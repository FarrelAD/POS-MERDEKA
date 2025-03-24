<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan')->insert([
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => 'Budi Santoso',
                'penjualan_kode' => 'PNJ-20240201-001',
                'penjualan_tanggal' => '2024-02-01 10:15:00'
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 2,
                'pembeli' => 'Siti Aisyah',
                'penjualan_kode' => 'PNJ-20240201-002',
                'penjualan_tanggal' => '2024-02-01 11:00:00'
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Joko Widodo',
                'penjualan_kode' => 'PNJ-20240201-003',
                'penjualan_tanggal' => '2024-02-01 12:30:00'
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 1,
                'pembeli' => 'Ani Susanti',
                'penjualan_kode' => 'PNJ-20240202-001',
                'penjualan_tanggal' => '2024-02-02 09:45:00'
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => 'Rudi Hartono',
                'penjualan_kode' => 'PNJ-20240202-002',
                'penjualan_tanggal' => '2024-02-02 14:10:00'
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Dewi Kartika',
                'penjualan_kode' => 'PNJ-20240202-003',
                'penjualan_tanggal' => '2024-02-02 16:05:00'
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 1,
                'pembeli' => 'Ahmad Zulfikar',
                'penjualan_kode' => 'PNJ-20240203-001',
                'penjualan_tanggal' => '2024-02-03 08:20:00'
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 2,
                'pembeli' => 'Lisa Marlina',
                'penjualan_kode' => 'PNJ-20240203-002',
                'penjualan_tanggal' => '2024-02-03 10:55:00'
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Samsul Bahri',
                'penjualan_kode' => 'PNJ-20240203-003',
                'penjualan_tanggal' => '2024-02-03 15:30:00'
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 1,
                'pembeli' => 'Rina Septiani',
                'penjualan_kode' => 'PNJ-20240203-004',
                'penjualan_tanggal' => '2024-02-03 17:45:00'
            ]
        ]);
    }
}
