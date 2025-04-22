<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LevelModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $level = LevelModel::create($req->all());
        return response()->json($level, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(LevelModel $level)
    {
        return LevelModel::find($level);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, LevelModel $level)
    {
        $level->update($req->all());
        return LevelModel::find($level);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LevelModel $user)
    {
        $user->delete();

        return response()->json([
            "message" => "Data successfully deleted"
        ]);
    }
}
