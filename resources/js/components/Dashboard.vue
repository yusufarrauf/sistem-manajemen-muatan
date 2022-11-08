<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div v-if="user_level == 'Super Admin' && penggajian.length != data_penggajian && penggajian.length > 0" class="col-12">
                        <div class="card">
                            <div class="card-body bg-danger font-weight-bolder text-center">
                                BEBERAPA DATA KARYAWAN BELUM DIINPUT GAJI !!
                            </div>
                            <div class="card-footer text-center">
                            <router-link to="/penggajian/input-penggajian" class="link-muted font-weight-bold">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ car_aktif }} <span style="font-size: .5em" class="font-weight-bold">Dari {{ data_kendaraan.length }}</span></h3>
                                <p>Kendaraan Aktif</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <router-link to="/data-master/kendaraan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ vendor_kendaraan.length }}</h3>
                                <p>Data Vendor Kendaraan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-industry"></i>
                            </div>
                            <router-link to="/data-master/kendaraan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data_kota.length }}</h3>
                                <p>Data Kota Terdaftar</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <router-link to="/data-master/kota" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data_muatan.length }}</h3>
                                <p>Data Muatan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                            <router-link to="/data-master/muatan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data_pelanggan.length }}</h3>
                                <p>Data Pelanggan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <router-link to="/data-master/pelanggan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data_rekap.length }}</h3>
                                <p>Data Rekap</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-copy"></i>
                            </div>
                            <router-link to="/rekapitulasi" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ karyawan.length }}</h3>
                                <p>Data Karyawan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <router-link to="/penggajian/data-karyawan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ angkutan_perbulan }}</h3>
                                <p>Data Angkutan Bulan Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                            <router-link to="/data/angkutan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data_angkutan.length }}</h3>
                                <p>Total Data Angkutan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                            <router-link to="/data/angkutan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ perawatan_perbulan }}</h3>
                                <p>Data Perawatan Bulan Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <router-link to="/data/perawatan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data_perawatan.length }}</h3>
                                <p>Total Data Perawatan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <router-link to="/data/perawatan" class="small-box-footer">Info Lebih Lanjut <i
                                    class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user_level: '',
                vendor_kendaraan: {},
                data_kendaraan: {},
                data_kota: {},
                data_muatan: {},
                data_pelanggan: {},
                data_angkutan: {},
                data_perawatan: {},
                data_rekap: {},
                karyawan: {},
                penggajian : {}
            }
        },
        computed: {
            car_aktif: function(){
                let obj = _.pickBy(this.data_kendaraan, function (u) {
                    return u.status == 'AKTIF';
                });
                return Object.keys(obj).length;
            },
            angkutan_perbulan: function(){
                let obj = _.pickBy(this.data_angkutan, function (u) {
                    let angkutan_date = Date.parse(u.tanggal);

                    let Order_date = new Date(angkutan_date);
                    let Order_in_date = '01'
                    let Order_in_month = Order_date.getMonth();
                    let Order_in_year = Order_date.getFullYear();
                    let merge_Order_in_date = new Date(Order_in_year, Order_in_month, Order_in_date);

                    let today = new Date();
                    let today_date = '01'
                    let today_month = today.getMonth();
                    let today_year = today.getFullYear();
                    let merge_this_today_date = new Date(today_year, today_month, today_date);

                    let a = Date.parse(merge_Order_in_date);
                    let b = Date.parse(merge_this_today_date);

                    return a == b;
                });
                return Object.keys(obj).length;
            },
            perawatan_perbulan: function(){
                let obj = _.pickBy(this.data_perawatan, function (u) {
                    let perawatan_date = Date.parse(u.tanggal);

                    let Order_date = new Date(perawatan_date);
                    let Order_in_date = '01'
                    let Order_in_month = Order_date.getMonth();
                    let Order_in_year = Order_date.getFullYear();
                    let merge_Order_in_date = new Date(Order_in_year, Order_in_month, Order_in_date);

                    let today = new Date();
                    let today_date = '01'
                    let today_month = today.getMonth();
                    let today_year = today.getFullYear();
                    let merge_this_today_date = new Date(today_year, today_month, today_date);

                    let a = Date.parse(merge_Order_in_date);
                    let b = Date.parse(merge_this_today_date);

                    return a == b;
                });
                return Object.keys(obj).length;
            },
            data_penggajian: function(){
                let obj = _.pickBy(this.penggajian, function (u) {
                    return u.status == 1;
                });
                return Object.keys(obj).length;
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/data-kendaraan').then(({
                    data
                }) => (this.data_kendaraan = data));
                axios.get('/api/vendor-kendaraan').then(({
                    data
                }) => (this.vendor_kendaraan = data))
                axios.get('/api/data-kota').then(({
                    data
                }) => (this.data_kota = data))
                axios.get('/api/data-muatan').then(({
                    data
                }) => (this.data_muatan = data))
                axios.get('/api/data-pelanggan').then(({
                    data
                }) => (this.data_pelanggan = data))
                axios.get('/api/angkutan').then(({
                    data
                }) => (this.data_angkutan = data))
                axios.get('/api/perawatan').then(({
                    data
                }) => (this.data_perawatan = data))
                axios.get('/api/rekapitulasi').then(({
                    data
                }) => (this.data_rekap = data))
                axios.get('/api/karyawan').then(({
                    data
                }) => (this.karyawan = data))
                axios.get('/api/data-penggajian').then(({
                    data
                }) => (this.penggajian = data))
                this.user_level = document.querySelector("meta[name='user-level']").getAttribute('content');
            },
        },
        created() {
            this.LoadData();
            Fire.$on('reloadData', () => {
                this.LoadData();
            });
        },
        mounted() {
            document.title = 'Annisa Rizki - Dashboard';
        },
    }

</script>
