<?php

namespace App\Http\Controllers\API;

use App\DataKendaraan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class DataKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DataKendaraan::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'vendor' => 'required',
            'nopol' => 'required|regex:/^\S*$/u|string|unique:data_kendaraans',
        ],[
            'nopol.regex' => 'Harap Input Nomor Plat Tanpa Spasi!',
        ]);
        if($request['supir'] == ''){
            $request['supir'] = strtoupper($request['nopol']);
        }

        DataKendaraan::create([
            'vendor' => strtoupper($request['vendor']),
            'nopol' => strtoupper($request['nopol']),
            'supir' => $request['supir'],
            'status' => 'AKTIF',
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
        $kendaraan = DataKendaraan::findOrFail($id);
        $user = User::where('username', '=', $kendaraan->nopol)->first();
        $this->validate($request,[
            'vendor' => 'required',
            'nopol' => 'required|regex:/^\S*$/u|string|unique:data_kendaraans,nopol,'.$kendaraan->id,
        ],[
            'nopol.regex' => 'Harap Input Nomor Plat Tanpa Spasi!',
        ]);
        if($request['supir'] == ''){
            $request['supir'] = strtoupper($request['nopol']);
        }
        $kendaraan->update([
            'vendor' => strtoupper($request['vendor']),
            'nopol' => strtoupper($request['nopol']),
            'supir' => $request['supir'],
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
        $kendaraan = DataKendaraan::findOrFail($id);
        $kendaraan->delete();
    }
    public function updateStatus(Request $request)
    {
        $kendaraan = DataKendaraan::findOrFail($request['id']);
        $kendaraan->update($request->all());
    }
}
