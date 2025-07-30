<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\PeminjamanStatusService;

class AutoUpdatePeminjamanStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Only run on admin routes
        if ($request->is('admin/*') || $request->is('auth/dashboard')) {
            // Update status otomatis
            PeminjamanStatusService::updateStatuses();
        }

        return $next($request);
    }
} 