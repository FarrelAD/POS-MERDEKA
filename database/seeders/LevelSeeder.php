<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level_id' => 1, 'level_kode' => 'ADM', 'level_name' => 'Administrator'],
            ['level_id' => 2, 'level_kode' => 'MMG', 'level_name' => 'Manager'],
            ['level_id' => 3, 'level_kode' => 'STF', 'level_name' => 'Staff/kasir']
        ];

        DB::table('m_level')->insert($data);
    }
}
