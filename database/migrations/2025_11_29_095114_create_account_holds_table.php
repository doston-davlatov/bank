<?php
// 9. 2025_01_01_000009_create_account_holds_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('account_holds', function (Blueprint $table) {
            $table->uuid('id')->generatedAs()->primary();
            $table->uuid('account_id');
            $table->decimal('amount', 20,4);
            $table->string('reason', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->uuid('transaction_id')->nullable();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');

            $table->index(['account_id', 'expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_holds');
    }
};
