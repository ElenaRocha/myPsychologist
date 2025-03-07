<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pass;
use App\Models\Booking;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PassControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para crear un nuevo bono.
     */
    public function test_create_pass()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/adquirir-bono', [
            'user_id' => $user->id,
            'total_sessions' => 10,
            'remaining_sessions' => 10,
            'purchase_date' => '2023-12-25',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Bono creado exitosamente',
            ]);

        $this->assertDatabaseHas('passes', [
            'user_id' => $user->id,
            'total_sessions' => 10,
            'remaining_sessions' => 10,
            'purchase_date' => '2023-12-25',
        ]);
    }

    /**
     * Test para obtener los bonos de un usuario.
     */
    public function test_get_user_passes()
    {
        $user = User::factory()->create();
        $pass = Pass::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/mis-bonos');

        $response->assertStatus(200)
            ->assertJson([
                [
                    'id' => $pass->id,
                    'user_id' => $user->id,
                    'total_sessions' => $pass->total_sessions,
                    'remaining_sessions' => $pass->remaining_sessions,
                ],
            ]);
    }

    /**
     * Test para verificar que las sesiones restantes se calculan correctamente.
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
        Appointment::create(['pass_id' => $pass->id, 'booking_id' => $booking->id]);

        $response = $this->actingAs($user)->getJson('/api/mis-bonos');

        $response->assertStatus(200)
            ->assertJson([
                [
                    'id' => $pass->id,
                    'remaining_sessions' => 9,
                ],
            ]);
    }
}
