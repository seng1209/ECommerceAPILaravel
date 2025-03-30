<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');
        $token = Token::where('token', $refreshToken)->first();
        if (!$token || $token->expiry_at < now()) {
            return response()->json(['error' => 'invalid_or_expired_refresh_token'], 401);
        }
        $user_id = $token->user_id;

        if (!$user_id) {
            return response()->json(['error' => 'invalid_refresh_token'], 401);
        }

        $user = User::where('user_id', $user_id)->first();

        if ($user) {
            $jwtAccessTokenClaims = [
                'username' => $user->username,
                'role' => $user->role,
            ];
            $access_token = JWTAuth::claims($jwtAccessTokenClaims)->fromUser($user);
            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => $access_token,
                'refresh_token' => $refreshToken,
            ]);
        }

        return response()->json(['error' => 'user_not_found'], 404);
    }

    // User registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'username' => 'required|string|max:24|unique:users',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:50|unique:users',
            'phone' => 'required|string|max:12|unique:users',
            'address' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $roleUser = Role::where('role' , 'USER')->first();
        $roleCustomer = Role::where('role' , 'CUSTOMER')->first();

        $roles = [$roleUser->role_id, $roleCustomer->role_id];

        $user = User::create([
            'image' => $request->get('image'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
        ]);

        $user->roles()->attach($roles);

        return response()->json(['message' => 'User created successfully'], 201);
    }

    // User login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])->first();

        $roleIds = UserRole::where('user_id', $user->user_id)->pluck('role_id');

        $role1 = Role::where('role_id', $roleIds[0])->first();
        $role2 = Role::where('role_id', $roleIds[1])->first();

        $roles = [$role1->role, $role2->role];

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $jwtAccessTokenClaims = [
                'username' => $user->username,
                'role' => $roles,
            ];
            $access_token = JWTAuth::claims($jwtAccessTokenClaims)->fromUser($user);
            $refreshToken = bin2hex(random_bytes(32));
            $expiredAt = now()->addMinutes(5);
            Token::create([
                'user_id' => $user->user_id,
                'token' => $refreshToken,
                'expiry_at' => $expiredAt,
            ]);

            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => $access_token,
                'refresh_token' => $refreshToken,
            ]);
        } else {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
    }

    // Get authenticated user
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
