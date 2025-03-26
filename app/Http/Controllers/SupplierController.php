<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
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
                $detailUrl = route('supplier.show', ['id' => $supplier->supplier_id]);
                $editUrl = route('supplier.edit-ajax', ['id' => $supplier->supplier_id]);
                $deleteUrl = route('supplier.delete-ajax', ['id' => $supplier->supplier_id]);
                
                return <<<HTML
                <button onclick="modalAction('{$detailUrl}')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$editUrl}')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$deleteUrl}')" class="btn btn-danger btn-sm">Hapus</button>
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

    public function createAjax()
    {
        return view('supplier.create-ajax');
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

    public function storeAjax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            redirect('/');
        }
        
        $validator = Validator::make($req->all(), [
            'supplier_nama' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'alamat' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        SupplierModel::create($req->all());

        return response()->json([
            'message' => 'Data supplier berhasil disimpan'
        ], Response::HTTP_OK);
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

    public function editAjax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit-ajax', [
            'supplier' => $supplier
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

    public function updateAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($req->all(), [
            'supplier_nama' => "required|string|min:5|max:100",
            'kontak' => 'required|string|max:20',
            'alamat' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $supplier = SupplierModel::find($id);

        if (!$supplier) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$req->filled('password')) {
            $req->request->remove('password');
        }

        $supplier->update($req->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
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

    public function confirmDeleteAjax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm-delete-ajax', ['supplier' => $supplier]);
    }

    public function deleteAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $supplier = SupplierModel::find($id);

        if (!$supplier) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $supplier->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], Response::HTTP_OK);
    }
}
