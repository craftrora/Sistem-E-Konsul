<?php

use App\Enums\RoleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', RoleEnum::values())->default(RoleEnum::OPD->value)->after('password');
            $table->foreignId('opd_id')->nullable()->after('role')
                ->constrained('opds')->nullOnDelete();
            $table->foreignId('unit_irban_id')->nullable()->after('opd_id')
                ->constrained('unit_irbans')->nullOnDelete();
            $table->string('no_wa', 20)->nullable()->after('unit_irban_id');
            $table->string('jabatan', 100)->nullable()->after('no_wa');
            $table->boolean('is_active')->default(true)->after('jabatan');
            $table->timestamp('last_login_at')->nullable()->after('is_active');

            $table->index(['role', 'is_active'], 'users_role_active_index');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_active_index');
            $table->dropConstrainedForeignId('opd_id');
            $table->dropConstrainedForeignId('unit_irban_id');
            $table->dropColumn(['role', 'no_wa', 'jabatan', 'is_active', 'last_login_at']);
        });
    }
};
