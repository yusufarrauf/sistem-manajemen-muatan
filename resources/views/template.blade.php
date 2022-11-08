@extends('layouts.app')
@section('title', 'Dashboard')
@section('body-class', 'layout-fixed sidebar-mini')
@section('content')
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <div class="text-bold align-self-center" id="dateTime"></div>
            <a href="#" class="nav-link ml-2"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="tooltip"
                data-placement="bottom" title="Logout">
                <i class="nav-icon fas fa-sign-out-alt" style="display: inline-block;
                border-radius: 60px;
                box-shadow: 0px 0px 2px #888;
                padding: 0.5em 0.6em;"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/" class="brand-link text-center">
            <span class="brand-text font-weight-light">Annisa Rizki</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex  justify-content-center">
                <div class="info text-center">
                    <div class="d-block text-bold text-white">
                        @if (Auth::user()->level != 'GUEST')
                        {{ strtoupper(Auth::user()->name) }}
                        @else
                        {{ strtoupper(Auth::user()->username)}} - {{ strtoupper(Auth::user()->name) }}
                        @endif
                    </div>
                    <div class="d-block text-bold text-white">({{ Auth::user()->level }})</div>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @if (Auth::user()->level == 'Super Admin' || Auth::user()->level == 'Admin')
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="fa fa-tachometer-alt nav-icon" aria-hidden="true"></i>
                            <p>Dashboard</p>
                        </router-link>
                    </li>
                    @endif
                    @if (Auth::user()->level == 'GUEST')
                    <li class="nav-item">
                        <router-link to="/report" class="nav-link">
                            <i class="fa fa-chart-line nav-icon" aria-hidden="true"></i>
                            <p>Report</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/report-history" class="nav-link">
                            <i class="fa fa-copy nav-icon" aria-hidden="true"></i>
                            <p>Data Report</p>
                        </router-link>
                    </li>
                    @endif
                    @if (Auth::user()->level == 'Super Admin')
                    <li class="nav-item">
                        <router-link to="/user-management" class="nav-link">
                            <i class="fa fa-users nav-icon" aria-hidden="true"></i>
                            <p>User Management</p>
                        </router-link>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Data Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/data-master/kendaraan" class="nav-link">
                                    <i class="fa fa-truck nav-icon" aria-hidden="true"></i>
                                    <p>Kendaraan</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-master/kota" class="nav-link">
                                    <i class="fa fa-city nav-icon" aria-hidden="true"></i>
                                    <p>Daftar Kota</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-master/muatan" class="nav-link">
                                    <i class="fa fa-truck-loading nav-icon" aria-hidden="true"></i>
                                    <p>Muatan</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-master/pelanggan" class="nav-link">
                                    <i class="fa fa-user nav-icon" aria-hidden="true"></i>
                                    <p>Pelanggan</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data-master/ongkos-biaya" class="nav-link">
                                    <i class="fa fa-money-check nav-icon" aria-hidden="true"></i>
                                    <p>Ongkos Biaya</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if (Auth::user()->level == 'Admin')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Input Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/input-data/angkutan" class="nav-link">
                                    <i class="fas fa-truck-loading nav-icon" aria-hidden="true"></i>
                                    <p>Input Angkutan</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/input-data/perawatan" class="nav-link">
                                    <i class="fas fa-tools nav-icon" aria-hidden="true"></i>
                                    <p>Input perawatan</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if (Auth::user()->level == 'Super Admin')
                    <li class="nav-item">
                        <router-link to="/filter-angkutan-palembang" class="nav-link">
                            <i class="fa fa-filter nav-icon" aria-hidden="true"></i>
                            <p>Filter Angkutan PLG</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/approval-data-perawatan" class="nav-link">
                            <i class="fa fa-tasks nav-icon" aria-hidden="true"></i>
                            <p>Approval Perawatan</p>
                        </router-link>
                    </li>
                    @endif
                    @if (Auth::user()->level == 'Super Admin' || Auth::user()->level == 'Admin')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Laporan Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/data/angkutan" class="nav-link">
                                    <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                    <p>Angkutan</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data/angkutan-vendor" class="nav-link">
                                    <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                    <p>Angkutan Vendor</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/data/perawatan" class="nav-link">
                                    <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                    <p>Perawatan</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <router-link to="/rekap-pervendor" class="nav-link">
                            <i class="fa fa-file-alt nav-icon" aria-hidden="true"></i>
                            <p>Rekap Pervendor</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/rekap-persupir" class="nav-link">
                            <i class="fa fa-file-alt nav-icon" aria-hidden="true"></i>
                            <p>Rekap Persupir</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/rekapitulasi" class="nav-link">
                            <i class="fa fa-copy nav-icon" aria-hidden="true"></i>
                            <p>Rekapitulasi</p>
                        </router-link>
                    </li>
                    @endif
                    @if (Auth::user()->level == 'Super Admin' || Auth::user()->level == 'Keuangan')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>
                                Penggajian
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/penggajian/data-gaji" class="nav-link">
                                    <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                    <p>Data Gaji</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/penggajian/data-karyawan" class="nav-link">
                                    <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                    <p>Data Karyawan</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/penggajian/input-penggajian" class="nav-link">
                                    <i class="fa fa-circle nav-icon" aria-hidden="true"></i>
                                    <p>Input Penggajian</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
    <router-view></router-view>
    <vue-progress-bar></vue-progress-bar>
    <footer class="main-footer">
        <strong>Copyright &copy; 2020 Annisa Rizki.</strong> All rights reserved.
    </footer>
</div>
@endsection
