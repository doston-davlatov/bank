<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountHold extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'account_id',
        'amount',
        'reason',
        'placed_by',
        'placed_at',
        'released_at',
        'status', // active / released / cancelled
    ];

    /**
     * Casts
     */
    protected $casts = [
        'amount' => 'decimal:4',
        'placed_at' => 'datetime',
        'released_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Enum values
     */
    public const STATUS_ACTIVE = 'active';
    public const STATUS_RELEASED = 'released';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_RELEASED,
        self::STATUS_CANCELLED,
    ];

    /**
     * Relationships
     */

    // Hold belongs to an Account
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Hold placed by a User
    public function placedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'placed_by');
    }

    /**
     * Scopes
     */

    // Active holds only
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
