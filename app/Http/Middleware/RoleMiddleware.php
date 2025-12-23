<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // jika belum login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // jika role tidak sesuai
        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'ANDA TIDAK PUNYA AKSES');
        }

        return $next($request);
    }
}
