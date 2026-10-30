<?php

namespace App\Services;

use App\Models\TicketCounter;
use Illuminate\Support\Facades\DB;

/**
 * Membangkitkan kode tiket EKS-YYYY-NNNNNN.
 *
 * Menggunakan tabel penghitung dengan penguncian baris agar aman
 * terhadap race condition saat beberapa OPD mengirim bersamaan.
 * Jangan pernah memakai MAX(kode_tiket) + 1.
 */
class TicketNumberGenerator
{
    public function generate(?int $tahun = null): string
    {
        $tahun ??= (int) now()->format('Y');

        return DB::transaction(function () use ($tahun) {
            $counter = TicketCounter::query()
                ->lockForUpdate()
                ->find($tahun);

            if (! $counter) {
                $counter = TicketCounter::create([
                    'tahun'          => $tahun,
                    'nomor_terakhir' => 0,
                ]);

                $counter = TicketCounter::query()->lockForUpdate()->find($tahun);
            }

            $nomor = $counter->nomor_terakhir + 1;
            $counter->update(['nomor_terakhir' => $nomor]);

            return sprintf(
                '%s-%d-%s',
                config('ekonsul.prefix_tiket', 'EKS'),
                $tahun,
                str_pad((string) $nomor, config('ekonsul.panjang_nomor', 6), '0', STR_PAD_LEFT)
            );
        });
    }
}
