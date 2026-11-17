<?php

namespace App\Console\Commands;

use Database\Seeders\ClientNotificationSeeder;
use Illuminate\Console\Command;
use Modules\ClientHub\Entities\Client;

class SeedClientNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:seed-notifications {client_id? : Specific client ID to seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed sample notifications into the database for client(s)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $clientId = $this->argument('client_id');

        if ($clientId) {
            $client = Client::find($clientId);
            if (!$client) {
                $this->error("Client with ID {$clientId} not found.");
                return 1;
            }
            ClientNotificationSeeder::seedForClient($client);
            $this->info("Seeded sample notifications for client ID {$clientId} ({$client->name} <{$client->email}>).");
            return 0;
        }

        $clients = Client::all();
        if ($clients->isEmpty()) {
            $this->warn('No clients found in the database.');
            return 0;
        }

        foreach ($clients as $client) {
            ClientNotificationSeeder::seedForClient($client);
        }

        $this->info("Seeded sample notifications for all {$clients->count()} clients successfully.");
        return 0;
    }
}

