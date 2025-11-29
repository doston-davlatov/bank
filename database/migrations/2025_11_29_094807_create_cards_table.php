<?php
// 4. 2025_01_01_000004_create_cards_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->generatedAs()->primary();
            $table->uuid('account_id');
            $table->uuid('customer_id');           // Qo‘shimcha karta bo‘lsa ham mijozga to‘g‘ridan bog‘lanadi
            $table->uuid('issued_by')->nullable(); // xodim

            $table->enum('card_type', ['UZCARD', 'HUMO', 'VISA', 'MASTERCARD']);
            $table->enum('card_product', ['Classic', 'Gold', 'Platinum', 'Virtual', 'Business']);
            $table->char('first_6', 6);
            $table->char('last_4', 4);
            $table->string('masked_number');       // 8600 **** **** 1234
            $table->string('card_holder_name');
            $table->date('expiry_date');
            $table->string('token')->unique()->nullable(); // PSP token (Payme, CloudPayments)
            $table->boolean('is_primary')->default(false); // asosiy yoki qo‘shimcha karta
            $table->boolean('is_active')->default(true);
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamp('blocked_at')->nullable();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();

            $table->index('customer_id');
            $table->index('masked_number');
            $table->index(['account_id', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
