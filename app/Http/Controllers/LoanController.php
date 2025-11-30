<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eng so‘nggi berilgan kreditlar, pagination bilan
        $loans = Loan::with(['customer', 'branch']) // optimized
        ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $loans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanRequest $request)
    {
        $loan = Loan::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loan created successfully',
            'data' => $loan
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        // Relationship bilan birga qaytarish
        $loan->load(['customer', 'branch']);

        return response()->json([
            'success' => true,
            'data' => $loan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        $loan->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loan updated successfully',
            'data' => $loan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete(); // soft delete

        return response()->json([
            'success' => true,
            'message' => 'Loan deleted successfully'
        ]);
    }
}
