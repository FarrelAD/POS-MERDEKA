<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BarangModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $barang = BarangModel::create($req->all());
        return response()->json($barang, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, BarangModel $barang)
    {
        $barang->update($req->all());
        return BarangModel::find($barang);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangModel $barang)
    {
        $barang->delete();

        return response()->json([
            "message" => "Data successfully deleted"
        ]);
    }
}
