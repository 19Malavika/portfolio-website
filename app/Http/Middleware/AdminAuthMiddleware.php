<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check Bearer token or custom X-Admin-Token header
        $token = $request->bearerToken() ?? $request->header('X-Admin-Token');

        if ($token) {
            $user = User::where('api_token', $token)->first();
            if ($user) {
                auth()->setUser($user);
                return $next($request);
            }
        }

        // 2. Check standard Laravel session auth (only if request has session)
        if ($request->hasSession() && auth()->check()) {
            return $next($request);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized. Admin credentials or valid token required.',
        ], 401);
    }
}
