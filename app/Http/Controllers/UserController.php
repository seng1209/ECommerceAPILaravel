<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(User::all());
    }

    public function show($username)
    {
        if (User::where('username', $username)->exists()) {
            $user = User::where('username', $username)->first();
            return new UserResource($user);
        }else{
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function store(StoreUserRequest $request)
    {
        if (User::where('username', $request->username)->exists())
        {
            return response()->json(['message' => 'Username already exists'], 400);
        }

        if (User::where('phone', $request->phone)->exists())
        {
            return response()->json(['message' => 'Phone number already exists'], 400);
        }

        if (User::where('email', $request->email)->exists())
        {
            return response()->json(['message' => 'Email already exists'], 400);
        }

        dd($request->all());

        return new UserResource(User::create($request->all()));

    }

    public function update(UpdateUserRequest $request, $username)
    {
        $user = User::where('username', $username)->first();
        if ($user){
            return new UserResource($user->update($request->all()));
        }else
            return response()->json(['message' => 'User not found'], 404);
    }

    public function destroy($username)
    {
        if (User::where('username', $username)->exists()) {
            $user = User::where('username', $username)->first();
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        }else
            return response()->json(['message' => 'User not found'], 404);
    }
}
