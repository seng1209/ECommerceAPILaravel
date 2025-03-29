<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next, ...$roles): Response
//    {
//        $user = Auth::user();
//
//        // Check if the user has the required role
//        if (!$user || !in_array($user->role, $roles)) {
//            return response()->json(['error' => 'Unauthorized'], 403);
//        }
//
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next, $role)
    {
        // Get the authenticated user from the JWT token
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user || $user->role !== $role) {
            return response()->json(['message' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
