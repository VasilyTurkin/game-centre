<?php

namespace Database\Seeders;

use App\Models\Computer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 10;

        for ($i = 1; $i <= $count; $i++) {
            Computer::factory()->create([
                'name' => 'Computer' . $i,
            ]);
        }
    }
}
