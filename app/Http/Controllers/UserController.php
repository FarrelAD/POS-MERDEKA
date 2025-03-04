<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'manager sebelas',
            'password' => Hash::make('12345'),
            'level_id' => 2
        ]);

        $user->username = 'manager12';

        $user->save();

        $user->wasChanged();
        $user->wasChanged('username');
        $user->wasChanged(['username', 'level_id']);
        $user->wasChanged('nama');

        dd($user->wasChanged(['nama', 'username']));

        return view('user', ['data' => $user]);
    }
}
