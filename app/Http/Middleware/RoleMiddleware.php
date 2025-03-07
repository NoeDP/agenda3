<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Verifica si el usuario está autenticado y si tiene el rol correspondiente
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            //throw new AuthorizationException('Acceso denegado.');
             abort(403);
        }

        return $next($request);
    }
}
