<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Listar todas las reservas (solo administradores).
     */
    public function index()
    {
        $this->authorize('viewAny', Booking::class);
        return response()->json(Booking::all());
    }

    /**
     * Obtener todas las reservas de un usuario.
     */
    public function getUserBookingsAdmin($user_id)
    {
        $this->authorize('viewAny', Booking::class);

        $bookings = Booking::where('user_id', $user_id)->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'Este usuario no tiene reservas'], 404);
        }

        return response()->json($bookings);
    }

    /**
     * Que un usuario pueda ver sus reservas
     */
    public function getUserBookings(Request $request)
    {
        $user = $request->user();
        $bookings = Booking::where('user_id', $user->id)->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No tienes reservas activas'], 404);
        }

        return response()->json($bookings);
    }

    /**
     * Crear una nueva reserva.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Booking::class);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pass_id' => 'nullable|exists:passes,id',
            'booking_date' => 'required|date',
            'paid' => 'boolean',
        ]);

        $booking = Booking::create($request->all());

        return response()->json([
            'message' => 'Reserva creada exitosamente',
            'booking' => $booking
        ], 201);
    }

    /**
     * Mostrar una reserva específica.
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $this->authorize('view', $booking);
        return response()->json($booking);
    }

    /**
     * Eliminar una reserva.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $this->authorize('delete', $booking);
        $booking->delete();

        return response()->json(['message' => 'Reserva eliminada correctamente']);
    }
}
