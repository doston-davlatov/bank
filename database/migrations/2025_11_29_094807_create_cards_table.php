<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary(); // yoki $table->uuid('id')->generatedAs()->primary();

            // Account va Customer → UUID bo‘lgani uchun foreignUuid
            $table->foreignUuid('account_id')
                ->constrained('accounts')
                ->onDelete('cascade');

            $table->foreignUuid('customer_id')
                ->constrained('customers')
                ->onDelete('cascade');

            // issued_by → users.id → bigIncrements(), shuning uchun foreignId
            $table->foreignId('issued_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            // Karta ma'lumotlari
            $table->enum('card_type', ['UZCARD', 'HUMO', 'VISA', 'MASTERCARD']);
            $table->enum('card_product', ['Classic', 'Gold', 'Platinum', 'Virtual', 'Business']);

            $table->char('first_6', 6);
            $table->char('last_4', 4);
            $table->string('masked_number', 30); // 8600 **** **** 1234
            $table->string('card_holder_name');
            $table->date('expiry_date');

            $table->string('token')->unique()->nullable(); // PSP token
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamp('issued_at')->useCurrent();
            $table->timestamp('blocked_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Indekslar
            $table->index('customer_id');
            $table->index('masked_number');
            $table->index(['account_id', 'is_active']);
            $table->index('is_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
