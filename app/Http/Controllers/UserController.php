<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     /**
     * Listar todos los usuarios (solo administradores).
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return response()->json(User::all());
    }

    /**
     * Obtener un usuario por ID.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return response()->json($user);
    }

    /**
 * Crear un nuevo usuario (solo administradores).
 */
public function store(Request $request)
{
    $this->authorize('create', User::class);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'telphone' => 'required|string|max:20',
        'role' => 'required|in:admin,client',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telphone' => $request->telphone,
        'role' => $request->role,
    ]);

    return response()->json([
        'message' => 'Usuario creado exitosamente',
        'user' => $user
    ], 201);
}


    /**
     * Actualizar un usuario.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6|confirmed',
            'telphone' => 'sometimes|string|max:20',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'telphone' => $request->telphone ?? $user->telphone,
        ]);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ]);
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    // falta store, showProfile y updateProfile
}
