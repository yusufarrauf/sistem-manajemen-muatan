<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Filter Angkutan Palembang</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Laporan</li>
                            <li class="breadcrumb-item active">Filter Angkutan Palembang</li>
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
                                <label for="name" class="col-md-1 col-form-label text-md-left">Bulan </label>
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
                                <label for="name" class="col-md-1 col-form-label text-md-left">Tahun </label>
                                <div class="col-md-3">
                                    <select v-model="form.tahun" id="tahun" name="tahun"
                                        class="form-control text-center" data-live-search="true">
                                        <option v-for="n in 51" :value="1999 + n" :key="n">{{ 1999 + n }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <button type="submit" class="btn btn-primary float-right ml-2"><i
                                            class="fas fa-search"></i> Cari Data</button>
                                    <button @click="reset()" type="button" class="btn btn-danger float-right"><i
                                            class="fas fa-undo"></i>
                                        Reset</button>
                                </div>
                            </div>
                        </form>
                        <table id="angkutan" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Nomor Polisi</th>
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
                                    <th scope="col" class="none">Tanggal Input</th>
                                    <th scope="col" class="none ">Tanggal Ubah</th>
                                    <th scope="col" class="text-center">FILTER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(da, index) in angkutan" :key="da.id">
                                    <td class="font-weight-bold align-middle">{{ index +1 }}</td>
                                    <td class="text-center align-middle font-weight-bold">
                                        {{ da.tanggal | dateReformat }}</td>
                                    <td class="text-center align-middle font-weight-bold">{{ da.nopol }}</td>
                                    <td class="text-center align-middle font-weight-bold">{{ da.transportir }}</td>
                                    <td class="font-weight-bold">{{ da.jenis_angkutan }}</td>
                                    <td style="background-color: red !importan" class="font-weight-bold">
                                        {{ da.asal_pemuatan }}</td>
                                    <td class="font-weight-bold">{{ da.no_surat }}</td>
                                    <td class="font-weight-bold">{{ da.tujuan }}</td>
                                    <td class="font-weight-bold">{{ da.kota }}</td>
                                    <td class="font-weight-bold">{{ da.tonase }} TON</td>
                                    <td class="font-weight-bold">Rp. {{ da.ongkos_angkut | currency}}</td>
                                    <td class="font-weight-bold">Rp. {{ da.ongkos_angkut * da.tonase | currency }}</td>
                                    <td class="font-weight-bold">Rp. {{ da.supir_perton  | currency}}</td>
                                    <td class="font-weight-bold">Rp. {{ da.supir_perton * da.tonase | currency }}</td>
                                    <td class="font-weight-bold">Rp. {{ da.ferry | currency }}</td>
                                    <td class="font-weight-bold">Rp. {{ da.bonus_supir  | currency}}</td>
                                    <td class="font-weight-bold">{{ da.ton_bonus }} TON</td>
                                    <td class="font-weight-bold">{{ da.max_tonase }} TON</td>
                                    <td class="font-weight-bold">Rp. {{ da.bonus_supir * da.ton_bonus | currency }}</td>
                                    <td class="font-weight-bold">Rp. {{ da.total_uj | currency}}</td>
                                    <td class="font-weight-bold">Rp. {{ da.panjar | currency }}</td>
                                    <td class="font-weight-bold">Rp. {{ da.sisa_uj | currency }}</td>
                                    <td class="font-weight-bold">Rp.
                                        {{ (da.ongkos_angkut * da.tonase) - (da.total_uj) | currency }}</td>
                                    <td class="font-weight-bold">{{ da.created_at | dateReformat}}</td>
                                    <td class="font-weight-bold">{{ da.updated_at | dateReformat}}</td>
                                    <td class="text-center align-middle">
                                        <select v-if="da.isFiltered == 0" id="isFiltered" :value="da.isFiltered"
                                            @change="editStatus(da.id)" name="isFiltered"
                                            class=" form-control bg-success font-weight-bold">
                                            <option value="0" hidden>TIDAK AKTIF</option>
                                            <option value="1">AKTIF</option>
                                        </select>
                                        <select v-else id="isFiltered" :value="da.isFiltered"
                                            @change="editStatus(da.id)" name="isFiltered"
                                            class=" form-control bg-danger font-weight-bold">
                                            <option value="0">TIDAK AKTIF</option>
                                            <option value="1" hidden>AKTIF</option>
                                        </select>
                                    </td>
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
                form: new Form({
                    bulan: {},
                    tahun: {},
                }),
                angkutan: {},
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/angkutanPalembang').then(({
                    data
                }) => (this.angkutan = data))
                this.form.bulan = new Date().getMonth();
                this.form.tahun = new Date().getFullYear();
            },
            filter() {
                this.form.post('/api/angkutanPalembang').then(({
                    data
                }) => (this.angkutan = data))
            },
            reset() {
                this.LoadData();
            },
            editStatus(id) {
                let status = new Form({
                    id: id,
                    status: document.getElementById("isFiltered").value,
                });
                this.$Progress.start();
                status.post('/api/updateAngkutanPalembang')
                    .then(() => {
                        Fire.$emit('reloadData');
                        Toast.fire({
                            icon: 'success',
                            title: 'Filter Berhasil Diterapkan'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
                        });
                        this.$Progress.fail();
                    })
            },
        },
        created() {
            this.LoadData();
            Fire.$on('reloadData', () => {
                this.LoadData();
            });
        },
        mounted() {
            document.title = 'Annisa Rizki - Laporan Filter Angkutan Palembang';
            this.dt = $("#angkutan").DataTable({
                "responsive": true,
                dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excel',
                        }],
            });
        },
        watch: {
            angkutan(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#angkutan").DataTable({
                        "responsive": true,
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excel',
                        }],
                    });
                })
            }
        }
    }

</script>
