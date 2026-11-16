<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Modules\ClientHub\Entities\Client;
use Tests\TestCase;

class ClientLocationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'cache.default' => 'array']);
        DB::purge('sqlite');
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('location')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        (require database_path('migrations/2026_11_16_000003_add_postcode_to_clients_table.php'))->up();
    }

    public function test_location_requires_authentication(): void
    {
        $this->postJson('/api/client/update/lat/long', ['lat' => 51.53, 'lng' => -0.06, 'postcode' => 'E2 9HD'])->assertUnauthorized();
    }

    public function test_saves_postcode_for_authenticated_client_only(): void
    {
        $client = Client::create([]);
        $other = Client::create(['postcode' => 'SW1A1AA']);
        Sanctum::actingAs($client);
        $this->postJson('/api/client/update/lat/long', [
            'lat' => 51.53, 'lng' => -0.06, 'location' => 'Clare Street, London', 'postcode' => ' e2 9hd ',
        ])->assertOk()->assertJsonPath('location.postcode', 'E29HD')->assertJsonPath('user.postcode', 'E29HD');
        $this->assertSame('E29HD', $client->fresh()->postcode);
        $this->assertSame('SW1A1AA', $other->fresh()->postcode);
    }

    public function test_missing_postcode_clears_previous_location_postcode(): void
    {
        $client = Client::create(['postcode' => 'E29HD']);
        Sanctum::actingAs($client);
        $this->postJson('/api/client/update/lat/long', [
            'lat' => 52, 'lng' => 1, 'location' => 'Current location', 'postcode' => '',
        ])->assertOk()->assertJsonPath('location.postcode', null);
        $this->assertNull($client->fresh()->postcode);
    }

    public function test_legacy_clients_can_supply_postcode_in_address_text(): void
    {
        Sanctum::actingAs(Client::create([]));
        $this->postJson('/api/client/update/lat/long', [
            'lat' => 51.53, 'long' => -0.06, 'location' => 'Clare Street', 'cityAndPostcode' => 'London E2 9HD',
        ])->assertOk()->assertJsonPath('location.postcode', 'E29HD');
    }

    public function test_invalid_postcode_does_not_modify_location(): void
    {
        $client = Client::create(['postcode' => 'E29HD', 'lat' => '51.53']);
        Sanctum::actingAs($client);
        foreach ([['invalid'], str_repeat('A', 17)] as $postcode) {
            $this->postJson('/api/client/update/lat/long', ['lat' => 52, 'lng' => 1, 'postcode' => $postcode])->assertStatus(422);
        }
        $this->assertSame('E29HD', $client->fresh()->postcode);
        $this->assertSame('51.53', $client->fresh()->lat);
    }
}
