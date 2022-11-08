<?php

namespace App\Http\Controllers\API;

use App\DataPelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DataPelanggan::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:data_pelanggans',
        ]);
        return DataPelanggan::create([
            'nama' => strtoupper($request['nama']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pelanggan = DataPelanggan::findOrFail($id);
        $this->validate($request, [
            'nama' => 'required|unique:data_pelanggans,nama,'.$pelanggan->id,
        ]);
        $pelanggan->update([
            'nama' => strtoupper($request['nama']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelanggan = DataPelanggan::findOrFail($id);
        $pelanggan->delete();
    }
}
