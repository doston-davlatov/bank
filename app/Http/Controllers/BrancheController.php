<?php

namespace App\Http\Controllers;

use App\Models\Branche;
use App\Http\Requests\StoreBrancheRequest;
use App\Http\Requests\UpdateBrancheRequest;

class BrancheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Barcha filiallarni olish (pagination bilan)
        $branches = Branche::orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $branches
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrancheRequest $request)
    {
        $branche = Branche::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Branche created successfully',
            'data' => $branche
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branche $branche)
    {
        return response()->json([
            'success' => true,
            'data' => $branche
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrancheRequest $request, Branche $branche)
    {
        $branche->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Branche updated successfully',
            'data' => $branche
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branche $branche)
    {
        $branche->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branche deleted successfully'
        ]);
    }
}
