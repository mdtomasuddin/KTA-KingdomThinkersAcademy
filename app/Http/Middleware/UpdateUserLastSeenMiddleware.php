<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastSeenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user() ?: $request->user();

        if ($user) {
            // Update last_seen_at if null or older than 1 minute to avoid excessive database writes
            if (! $user->last_seen_at || $user->last_seen_at->lt(now()->subMinute())) {
                $user->timestamps = false; // Avoid changing updated_at
                $user->update(['last_seen_at' => now()]);
                $user->timestamps = true;
            }
        }

        return $next($request);
    }
}

