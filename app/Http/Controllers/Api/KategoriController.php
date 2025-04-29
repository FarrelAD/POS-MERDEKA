<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return KategoriModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $kategori = KategoriModel::create($req->all());
        return response()->json($kategori, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriModel $kategori)
    {
        return KategoriModel::find($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, KategoriModel $kategori)
    {
        $kategori->update($req->all());
        return KategoriModel::find($kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriModel $kategori)
    {
        $kategori->delete();

        return response()->json([
            "message" => "Data successfully deleted"
        ]);
    }
}
