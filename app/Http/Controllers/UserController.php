<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
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
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        if ($req->level_id) {
            $users->where('level_id', $req->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $userUrl = url("/user/{$user->user_id}");
                // $csrfField = csrf_field();
                // $methodField = method_field('DELETE');

                // return <<<HTML
                // <a href="{$userUrl}" class="btn btn-info btn-sm">Detail</a>
                // <a href="{$userUrl}/edit" class="btn btn-warning btn-sm">Edit</a>
                // <form action="{$userUrl}" method="post" class="d-inline-block">
                //     {$csrfField}
                //     {$methodField}

                //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin menghapus data ini?')">Hapus</button>
                // </form>
                // HTML;
                
                return <<<HTML
                <button onclick="modalAction('{$userUrl}/show_ajax')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$userUrl}/edit_ajax')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$userUrl}/delete_ajax')" class="btn btn-danger btn-sm">Hapus</button>
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

        UserModel::create([
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
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        UserModel::create($req->all());

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);
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
            'user' => UserModel::with('level')->find($id),
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
            'user' => UserModel::find($id),
            'level' =>LevelModel::all(),
            'activeMenu' => 'user'
        ]);
    }

    public function editAjax(string $id)
    {
        $user = UserModel::find($id);
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

        UserModel::find($id)->update([
            'username' => $req->username,
            'nama' => $req->nama,
            'password' => $req->password ? bcrypt($req->password) : UserModel::find($id)->password,
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
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = UserModel::find($id);

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
        $check = UserModel::find($id);

        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);

            return redirect('/user')
                ->with('success', 'Data user berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/user')
                ->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
