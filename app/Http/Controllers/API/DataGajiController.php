<?php

namespace App\Http\Controllers\API;

use App\DataGaji;
use App\DataKaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Penggajian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DataGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DataGaji::all();
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
            'nama' => 'required|unique:data_gajis',
            'gaji_pokok' => 'gt:0'
        ],[
            'nama.required' => 'Silahkan Masukan Nama Jabatan',
            'nama.unique' => 'Nama Jabatan Sudah Ada',
            'gaji_pokok.gt' => 'Gaji Pokok Harus Lebih Dari 0'
        ]);
        return DataGaji::create([
            'nama' => strtoupper($request['nama']),
            'gaji_pokok' => $request['gaji_pokok'],
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
        $data_gaji = DataGaji::findOrFail($id);
        $this->validate($request, [
            'nama' => 'required|unique:data_gajis,nama,'.$data_gaji->id,
            'gaji_pokok' => 'gt:0'
        ],[
            'nama.required' => 'Silahkan Masukan Nama Jabatan',
            'nama.unique' => 'Nama Jabatan Sudah Ada',
            'gaji_pokok.gt' => 'Gaji Pokok Harus Lebih Dari 0'
        ]);
        $request['nama'] = strtoupper($request['nama']);
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
        $data_gaji = DataGaji::findOrFail($id);
        $data_gaji->delete();
    }

    public function dataPenggajian(){
        $karyawan = DB::table('data_karyawans')
        ->join('data_gajis', 'data_karyawans.jabatan', '=', 'data_gajis.nama')
        ->select('data_karyawans.*', 'data_gajis.gaji_pokok')
        ->get();
        $dateFrom = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime('-1 months')), 26, date("Y")));
        $dateTo = date("Y-m-d", mktime(0, 0, 0, date("m"), 15, date("Y")));

        $newArr = array();
        for($i=0; $i<count($karyawan); $i++){
            $status = 0;
            $data = Penggajian::where('id_karyawan', '=', $karyawan[$i]->id)
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->get();
            if(count($data) == 0){
                $status = 0;
                $id_penggajian = '';
                $biaya_lain = 0;
                $total_gaji = 0;
            } else {
                $status = 1;
                $id_penggajian = $data[0]->id;
                $biaya_lain = $data[0]->biaya_lain;
                $total_gaji = $data[0]->total_gaji;
            }
            $obj = (Object)[
                'id_penggajian' => $id_penggajian,
                'id_karyawan' => $karyawan[$i]->id,
                'nama' => $karyawan[$i]->nama,
                'jabatan' => $karyawan[$i]->jabatan,
                'gaji_pokok' => $karyawan[$i]->gaji_pokok,
                'biaya_lain' => $biaya_lain,
                'status' => $status,
                'total_gaji' => $total_gaji
            ];
            array_push($newArr, $obj);
        }
        return $newArr;
    }

    public function inputPenggajian(Request $request)
    {
        $biaya = '';
        for($i=0; $i< count($request['biaya_lain']); $i++){
            $biaya .= $request['biaya_lain'][$i]['nama'].':'.$request['biaya_lain'][$i]['jumlah'];
            if($i != count($request['biaya_lain'])){
                $biaya .= ';';
            }
        }
        return Penggajian::create([
            'id_karyawan' => $request['id_karyawan'],
            'gaji_pokok' => $request['gaji_pokok'],
            'biaya_lain' => $biaya,
            'total_gaji' => $request['total_gaji'],
        ]);
    }
    public function editPenggajian(Request $request, $id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $biaya = '';
        for($i=0; $i< count($request['biaya_lain']); $i++){
            $biaya .= $request['biaya_lain'][$i]['nama'].':'.$request['biaya_lain'][$i]['jumlah'];
            if($i != count($request['biaya_lain'])){
                $biaya .= ';';
            }
        }
        $penggajian->update([
            'id_karyawan' => $request['id_karyawan'],
            'gaji_pokok' => $request['gaji_pokok'],
            'biaya_lain' => $biaya,
            'total_gaji' => $request['total_gaji'],
        ]);
    }
}
