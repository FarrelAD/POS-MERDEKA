<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_id' => 1,
                'supplier_nama' => 'Si Kencang',
                'kontak' => '0123123123',
                'alamat' => 'Kota Surabaya'
            ],
            [
                'supplier_id' => 2,
                'supplier_nama' => 'Lele Gila',
                'kontak' => '07781781123',
                'alamat' => 'Kabupaten Ponorogo'
            ],
            [
                'supplier_id' => 3,
                'supplier_nama' => 'Mantap Asli',
                'kontak' => '0888111222',
                'alamat' => 'Kota Magetan'
            ]
        ]);
    }
}
