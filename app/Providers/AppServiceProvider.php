<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Models
use App\Models\Account;
use App\Models\Account_hold;
use App\Models\Audit_log;
use App\Models\Branche;
use App\Models\Card;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\Loan_payment;
use App\Models\Loan_schedul;
use App\Models\transaction;

// Policies
use App\Policies\AccountPolicy;
use App\Policies\AccountHoldPolicy;
use App\Policies\AuditLogPolicy;
use App\Policies\BranchePolicy;
use App\Policies\CardPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\LoanPolicy;
use App\Policies\LoanPaymentPolicy;
use App\Policies\LoanSchedulPolicy;
use App\Policies\TransactionPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // --- Account ---
        Gate::define('account-view', fn(User $user, Account $account) => in_array($user->role, ['admin', 'accountant']) || $user->id === $account->opened_by);
        Gate::define('account-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('account-update', fn(User $user, Account $account) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('account-delete', fn(User $user, Account $account) => in_array($user->role, ['admin']));
        Gate::define('account-restore', fn(User $user, Account $account) => in_array($user->role, ['admin']));
        Gate::define('account-forceDelete', fn(User $user, Account $account) => in_array($user->role, ['admin']));

        // --- Card ---
        Gate::define('card-view', fn(User $user, Card $card) => in_array($user->role, ['admin', 'accountant']) || $user->id === $card->customer_id);
        Gate::define('card-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('card-update', fn(User $user, Card $card) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('card-delete', fn(User $user, Card $card) => in_array($user->role, ['admin']));
        Gate::define('card-restore', fn(User $user, Card $card) => in_array($user->role, ['admin']));
        Gate::define('card-forceDelete', fn(User $user, Card $card) => in_array($user->role, ['admin']));

        // --- Customer ---
        Gate::define('customer-view', fn(User $user, Customer $customer) => in_array($user->role, ['admin', 'accountant']) || $user->id === $customer->id);
        Gate::define('customer-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('customer-update', fn(User $user, Customer $customer) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('customer-delete', fn(User $user, Customer $customer) => in_array($user->role, ['admin']));
        Gate::define('customer-restore', fn(User $user, Customer $customer) => in_array($user->role, ['admin']));
        Gate::define('customer-forceDelete', fn(User $user, Customer $customer) => in_array($user->role, ['admin']));

        // --- Transaction ---
        Gate::define('transaction-view', fn(User $user, Transaction $transaction) => in_array($user->role, ['admin', 'accountant']) || $user->id === $transaction->performed_by);
        Gate::define('transaction-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('transaction-update', fn(User $user, Transaction $transaction) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('transaction-delete', fn(User $user, Transaction $transaction) => in_array($user->role, ['admin']));
        Gate::define('transaction-restore', fn(User $user, Transaction $transaction) => in_array($user->role, ['admin']));
        Gate::define('transaction-forceDelete', fn(User $user, Transaction $transaction) => in_array($user->role, ['admin']));

        // --- Loan ---
        Gate::define('loan-view', fn(User $user, Loan $loan) => in_array($user->role, ['admin', 'accountant']) || $user->id === $loan->customer_id);
        Gate::define('loan-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('loan-update', fn(User $user, Loan $loan) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('loan-delete', fn(User $user, Loan $loan) => in_array($user->role, ['admin']));
        Gate::define('loan-restore', fn(User $user, Loan $loan) => in_array($user->role, ['admin']));
        Gate::define('loan-forceDelete', fn(User $user, Loan $loan) => in_array($user->role, ['admin']));

        // --- Loan Payment ---
        Gate::define('loan-payment-view', fn(User $user, Loan_payment $payment) => in_array($user->role, ['admin', 'accountant']) || $user->id === $payment->customer_id);
        Gate::define('loan-payment-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('loan-payment-update', fn(User $user, Loan_payment $payment) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('loan-payment-delete', fn(User $user, Loan_payment $payment) => in_array($user->role, ['admin']));
        Gate::define('loan-payment-restore', fn(User $user, Loan_payment $payment) => in_array($user->role, ['admin']));
        Gate::define('loan-payment-forceDelete', fn(User $user, Loan_payment $payment) => in_array($user->role, ['admin']));

        // --- Loan Schedule ---
        Gate::define('loan-schedul-view', fn(User $user, Loan_schedul $schedul) => in_array($user->role, ['admin', 'accountant']) || $user->id === $schedul->customer_id);
        Gate::define('loan-schedul-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('loan-schedul-update', fn(User $user, Loan_schedul $schedul) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('loan-schedul-delete', fn(User $user, Loan_schedul $schedul) => in_array($user->role, ['admin']));
        Gate::define('loan-schedul-restore', fn(User $user, Loan_schedul $schedul) => in_array($user->role, ['admin']));
        Gate::define('loan-schedul-forceDelete', fn(User $user, Loan_schedul $schedul) => in_array($user->role, ['admin']));

        // --- Branche ---
        Gate::define('branche-view', fn(User $user, Branche $branche) => in_array($user->role, ['admin', 'manager']));
        Gate::define('branche-create', fn(User $user) => in_array($user->role, ['admin', 'manager']));
        Gate::define('branche-update', fn(User $user, Branche $branche) => in_array($user->role, ['admin', 'manager']));
        Gate::define('branche-delete', fn(User $user, Branche $branche) => in_array($user->role, ['admin']));
        Gate::define('branche-restore', fn(User $user, Branche $branche) => in_array($user->role, ['admin']));
        Gate::define('branche-forceDelete', fn(User $user, Branche $branche) => in_array($user->role, ['admin']));

        // --- Audit Log ---
        Gate::define('audit-log-view', fn(User $user, Audit_log $log) => in_array($user->role, ['admin', 'auditor']));
        Gate::define('audit-log-create', fn(User $user) => in_array($user->role, ['admin']));
        Gate::define('audit-log-update', fn(User $user, Audit_log $log) => in_array($user->role, ['admin']));
        Gate::define('audit-log-delete', fn(User $user, Audit_log $log) => in_array($user->role, ['admin']));
        Gate::define('audit-log-restore', fn(User $user, Audit_log $log) => in_array($user->role, ['admin']));
        Gate::define('audit-log-forceDelete', fn(User $user, Audit_log $log) => in_array($user->role, ['admin']));

        // --- Account Hold ---
        Gate::define('account-hold-view', fn(User $user, Account_hold $hold) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('account-hold-create', fn(User $user) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('account-hold-update', fn(User $user, Account_hold $hold) => in_array($user->role, ['admin', 'accountant']));
        Gate::define('account-hold-delete', fn(User $user, Account_hold $hold) => in_array($user->role, ['admin']));
        Gate::define('account-hold-restore', fn(User $user, Account_hold $hold) => in_array($user->role, ['admin']));
        Gate::define('account-hold-forceDelete', fn(User $user, Account_hold $hold) => in_array($user->role, ['admin']));

        // Policy mapping
        Gate::policy(Account::class, AccountPolicy::class);
        Gate::policy(Account_hold::class, AccountHoldPolicy::class);
        Gate::policy(Audit_log::class, AuditLogPolicy::class);
        Gate::policy(Branche::class, BranchePolicy::class);
        Gate::policy(Card::class, CardPolicy::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Loan::class, LoanPolicy::class);
        Gate::policy(Loan_payment::class, LoanPaymentPolicy::class);
        Gate::policy(Loan_schedul::class, LoanSchedulPolicy::class);
        Gate::policy(transaction::class, TransactionPolicy::class);
    }
}
