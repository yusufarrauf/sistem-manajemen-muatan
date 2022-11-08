<!DOCTYPE html>
<html lang="en">
@php
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
    @endphp

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Annisa Rizki - Cetak Slip Gaji</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" defer></script>
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
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
                /* display: none; */
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
        <div class="container-fluid mt-4">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <div style="font-size: 28pt; color: rgb(95 149 245)" class="m-0">PT. ANNISA RIZKI JAYA
                        BERSAMA</div>
                    <div style="font-size: 11pt" class="m-0">Jasa Angkutan Perdagangan & Pemeliharaan</div>
                    <div style="font-size: 11pt; border-bottom-color: black !important;" class="m-0 pb-2 border-bottom">
                        Alamat . Jalan Penanggulangan Banjir No 23 PADANG
                        (Tlp
                        081363948541)</div>
                        <div style="font-size: 14pt; border-bottom-color: black !important;" class="m-0 pt-2 pb-2 border-bottom">
                            ========&nbsp; SLIP GAJI &nbsp;========</div>
                </div>
            </div>
        </div>
        <div class="content mt-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12 row mb-4 font-weight-bold">
                        <div class="col-md-6 row">
                            <div class="col-md-3">Nama</div>
                            <div class="col-md-9">:&nbsp; {{ $karyawan->nama }}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-3">Alamat</div>
                            <div class="col-md-9">:&nbsp; {{ $karyawan->alamat }}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-3">Jabatan</div>
                            <div class="col-md-9">:&nbsp; {{ $karyawan->jabatan }}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-3">Handphone</div>
                            <div class="col-md-9">:&nbsp; {{ $karyawan->handphone }}</div>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid black !important; position: absolute; left: 1em; width:auto; right:1em; top: 18em"
                        class="m-0 pb-2 border-bottom">
                    </div>
                    <div class="col-md-12 mt-3">
                        <table id="data-gaji" class="table dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="60px" scope="col">NO</th>
                                    <th scope="col">Keterangan</th>
                                    <th width="200px" class="text-right" scope="col">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="font-weight-bold">GAJI POKOK</td>
                                    <td class="font-weight-bold text-right">Rp.
                                        {{ number_format($penggajian->gaji_pokok) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-weight-bold">LAIN - LAIN</td>
                                    <td></td>
                                </tr>
                                @php
                                $biaya_lain = explode(';', $penggajian->biaya_lain);
                                @endphp
                                @for ($i = 0; $i < count($biaya_lain)-1; $i++) @php $nama=explode(":",
                                    $biaya_lain[$i])[0]; $jumlah=explode(":", $biaya_lain[$i])[1]; @endphp <tr>
                                    <td>{{ $i+2 }}</td>
                                    <td class="font-weight-bold">{{ strtoupper($nama) }}</td>
                                    <td class="font-weight-bold text-right">Rp. {{ number_format($jumlah) }}
                                        </tr>
                                        @endfor
                                        <tr>
                                            <td class="font-weight-bold text-right" colspan="2">TOTAL DITERIMA</td>
                                            <td class="font-weight-bold text-right">Rp.
                                                {{ number_format($penggajian->total_gaji) }}
                                        </tr>
                            </tbody>
                        </table>
                        <div class="border border-dark font-weight-bold font-italic text-center">
                            Terbilang : {{ terbilang($penggajian->total_gaji)}} Rupiah</div>
                    </div>
                    <div id="footer-ttd" class="col-md-12 row justify-content-center">
                        <div style="bottom: 0; position: absolute" class="col-md-12">
                            <div id="identifier" class="mt-4"></div>
                            <div class="mb-5">Penerima</div>
                            <div class="mt-5 mb-5">&nbsp</div>
                            <div><span style="border-bottom-color: black !important"
                                    class="border-bottom">{{ strtoupper($karyawan->nama) }}</span></div>
                            <div>{{ $karyawan->jabatan }}</div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div id="identifier" class="mt-4"></div>
                            <div id="dateCreate" class="mb-5">Penerima</div>
                            <div class="mt-5 mb-5">&nbsp</div>
                            <div><span style="border-bottom-color: black !important"
                                    class="border-bottom">PT. ANNISA RIZKI JAYA BERSAMA</span></div>
                                    <div>&nbsp;</div>
                        </div>
                    </div>
                    {{-- <div class="pagebreak"></div> --}}
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
            document.getElementById('dateCreate').innerHTML = date + " " + fullmonth[month] + " " +
                    year;
            window.print();
        }

    </script>

</html>
