<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanctumMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
