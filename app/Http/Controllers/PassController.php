<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pass;

class PassController extends Controller
{
    /**
     * Listar todos los bonos (solo administradores).
     */
    public function index()
    {
        $this->authorize('viewAny', Pass::class);
        return response()->json(Pass::all());
    }

    /**
     * Obtener todos los bonos de un usuario específico.
     */
    public function getUserPasses($user_id)
    {
        $passes = Pass::where('user_id', $user_id)->get();

        if ($passes->isEmpty()) {
            return response()->json(['message' => 'Este usuario no tiene bonos'], 404);
        }

        return response()->json($passes);
    }

    /**
     * Crear un nuevo bono.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Pass::class);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_sessions' => 'required|integer|min:1',
            'remaining_sessions' => 'required|integer|min:0',
            'purchase_date' => 'required|date',
        ]);

        $pass = Pass::create($request->all());

        return response()->json([
            'message' => 'Bono creado exitosamente',
            'pass' => $pass
        ], 201);
    }

    /**
     * Eliminar un bono.
     */
    public function destroy($id)
    {
        $pass = Pass::findOrFail($id);
        $this->authorize('delete', $pass);
        $pass->delete();

        return response()->json(['message' => 'Bono eliminado correctamente']);
    }

    // en la vista de los bonos, que se vea cuántas sesiones quedan
}
