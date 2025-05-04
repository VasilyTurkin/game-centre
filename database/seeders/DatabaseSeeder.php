<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Computer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('booking_computer')->truncate();
        DB::table('bookings')->truncate();
        DB::table('computers')->truncate();
        DB::table('users')->truncate();

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = (new User)->create([
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password' . $i),
                'deposit' => rand(1000, 10000) / 100,
                'email_verified_at' => now(),
            ]);
        }

        $computers = [];
        $specs = [
            'Intel Core i7, 16GB RAM, 512GB SSD, NVIDIA RTX 3080',
            'AMD Ryzen 9, 32GB RAM, 1TB SSD, NVIDIA RTX 3090',
            'Intel Core i5, 8GB RAM, 256GB SSD, NVIDIA GTX 1660',
            'AMD Ryzen 7, 16GB RAM, 1TB HDD, NVIDIA RTX 3060',
            'Intel Core i9, 64GB RAM, 2TB SSD, NVIDIA RTX 4090',
        ];

        for ($i = 1; $i <= 10; $i++) {
            $computers[] = (new Computer)->create([
                'name' => 'PC-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'price' => rand(500, 2000),
                'specs' => $specs[array_rand($specs)],
            ]);
        }

        $bookings = [];
        for ($i = 1; $i <= 10; $i++) {
            $start = Carbon::now()->addDays(rand(1, 30))->addHours(rand(1, 12));
            $end = (clone $start)->addHours(rand(1, 6));

            $bookings[] = Booking::create([
                'user_id' => $users[array_rand($users)]->id,
                'start_time' => $start,
                'end_time' => $end,
                'status' => rand(0, 1) ? 'confirmed' : 'canceled',
                'total_price' => rand(1000, 5000) / 100,
            ]);
        }

        foreach ($bookings as $booking) {

            $randomComputers = array_rand($computers, rand(1, 3));
            $randomComputers = is_array($randomComputers) ? $randomComputers : [$randomComputers];

            foreach ($randomComputers as $computerIndex) {
                $booking->computers()->attach($computers[$computerIndex]->id);
            }
        }
    }
}
