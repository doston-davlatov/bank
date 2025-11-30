<?php

namespace App\Policies;

use App\Models\Loan_payment;
use App\Models\User;

class LoanPaymentPolicy
{
    /**
     * Determine whether the user can view any loan payments.
     */
    public function viewAny(User $user): bool
    {
        // Admin va kredit bo‘limi barcha to‘lovlarni ko‘ra oladi
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can view a specific loan payment.
     */
    public function view(User $user, Loan_payment $loanPayment): bool
    {
        // Admin va kredit bo‘limi barcha to‘lovlarni ko‘ra oladi
        // Oddiy foydalanuvchi faqat o‘zining kredit to‘lovlarini ko‘ra oladi
        return in_array($user->role, ['admin', 'loan_officer'])
            || $user->id === $loanPayment->loan->customer->user_id;
    }

    /**
     * Determine whether the user can create a loan payment.
     */
    public function create(User $user): bool
    {
        // Faqat admin va kredit bo‘limi to‘lov yaratishi mumkin
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can update the loan payment.
     */
    public function update(User $user, Loan_payment $loanPayment): bool
    {
        // Faqat admin va kredit bo‘limi o‘zgartirishi mumkin
        return in_array($user->role, ['admin', 'loan_officer']);
    }

    /**
     * Determine whether the user can delete the loan payment.
     */
    public function delete(User $user, Loan_payment $loanPayment): bool
    {
        // Faqat admin o‘chira oladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the loan payment.
     */
    public function restore(User $user, Loan_payment $loanPayment): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the loan payment.
     */
    public function forceDelete(User $user, Loan_payment $loanPayment): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
