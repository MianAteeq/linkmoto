<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Entities\ClientNotification;
use Tests\TestCase;

class ClientNotificationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true,
        ]);
        DB::purge('sqlite');

        // Create base tables for SQLite memory testing
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        (require database_path('migrations/2026_11_17_000001_create_client_notifications_table.php'))->up();
    }

    public function test_all_notification_endpoints_require_login(): void
    {
        $this->getJson('/api/client/notifications')->assertUnauthorized();
        $this->getJson('/api/notifications')->assertUnauthorized();
        $this->getJson('/api/client/notifications/unread-count')->assertUnauthorized();
        $this->getJson('/api/notifications/unread-count')->assertUnauthorized();
        $this->patchJson('/api/client/notifications/1/read')->assertUnauthorized();
        $this->patchJson('/api/client/notifications/1/unread')->assertUnauthorized();
        $this->postJson('/api/client/notifications/mark-all-read')->assertUnauthorized();
        $this->deleteJson('/api/client/notifications/1')->assertUnauthorized();
    }

    public function test_vendor_tokens_are_forbidden(): void
    {
        $vendor = User::create(['name' => 'Garage Owner']);
        Sanctum::actingAs($vendor);

        $this->getJson('/api/client/notifications')->assertForbidden();
        $this->getJson('/api/notifications')->assertForbidden();
        $this->getJson('/api/client/notifications/unread-count')->assertForbidden();
        $this->patchJson('/api/client/notifications/1/read')->assertForbidden();
        $this->patchJson('/api/client/notifications/1/unread')->assertForbidden();
        $this->postJson('/api/client/notifications/mark-all-read')->assertForbidden();
        $this->deleteJson('/api/client/notifications/1')->assertForbidden();
    }

    public function test_client_can_fetch_paginated_notifications_and_unread_count(): void
    {
        $client = Client::create(['name' => 'Alice']);
        Sanctum::actingAs($client);

        // Initially empty
        $response = $this->getJson('/api/client/notifications');
        $response->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('total', 0)
            ->assertJsonPath('unreadCount', 0)
            ->assertJsonPath('hasMore', false)
            ->assertJsonCount(0, 'items');

        // Create 5 notifications: 3 unread, 2 read
        for ($i = 1; $i <= 5; $i++) {
            ClientNotification::create([
                'client_id' => $client->id,
                'title' => "Notification $i",
                'message' => "Message body $i",
                'type' => 'booking_update',
                'status_word' => 'Booked',
                'status_color' => '#1E40AF',
                'provider_name' => 'H&H Motors',
                'tru_id' => 'TRU000176',
                'read_at' => $i > 3 ? now() : null,
                'created_at' => now()->subMinutes(10 * (6 - $i)),
            ]);
        }

        // Test unread count endpoint
        $this->getJson('/api/client/notifications/unread-count')
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('unreadCount', 3);

        // Fetch page 1 (limit 3)
        $p1 = $this->getJson('/api/client/notifications?page=1&limit=3');
        $p1->assertOk()
            ->assertJsonPath('page', 1)
            ->assertJsonPath('limit', 3)
            ->assertJsonPath('total', 5)
            ->assertJsonPath('hasMore', true)
            ->assertJsonPath('unreadCount', 3)
            ->assertJsonCount(3, 'items');

        // Fetch page 2 (limit 3)
        $p2 = $this->getJson('/api/client/notifications?page=2&limit=3');
        $p2->assertOk()
            ->assertJsonPath('page', 2)
            ->assertJsonPath('limit', 3)
            ->assertJsonPath('total', 5)
            ->assertJsonPath('hasMore', false)
            ->assertJsonPath('unreadCount', 3)
            ->assertJsonCount(2, 'items');

        // Verify items formatting matches TypeScript contract
        $item = $p1->json('items.0');
        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('title', $item);
        $this->assertArrayHasKey('message', $item);
        $this->assertArrayHasKey('type', $item);
        $this->assertArrayHasKey('createdAt', $item);
        $this->assertArrayHasKey('isRead', $item);
        $this->assertArrayHasKey('statusWord', $item);
        $this->assertArrayHasKey('statusColor', $item);
        $this->assertArrayHasKey('providerName', $item);
        $this->assertArrayHasKey('truId', $item);
    }

    public function test_client_can_filter_unread_notifications(): void
    {
        $client = Client::create(['name' => 'Bob']);
        Sanctum::actingAs($client);

        ClientNotification::create([
            'client_id' => $client->id,
            'title' => 'Read One',
            'message' => 'Body',
            'read_at' => now(),
        ]);
        ClientNotification::create([
            'client_id' => $client->id,
            'title' => 'Unread One',
            'message' => 'Body',
            'read_at' => null,
        ]);

        $res = $this->getJson('/api/client/notifications?filter=unread');
        $res->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('unreadCount', 1)
            ->assertJsonCount(1, 'items')
            ->assertJsonPath('items.0.title', 'Unread One')
            ->assertJsonPath('items.0.isRead', false);
    }

    public function test_client_can_mark_notification_as_read_and_unread(): void
    {
        $client = Client::create(['name' => 'Charlie']);
        Sanctum::actingAs($client);

        $notif = ClientNotification::create([
            'client_id' => $client->id,
            'title' => 'Action required',
            'message' => 'Please confirm booking',
            'read_at' => null,
        ]);

        // Mark as read
        $this->patchJson("/api/client/notifications/{$notif->id}/read")
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('success', true);

        $this->assertNotNull($notif->fresh()->read_at);
        $this->getJson('/api/client/notifications/unread-count')
            ->assertJsonPath('unreadCount', 0);

        // Mark as unread
        $this->patchJson("/api/client/notifications/{$notif->id}/unread")
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('success', true);

        $this->assertNull($notif->fresh()->read_at);
        $this->getJson('/api/client/notifications/unread-count')
            ->assertJsonPath('unreadCount', 1);
    }

    public function test_client_can_mark_all_notifications_as_read(): void
    {
        $client = Client::create(['name' => 'David']);
        Sanctum::actingAs($client);

        for ($i = 1; $i <= 3; $i++) {
            ClientNotification::create([
                'client_id' => $client->id,
                'title' => "Notification $i",
                'message' => "Message $i",
                'read_at' => null,
            ]);
        }

        $this->postJson('/api/client/notifications/mark-all-read')
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('success', true);

        $this->assertSame(0, ClientNotification::where('client_id', $client->id)->unread()->count());
        $this->getJson('/api/client/notifications/unread-count')
            ->assertJsonPath('unreadCount', 0);
    }

    public function test_client_can_delete_notification(): void
    {
        $client = Client::create(['name' => 'Eve']);
        Sanctum::actingAs($client);

        $notif = ClientNotification::create([
            'client_id' => $client->id,
            'title' => 'To be deleted',
            'message' => 'Message',
            'read_at' => null,
        ]);

        $this->deleteJson("/api/client/notifications/{$notif->id}")
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('success', true);

        // Soft deleted
        $this->assertSoftDeleted('client_notifications', ['id' => $notif->id]);

        $this->getJson('/api/client/notifications')
            ->assertJsonPath('total', 0)
            ->assertJsonCount(0, 'items');
    }

    public function test_clients_cannot_access_or_modify_each_others_notifications(): void
    {
        $clientA = Client::create(['name' => 'Client A']);
        $clientB = Client::create(['name' => 'Client B']);

        $notifA = ClientNotification::create([
            'client_id' => $clientA->id,
            'title' => 'Secret A',
            'message' => 'Client A Only',
            'read_at' => null,
        ]);

        Sanctum::actingAs($clientB);

        // Client B cannot see Client A's notification
        $this->getJson('/api/client/notifications')
            ->assertJsonCount(0, 'items')
            ->assertJsonPath('total', 0);

        // Client B cannot mark read, unread, or delete Client A's notification
        $this->patchJson("/api/client/notifications/{$notifA->id}/read")->assertNotFound();
        $this->patchJson("/api/client/notifications/{$notifA->id}/unread")->assertNotFound();
        $this->deleteJson("/api/client/notifications/{$notifA->id}")->assertNotFound();

        $this->assertNull($notifA->fresh()->read_at);
    }

    public function test_both_prefixed_and_unprefixed_aliases_work(): void
    {
        $client = Client::create(['name' => 'Frank']);
        Sanctum::actingAs($client);

        $notif = ClientNotification::create([
            'client_id' => $client->id,
            'title' => 'Alias check',
            'message' => 'Testing route aliases',
            'read_at' => null,
        ]);

        // Un-prefixed /api/notifications
        $this->getJson('/api/notifications')
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('items.0.title', 'Alias check');

        $this->getJson('/api/notifications/unread-count')
            ->assertOk()
            ->assertJsonPath('unreadCount', 1);

        $this->patchJson("/api/notifications/{$notif->id}/read")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->postJson('/api/notifications/mark-all-read')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->deleteJson("/api/notifications/{$notif->id}")
            ->assertOk()
            ->assertJsonPath('success', true);
    }
}

