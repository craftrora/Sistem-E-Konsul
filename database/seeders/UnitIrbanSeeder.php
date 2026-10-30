<?php

namespace Database\Seeders;

use App\Models\UnitIrban;
use Illuminate\Database\Seeder;

class UnitIrbanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode'            => 'IRBAN_1',
                'nama'            => 'Irban Wilayah I',
                'cakupan_wilayah' => 'OPD dan kecamatan pada wilayah kerja I',
                'urutan'          => 1,
            ],
            [
                'kode'            => 'IRBAN_2',
                'nama'            => 'Irban Wilayah II',
                'cakupan_wilayah' => 'OPD dan kecamatan pada wilayah kerja II',
                'urutan'          => 2,
            ],
            [
                'kode'            => 'IRBAN_3',
                'nama'            => 'Irban Wilayah III',
                'cakupan_wilayah' => 'OPD dan kecamatan pada wilayah kerja III',
                'urutan'          => 3,
            ],
            [
                'kode'            => 'IRBAN_4',
                'nama'            => 'Irban Wilayah IV',
                'cakupan_wilayah' => 'OPD dan kecamatan pada wilayah kerja IV',
                'urutan'          => 4,
            ],
            [
                'kode'            => 'IRBAN_KHUSUS',
                'nama'            => 'Irban Khusus',
                'cakupan_wilayah' => 'Penanganan pengaduan masyarakat dan pemeriksaan khusus lintas wilayah',
                'urutan'          => 5,
            ],
        ];

        foreach ($data as $row) {
            UnitIrban::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
