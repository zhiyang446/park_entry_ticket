<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => 'TICKET' . Carbon::now()->format('Ymd') . '_' . str_pad(1, 3, '0', STR_PAD_LEFT),
            'creation_date' => Carbon::now()->format('Y-m-d'),
            'redemption_date' => Carbon::now()->format('Y-m-d'),
            'status' => 'new',
        ];
    }
}
