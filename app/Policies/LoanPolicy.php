<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    /**
     * Determine whether the user can view any loans.
     */
    public function viewAny(User $user): bool
    {
        // Admin va kredit bo‘limi barcha kreditlarni ko‘ra oladi
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can view a specific loan.
     */
    public function view(User $user, Loan $loan): bool
    {
        // Admin va kredit bo‘limi barcha kreditlarni ko‘ra oladi
        // Oddiy foydalanuvchi faqat o‘z kreditlarini ko‘ra oladi
        return in_array($user->role, ['admin', 'loan_officer'])
            || $user->id === $loan->customer->user_id;
    }

    /**
     * Determine whether the user can create a loan.
     */
    public function create(User $user): bool
    {
        // Faqat admin va kredit bo‘limi yangi kredit yaratishi mumkin
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can update the loan.
     */
    public function update(User $user, Loan $loan): bool
    {
        // Faqat admin va kredit bo‘limi kreditni o‘zgartirishi mumkin
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can delete the loan.
     */
    public function delete(User $user, Loan $loan): bool
    {
        // Faqat admin o‘chira oladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the loan.
     */
    public function restore(User $user, Loan $loan): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the loan.
     */
    public function forceDelete(User $user, Loan $loan): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
