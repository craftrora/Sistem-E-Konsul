<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\UnitIrban;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Kategori konsultasi berdasarkan Ruang Lingkup Irban Wilayah dan Khusus
 * Inspektorat Kabupaten Ngawi 2026.
 *
 * Kolom default_unit_irban_id diisi untuk kategori yang punya Irban spesifik.
 * Kategori tanpa Irban tetap (null) → sistem fallback ke unit_irban_id OPD.
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $irban = UnitIrban::whereIn('kode', ['IRBAN_1', 'IRBAN_2', 'IRBAN_3', 'IRBAN_4', 'IRBAN_KHUSUS'])
            ->pluck('id', 'kode');

        $i1 = $irban['IRBAN_1']      ?? null;
        $i2 = $irban['IRBAN_2']      ?? null;
        $i3 = $irban['IRBAN_3']      ?? null;
        $i4 = $irban['IRBAN_4']      ?? null;
        $ik = $irban['IRBAN_KHUSUS'] ?? null;

        $data = [
            // ── Kategori yang langsung ke Irban spesifik ───────────────
            [
                'nama_kategori'        => 'Kepegawaian dan SDM',
                'deskripsi'            => 'Rekrutmen, promosi, mutasi, disiplin, dan administrasi ASN.',
                'default_unit_irban_id' => $i1,
            ],
            [
                'nama_kategori'        => 'Akuntabilitas Kinerja (AKIP)',
                'deskripsi'            => 'Evaluasi dan asistensi AKIP, penyusunan laporan kinerja.',
                'default_unit_irban_id' => $i1,
            ],
            [
                'nama_kategori'        => 'Pelayanan Publik Sektor Kesehatan',
                'deskripsi'            => 'Reviu kinerja layanan kesehatan termasuk RSUD.',
                'default_unit_irban_id' => $i2,
            ],
            [
                'nama_kategori'        => 'Pengelolaan Barang Milik Daerah',
                'deskripsi'            => 'Penatausahaan, pemanfaatan, pemeliharaan, dan penghapusan BMD.',
                'default_unit_irban_id' => $i2,
            ],
            [
                'nama_kategori'        => 'Pelayanan Publik Sektor Pendidikan',
                'deskripsi'            => 'Reviu kinerja layanan pendidikan dan penerimaan peserta didik baru.',
                'default_unit_irban_id' => $i3,
            ],
            [
                'nama_kategori'        => 'Reformasi Birokrasi',
                'deskripsi'            => 'Evaluasi rencana aksi reformasi birokrasi dan Zona Integritas.',
                'default_unit_irban_id' => $i3,
            ],
            [
                'nama_kategori'        => 'Manajemen Risiko dan SPIP',
                'deskripsi'            => 'Penyelenggaraan SPIP, maturitas SPIP, dan penilaian risiko.',
                'default_unit_irban_id' => $i4,
            ],
            [
                'nama_kategori'        => 'Pemeriksaan Kinerja',
                'deskripsi'            => 'Evaluasi efektivitas dan efisiensi kinerja program/kegiatan.',
                'default_unit_irban_id' => $i4,
            ],
            [
                'nama_kategori'        => 'Dana BOS',
                'deskripsi'            => 'Pengelolaan dan pertanggungjawaban Bantuan Operasional Sekolah.',
                'default_unit_irban_id' => $i4,
            ],
            [
                'nama_kategori'        => 'Pelayanan Publik Sektor Perizinan',
                'deskripsi'            => 'Reviu kinerja layanan perizinan dan PTSP.',
                'default_unit_irban_id' => $ik,
            ],
            [
                'nama_kategori'        => 'Pengadaan Barang dan Jasa',
                'deskripsi'            => 'Perencanaan, pelaksanaan, dan serah terima pengadaan barang/jasa, termasuk e-audit PBJ.',
                'default_unit_irban_id' => $ik,
            ],
            [
                'nama_kategori'        => 'Bantuan Sosial dan Hibah',
                'deskripsi'            => 'Penyaluran dan pertanggungjawaban bansos, hibah, dan bantuan keuangan.',
                'default_unit_irban_id' => $ik,
            ],
            [
                'nama_kategori'        => 'Pengaduan dan Dugaan Kerugian Daerah',
                'deskripsi'            => 'Penanganan pengaduan masyarakat, indisipliner, dan dugaan kerugian keuangan daerah.',
                'default_unit_irban_id' => $ik,
            ],
            [
                'nama_kategori'        => 'Zona Integritas (ZI/WBK/WBBM)',
                'deskripsi'            => 'Konsultasi pembangunan Zona Integritas menuju WBK/WBBM.',
                'default_unit_irban_id' => $ik,
            ],

            // ── Kategori shared → fallback ke Irban wilayah OPD ────────
            [
                'nama_kategori'        => 'Pengelolaan Keuangan Daerah',
                'deskripsi'            => 'Penganggaran, penatausahaan, pertanggungjawaban, dan reviu laporan keuangan daerah.',
                'default_unit_irban_id' => null,
            ],
            [
                'nama_kategori'        => 'Perjalanan Dinas',
                'deskripsi'            => 'Standar biaya, mekanisme, dan pertanggungjawaban perjalanan dinas.',
                'default_unit_irban_id' => null,
            ],
            [
                'nama_kategori'        => 'Keuangan Desa',
                'deskripsi'            => 'Pengelolaan APBDes, dana desa, alokasi dana desa, dan keuangan desa lainnya.',
                'default_unit_irban_id' => null,
            ],
            [
                'nama_kategori'        => 'Perencanaan dan Penganggaran',
                'deskripsi'            => 'Penyusunan Renja, RKA, KUA-PPAS, RKPD, dan dokumen perencanaan lainnya.',
                'default_unit_irban_id' => null,
            ],
            [
                'nama_kategori'        => 'Tindak Lanjut Hasil Pemeriksaan',
                'deskripsi'            => 'Tindak lanjut rekomendasi BPK, APIP, dan hasil pengawasan lainnya.',
                'default_unit_irban_id' => null,
            ],
            [
                'nama_kategori'        => 'Lain-lain',
                'deskripsi'            => 'Konsultasi di luar kategori yang tersedia. Akan diteruskan ke Irban wilayah pengawasan OPD.',
                'default_unit_irban_id' => null,
            ],
        ];

        foreach ($data as $row) {
            $row['slug'] = Str::slug($row['nama_kategori']);
            Category::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
