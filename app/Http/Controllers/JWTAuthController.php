<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
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

        $user = User::create([
            'image' => $request->get('image'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
        ]);

        return response()->json(['message' => 'User created successfully'], 201);

//        $token = JWTAuth::fromUser($user);

//        return response()->json(compact('user','token'), 201);
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

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Password is correct, generate token
//            $token = JWTAuth::attempt($credentials);
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => $token,
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
