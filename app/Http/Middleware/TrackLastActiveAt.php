<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class TrackLastActiveAt
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }

        if (!$request->user()->last_active_at || $request->user()->last_active_at->isPast()) {
            $request->user()->update([
                'last_active_at' => now(),
            ]);
        }

        return $next($request);
    }
}