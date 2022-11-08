<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Ubah Data Angkutan</h1>
                        <h3 class="bg-secondary rounded">Nomor Polisi: <strong
                                class="text-success">{{ angkutan.nopol }}</strong> | Tanggal: <strong
                                class="text-success">{{ angkutan.tanggal | dateReformat }}</strong></h3>
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
                                <div class="col-md-4">
                                    <input @change="changeDate(form.asal)" v-model="form.tanggal" type="date"
                                        name="tanggal" :class="{ 'is-invalid': form.errors.has('tanggal') }"
                                        class="form-control text-center font-weight-bold">
                                    <has-error :form="form" field="tanggal"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Nomor Polisi</label>
                                <div class="col-md-4">
                                    <a href="#" @click="openKendaraan()">
                                        <input v-model="form.nopol" type="text" name="nopol"
                                            class="form-control text-center font-weight-bold"
                                            :class="{ 'is-invalid': form.errors.has('nopol') }"
                                            placeholder="Pilih Nomor Polisi" disabled style="cursor: pointer">
                                        <has-error :form="form" field="nopol"></has-error>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Transportir</label>
                                <div class="col-md-4">
                                    <select v-model="form.transportir" id="transportir" name="transportir"
                                        class="form-control text-center"
                                        :class="{ 'is-invalid': form.errors.has('transportir') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option value="ANNISA">ANNISA</option>
                                        <option value="PASOKA">PASOKA</option>
                                    </select>
                                    <has-error :form="form" field="transportir"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Jenis Angkutan</label>
                                <div class="col">
                                    <select @change="fillAsal(form.jenis)" v-model="form.jenis" id="jenis" name="jenis"
                                        class="form-control text-center"
                                        :class="{ 'is-invalid': form.errors.has('jenis') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option v-for="da in muatan" :value="da.muatan" :key="da.id">{{ da.muatan }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="jenis"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Asal Pemuatan</label>
                                <div class="col">
                                    <input v-model="form.asal" type="text" name="asal" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('asal') }" disabled>
                                    <has-error :form="form" field="asal"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">No. Surat Jalan</label>
                                <div class="col">
                                    <div v-if="form.asal == 'KRNG'" class="input-group">
                                        <input @input="maxText(1)" v-model="form.no_surat.awal" type="number"
                                            name="no_surat.awal" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('no_surat.awal') }">
                                        <input v-model="form.no_surat.akhir" type="text" name="no_surat.akhir"
                                            class="form-control font-weight-bold" disabled>
                                        <has-error :form="form" field="no_surat.awal"></has-error>
                                    </div>
                                    <div v-else-if="form.asal == 'HAOHAN CEMENT'" class="input-group">
                                        <input v-model="form.no_surat.awal" type="text" name="no_surat.awal"
                                            class="form-control font-weight-bold" disabled>
                                        <input @input="maxText(2)" v-model="form.no_surat.akhir" type="number"
                                            name="no_surat.akhir" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('no_surat.akhir') }">
                                        <has-error :form="form" field="no_surat.akhir"></has-error>
                                    </div>
                                    <div v-else class="input-group">
                                        <input v-if="form.asal != ''" @input="maxText(3)" v-model="form.no_surat.awal"
                                            type="number" name="no_surat.awal" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('no_surat.awal') }">
                                        <input v-else class="form-control" disabled>
                                    </div>
                                    <has-error :form="form" field="no_surat.awal"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Tujuan</label>
                                <div class="col">
                                    <select v-model="form.tujuan" id="tujuan" name="tujuan"
                                        class="form-control text-center"
                                        :class="{ 'is-invalid': form.errors.has('tujuan') }" data-live-search="true">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option v-for="da in pelanggan" :value="da.nama" :key="da.id">{{da.nama}}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="tujuan"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Kota</label>
                                <div class="col">
                                    <select @change="getCost()" v-if="form.tujuan !== ''" v-model="form.kota" id="kota"
                                        name="kota" class="form-control text-center selectpicker"
                                        :class="{ 'is-invalid': form.errors.has('kota') }" data-live-search="true">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option v-for="da in kota" :value="da.kota" :key="da.id">{{ da.kota }}</option>
                                    </select>
                                    <select v-else v-model="form.kota" id="kota" name="kota"
                                        class="form-control text-center selectpicker"
                                        :class="{ 'is-invalid': form.errors.has('kota') }" disabled>
                                        <option value hidden selected>== PILIH ==</option>
                                    </select>
                                    <has-error :form="form" field="kota"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Tonase</label>
                                <div class="col">
                                    <input @change="calculate()" v-model="form.tonase" type="number" step="0.01"
                                        name="tonase" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('tonase') }">
                                    <has-error :form="form" field="tonase"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Ongkos Angkut</label>
                                <div class="col-md-4">
                                    <vue-numeric currency="Rp." separator="." v-model="form.ongkos.jumlah"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                                <label class="col-md-2 col-form-label text-md-right">Jumlah</label>
                                <div class="col-md-4">
                                    <vue-numeric currency="Rp." separator="." v-model="form.ongkos.total"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Supir @TON</label>
                                <div class="col-md-4">
                                    <vue-numeric currency="Rp." separator="." v-model="form.sopir.jumlah"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                                <label class="col-md-2 col-form-label text-md-right">Jumlah</label>
                                <div class="col-md-4">
                                    <vue-numeric currency="Rp." separator="." v-model="form.sopir.total"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Max Tonase</label>
                                <div class="col">
                                    <input v-model="form.max_ton" type="number" step="0.01" name="max_ton"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('max_ton') }" readonly>
                                    <has-error :form="form" field="max_ton"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Ferry</label>
                                <div class="col">
                                    <vue-numeric v-on:keyup.native="reCalculate" currency="Rp." separator="."
                                        v-model="form.ferry" class="form-control">
                                    </vue-numeric>
                                </div>
                            </div>
                            <div v-if="form.tonase > 31" class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Bonus Sopir @TON</label>
                                <div class="col-md-2">
                                    <vue-numeric currency="Rp." separator="." v-model="form.bonus.biaya"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                    <has-error :form="form" field="bonus.biaya"></has-error>
                                </div>
                                <label class="col-md-2 col-form-label text-md-left">Jumlah</label>
                                <div class="col-md-2">
                                    <input v-model="form.bonus.jumlah" type="number" step="0.01" name="bonus_jumlah"
                                        class="form-control" disabled>
                                </div>
                                <label class="col-md-2 col-form-label text-md-left">Hasil Bonus</label>
                                <div class="col-md-2">
                                    <vue-numeric currency="Rp." separator="." v-model="form.bonus.total"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Total UJ Sopir</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.total_uj"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Panjar</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.panjar" class="form-control"
                                        disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Sisa UJ Sopir</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.sisa" class="form-control"
                                        disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 offset-md-6 mb-4">
                                    <button @click="resetForm()" type="button" class="btn btn-danger btn-lg btn-block">
                                        <i class="fa fa-undo"></i> Reset</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-save"></i> Simpan</button>
                                </div>
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
                angkutan: {},
                kendaraan: {},
                muatan: {},
                kota: {},
                pelanggan: {},
                form: new Form({
                    id: '',
                    nopol: '',
                    tanggal: '',
                    transportir: '',
                    jenis: '',
                    asal: '',
                    no_surat: {
                        awal: '',
                        akhir: '',
                    },
                    tujuan: '',
                    plant: '',
                    kota: '',
                    tonase: 0,
                    ongkos: {
                        jumlah: 0,
                        total: 0,
                    },
                    sopir: {
                        jumlah: 0,
                        total: 0,
                    },
                    ferry: 0,
                    max_ton: 0,
                    bonus: {
                        biaya: 0,
                        jumlah: 0,
                        total: 0,
                    },
                    total_uj: 0,
                    panjar: 0,
                    sisa: 0,
                })
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/angkutan/' + this.$route.params.id).then(({
                    data
                }) => {
                    this.angkutan = data[0];
                    this.form.fill(data[0]);
                })
                axios.get('/api/data-muatan').then(({
                    data
                }) => (this.muatan = data));
                axios.get('/api/data-kota').then(({
                    data
                }) => (this.kota = data));
                axios.get('/api/data-pelanggan').then(({
                    data
                }) => (this.pelanggan = data))
            },
            openKendaraan() {
                $('#Modal').modal('show')
            },
            getKendaraan(index) {
                let data = this.dt.row(index).data();
                this.form.nopol = data[0];
                $('#Modal').modal('hide')
            },
            changeDate(asal) {
                let date = new Date(this.form.tanggal)
                if (asal == "KRNG") {
                    this.form.no_surat.awal = '';
                    this.form.no_surat.akhir = '/DO/SPP/KRNG/' + ("0" + (date.getMonth() + 1)).slice(-2) + '/' + date
                        .getFullYear();
                } else if (asal == 'HAOHAN CEMENT') {
                    this.form.no_surat.awal = 'A' + date.getFullYear() + ("0" + (date.getMonth() + 1)).slice(-2) + (
                        "0" + (date.getDate())).slice(-2);
                    this.form.no_surat.akhir = '';
                } else {
                    this.form.no_surat.awal = '';
                    this.form.no_surat.akhir = '';
                }
            },
            fillAsal(value) {
                let nama = value;
                let asal = _.pickBy(this.material, function (u) {
                    return u.nama == nama;
                });
                let arrayAsal = Object.keys(asal).map(i => asal[i]);
                this.form.asal = arrayAsal[0].asal;

                let date = new Date(this.form.tanggal)
                if (this.form.asal == "KRNG") {
                    this.form.no_surat.awal = '';
                    this.form.no_surat.akhir = '/DO/SPP/KRNG/' + ("0" + (date.getMonth() + 1)).slice(-2) + '/' + date
                        .getFullYear();
                } else if (this.form.asal == 'HAOHAN CEMENT') {
                    this.form.no_surat.awal = 'A' + date.getFullYear() + ("0" + (date.getMonth() + 1)).slice(-2) + (
                        "0" + (date.getDate())).slice(-2);
                    this.form.no_surat.akhir = '';
                } else {
                    this.form.no_surat.awal = '';
                    this.form.no_surat.akhir = '';
                }
            },
            maxText(id) {
                if (id == 1) {
                    if (this.form.no_surat.awal.length > 5) {
                        this.form.no_surat.awal = this.form.no_surat.awal.slice(0, 5)
                    }
                } else if (id == 2) {
                    if (this.form.no_surat.akhir.length > 5) {
                        this.form.no_surat.akhir = this.form.no_surat.akhir.slice(0, 5)
                    }
                } else {
                    if (this.form.no_surat.awal.length > 6) {
                        this.form.no_surat.awal = this.form.no_surat.awal.slice(0, 6)
                    }
                }
            },
            getCost() {
                let dataForm = new Form({
                    asal: this.form.asal,
                    kota: this.form.kota,
                    perusahaan: this.form.tujuan,
                });
                dataForm.post('/api/getCost').then(({
                    data
                }) => {
                    this.form.ongkos.jumlah = data.ongkos_invoice;
                    this.form.ongkos.total = data.ongkos_invoice;
                    this.form.sopir.jumlah = data.supir_perton;
                    this.form.sopir.total = data.supir_perton;
                    this.form.bonus.biaya = data.bonus;
                    this.form.total_uj = data.supir_perton;
                    this.form.panjar = data.panjar;
                    this.form.sisa = Math.abs(data.supir_perton - data.panjar);
                });
            },
            calculate() {
                this.form.ongkos.total = this.form.ongkos.jumlah * this.form.tonase;
                this.form.sopir.total = this.form.sopir.jumlah * this.form.tonase;
                if (this.form.tonase > 31) {
                    if (this.vendor == "PASOKA") {
                        this.form.bonus.jumlah = 0;
                        this.form.bonus.total = 0;
                    } else {
                        this.form.bonus.jumlah = this.form.tonase - 31;
                        this.form.bonus.total = this.form.bonus.biaya * this.form.bonus.jumlah;
                    }
                } else {
                    this.form.bonus.jumlah = 0;
                    this.form.bonus.total = 0;
                }
                if (this.form.tonase >= 35) {
                    this.form.max_ton = 35;
                } else {
                    this.form.max_ton = this.form.tonase;
                }
                this.form.total_uj = this.form.sopir.total + this.form.bonus.total;
                this.form.sisa = this.form.total_uj - this.form.ferry - this.form.panjar;
                if(this.form.asal == "KRNG"){
                    this.form.sisa = 0;
                }
            },
            reCalculate: function (evt) {
                this.form.ongkos.total = this.form.ongkos.jumlah * this.form.tonase;
                this.form.sopir.total = this.form.sopir.jumlah * this.form.tonase;
                if (this.form.tonase > 31) {
                    if (this.vendor == "PASOKA") {
                        this.form.bonus.jumlah = 0;
                        this.form.bonus.total = 0;
                    } else {
                        this.form.bonus.jumlah = this.form.tonase - 31;
                        this.form.bonus.total = this.form.bonus.biaya * this.form.bonus.jumlah;
                    }
                } else {
                    this.form.bonus.jumlah = 0;
                    this.form.bonus.total = 0;
                }
                if (this.form.tonase >= 35) {
                    this.form.max_ton = 35;
                } else {
                    this.form.max_ton = this.form.tonase;
                }
                this.form.total_uj = this.form.sopir.total + this.form.bonus.total;
                this.form.sisa = this.form.total_uj - this.form.ferry - this.form.panjar;
                if(this.form.asal == "KRNG"){
                    this.form.sisa = 0;
                }
            },
            insert() {
                this.$Progress.start();
                this.form.put('/api/angkutan/' + this.form.id)
                    .then(() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Informasi Angkutan Berhasil Diubah'
                        });
                        this.$Progress.finish();
                        this.form.reset();
                        window.location.replace("/data/angkutan");
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
                        });
                        this.$Progress.fail();
                    });
            },
            resetForm() {
                this.form.reset();
                this.form.clear();
            }
        },
        created() {
            this.LoadData();
        },
        mounted() {
            document.title = 'Annisa Rizki - Ubah Data Angkutan';
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
            },

        },
    }

</script>
