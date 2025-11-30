<?php

namespace App\Policies;

use App\Models\Loan_schedul;
use App\Models\User;

class LoanSchedulPolicy
{
    /**
     * Determine whether the user can view any loan schedules.
     */
    public function viewAny(User $user): bool
    {
        // Admin va kredit bo‘limi barcha jadvalni ko‘ra oladi
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can view a specific loan schedule.
     */
    public function view(User $user, Loan_schedul $loanSchedul): bool
    {
        // Admin va kredit bo‘limi barcha jadvalni ko‘radi
        // Oddiy foydalanuvchi faqat o‘z kredit jadvalini ko‘radi
        return in_array($user->role, ['admin', 'loan_officer'])
            || $user->id === $loanSchedul->loan->customer->user_id;
    }

    /**
     * Determine whether the user can create a loan schedule.
     */
    public function create(User $user): bool
    {
        // Faqat admin va kredit bo‘limi yangi jadval yaratishi mumkin
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can update the loan schedule.
     */
    public function update(User $user, Loan_schedul $loanSchedul): bool
    {
        // Faqat admin va kredit bo‘limi jadvalni o‘zgartirishi mumkin
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can delete the loan schedule.
     */
    public function delete(User $user, Loan_schedul $loanSchedul): bool
    {
        // Faqat admin o‘chira oladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the loan schedule.
     */
    public function restore(User $user, Loan_schedul $loanSchedul): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the loan schedule.
     */
    public function forceDelete(User $user, Loan_schedul $loanSchedul): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
