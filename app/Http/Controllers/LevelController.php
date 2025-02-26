<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\returnArgument;

class LevelController extends Controller
{
    public function index()
    {
        // DB::insert(<<<SQL
        // INSERT INTO m_level 
        // (level_kode, level_name, created_at)
        // VALUES
        // (?, ?, ?)
        // SQL,
        // ['CUS', 'pelanggan', now()]);

        // return 'Sukses insert data baru!';
        
        // $row = DB::update(<<<SQL
        // UPDATE m_level
        // SET level_name = ?
        // WHERE level_kode = ?
        // SQL,
        // ['Customer', 'CUS']);

        // return "Sukses memperbarui data pada tabel m_level. Jumlah data yang berhasil diperbarui $row baris";

        // $row = DB::delete(<<<SQL
        // DELETE FROM m_level
        // WHERE level_kode = ?
        // SQL,
        // ['CUS']);

        // return "Sukses menghapus data pada tabel <b>m_level</b>. Jumlah data yang berhasil dihapus <b>$row</b> baris.";

        $data = DB::select(<<<SQL
        SELECT * FROM m_level
        SQL);

        return view('level', ['data' => $data]);
    }
}
