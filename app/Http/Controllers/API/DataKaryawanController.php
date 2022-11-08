<?php

namespace App\Http\Controllers\API;

use App\DataKaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataKaryawanController extends Controller
{
    public function index()
    {
        return DataKaryawan::all();
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
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'handphone' => 'required|numeric',
            'jabatan' => 'required',
        ],[
            'nama.required' => 'Silahkan Masukan Nama Jabatan',
            'tempat_lahir.required' => 'Silahkan Masukan Tempat Lahir',
            'tanggal_lahir.required' => 'Silahkan Masukan Tanggal Lahir',
            'jenis_kelamin.required' => 'Silahkan Pilih Jenis Kelamin',
            'alamat.required' => 'Silahkan Masukan Alamat',
            'handphone.required' => 'Silahkan Masukan Nomor Handphone',
            'handphone.numeric' => 'Nomor HP Harus Berupa Angka',
            'jabatan.required' => 'Silahkan Pilih Jabatan',
        ]);
        return DataKaryawan::create([
            'nama' => $request['nama'],
            'tempat_lahir' => $request['tempat_lahir'],
            'tanggal_lahir' => $request['tanggal_lahir'],
            'jenis_kelamin' => $request['jenis_kelamin'],
            'alamat' => $request['alamat'],
            'handphone' => $request['handphone'],
            'jabatan' => $request['jabatan'],
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
        $data_gaji = DataKaryawan::findOrFail($id);
        $this->validate($request, [
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'handphone' => 'required|numeric',
            'jabatan' => 'required',
        ],[
            'nama.required' => 'Silahkan Masukan Nama Jabatan',
            'tempat_lahir.required' => 'Silahkan Masukan Tempat Lahir',
            'tanggal_lahir.required' => 'Silahkan Masukan Tanggal Lahir',
            'jenis_kelamin.required' => 'Silahkan Pilih Jenis Kelamin',
            'alamat.required' => 'Silahkan Masukan Alamat',
            'handphone.required' => 'Silahkan Masukan Nomor Handphone',
            'handphone.numeric' => 'Nomor HP Harus Berupa Angka',
            'jabatan.required' => 'Silahkan Pilih Jabatan',
        ]);
        $data_gaji->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data_gaji = DataKaryawan::findOrFail($id);
        $data_gaji->delete();
    }
}
