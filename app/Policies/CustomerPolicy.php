<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any customers.
     */
    public function viewAny(User $user): bool
    {
        // Admin va support barcha mijozlarni ko‘ra oladi
        return in_array($user->role, ['admin', 'support']);
    }

    /**
     * Determine whether the user can view a specific customer.
     */
    public function view(User $user, Customer $customer): bool
    {
        // Admin yoki support barcha mijozlarni ko‘ra oladi
        // Oddiy foydalanuvchi faqat o‘z mijozini ko‘ra oladi (agar foydalanuvchi mijoz bo‘lsa)
        return $user->role === 'admin'
            || $user->role === 'support'
            || $user->id === $customer->user_id;
    }

    /**
     * Determine whether the user can create a customer.
     */
    public function create(User $user): bool
    {
        // Admin va support yangi mijoz yaratishi mumkin
        return in_array($user->role, ['admin', 'support']);
    }

    /**
     * Determine whether the user can update the customer.
     */
    public function update(User $user, Customer $customer): bool
    {
        // Admin va support mijoz ma’lumotlarini o‘zgartirishi mumkin
        return in_array($user->role, ['admin', 'support']);
    }

    /**
     * Determine whether the user can delete the customer.
     */
    public function delete(User $user, Customer $customer): bool
    {
        // Faqat admin mijozni o‘chira oladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the customer.
     */
    public function restore(User $user, Customer $customer): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the customer.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
