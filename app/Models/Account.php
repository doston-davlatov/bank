<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ["account_number", "customer_id", "branch_id", "opened_by", "currency_code", 'account_type' => ['current', 'savings', 'card', 'loan'], "balance", "available_balance", 'status' => ['active', 'frozen', 'closed', 'dormant'], "opened_at", "closed_at"];

    public array $translatable = ["account_number", "customer_id", "branch_id"];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
