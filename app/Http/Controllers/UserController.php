<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::firstOrNew([
            'username' => 'manager333',
            'nama' => 'manager TIGA THREE',
            'password' => Hash::make('12345'),
            'level_id' => 2
        ]);

        return view('user', ['data' => $user]);
    }
}
