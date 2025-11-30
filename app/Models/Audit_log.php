<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditLog extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'user_id',          // kim amalga oshirdi
        'auditable_type',   // model nomi (Account, Customer, Card va h.k.)
        'auditable_id',     // modeldagi primary key
        'event',            // created, updated, deleted
        'old_values',       // o‘zgartirishdan oldingi qiymat
        'new_values',       // o‘zgartirishdan keyingi qiymat
        'url',              // qayerdan kelgan request
        'ip_address',       // foydalanuvchi IP
        'user_agent',       // browser/OS
        'tags',             // ixtiyoriy taglar
        'note',             // ixtiyoriy izoh
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'tags' => 'array',
    ];

    /**
     * Relationships
     */

    // Audit log belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Polymorphic relation to auditable models
     */
    public function auditable()
    {
        return $this->morphTo();
    }

    /**
     * Scopes
     */

    // Filter by event type
    public function scopeEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    // Filter by user
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
