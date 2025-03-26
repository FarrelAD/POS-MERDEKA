<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar user',
                'list' => ['Home', 'User']
            ],
            'level' => LevelModel::all(),
            'page' => (object) [
                'title' => 'Daftar user yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'user'
        ]);
    }

    public function list(Request $req) 
    {
        $users = User::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        if ($req->level_id) {
            $users->where('level_id', $req->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $detailUrl = route('user.show', ['id' => $user->user_id]);
                $editUrl = route('user.edit-ajax', ['id' => $user->user_id]);
                $deleteAjax = route('user.delete-ajax', ['id' => $user->user_id]);
                
                return <<<HTML
                <button onclick="modalAction('{$detailUrl}')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$editUrl}')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$deleteAjax}')" class="btn btn-danger btn-sm">Hapus</button>
                HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    public function create()
    {
        return view('user.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah User',
                'list' => ['Home', 'User', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah user baru'
            ],
            'level' => LevelModel::all(),
            'activeMenu' => 'user'
        ]);
    }

    public function createAjax()
    {
        return view('user.create-ajax')
            ->with('levels', LevelModel::select('level_id', 'level_name')->get());
    }

    public function store(Request $req)
    {
        $req->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        User::create([
            'username' => $req->username,
            'nama' => $req->nama,
            'password' => bcrypt($req->password),
            'level_id' => $req->level_id
        ]);

        return redirect('/user')
            ->with('success', 'Data user berhasil disimpan!');
    }

    public function storeAjax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            redirect('/');
        }
        
        $validator = Validator::make($req->all(), [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        User::create($req->all());

        return response()->json([
            'message' => 'Data user berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function show(string $id)
    {
        return view('user.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail User',
                'list' => ['Home', 'User', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail user'
            ],
            'user' => User::with('level')->find($id),
            'activeMenu' => 'user'
        ]);
    }

    public function edit(string $id)
    {
        return view('user.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit User',
                'list' => ['Home', 'User', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit User'
            ],
            'user' => User::find($id),
            'level' =>LevelModel::all(),
            'activeMenu' => 'user'
        ]);
    }

    public function editAjax(string $id)
    {
        $user = User::find($id);
        $levels = LevelModel::select('level_id', 'level_name')->get();

        return view('user.edit-ajax', [
            'user' => $user,
            'levels' => $levels
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'username' => "required|string|min:3|unique:m_user,username,$id,user_id",
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        User::find($id)->update([
            'username' => $req->username,
            'nama' => $req->nama,
            'password' => $req->password ? bcrypt($req->password) : User::find($id)->password,
            'level_id' => $req->level_id
        ]);

        return redirect('/user')
            ->with('success', 'Data berhasil diubah');
    }

    public function updateAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($req->all(), [
            'level_id' => 'required|integer',
            'username' => "required|max:20|unique:m_user,username,$id,user_id",
            'nama' => 'required|max:100',
            'password' => 'nullable|min:6|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$req->filled('password')) {
            $req->request->remove('password');
        }

        $user->update($req->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $check = User::find($id);

        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            User::destroy($id);

            return redirect('/user')
                ->with('success', 'Data user berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/user')
                ->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirmDeleteAjax(string $id)
    {
        $user = User::find($id);

        return view('user.confirm-delete-ajax', ['user' => $user]);
    }

    public function deleteAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], Response::HTTP_OK);
    }
}
