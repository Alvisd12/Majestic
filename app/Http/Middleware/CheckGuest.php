<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is NOT logged in using session
        if (session('is_logged_in')) {
            return redirect()->route('auth.dashboard')->with('info', 'Anda sudah login.');
        }

        return $next($request);
    }
} 