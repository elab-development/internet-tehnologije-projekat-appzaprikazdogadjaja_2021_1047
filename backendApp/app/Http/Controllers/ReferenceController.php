<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reference = Reference::all();
        return response()->json(ReferenceResource::collection($reference));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'website' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reference = Reference::create($validator->validated());
        return response()->json(new ReferenceResource($reference), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reerence = Reference::findOrFail($id);
        return response()->json(new ReferenceResource($reference));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'website' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reference = Reference::findOrFail($id);
        $reference->update($validator->validated());
        return response()->json(new ReferenceResource($reference));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reference = Reference::findOrFail($id);
        $reference->delete();
        return response()->json(['message' => 'Reference deleted successfully']);
    }
}
