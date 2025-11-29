<?php
// 6. 2025_01_01_000006_create_loans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->generatedAs()->primary();
            $table->uuid('customer_id');
            $table->uuid('account_id')->nullable(); // kredit hisobi
            $table->uuid('branch_id');
            $table->uuid('disbursed_by')->nullable();
            $table->uuid('disbursement_transaction_id')->nullable();

            $table->string('loan_type');
            $table->decimal('principal_amount', 20, 4);
            $table->decimal('interest_rate', 8, 4);
            $table->integer('term_months');
            $table->decimal('monthly_payment', 20, 4);
            $table->decimal('remaining_principal', 20, 4);
            $table->date('disbursed_at');
            $table->date('next_payment_date');
            $table->integer('overdue_days')->default(0);
            $table->enum('status', ['active', 'closed', 'overdue', 'written_off'])->default('active');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('restrict');
            $table->foreign('disbursed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('disbursement_transaction_id')->references('id')->on('transactions')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
