<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Modules\ClientHub\Entities\Client;
use Tests\TestCase;

class ProviderDiscoveryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'cache.default' => 'array']);
        DB::purge('sqlite');
        $pdo = DB::connection()->getPdo();
        foreach (['radians' => fn ($v) => $v === null ? null : deg2rad($v),
            'cos' => fn ($v) => $v === null ? null : cos($v), 'sin' => fn ($v) => $v === null ? null : sin($v),
            'acos' => fn ($v) => $v === null ? null : acos($v),
            'least' => fn (...$v) => in_array(null, $v, true) ? null : min($v),
            'greatest' => fn (...$v) => in_array(null, $v, true) ? null : max($v)] as $name => $function) {
            $pdo->sqliteCreateFunction($name, $function);
        }
        foreach ([
            'users' => ['name', 'status', 'application_status', 'vender_id', 'email', 'password'],
            'clients' => ['name'],
            'vendor_profiles' => ['vender_id', 'company_name', 'bank_account_no', 'document_proof'],
            'trading_names' => ['name'],
            'trading_units' => ['vender_id', 'name', 'status', 'site_id', 'trading_name_id', 'trading_template', 'operation_type', 'lat', 'long', 'city', 'postcode', 'radius'],
            'vender_addresses' => ['address_line_1', 'address_line_2', 'address_line_3', 'address_line_4', 'city', 'postcode', 'lat', 'long', 'proof'],
            'trading_unit_job_types' => ['trading_id', 'job_type_id'],
            'job_types' => ['name'],
            'quick_products' => ['trading_id', 'product_name', 'job_type_id', 'description', 'price', 'price_type'],
            'trading_unit_hub_profiles' => ['trading_id', 'website'],
            'trading_unit_payment_methods' => ['trading_id', 'payment_method_id'],
            'payment_methods' => ['name'],
            'trading_unit_warrenty_jobs' => ['trading_id', 'warranty_job_id'],
            'warranty_jobs' => ['name'],
            'trading_unit_vehicle_specialists' => ['trading_id', 'vehicle_specialist_id'],
            'vehicle_specialists' => ['name'],
            'trading_unit_accreditation_schemes' => ['trading_id', 'accreditation_id'],
            'accreditation_schemes' => ['name'],
            'link_venders' => ['vender_id', 'hub_id'],
        ] as $name => $columns) {
            Schema::create($name, function (Blueprint $table) use ($columns) {
                $table->id(); foreach ($columns as $column) $table->string($column)->nullable();
                $table->timestamps();
            });
        }
        Schema::table('clients', fn (Blueprint $table) => $table->softDeletes());
        $this->provider(1, 'Real Garage', 51.5, -0.12);
        DB::table('vender_addresses')->insert(['id' => 1, 'address_line_1' => '10 Real Street', 'city' => 'London', 'postcode' => 'E1 1AA', 'proof' => 'private.pdf']);
        DB::table('trading_units')->where('id', 1)->update(['site_id' => 1]);
        DB::table('job_types')->insert(['id' => 1, 'name' => 'MOT']);
        DB::table('trading_unit_job_types')->insert(['trading_id' => 1, 'job_type_id' => 1]);
    }

    private function provider(int $id, string $name, ?float $lat = null, ?float $lng = null, string $status = 'ACTIVE'): void
    {
        DB::table('users')->insert(['id' => $id, 'name' => $name, 'status' => $status, 'vender_id' => 0, 'email' => 'private@example.com', 'password' => 'secret']);
        DB::table('vendor_profiles')->insert(['vender_id' => $id, 'company_name' => $name, 'bank_account_no' => 'private']);
        DB::table('trading_units')->insert(['id' => $id, 'vender_id' => $id, 'name' => $name, 'status' => $status, 'operation_type' => 'On-site', 'lat' => $lat, 'long' => $lng]);
    }

    public function test_guests_receive_real_public_fields_without_account_or_document_data(): void
    {
        $this->provider(2, 'Pending Garage', null, null, 'PENDING');
        $response = $this->postJson('/api/client/providers/search', ['lat' => 51.5, 'lng' => -0.12]);
        $response->assertOk()->assertJsonCount(1, 'providers')->assertJsonPath('providers.0.name', 'Real Garage')
            ->assertJsonPath('providers.0.id', '1')->assertJsonPath('providers.0.services', 'MOT')
            ->assertJsonPath('providers.0.address', '10 Real Street, London E1 1AA')
            ->assertJsonPath('providers.0.distanceOrCoverage', '0.0 miles away')
            ->assertJsonPath('providers.0.isLinked', false)->assertJsonPath('providers.0.ratings', []);
        $this->assertStringNotContainsString('private', $response->getContent());
        $this->assertStringNotContainsString('secret', $response->getContent());
    }

    public function test_search_and_filters_apply_before_pagination_and_include_product_names(): void
    {
        $this->provider(2, 'Mobile Garage');
        DB::table('trading_units')->where('id', 2)->update(['operation_type' => 'Mobile', 'radius' => 15, 'city' => 'London']);
        DB::table('quick_products')->insert(['trading_id' => 2, 'product_name' => 'Battery replacement']);
        foreach ([['search' => 'Battery'], ['categories' => ['Mobile']], ['providerNames' => ['Mobile Garage']]] as $filter) {
            $this->postJson('/api/client/providers/search', $filter)->assertOk()->assertJsonCount(1, 'providers')->assertJsonPath('providers.0.id', '2');
        }
        $this->postJson('/api/client/providers/search', ['categories' => ['MOT']])->assertJsonCount(1, 'providers')->assertJsonPath('providers.0.id', '1');
        $this->postJson('/api/client/providers/search', ['jobTerms' => ['unknown']])->assertJsonCount(0, 'providers');
    }

    public function test_distance_ordering_missing_coordinates_and_pagination_are_real(): void
    {
        for ($id = 2; $id <= 23; $id++) $this->provider($id, "Garage $id", $id === 23 ? null : 52.0, $id === 23 ? null : -0.12);
        $this->postJson('/api/client/providers/search', ['lat' => 51.5, 'lng' => -0.12])
            ->assertJsonCount(20, 'providers')->assertJsonPath('providers.0.id', '1')->assertJsonPath('nextPage', 2);
        $this->postJson('/api/client/providers/search', ['lat' => 51.5, 'lng' => -0.12, 'page' => 2])
            ->assertJsonCount(3, 'providers')->assertJsonPath('providers.2.distanceOrCoverage', 'Distance unavailable')->assertJsonPath('nextPage', null);
    }

    public function test_linked_status_is_scoped_to_the_signed_in_client(): void
    {
        $client = Client::create(['name' => 'Viewer']);
        DB::table('link_venders')->insert(['vender_id' => 1, 'hub_id' => $client->id]);
        Sanctum::actingAs($client);
        $this->postJson('/api/client/providers/search')->assertOk()->assertJsonPath('providers.0.isLinked', true);
        Sanctum::actingAs(Client::create(['name' => 'Other']));
        $this->postJson('/api/client/providers/search')->assertOk()->assertJsonPath('providers.0.isLinked', false);
    }

    public function test_invalid_coordinates_and_unbounded_filter_input_are_rejected(): void
    {
        foreach ([['lat' => 99, 'lng' => 0], ['lat' => 1], ['page' => 0], ['categories' => array_fill(0, 31, 'MOT')]] as $input) {
            $this->postJson('/api/client/providers/search', $input)->assertUnprocessable();
        }
    }

    public function test_live_details_are_public_and_cannot_fall_back_to_a_different_or_pending_provider(): void
    {
        $this->getJson('/api/client/providers/1')->assertOk()->assertJsonPath('profile.id', '1')
            ->assertJsonPath('profile.name', 'Real Garage')->assertJsonPath('profile.location.address', '10 Real Street, London E1 1AA')
            ->assertJsonPath('profile.serviceCategories.0.title', 'MOT')->assertJsonCount(0, 'profile.products')
            ->assertJsonPath('profile.openingHours.schedule', [])->assertJsonMissingPath('profile.vender')
            ->assertJsonMissingPath('profile.bank_account_no');
        $this->provider(2, 'Pending', null, null, 'PENDING');
        $this->getJson('/api/client/providers/2')->assertNotFound();
        $this->getJson('/api/client/providers/999')->assertNotFound();
    }
}
