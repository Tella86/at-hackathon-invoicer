<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@app.com')->first();

        // Exit if the demo user doesn't exist
        if (!$user) {
            $this->command->info('Demo user not found. Skipping ClientSeeder.');
            return;
        }

        // Create 5 clients for the demo user
        Client::factory(5)->create(['user_id' => $user->id])
            ->each(function ($client) use ($user) {
                // For each client, create a few invoices
                Invoice::factory(3)
                    ->has(InvoiceItem::factory()->count(2), 'items') // Create 2 items for each invoice
                    ->create([
                        'user_id' => $user->id,
                        'client_id' => $client->id,
                    ]);
            });
    }
}
