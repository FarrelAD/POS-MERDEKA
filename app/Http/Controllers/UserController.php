<?php

namespace App\Http\Controllers;

use App\Models\UserModel;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::where('level_id', 2)
            ->count();
        
        // dd($user);

        return view('user', ['data' => $user]);
    }
}
