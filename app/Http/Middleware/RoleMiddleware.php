<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!auth()->check()) {
            abort(403);
        }

        $allowedRoles = explode(',', $roles);

        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
