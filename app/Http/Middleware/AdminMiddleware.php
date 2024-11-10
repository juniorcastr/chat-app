<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || !auth()->user()->hasPerfil('Admin')) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}

