<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatetransactionRequest extends FormRequest
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
            'debit_account_id' => 'nullable|uuid|exists:accounts,id',
            'credit_account_id' => 'nullable|uuid|exists:accounts,id',
            'debit_card_id' => 'nullable|uuid|exists:cards,id',
            'credit_card_id' => 'nullable|uuid|exists:cards,id',
            'debit_customer_id' => 'nullable|uuid|exists:customers,id',
            'credit_customer_id' => 'nullable|uuid|exists:customers,id',
            'amount' => 'required|numeric|min:0.01',
            'currency_code' => 'nullable|string|size:3',
            'exchange_rate' => 'nullable|numeric|min:0',
            'transaction_type' => 'nullable|in:transfer,p2p,payment,deposit,withdrawal,fee,reversal,loan_disbursement,loan_payment,refund,salary,cashback',
            'reference_number' => 'nullable|string|unique:transactions,reference_number,' . $this->transaction->id,
            'idempotency_key' => 'nullable|string|unique:transactions,idempotency_key,' . $this->transaction->id,
            'description' => 'nullable|string',
            'counterparty_name' => 'nullable|string',
            'counterparty_account' => 'nullable|string',
            'counterparty_bank' => 'nullable|string',
            'status' => 'nullable|in:pending,success,failed,reversed,cancelled',
            'executed_at' => 'nullable|date',
            'performed_by' => 'nullable|uuid|exists:users,id',
            'branch_id' => 'nullable|uuid|exists:branches,id',
            'loan_id' => 'nullable|uuid|exists:loans,id',
            'channel' => 'nullable|string|max:20',
        ];
    }

}
