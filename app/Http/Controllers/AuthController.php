<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        return redirect('/');
    }

    public function postLogin(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect(route('login'));
        }

        $credentials = $req->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login Gagal!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'Login Berhasil',
            'redirect' => url('/')
        ]);
    }

    public function logout(Request $req)
    {
        Auth::logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect('login');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function postSignup(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect()->back();
        }

        $validator = Validator::make($req->all(), [
            'username' => 'required|string|min:5|max:20|unique:m_user,username',
            'nama' => 'required|string|min:5|max:100',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'username' => $req->username,
            'nama' => $req->nama,
            'level_id' => 3,        // level id for 'Staff/Kasir'
            'password' => Hash::make($req->password)
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Data pengguna berhasil dibuat',
            'redirect' => url('/')
        ], Response::HTTP_OK);
    }
}
