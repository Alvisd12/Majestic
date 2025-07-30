<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $userRole = session('user_role');
        
        if (!$userRole || $userRole !== $role) {
            // Redirect based on current role or to login if no role
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak!');
            } elseif ($userRole === 'pengunjung') {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
            } else {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }
        }

        return $next($request);
    }
}

// Register middleware di app/Http/Kernel.php
// Tambahkan di array $routeMiddleware:
// 'checkRole' => \App\Http\Middleware\CheckRole::class,