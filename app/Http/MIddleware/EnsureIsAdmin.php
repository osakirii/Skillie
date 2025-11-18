<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user || ! data_get($user, 'is_admin')) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
