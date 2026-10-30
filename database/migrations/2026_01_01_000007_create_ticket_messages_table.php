<?php

use App\Enums\MessageType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->enum('tipe', MessageType::values());
            $table->text('isi');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['ticket_id', 'created_at'], 'messages_ticket_created_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
    }
};
