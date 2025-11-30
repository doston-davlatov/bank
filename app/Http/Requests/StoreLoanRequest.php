<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|uuid|exists:customers,id',
            'account_id' => 'nullable|uuid|exists:accounts,id',
            'branch_id' => 'required|uuid|exists:branches,id',
            'disbursed_by' => 'nullable|uuid|exists:users,id',
            'disbursement_transaction_id' => 'nullable|uuid|exists:transactions,id',

            'loan_type' => 'required|string|max:255',
            'principal_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0',
            'term_months' => 'required|integer|min:1',
            'monthly_payment' => 'required|numeric|min:0',
            'remaining_principal' => 'required|numeric|min:0',

            'disbursed_at' => 'required|date',
            'next_payment_date' => 'required|date|after_or_equal:disbursed_at',

            'overdue_days' => 'integer|min:0',

            'status' => 'in:active,closed,overdue,written_off',
        ];
    }

}
