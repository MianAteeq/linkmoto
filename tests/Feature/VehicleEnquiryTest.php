<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Services\DvlaVehicleEnquiryService;
use Modules\ClientHub\Services\DvsaMotHistoryService;
use Modules\Vender\Entities\Vehicle;
use Tests\TestCase;

class VehicleEnquiryTest extends TestCase
{
    private string $url = 'https://uat.driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles';

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:',
            'cache.default' => 'array', 'services.dvla.api_key' => 'test-only-key', 'services.dvla.url' => $this->url]);
        DB::purge('sqlite');
        Cache::flush();
        Http::preventStrayRequests();
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); $table->softDeletes(); $table->timestamps();
        });
        (require base_path('Modules/Vender/Database/Migrations/2022_09_19_091551_create_vehicles_table.php'))->up();
        Schema::table('vehicles', function (Blueprint $table) { $table->string('type')->nullable(); });
    }

    private function record(array $overrides = []): array
    {
        return array_replace(['registrationNumber' => 'AB12CDE', 'motStatus' => 'Valid',
            'motExpiry' => '2027-11-16', 'taxStatus' => 'Taxed', 'taxDueDate' => '2027-02-01'], $overrides);
    }

    private function service(): DvlaVehicleEnquiryService
    {
        return app(DvlaVehicleEnquiryService::class);
    }

    public function test_normalizes_vrm_posts_json_with_key_and_maps_official_fields(): void
    {
        Http::fake([$this->url => Http::response($this->record())]);
        $result = $this->service()->lookupChecks(' ab 12 cde ');
        $this->assertTrue($result['status']);
        $this->assertSame('16 Nov 2027', $result['checks']['motExpiryDate']);
        $this->assertSame('01 Feb 2027', $result['checks']['taxExpiryDate']);
        $this->assertSame('dvla', $result['checks']['source']);
        Http::assertSent(fn ($request) => $request->url() === $this->url && $request->method() === 'POST'
            && $request->hasHeader('x-api-key', 'test-only-key')
            && $request->hasHeader('Content-Type', 'application/json')
            && $request->data() === ['registrationNumber' => 'AB12CDE']);
    }

    public function test_preserves_sorn_and_non_valid_mot_without_inventing_dates(): void
    {
        Http::fake([$this->url => Http::response($this->record([
            'motStatus' => 'Not valid', 'taxStatus' => 'SORN', 'motExpiry' => null, 'taxDueDate' => null]))]);
        $checks = $this->service()->lookupChecks('AB12CDE')['checks'];
        $this->assertSame('Not valid', $checks['motStatus']);
        $this->assertSame('SORN', $checks['taxStatus']);
        $this->assertNull($checks['motExpiryDate']);
        $this->assertNull($checks['taxExpiryDate']);
    }

    public function test_missing_or_invalid_dates_are_not_generated(): void
    {
        Http::fake([$this->url => Http::response(['registrationNumber' => 'AB12CDE',
            'motStatus' => 'No details held by DVLA', 'motExpiry' => '2027-02-30'])]);
        $checks = $this->service()->lookupChecks('AB12CDE')['checks'];
        $this->assertSame('Unavailable', $checks['taxStatus']);
        $this->assertNull($checks['motExpiryDate']);
        $this->assertNull($checks['taxExpiryDate']);
    }

    public function test_maps_uat_mot_expiry_date_alias(): void
    {
        $record = $this->record();
        unset($record['motExpiry']);
        $record['motExpiryDate'] = '2027-11-16';
        Http::fake([$this->url => Http::response($record)]);
        $this->assertSame('16 Nov 2027', $this->service()->lookupChecks('AB12CDE')['checks']['motExpiryDate']);
    }

    public function test_missing_key_and_invalid_registration_do_not_call_dvla(): void
    {
        config(['services.dvla.api_key' => null]);
        $this->assertSame(503, $this->service()->lookupChecks('AB12CDE')['httpStatus']);
        $this->assertSame(422, $this->service()->lookupChecks('../BAD')['httpStatus']);
        Http::assertNothingSent();
    }

    public function test_upstream_errors_do_not_return_fabricated_success(): void
    {
        $status = 400;
        Http::fake(function () use (&$status) { return Http::response(['errors' => []], $status); });
        foreach ([400, 401, 403, 404, 429, 500, 503] as $status) {
            $result = $this->service()->lookupChecks('AB12CDE', true);
            $this->assertFalse($result['status']);
            $this->assertArrayNotHasKey('checks', $result);
            $this->assertSame($status === 404 ? 404 : 503, $result['httpStatus']);
        }
    }

    public function test_timeout_is_reported_without_fake_checks(): void
    {
        Http::fake(fn () => throw new ConnectionException('timeout'));
        $this->assertFalse($this->service()->lookupChecks('AB12CDE')['status']);
        $this->assertSame('Unavailable', $this->service()->cachedChecks('AB12CDE')['taxStatus']);
    }

    public function test_malformed_or_wrong_vehicle_responses_are_rejected(): void
    {
        $record = [];
        Http::fake(function () use (&$record) { return Http::response($record); });
        foreach ([[], ['registrationNumber' => 'AB12CDE'], $this->record(['registrationNumber' => 'XX12XXX']),
            $this->record(['motStatus' => ['Valid']])] as $record) {
            $this->assertSame(502, $this->service()->lookupChecks('AB12CDE', true)['httpStatus']);
        }
    }

    public function test_cache_is_reused_but_force_refresh_fetches_new_official_data(): void
    {
        Http::fake([$this->url => Http::sequence()->push($this->record())->push($this->record(['taxStatus' => 'Untaxed']))]);
        $this->service()->lookupChecks('AB12CDE');
        $this->assertSame('Taxed', $this->service()->lookupChecks('ab12 cde')['checks']['taxStatus']);
        $this->assertSame('Untaxed', $this->service()->lookupChecks('AB12CDE', true)['checks']['taxStatus']);
        Http::assertSentCount(2);
    }

    public function test_failed_refresh_keeps_last_successful_data_and_legacy_generated_cache_is_ignored(): void
    {
        Cache::put('vehicle_checks_AB12CDE', ['taxStatus' => 'Taxed']);
        $this->assertSame('Unavailable', $this->service()->cachedChecks('AB12CDE')['taxStatus']);
        Http::fake([$this->url => Http::sequence()->push($this->record())->push([], 503)]);
        $initial = $this->service()->lookupChecks('AB12CDE')['checks'];
        $this->assertFalse($this->service()->lookupChecks('AB12CDE', true)['status']);
        $this->assertSame($initial, $this->service()->cachedChecks('AB12CDE'));
        $this->assertSame('Unavailable', $this->service()->cachedChecks('OTHER12')['taxStatus']);
    }

    public function test_uat_checks_are_not_reused_when_switching_to_live(): void
    {
        Http::fake([$this->url => Http::response($this->record())]);
        $this->service()->lookupChecks('AB12CDE');
        config(['services.dvla.url' => 'https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles']);
        $this->assertSame('Unavailable', $this->service()->cachedChecks('AB12CDE')['taxStatus']);
    }

    public function test_cached_official_checks_survive_vehicle_save_and_ignore_submitted_fake_checks(): void
    {
        Schema::table('vehicles', function (Blueprint $table) { $table->string('vehicle_no')->nullable(); });
        (require database_path('migrations/2026_11_16_000001_add_default_vehicle_id_to_clients_table.php'))->up();
        (require database_path('migrations/2026_11_16_000002_create_vehicle_documents_table.php'))->up();
        foreach (['car_makers', 'car_models', 'engine_sizes', 'transmission_types', 'fuel_types', 'vehicle_colors'] as $name) {
            Schema::create($name, function (Blueprint $table) { $table->id(); });
        }
        Sanctum::actingAs(Client::create([]));
        Http::fake([$this->url => Http::response($this->record(['taxStatus' => 'Untaxed']))]);
        $this->service()->lookupChecks('AB12CDE');
        $saved = $this->postJson('/api/client/vehicles/add', [
            'vrm' => 'AB12CDE', 'checks' => ['taxStatus' => 'Taxed', 'source' => 'dvla'],
        ])->assertOk()->assertJsonPath('vehicle.checks.taxStatus', 'Untaxed');
        $id = $saved->json('vehicle.id');
        $this->getJson("/api/client/vehicles/{$id}")->assertOk()
            ->assertJsonPath('vehicle.checks.source', 'dvla')->assertJsonPath('vehicle.checks.taxStatus', 'Untaxed');
        $this->postJson('/api/client/vehicles/update', ['id' => $id, 'vrm' => 'XX12XXX'])->assertOk()
            ->assertJsonPath('vehicle.checks.taxStatus', 'Unavailable');
    }

    public function test_lookup_combines_dvsa_identity_with_dvla_checks(): void
    {
        $this->mock(DvsaMotHistoryService::class)->shouldReceive('lookupVehicle')->with('ab12 cde')->once()
            ->andReturn(['status' => true, 'found' => true, 'source' => 'dvsa',
                'vehicle' => ['make' => 'Ford', 'model' => 'Focus', 'checks' => ['taxStatus' => 'Taxed']]]);
        Http::fake([$this->url => Http::response($this->record(['taxStatus' => 'Untaxed']))]);
        $this->getJson('/api/client/vehicle/lookup?vrm=ab12%20cde')->assertOk()
            ->assertJsonPath('vehicle.make', 'Ford')->assertJsonPath('vehicle.model', 'Focus')
            ->assertJsonPath('registrationNumber', 'AB12CDE')->assertJsonPath('vehicle.checks.taxStatus', 'Untaxed');
    }

    public function test_dvla_outage_does_not_prevent_vehicle_identity_lookup(): void
    {
        $this->mock(DvsaMotHistoryService::class)->shouldReceive('lookupVehicle')->andReturn([
            'status' => true, 'found' => true, 'vehicle' => ['make' => 'Ford', 'model' => 'Focus']]);
        Http::fake([$this->url => Http::response([], 503)]);
        $this->getJson('/api/client/vehicle/lookup?vrm=AB12CDE')->assertOk()
            ->assertJsonPath('found', true)->assertJsonPath('vehicle.checks.motStatus', 'Unavailable');
    }

    public function test_dvsa_failure_does_not_generate_catalog_vehicles(): void
    {
        config(['services.dvsa.client_id' => null, 'services.dvsa.client_secret' => null,
            'services.dvsa.token_url' => null]);
        $this->getJson('/api/client/vehicle/lookup?vrm=AB12CDE')->assertOk()
            ->assertJsonPath('found', false)->assertJsonMissingPath('vehicle');
        Http::assertNothingSent();
    }

    public function test_refresh_requires_auth_and_ownership_and_uses_only_dvla(): void
    {
        $client = Client::create([]);
        $vehicle = Vehicle::create(['vender_id' => $client->id, 'type' => 'Client', 'vrm' => 'AB12CDE']);
        $path = "/api/client/vehicles/{$vehicle->id}/refresh-checks";
        $this->postJson($path)->assertUnauthorized();
        Sanctum::actingAs(Client::create([]));
        $this->postJson($path)->assertNotFound();
        Http::assertNothingSent();
        Sanctum::actingAs($client);
        $this->mock(DvsaMotHistoryService::class)->shouldNotReceive('lookupVehicle');
        Http::fake([$this->url => Http::response($this->record())]);
        $this->postJson($path)->assertOk()->assertJsonPath('status', true)->assertJsonPath('checks.source', 'dvla');
    }

    public function test_refresh_failure_returns_retryable_error(): void
    {
        $client = Client::create([]);
        $vehicle = Vehicle::create(['vender_id' => $client->id, 'type' => 'Client', 'vrm' => 'AB12CDE']);
        Sanctum::actingAs($client);
        Http::fake([$this->url => Http::response([], 429)]);
        $this->postJson("/api/client/vehicles/{$vehicle->id}/refresh-checks")->assertStatus(503)
            ->assertJsonPath('status', false)->assertJsonMissingPath('checks');
    }
}
