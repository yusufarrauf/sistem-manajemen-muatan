<?php

namespace App\Http\Controllers\API;

use App\DataOngkos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataOngkosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DataOngkos::all();
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
            'asal' => 'required',
            'kota' => 'required',
        ]);
        return DataOngkos::create([
            'asal' => $request['asal'],
            'kota' => $request['kota'],
            'tujuan' => $request['tujuan'],
            'ongkos_vendor' => $request['ongkos_vendor'],
            'ongkos_invoice' => $request['ongkos_invoice'],
            'mobil_perton' => $request['mobil_perton'],
            'supir_perton' => $request['supir_perton'],
            'bonus' => $request['bonus'],
            'panjar' => $request['panjar'],
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
        $ongkos = DataOngkos::findOrFail($id);
        $this->validate($request, [
            'asal' => 'required',
            'kota' => 'required',
        ]);
        $ongkos->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ongkos = DataOngkos::findOrFail($id);
        $ongkos->delete();
    }
    public function getCost(Request $req)
    {
        $data = DataOngkos::where('asal', '=', $req['asal'])
        ->where('kota', '=', $req['kota']);

        if($req['asal'] != "KRNG"){
            $data->where('tujuan', '=', $req['perusahaan']);
        }
        return $data->first();
    }
}
