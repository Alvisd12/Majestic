<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in using session
        if (!session('is_logged_in')) {
            // If it's an AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Session expired',
                    'message' => 'Silakan login kembali.',
                    'redirect' => route('login')
                ], 401);
            }
            
            // For regular requests, check if it's a back button attempt
            $referer = $request->header('referer');
            if ($referer && strpos($referer, $request->getHost()) !== false) {
                // User came from same domain (likely back button after logout)
                return redirect()->route('session.expired');
            }
            
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
} 