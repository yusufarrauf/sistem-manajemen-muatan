<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Perawatan Mobil</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Input Data</li>
                            <li class="breadcrumb-item active">Perawatan Mobil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <form @submit.prevent="insert()" @keydown="form.onKeydown($event)">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Tanggal</label>
                                <div class="col-4">
                                    <input @change="getLimit()" v-model="form.tanggal" type="date" name="tanggal"
                                        class="form-control text-center font-weight-bold" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Nomor Polisi</label>
                                <div class="col-4">
                                    <a href="#" @click="openKendaraan()">
                                        <input v-model="form.nopol" type="text" name="nopol"
                                            class="form-control text-center font-weight-bold"
                                            :class="{ 'is-invalid': form.errors.has('nopol') }"
                                            placeholder="Pilih Nomor Polisi" disabled style="cursor: pointer">
                                    </a>
                                    <has-error :form="form" field="nopol"></has-error>
                                </div>
                            </div>
                            <div v-if="perawatanBan >= 3" class="card bg-warning">
                                <div class="card-body font-weight-bold text-center">
                                    <div>NOMOR POLISI <span class="text-danger">{{ form.nopol }}</span> SUDAH MELEBIHI
                                        BATAS PERGANTIAN BAN PADA BULAN INI ({{ dateReformat(form.tanggal)}}) !!</div>
                                    <div>INFORMASI PERGANTIAN BAN YANG DI INPUT AKAN MELALUI PERSETUJUAN TERLEBIH DAHULU !!
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body row justify-content-center">
                                    <div class="col-12 text-center mb-3">
                                        <h3 class="m-0 text-dark font-weight-bold">DATA PERAWATAN</h3>
                                    </div>
                                    <div v-for="(da, index) in form.sparepart" class="col-12 form-row" :key="index">
                                        <div class="form-group text-center col-md-5">
                                            <label v-show="index == 0">BIAYA (SPAREPART)</label>
                                            <input v-model="form.sparepart[index].nama" type="text" class="form-control"
                                                placeholder="Nama Sparepart" required>
                                        </div>
                                        <div class="form-group text-center col-md-2">
                                            <label v-show="index == 0">HARGA</label>
                                            <vue-numeric currency="Rp." separator="."
                                                v-model="form.sparepart[index].harga" class="form-control">
                                            </vue-numeric>
                                        </div>
                                        <div class="form-group text-center col-md-1">
                                            <label v-show="index == 0">SATUAN</label>
                                            <input min="0.01" step="0.01" @change="total(index)" v-model="form.sparepart[index].satuan"
                                                type="number" class="form-control text-center" placeholder="Satuan"
                                                required>
                                        </div>
                                        <div class="form-group text-center col-md-3">
                                            <label v-show="index == 0">TOTAL</label>
                                            <vue-numeric currency="Rp." separator="."
                                                v-model="form.sparepart[index].total" class="form-control" disabled>
                                            </vue-numeric>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label v-show="index == 0" for="">&nbsp</label>
                                            <button v-if="index > 0" type="button" @click="deleteData(index)"
                                                class="btn btn-outline-danger btn-block">
                                                <i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 mb-2 mt-3">
                                        <button type="button" @click="addData()"
                                            class="btn btn-primary btn-lg btn-block">
                                            <i class="fas fa-plus"></i>
                                            Tambah Data</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 offset-md-9 mb-5">
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    <i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Kendaraan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table id="kendaraan" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Nomor Polisi</th>
                                    <th scope="col" class="text-center">Vendor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(da, index) in kendaraan" :key="da.id">
                                    <td class="text-center font-weight-bold">{{ da.nopol | nopolFormat}}</td>
                                    <td class="text-center font-weight-bold">{{ da.vendor}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger font-weight-bold"
                                            @click="getKendaraan(index)">P I L I H</button>
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
                kendaraan: {},
                perawatanBan: 0,
                form: new Form({
                    id: '',
                    tanggal: '',
                    nopol: '',
                    sparepart: [{
                        nama: '',
                        satuan: 0,
                        harga: '',
                        total: '',
                    }]
                })
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/data-kendaraan').then(({
                    data
                }) => (this.kendaraan = data))
            },
            openKendaraan() {
                $('#Modal').modal('show')
            },
            getKendaraan(index) {
                let data = this.dt.row(index).data();
                this.form.nopol = data[0];
                this.getLimit();
                $('#Modal').modal('hide')
            },
            dateReformat(tanggal) {
                var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                    "September",
                    "Oktober", "November", "Desember"
                ];
                let bulan = tanggal.split('-')[1];
                return month[bulan-1].toUpperCase();
            },
            getLimit() {
                if (this.form.nopol != '' && this.form.tanggal != '') {
                    let data = new Form({
                        nopol: this.form.nopol,
                        tanggal: this.form.tanggal
                    });
                    data.post('/api/getLimitData').then(({
                        data
                    }) => (this.perawatanBan = data))
                }
            },
            total(index) {
                this.form.sparepart[index].total = this.form.sparepart[index].harga * this.form.sparepart[index].satuan;
            },
            addData() {
                let sparepart = {};
                sparepart.nama = "";
                sparepart.satuan = 0;
                sparepart.harga = "";
                sparepart.total = "";
                this.form.sparepart.push(sparepart);
            },
            deleteData(index) {
                this.form.sparepart.splice(index, 1);
            },
            insert() {
                this.$Progress.start();
                this.form.post('/api/perawatan')
                    .then(() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Perawatan Mobil Berhasil Disimpan'
                        });
                        this.$Progress.finish();
                        this.form.reset();
                    })
                    .catch((resp) => {
                        Toast.fire({
                            icon: 'error',
                            title: resp.response.data.status_code + ': ' + resp.response.data.message
                        });
                        this.$Progress.fail();
                    });
            }
        },
        created() {
            this.LoadData();
        },
        mounted() {
            document.title = 'Annisa Rizki - Perawatan Mobil';
            this.dt = $("#kendaraan").DataTable({
                "responsive": true,
            });

        },
        watch: {
            kendaraan(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#kendaraan").DataTable({
                        "responsive": true,
                    });
                })
            }
        }
    }

</script>
