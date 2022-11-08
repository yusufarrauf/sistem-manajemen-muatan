<?php

namespace App\Http\Controllers\API;

use App\Angkutan;
use App\AngkutanSupir;
use App\DataKendaraan;
use App\DataOngkos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LockAngkutan;
use App\Perawatan;

class AngkutanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return \DB::table('angkutans')
        ->join('lock_angkutans', 'angkutans.id', '=', 'lock_angkutans.id_angkutan')
        ->select('angkutans.*', 'lock_angkutans.status as isLock')
        ->where('angkutans.isFiltered', '=', 0)
        ->orderBy('tanggal', 'ASC')
        ->get();
    }
    public function reportSupir()
    {
        $user = auth()->user();
        $angkutan = Angkutan::where('nopol', '=', $user->username)
        ->whereMonth('tanggal', '=', date('m'))
        ->whereYear('tanggal', '=', date('Y'))
        ->where('isFiltered', '=', 0)
        ->get();
        $perawatan = Perawatan::where('nopol', '=', $user->username)
        ->whereMonth('tanggal', '=', date('m'))
        ->whereYear('tanggal', '=', date('Y'))
        ->get();

        $angkutanObj = [];
        for($i = 0; $i < count($angkutan); $i++){
            if($angkutan[$i]->asal_pemuatan != "KRNG"){
                $ongkosVendor = DataOngkos::where('asal', '=', $angkutan[$i]->asal_pemuatan)
                ->where('kota', '=', $angkutan[$i]->kota)
                ->where('tujuan', '=', $angkutan[$i]->asal_pemuatan)
                ->first();
            } else {
                $ongkosVendor = DataOngkos::where('asal', '=', $angkutan[$i]->asal_pemuatan)
                ->where('kota', '=', $angkutan[$i]->kota)
                ->first();
            }
            $angkutanObj[] = (Object)[
                'tanggal' => $angkutan[$i]->tanggal,
                'transportir' => $angkutan[$i]->transportir,
                'jenis_angkutan' => $angkutan[$i]->jenis_angkutan,
                'asal_pemuatan' => $angkutan[$i]->asal_pemuatan,
                'no_surat' => $angkutan[$i]->no_surat,
                'tujuan' => $angkutan[$i]->tujuan,
                'kota' => $angkutan[$i]->kota,
                'tonase' => $angkutan[$i]->tonase,
                'ongkos_angkut' => $ongkosVendor->ongkos_vendor,
                'supir_perton' => $angkutan[$i]->supir_perton,
                'max_tonase' => $angkutan[$i]->max_tonase,
                'ferry' => $angkutan[$i]->ferry,
                'bonus_supir' => $angkutan[$i]->bonus_supir,
                'ton_bonus' => $angkutan[$i]->ton_bonus,
                'total_uj' => $angkutan[$i]->total_uj,
                'panjar' => $angkutan[$i]->panjar,
                'sisa_uj' => $angkutan[$i]->sisa_uj,
                'status' => $angkutan[$i]->status
            ];

        }
        $perawatanObj = [];
            for($i = 0; $i < count($perawatan); $i++){
                $perawatanObj[] = (Object)[
                    'tanggal' => $perawatan[$i]->tanggal,
                    'sparepart' => $perawatan[$i]->sparepart,
                    'harga' => $perawatan[$i]->harga,
                    'satuan' => $perawatan[$i]->satuan,
                    'total' => $perawatan[$i]->total,
                ];
            }

        $newArr = [(Object)[
            'nopol' => strtoupper($user->username),
            'tanggal' => date("Y-m-d"),
            'angkutan' => $angkutanObj,
            'perawatan' => $perawatanObj,
        ]];
        return $newArr;
    }
    public function filterReportSupir(Request $request)
    {
        $user = auth()->user();
        $angkutan = Angkutan::where('nopol', '=', $user->username)
        ->whereMonth('tanggal', '=', $request['bulan']+1)
        ->whereYear('tanggal', '=', $request['tahun'])
        ->where('isFiltered', '=', 0)
        ->get();
        $perawatan = Perawatan::where('nopol', '=', $user->username)
        ->whereMonth('tanggal', '=', $request['bulan']+1)
        ->whereYear('tanggal', '=', $request['tahun'])
        ->get();

        $angkutanObj = [];
        for($i = 0; $i < count($angkutan); $i++){
            $ongkosVendor = DataOngkos::where('asal', '=', $angkutan[$i]->asal_pemuatan)
            ->where('tujuan', '=', $angkutan[$i]->tujuan)
            ->where('kota', '=', $angkutan[$i]->kota)
            ->first();
            $angkutanObj[] = (Object)[
                'tanggal' => $angkutan[$i]->tanggal,
                'transportir' => $angkutan[$i]->transportir,
                'jenis_angkutan' => $angkutan[$i]->jenis_angkutan,
                'asal_pemuatan' => $angkutan[$i]->asal_pemuatan,
                'no_surat' => $angkutan[$i]->no_surat,
                'tujuan' => $angkutan[$i]->tujuan,
                'kota' => $angkutan[$i]->kota,
                'tonase' => $angkutan[$i]->tonase,
                'ongkos_angkut' => $ongkosVendor->ongkos_vendor,
                'supir_perton' => $angkutan[$i]->supir_perton,
                'max_tonase' => $angkutan[$i]->max_tonase,
                'ferry' => $angkutan[$i]->ferry,
                'bonus_supir' => $angkutan[$i]->bonus_supir,
                'ton_bonus' => $angkutan[$i]->ton_bonus,
                'total_uj' => $angkutan[$i]->total_uj,
                'panjar' => $angkutan[$i]->panjar,
                'sisa_uj' => $angkutan[$i]->sisa_uj,
                'status' => $angkutan[$i]->status
            ];

        }
        $perawatanObj = [];
            for($i = 0; $i < count($perawatan); $i++){
                $perawatanObj[] = (Object)[
                    'tanggal' => $perawatan[$i]->tanggal,
                    'sparepart' => $perawatan[$i]->sparepart,
                    'harga' => $perawatan[$i]->harga,
                    'satuan' => $perawatan[$i]->satuan,
                    'total' => $perawatan[$i]->total,
                ];
            }

        $newArr = [(Object)[
            'nopol' => strtoupper($user->username),
            'tanggal' => date_format(date_create($request['tahun'].'-'.($request['bulan']+1).'-01'), "Y-m-d"),
            'angkutan' => $angkutanObj,
            'perawatan' => $perawatanObj,
        ]];
        return $newArr;
    }
    public function rekapSupir(Request $request)
    {
        $this->validate($request,[
            'nopol' => 'required'
        ],[
            'nopol.required' => 'Silahkan Pilih Nomor Polisi Terlebih Dahulu!'
        ]);
        $nopol = explode(' ', $request['nopol']);
        $request['nopol'] = $nopol[0].$nopol[1].$nopol[2];
        $angkutan = Angkutan::where('nopol', '=', $request['nopol'])
        ->where('isFiltered', '=', 0)
        ->whereMonth('tanggal', '=', $request['bulan']+1)
        ->whereYear('tanggal', '=', $request['tahun'])
        ->get();
        $perawatan = Perawatan::where('nopol', '=', $request['nopol'])
        ->whereMonth('tanggal', '=', $request['bulan']+1)
        ->whereYear('tanggal', '=', $request['tahun'])
        ->get();

        $angkutanObj = [];
        for($i = 0; $i < count($angkutan); $i++){
            $angkutanObj[] = (Object)[
                'tanggal' => $angkutan[$i]->tanggal,
                'transportir' => $angkutan[$i]->transportir,
                'jenis_angkutan' => $angkutan[$i]->jenis_angkutan,
                'asal_pemuatan' => $angkutan[$i]->asal_pemuatan,
                'no_surat' => $angkutan[$i]->no_surat,
                'tujuan' => $angkutan[$i]->tujuan,
                'kota' => $angkutan[$i]->kota,
                'tonase' => $angkutan[$i]->tonase,
                'ongkos_angkut' => $angkutan[$i]->ongkos_angkut,
                'supir_perton' => $angkutan[$i]->supir_perton,
                'max_tonase' => $angkutan[$i]->max_tonase,
                'ferry' => $angkutan[$i]->ferry,
                'bonus_supir' => $angkutan[$i]->bonus_supir,
                'ton_bonus' => $angkutan[$i]->ton_bonus,
                'total_uj' => $angkutan[$i]->total_uj,
                'panjar' => $angkutan[$i]->panjar,
                'sisa_uj' => $angkutan[$i]->sisa_uj,
                'status' => $angkutan[$i]->status
            ];

        }
        $perawatanObj = [];
            for($i = 0; $i < count($perawatan); $i++){
                $perawatanObj[] = (Object)[
                    'tanggal' => $perawatan[$i]->tanggal,
                    'sparepart' => $perawatan[$i]->sparepart,
                    'harga' => $perawatan[$i]->harga,
                    'satuan' => $perawatan[$i]->satuan,
                    'total' => $perawatan[$i]->total,
                ];
            }

        $newArr = [(Object)[
            'nopol' => $request['nopol'],
            'tanggal' => date_format(date_create($request['tahun'].'-'.($request['bulan']+1).'-01'), "Y-m-d"),
            'angkutan' => $angkutanObj,
            'perawatan' => $perawatanObj,
        ]];
        return $newArr;
    }
    public function rekapVendor(Request $request)
    {
        $this->validate($request,[
            'vendor' => 'required'
        ],[
            'vendor.required' => 'Silahkan Pilih Vendor Terlebih Dahulu!'
        ]);
        $kendaraan = DataKendaraan::where('vendor', '=', $request['vendor'])->get();
        $angkutan = Angkutan::where('isFiltered', '=', 0)
        ->whereMonth('tanggal', '=', $request['bulan']+1)
        ->whereYear('tanggal', '=', $request['tahun'])
        ->get();

        $angkutanObj = [];
        for($i = 0; $i < count($angkutan); $i++){
            for($j = 0; $j < count($kendaraan); $j++){
                if($angkutan[$i]->nopol == $kendaraan[$j]->nopol){
                    $angkutanObj[] = (Object)[
                        'nopol' => $angkutan[$i]->nopol,
                        'tanggal' => $angkutan[$i]->tanggal,
                        'transportir' => $angkutan[$i]->transportir,
                        'jenis_angkutan' => $angkutan[$i]->jenis_angkutan,
                        'asal_pemuatan' => $angkutan[$i]->asal_pemuatan,
                        'no_surat' => $angkutan[$i]->no_surat,
                        'tujuan' => $angkutan[$i]->tujuan,
                        'kota' => $angkutan[$i]->kota,
                        'tonase' => $angkutan[$i]->tonase,
                        'ongkos_angkut' => $angkutan[$i]->ongkos_angkut,
                        'supir_perton' => $angkutan[$i]->supir_perton,
                        'max_tonase' => $angkutan[$i]->max_tonase,
                        'ferry' => $angkutan[$i]->ferry,
                        'bonus_supir' => $angkutan[$i]->bonus_supir,
                        'ton_bonus' => $angkutan[$i]->ton_bonus,
                        'total_uj' => $angkutan[$i]->total_uj,
                        'panjar' => $angkutan[$i]->panjar,
                        'sisa_uj' => $angkutan[$i]->sisa_uj,
                        'status' => $angkutan[$i]->status
                    ];
                }
            }
        }
        $newArr = [(Object)[
            'nopol' => $request['nopol'],
            'tanggal' => date_format(date_create($request['tahun'].'-'.($request['bulan']+1).'-01'), "Y-m-d"),
            'angkutan' => $angkutanObj,
        ]];
        return $newArr;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nopol = explode(' ', strtoupper($request['nopol']));
        if($request['asal'] == "KRNG" ){
            $prop = 'awal';
            $surat = 'required|min:5';
            $msg = 'Nomor Surat Tidak Boleh Kosong';
        } else if($request['asal'] == "HAOHAN CEMENT" ){
            $prop = 'akhir';
            $surat = 'required|min:5';
            $msg = 'Nomor Surat Tidak Boleh Kosong';
        } else {
            $prop = 'awal';
            $surat = '';
            $msg = '';
        }

        if($request['tonase'] > 31){
            $bonus = 'required|gt:0';
        } else {
            $bonus = '';
        }
        $this->validate($request,[
            'tanggal' => 'required',
            'nopol' => 'required',
            'transportir' => 'required',
            'jenis' => 'required',
            'asal' => 'required',
            'no_surat.'.$prop => $surat,
            'tujuan' => 'required',
            'kota' => 'required',
            'tonase' => 'required|gt:0',
            'ongkos.jumlah' => 'required|gt:0',
            'sopir.jumlah' => 'required|gt:0',
            'max_ton' => 'required|gt:0',
            'bonus.biaya' => $bonus,
        ],[
            'tanggal.required' => 'Tanggal Tidak Boleh Kosong',
            'nopol.required' => 'Nomor Polisi Belum Dipilih',
            'transportir.required' => 'Transportir Tidak Boleh Kosong',
            'jenis.required' => 'Jenis Muatan Tidak Boleh Kosong',
            'asal.required' => 'Asal Muatan Tidak Boleh Kosong',
            'no_surat.*.required' => $msg,
            'no_surat.*.min' => 'Panjang Nomor Surat Minimal 5',
            'tujuan.required' => 'Tujuan Angkutan Tidak Boleh Kosong',
            'kota.required' => 'Kota Tujuan Tidak Boleh Kosong',
            'tonase.gt' => 'Jumlah Angkutan Harus Lebih Dari 0',
            'ongkos.jumlah.gt' => 'Jumlah Ongkos Harus Lebih Dari 0',
            'sopir.jumlah.gt' => 'Jumlah Sopir @TON Harus Lebih Dari 0',
            'max_ton.gt' => 'Jumlah Maksimal Angkutan Harus Lebih Dari 0',
            'bonus.biaya.gt' => 'Jumlah Bonus Harus Lebih Dari 0',
            'panjar.gt' => 'Jumlah Panjar Harus Lebih Dari 0',
        ]);
        $angkutan = Angkutan::create([
            'nopol' => $nopol[0].$nopol[1].$nopol[2],
            'tanggal' => $request['tanggal'],
            'transportir' => $request['transportir'],
            'jenis_angkutan' => $request['jenis'],
            'asal_pemuatan' => $request['asal'],
            'no_surat' => $request['no_surat']['awal'].$request['no_surat']['akhir'],
            'tujuan' => $request['tujuan'],
            'kota' => $request['kota'],
            'tonase' => $request['tonase'],
            'ongkos_angkut' => $request['ongkos']['jumlah'],
            'supir_perton' => $request['sopir']['jumlah'],
            'max_tonase' => $request['max_ton'],
            'ferry' => $request['ferry'],
            'bonus_supir' => $request['bonus']['biaya'],
            'ton_bonus' => $request['bonus']['jumlah'],
            'total_uj' => $request['total_uj'],
            'panjar' => $request['panjar'],
            'sisa_uj' => $request['sisa'],
            'status' => 'BELUM DIBAYAR'
        ])->id;

        if($request['tonase'] > 35){
            $reTon = 35;
        } else {
            $reTon = $request['tonase'];
        }
        if($request['tonase'] > 31){
            $bonusTon = $reTon - 31;
        } else {
            $bonusTon = 0;
        }
        AngkutanSupir::create([
            'id' => $angkutan,
            'nopol' => $nopol[0].$nopol[1].$nopol[2],
            'tanggal' => $request['tanggal'],
            'transportir' => $request['transportir'],
            'jenis_angkutan' => $request['jenis'],
            'asal_pemuatan' => $request['asal'],
            'no_surat' => $request['no_surat']['awal'].$request['no_surat']['akhir'],
            'tujuan' => $request['tujuan'],
            'kota' => $request['kota'],
            'tonase' => $reTon,
            'ongkos_angkut' => $request['ongkos']['jumlah'],
            'supir_perton' => $request['sopir']['jumlah'],
            'max_tonase' => $reTon,
            'ferry' => $request['ferry'],
            'bonus_supir' => $request['bonus']['biaya'],
            'ton_bonus' => $bonusTon,
            'total_uj' => ($request['sopir']['jumlah'] * $reTon) + ($request['bonus']['biaya'] * $bonusTon),
            'panjar' => $request['panjar'],
            'sisa_uj' => 0,
            'status' => 'BELUM DIBAYAR'
        ]);

        return LockAngkutan::create([
            'id_angkutan' => $angkutan,
            'status' => "LOCK",
            'password' => '',
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
        $angkutan = Angkutan::findOrFail($id);
        if($angkutan->asal_pemuatan == 'KRNG'){
            $awal = substr($angkutan->no_surat,0,5);
            $akhir = substr($angkutan->no_surat,5);
        }
        else if ($angkutan->asal_pemuatan == 'HAOHAN CEMENT'){
            $awal = substr($angkutan->no_surat,0,9);
            $akhir = substr($angkutan->no_surat,9);
        } else {
            $awal = $angkutan->no_surat;
            $akhir = '';
        }
        preg_match_all('/([0-9]+|[a-zA-Z]+)/', $angkutan->nopol, $newnopol);
        $newArr = array();
        $newObj = (object)[
            'id' => $angkutan->id,
            'nopol' => $newnopol[0][0].' '.$newnopol[0][1].' '.$newnopol[0][2],
            'tanggal' => $angkutan->tanggal,
            'transportir' => $angkutan->transportir,
            'jenis' => $angkutan->jenis_angkutan,
            'asal' => $angkutan->asal_pemuatan,
            'no_surat' => (object)[
                'awal' => $awal,
                'akhir' => $akhir,
            ],
            'tujuan' => $angkutan->tujuan,
            'kota' => $angkutan->kota,
            'tonase' => $angkutan->tonase,
            'ongkos' => (object)[
                'jumlah' => $angkutan->ongkos_angkut,
                'total' => $angkutan->ongkos_angkut * $angkutan->tonase,
            ],
            'sopir' => (object)[
                'jumlah' => $angkutan->supir_perton,
                'total' => $angkutan->supir_perton * $angkutan->tonase,
            ],
            'ferry' => $angkutan->ferry,
            'max_ton' => $angkutan->max_tonase,
            'bonus' => (object)[
                'biaya' => $angkutan->bonus_supir,
                'jumlah' => $angkutan->ton_bonus,
                'total' => $angkutan->bonus_supir * $angkutan->ton_bonus,
            ],
            'total_uj' => $angkutan->total_uj,
            'panjar' => $angkutan->panjar,
            'sisa' => $angkutan->sisa_uj
        ];
        $newArr[0] = $newObj;
        return $newArr;
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
        $nopol = explode(' ', strtoupper($request['nopol']));
        $angkutan = Angkutan::findOrFail($id);
        $angkutanSupir = AngkutanSupir::findOrFail($id);
        $LockAngkutan = LockAngkutan::where('id_angkutan', '=', $angkutan->id)->first();
        if($request['asal'] == "KRNG" ){
            $prop = 'awal';
            $surat = 'required|min:5';
            $msg = 'Nomor Surat Tidak Boleh Kosong';
        } else if($request['asal'] == "HAOHAN CEMENT" ){
            $prop = 'akhir';
            $surat = 'required|min:5';
            $msg = 'Nomor Surat Tidak Boleh Kosong';
        } else {
            $prop = 'awal';
            $surat = '';
            $msg = '';
        }

        if($request['tonase'] > 31){
            $bonus = 'required|gt:0';
        } else {
            $bonus = '';
        }

        $this->validate($request,[
            'tanggal' => 'required',
            'nopol' => 'required',
            'transportir' => 'required',
            'jenis' => 'required',
            'asal' => 'required',
            'no_surat.'.$prop => $surat,
            'tujuan' => 'required',
            'kota' => 'required',
            'tonase' => 'required|gt:0',
            'ongkos.jumlah' => 'required|gt:0',
            'sopir.jumlah' => 'required|gt:0',
            'max_ton' => 'required|gt:0',
            'bonus.biaya' => $bonus,
        ],[
            'tanggal.required' => 'Tanggal Tidak Boleh Kosong',
            'nopol.required' => 'Nomor Polisi Belum Dipilih',
            'transportir.required' => 'Transportir Tidak Boleh Kosong',
            'jenis.required' => 'Jenis Muatan Tidak Boleh Kosong',
            'asal.required' => 'Asal Muatan Tidak Boleh Kosong',
            'no_surat.*.required' => $msg,
            'no_surat.*.min' => 'Panjang Nomor Surat Minimal 5',
            'tujuan.required' => 'Tujuan Angkutan Tidak Boleh Kosong',
            'kota.required' => 'Kota Tujuan Tidak Boleh Kosong',
            'tonase.gt' => 'Jumlah Angkutan Harus Lebih Dari 0',
            'ongkos.jumlah.gt' => 'Jumlah Ongkos Harus Lebih Dari 0',
            'sopir.jumlah.gt' => 'Jumlah Sopir @TON Harus Lebih Dari 0',
            'max_ton.gt' => 'Jumlah Maksimal Angkutan Harus Lebih Dari 0',
            'bonus.biaya.gt' => 'Jumlah Bonus Harus Lebih Dari 0',
            'panjar.gt' => 'Jumlah Panjar Harus Lebih Dari 0',
        ]);
        if($LockAngkutan->status == 'LOCK'){
            return response()->json([
                'status_code' => '403',
                'status' => 'Forbidden',
                'message' => 'Anda Tidak Memiliki Akses!!'
            ], 403);
        }

        $angkutan->update([
            'nopol' => $nopol[0].$nopol[1].$nopol[2],
            'tanggal' => $request['tanggal'],
            'transportir' => $request['transportir'],
            'jenis_angkutan' => $request['jenis'],
            'asal_pemuatan' => $request['asal'],
            'no_surat' => $request['no_surat']['awal'].$request['no_surat']['akhir'],
            'tujuan' => $request['tujuan'],
            'kota' => $request['kota'],
            'tonase' => $request['tonase'],
            'ongkos_angkut' => $request['ongkos']['jumlah'],
            'supir_perton' => $request['sopir']['jumlah'],
            'max_tonase' => $request['max_ton'],
            'ferry' => $request['ferry'],
            'bonus_supir' => $request['bonus']['biaya'],
            'ton_bonus' => $request['bonus']['jumlah'],
            'total_uj' => $request['total_uj'],
            'panjar' => $request['panjar'],
            'sisa_uj' => $request['sisa'],
        ]);
        if($request['tonase'] > 35){
            $reTon = 35;
        } else {
            $reTon = $request['tonase'];
        }
        if($request['tonase'] > 31){
            $bonusTon = $reTon - 31;
        } else {
            $bonusTon = 0;
        }
        $angkutanSupir->update([
            'nopol' => $nopol[0].$nopol[1].$nopol[2],
            'tanggal' => $request['tanggal'],
            'transportir' => $request['transportir'],
            'jenis_angkutan' => $request['jenis'],
            'asal_pemuatan' => $request['asal'],
            'no_surat' => $request['no_surat']['awal'].$request['no_surat']['akhir'],
            'tujuan' => $request['tujuan'],
            'kota' => $request['kota'],
            'tonase' => $reTon,
            'ongkos_angkut' => $request['ongkos']['jumlah'],
            'supir_perton' => $request['sopir']['jumlah'],
            'max_tonase' => $reTon,
            'ferry' => $request['ferry'],
            'bonus_supir' => $request['bonus']['biaya'],
            'ton_bonus' => $bonusTon,
            'total_uj' => ($request['sopir']['jumlah'] * $reTon) + ($request['bonus']['biaya'] * $bonusTon),
            'panjar' => $request['panjar'],
            'sisa_uj' => 0,
            'status' => 'BELUM DIBAYAR'
        ]);

        $LockAngkutan->update([
            'status' => 'LOCK',
            'password' => ''
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
        $angkutan = Angkutan::findOrFail($id);
        $angkutanSupir = AngkutanSupir::findOrFail($id);
        $angkutan->delete();
        $angkutanSupir->delete();
    }
    public function filter(Request $request)
    {
        $angkutan = Angkutan::whereMonth('tanggal', $request['bulan']+1)
        ->whereYear('tanggal', $request['tahun'])
        ->where('isFiltered', '=', 0)
        ->get();
        return $angkutan;
    }
    public function angkutanVendor()
    {
        return \DB::table('angkutan_supirs')
        ->join('lock_angkutans', 'angkutan_supirs.id', '=', 'lock_angkutans.id_angkutan')
        ->select('angkutan_supirs.*', 'lock_angkutans.status as isLock')
        ->where('angkutan_supirs.isFiltered', '=', 0)
        ->orderBy('tanggal', 'ASC')
        ->get();
    }
    public function filterVendor(Request $request)
    {
        $angkutan = AngkutanSupir::whereMonth('tanggal', $request['bulan']+1)
        ->whereYear('tanggal', $request['tahun'])
        ->where('isFiltered', '=', 0)
        ->orderBy('tanggal', 'ASC')
        ->get();
        return $angkutan;
    }
    public function updateStatus(Request $request)
    {
        $angkutan = Angkutan::findOrFail($request['id']);
        $angkutan->update($request->all());
    }
    public function updateLock(Request $request)
    {
        $user = auth()->user()->level;
        if($user == "Super Admin"){
            $angkutan = LockAngkutan::where('id_angkutan', '=',$request['id']);
            if($request['status'] == 'LOCK'){
                $unlock = 'required|min:6';
            } else {
                $unlock = '';
                $request['status'] = 'LOCK';
            }
            $this->validate($request,[
                'password' => $unlock
            ]);

            $angkutan->update($request->all());
        } else {
            return response()->json([
                'status_code' => '403',
                'status' => 'Forbidden',
                'message' => 'Anda Tidak Memiliki Akses!!'
            ], 403);
        }

    }
    public function getUnlock(Request $request)
    {
        $angkutan = LockAngkutan::where('id_angkutan', '=', $request['id'])->first();
        if($angkutan->status == 'LOCK' && $angkutan->password == ''){
            return response()->json([
                'status_code' => '500',
                'status' => 'warning',
                'message' => 'Data Dikunci!! Silahkan Minta Password Kepada Super Admin!!'
            ], 500);
        }
        $this->validate($request,[
            'password' => 'required|in:'.$angkutan->password,
        ],[
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.in' => 'Password Salah!'
        ]);
        $request['status'] = 'UNLOCK';
        $angkutan->update($request->all());
    }
    public function angkutanPalembang(){
        return \DB::table('angkutans')
        ->join('data_kendaraans', 'angkutans.nopol', '=', 'data_kendaraans.nopol')
        ->select('angkutans.*', 'data_kendaraans.vendor')
        ->where('data_kendaraans.vendor', '=', "DWI PLG")
        ->get();
    }
    public function filterAngkutanPalembang(Request $request){
        return \DB::table('angkutans')
        ->join('data_kendaraans', 'angkutans.nopol', '=', 'data_kendaraans.nopol')
        ->select('angkutans.*', 'data_kendaraans.vendor')
        ->where('data_kendaraans.vendor', '=', "DWI PLG")
        ->whereMonth('angkutans.tanggal', $request['bulan']+1)
        ->whereYear('angkutans.tanggal', $request['tahun'])
        ->get();
    }
    public function updateIsFiltered(Request $request){
        $angkutan = Angkutan::findOrFail($request['id']);
        $angkutan->isFiltered = $request['status'];
        $angkutan->save();
    }
}
