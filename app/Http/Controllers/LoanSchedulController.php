<?php

namespace App\Http\Controllers;

use App\Models\Loan_schedul;
use App\Http\Requests\StoreLoan_schedulRequest;
use App\Http\Requests\UpdateLoan_schedulRequest;

class LoanSchedulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Loan_schedul::with('loan')
            ->orderBy('due_date', 'asc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $schedules
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoan_schedulRequest $request)
    {
        $schedule = Loan_schedul::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loan schedule created successfully',
            'data' => $schedule
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan_schedul $loan_schedul)
    {
        $loan_schedul->load('loan');

        return response()->json([
            'success' => true,
            'data' => $loan_schedul
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoan_schedulRequest $request, Loan_schedul $loan_schedul)
    {
        $loan_schedul->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loan schedule updated successfully',
            'data' => $loan_schedul
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan_schedul $loan_schedul)
    {
        $loan_schedul->delete(); // soft delete qo‘shish mumkin

        return response()->json([
            'success' => true,
            'message' => 'Loan schedule deleted successfully'
        ]);
    }
}
