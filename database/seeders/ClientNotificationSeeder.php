<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Entities\ClientNotification;

class ClientNotificationSeeder extends Seeder
{
    /**
     * Seed sample notifications into the database.
     */
    public function run(?int $clientId = null): void
    {
        $clients = $clientId
            ? Client::where('id', $clientId)->get()
            : Client::all();

        if ($clients->isEmpty()) {
            $this->command?->warn('No clients found in database to seed notifications.');
            return;
        }

        foreach ($clients as $client) {
            $this->seedForClient($client);
        }

        $this->command?->info("Successfully seeded sample notifications for {$clients->count()} client(s).");
    }

    public static function seedForClient(Client $client): void
    {
        $samples = [
            [
                'title' => 'Booking request updated',
                'message' => 'H&H Motors has changed your booking status to Booked.',
                'status_word' => 'Booked',
                'status_color' => '#1E40AF',
                'type' => 'booking_update',
                'tru_id' => 'TRU000176',
                'provider_name' => 'H&H Motors',
                'read_at' => null,
                'created_at' => now()->subMinutes(12),
            ],
            [
                'title' => 'Booking update',
                'message' => 'H&H Motors has changed your booking status to Arrived.',
                'status_word' => 'Arrived',
                'status_color' => '#111827',
                'type' => 'booking_update',
                'tru_id' => 'TRU000176',
                'provider_name' => 'H&H Motors',
                'read_at' => null,
                'created_at' => now()->subHours(3),
            ],
            [
                'title' => 'Job update',
                'message' => 'ABC Car Fix has changed your job status to Ready for collection.',
                'status_word' => 'Ready for collection',
                'status_color' => '#1E40AF',
                'type' => 'job_update',
                'tru_id' => 'TRU002345',
                'provider_name' => 'ABC Car Fix',
                'read_at' => null,
                'created_at' => now()->subDay(),
            ],
            [
                'title' => 'Invoice update',
                'message' => 'ABC Car Fix has changed your invoice status to Paid.',
                'status_word' => 'Paid',
                'status_color' => '#111827',
                'type' => 'invoice_update',
                'tru_id' => 'TRU002345',
                'provider_name' => 'ABC Car Fix',
                'read_at' => now()->subDays(3),
                'created_at' => now()->subDays(3),
            ],
            [
                'title' => 'Booking update',
                'message' => 'All Star Cars has changed your booking status to Arrived.',
                'status_word' => 'Arrived',
                'status_color' => '#111827',
                'type' => 'booking_update',
                'tru_id' => 'TRU000889',
                'provider_name' => 'All Star Cars',
                'read_at' => now()->subDays(4),
                'created_at' => now()->subDays(4),
            ],
            [
                'title' => 'Job update',
                'message' => 'All Star Cars has changed your job status to Collected.',
                'status_word' => 'Collected',
                'status_color' => '#111827',
                'type' => 'job_update',
                'tru_id' => 'TRU000889',
                'provider_name' => 'All Star Cars',
                'read_at' => now()->subDays(6),
                'created_at' => now()->subDays(6),
            ],
            [
                'title' => 'MOT & Service reminder',
                'message' => 'Your vehicle FIG9509 MOT is due soon. Check nearby approved service providers.',
                'status_word' => 'Due',
                'status_color' => '#1E40AF',
                'type' => 'service_update',
                'tru_id' => 'TRU000176',
                'provider_name' => 'H&H Motors',
                'read_at' => null,
                'created_at' => now()->subMinutes(45),
            ],
        ];

        foreach ($samples as $data) {
            ClientNotification::create(array_merge($data, [
                'client_id' => $client->id,
            ]));
        }
    }
}

