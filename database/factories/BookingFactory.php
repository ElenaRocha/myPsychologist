<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Pass;

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
        return [
            'user_id' => User::factory(),
            'pass_id' => fake()->boolean(70) ? Pass::factory() : null,
            'booking_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'paid' => fake()->boolean(50),
        ];
    }
}
