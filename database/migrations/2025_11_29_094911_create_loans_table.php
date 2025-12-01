<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // UUID bo‘lgan jadvallar → foreignUuid
            $table->foreignUuid('customer_id')
                ->constrained('customers')
                ->onDelete('cascade');

            $table->foreignUuid('account_id')
                ->nullable()
                ->constrained('accounts')
                ->onDelete('set null');

            $table->foreignUuid('branch_id')
                ->constrained('branches')
                ->onDelete('restrict');

            // disbursement_transaction_id → transactions.id → UUID
            $table->foreignUuid('disbursement_transaction_id')
                ->nullable()
                ->constrained('transactions')
                ->onDelete('set null');

            // disbursed_by → users.id → bigIncrements → BIGINT UNSIGNED
            $table->foreignId('disbursed_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');


            // Kredit ma'lumotlari
            $table->string('loan_type', 50); // consumer, mortgage, auto, etc.
            $table->decimal('principal_amount', 20, 4);
            $table->decimal('interest_rate', 8, 4); // yillik foiz
            $table->integer('term_months');
            $table->decimal('monthly_payment', 20, 4);
            $table->decimal('remaining_principal', 20, 4);

            $table->date('disbursed_at')->nullable();
            $table->date('next_payment_date')->nullable();
            $table->integer('overdue_days')->default(0);

            $table->enum('status', ['applied', 'approved', 'disbursed', 'active', 'closed', 'overdue', 'written_off'])
                ->default('applied');

            $table->softDeletes();
            $table->timestamps();

            // Indekslar
            $table->index(['customer_id', 'status']);
            $table->index('disbursed_at');
            $table->index('next_payment_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
