<?php

namespace App\Http\Controllers;

use App\Mail\VerifyCode;
use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserVerifyCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{

    // resend verify code
    public function resendVerifyCode(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $verificationCode = rand(100000, 999999);

//        Mail::to($request->email)->send(new VerifyCode($verificationCode));

        $expiredAt = now()->addMinutes(5);

//        if ($expiredAt < now()){
//            return response()->json(['error' => 'Code expired'], 401);
//        }

//        dd($expiredAt, now());

        UserVerifyCode::create([
            'user_id' => $user->user_id,
            'code' => $verificationCode,
            'expiry_at' => $expiredAt,
        ]);

        return response()->json(['message' => 'Please verify.'], 200);

    }

    // verify code
    public function verify(Request $request)
    {
        $code = $request->input('code');
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $userVerifyCode = UserVerifyCode::where('user_id', $user->user_id)->first();

        if (!$userVerifyCode){
            return response()->json(['error' => 'User not found'], 404);
        }

//        dd($userVerifyCode->expiry_at, now());

        if ($userVerifyCode->expiry_at < now()){
            $userVerifyCode->delete();
            return response()->json(['error' => 'Code expired'], 401);
        }

        if ($userVerifyCode && $userVerifyCode->code == $code && $userVerifyCode->expiry_at > now()) {
            $user = User::where('user_id', $user->user_id)->first();
            $user->is_verified = true;
            $user->save();
            $userVerifyCode->delete();
            return response()->json(['message' => 'Code verified successfully'], 200);
        } else {
            return response()->json(['error' => 'Invalid code'], 401);
        }

    }

    // refresh token
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

        $roleIds = UserRole::where('user_id', $user->user_id)->pluck('role_id');

        $roles = [];

        foreach ($roleIds as $roleId) {
            $roles[] = Role::where('role_id', $roleId)->first()->role;
        }

        if ($user) {
            $jwtAccessTokenClaims = [
                'username' => $user->username,
                'role' => $roles,
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
            'image_name' => 'required',
            'username' => 'required|string|max:24|unique:users',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:50|unique:users',
            'phone' => 'required|string|max:12|unique:users',
            'address' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // set default role for user
        $roleUser = Role::where('role' , 'USER')->first();
        $roleCustomer = Role::where('role' , 'CUSTOMER')->first();

        $roles = [$roleUser->role_id, $roleCustomer->role_id];

//        $verificationCode = rand(100000, 999999);

//        Mail::to($request->email)->send(new VerifyCode($verificationCode));

        $user = User::create([
            'image' => $request->get('image'),
            'image_name' => $request->get('image_name'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
        ]);

//        $expiredAt = now()->addMinutes(2);

//        UserVerifyCode::create([
//            'user_id' => $user->user_id,
//            'code' => $verificationCode,
//            'expiry_at' => $expiredAt,
//        ]);

        // create user_roles
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

//        if (!$user->is_verified || $user->is_verified == null){
//            return response()->json(['error' => 'User not verified'], 401);
//        }

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
            $expiredAt = now()->addDays(30);
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
