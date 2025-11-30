<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;

class CardPolicy
{
    /**
     * Determine whether the user can view any cards.
     */
    public function viewAny(User $user): bool
    {
        // Admin barcha kartalarni ko‘ra oladi, foydalanuvchilar faqat o‘zlari
        return in_array($user->role, ['admin', 'support']);
    }

    /**
     * Determine whether the user can view a specific card.
     */
    public function view(User $user, Card $card): bool
    {
        // Admin yoki karta egasi
        return $user->role === 'admin' || $card->customer_id === $user->id;
    }

    /**
     * Determine whether the user can create a card.
     */
    public function create(User $user): bool
    {
        // Admin va bank xodimi (support) karta yaratishi mumkin
        return in_array($user->role, ['admin', 'support']);
    }

    /**
     * Determine whether the user can update the card.
     */
    public function update(User $user, Card $card): bool
    {
        // Admin yoki karta egasi faqat faollik holatini o‘zgartirishi mumkin
        return $user->role === 'admin' || $card->customer_id === $user->id;
    }

    /**
     * Determine whether the user can delete the card.
     */
    public function delete(User $user, Card $card): bool
    {
        // Faqat admin karta o‘chirishi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the card.
     */
    public function restore(User $user, Card $card): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the card.
     */
    public function forceDelete(User $user, Card $card): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
