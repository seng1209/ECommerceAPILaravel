<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new RoleCollection(Role::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        if (Role::where('role', $request->role)->first()){
            return response()->json(['message' => 'Role already exists'], 409);
        }

        $role = new Role();
        $role->role = $request->role;
        $role->description = $request->description;
        $role->save();
        return new RoleResource($role);
//        return response()->json(['message' => 'Role created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($role)
    {
        if ($tb_role = Role::where('role', $role)->first()) {
            return new RoleResource($tb_role);
        }

        return response()->json(['message' => 'Role not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, $role)
    {
        $tb_role = Role::where('role', $role)->first();
        if ($tb_role){
            $tb_role->role = is_null($request->role) ? $tb_role->role : $request->role;
            $tb_role->description = is_null($request->description) ? $tb_role->description : $request->description;
            $tb_role->save();
            return new RoleResource($tb_role);
//            return response()->json(['message' => 'Role updated successfully'], 200);
        }else{
            return response()->json(['message' => 'Role not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($role)
    {
        $tb_role = Role::where('role', $role)->first();
        if ($tb_role){
            $tb_role->delete();
            return response()->json(['message' => 'Role deleted successfully'], 202);
        }else{
            return response()->json(['message' => 'Role not found'], 404);
        }
    }
}
