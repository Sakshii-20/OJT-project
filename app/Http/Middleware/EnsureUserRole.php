<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            if ($request->expectsJson() || $request->is('admin/*') || $request->is('student/*')) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
