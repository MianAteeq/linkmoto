<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Services\DvsaMotHistoryService;
use Modules\Vender\Entities\Vehicle;
use Tests\TestCase;

class DefaultVehicleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // These API tests always use an isolated database, regardless of local .env.
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true,
            'cache.default' => 'array',
        ]);
        DB::purge('sqlite');

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        (require base_path('Modules/Vender/Database/Migrations/2022_09_19_091551_create_vehicles_table.php'))->up();
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('vehicle_no')->nullable();
        });
        $this->defaultMigration()->up();
        (require database_path('migrations/2026_11_16_000002_create_vehicle_documents_table.php'))->up();
        foreach (['car_makers', 'car_models', 'engine_sizes', 'transmission_types', 'fuel_types', 'vehicle_colors'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
            });
        }

        $this->mock(DvsaMotHistoryService::class, function (MockInterface $mock) {
            $mock->shouldReceive('computeDynamicChecksForVrm')->andReturn([
                'motStatus' => 'Valid', 'taxStatus' => 'Taxed',
            ]);
        });
    }

    private function defaultMigration(): \Illuminate\Database\Migrations\Migration
    {
        return require database_path('migrations/2026_11_16_000001_add_default_vehicle_id_to_clients_table.php');
    }

    private function vehicle(Client $client, ?string $type = 'Client'): Vehicle
    {
        return Vehicle::create([
            'vender_id' => $client->id, 'type' => $type, 'vrm' => 'TEST123',
        ]);
    }

    public function test_default_requires_authentication(): void
    {
        $this->postJson('/api/client/vehicles/1/set-default')->assertUnauthorized();
    }

    public function test_default_persists_after_cache_clear_and_is_consistent_across_reads(): void
    {
        $client = Client::create(['name' => 'Vehicle owner']);
        $first = $this->vehicle($client);
        $second = $this->vehicle($client);
        Cache::forever("client_{$client->id}_default_vehicle", $first->id);
        Sanctum::actingAs($client);

        foreach ([$first, $second, $second] as $vehicle) {
            $this->postJson("/api/client/vehicles/{$vehicle->id}/set-default")
                ->assertOk()->assertJsonPath('status', true)
                ->assertJsonPath('defaultVehicleId', (string) $vehicle->id)
                ->assertJsonPath('vehicle.isDefault', true);
        }

        Cache::flush();
        $this->assertEquals($second->id, $client->fresh()->default_vehicle_id);
        $response = $this->getJson('/api/client/vehicles');
        $this->assertSame(200, $response->status(), $response->getContent());
        $vehicles = $response->json('vehicles');
        $this->assertCount(1, array_filter($vehicles, fn ($v) => $v['isDefault']));
        $this->assertSame((string) $second->id, collect($vehicles)->firstWhere('isDefault', true)['id']);
        $this->getJson("/api/client/vehicles/{$first->id}")->assertOk()->assertJsonPath('vehicle.isDefault', false);
        $this->getJson("/api/client/vehicles/{$second->id}")->assertOk()->assertJsonPath('vehicle.isDefault', true);
    }

    public function test_other_accounts_and_vendor_vehicles_cannot_be_selected(): void
    {
        $client = Client::create([]);
        $own = $this->vehicle($client);
        $otherClient = Client::create([]);
        $other = $this->vehicle($otherClient);
        $vendorVehicle = $this->vehicle($client, 'Vender');
        Sanctum::actingAs($client);
        $this->postJson("/api/client/vehicles/{$own->id}/set-default")->assertOk();

        foreach ([$other->id, $vendorVehicle->id, 999999] as $id) {
            $this->postJson("/api/client/vehicles/{$id}/set-default")
                ->assertNotFound()->assertJsonPath('status', false);
        }
        $this->assertEquals($own->id, $client->fresh()->default_vehicle_id);
        $this->assertNull($otherClient->fresh()->default_vehicle_id);
    }

    public function test_vendor_token_with_same_numeric_id_is_rejected(): void
    {
        $client = Client::create([]);
        $vehicle = $this->vehicle($client);
        $vendor = new User();
        $vendor->id = $client->id;
        Sanctum::actingAs($vendor);

        $this->postJson("/api/client/vehicles/{$vehicle->id}/set-default")->assertForbidden();
        $this->getJson('/api/client/vehicles')->assertForbidden();
        $this->getJson("/api/client/vehicles/{$vehicle->id}")->assertForbidden();
        $this->postJson('/api/client/vehicles/delete', ['vehicle_id' => $vehicle->id])->assertForbidden();
        $this->assertNull($client->fresh()->default_vehicle_id);
    }

    public function test_invalid_vehicle_id_is_rejected(): void
    {
        Sanctum::actingAs(Client::create([]));
        $this->postJson('/api/client/vehicles/invalid/set-default')
            ->assertUnprocessable()->assertJsonPath('status', false);
    }

    public function test_search_does_not_mark_a_non_default_result_as_default(): void
    {
        $client = Client::create([]);
        $default = $this->vehicle($client);
        $other = $this->vehicle($client);
        $other->update(['vrm' => 'OTHER123']);
        Sanctum::actingAs($client);
        $this->postJson("/api/client/vehicles/{$default->id}/set-default")->assertOk();

        $this->postJson('/api/client/vehicle/detail/search', ['search' => 'OTHER123'])
            ->assertOk()->assertJsonCount(1, 'vehicles')
            ->assertJsonPath('vehicles.0.isDefault', false);
    }

    public function test_existing_cached_preference_is_preserved_in_database(): void
    {
        $client = Client::create([]);
        $first = $this->vehicle($client, null);
        $this->vehicle($client);
        Cache::forever("client_{$client->id}_default_vehicle", $first->id);
        Sanctum::actingAs($client);

        $this->getJson('/api/client/vehicles')->assertOk();
        $this->assertEquals($first->id, $client->fresh()->default_vehicle_id);
        Cache::flush();
        $this->getJson("/api/client/vehicles/{$first->id}")
            ->assertOk()->assertJsonPath('vehicle.isDefault', true);
    }

    public function test_deleting_default_promotes_remaining_vehicle(): void
    {
        $client = Client::create([]);
        $first = $this->vehicle($client);
        $second = $this->vehicle($client);
        Sanctum::actingAs($client);
        $this->postJson("/api/client/vehicles/{$first->id}/set-default")->assertOk();
        $this->postJson('/api/client/vehicles/delete', ['vehicle_id' => $first->id])->assertOk();

        $this->getJson('/api/client/vehicles')->assertOk()->assertJsonCount(1, 'vehicles')
            ->assertJsonPath('vehicles.0.isDefault', true);
        $this->assertEquals($second->id, $client->fresh()->default_vehicle_id);
        $second->delete();
        $this->getJson('/api/client/vehicles')->assertOk()->assertJsonCount(0, 'vehicles');
        $this->assertNull($client->fresh()->default_vehicle_id);
    }

}
