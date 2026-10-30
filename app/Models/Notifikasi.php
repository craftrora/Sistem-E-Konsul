<?php

namespace App\Models;

use App\Enums\NotifType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'ticket_id',
        'tipe',
        'judul',
        'pesan',
        'dibaca_pada',
    ];

    protected function casts(): array
    {
        return [
            'tipe'        => NotifType::class,
            'dibaca_pada' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function scopeMilik(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeBelumDibaca(Builder $query): Builder
    {
        return $query->whereNull('dibaca_pada');
    }

    public function sudahDibaca(): bool
    {
        return ! is_null($this->dibaca_pada);
    }

    public function tandaiDibaca(): void
    {
        if (is_null($this->dibaca_pada)) {
            $this->forceFill(['dibaca_pada' => now()])->save();
        }
    }

    /**
     * Tautan tujuan saat notifikasi diklik, disesuaikan dengan peran penerima.
     * Bila tiket sudah terhapus, arahkan ke daftar notifikasi.
     */
    public function tautan(): string
    {
        if (! $this->ticket) {
            return route('notifikasi.index');
        }

        return match (true) {
            $this->user->isAdmin() => route('admin.tiket.show', $this->ticket),
            $this->user->isIrban() => route('irban.tiket.show', $this->ticket),
            default                => route('opd.konsultasi.show', $this->ticket),
        };
    }
}
