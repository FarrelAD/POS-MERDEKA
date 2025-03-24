<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar supplier',
                'list' => ['Home', 'supplier']
            ],
            'page' => (object) [
                'title' => 'Daftar supplier yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'supplier'
        ]);
    }

    public function list(Request $req) 
    {
        $supplier = SupplierModel::select( 'supplier_id', 'supplier_nama', 'kontak', 'alamat');

        if ($req->supplier_id) {
            $supplier->where('supplier_id', $req->supplier_id);
        }

        return DataTables::of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                $supplierUrl = route('supplier.destroy', ['id' => $supplier->supplier_id]);
                $csrfField = csrf_field();
                $methodField = method_field('DELETE');

                return <<<HTML
                <a href="{$supplierUrl}" class="btn btn-info btn-sm">Detail</a>
                <a href="{$supplierUrl}/edit" class="btn btn-warning btn-sm">Edit</a>
                <form action="{$supplierUrl}" method="post" class="d-inline-block">
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
        return view('supplier.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah supplier ',
                'list' => ['Home', 'supplier', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah supplier  baru'
            ],
            'supplier' => SupplierModel::all(),
            'activeMenu' => 'supplier'
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'supplier_nama' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'alamat' => 'required|string|max:100'
        ]);

        SupplierModel::create([
            'supplier_nama' => $req->supplier_nama,
            'kontak' => $req->kontak,
            'alamat' => $req->alamat
        ]);

        return redirect('/supplier')
            ->with('success', 'Data supplier  berhasil disimpan!');
    }

    public function show(string $id)
    {
        return view('supplier.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail supplier',
                'list' => ['Home', 'supplier', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail supplier'
            ],
            'supplier' => SupplierModel::find($id),
            'activeMenu' => 'supplier'
        ]);
    }

    public function edit(string $id)
    {
        return view('supplier.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit supplier',
                'list' => ['Home', 'supplier', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit supplier'
            ],
            'supplier' => SupplierModel::find($id),
            'activeMenu' => 'supplier'
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'supplier_nama' => "required|string|min:5|max:100",
            'kontak' => 'required|string|max:20',
            'alamat' => 'required|string|max:100'
        ]);

        SupplierModel::find($id)->update([
            'supplier_nama' => $req->supplier_nama,
            'kontak' => $req->kontak,
            'alamat' => $req->alamat
        ]);

        return redirect('/supplier')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = SupplierModel::find($id);

        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id);

            return redirect('/supplier')
                ->with('success', 'Data supplier  berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/supplier')
                ->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
