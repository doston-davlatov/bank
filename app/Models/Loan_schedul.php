<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan_schedul extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'loan_id',
        'period',
        'due_date',
        'planned_principal',
        'planned_interest',
        'planned_total',
        'paid_amount',
        'is_paid',
        'paid_at',
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'period' => 'integer',
        'due_date' => 'date',
        'planned_principal' => 'decimal:4',
        'planned_interest' => 'decimal:4',
        'planned_total' => 'decimal:4',
        'paid_amount' => 'decimal:4',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Schedule belongs to a Loan
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Scopes
     */

    // Scope for paid schedules
    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    // Scope for unpaid schedules
    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', false);
    }

    // Scope for a specific period
    public function scopePeriod($query, int $period)
    {
        return $query->where('period', $period);
    }
}
