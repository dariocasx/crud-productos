<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarRol
{
    public function handle(Request $request, Closure $next, $role)
    {
        $usuario = session('usuario'); // Obtener usuario de la sesion

        // verifica si el usuario esta autenticado
        if (!$usuario) {
            return response()->json(['error' => 'Acceso denegado. Usuario no autenticado.'], 403);
        }

        // verifica el rol del usuario
        if ($usuario['role'] !== $role) {
            return response()->json(['error' => 'Acceso denegado.'], 403);
        }

        return $next($request);
    }
}
