<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori')->insert([
            [
                'kategori_id' => 1,
                'kategori_kode' => 'FOOD001',
                'kategori_nama' => 'Makanan'
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'DRINK001',
                'kategori_nama' => 'Minuman'
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'SNACK001',
                'kategori_nama' => 'Snack'
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'ELEC001',
                'kategori_nama' => 'Elektronik'
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'CLEAN001',
                'kategori_nama' => 'Kebutuhan Rumah Tangga'
            ]
        ]);
    }
}
