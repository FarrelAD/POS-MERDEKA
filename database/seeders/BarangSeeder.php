<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_barang')->insert([
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'B001',
                'barang_nama' => 'Nasi Goreng',
                'harga_beli' => 15000,
                'harga_jual' => 20000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'B002',
                'barang_nama' => 'Mie Ayam',
                'harga_beli' => 12000,
                'harga_jual' => 18000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'B003',
                'barang_nama' => 'Es Teh',
                'harga_beli' => 3000,
                'harga_jual' => 5000
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'B004',
                'barang_nama' => 'Kopi Hitam',
                'harga_beli' => 5000,
                'harga_jual' => 8000
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'B005',
                'barang_nama' => 'Keripik Kentang',
                'harga_beli' => 8000,
                'harga_jual' => 12000
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'B006',
                'barang_nama' => 'Coklat Batang',
                'harga_beli' => 7000,
                'harga_jual' => 10000
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'B007',
                'barang_nama' => 'Headphone',
                'harga_beli' => 200000,
                'harga_jual' => 250000
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'B008',
                'barang_nama' => 'Mouse Wireless',
                'harga_beli' => 100000,
                'harga_jual' => 150000
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'B009',
                'barang_nama' => 'Sabun Cuci Piring',
                'harga_beli' => 5000,
                'harga_jual' => 8000
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'B010',
                'barang_nama' => 'Sikat WC',
                'harga_beli' => 12000,
                'harga_jual' => 18000
            ]
        ]);
    }
}
