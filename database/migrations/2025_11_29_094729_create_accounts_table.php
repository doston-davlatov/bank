<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('customer_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignUuid('branch_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->foreignUuid('opened_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->string('account_number', 20)->unique();
            $table->string('currency_code', 3)->default('UZS');

            // Enum o‘rniga check constraint (faqat MySQL/PostgreSQL uchun ishlaydi, SQLite uchun o‘chiriladi)
            $table->string('account_type')
                ->default('current')
                ->comment('current, savings, card, loan');

            $table->string('status')
                ->default('active')
                ->comment('active, frozen, closed, dormant');

            // Pul maydonlari
            $table->decimal('balance', 18, 2)->default(0);
            $table->decimal('available_balance', 18, 2)->default(0);

            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();

            $table->softDeletes();           // deleted_at
            $table->timestamps();            // created_at, updated_at
        });

        // Agar SQLite bo‘lmasa, check constraint qo‘shish
        if (config('database.default') !== 'sqlite') {
            Schema::table('accounts', function (Blueprint $table) {
                $table->check('balance >= 0');
                $table->check('available_balance >= 0');

                $table->check("account_type IN ('current', 'savings', 'card', 'loan')");
                $table->check("status IN ('active', 'frozen', 'closed', 'dormant')");
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
