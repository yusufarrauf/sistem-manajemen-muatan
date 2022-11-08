<!DOCTYPE html>
<html lang="en">
@php
$sumTotal = 0;
function dateReformat($tanggal){
$bulan = array (
1 => 'Januari',
'Februari',
'Maret',
'April',
'Mei',
'Juni',
'Juli',
'Agustus',
'September',
'Oktober',
'November',
'Desember'
);
$pecahkan = explode('-', $tanggal);
return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
return "a";
}
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Annisa Rizki - Cetak Perawatan {!! Request::segment(4) !!}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap4.min.js" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body onload="startTime()">
    <div class="container-fluid mt-4">
        <div class="row mb-2">
            <div class="col-md-4 offset-8 mb-3">
                <h4 id="printDate" style="font-size: 12pt" class="m-0 text-dark float-right">Tanggal Cetak</h4>
            </div>
            <div class="col-md-12 text-center">
                <h4 style="font-size: 16pt" class="m-0 text-dark">PERAWATAN MOBIL - {!! Request::segment(5) !!}</h4>
                <h4 id="date" style="font-size: 12pt" class="m-0 text-dark"></h4>
            </div>
        </div>
    </div>
    </div>

    <div id="app" class="content mt-4">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
                            @for ($i = 1; $i < count($item); $i++) <tr>
                                <td class="align-middle">{{ $item[$i]->sparepart }}
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
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        h = checkTime(h);
        m = checkTime(m);
        s = checkTime(s);

        let path = window.location.pathname.split('/');;
        document.getElementById('date').innerHTML = "Bulan " + fullmonth[path[3]] + " " + path[4];
        document.getElementById('printDate').innerHTML = "Tanggal Cetak : " + date + " " + fullmonth[month] + " " +
            year;
        window.print();
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }

</script>

</html>
