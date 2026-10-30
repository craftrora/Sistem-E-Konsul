<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->foreignId('unit_irban_id')->nullable()->after('kode_opd')
                ->comment('Wilayah kerja Irban sesuai Pembagian Wilayah Pengawasan')
                ->constrained('unit_irbans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unit_irban_id');
        });
    }
};
