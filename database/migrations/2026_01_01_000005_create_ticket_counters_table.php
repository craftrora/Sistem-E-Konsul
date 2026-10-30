<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_counters', function (Blueprint $table) {
            $table->unsignedSmallInteger('tahun')->primary();
            $table->unsignedInteger('nomor_terakhir')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_counters');
    }
};
