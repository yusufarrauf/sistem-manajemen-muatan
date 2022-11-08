<?php

namespace App\Http\Controllers\API;

use App\DataKota;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DataKota::all();
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
            'kota' => 'required|unique:data_kotas',
        ]);
        return DataKota::create([
            'kota' => strtoupper($request['kota'])
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
        $kota = DataKota::findOrFail($id);
        $this->validate($request, [
            'kota' => 'required|unique:data_kotas,kota,'.$kota->id,
        ]);
        $kota->update([
            'kota' => strtoupper($request['kota'])
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
        $kota = DataKota::findOrFail($id);
        $kota->delete();
    }
}
