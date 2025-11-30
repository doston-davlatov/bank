<?php

namespace App\Policies;

use App\Models\Audit_log;
use App\Models\User;

class AuditLogPolicy
{
    /**
     * Determine whether the user can view any audit logs.
     */
    public function viewAny(User $user): bool
    {
        // Faqat admin va auditorlar barcha loglarni ko‘ra oladi
        return in_array($user->role, ['admin', 'auditor']);
    }

    /**
     * Determine whether the user can view a specific audit log.
     */
    public function view(User $user, Audit_log $auditLog): bool
    {
        // Admin va auditorlar barcha loglarni ko‘rishi mumkin
        return in_array($user->role, ['admin', 'auditor']);
    }

    /**
     * Determine whether the user can create audit logs.
     */
    public function create(User $user): bool
    {
        // Audit log odatda avtomatik yaratiladi, foydalanuvchi qo‘lda yaratmaydi
        return false;
    }

    /**
     * Determine whether the user can update the audit log.
     */
    public function update(User $user, Audit_log $auditLog): bool
    {
        // Audit logni o‘zgartirish taqiqlangan
        return false;
    }

    /**
     * Determine whether the user can delete the audit log.
     */
    public function delete(User $user, Audit_log $auditLog): bool
    {
        // Audit logni o‘chirish ham faqat admin tomonidan ruxsat beriladi
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the audit log.
     */
    public function restore(User $user, Audit_log $auditLog): bool
    {
        // Faqat admin tiklashi mumkin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the audit log.
     */
    public function forceDelete(User $user, Audit_log $auditLog): bool
    {
        // Faqat admin doimiy o‘chira oladi
        return $user->role === 'admin';
    }
}
