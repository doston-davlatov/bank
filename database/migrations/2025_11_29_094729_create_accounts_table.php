<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Agar jadval allaqachon mavjud bo‘lsa, qayta yaratmaymiz (migrate:fresh dan keyin ham ishlaydi)
        if (Schema::hasTable('accounts')) {
            // Agar jadval bor, lekin migratsiya hali "bajarilmagan" deb hisoblanayotgan bo‘lsa
            // uni migrations jadvaliga qo‘shib qo‘yamiz
            $this->markAsMigrated();
            return;
        }

        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('customer_id')
                ->constrained('customers')  // customers jadvali bor deb faraz qilyapmiz
                ->onDelete('cascade');

            $table->foreignUuid('branch_id')
                ->nullable()
                ->constrained('branches')
                ->onDelete('set null');

            $table->foreignId('opened_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->string('account_number', 20)->unique();
            $table->string('currency_code', 3)->default('UZS');

            $table->string('account_type', 20)->default('current')
                ->comment('current, savings, card, loan');

            $table->string('status', 20)->default('active')
                ->comment('active, frozen, closed, dormant');

            $table->decimal('balance', 18, 2)->default(0);
            $table->decimal('available_balance', 18, 2)->default(0);

            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // MySQL va PostgreSQL uchun CHECK constraint (SQLite bu sintaksisni qo‘llab-quvvatlamaydi)
        $connection = config('database.default');
        if (in_array($connection, ['mysql', 'pgsql'])) {
            DB::statement("ALTER TABLE accounts ADD CONSTRAINT chk_account_type CHECK (account_type IN ('current', 'savings', 'card', 'loan'))");
            DB::statement("ALTER TABLE accounts ADD CONSTRAINT chk_status CHECK (status IN ('active', 'frozen', 'closed', 'dormant'))");
            DB::statement("ALTER TABLE accounts ADD CONSTRAINT chk_positive_balance CHECK (balance >= 0)");
            DB::statement("ALTER TABLE accounts ADD CONSTRAINT chk_positive_available CHECK (available_balance >= 0)");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }

    /**
     * Agar jadval bor bo‘lsa, lekin migrations jadvalida yo‘q bo‘lsa — uni qo‘shib qo‘yish
     */
    private function markAsMigrated(): void
    {
        $migrationName = '2025_11_29_094729_create_accounts_table';
        $exists = DB::table('migrations')->where('migration', $migrationName)->exists();

        if (!$exists) {
            $batch = DB::table('migrations')->max('batch') + 1 ?? 1;
            DB::table('migrations')->insert([
                'migration' => $migrationName,
                'batch'     => $batch,
            ]);
        }
    }
};
