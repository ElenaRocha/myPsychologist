<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pass;
use App\Models\Booking;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para verificar la relación entre Appointment, Pass y Booking.
     */
    public function test_appointment_relationships()
    {
        $user = User::factory()->create();
        $pass = Pass::factory()->create(['user_id' => $user->id]);
        $booking = Booking::factory()->create(['user_id' => $user->id, 'pass_id' => $pass->id]);

        $appointment = Appointment::create([
            'pass_id' => $pass->id,
            'booking_id' => $booking->id,
        ]);

        // Verificar que la relación con Pass funciona
        $this->assertEquals($pass->id, $appointment->pass->id);

        // Verificar que la relación con Booking funciona
        $this->assertEquals($booking->id, $appointment->booking->id);
    }

    /**
     * Test para verificar que se calculan correctamente las sesiones restantes de un Pass.
     */
    public function test_remaining_sessions_calculation()
    {
        $user = User::factory()->create();
        $pass = Pass::factory()->create([
            'user_id' => $user->id,
            'total_sessions' => 10,
            'remaining_sessions' => 10,
        ]);

        $booking = Booking::factory()->create(['user_id' => $user->id, 'pass_id' => $pass->id]);

        // Crear una cita (Appointment) que consume una sesión
        Appointment::create([
            'pass_id' => $pass->id,
            'booking_id' => $booking->id,
        ]);

        // Verificar que las sesiones restantes se actualizan correctamente
        $this->assertEquals(9, $pass->fresh()->remaining_sessions);
    }
}
