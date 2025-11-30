<?php

namespace App\Http\Controllers;

use App\Models\Loan_payment;
use App\Http\Requests\StoreLoan_paymentRequest;
use App\Http\Requests\UpdateLoan_paymentRequest;

class LoanPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Loan payment lar, pagination bilan, loan relation bilan
        $payments = Loan_payment::with(['loan', 'transaction'])
            ->orderBy('payment_date', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoan_paymentRequest $request)
    {
        $payment = Loan_payment::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loan payment created successfully',
            'data' => $payment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan_payment $loan_payment)
    {
        $loan_payment->load(['loan', 'transaction']);

        return response()->json([
            'success' => true,
            'data' => $loan_payment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoan_paymentRequest $request, Loan_payment $loan_payment)
    {
        $loan_payment->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loan payment updated successfully',
            'data' => $loan_payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan_payment $loan_payment)
    {
        $loan_payment->delete(); // agar soft delete ishlatilsa

        return response()->json([
            'success' => true,
            'message' => 'Loan payment deleted successfully'
        ]);
    }
}
