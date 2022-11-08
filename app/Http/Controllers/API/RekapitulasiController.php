<?php

namespace App\Http\Controllers\API;

use App\Angkutan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rekapitulasi;

class RekapitulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Rekapitulasi::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = 0;
        foreach($request['jenis'] as $jenis){
            if($jenis == true){
                $count += 1;
            }
        }
        if($count == 0){
            $request['jenis'] = "";
            $rule = 'required';
        } else {
            $rule = '';
        }
        // return $request->all();
        $this->validate($request,[
            'nama' => 'required',
            'jenis' => $rule,
            'range_from' => 'required',
            'range_to' => 'required|after:range_from'
        ],[
            'nama.required' => 'Nama Inisial Tidak Boleh Kosong!',
            'jenis.required' => 'PILIH SETIDAKNYA 1 JENIS!',
            'range_from.required' => 'Tanggal Awal Tidak Boleh Kosong!',
            'range_to.required' => 'Tanggal Akhir Tidak Boleh Kosong!',
            'range_to.after' => 'Tanggal Akhir Harus Lebih Dari Tanggal Awal!',
        ]);
        $initDate = explode('-', $request['range_from']);
        $initNo = substr(strtotime('now'), 5);
        $autoID = 'RKP'.'-'.$initNo.$initDate[0].$initDate[1];

        $jenis = '';
        $count = 0;
        foreach($request['jenis'] as $values){
            if($values == true){
                $jenis .= 1;
            } else {
                $jenis .= 0;
            }
            $count += 1;
            if($count < 4){
                $jenis .= ';';
            }
        }

        return Rekapitulasi::create([
            'kode' => $autoID,
            'nama' => $request['nama'],
            'ke' => $request['ke'],
            'jenis' => $jenis,
            'range_from' => $request['range_from'],
            'range_to' => $request['range_to'],
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $rekapitulasi = Rekapitulasi::where('kode', '=', $id);
        $count = 0;
        foreach($request['jenis'] as $jenis){
            if($jenis == true){
                $count += 1;
            }
        }
        if($count == 0){
            $request['jenis'] = "";
            $rule = 'required';
        } else {
            $rule = '';
        }
        $this->validate($request,[
            'nama' => 'required',
            'jenis' => $rule,
            'range_from' => 'required',
            'range_to' => 'required|after:range_from'
        ],[
            'nama.required' => 'Nama Inisial Tidak Boleh Kosong!',
            'jenis.required' => 'PILIH SETIDAKNYA 1 JENIS!',
            'range_from.required' => 'Tanggal Awal Tidak Boleh Kosong!',
            'range_to.required' => 'Tanggal Akhir Tidak Boleh Kosong!',
            'range_to.after' => 'Tanggal Akhir Harus Lebih Dari Tanggal Awal!',
        ]);
        $initDate = explode('-', $request['range_from']);
        $initNo = substr(strtotime('now'), 5);
        $autoID = 'RKP'.'-'.$initNo.$initDate[0].$initDate[1];
        $jenis = '';
        $count = 0;
        foreach($request['jenis'] as $values){
            if($values == true){
                $jenis .= 1;
            } else {
                $jenis .= 0;
            }
            $count += 1;
            if($count < 4){
                $jenis .= ';';
            }
        }
        $rekapitulasi->update([
            'kode' => $autoID,
            'nama' => $request['nama'],
            'ke' => $request['ke'],
            'jenis' => $jenis,
            'range_from' => $request['range_from'],
            'range_to' => $request['range_to'],
        ]);
    }

    public function destroy($id)
    {
        $rekapitulasi = Rekapitulasi::findOrFail($id);
        $rekapitulasi->delete();
    }

    public function filter(Request $request)
    {
        return Rekapitulasi::whereMonth('range_from', $request['bulan']+1)
        ->whereYear('range_from', $request['tahun'])
        ->orderBy('created_at', 'asc')
        ->get();
    }
}
