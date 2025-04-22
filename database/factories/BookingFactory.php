<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('now', '+30 days');

        $endTime = (clone $startTime)->modify('+'.rand(1, 4).' hours');

        return [
            'user_id' => User::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $this->faker->randomElement(['confirmed', 'canceled']),
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }

    public function confirmed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'confirmed',
            ];
        });
    }

    public function canceled()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'canceled',
            ];
        });
    }
}
