<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar kategori barang',
                'list' => ['Home', 'Kategori']
            ],
            'kategori' => KategoriModel::all(),
            'page' => (object) [
                'title' => 'Daftar kategori barang yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'kategori'
        ]);
    }

    public function list(Request $req) 
    {
        $kategori = KategoriModel::select( 'kategori_id', 'kategori_kode', 'kategori_nama');

        if ($req->kategori_id) {
            $kategori->where('kategori_id', $req->kategori_id);
        }

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $kategoriUrl = url("/kategori/{$kategori->kategori_id}");
                $csrfField = csrf_field();
                $methodField = method_field('DELETE');

                return <<<HTML
                <a href="{$kategoriUrl}" class="btn btn-info btn-sm">Detail</a>
                <a href="{$kategoriUrl}/edit" class="btn btn-warning btn-sm">Edit</a>
                <form action="{$kategoriUrl}" method="post" class="d-inline-block">
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
        return view('kategori.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Kategori Barang',
                'list' => ['Home', 'Kategori', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah kategori barang baru'
            ],
            'kategori' => KategoriModel::all(),
            'activeMenu' => 'kategori'
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'kategori_kode' => "required|string|min:3|unique:m_kategori,kategori_kode",
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama'
        ]);

        KategoriModel::create([
            'kategori_kode' => $req->kategori_kode,
            'kategori_nama' => $req->kategori_nama
        ]);

        return redirect('/kategori')
            ->with('success', 'Data kategori barang berhasil disimpan!');
    }

    public function show(string $id)
    {
        return view('kategori.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Kategori Barang',
                'list' => ['Home', 'Kategori', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail kategori barang'
            ],
            'kategori' => KategoriModel::find($id),
            'activeMenu' => 'kategori'
        ]);
    }

    public function edit(string $id)
    {
        return view('kategori.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit Kategori Barang',
                'list' => ['Home', 'Kategori', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit Kategori Barang'
            ],
            'kategori' => KategoriModel::find($id),
            'activeMenu' => 'kategori'
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'kategori_kode' => "required|string|min:3|unique:m_kategori,kategori_kode,$id,kategori_id",
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $req->kategori_kode,
            'kategori_nama' => $req->kategori_nama
        ]);

        return redirect('/kategori')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);

        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori barang tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);

            return redirect('/kategori')
                ->with('success', 'Data kategori barang berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/kategori')
                ->with('error', 'Data kategori barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
