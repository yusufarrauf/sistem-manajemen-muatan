<?php

namespace App\Http\Controllers\API;

use App\ApprovalPerawatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Perawatan;

class PerawatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Perawatan::all();
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
            'nopol' => 'required'
        ]);
        $nopol = explode(' ', $request['nopol']);
        $request['nopol'] = $nopol[0].$nopol[1].$nopol[2];

        for($i = 0; $i < count($request['sparepart']); $i++){
            $count = 0;
            $perawatan = Perawatan::where('nopol','=', $request['nopol'])
            ->whereMonth('tanggal', date("m"))
            ->whereYear('tanggal', date("Y"))
            ->get();
            for($a=0; $a<count($perawatan);$a++){
                $str = explode(' ', strtoupper($perawatan[$a]->sparepart));
                for($j=0; $j < count($str); $j++){
                    $newstr = count_chars($str[$j], 3);
                    if($newstr == "ABN"){
                        $count += 1;
                    }
                }
            }
            $str = explode(' ', strtoupper($request['sparepart'][$i]['nama']));
            $isFind = 0;
            for($j=0; $j < count($str); $j++){
                $newstr = count_chars($str[$j], 3);
                if($newstr = "ABN"){
                    $isFind = 1;
                }
            }
            if($count >= 3){
                if($isFind == 0){
                    Perawatan::create([
                        'nopol' => $request['nopol'],
                        'tanggal' => $request['tanggal'],
                        'sparepart' => $request['sparepart'][$i]['nama'],
                        'harga' => $request['sparepart'][$i]['harga'],
                        'satuan' => $request['sparepart'][$i]['satuan'],
                        'total' => $request['sparepart'][$i]['total'],
                    ]);
                } else {
                    ApprovalPerawatan::create([
                        'nopol' => $request['nopol'],
                        'tanggal' => $request['tanggal'],
                        'sparepart' => $request['sparepart'][$i]['nama'],
                        'harga' => $request['sparepart'][$i]['harga'],
                        'satuan' => $request['sparepart'][$i]['satuan'],
                        'total' => $request['sparepart'][$i]['total'],
                        'isApprove' => 1
                    ]);
                }
            } else {
                Perawatan::create([
                    'nopol' => $request['nopol'],
                    'tanggal' => $request['tanggal'],
                    'sparepart' => $request['sparepart'][$i]['nama'],
                    'harga' => $request['sparepart'][$i]['harga'],
                    'satuan' => $request['sparepart'][$i]['satuan'],
                    'total' => $request['sparepart'][$i]['total'],
                ]);
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $perawatan = Perawatan::findOrFail($id);
        $perawatan->update([
                'tanggal' => $request['tanggal'],
                'sparepart' => $request['sparepart'],
                'harga' => $request['harga'],
                'satuan' => $request['satuan'],
                'total' => $request['total'],
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
        $perawatan = Perawatan::findOrFail($id);
        $perawatan->delete();
    }
    public function filter(Request $request)
    {
        $this->validate($request,[
            'nopol' => 'required'
        ],[
            'nopol.required' => 'Silahkan Pilih Nomor Polisi Terlebih Dahulu!'
        ]);
        $nopol = explode(' ', $request['nopol']);
        $request['nopol'] = $nopol[0].$nopol[1].$nopol[2];
        $perawatan = Perawatan::where('nopol', '=', $request['nopol'])
        ->whereMonth('tanggal', $request['bulan']+1)
        ->whereYear('tanggal', $request['tahun'])
        ->orderBy('tanggal', 'ASC')
        ->get();

        $newArr = [];
        foreach($perawatan as $key => $value){
            $newArr[] = $value;
        }

        return $newArr;
    }
    public function getLimit(Request $request){
        $tanggal = explode('-', $request['tanggal']);
        $count = 0;
        $nopol = explode(' ', $request['nopol']);
        $request['nopol'] = $nopol[0].$nopol[1].$nopol[2];
        $perawatan = Perawatan::where('nopol','=', $request['nopol'])
        ->whereMonth('tanggal', $tanggal[1])
        ->whereYear('tanggal', $tanggal[0])
        ->get();
        for($i=0; $i<count($perawatan);$i++){
            $str = explode(' ', strtoupper($perawatan[$i]->sparepart));
            for($j=0; $j < count($str); $j++){
                $newstr = count_chars($str[$j], 3);
                if($newstr == "ABN"){
                    $count += 1;
                }
            }
        }
        return $count;
    }
    public function approvalData(){
        return ApprovalPerawatan::all();
    }
    public function filterApprovalData(Request $request){
        return ApprovalPerawatan::whereMonth('tanggal', $request['bulan']+1)
        ->whereYear('tanggal', $request['tahun'])
        ->get();
    }
    public function updateApprovalData(Request $request){
        $perawatan = ApprovalPerawatan::findOrFail($request['id']);
        if($request['status'] == 2){
            Perawatan::create([
                'nopol' => $perawatan->nopol,
                'tanggal' => $perawatan->tanggal,
                'sparepart' => $perawatan->sparepart,
                'harga' => $perawatan->harga,
                'satuan' => $perawatan->satuan,
                'total' => $perawatan->total,
            ]);
        }
        $perawatan->isApprove = $request['status'];
        $perawatan->save();
    }
}
