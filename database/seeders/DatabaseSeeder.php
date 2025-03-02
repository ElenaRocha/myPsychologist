<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pass;
use App\Models\Booking;
use App\Models\Appointment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(10)->create()->each(function ($user) {
            Pass::factory(fake()->numberBetween(1, 3))->create(['user_id' => $user->id])->each(function ($pass) {
                Booking::factory(fake()->numberBetween(1, 5))->create(['user_id' => $pass->user_id, 'pass_id' => $pass->id])->each(function ($booking) use ($pass) {
                    Appointment::factory(fake()->numberBetween(1, 2))->create([
                        'pass_id' => $pass->id,
                        'booking_id' => $booking->id,
                    ]);
                });
            });
        });
    }
}
