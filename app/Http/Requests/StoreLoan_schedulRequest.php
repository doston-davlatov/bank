<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoan_schedulRequest extends FormRequest
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
            'period' => 'required|integer|min:1',
            'due_date' => 'required|date|after_or_equal:today',
            'planned_principal' => 'required|numeric|min:0',
            'planned_interest' => 'required|numeric|min:0',
            'planned_total' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'is_paid' => 'nullable|boolean',
            'paid_at' => 'nullable|date',
        ];
    }

}
