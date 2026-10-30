<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_message_id')->constrained('ticket_messages')->cascadeOnDelete();
            $table->string('nama_asli', 255);
            $table->string('path', 255)->comment('Lokasi di disk private, bukan public');
            $table->string('mime_type', 100);
            $table->unsignedInteger('ukuran')->comment('Dalam byte');
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
