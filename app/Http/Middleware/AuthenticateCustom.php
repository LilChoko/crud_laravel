<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado mediante la sesión
        if (!session('user_id')) {
            // Si no está autenticado, redirigir a la página de login
            return redirect()->route('login');
        }

        // Si está autenticado, permitir el acceso
        return $next($request);
    }
}
