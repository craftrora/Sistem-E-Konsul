<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opds', function (Blueprint $table) {
            $table->id();
            $table->string('kode_opd', 20)->unique();
            $table->string('nama_opd', 150);
            $table->text('alamat')->nullable();
            $table->string('no_wa', 20)->comment('Format 62xxxxxxxxxx');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opds');
    }
};
