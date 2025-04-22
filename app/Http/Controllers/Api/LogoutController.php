<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function __invoke(Request $req)
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {
            return response()->json([
                "message" => "Successfully to logout"
            ]);
        }
    }
}
