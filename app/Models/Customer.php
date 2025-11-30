<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'phone_number',
        'email',
        'pinfl',
        'passport_series',
        'passport_number',
        'address',
        'email_verified_at',
        'phone_verified_at',
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'birth_date' => 'date',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Customer has many accounts
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    // Customer has many cards
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    // Customer has many loans
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    // Customer has many transactions (as debit)
    public function debitTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'debit_customer_id');
    }

    // Customer has many transactions (as credit)
    public function creditTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'credit_customer_id');
    }

    /**
     * Scopes
     */

    // Search customer by full name
    public function scopeName($query, string $name)
    {
        return $query->where(function ($q) use ($name) {
            $q->where('first_name', 'like', "%{$name}%")
                ->orWhere('last_name', 'like', "%{$name}%")
                ->orWhere('middle_name', 'like', "%{$name}%");
        });
    }

    // Filter by phone
    public function scopePhone($query, string $phone)
    {
        return $query->where('phone_number', $phone);
    }
}
