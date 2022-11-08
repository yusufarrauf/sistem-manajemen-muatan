<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Data Report Bulan: {{ reportDate }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <form @submit.prevent="filter()" @keydown="form.onKeydown($event)">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Bulan </label>
                                <div class="col-md-3">
                                    <select v-model="form.bulan" id="bulan" name="bulan"
                                        class="form-control text-center" data-live-search="true">
                                        <option value="0">Januari</option>
                                        <option value="1">Februari</option>
                                        <option value="2">Maret</option>
                                        <option value="3">April</option>
                                        <option value="4">Mei</option>
                                        <option value="5">Juni</option>
                                        <option value="6">Juli</option>
                                        <option value="7">Agustus</option>
                                        <option value="8">September</option>
                                        <option value="9">Oktober</option>
                                        <option value="10">November</option>
                                        <option value="11">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Tahun </label>
                                <div class="col-md-3">
                                    <select v-model="form.tahun" id="tahun" name="tahun"
                                        class="form-control text-center" data-live-search="true">
                                        <option v-for="n in 51" :value="1999 + n" :key="n">{{ 1999 + n }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-2">
                                    <button type="submit" class="btn btn-primary float-right ml-2"><i
                                            class="fas fa-search"></i> Cari Data</button>
                                    <button @click="reset()" type="button" class="btn btn-danger float-right ml-2"><i
                                            class="fas fa-undo"></i>
                                        Reset</button>
                                </div>
                            </div>
                        </form>
                        <div class="card">
                            <h3 class="card-header">Laporan Angkutan</h3>
                            <div class="card-body">
                                <table id="angkutan" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Transportir</th>
                                            <th scope="col" class="none">Jenis Angkutan</th>
                                            <th scope="col" class="none">Asal Pemuatan</th>
                                            <th scope="col" class="none">No. Surat Jalan</th>
                                            <th scope="col" class="none">Tujuan</th>
                                            <th scope="col" class="none">Kota</th>
                                            <th scope="col" class="none">Tonase</th>
                                            <th scope="col" class="none">Ongkos Angkut</th>
                                            <th scope="col" class="none">Jumlah</th>
                                            <th scope="col" class="none">Sopir @TON</th>
                                            <th scope="col" class="none">Jumlah</th>
                                            <th scope="col" class="none">Ferry</th>
                                            <th scope="col" class="none">Bonus Sopir @TON</th>
                                            <th scope="col" class="none">Jumlah</th>
                                            <th scope="col" class="none">MAX Tonase Sopir</th>
                                            <th scope="col" class="none">Hasil Bonus</th>
                                            <th scope="col" class="none">Total UJ Sopir</th>
                                            <th scope="col" class="none">PANJAR</th>
                                            <th scope="col" class="none">Sisa UJ Sopir</th>
                                            <th scope="col" class="none ">Hasil Bersih Mobil</th>
                                            <th scope="col" class="text-center">Status Sisa UJ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(da, index) in report.angkutan" :key="da.id">
                                            <td class="font-weight-bold align-middle">{{ index +1 }}</td>
                                            <td class="text-center align-middle font-weight-bold">
                                                {{ da.tanggal | dateReformat }}</td>
                                            <td class="text-center align-middle font-weight-bold">{{ da.transportir }}
                                            </td>
                                            <td class="font-weight-bold">{{ da.jenis_angkutan }}</td>
                                            <td style="background-color: red !importan" class="font-weight-bold">
                                                {{ da.asal_pemuatan }}</td>
                                            <td class="font-weight-bold">{{ da.no_surat }}</td>
                                            <td class="font-weight-bold">{{ da.tujuan }}</td>
                                            <td class="font-weight-bold">{{ da.kota }}</td>
                                            <td class="font-weight-bold">{{ da.tonase }} TON</td>
                                            <td class="font-weight-bold">Rp. {{ da.ongkos_angkut | currency}}</td>
                                            <td class="font-weight-bold">Rp.
                                                {{ da.ongkos_angkut * da.tonase | currency }}</td>
                                            <td class="font-weight-bold">Rp. {{ da.supir_perton  | currency}}</td>
                                            <td class="font-weight-bold">Rp.
                                                {{ da.supir_perton * da.tonase | currency }}</td>
                                            <td class="font-weight-bold">Rp. {{ da.ferry | currency }}</td>
                                            <td class="font-weight-bold">Rp. {{ da.bonus_supir  | currency}}</td>
                                            <td class="font-weight-bold">{{ da.ton_bonus }} TON</td>
                                            <td class="font-weight-bold">{{ da.max_tonase }} TON</td>
                                            <td class="font-weight-bold">Rp.
                                                {{ da.bonus_supir * da.ton_bonus | currency }}</td>
                                            <td class="font-weight-bold">Rp. {{ da.total_uj | currency}}</td>
                                            <td class="font-weight-bold">Rp. {{ da.panjar | currency }}</td>
                                            <td class="font-weight-bold">Rp. {{ da.sisa_uj | currency }}</td>
                                            <td class="font-weight-bold">Rp.
                                                {{ (da.ongkos_angkut * da.tonase) - (da.total_uj) | currency }}</td>
                                            <td v-if="da.status == 'SUDAH DIBAYAR'"
                                                class="text-center align-middle bg-success">
                                                {{da.status}}
                                            </td>
                                            <td v-else class="text-center align-middle bg-danger font-weight-bold"> {{da.status}}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-bold text-right text-danger">Jumlah</th>
                                            <th class="text-bold text-right text-danger"></th>
                                            <th colspan="19"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <h3 class="card-header">Laporan Perawatan</h3>
                            <div class="card-body">
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
                                        <tr v-for="sp in report.perawatan" :key="sp.id">
                                            <td class="text-center font-weight-bold align-middle">
                                                {{ sp.tanggal | dateReformat }}</td>
                                            <td class="font-weight-bold">{{ sp.sparepart }}</td>
                                            <td class="text-center font-weight-bold">{{ sp.satuan }}</td>
                                            <td class="text-center font-weight-bold">Rp. {{ sp.harga | currency }}</td>
                                            <td class="font-weight-bold text-right">Rp. {{ sp.total | currency }}</td>
                                        </tr>
                                        <tr v-if="report.perawatan.length != 0">
                                            <td></td>
                                            <td class="font-weight-bold">Perawatan Mobil</td>
                                            <td></td>
                                            <td></td>
                                            <td class="font-weight-bold text-right">Rp. 1.000.000</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-bold text-right text-danger">Jumlah</th>
                                            <th class="text-bold text-right text-danger"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ml-auto mb-4">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group list-group-flush font-weight-bold">
                                    <li class="list-group-item">
                                        <div>Hasil Mobil<span class="float-right">Rp.
                                                {{ hasil_mobil | currency }}</span></div>
                                        <div>Total Biaya Perawatan<span class="float-right">Rp.
                                                {{ total_perawatan | currency }}</span></div>
                                        <div class="float-right">-</div>
                                    </li>
                                    <li class="list-group-item text-danger">
                                        <div>Total Bersih<span class="float-right">Rp.
                                                {{ hasil_bersih | currency }}</span></div>
                                    </li>
                                </ul>
                                <button type="button" @click="print()" class="btn btn-primary btn-lg btn-block font-weight-bold">
                                <i class="fas fa-print"></i> CETAK</button>
                            </div>
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
                report: {},
                form: new Form({
                    nopol: '',
                    bulan: {},
                    tahun: {},
                }),
            }
        },
        computed: {
            reportDate: function () {
                var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                    "September",
                    "Oktober", "November", "Desember"
                ];
                return month[this.form.bulan] + ' ' + this.form.tahun;
            },
            hasil_mobil: function () {
                let price = 0;
                for (let i = 0; i < this.report.angkutan.length; i++) {
                    price += this.report.angkutan[i].total_uj
                }
                return price;
            },
            total_perawatan: function () {
                if (this.report.perawatan.length == 0) {
                    return 0;
                }
                let price = 0;
                for (let i = 0; i < this.report.perawatan.length; i++) {
                    price += this.report.perawatan[i].total
                }
                return price + 1000000;
            },
            hasil_bersih: function () {
                return this.hasil_mobil - this.total_perawatan;
            },

        },
        methods: {
            LoadData() {
                axios.get('/api/myReport').then(({
                    data
                }) => (this.report = data[0]));
                this.form.bulan = new Date().getMonth();
                this.form.tahun = new Date().getFullYear();
            },
            filter() {
                this.form.post('/api/filterMyReport').then(({
                    data
                }) => (this.report = data[0]))
            },
            reset() {
                this.form.reset();
                this.LoadData();
                this.report = {};
            },
            print() {
                let bulan = parseInt(this.form.bulan) +1;
                let nopol = document.querySelector("meta[name='username']").getAttribute('content').toUpperCase();
                let a = window.open('/cetak/rekap-supir/' + (bulan) + '/' + this.form.tahun + '/' + nopol, '_blank');
                a.open();
                setTimeout(function () {
                    a.close();
                }, 3000);
            }

        },
        created() {
            this.LoadData();
        },
        mounted() {
            let username = document.querySelector("meta[name='username']").getAttribute('content');
            document.title = 'Annisa Rizki - Data Report "' + username.toUpperCase() + '"';
            this.dt = $("#angkutan").DataTable({
                "responsive": true,
            });
            this.ac = $("#perawatan").DataTable({
                "responsive": true,
                'rowsGroup': [0],
            });
            $(document).on('destroy.ac', function (e, settings) {
                var api = new $.fn.dataTable.Api(settings);
                api.off('order.dt');
                api.off('preDraw.dt');
                api.off('column-visibility.dt');
                api.off('search.dt');
                api.off('page.dt');
                api.off('length.dt');
                api.off('xhr.dt');
            });
        },
        watch: {
            report(val) {
                this.dt.destroy();
                this.ac.destroy();
                this.$nextTick(() => {
                    this.dt = $("#angkutan").DataTable({
                        "responsive": true,
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(),
                                data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function (i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\Rp. ,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column(18)
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Update footer
                            $(api.column(4).footer()).html(
                                "Rp. " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                            );
                        }
                    });
                    this.ac = $("#perawatan").DataTable({
                        "responsive": true,
                        'rowsGroup': [0],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(),
                                data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function (i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\Rp. ,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column(4)
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Update footer
                            $(api.column(4).footer()).html(
                                "Rp. " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                            );
                        }
                    });
                })
            }
        }
    }

</script>
