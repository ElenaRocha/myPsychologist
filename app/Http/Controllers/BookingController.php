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

    // pensar la ruta para ver sesiones ¿Todas las sesiones de un cliente?¿Todas las sesiones de un bono?

     /**
     * Obtener todas las reservas de un bono específico.
     */
    public function getBookingsByPass($pass_id)
    {
        $appointments = Appointment::where('pass_id', $pass_id)->pluck('booking_id');

        if ($appointments->isEmpty()) {
            return response()->json(['message' => 'No hay reservas asociadas a este bono'], 404);
        }

        $bookings = Booking::whereIn('id', $appointments)->get();

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
