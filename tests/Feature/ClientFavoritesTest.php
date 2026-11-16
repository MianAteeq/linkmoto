<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Modules\ClientHub\Entities\Client;
use Tests\TestCase;

class ClientFavoritesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true, 'cache.default' => 'array']);
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
            'clients' => ['name'], 'vendor_profiles' => ['vender_id', 'company_name', 'bank_account_no'],
            'trading_names' => ['name'],
            'trading_units' => ['vender_id', 'name', 'status', 'site_id', 'trading_name_id', 'trading_template', 'operation_type', 'lat', 'long', 'city', 'postcode'],
            'vender_addresses' => ['address_line_1', 'address_line_2', 'address_line_3', 'address_line_4', 'city', 'postcode', 'lat', 'long'],
            'trading_unit_job_types' => ['trading_id', 'job_type_id'], 'job_types' => ['name'],
            'quick_products' => ['trading_id', 'product_name'], 'link_venders' => ['vender_id', 'hub_id'],
        ] as $name => $columns) {
            Schema::create($name, function (Blueprint $table) use ($columns) {
                $table->id();
                foreach ($columns as $column) $table->string($column)->nullable();
                $table->timestamps();
            });
        }
        Schema::table('clients', fn (Blueprint $table) => $table->softDeletes());
        (require database_path('migrations/2026_11_16_000004_create_client_favorites_table.php'))->up();
        $this->provider(1);
    }

    private function provider(int $id, string $status = 'ACTIVE'): void
    {
        DB::table('users')->insert(['id' => $id, 'name' => "Garage $id", 'status' => $status, 'vender_id' => 0]);
        DB::table('vendor_profiles')->insert(['vender_id' => $id, 'company_name' => "Garage $id", 'bank_account_no' => 'private']);
        DB::table('trading_units')->insert(['id' => $id, 'vender_id' => $id, 'name' => "Garage $id", 'status' => $status,
            'operation_type' => 'On-site', 'lat' => '51.5', 'long' => '-0.12']);
    }

    public function test_all_favorite_endpoints_require_login(): void
    {
        $this->getJson('/api/client/favorites')->assertUnauthorized();
        $this->postJson('/api/client/favorites', ['providerId' => '1'])->assertUnauthorized();
        $this->deleteJson('/api/client/favorites/1')->assertUnauthorized();
        $this->getJson('/api/client/favorites/1/status')->assertUnauthorized();
    }

    public function test_saves_are_persistent_idempotent_and_return_real_public_cards(): void
    {
        $client = Client::create(['name' => 'Owner']);
        Sanctum::actingAs($client);
        $this->getJson('/api/client/favorites')->assertOk()->assertJsonCount(0, 'favorites');
        foreach ([1, 2] as $_) {
            $this->postJson('/api/client/favorites', ['providerId' => '1'])->assertOk()
                ->assertJsonPath('success', true)->assertJsonPath('isFavorite', true)->assertJsonPath('providerId', '1');
        }
        Cache::flush();
        $this->assertSame(1, DB::table('client_favorites')->where('client_id', $client->id)->count());
        $this->getJson('/api/client/favorites/1/status')->assertOk()->assertJsonPath('isFavorite', true);
        $response = $this->getJson('/api/client/favorites?lat=51.5&lng=-0.12');
        $response->assertOk()->assertJsonCount(1, 'favorites')->assertJsonPath('favorites.0.id', '1')
            ->assertJsonPath('favorites.0.name', 'Garage 1')->assertJsonPath('favorites.0.isFavorite', true)
            ->assertJsonPath('favorites.0.distanceOrCoverage', '0.0 miles away');
        $this->assertStringNotContainsString('private', $response->getContent());
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_accounts_cannot_read_or_remove_each_others_saved_providers(): void
    {
        $first = Client::create([]);
        $second = Client::create([]);
        Sanctum::actingAs($first);
        $this->postJson('/api/client/favorites', ['providerId' => '1'])->assertOk();
        Sanctum::actingAs($second);
        $this->getJson('/api/client/favorites')->assertJsonCount(0, 'favorites');
        $this->getJson('/api/client/favorites/1/status')->assertJsonPath('isFavorite', false);
        $this->deleteJson('/api/client/favorites/1')->assertOk();
        Sanctum::actingAs($first);
        $this->getJson('/api/client/favorites')->assertJsonCount(1, 'favorites');
    }

    public function test_vendor_tokens_are_rejected_even_with_the_same_numeric_id(): void
    {
        Client::create(['id' => 1]);
        Sanctum::actingAs(User::find(1));
        $this->getJson('/api/client/favorites')->assertForbidden();
        $this->postJson('/api/client/favorites', ['providerId' => '1'])->assertForbidden();
        $this->deleteJson('/api/client/favorites/1')->assertForbidden();
        $this->getJson('/api/client/favorites/1/status')->assertForbidden();
    }

    public function test_only_existing_approved_providers_can_be_saved(): void
    {
        $this->provider(2, 'PENDING');
        Sanctum::actingAs(Client::create([]));
        foreach ([2, 99999] as $id) $this->postJson('/api/client/favorites', ['providerId' => $id])->assertNotFound();
        foreach ([[], ['providerId' => 'prov-1'], ['providerId' => 0]] as $input) $this->postJson('/api/client/favorites', $input)->assertUnprocessable();
        $this->assertSame(0, DB::table('client_favorites')->count());
    }

    public function test_removing_the_last_favorite_persists_and_is_idempotent(): void
    {
        Sanctum::actingAs(Client::create([]));
        $this->postJson('/api/client/favorites', ['providerId' => 1])->assertOk();
        foreach ([1, 2] as $_) $this->deleteJson('/api/client/favorites/1')->assertOk()->assertJsonPath('isFavorite', false);
        $this->getJson('/api/client/favorites')->assertJsonCount(0, 'favorites');
        $this->getJson('/api/client/favorites/1/status')->assertJsonPath('isFavorite', false);
    }

    public function test_unapproved_providers_are_hidden_and_still_removable(): void
    {
        Sanctum::actingAs(Client::create([]));
        $this->postJson('/api/client/favorites', ['providerId' => 1])->assertOk();
        DB::table('trading_units')->where('id', 1)->update(['status' => 'PENDING']);
        $this->getJson('/api/client/favorites')->assertJsonCount(0, 'favorites');
        $this->deleteJson('/api/client/favorites/1')->assertOk();
        $this->assertSame(0, DB::table('client_favorites')->count());
    }

    public function test_mobile_favorites_remain_saved_when_location_changes_without_claiming_coverage(): void
    {
        DB::table('trading_units')->where('id', 1)->update(['operation_type' => 'Mobile', 'postcode' => 'E2 9HD']);
        Sanctum::actingAs(Client::create([]));
        $this->postJson('/api/client/favorites', ['providerId' => 1])->assertOk();
        $this->getJson('/api/client/favorites?postcode=e29hd')->assertJsonPath('favorites.0.distanceOrCoverage', 'Serves your area');
        $this->getJson('/api/client/favorites?postcode=N15PA')->assertJsonCount(1, 'favorites')
            ->assertJsonPath('favorites.0.distanceOrCoverage', 'Mobile service');
    }

    public function test_listing_is_latest_saved_first_and_keeps_linked_status_scoped(): void
    {
        $this->provider(2);
        $client = Client::create([]);
        DB::table('link_venders')->insert(['hub_id' => $client->id, 'vender_id' => 2]);
        Sanctum::actingAs($client);
        foreach ([1, 2] as $id) $this->postJson('/api/client/favorites', ['providerId' => $id])->assertOk();
        $this->getJson('/api/client/favorites')->assertJsonPath('favorites.0.id', '2')->assertJsonPath('favorites.0.isLinked', true)
            ->assertJsonPath('favorites.1.id', '1')->assertJsonPath('favorites.1.isLinked', false);
    }
}
