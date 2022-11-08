<!DOCTYPE html>
<html lang="en">
@php
$sumTotal = 0;

$total_ton = 0;
$total_ongkos = 0;
$total_supir = 0;
$total_bonus = 0;
$total_ferry = 0;
$total_uj = 0;
$total_panjar = 0;
$total_sisa_uj = 0;
$total_bersih = 0;
function dateReformat($tanggal){
$bulan=array ( 1=> 'JANUARI',
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
$bulan=array ( 1=> 'JANUARI',
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
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Annisa Rizki - Print Rekap {{ strtoupper($identity[2]) }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #angkutan {
            font-size: 6pt;
        }

        #perawatan {
            font-size: .8em;
        }

        table.table-bordered,
        .card {
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
            @page {
                size: landscape;
            }

            .pagebreak {
                page-break-before: always;
            }

            #footer-ttd {
                display: block;
                position: absolute;
                bottom: 0;
                width: 100%;
            }

            #angkutan {
                font-size: 6pt;
            }

            #perawatan {
                font-size: .8em;
            }
        }

    </style>
</head>

<body onload="startTime()">
    <div class="container-fluid mt-4">
        <div class="row mb-2">
            <div class="col-md-4 offset-8 mb-3">
                <h4 style="font-size: 11pt" class="m-0 text-dark float-right printDate"></h4>
            </div>
            <div class="col-md-12 text-center">
                <h4 style="font-size: 14pt" class="m-0 text-dark">REKAPITULASI {{ $identity[2] }}</h4>
                <h3 style="font-size: 12pt" class="m-0 text-dark">BULAN : {{ $bulan[$identity[0]] }} {{ $identity[1] }}</h3>
            </div>
        </div>
    </div>
    <div class="content mt-4">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table id="angkutan" class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle text-center">NO</th>
                                <th scope="col" class="align-middle text-center">TANGGAL</th>
                                <th scope="col" class="align-middle text-center">TRANSPORTIR</th>
                                <th scope="col" class="align-middle text-center">JENIS ANGKUTAN</th>
                                <th scope="col" class="align-middle text-center">ASAL PEMUATAN</th>
                                <th scope="col" class="align-middle text-center">NO. SURAT JALAN</th>
                                <th scope="col" class="align-middle text-center">TUJUAN</th>
                                <th scope="col" class="align-middle text-center">KOTA</th>
                                <th scope="col" class="align-middle text-center">TONASE</th>
                                <th scope="col" class="align-middle text-center">ONGKOS ANGKUT</th>
                                <th scope="col" class="align-middle text-center">JUMLAH</th>
                                <th scope="col" class="align-middle text-center">SUPIR @TON</th>
                                <th scope="col" class="align-middle text-center">JUMLAH</th>
                                <th scope="col" class="align-middle text-center">FERRY</th>
                                <th scope="col" class="align-middle text-center">BONUS SUPIR @TON</th>
                                <th scope="col" class="align-middle text-center">JUMLAH</th>
                                <th scope="col" class="align-middle text-center">MAX TONASE SUPIR</th>
                                <th scope="col" class="align-middle text-center">HASIL BONUS</th>
                                <th scope="col" class="align-middle text-center">TOTAL UJ SUPIR</th>
                                <th scope="col" class="align-middle text-center">PANJAR</th>
                                <th scope="col" class="align-middle text-center">SISA UJ SUPIR</th>
                                <th scope="col" class="align-middle text-center">HASIL BERSIH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($angkutan as $item)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->index +1 }}</td>
                                <td class="align-middle text-center">{{ substr(dateReformat($item->tanggal),0,6) }}</td>
                                <td class="text-center align-middle">{{ $item->transportir }}</td>
                                <td class="text-center align-middle">{{ $item->jenis_angkutan }}</td>
                                <td class="text-center align-middle">{{ $item->asal_pemuatan }}</td>
                                <td class="text-center align-middle">{{ $item->no_surat }}</td>
                                <td class="text-center align-middle">{{ $item->tujuan }}</td>
                                <td class="text-center align-middle">{{ $item->kota }}</td>
                                <td class="text-center align-middle">{{ number_format($item->tonase) }}</td>
                                <td class="text-center align-middle">Rp. {{ number_format($item->ongkos_angkut) }}</td>
                                <td class="text-center align-middle">Rp.
                                    {{ number_format($item->ongkos_angkut * $item->tonase) }}</td>
                                <td class="text-center align-middle">Rp. {{ number_format($item->supir_perton) }}</td>
                                <td class="text-center align-middle">Rp.
                                    {{ number_format($item->supir_perton * $item->tonase) }}</td>
                                <td class="text-center align-middle">Rp. {{ number_format($item->ferry) }}</td>
                                <td class="text-center align-middle">Rp. {{ number_format($item->bonus_supir) }}</td>
                                <td class="text-center align-middle">{{ number_format($item->ton_bonus) }}</td>
                                <td class="text-center align-middle">{{ number_format($item->max_tonase) }}</td>
                                <td class="text-center align-middle">Rp.
                                    {{ number_format($item->bonus_supir * $item->ton_bonus) }}</td>
                                <td class="text-center align-middle">Rp. {{ number_format($item->total_uj) }}</td>
                                <td class="text-center align-middle">Rp. {{ number_format($item->panjar) }}</td>
                                <td class="text-center align-middle">Rp. {{ number_format($item->sisa_uj) }}</td>
                                <td class="text-center align-middle">Rp.
                                    {{ number_format($item->ongkos_angkut * $item->tonase - $item->total_uj) }}</td>
                            </tr>
                            @php
                            $total_ton += $item->tonase;
                            $total_ongkos += $item->ongkos_angkut * $item->tonase;
                            $total_supir += $item->supir_perton * $item->tonase;
                            $total_bonus += $item->bonus_supir * $item->ton_bonus;
                            $total_uj += $item->total_uj;
                            $total_ferry += $item->ferry;
                            $total_panjar += $item->panjar;
                            $total_sisa_uj += $item->sisa_uj;
                            $total_bersih += $item->ongkos_angkut * $item->tonase - $item->total_uj;
                            @endphp
                            @endforeach
                            <tr>
                                <td colspan="8" class="text-right font-weight-bold align-middle">TOTAL</td>
                                <td class="text-center align-middle font-weight-bold">{{ number_format($total_ton) }}</td>
                                <td colspan="2" class="text-center align-middle font-weight-bold">Rp. {{ number_format($total_ongkos) }}</td>
                                <td colspan="2" class="text-center align-middle font-weight-bold">Rp. {{ number_format($total_supir) }}</td>
                                <td class="text-center align-middle font-weight-bold">Rp. {{ number_format($total_ferry) }}</td>
                                <td colspan="4" class="text-center align-middle font-weight-bold">Rp. {{ number_format($total_bonus) }}</td>
                                <td class="text-center align-middle font-weight-bold">Rp. {{ number_format($total_uj) }}</td>
                                <td class="text-center align-middle font-weight-bold">Rp. {{ number_format($total_panjar) }}</td>
                                <td class="text-center align-middle font-weight-bold">Rp. {{ number_format($total_sisa_uj) }}</td>
                                <td class="text-center align-middle font-weight-bold">Rp.
                                    {{ number_format($total_bersih) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table id="perawatan" class="table table-striped table-bordered dt-responsive nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Tanggal</th>
                                <th scope="col">Biaya (Sparepart)</th>
                                <th scope="col" class="text-center">Satuan</th>
                                <th scope="col" class="text-center">Harga</th>
                                <th scope="col" class="text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perawatan->groupBy('tanggal') as $item)
                            @if (count($item) == 1)
                            <tr>
                                <td class="align-middle text-center font-weight-bold">
                                    {{ substr(dateReformat($item[0]->tanggal),0,6) }}
                                </td>
                                <td class="align-middle">{{ $item[0]->sparepart }}</td>
                                <td class="align-middle text-center">{{ $item[0]->satuan }}</td>
                                <td class="align-middle text-right font-weight-bold">Rp.
                                    {{ number_format($item[0]->harga) }}</td>
                                <td class="align-middle text-right font-weight-bold">Rp.
                                    {{ number_format($item[0]->total) }}</td>
                                @php
                                $sumTotal += $item[0]->total;
                                @endphp
                            </tr>
                            @else
                            <tr>
                                <td rowspan="{{count($item)}}" class="align-middle text-center font-weight-bold">
                                    {{ substr(dateReformat($item[0]->tanggal),0,6) }}
                                </td>
                                <td class="align-middle">{{ $item[0]->sparepart }}</td>
                                <td class="align-middle text-center">{{ $item[0]->satuan }}</td>
                                <td class="align-middle text-right font-weight-bold">Rp.
                                    {{ number_format($item[0]->harga) }}</td>
                                <td class="align-middle text-right font-weight-bold">Rp.
                                    {{ number_format($item[0]->total) }}</td>
                                @php
                                $sumTotal += $item[0]->total;
                                @endphp
                            </tr>
                            @for ($i = 1; $i < count($item); $i++)
                            <tr><td class="align-middle">{{ $item[$i]->sparepart }}
                                </td>
                                <td class="align-middle text-center">{{ $item[$i]->satuan }}</td>
                                <td class="align-middle text-right font-weight-bold">Rp.
                                    {{ number_format($item[$i]->harga) }}</td>
                                <td class="align-middle text-right font-weight-bold">Rp.
                                    {{ number_format($item[$i]->total) }}</td>
                                </tr>
                                @php
                                $sumTotal += $item[$i]->total;
                                @endphp
                                @endfor
                                @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td class="align-middle font-weight-bold">Biaya Perawatan</td>
                                    <td></td>
                                    <td></td>
                                    <td class="align-middle text-right font-weight-bold">Rp.
                                        {{ number_format(1000000) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="align-middle font-weight-bold text-right">Jumlah</td>
                                    <td class="text-right font-weight-bold">Rp. {{ number_format($sumTotal + 1000000) }}
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-4 offset-8">
                    <div class="card border-black">
                        <div class="card-body">
                            <ul class="list-group list-group-flush font-weight-bold">
                                <li style="border-bottom: 2px solid black" class="list-group-item">
                                    <div>Hasil Mobil<span class="float-right">Rp.
                                            {{ number_format($total_bersih) }}</span></div>
                                    <div>Total Biaya Perawatan<span class="float-right">Rp.
                                            {{ number_format($sumTotal) }}</span></div>
                                    <div class="float-right">-</div>
                                </li>
                                <li class="list-group-item text-danger">
                                    <div>Total Bersih<span class="float-right">Rp.
                                            {{ number_format( $total_bersih - (1000000 +$sumTotal)) }}</span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        window.print();
    }

</script>

</html>
