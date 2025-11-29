<?php
// 2. 2025_01_01_000002_create_customers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->generatedAs()->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birth_date');
            $table->string('phone_number', 20)->unique();
            $table->string('email')->unique()->nullable();

            // O‘zbekiston talabi
            $table->char('pinfl', 14)->unique();
            $table->string('passport_series', 2);
            $table->string('passport_number', 7);
            $table->unique(['passport_series', 'passport_number']);

            $table->text('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Indekslar
            $table->index('phone_number');
            $table->index('pinfl');
            $table->index(['passport_series', 'passport_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
