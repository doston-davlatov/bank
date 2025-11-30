<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'account_id',           // qaysi hisobga bog‘langan
        'customer_id',          // mijoz
        'issued_by',            // kim chiqarildi (xodim)
        'card_type',            // UZCARD, HUMO, VISA, MASTERCARD
        'card_product',         // Classic, Gold, Platinum, Virtual, Business
        'first_6',              // karta birinchi 6 raqam
        'last_4',               // karta oxirgi 4 raqam
        'masked_number',        // maskalangan raqam
        'card_holder_name',     // karta egasi nomi
        'expiry_date',          // amal qilish muddati
        'token',                // PSP token
        'is_primary',           // asosiy yoki qo‘shimcha
        'is_active',            // faol yoki faol emas
        'issued_at',            // chiqarilgan sana
        'blocked_at'            // bloklangan sana
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'expiry_date' => 'date',
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'issued_at' => 'datetime',
        'blocked_at' => 'datetime',
    ];

    /**
     * Allowed enums
     */
    public const CARD_TYPES = ['UZCARD', 'HUMO', 'VISA', 'MASTERCARD'];
    public const CARD_PRODUCTS = ['Classic', 'Gold', 'Platinum', 'Virtual', 'Business'];

    /**
     * Relationships
     */

    // Card belongs to Account
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Card belongs to Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Card issued by a User
    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Scopes
     */

    // Faol kartalar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Asosiy kartalar
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Karta turi bo‘yicha filter
    public function scopeType($query, string $type)
    {
        if (in_array($type, self::CARD_TYPES)) {
            return $query->where('card_type', $type);
        }
        return $query;
    }

    // Karta product bo‘yicha filter
    public function scopeProduct($query, string $product)
    {
        if (in_array($product, self::CARD_PRODUCTS)) {
            return $query->where('card_product', $product);
        }
        return $query;
    }
}
