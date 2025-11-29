<?php
// 8. 2025_01_01_000008_create_loan_payments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('loan_id');
            $table->uuid('transaction_id')->nullable(); // to‘lov qaysi tranzaksiya orqali
            $table->decimal('amount', 20,4);
            $table->decimal('principal_part', 20,4);
            $table->decimal('interest_part', 20,4);
            $table->decimal('penalty_part', 20,4)->default(0);
            $table->timestamp('payment_date')->useCurrent();
            $table->string('payment_method', 30);

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_payments');
    }
};
