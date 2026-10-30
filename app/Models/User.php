<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'opd_id',
        'unit_irban_id',
        'no_wa',
        'jabatan',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
            'role'              => RoleEnum::class,
            'is_active'         => 'boolean',
        ];
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class);
    }

    public function unitIrban(): BelongsTo
    {
        return $this->belongsTo(UnitIrban::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ADMIN;
    }

    public function isIrban(): bool
    {
        return $this->role === RoleEnum::IRBAN;
    }

    public function isOpd(): bool
    {
        return $this->role === RoleEnum::OPD;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeRole(Builder $query, RoleEnum $role): Builder
    {
        return $query->where('role', $role->value);
    }

    /** Nomor WhatsApp tujuan notifikasi: nomor pribadi, fallback ke nomor OPD */
    public function nomorNotifikasi(): ?string
    {
        return $this->no_wa ?: $this->opd?->no_wa;
    }
}
