<?php

use App\Enums\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket', 20)->unique();
            $table->string('judul', 200);

            $table->foreignId('opd_id')->constrained('opds')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('unit_irban_id')->nullable()
                ->constrained('unit_irbans')->nullOnDelete();

            $table->enum('status', TicketStatus::values())
                ->default(TicketStatus::MENUNGGU_VERIFIKASI->value);
            $table->enum('prioritas', ['rendah', 'normal', 'tinggi'])->default('normal');

            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('last_reply_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'unit_irban_id'], 'tickets_status_irban_index');
            $table->index(['opd_id', 'status'], 'tickets_opd_status_index');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
