<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'debit_account_id',
        'credit_account_id',
        'debit_card_id',
        'credit_card_id',
        'debit_customer_id',
        'credit_customer_id',
        'amount',
        'currency_code',
        'exchange_rate',
        'transaction_type',
        'reference_number',
        'idempotency_key',
        'description',
        'counterparty_name',
        'counterparty_account',
        'counterparty_bank',
        'status',
        'executed_at',
        'performed_by',
        'branch_id',
        'loan_id',
        'channel',
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'amount' => 'decimal:4',
        'exchange_rate' => 'decimal:8',
        'executed_at' => 'datetime',
        'debit_account_id' => 'string',
        'credit_account_id' => 'string',
        'debit_card_id' => 'string',
        'credit_card_id' => 'string',
        'debit_customer_id' => 'string',
        'credit_customer_id' => 'string',
        'performed_by' => 'string',
        'branch_id' => 'string',
        'loan_id' => 'string',
    ];

    /**
     * Relationships
     */

    public function debitAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'debit_account_id');
    }

    public function creditAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'credit_account_id');
    }

    public function debitCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'debit_card_id');
    }

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'credit_card_id');
    }

    public function debitCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'debit_customer_id');
    }

    public function creditCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'credit_customer_id');
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branche::class, 'branch_id');
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    /**
     * Scopes
     */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeReversed($query)
    {
        return $query->where('status', 'reversed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeType($query, string $type)
    {
        return $query->where('transaction_type', $type);
    }
}
