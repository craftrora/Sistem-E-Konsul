<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'tipe',
        'isi',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'tipe'    => MessageType::class,
            'read_at' => 'datetime',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function scopeVisibleToOpd(Builder $query): Builder
    {
        return $query->where('tipe', '!=', MessageType::CATATAN_INTERNAL->value);
    }

    public function isInternal(): bool
    {
        return $this->tipe === MessageType::CATATAN_INTERNAL;
    }

    public function markAsRead(): void
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => now()])->save();
        }
    }
}
