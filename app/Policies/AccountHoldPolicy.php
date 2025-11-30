<?php

namespace App\Policies;

use App\Models\Account_hold;
use App\Models\User;

class AccountHoldPolicy
{
    /**
     * Determine whether the user can view any account holds.
     */
    public function viewAny(User $user): bool
    {
        // Admin va manager barcha yozuvlarni ko‘ra oladi
        return in_array($user->role, ['admin', 'manager']);
    }

    /**
     * Determine whether the user can view a specific account hold.
     */
    public function view(User $user, Account_hold $accountHold): bool
    {
        // Admin va manager barcha yozuvlarni ko‘ra oladi
        if (in_array($user->role, ['admin', 'manager'])) {
            return true;
        }

        // Oddiy foydalanuvchi faqat o‘z yozuvini ko‘rishi mumkin
        return $accountHold->user_id === $user->id;
    }

    /**
     * Determine whether the user can create account holds.
     */
    public function create(User $user): bool
    {
        // Faqat admin va manager yaratishi mumkin
        return in_array($user->role, ['admin', 'manager']);
    }

    /**
     * Determine whether the user can update the account hold.
     */
    public function update(User $user, Account_hold $accountHold): bool
    {
        // Faqat admin yoki yozuv egasi
        return $user->role === 'admin' || $accountHold->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the account hold.
     */
    public function delete(User $user, Account_hold $accountHold): bool
    {
        // Faqat admin o‘chira oladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the account hold.
     */
    public function restore(User $user, Account_hold $accountHold): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the account hold.
     */
    public function forceDelete(User $user, Account_hold $accountHold): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
