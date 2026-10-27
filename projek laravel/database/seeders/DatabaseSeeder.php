<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (DB::table('areas')->count() == 0) {
            DB::table('areas')->insert([
                ['id' => 1, 'nama_area' => 'Gedung A', 'tipe' => 'indoor', 'deskripsi' => 'Gedung olahraga tertutup'],
                ['id' => 2, 'nama_area' => 'Lapangan Terbuka', 'tipe' => 'outdoor', 'deskripsi' => 'Area luar ruangan'],
            ]);

            DB::table('lapangans')->insert([
                [
                    'id' => 1,
                    'area_id' => 1,
                    'kode' => 'BDM-01',
                    'nama_lapangan' => 'Badminton 1',
                    'cabang_olahraga' => 'Badminton',
                    'jenis_permukaan' => 'vinyl',
                    'panjang' => 13.4,
                    'lebar' => 6.1,
                    'status_fisik' => 'baik',
                    'keterangan' => null,
                ],
                [
                    'id' => 2,
                    'area_id' => 2,
                    'kode' => 'FTS-01',
                    'nama_lapangan' => 'Futsal 1',
                    'cabang_olahraga' => 'Futsal',
                    'jenis_permukaan' => 'rumput_sintetis',
                    'panjang' => 25,
                    'lebar' => 15,
                    'status_fisik' => 'perlu_perbaikan',
                    'keterangan' => null,
                ],
            ]);
        }
    }
}
