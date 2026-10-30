<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Opd;
use App\Models\UnitIrban;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Administrator
        User::updateOrCreate(
            ['email' => 'admin@inspektorat.ngawikab.go.id'],
            [
                'name'      => 'Administrator E-KONSUL',
                'password'  => Hash::make('password'),
                'role'      => RoleEnum::ADMIN,
                'jabatan'   => 'Administrator Sistem',
                'no_wa'     => '6280000000001',
                'is_active' => true,
            ]
        );

        // 2. Satu akun Irban untuk tiap unit
        UnitIrban::orderBy('urutan')->get()->each(function (UnitIrban $unit, int $i) {
            $no = $i + 1;
            User::updateOrCreate(
                ['email' => 'irban' . $no . '@inspektorat.ngawikab.go.id'],
                [
                    'name'          => $unit->nama,
                    'password'      => Hash::make('irban' . $no),
                    'role'          => RoleEnum::IRBAN,
                    'unit_irban_id' => $unit->id,
                    'jabatan'       => 'Inspektur Pembantu',
                    'no_wa'         => '628000000' . str_pad((string) ($i + 10), 4, '0', STR_PAD_LEFT),
                    'is_active'     => true,
                ]
            );
        });

        // 3. Satu akun operator untuk tiap OPD contoh
        Opd::orderBy('id')->get()->each(function (Opd $opd) {
            User::updateOrCreate(
                ['email' => strtolower($opd->kode_opd) . '@ngawikab.go.id'],
                [
                    'name'      => 'Operator ' . $opd->nama_opd,
                    'password'  => Hash::make('password'),
                    'role'      => RoleEnum::OPD,
                    'opd_id'    => $opd->id,
                    'jabatan'   => 'Operator Konsultasi',
                    'no_wa'     => $opd->no_wa,
                    'is_active' => true,
                ]
            );
        });
    }
}
