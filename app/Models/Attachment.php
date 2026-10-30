<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_message_id',
        'nama_asli',
        'path',
        'mime_type',
        'ukuran',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return ['ukuran' => 'integer'];
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(TicketMessage::class, 'ticket_message_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUkuranTerbacaAttribute(): string
    {
        $bytes = $this->ukuran;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }

    public function getIkonAttribute(): string
    {
        return match (true) {
            str_contains($this->mime_type, 'pdf')        => 'bi-file-earmark-pdf',
            str_contains($this->mime_type, 'word')       => 'bi-file-earmark-word',
            str_contains($this->mime_type, 'sheet'),
            str_contains($this->mime_type, 'excel')      => 'bi-file-earmark-excel',
            str_starts_with($this->mime_type, 'image/')  => 'bi-file-earmark-image',
            default                                      => 'bi-file-earmark',
        };
    }
}
