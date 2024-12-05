<?php

namespace App\Http\Controllers;

use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        return RoleResource::collection($role);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $role = Role::create($request->all());

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $role->update($request->all());

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
}
