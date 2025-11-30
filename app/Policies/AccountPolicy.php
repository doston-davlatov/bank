<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;

class AccountPolicy
{
    public function view(User $user, Account $account): bool
    {
        return $user->hasRole(['admin', 'accountant']) || $user->id === $account->opened_by;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'accountant']);
    }

    public function update(User $user, Account $account): bool
    {
        return $user->hasRole(['admin', 'accountant']);
    }

    public function delete(User $user, Account $account): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Account $account): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Account $account): bool
    {
        return $user->hasRole('admin');
    }
}
