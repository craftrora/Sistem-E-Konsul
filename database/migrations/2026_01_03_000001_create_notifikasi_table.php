<?php

use App\Enums\NotifType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()
                ->comment('Penerima notifikasi');
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->cascadeOnDelete();
            $table->enum('tipe', NotifType::values());
            $table->string('judul', 150);
            $table->string('pesan', 255);
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'dibaca_pada'], 'notif_user_dibaca_index');
            $table->index(['user_id', 'created_at'], 'notif_user_waktu_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
