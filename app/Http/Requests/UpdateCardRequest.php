<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
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
            'account_id' => 'required|uuid|exists:accounts,id',
            'customer_id' => 'required|uuid|exists:customers,id',
            'issued_by' => 'nullable|uuid|exists:users,id',

            'card_type' => 'required|in:UZCARD,HUMO,VISA,MASTERCARD',
            'card_product' => 'required|in:Classic,Gold,Platinum,Virtual,Business',

            'first_6' => 'required|digits:6',
            'last_4' => 'required|digits:4',

            'masked_number' => 'required|string|max:30|unique:cards,masked_number,' . $this->card->id,
            'card_holder_name' => 'required|string|max:255',
            'expiry_date' => 'required|date',

            'token' => 'nullable|string|unique:cards,token,' . $this->card->id,
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

}
