<?php

namespace App\Enums;

enum NotifType: string
{
    case DIBUAT        = 'konsultasi_dibuat';
    case DIVERIFIKASI  = 'konsultasi_diverifikasi';
    case DIPROSES      = 'konsultasi_diproses';
    case DIJAWAB       = 'konsultasi_dijawab';
    case BALASAN       = 'balasan_lanjutan';
    case SELESAI       = 'konsultasi_selesai';

    public function label(): string
    {
        return match ($this) {
            self::DIBUAT       => 'Konsultasi Dibuat',
            self::DIVERIFIKASI => 'Konsultasi Diverifikasi',
            self::DIPROSES     => 'Konsultasi Diproses',
            self::DIJAWAB      => 'Konsultasi Dijawab',
            self::BALASAN      => 'Balasan Lanjutan',
            self::SELESAI      => 'Konsultasi Selesai',
        };
    }

    /** Ikon Bootstrap Icons untuk tampilan daftar notifikasi */
    public function ikon(): string
    {
        return match ($this) {
            self::DIBUAT       => 'bi-file-earmark-plus',
            self::DIVERIFIKASI => 'bi-check2-square',
            self::DIPROSES     => 'bi-diagram-3',
            self::DIJAWAB      => 'bi-chat-left-text',
            self::BALASAN      => 'bi-reply',
            self::SELESAI      => 'bi-check2-circle',
        };
    }

    /** Kelas warna latar ikon */
    public function warna(): string
    {
        return match ($this) {
            self::DIBUAT       => 'biru',
            self::DIVERIFIKASI => 'amber',
            self::DIPROSES     => 'ungu',
            self::DIJAWAB      => 'hijau',
            self::BALASAN      => 'biru',
            self::SELESAI      => 'hijau',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
