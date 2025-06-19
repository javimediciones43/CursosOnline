<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Aqui creamos un middleware checkRole para comprobar el rol de un usuario.
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Esto verifica si el rol del usuario es el mismo que el rol que se pasa como argumento.
        // Si el usuario no tiene ese rol, se devuelve un mensaje de error y cancela la solicitud.
        if ($request->user()->role !== $role) {
            return response()->json([
                'message' => 'Acceso denegado. Solo usuarios con rol ' . $role . ' tienen acceso.'],
                403);
        }
        return $next($request);
    }
}
