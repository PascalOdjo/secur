<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle requis
            return $request->expectsJson()
                ? abort(403, 'Unauthorized')
                : redirect()->route('login');
        }

        return $next($request);
    }
}