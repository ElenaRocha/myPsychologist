<?php

// tests/Unit/AppointmentTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointment_creation()
    {
        $user = User::factory()->create();
        $appointment = Appointment::factory()->create([
            'user_id' => $user->id,
            'date' => '2023-12-25',
            'time' => '10:00',
        ]);

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'date' => '2023-12-25',
            'time' => '10:00',
        ]);
    }
}