<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'username' => $req->username,
            'nama' => $req->nama,
            'password' => bcrypt($req->password),
            'level_id' => $req->level_id,
            'image' => $req->image->hashName()
        ]);

        if (!$user) {
            return response()->json([
                'user' => null
            ], Response::HTTP_CONFLICT);
        }
        
        
        return response()->json([
            'user' => $user
        ], Response::HTTP_CREATED);
    }
}
