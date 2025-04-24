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

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user(); // Assuming you're using JWT Auth

        $roleIds = UserRole::where('user_id', $user->user_id)->pluck('role_id');

        $userRoles = [];

        foreach ($roleIds as $roleId) {
            $userRoles[] = Role::where('role_id', $roleId)->first()->role;
        }

        // Check if the user has one of the roles specified
        if ($user && $userRoles && array_intersect($userRoles, $roles)) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
