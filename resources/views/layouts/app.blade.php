<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    @if(Auth::check())
    <meta name="user-id" content="{{ Auth::user()->id }}">
    <meta name="username" content="{{ Auth::user()->username }}">
    <meta name="user-level" content="{{ Auth::user()->level }}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Annisa Rizki - @yield('title')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap4.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js" defer></script>
    <script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body class="@yield('body-class')" onload="startTime()">
    <div id="app">
        @yield('content')
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
        document.getElementById('dateTime').innerHTML =
            week[day] + ", " + date + " " + fullmonth[month] + " " + year + " - " + h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }
</script>
</html>
