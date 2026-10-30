<?php

namespace Database\Seeders;

use App\Models\Opd;
use App\Models\UnitIrban;
use Illuminate\Database\Seeder;

/**
 * Daftar resmi 46 Perangkat Daerah dan Kecamatan se-Kabupaten Ngawi,
 * dikelompokkan sesuai wilayah kerja Irban menurut dokumen
 * "Pembagian Wilayah Pengawasan Inspektorat Kabupaten Ngawi Tahun 2026".
 *
 * Nomor WhatsApp masih placeholder — ganti dengan nomor dinas resmi
 * masing-masing OPD sebelum go-live.
 */
class OpdSeeder extends Seeder
{
    public function run(): void
    {
        $wilayah = [
            "IRBAN_1" => [
                ["DISPUSIP",     "Dinas Perpustakaan dan Kearsipan"],
                ["DISPARPORA",   "Dinas Pariwisata, Pemuda dan Olah Raga"],
                ["DLH",          "Dinas Lingkungan Hidup"],
                ["BPBD",         "Badan Penanggulangan Bencana Daerah"],
                ["SETWAN",       "Sekretariat DPRD"],
                ["DISKOMINFO",   "Dinas Komunikasi, Informatika, Statistik dan Persandian"],
                ["SETDA",        "Sekretariat Daerah"],
                ["KEC_PADAS",        "Kecamatan Padas"],
                ["KEC_JOGOROGO",     "Kecamatan Jogorogo"],
                ["KEC_NGAWI",        "Kecamatan Ngawi"],
                ["KEC_KARANGANYAR",  "Kecamatan Karanganyar"],
                ["KEC_PITU",         "Kecamatan Pitu"],
            ],
            "IRBAN_2" => [
                ["SATPOLPP",     "Satuan Polisi Pamong Praja"],
                ["DPMD",         "Dinas Pemberdayaan Masyarakat dan Desa"],
                ["DINKES",       "Dinas Kesehatan"],
                ["DISPERKIM",    "Dinas Perumahan Rakyat dan Kawasan Pemukiman"],
                ["BAKEU",        "Badan Keuangan"],
                ["DISTAPANG",    "Dinas Ketahanan Pangan dan Pertanian"],
                ["RSUD_SOEROTO", "RSUD dr. Soeroto"],
                ["KEC_BRINGIN",      "Kecamatan Bringin"],
                ["KEC_WIDODAREN",    "Kecamatan Widodaren"],
                ["KEC_MANTINGAN",    "Kecamatan Mantingan"],
                ["KEC_KWADUNGAN",    "Kecamatan Kwadungan"],
                ["KEC_KENDAL",       "Kecamatan Kendal"],
            ],
            "IRBAN_3" => [
                ["DP3AKB",       "Dinas Pemberdayaan Perempuan, Perlindungan Anak dan KB"],
                ["BKPSDM",       "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia"],
                ["DISPERINAKER", "Dinas Perdagangan, Perindustrian dan Tenaga Kerja"],
                ["BAPPEDA",      "Badan Perencanaan Pembangunan Daerah"],
                ["DISKANNAK",    "Dinas Perikanan dan Peternakan"],
                ["DISDIKBUD",    "Dinas Pendidikan dan Kebudayaan"],
                ["DISDUKCAPIL",  "Dinas Kependudukan dan Pencatatan Sipil"],
                ["KEC_NGRAMBE",      "Kecamatan Ngrambe"],
                ["KEC_PANGKUR",      "Kecamatan Pangkur"],
                ["KEC_GENENG",       "Kecamatan Geneng"],
                ["KEC_KARANGJATI",   "Kecamatan Karangjati"],
            ],
            "IRBAN_4" => [
                ["BAKESBANGPOL", "Badan Kesatuan Bangsa dan Politik"],
                ["DPMPTSP",      "Dinas Penanaman Modal, Pelayanan Terpadu Satu Pintu"],
                ["DISKOPUKM",    "Dinas Koperasi, Usaha Kecil dan Menengah"],
                ["DISHUB",       "Dinas Perhubungan"],
                ["DINSOS",       "Dinas Sosial"],
                ["DPUPR",        "Dinas Pekerjaan Umum dan Penataan Ruang"],
                ["KEC_SINE",         "Kecamatan Sine"],
                ["KEC_KEDUNGGALAR",  "Kecamatan Kedunggalar"],
                ["KEC_KASREMAN",     "Kecamatan Kasreman"],
                ["KEC_PARON",        "Kecamatan Paron"],
                ["KEC_GERIH",        "Kecamatan Gerih"],
            ],
        ];

        $kodeResmi = [];

        foreach ($wilayah as $kodeIrban => $daftar) {
            $unitIrban = UnitIrban::where("kode", $kodeIrban)->first();

            foreach ($daftar as [$kodeOpd, $namaOpd]) {
                $kodeResmi[] = $kodeOpd;

                Opd::updateOrCreate(
                    ["kode_opd" => $kodeOpd],
                    [
                        "unit_irban_id" => $unitIrban?->id,
                        "nama_opd"      => $namaOpd,
                        "alamat"        => "Kabupaten Ngawi",
                        "no_wa"         => "6280000000000",
                        "is_active"     => true,
                    ]
                );
            }
        }

        // Bersihkan sisa data placeholder lama (mis. dari seeder sebelum
        // daftar 46 OPD resmi ini dipakai) yang kode_opd-nya sudah tidak
        // ada di daftar resmi, supaya tidak dobel di dropdown pendaftaran.
        Opd::whereNotIn("kode_opd", $kodeResmi)->delete();
    }
}
