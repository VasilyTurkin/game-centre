<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Computer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::factory()
            ->count(10)
            ->hasAttached(
                (new Computer)->inRandomOrder()->limit(2)->get()
            )
            ->create();
    }
}
