<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('debit_account_id')->nullable();
            $table->uuid('credit_account_id')->nullable();
            $table->uuid('debit_card_id')->nullable();
            $table->uuid('credit_card_id')->nullable();
            $table->uuid('debit_customer_id')->nullable();
            $table->uuid('credit_customer_id')->nullable();

            $table->decimal('amount', 20, 4);
            $table->string('currency_code', 3)->default('UZS');
            $table->decimal('exchange_rate', 16, 8)->nullable();

            $table->enum('transaction_type', [
                'transfer', 'p2p', 'payment', 'deposit', 'withdrawal',
                'fee', 'reversal', 'loan_disbursement', 'loan_payment',
                'refund', 'salary', 'cashback'
            ]);

            $table->string('reference_number')->unique();
            $table->string('idempotency_key')->unique();
            $table->text('description')->nullable();

            $table->string('counterparty_name')->nullable();
            $table->string('counterparty_account')->nullable();
            $table->string('counterparty_bank')->nullable();

            $table->enum('status', ['pending', 'success', 'failed', 'reversed', 'cancelled'])
                ->default('pending');

            $table->timestamp('executed_at')->nullable();
            $table->uuid('performed_by')->nullable();
            $table->uuid('branch_id')->nullable();
            $table->uuid('loan_id')->nullable();
            $table->string('channel', 20)->default('web');

            $table->timestamps();

            // Foreign keys
            $table->foreign('debit_account_id')->references('id')->on('accounts')->onDelete('restrict');
            $table->foreign('credit_account_id')->references('id')->on('accounts')->onDelete('restrict');
            $table->foreign('debit_card_id')->references('id')->on('cards')->onDelete('set null');
            $table->foreign('credit_card_id')->references('id')->on('cards')->onDelete('set null');
            $table->foreign('debit_customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('credit_customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('set null');

            // Indekslar
            $table->index(['executed_at', 'status']);
            $table->index('reference_number');
            $table->index('idempotency_key');
            $table->index('debit_customer_id');
            $table->index('credit_customer_id');
        });

        // CHECK constraint faqat SQLite bo‘lmagan hollarda qo‘shiladi
        if (config('database.default') !== 'sqlite') {
            Schema::table('transactions', function (Blueprint $table) {
                $table->check('amount > 0');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
