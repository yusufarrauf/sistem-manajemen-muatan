<!DOCTYPE html>
<html lang="en">
@php
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
$awal = explode('-', $rekap[0]['range_from'])[2];
$akhir = dateReformat($rekap[0]['range_to']);
$jenis = explode(';', $rekap[0]['jenis']);
@endphp

<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Annisa Rizki - Print Rekap Angkutan</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" defer></script>
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            table {
                    font-size: 6pt;
                }
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

                table {
                    font-size: 6pt;
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
                <h4 style="font-size: 14pt" class="m-0 text-dark">REKAPITULASI ANGKUTAN PERIODE {{ $awal }} S/D
                    {{ $akhir }}
                </h4>
                @php
                    $angkutan_list = '';
                    $asal_muatan = ['HAOHAN CEMENT', 'KRNG', 'WANGDA', 'WSD'];
                    for($i=0; $i < 4; $i++){
                        if($jenis[$i] == 1){
                            $angkutan_list .= $asal_muatan[$i];
                            if($i < 4){
                                $angkutan_list .= ', ';
                            }
                        }
                    }
                    $strlen = strlen($angkutan_list)-2;
                    $angkutan_list = substr($angkutan_list,0,$strlen);
                @endphp
                <h3 style="font-size: 12pt" class="m-0 text-dark">
                ({{$angkutan_list}})
                </h3>
            </div>
        </div>
    </div>
    <div class="content mt-4">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle text-center">NO</th>
                                <th scope="col" class="align-middle text-center">TANGGAL</th>
                                <th scope="col" class="align-middle text-center">NOPOL</th>
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
                            @php
                                $nopol = $item->nopol;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->index +1 }}</td>
                                    <td class="align-middle text-center">{{ substr(dateReformat($item->tanggal),0,6) }}</td>
                                    <td class="text-center align-middle">
                                        {{ $nopol }}
                                    </td>
                                    <td class="text-center align-middle">{{ $item->transportir }}</td>
                                    <td class="text-center align-middle">{{ $item->jenis_angkutan }}</td>
                                    <td class="text-center align-middle">{{ $item->asal_pemuatan }}</td>
                                    <td class="text-center align-middle">{{ $item->no_surat }}</td>
                                    <td class="text-center align-middle">{{ $item->tujuan }}</td>
                                    <td class="text-center align-middle">{{ $item->kota }}</td>
                                    <td class="text-center align-middle">{{ number_format($item->tonase) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->ongkos_angkut) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->ongkos_angkut * $item->tonase) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->supir_perton) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->supir_perton * $item->tonase) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->ferry) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->bonus_supir) }}</td>
                                    <td class="text-center align-middle">{{ number_format($item->ton_bonus) }}</td>
                                    <td class="text-center align-middle">{{ number_format($item->max_tonase) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->bonus_supir * $item->ton_bonus) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->total_uj) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->panjar) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->sisa_uj) }}</td>
                                    <td class="text-center align-middle">Rp. {{ number_format($item->ongkos_angkut * $item->tonase - $item->total_uj) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
