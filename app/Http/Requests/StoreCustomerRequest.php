<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',

            'birth_date' => 'required|date|before:today',

            'phone_number' => 'required|string|max:20|unique:customers,phone_number',
            'email' => 'nullable|email|unique:customers,email',

            'pinfl' => 'required|digits:14|unique:customers,pinfl',

            'passport_series' => 'required|string|size:2',
            'passport_number' => 'required|string|size:7',
            // Kombinatsiya unikal bo‘lishi kerak
            'passport_series' => 'required|string|size:2',
            'passport_number' => 'required|string|size:7',

            'address' => 'nullable|string',
        ];
    }

}
