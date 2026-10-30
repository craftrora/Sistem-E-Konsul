<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opd extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_opd',
        'unit_irban_id',
        'nama_opd',
        'alamat',
        'no_wa',
        'kode_pendaftaran',
        'pendaftaran_dibuka',
        'is_active',
    ];

    protected $hidden = [
        'kode_pendaftaran',
    ];

    protected function casts(): array
    {
        return [
            'is_active'          => 'boolean',
            'pendaftaran_dibuka' => 'boolean',
        ];
    }

    public function unitIrban(): BelongsTo
    {
        return $this->belongsTo(UnitIrban::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeMenerimaPendaftaran(Builder $query): Builder
    {
        return $query->where('is_active', true)->where('pendaftaran_dibuka', true);
    }
}
