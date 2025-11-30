<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'account_number',
        'customer_id',
        'branch_id',
        'opened_by',
        'currency_code',
        'account_type',
        'balance',
        'available_balance',
        'status',
        'opened_at',
        'closed_at'
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'balance' => 'decimal:4',
        'available_balance' => 'decimal:4',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'account_type' => 'string',
        'status' => 'string',
    ];

    /**
     * Allowed enum values for account_type
     */
    public const ACCOUNT_TYPES = ['current', 'savings', 'card', 'loan'];

    /**
     * Allowed enum values for status
     */
    public const STATUS_TYPES = ['active', 'frozen', 'closed', 'dormant'];

    /**
     * Relationships
     */

    // Account belongs to a Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Account belongs to a Branch
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // Account opened by a User
    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    // Account has many Products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Account has many Cards
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    // Account has many Transactions (as debit)
    public function debitTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'debit_account_id');
    }

    // Account has many Transactions (as credit)
    public function creditTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'credit_account_id');
    }

    /**
     * Scopes
     */

    // Active accounts
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Filter by account type
    public function scopeType($query, string $type)
    {
        if (in_array($type, self::ACCOUNT_TYPES)) {
            return $query->where('account_type', $type);
        }
        return $query;
    }
}
