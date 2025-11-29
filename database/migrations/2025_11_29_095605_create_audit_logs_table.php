<?php
// 10. 2025_01_01_000010_create_audit_logs_table.php  // Markaziy Bank talabi!
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->generatedAs()->primary();
            $table->uuid('user_id')->nullable();
            $table->string('table_name', 50);
            $table->uuid('record_id');
            $table->string('action', 20); // created, updated, deleted, login, etc.
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['table_name', 'record_id']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
};
