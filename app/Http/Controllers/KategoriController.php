<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        // Insert kategori data
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/makanan ringan',
        //     'created_at' => now()
        // ];

        // DB::table('m_kategori')->insert($data);

        // return "Sukses menambahkan data kategori baru dengan kode <b>" . $data['kategori_kode'] . "</b>";

        // Update kategori data
        // $row = DB::table('m_kategori')
        //     ->where('kategori_kode', 'SNK')
        //     ->update(['kategori_nama' => 'Camilan']);

        // return "Sukses memperbarui data dengan Query Builder. Total baris yang diperbarui <b>$row</b>";

        // Delete kategori data
        // $row = DB::table('m_kategori')
        //     ->where('kategori_kode', 'SNK')
        //     ->delete();
        
        // return "Sukses menghapus data dengan menggunakan Query Builder. Total baris yang terhappus <b>$row</b>";


        // Display kategori data to Laravel Blade
        $data = DB::table('m_kategori')->get();

        return view('kategori', ['data' => $data]);
    }
}
