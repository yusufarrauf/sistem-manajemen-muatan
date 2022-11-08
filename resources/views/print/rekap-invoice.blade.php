<!DOCTYPE html>
<html lang="en">
@php
$sumTotal = 0;
$sumTonase = 0;
$sumPanjar = 0;
$sumHasil = 0;
$total_price = 0;
$hasil_mobil = 0;
$plant_ton = 0;
$plant_total = 0;
$ton_total = 0;
$price_total = 0;

function penyebut($nilai) {
$nilai = abs($nilai);
$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh",
"Sebelas");
$temp = "";
if ($nilai < 12) { $temp=" " . $huruf[$nilai]; } else if ($nilai <20) { $temp=penyebut($nilai - 10). " Belas" ; } else
    if ($nilai < 100) { $temp=penyebut($nilai/10)." Puluh". penyebut($nilai % 10); } else if ($nilai < 200) {
    $temp=" Seratus" . penyebut($nilai - 100); } else if ($nilai < 1000) { $temp=penyebut($nilai/100) . " Ratus" .
    penyebut($nilai % 100); } else if ($nilai < 2000) { $temp=" Seribu" . penyebut($nilai - 1000); } else if ($nilai <
    1000000) { $temp=penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000); } else if ($nilai < 1000000000) {
    $temp=penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000); } else if ($nilai < 1000000000000) {
    $temp=penyebut($nilai/1000000000) . " Miliar" . penyebut(fmod($nilai,1000000000)); } else if ($nilai <
    1000000000000000) { $temp=penyebut($nilai/1000000000000) . " Triliun" . penyebut(fmod($nilai,1000000000000)); }
    return $temp; } function terbilang($nilai) { if($nilai<0) { $hasil="minus " . trim(penyebut($nilai)); } else {
    $hasil=trim(penyebut($nilai)); } return $hasil; } function dateReformat($tanggal){ $bulan=array ( 1=> 'JANUARI',
    'FEBRUARI',
    'MARET',
    'APRIL',
    'MEI',
    'JUNI',
    'JULI',
    'AGUSTUS',
    'SEPTEMBER',
    'OKTOBER',
    'NOVEMBER',
    'DESEMBER'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
    $awal = explode('-', $rekap[0]['range_from'])[2];
    $akhir = dateReformat($rekap[0]['range_to']);
    $ke = $rekap[0]['ke'];
    $jenis = explode(';', $rekap[0]['jenis']);
    @endphp

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Annisa Rizki - Print Rekap Invoice</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" defer></script>
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            table.table-bordered {
                border: 1px solid black !important;
            }

            table.table-bordered>thead>tr>th {
                border: 1px solid black !important;
                ;
            }

            table.table-bordered>tbody>tr>td {
                border: 1px solid black !important;
                ;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid black !important;
            }

            #footer-ttd {
                display: none;
            }

            @media print {
                .pagebreak {
                    page-break-before: always;
                }

                #footer-ttd {
                    display: block;
                    position: absolute;
                    bottom: 0;
                    width: 100%;
                }

                table {
                    font-size: .8em;
                }
            }

        </style>
    </head>

    <body onload="startTime()">
        @if ($jenis[1] == 1)
        <div class="container-fluid mt-4">
            <div class="row mb-2">
                <div class="col-md-4 offset-8 mb-3">
                    <h4 style="font-size: 11pt" class="m-0 text-dark float-right printDate"></h4>
                </div>
                <div class="col-md-12 text-center">
                    <h4 style="font-size: 14pt" class="m-0 text-dark">REKAPITULASI KRNG PERIODE {{ $awal }} S/D
                        {{ $akhir }}
                    </h4>
                </div>
            </div>
        </div>
        @php
        $sumTotal = 0;
        $sumTonase = 0;
        $ton_total = 0;
        $price_total = 0;
        @endphp
        <div class="content mt-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle text-center">NO</th>
                                    <th scope="col" class="align-middle text-center">TANGGAL</th>
                                    <th scope="col" class="align-middle text-center">NOMOR POLISI</th>
                                    <th scope="col" class="align-middle text-center">NAMA PELANGGAN</th>
                                    <th scope="col" class="align-middle text-center">NAMA PLANT</th>
                                    <th scope="col" class="align-middle text-center">DO NUMBER</th>
                                    <th scope="col" class="align-middle text-center">VOLUME (TON)</th>
                                    <th scope="col" class="align-middle text-center">UNIT PRICE</th>
                                    <th scope="col" class="align-middle text-center">TOTAL PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($angkutan->where('asal_pemuatan', '=', 'KRNG') as $item)
                                @php
                                $nopol = $item->nopol;
                                $total_price = $item->ongkos_angkut * $item->tonase;
                                $sumTotal += $total_price;
                                $sumTonase += $item->tonase;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->index +1 }}</td>
                                    <td class="text-center align-middle">{{ substr(dateReformat($item->tanggal),0,6) }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $nopol }}
                                    </td>
                                    <td class="text-center align-middle">{{ $item->tujuan }}</td>
                                    <td class="text-center align-middle">PLANT {{ $item->kota }}</td>
                                    <td class="text-center align-middle">{{ $item->no_surat }}</td>
                                    <td class="text-center align-middle">{{ $item->tonase }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($item->ongkos_angkut) }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($total_price) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="align-middle font-weight-bold text-right">Jumlah</td>
                                    <td class="text-center align-middle font-weight-bold">
                                        {{ number_format($sumTonase,2) }}
                                    </td>
                                    <td></td>
                                    <td class="text-center font-weight-bold">Rp. {{ number_format($sumTotal) }}</td>
                                </tr>
                                @php
                                $sumTotal = 0;
                                $sumTonase = 0;
                                @endphp
                            </tbody>
                        </table>
                        <div class="pagebreak"></div>
                        <div class="text-center">
                            <div style="font-size: 28pt; color: rgb(95 149 245)" class="m-0">PT. ANNISA RIZKI JAYA
                                BERSAMA</div>
                            <div style="font-size: 11pt" class="m-0">Jasa Angkutan Perdagangan & Pemeliharaan</div>
                            <div style="font-size: 11pt; border-bottom-color: black !important;"
                                class="m-0 pb-2 border-bottom">Alamat . Jalan Penanggulangan Banjir No 23 PADANG
                                (Tlp
                                081363948541)</div>
                            <table class="table table-striped table-bordered dt-responsive nowrap mt-5"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" colspan="2" style="font-size: 24pt" scope="col"
                                            class="text-center align-middle">INVOICE</th>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">INVOICE {{ $awal }} S/D {{ $akhir }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">KE {{ $ke }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="4" scope="col" style="font-size: 11pt"
                                            class="align-middle text-left">
                                            <div>Kepada : PT. KRNG INDONESIA</div>
                                            <div>AREA PABRIK BAJA TERPADU, PT. KRAKATAU POSCO JL. AFRIKA NO 2
                                                CILEGON
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Nama Jasa / Barang</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            TON</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Ongkos Angkut</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Jumlah</td>
                                    </tr>
                                    @foreach ($angkutan->where('asal_pemuatan', '=', 'KRNG')->groupBy('kota') as $item)
                                    @php
                                    for($i=0; $i< count($item); $i++){ $plant_ton +=$item[$i]->tonase;
                                        $plant_total += $item[0]->ongkos_angkut * $item[$i]->tonase;
                                        }
                                        $ton_total += $plant_ton;
                                        $price_total += $plant_total;
                                        @endphp
                                        <tr>
                                            <td style="font-size: 11pt" class="text-center align-middle">PLANT
                                                {{$item[0]->kota}}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">
                                                {{ number_format($plant_ton, 2) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($item[0]->ongkos_angkut) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($plant_total) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="font-size: 11pt" class="text-left align-middle font-weight-bold">
                                                TOTAL......</td>
                                            <td style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">
                                                {{ number_format($ton_total, 2) }}</td>
                                            <td colspan="2" style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">Rp.
                                                {{ number_format($price_total) }}</td>
                                        </tr>
                                </tbody>
                            </table>
                            <div style="font-size: 11pt" class="border border-dark font-weight-bold font-italic">
                                Terbilang : {{ terbilang($price_total)}} Rupiah</div>
                            @php
                            $ton_total = 0;
                            $price_total = 0;
                            @endphp
                        </div>
                        <div id="footer-ttd" class="mb-4 row">
                            <div class="col-md-6">
                                <div class="font-weight-bold">Bank : MANDIRI cabang PADANG</div>
                                <div class="font-weight-bold">Rek , 111.001.371.7091/PT. ANNISA RIZKI JAYA BERSAMA</div>
                                <div id="identifier" class="mt-4"></div>
                                <div class="mb-5">PT. ANNISA RIZKI JAYA BERSAMA</div>
                                <div class="mt-5 mb-5">&nbsp</div>
                                <div><span style="border-bottom-color: black !important" class="border-bottom">TEGUH
                                        MARDIANTO</span></div>
                                <div>DIREKTUR</div>
                            </div>
                        </div>
                        <div class="pagebreak"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($jenis[2] == 1)
        <div class="container-fluid mt-4">
            <div class="row mb-2">
                <div class="col-md-4 offset-8 mb-3">
                    <h4 style="font-size: 11pt" class="m-0 text-dark float-right printDate"></h4>
                </div>
                <div class="col-md-12 text-center">
                    <h4 style="font-size: 14pt" class="m-0 text-dark">REKAPITULASI WANGDA PERIODE {{ $awal }} S/D
                        {{ $akhir }}
                    </h4>
                </div>
            </div>
        </div>
        @php
        $sumTotal = 0;
        $sumTonase = 0;
        $ton_total = 0;
        $price_total = 0;
        @endphp
        <div class="content mt-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle text-center">NO</th>
                                    <th scope="col" class="align-middle text-center">TANGGAL</th>
                                    <th scope="col" class="align-middle text-center">NOMOR POLISI</th>
                                    <th scope="col" class="align-middle text-center">ASAL</th>
                                    <th scope="col" class="align-middle text-center">TUJUAN</th>
                                    <th scope="col" class="align-middle text-center">S/J</th>
                                    <th scope="col" class="align-middle text-center">TONASE</th>
                                    <th scope="col" class="align-middle text-center">HARGA</th>
                                    <th scope="col" class="align-middle text-center">JUMLAH</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($angkutan->where('asal_pemuatan', '=', 'WANGDA') as $item)
                                @php
                                $total_price = 0;
                                $nopol = $item->nopol;
                                $total_price = $item->ongkos_angkut * $item->tonase;
                                $sumTotal += $total_price;
                                $sumTonase += $item->tonase;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->index +1 }}</td>
                                    <td class="text-center align-middle">
                                        {{ substr(dateReformat($item->tanggal),0,6) }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $nopol }}
                                    </td>
                                    <td class="text-center align-middle">{{ $item->tujuan }}</td>
                                    <td class="text-center align-middle">{{ $item->kota }}</td>
                                    <td class="text-center align-middle">{{ $item->no_surat }}</td>
                                    <td class="text-center align-middle">{{ $item->tonase }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($item->ongkos_angkut) }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($total_price) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="align-middle font-weight-bold text-right">Jumlah</td>
                                    <td class="text-center align-middle font-weight-bold">
                                        {{ number_format($sumTonase,2) }}
                                    </td>
                                    <td></td>
                                    <td class="text-center font-weight-bold">Rp. {{ number_format($sumTotal) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagebreak"></div>
                        <div class="text-center">
                            <div style="font-size: 28pt; color: rgb(95 149 245)" class="m-0">PT. ANNISA RIZKI
                                JAYA
                                BERSAMA</div>
                            <div style="font-size: 11pt" class="m-0">Jasa Angkutan Perdagangan & Pemeliharaan
                            </div>
                            <div style="font-size: 11pt; border-bottom-color: black !important;"
                                class="m-0 pb-2 border-bottom">Alamat . Jalan Penanggulangan Banjir No 23 PADANG
                                (Tlp
                                081363948541)</div>
                            <table class="table table-striped table-bordered dt-responsive nowrap mt-5"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" colspan="2" style="font-size: 24pt" scope="col"
                                            class="text-center align-middle">INVOICE</th>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">INVOICE {{ $awal }} S/D
                                            {{ $akhir }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">KE {{ $ke }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="4" scope="col" style="font-size: 11pt"
                                            class="align-middle text-left">
                                            <div>Kepada : PT. WANGDA</div>
                                            <div>KARAWANG
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Nama Jasa / Barang</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            TON</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Ongkos Angkut</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Jumlah</td>
                                    </tr>
                                    @foreach ($angkutan->where('asal_pemuatan', '=', 'WANGDA')->groupBy('kota') as
                                    $item)
                                    @php
                                    $plant_ton = 0;
                                    $plant_total = 0;
                                    for($i=0; $i< count($item); $i++){ $plant_ton +=$item[$i]->tonase;
                                        $plant_total += $item[0]->ongkos_angkut * $item[$i]->tonase;
                                        }
                                        $ton_total += $plant_ton;
                                        $price_total += $plant_total;
                                        @endphp
                                        <tr>
                                            <td style="font-size: 11pt" class="text-center align-middle">
                                                {{$item[0]->kota}}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">
                                                {{ number_format($plant_ton, 2) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($item[0]->ongkos_angkut) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($plant_total) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="font-size: 11pt" class="text-left align-middle font-weight-bold">
                                                TOTAL......</td>
                                            <td style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">
                                                {{ number_format($ton_total, 2) }}</td>
                                            <td colspan="2" style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">Rp.
                                                {{ number_format($price_total) }}</td>
                                        </tr>
                                </tbody>
                            </table>
                            <div style="font-size: 11pt" class="border border-dark font-weight-bold font-italic">
                                Terbilang : {{ terbilang($price_total)}} Rupiah</div>
                        </div>
                        {{-- <div class="pagebreak"></div> --}}
                        <div id="footer-ttd" class="mb-4 row">
                            <div class="col-md-6">
                                <div class="font-weight-bold">BCA. 0321948765</div>
                                <div class="font-weight-bold">a/n Teguh Mardianto</div>
                                <div id="identifier" class="mt-4"></div>
                                <div class="mb-5">PT. ANNISA RIZKI JAYA BERSAMA</div>
                                <div class="mt-5 mb-5">&nbsp</div>
                                <div><span style="border-bottom-color: black !important" class="border-bottom">TEGUH
                                        MARDIANTO</span></div>
                                <div>TRANSPORTIR</div>
                            </div>
                        </div>
                        <div class="pagebreak"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($jenis[3] == 1)
        <div class="container-fluid mt-4">
            <div class="row mb-2">
                <div class="col-md-4 offset-8 mb-3">
                    <h4 style="font-size: 11pt" class="m-0 text-dark float-right printDate"></h4>
                </div>
                <div class="col-md-12 text-center">
                    <h4 style="font-size: 14pt" class="m-0 text-dark">REKAPITULASI WSD PERIODE {{ $awal }} S/D
                        {{ $akhir }}
                    </h4>
                </div>
            </div>
        </div>
        @php
        $sumTotal = 0;
        $sumTonase = 0;
        $sumPanjar = 0;
        $sumHasil = 0;
        $ton_total = 0;
        $price_total = 0;
        @endphp
        <div class="content mt-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle text-center">NO</th>
                                    <th scope="col" class="align-middle text-center">TANGGAL</th>
                                    <th scope="col" class="align-middle text-center">NOMOR POLISI</th>
                                    <th scope="col" class="align-middle text-center">ASAL</th>
                                    <th scope="col" class="align-middle text-center">TUJUAN</th>
                                    <th scope="col" class="align-middle text-center">S/J</th>
                                    <th scope="col" class="align-middle text-center">TONASE</th>
                                    <th scope="col" class="align-middle text-center">HARGA</th>
                                    <th scope="col" class="align-middle text-center">JUMLAH</th>
                                    <th scope="col" class="align-middle text-center">PANJAR</th>
                                    <th scope="col" class="align-middle text-center">HASIL MOBIL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($angkutan->where('asal_pemuatan', '=', 'WSD') as $item)
                                @php
                                $total_price = 0;
                                $hasil_mobil = 0;
                                $nopol = $item->nopol;
                                $total_price = $item->ongkos_angkut * $item->tonase;
                                $sumTotal += $total_price;
                                $sumTonase += $item->tonase;
                                $sumPanjar += $item->panjar;
                                $hasil_mobil = $total_price - $item->panjar;
                                $sumHasil += $hasil_mobil;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->index +1 }}</td>
                                    <td class="text-center align-middle">
                                        {{ substr(dateReformat($item->tanggal),0,6) }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $nopol }}
                                    </td>
                                    <td class="text-center align-middle">{{ $item->tujuan }}</td>
                                    <td class="text-center align-middle">{{ $item->kota }}</td>
                                    <td class="text-center align-middle">{{ $item->no_surat }}</td>
                                    <td class="text-center align-middle">{{ $item->tonase }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($item->ongkos_angkut) }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($total_price) }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($item->panjar) }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($hasil_mobil) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="align-middle font-weight-bold text-right">Jumlah</td>
                                    <td class="text-center align-middle font-weight-bold">
                                        {{ number_format($sumTonase,2) }}
                                    </td>
                                    <td></td>
                                    <td class="text-center font-weight-bold">Rp. {{ number_format($sumTotal) }}
                                    </td>
                                    <td class="text-center font-weight-bold">Rp. {{ number_format($sumPanjar) }}
                                    </td>
                                    <td class="text-center font-weight-bold">Rp. {{ number_format($sumHasil) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagebreak"></div>
                        <div class="text-center">
                            <div style="font-size: 28pt; color: rgb(95 149 245)" class="m-0">PT. ANNISA RIZKI
                                JAYA
                                BERSAMA</div>
                            <div style="font-size: 11pt" class="m-0">Jasa Angkutan Perdagangan & Pemeliharaan
                            </div>
                            <div style="font-size: 11pt; border-bottom-color: black !important;"
                                class="m-0 pb-2 border-bottom">Alamat . Jalan Penanggulangan Banjir No 23 PADANG
                                (Tlp
                                081363948541)</div>
                            <table class="table table-striped table-bordered dt-responsive nowrap mt-5"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" colspan="2" style="font-size: 24pt" scope="col"
                                            class="text-center align-middle">INVOICE</th>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">INVOICE {{ $awal }} S/D
                                            {{ $akhir }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">KE {{ $ke }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="4" scope="col" style="font-size: 11pt"
                                            class="align-middle text-left">
                                            <div>Kepada : PT. WAN SHI DA INDONESIA</div>
                                            <div>KP. CIBUNTU DS.PADABEUNGHAR KEC. JAMPANG TENGAH SUKABUMI
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Nama Jasa / Barang</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            TON</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Ongkos Angkut</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Jumlah</td>
                                    </tr>
                                    @foreach ($angkutan->where('asal_pemuatan', '=', 'WSD')->groupBy('kota') as $item)
                                    @php
                                    $plant_ton = 0;
                                    $plant_total = 0;
                                    for($i=0; $i< count($item); $i++){ $plant_ton +=$item[$i]->tonase;
                                        $plant_total += $item[0]->ongkos_angkut * $item[$i]->tonase;
                                        }
                                        $ton_total += $plant_ton;
                                        $price_total += $plant_total;
                                        @endphp
                                        <tr>
                                            <td style="font-size: 11pt" class="text-center align-middle">
                                                {{$item[0]->kota}}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">
                                                {{ number_format($plant_ton, 2) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($item[0]->ongkos_angkut) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($plant_total) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="font-size: 11pt" class="text-left align-middle font-weight-bold">
                                                TOTAL......</td>
                                            <td style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">
                                                {{ number_format($ton_total, 2) }}</td>
                                            <td colspan="2" style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">Rp.
                                                {{ number_format($price_total) }}</td>
                                        </tr>
                                </tbody>
                            </table>
                            <div style="font-size: 11pt" class="border border-dark font-weight-bold font-italic">
                                Terbilang : {{ terbilang($price_total)}} Rupiah</div>
                        </div>
                        {{-- <div class="pagebreak"></div> --}}
                        <div id="footer-ttd" class="mb-4 row">
                            <div class="col-md-6">
                                <div class="font-weight-bold">BCA. 0321948765</div>
                                <div class="font-weight-bold">a/n Teguh Mardianto</div>
                                <div id="identifier" class="mt-4"></div>
                                <div class="mb-5">PT. ANNISA RIZKI JAYA BERSAMA</div>
                                <div class="mt-5 mb-5">&nbsp</div>
                                <div><span style="border-bottom-color: black !important" class="border-bottom">TEGUH
                                        MARDIANTO</span></div>
                                <div>TRANSPORTIR</div>
                            </div>
                        </div>
                        <div class="pagebreak"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($jenis[0] == 1)
        <div class="container-fluid mt-4">
            <div class="row mb-2">
                <div class="col-md-4 offset-8 mb-3">
                    <h4 style="font-size: 11pt" class="m-0 text-dark float-right printDate"></h4>
                </div>
                <div class="col-md-12 text-center">
                    <h4 style="font-size: 14pt" class="m-0 text-dark">REKAPITULASI HAOHAN CEMENT PERIODE {{ $awal }} S/D
                        {{ $akhir }}
                    </h4>
                </div>
            </div>
        </div>
        @php
        $sumTotal = 0;
        $sumTonase = 0;
        $ton_total = 0;
        $price_total = 0;
        @endphp
        <div class="content mt-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle text-center">NO</th>
                                    <th scope="col" class="align-middle text-center">TANGGAL</th>
                                    <th scope="col" class="align-middle text-center">NOMOR POLISI</th>
                                    <th scope="col" class="align-middle text-center">SURAT JALAN</th>
                                    <th scope="col" class="align-middle text-center">ASAL</th>
                                    <th scope="col" class="align-middle text-center">TUJUAN</th>
                                    <th scope="col" class="align-middle text-center">TONASE</th>
                                    <th scope="col" class="align-middle text-center">HARGA</th>
                                    <th scope="col" class="align-middle text-center">JUMLAH</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($angkutan->where('asal_pemuatan', '=', 'HAOHAN CEMENT') as $item)
                                @php
                                $total_price = 0;
                                $nopol = $item->nopol;
                                $total_price = $item->ongkos_angkut * $item->tonase;
                                $sumTotal += $total_price;
                                $sumTonase += $item->tonase;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->index +1 }}</td>
                                    <td class="text-center align-middle">
                                        {{ substr(dateReformat($item->tanggal),0,6) }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $nopol }}
                                    </td>
                                    <td class="text-center align-middle">{{ $item->no_surat }}</td>
                                    <td class="text-center align-middle">{{ $item->tujuan }}</td>
                                    <td class="text-center align-middle">{{ $item->kota }}</td>
                                    <td class="text-center align-middle">{{ $item->tonase }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($item->ongkos_angkut) }}</td>
                                    <td class="text-center align-middle">Rp.
                                        {{ number_format($total_price) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="align-middle font-weight-bold text-right">Jumlah</td>
                                    <td class="text-center align-middle font-weight-bold">
                                        {{ number_format($sumTonase,2) }}
                                    </td>
                                    <td></td>
                                    <td class="text-center font-weight-bold">Rp. {{ number_format($sumTotal) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagebreak"></div>
                        <div class="text-center">
                            <div style="font-size: 28pt; color: rgb(95 149 245)" class="m-0">PT. ANNISA RIZKI
                                JAYA
                                BERSAMA</div>
                            <div style="font-size: 11pt" class="m-0">Jasa Angkutan Perdagangan & Pemeliharaan
                            </div>
                            <div style="font-size: 11pt; border-bottom-color: black !important;"
                                class="m-0 pb-2 border-bottom">Alamat . Jalan Penanggulangan Banjir No 23 PADANG
                                (Tlp
                                081363948541)</div>
                            <table class="table table-striped table-bordered dt-responsive nowrap mt-5"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" colspan="2" style="font-size: 24pt" scope="col"
                                            class="text-center align-middle">INVOICE</th>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">INVOICE {{ $awal }} S/D
                                            {{ $akhir }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2" style="font-size: 11pt"
                                            class="text-center align-middle">KE {{ $ke }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="4" scope="col" style="font-size: 11pt"
                                            class="align-middle text-left">
                                            <div>Kepada : SEMEN SERANG</div>
                                            <div>CILEGON
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Nama Jasa / Barang</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            TON</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Ongkos Angkut</td>
                                        <td style="font-size: 11pt" class="text-center align-middle font-weight-bold">
                                            Jumlah</td>
                                    </tr>
                                    @foreach ($angkutan->where('asal_pemuatan', '=', 'HAOHAN CEMENT')->groupBy('tujuan')
                                    as
                                    $item)
                                    @php
                                    $plant_ton = 0;
                                    $plant_total = 0;
                                    for($i=0; $i< count($item); $i++){ $plant_ton +=$item[$i]->tonase;
                                        $plant_total += $item[0]->ongkos_angkut * $item[$i]->tonase;
                                        }
                                        $ton_total += $plant_ton;
                                        $price_total += $plant_total;
                                        @endphp
                                        <tr>
                                            <td style="font-size: 11pt" class="text-center align-middle">
                                                {{$item[0]->tujuan}}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">
                                                {{ number_format($plant_ton, 2) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($item[0]->ongkos_angkut) }}</td>
                                            <td style="font-size: 11pt" class="text-right align-middle">Rp.
                                                {{ number_format($plant_total) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="font-size: 11pt" class="text-left align-middle font-weight-bold">
                                                TOTAL......</td>
                                            <td style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">
                                                {{ number_format($ton_total, 2) }}</td>
                                            <td colspan="2" style="font-size: 11pt"
                                                class="text-right align-middle font-weight-bold">Rp.
                                                {{ number_format($price_total) }}</td>
                                        </tr>
                                </tbody>
                            </table>
                            <div style="font-size: 11pt" class="border border-dark font-weight-bold font-italic">
                                Terbilang : {{ terbilang($price_total)}} Rupiah</div>
                        </div>
                        {{-- <div class="pagebreak"></div> --}}
                        <div id="footer-ttd" class="mb-4 row">
                            <div class="col-md-6">
                                <div class="font-weight-bold">BCA. 1750656354</div>
                                <div class="font-weight-bold">a/n Shinta Dewi</div>
                                <div id="identifier" class="mt-4"></div>
                                <div class="mb-5">PT. ANNISA RIZKI JAYA BERSAMA</div>
                                <div class="mt-5 mb-5">&nbsp</div>
                                <div><span style="border-bottom-color: black !important" class="border-bottom">TEGUH
                                        MARDIANTO</span></div>
                                <div>TRANSPORTIR</div>
                            </div>
                        </div>
                        <div class="pagebreak"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </body>
    <script>
        function startTime() {
            var week = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var fullmonth = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            var today = new Date();
            var day = today.getDay();
            var date = today.getDate();
            var month = today.getMonth();
            var year = today.getFullYear();
            let path = window.location.pathname.split('/');
            let elementPrint = document.getElementsByClassName('printDate');
            for (let i = 0; i < elementPrint.length; i++) {
                elementPrint[i].innerHTML = "Tanggal Cetak : " + date + " " + fullmonth[month] + " " +
                    year;
            }
            document.getElementById('identifier').innerHTML = "Cilegon, " + date + " " + fullmonth[month] + " " +
                year;
            window.print();
        }

    </script>

</html>
