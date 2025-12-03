<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // yangi maydon
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Foydalanuvchi rollarini tekshirish uchun yordamchi metod
    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    /**
     * Relationships
     */

    // User opened many accounts
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'opened_by');
    }

    // User performed many transactions
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'performed_by');
    }

    // User issued many cards
    public function issuedCards(): HasMany
    {
        return $this->hasMany(Card::class, 'issued_by');
    }

    // User disbursed many loans
    public function loansDisbursed(): HasMany
    {
        return $this->hasMany(Loan::class, 'disbursed_by');
    }

    /**
     * Helper methods
     */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // Scope for active users
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for specific role
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}
