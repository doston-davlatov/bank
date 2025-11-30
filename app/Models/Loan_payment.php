<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan_payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'loan_id',
        'transaction_id',
        'amount',
        'principal_part',
        'interest_part',
        'penalty_part',
        'payment_date',
        'payment_method',
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'amount' => 'decimal:4',
        'principal_part' => 'decimal:4',
        'interest_part' => 'decimal:4',
        'penalty_part' => 'decimal:4',
        'payment_date' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Loan payment belongs to a Loan
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    // Loan payment may belong to a Transaction
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Scopes
     */

    // Payments above a certain amount
    public function scopeAboveAmount($query, $amount)
    {
        return $query->where('amount', '>', $amount);
    }

    // Payments by method
    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }
}
