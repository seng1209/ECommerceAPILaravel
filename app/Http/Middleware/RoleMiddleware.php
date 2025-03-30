<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\UserRole;
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
//    public function handle(Request $request, Closure $next, $role)
//    {
//        // Get the authenticated user from the JWT token
//        $user = JWTAuth::parseToken()->authenticate();
//
//        if (!$user || $user->role !== $role) {
//            return response()->json(['message' => 'Access denied'], Response::HTTP_FORBIDDEN);
//        }
//
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user(); // Assuming you're using JWT Auth

        $roleIds = UserRole::where('user_id', $user->user_id)->pluck('role_id');

        $role1 = Role::where('role_id', $roleIds[0])->first();
        $role2 = Role::where('role_id', $roleIds[1])->first();

        $userRoles = [$role1->role, $role2->role];

        // Check if the user has one of the roles specified
//        if ($user && $user->role && array_intersect($user->role, $roles)) {
//            return $next($request);
//        }
        if ($user && $userRoles && array_intersect($userRoles, $roles)) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
