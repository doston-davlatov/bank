<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('debit_account_id')->nullable()->constrained('accounts')->onDelete('restrict');
            $table->foreignUuid('credit_account_id')->nullable()->constrained('accounts')->onDelete('restrict');
            $table->foreignUuid('debit_card_id')->nullable()->constrained('cards')->onDelete('set null');
            $table->foreignUuid('credit_card_id')->nullable()->constrained('cards')->onDelete('set null');
            $table->foreignUuid('debit_customer_id')->nullable()->constrained('customers')->onDelete('restrict');
            $table->foreignUuid('credit_customer_id')->nullable()->constrained('customers')->onDelete('restrict');
            $table->foreignUuid('branch_id')->nullable()->constrained('branches')->onDelete('set null');

            // performed_by → users.id → bigIncrements
            $table->foreignId('performed_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            // loan_id ni hozircha olib tashlaymiz — keyinroq qo‘shamiz
            // $table->foreignUuid('loan_id')->nullable()->constrained('loans')->onDelete('set null');

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
            $table->string('channel', 20)->default('web');

            $table->timestamps();

            // Indekslar
            $table->index(['executed_at', 'status']);
            $table->index('reference_number');
            $table->index('idempotency_key');
            $table->index('debit_customer_id');
            $table->index('credit_customer_id');
            $table->index('performed_by');
        });

        if (config('database.default') !== 'sqlite') {
            \DB::statement('ALTER TABLE transactions ADD CONSTRAINT chk_amount_positive CHECK (amount > 0)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
