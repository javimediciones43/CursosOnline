<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


// Controller creado para gestionar la autenticacion.
class AuthController extends Controller
{
    // Implemantamos la logica de los registros.
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:8|confirmed',
            'role' => 'required|in:user'
            // 'role' => 'required|in:admin'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return response()->json([
            'message' => 'Ususario creado correctamente',
            'user' => $user
        ], 201);
    }
    // Asegúrate de que el campo password_confirmation también se envíe en el body para la validación confirmed.

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);


/* $user = User::where('email', $request->email)->first();

        // Verifica si el usuario tiene el rol de administrador.
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales Invalidas'
            ], 401);
        } */

       if (!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'message' => 'Credenciales Invalidas'
            ], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesion exitoso',
            'token' => $token,
            'accepted' => true,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'La sesión se ha cerrado correctamente']);
    }
}
