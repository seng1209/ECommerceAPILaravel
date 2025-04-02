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
//        if (User::find($request->username))
        if (User::where('username', $request->username)->exists())
        {
            return response()->json(['message' => 'Username already exists'], 400);
        }

//        if (User::find($request->phone))
        if (User::where('phone', $request->phone)->exists())
        {
            return response()->json(['message' => 'Phone number already exists'], 400);
        }

//        if (User::find($request->email))
        if (User::where('email', $request->email)->exists())
        {
            return response()->json(['message' => 'Email already exists'], 400);
        }

        $user = new User();
        $user->image = $request->image;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        return new UserResource($user);
//        return response()->json(['message' => 'User created successfully'], 201);

    }

    public function update(UpdateUserRequest $request, $username)
    {
//        $user = User::find($username);
        $user = User::where('username', $username)->first();
        if ($user){
            $user->image = is_null($request->image) ? $user->image : $request->image;
            $user->username = is_null($request->username) ? $user->username : $request->username;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->phone = is_null($request->phone) ? $user->phone : $request->phone;
            $user->address = is_null($request->address) ? $user->address : $request->address;
            $user->role = is_null($request->role) ? $user->role : $request->role;
            $user->save();
            return new UserResource($user);
//            return response()->json(['message' => 'User updated successfully'], 200);
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
