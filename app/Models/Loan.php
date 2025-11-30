<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'customer_id',
        'account_id',
        'branch_id',
        'disbursed_by',
        'disbursement_transaction_id',
        'loan_type',
        'principal_amount',
        'interest_rate',
        'term_months',
        'monthly_payment',
        'remaining_principal',
        'disbursed_at',
        'next_payment_date',
        'overdue_days',
        'status',
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'principal_amount' => 'decimal:4',
        'interest_rate' => 'decimal:4',
        'monthly_payment' => 'decimal:4',
        'remaining_principal' => 'decimal:4',
        'disbursed_at' => 'date',
        'next_payment_date' => 'date',
        'overdue_days' => 'integer',
        'status' => 'string',
    ];

    /**
     * Relationships
     */

    // Loan belongs to a Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Loan belongs to an Account
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Loan belongs to a Branch
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branche::class);
    }

    // Loan disbursed by a User
    public function disbursedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disbursed_by');
    }

    // Loan disbursement transaction
    public function disbursementTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'disbursement_transaction_id');
    }

    // Loan has many payments
    public function payments(): HasMany
    {
        return $this->hasMany(Loan_payment::class);
    }

    // Loan has many schedules
    public function schedules(): HasMany
    {
        return $this->hasMany(Loan_schedul::class);
    }

    /**
     * Scopes
     */

    // Active loans
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Overdue loans
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    // Closed loans
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }
}
