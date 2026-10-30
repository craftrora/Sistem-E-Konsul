<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'aksi',
        'model_type',
        'model_id',
        'nilai_lama',
        'nilai_baru',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'nilai_lama' => 'array',
            'nilai_baru' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
