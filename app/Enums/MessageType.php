<?php

namespace App\Enums;

enum MessageType: string
{
    case PERTANYAAN       = 'pertanyaan';
    case JAWABAN          = 'jawaban';
    case BALASAN          = 'balasan';
    case CATATAN_INTERNAL = 'catatan_internal';

    public function label(): string
    {
        return match ($this) {
            self::PERTANYAAN       => 'Pertanyaan',
            self::JAWABAN          => 'Jawaban Irban',
            self::BALASAN          => 'Balasan',
            self::CATATAN_INTERNAL => 'Catatan Internal',
        };
    }

    /** Catatan internal tidak pernah ditampilkan kepada OPD */
    public function isVisibleToOpd(): bool
    {
        return $this !== self::CATATAN_INTERNAL;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
