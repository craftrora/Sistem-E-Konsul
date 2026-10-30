<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case IRBAN = 'irban';
    case OPD   = 'opd';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::IRBAN => 'Inspektur Pembantu',
            self::OPD   => 'Organisasi Perangkat Daerah',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
