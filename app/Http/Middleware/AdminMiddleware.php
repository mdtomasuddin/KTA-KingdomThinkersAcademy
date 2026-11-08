<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedRoles = ['super_admin', 'admin'];

        if (! Auth::check() || ! in_array(Auth::user()->role, $allowedRoles, true)) {
            if ($request->expectsJson()) {
                return response()->json([
                    't-error' => true,
                    'message' => 'Access restricted to authorized administrators.',
                ], 403);
            }

            Auth::guard('web')->logout();

            return redirect()->route('login')->withErrors([
                'email' => 'This account does not have administrative privileges.',
            ]);
        }

        return $next($request);
    }
}

