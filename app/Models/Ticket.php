<?php

namespace App\Models;

use App\Enums\MessageType;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_tiket',
        'judul',
        'opd_id',
        'created_by',
        'category_id',
        'unit_irban_id',
        'status',
        'prioritas',
        'verified_by',
        'verified_at',
        'closed_by',
        'closed_at',
        'last_reply_at',
    ];

    protected function casts(): array
    {
        return [
            'status'        => TicketStatus::class,
            'verified_at'   => 'datetime',
            'closed_at'     => 'datetime',
            'last_reply_at' => 'datetime',
        ];
    }

    /** Route model binding memakai kode tiket, bukan id */
    public function getRouteKeyName(): string
    {
        return 'kode_tiket';
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unitIrban(): BelongsTo
    {
        return $this->belongsTo(UnitIrban::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function closer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class)->orderBy('created_at');
    }

    /** Pesan yang boleh dilihat OPD (tanpa catatan internal) */
    public function publicMessages(): HasMany
    {
        return $this->messages()->where('tipe', '!=', MessageType::CATATAN_INTERNAL->value);
    }

    public function pertanyaanAwal(): HasOne
    {
        return $this->hasOne(TicketMessage::class)
            ->where('tipe', MessageType::PERTANYAAN->value)
            ->oldestOfMany();
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(TicketStatusLog::class)->latest('created_at');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(WaNotification::class);
    }

    /**
     * Pembatasan visibilitas data (AB-02, AB-03, AB-04).
     * Selalu pakai scope ini di controller Irban dan OPD.
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isOpd()) {
            return $query->where('opd_id', $user->opd_id);
        }

        return $query
            ->where('unit_irban_id', $user->unit_irban_id)
            ->where('status', '!=', TicketStatus::MENUNGGU_VERIFIKASI->value);
    }

    public function scopeStatus(Builder $query, TicketStatus|array $status): Builder
    {
        $values = is_array($status)
            ? array_map(fn (TicketStatus $s) => $s->value, $status)
            : [$status->value];

        return $query->whereIn('status', $values);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('kode_tiket', 'like', "%{$term}%")
              ->orWhere('judul', 'like', "%{$term}%");
        });
    }

    public function isLocked(): bool
    {
        return $this->status->isLocked();
    }

    public function belumDiverifikasi(): bool
    {
        return $this->status === TicketStatus::MENUNGGU_VERIFIKASI;
    }
}
