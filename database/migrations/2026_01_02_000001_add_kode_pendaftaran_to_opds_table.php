<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->string('kode_pendaftaran', 20)->nullable()->after('no_wa')
                ->comment('Kode yang dibagikan sekali kepada OPD untuk pendaftaran mandiri');
            $table->boolean('pendaftaran_dibuka')->default(true)->after('kode_pendaftaran')
                ->comment('Bila false, OPD ini tidak menerima pendaftaran akun baru');
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn(['kode_pendaftaran', 'pendaftaran_dibuka']);
        });
    }
};
