<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public  function __invoke(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "username" => "required",
            "password" =>"required"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = $req->only('username', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                "message" => "Incorrect username and password"
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            "user" => auth()->guard('api')->user(),
            "token" => $token
        ]);
    }
}
