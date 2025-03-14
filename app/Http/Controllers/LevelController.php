<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
class LevelController extends Controller
{
    public function index()
    {
        return view('level.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar level pengguna',
                'list' => ['Home', 'Level']
            ],
            'level' => LevelModel::all(),
            'page' => (object) [
                'title' => 'Daftar level pengguna yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'level'
        ]);
    }

    public function list(Request $req) 
    {
        $level = LevelModel::select( 'level_id', 'level_kode', 'level_name');

        if ($req->level_id) {
            $level->where('level_id', $req->level_id);
        }

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $levelUrl = url("/level/{$level->level_id}");
                $csrfField = csrf_field();
                $methodField = method_field('DELETE');

                return <<<HTML
                <a href="{$levelUrl}" class="btn btn-info btn-sm">Detail</a>
                <a href="{$levelUrl}/edit" class="btn btn-warning btn-sm">Edit</a>
                <form action="{$levelUrl}" method="post" class="d-inline-block">
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
        return view('level.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Level Pengguna',
                'list' => ['Home', 'Level', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah level pengguna baru'
            ],
            'level' => LevelModel::all(),
            'activeMenu' => 'level'
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'level_kode' => "required|string|min:3|unique:m_level,level_kode",
            'level_name' => 'required|string|max:100|unique:m_level,level_name'
        ]);

        LevelModel::create([
            'level_kode' => $req->level_kode,
            'level_name' => $req->level_name
        ]);

        return redirect('/level')
            ->with('success', 'Data level pengguna berhasil disimpan!');
    }

    public function show(string $id)
    {
        return view('level.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Level',
                'list' => ['Home', 'Level', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail level'
            ],
            'level' => LevelModel::find($id),
            'activeMenu' => 'level'
        ]);
    }

    public function edit(string $id)
    {
        return view('level.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit level',
                'list' => ['Home', 'Level', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit level'
            ],
            'level' => LevelModel::find($id),
            'activeMenu' => 'level'
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'level_kode' => "required|string|min:3|unique:m_level,level_kode,$id,level_id",
            'level_name' => 'required|string|max:100'
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $req->level_kode,
            'level_name' => $req->level_name
        ]);

        return redirect('/level')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = LevelModel::find($id);

        if (!$check) {
            return redirect('/level')->with('error', 'Data level pengguna tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);

            return redirect('/level')
                ->with('success', 'Data level pengguna berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/level')
                ->with('error', 'Data level pengguna gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
