<?php
// 7. 2025_01_01_000007_create_loan_schedules_table.php  // Majburiy!
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->uuid('id')->generatedAs()->primary();
            $table->uuid('loan_id');
            $table->integer('period'); // 1, 2, 3 ... oy
            $table->date('due_date');
            $table->decimal('planned_principal', 20,4);
            $table->decimal('planned_interest', 20,4);
            $table->decimal('planned_total', 20,4);
            $table->decimal('paid_amount', 20,4)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['loan_id', 'period']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_schedules');
    }
};
