<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user-tambah');
    }

    public function tambahSimpan(Request $req)
    {
        UserModel::create([
            'username' => $req->username,
            'nama' => $req->nama,
            'password' => Hash::make($req->password),
            'level_id' => $req->level_id
        ]);

        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user-ubah', ['data' => $user]);
    }

    public function ubahSimpan(Request $req, $id)
    {
        $user = UserModel::find($id);

        $user->username = $req->username;
        $user->nama = $req->nama;
        $user->password = Hash::make($req->password);
        $user->level_id = $req->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}
