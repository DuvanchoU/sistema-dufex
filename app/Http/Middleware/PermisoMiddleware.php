<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermisoMiddleware
{
    public function handle(Request $request, Closure $next, string $permiso): Response
    {
        // Usuario no autenticado
        if (!Auth::check()) {
            abort(403, 'No autenticado');
        }

        // Usuario sin permiso
        if (!Auth::user()->tienePermiso($permiso)) {
            abort(403, 'No tienes permiso para esta acción');
        }

        return $next($request);
    }
}
