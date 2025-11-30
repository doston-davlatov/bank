<?php

namespace App\Policies;

use App\Models\User;
use App\Models\transaction;

class TransactionPolicy
{
    /**
     * Determine whether the user can view any transactions.
     */
    public function viewAny(User $user): bool
    {
        // Admin va buxgalteriya barcha tranzaksiyalarni ko‘ra oladi
        return in_array($user->role, ['admin', 'accountant']);
    }

    /**
     * Determine whether the user can view a specific transaction.
     */
    public function view(User $user, transaction $transaction): bool
    {
        // Admin va buxgalteriya barcha tranzaksiyalarni ko‘radi
        // Oddiy foydalanuvchi faqat o‘z hisobidagi tranzaksiyalarni ko‘radi
        return in_array($user->role, ['admin', 'accountant'])
            || $user->id === $transaction->performed_by;
    }

    /**
     * Determine whether the user can create a transaction.
     */
    public function create(User $user): bool
    {
        // Faqat admin, buxgalteriya va kassir yangi tranzaksiya yaratishi mumkin
        return in_array($user->role, ['admin', 'accountant', 'cashier']);
    }

    /**
     * Determine whether the user can update a transaction.
     */
    public function update(User $user, transaction $transaction): bool
    {
        // Faqat admin va buxgalteriya tranzaksiyani o‘zgartirishi mumkin
        return in_array($user->role, ['admin', 'accountant']);
    }

    /**
     * Determine whether the user can delete a transaction.
     */
    public function delete(User $user, transaction $transaction): bool
    {
        // Faqat admin tranzaksiyani o‘chira oladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore a transaction.
     */
    public function restore(User $user, transaction $transaction): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete a transaction.
     */
    public function forceDelete(User $user, transaction $transaction): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
