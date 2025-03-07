<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pass;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para crear una nueva reserva.
     */
    public function test_create_booking()
    {
        $user = User::factory()->create();
        $pass = Pass::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->postJson('/api/reservar-sesion', [
            'user_id' => $user->id,
            'pass_id' => $pass->id,
            'booking_date' => '2023-12-25 10:00:00',
            'paid' => true,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Reserva creada exitosamente',
            ]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'pass_id' => $pass->id,
            'booking_date' => '2023-12-25 10:00:00',
            'paid' => true,
        ]);
    }

    /**
     * Test para obtener las reservas de un usuario.
     */
    public function test_get_user_bookings()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/mis-sesiones');

        $response->assertStatus(200)
            ->assertJson([
                [
                    'id' => $booking->id,
                    'user_id' => $user->id,
                ],
            ]);
    }
}
