<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Approval Data Perawatan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Laporan</li>
                            <li class="breadcrumb-item active">Approval Data Perawatan</li>
                        </ol>
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

                        <table id="perawatan" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                                    <th rowspan="2" scope="col" class="align-middle">Biaya (Sparepart)</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle">Satuan</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle">Harga</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle">Jumlah</th>
                                    <th colspan="2" scope="col" class="text-center align-middle">Approval</th>
                                </tr>
                                <tr>
                                    <th scope="col" class="text-center align-middle">Status</th>
                                    <th scope="col" class="text-center align-middle"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sp in perawatan" :key="sp.id">
                                    <td class="text-center font-weight-bold align-middle">
                                        {{ sp.tanggal | dateReformat }}</td>
                                    <td class="font-weight-bold">{{ sp.sparepart }}</td>
                                    <td class="text-center font-weight-bold">{{ sp.satuan }}</td>
                                    <td class="text-center font-weight-bold">Rp. {{ sp.harga | currency }}</td>
                                    <td class="font-weight-bold text-center">Rp. {{ sp.total | currency }}</td>
                                    <td v-if="sp.isApprove == 1" class="text-center font-weight-bold bg-warning">PROSES</td>
                                    <td v-else-if="sp.isApprove == 0" class="text-center font-weight-bold bg-danger">DI TOLAK</td>
                                    <td v-else class="text-center font-weight-bold bg-success">DI TERIMA</td>
                                    <td v-if="sp.isApprove == 1" class="text-center">
                                        <button type="button" class="btn btn-danger" @click="update(sp.id, 0)"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-success" @click="update(sp.id, 2)"><i class="fa fa-check"></i></button>
                                    </td>
                                    <td v-else></td>
                                </tr>
                            </tbody>
                        </table>
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
                perawatan: {},
                form: new Form({
                    bulan: {},
                    tahun: {},
                }),
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/approvalData').then(({
                    data
                }) => (this.perawatan = data))
                this.form.bulan = new Date().getMonth();
                this.form.tahun = new Date().getFullYear();
            },
            filter() {
                this.form.post('/api/approvalData').then(({
                    data
                }) => (this.perawatan = data))
            },
            reset() {
                this.form.reset();
                this.form.bulan = new Date().getMonth();
                this.form.tahun = new Date().getFullYear();
            },
            update(id_a, status_a){
                let str = new Form({
                    id: id_a,
                    status: status_a,
                });
                str.post('/api/updateApprovalData').then(function(){
                    this.LoadData();
                });
            },
        },
        created() {
            this.LoadData();
            Fire.$on('reloadData', () => {
                this.LoadData();
            });
        },
        mounted() {
            document.title = 'Annisa Rizki - Approval Data Perawatan';
            this.dt = $("#perawatan").DataTable({
                "responsive": false,
                        "scrollX": true,
            });
        },
        watch: {
            perawatan(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#perawatan").DataTable({
                        "responsive": false,
                        "scrollX": true,
                    });
                })
            },
        }
    }

</script>
