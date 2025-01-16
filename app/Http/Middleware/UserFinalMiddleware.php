<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFinalMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y tiene rol de usuario final (2)
        if (Auth::check() && Auth::user()->role_id == 2) {
            return $next($request);
        }

        // Si no está autenticado o no es usuario final, redirigir al login
        return redirect()->route('login')->with('error', 'Acceso denegado.');
    }
}
