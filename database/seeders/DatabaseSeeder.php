<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'is_admin' => true,
        ]);

        Ticket::factory()->create([
            'ticket_id' => 'TICKET20250218_001',
            'ticket_type' => 'adult',
            'ticket_price' => '100',
            'ticket_quantity' => '1',
            'creation_date' => '2025-02-18',
            'redemption_date' => '2025-02-18',
            'status' => 'new',
        ]);
    }
}
