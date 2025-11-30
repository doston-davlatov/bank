<?php

namespace App\Policies;

use App\Models\Branche;
use App\Models\User;

class BranchePolicy
{
    /**
     * Determine whether the user can view any branches.
     */
    public function viewAny(User $user): bool
    {
        // Admin va branch manager barcha filiallarni ko‘ra oladi
        return in_array($user->role, ['admin', 'branch_manager']);
    }

    /**
     * Determine whether the user can view a specific branch.
     */
    public function view(User $user, Branche $branche): bool
    {
        // Admin barcha filiallarni ko‘rishi mumkin, branch manager faqat o‘z filiali
        return $user->role === 'admin' || ($user->role === 'branch_manager' && $user->branch_id === $branche->id);
    }

    /**
     * Determine whether the user can create a branch.
     */
    public function create(User $user): bool
    {
        // Faqat admin filial qo‘shishi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the branch.
     */
    public function update(User $user, Branche $branche): bool
    {
        // Admin hamma filialni, branch manager faqat o‘z filiali
        return $user->role === 'admin' || ($user->role === 'branch_manager' && $user->branch_id === $branche->id);
    }

    /**
     * Determine whether the user can delete the branch.
     */
    public function delete(User $user, Branche $branche): bool
    {
        // Faqat admin filialni o‘chira oladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the branch.
     */
    public function restore(User $user, Branche $branche): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the branch.
     */
    public function forceDelete(User $user, Branche $branche): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
