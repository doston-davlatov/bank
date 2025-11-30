<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branche extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'code',       // filial kodi (unique)
        'name_uz',    // nomi o‘zbekcha
        'name_ru',    // nomi ruscha
        'name_en',    // nomi inglizcha
        'address',    // manzil
        'phone',      // telefon raqam
        'is_active',  // faol yoki faol emas
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */

    // Branch has many Accounts
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    // Branch has many Users (xodimlar)
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Branch has many Loans
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Scopes
     */

    // Faol filiallar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Kod orqali filial qidirish
    public function scopeCode($query, string $code)
    {
        return $query->where('code', $code);
    }
}
