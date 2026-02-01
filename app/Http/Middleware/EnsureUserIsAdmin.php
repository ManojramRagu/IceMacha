<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request);
        }

        // Log unauthorized access attempts
        \App\Models\SecurityLog::create([
            'email' => $request->user() ? $request->user()->email : null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'attempted_url' => $request->fullUrl(),
            'attempted_at' => now(),
        ]);

        abort(403, 'Unauthorized action.');
    }
}
