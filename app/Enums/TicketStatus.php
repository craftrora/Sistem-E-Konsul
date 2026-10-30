<?php

namespace App\Enums;

enum TicketStatus: string
{
    case MENUNGGU_VERIFIKASI  = 'menunggu_verifikasi';
    case DIPROSES             = 'diproses';
    case SUDAH_DIJAWAB        = 'sudah_dijawab';
    case MENUNGGU_BALASAN_OPD = 'menunggu_balasan_opd';
    case SELESAI              = 'selesai';

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU_VERIFIKASI  => 'Menunggu Verifikasi',
            self::DIPROSES             => 'Diproses',
            self::SUDAH_DIJAWAB        => 'Sudah Dijawab',
            self::MENUNGGU_BALASAN_OPD => 'Menunggu Balasan OPD',
            self::SELESAI              => 'Selesai',
        };
    }

    /** Kelas badge Bootstrap 5 */
    public function badge(): string
    {
        return match ($this) {
            self::MENUNGGU_VERIFIKASI  => 'bg-secondary',
            self::DIPROSES             => 'bg-warning text-dark',
            self::SUDAH_DIJAWAB        => 'bg-info text-dark',
            self::MENUNGGU_BALASAN_OPD => 'bg-primary',
            self::SELESAI              => 'bg-success',
        };
    }

    /** Transisi status yang diizinkan */
    public function allowedTransitions(): array
    {
        return match ($this) {
            // MENUNGGU_VERIFIKASI dipertahankan untuk kompatibilitas data lama
            self::MENUNGGU_VERIFIKASI  => [self::DIPROSES],
            self::DIPROSES             => [self::SUDAH_DIJAWAB, self::MENUNGGU_BALASAN_OPD, self::SELESAI],
            self::SUDAH_DIJAWAB        => [self::MENUNGGU_BALASAN_OPD, self::SELESAI],
            self::MENUNGGU_BALASAN_OPD => [self::DIPROSES, self::SUDAH_DIJAWAB, self::SELESAI],
            self::SELESAI              => [self::DIPROSES],
        };
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }

    /** Tiket terkunci: tidak dapat dibalas oleh siapa pun */
    public function isLocked(): bool
    {
        return $this === self::SELESAI;
    }

    /** Status yang dihitung sebagai tiket aktif di dashboard Irban */
    public static function aktif(): array
    {
        return [self::DIPROSES, self::SUDAH_DIJAWAB, self::MENUNGGU_BALASAN_OPD];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
