<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar barang',
                'list' => ['Home', 'Barang']
            ],
            'kategori' => KategoriModel::all(),
            'page' => (object) [
                'title' => 'Daftar barang yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'barang'
        ]);
    }

    public function list(Request $req) 
    {
        $barang = BarangModel::select(
             'barang_id', 
             'kategori_id', 
             'barang_kode',
             'barang_nama',
             'harga_beli',
             'harga_jual'
             )
            ->with('kategori');

        if ($req->barang_id) {
            $barang->where('barang_id', $req->barang_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $barangUrl = url("/barang/{$barang->barang_id}");
                $csrfField = csrf_field();
                $methodField = method_field('DELETE');

                return <<<HTML
                <a href="{$barangUrl}" class="btn btn-info btn-sm">Detail</a>
                <a href="{$barangUrl}/edit" class="btn btn-warning btn-sm">Edit</a>
                <form action="{$barangUrl}" method="post" class="d-inline-block">
                    {$csrfField}
                    {$methodField}

                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin menghapus data ini?')">Hapus</button>
                </form>
                HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    public function create()
    {
        return view('barang.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Barang',
                'list' => ['Home', 'Barang', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah barang baru'
            ],
            'kategori' => KategoriModel::all(),
            'barang' => BarangModel::all(),
            'activeMenu' => 'barang'
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'kategori_id' => 'required|integer|min:3',
            'barang_kode' => 'required|string|max:100|unique:m_barang,kategori_kode',
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        BarangModel::create([
            'kategori_id' => $req->kategori_id,
            'barang_kode' => $req->barang_kode,
            'barang_nama' => $req->barang_nama,
            'harga_beli' => $req->harga_beli,
            'harga_jual' => $req->harga_jual
        ]);

        return redirect('/barang')
            ->with('success', 'Data barang berhasil disimpan!');
    }

    public function show(string $id)
    {
        return view('barang.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Barang',
                'list' => ['Home', 'Barang', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail barang'
            ],
            'barang' => BarangModel::find($id),
            'activeMenu' => 'barang'
        ]);
    }

    public function edit(string $id)
    {
        return view('barang.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit Barang',
                'list' => ['Home', 'Barang', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit Barang'
            ],
            'kategori' => KategoriModel::all(),
            'barang' => BarangModel::find($id),
            'activeMenu' => 'barang'
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'kategori_kode' => "required|string|min:3|unique:m_kategori,kategori_kode,$id,kategori_id",
            'kategori_nama' => 'required|string|max:100'
        ]);

        BarangModel::find($id)->update([
            'kategori_kode' => $req->kategori_kode,
            'kategori_nama' => $req->kategori_nama
        ]);

        return redirect('/barang')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = BarangModel::find($id);

        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);

            return redirect('/barang')
                ->with('success', 'Data barang berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/barang')
                ->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
