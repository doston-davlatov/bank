<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoan_paymentRequest extends FormRequest
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
            'loan_id' => 'required|uuid|exists:loans,id',
            'transaction_id' => 'nullable|uuid|exists:transactions,id',
            'amount' => 'required|numeric|min:0',
            'principal_part' => 'required|numeric|min:0',
            'interest_part' => 'required|numeric|min:0',
            'penalty_part' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_method' => 'required|string|max:30',
        ];
    }

}
