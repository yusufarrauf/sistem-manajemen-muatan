<?php

namespace App\Http\Controllers;

use App\Angkutan;
use App\DataKaryawan;
use App\Kendaraan;
use App\Penggajian;
use App\Perawatan;
use App\Plant;
use App\Rekapitulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('template');
    }

    public function printPerawatan($bulan, $tahun, $nopol)
    {
        $perawatan = Perawatan::where('nopol', '=', $nopol)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal', 'asc')
        ->get();
        // return $perawatan->groupBy('tanggal');
        return view('print.perawatan', compact('perawatan'));
    }
    public function printRekapInvoice($kode){
        $rekap = Rekapitulasi::where('kode', '=', $kode)->get();
        $perawatan = Perawatan::whereDate('tanggal', '>=', $rekap[0]->range_from)
        ->whereDate('tanggal', '<=', $rekap[0]->range_to)
        ->orderBy('tanggal', 'ASC')
        ->get();
        $angkutan = Angkutan::whereDate('tanggal', '>=', $rekap[0]->range_from)
        ->whereDate('tanggal', '<=', $rekap[0]->range_to)
        ->orderBy('tanggal', 'ASC')
        ->get();
        return view('print.rekap-invoice', compact('rekap', 'perawatan', 'angkutan'));
    }
    public function printRekapAngkutan($kode){
        $rekap = Rekapitulasi::where('kode', '=', $kode)->get();
        $asal_muatan = [];
        $jenis = explode(';', $rekap[0]->jenis);
        if($jenis[0] == 1){
            array_push($asal_muatan, 'HAOHAN CEMENT');
        }
        if($jenis[1] == 1){
            array_push($asal_muatan, 'KRNG');
        }
        if($jenis[2] == 1){
            array_push($asal_muatan, 'WANGDA');
        }
        if($jenis[3] == 1){
            array_push($asal_muatan, 'WSD');
        }
        $angkutan = Angkutan::whereIn('asal_pemuatan', $asal_muatan)
        ->whereDate('tanggal', '>=', $rekap[0]->range_from)
        ->whereDate('tanggal', '<=', $rekap[0]->range_to)
        ->orderBy('tanggal', 'ASC')
        ->get();
        return view('print.rekap-angkutan', compact('rekap', 'angkutan'));
    }
    public function exportExcel($kode){
        $rekap = Rekapitulasi::where('kode', '=', $kode)->get();
        $asal_muatan = [];
        $jenis = explode(';', $rekap[0]->jenis);
        if($jenis[0] == 1){
            array_push($asal_muatan, 'HAOHAN CEMENT');
        }
        if($jenis[1] == 1){
            array_push($asal_muatan, 'KRNG');
        }
        if($jenis[2] == 1){
            array_push($asal_muatan, 'WANGDA');
        }
        if($jenis[3] == 1){
            array_push($asal_muatan, 'WSD');
        }
        $angkutan = Angkutan::whereIn('asal_pemuatan', $asal_muatan)
        ->whereDate('tanggal', '>=', $rekap[0]->range_from)
        ->whereDate('tanggal', '<=', $rekap[0]->range_to)
        ->orderBy('tanggal', 'ASC')
        ->get();
        return view('print.exportExcel', compact('rekap', 'angkutan'));
    }
    public function printPersupir($bulan, $tahun, $nopol)
    {
        $angkutan = Angkutan::where('nopol', '=', $nopol)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal', 'asc')
        ->get();

        $perawatan = Perawatan::where('nopol', '=', $nopol)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal', 'asc')
        ->get();
        $identity = [
            $bulan, $tahun, $nopol
        ];
        return view('print.rekap-persupir', compact('identity', 'angkutan', 'perawatan'));
    }
    public function printSlipGaji($id){
        $penggajian = Penggajian::findOrFail($id);
        $karyawan = DataKaryawan::findOrFail($penggajian->id_karyawan);
        return view('print.slip-gaji', compact('penggajian', 'karyawan'));
    }
}
