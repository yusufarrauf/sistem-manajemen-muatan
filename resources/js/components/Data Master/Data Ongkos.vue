<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Ongkos Biaya</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Data Master</li>
                            <li class="breadcrumb-item active">Ongkos Biaya</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table id="ongkos-biaya" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" scope="col" class="text-center align-middle">Asal Pemuatan</th>
                                    <th colspan="2" scope="col" class="text-center align-middle">Tujuan</th>
                                    <th colspan="2" scope="col" class="text-center align-middle">Ongkos</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle none">Supir @TON</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle none">Mobil @TON</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle none">Bonus Supir</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle none">Panjar</th>
                                    <th rowspan="2" scope="col" class="text-center align-middle">Modify</th>
                                </tr>
                                <tr>
                                    <th scope="col" class="text-center align-middle">Kota</th>
                                    <th scope="col" class="text-center align-middle">Perusahaan</th>
                                    <th scope="col" class="text-center align-middle">Vendor</th>
                                    <th scope="col" class="text-center align-middle">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="da in data_ongkos" :key="da.id">
                                    <td class="font-weight-bold text-center align-middle">{{ da.asal }}</td>
                                    <td class="text-center align-middle">{{ da.kota }}</td>
                                    <td class="text-center align-middle">{{ da.tujuan }}</td>
                                    <td class="text-center align-middle">Rp. {{ da.ongkos_vendor | currency }}</td>
                                    <td class="text-center align-middle">Rp. {{ da.ongkos_invoice | currency }}</td>
                                    <td class="text-center align-middle">Rp. {{ da.supir_perton | currency }}</td>
                                    <td class="text-center align-middle">Rp. {{ da.mobil_perton | currency }}</td>
                                    <td class="text-center align-middle">Rp. {{ da.bonus | currency }}</td>
                                    <td class="text-center align-middle">Rp. {{ da.panjar | currency }}</td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-primary font-weight-bold"
                                            @click="editData(da)"><i class="fa fa-edit"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger font-weight-bold"
                                            @click="deleteData(da)"><i class="fa fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2 mt-3">
                        <button type="button" @click="insertData()" class="btn btn-success btn-lg btn-block">
                            <i class="fas fa-plus"></i>
                            Tambah Data Ongkos Biaya</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Data Ongkos Biaya</h4>
                        <h4 v-show="!editmode" class="modal-title">Tambah Data Ongkos Biaya</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? edit() : insert()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Asal</label>
                                <div class="col">
                                    <select v-model="form.asal" id="asal" name="asal" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('asal') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option value="DUMP TRUCK">DUMP TRUCK</option>
                                        <option value="HAOHAN CEMENT">HAOHAN CEMENT</option>
                                        <option value="IMS">IMS</option>
                                        <option value="KRNG">KRNG</option>
                                        <option value="SBID">SBID</option>
                                        <option value="WANGDA">WANGDA</option>
                                        <option value="WSD">WSD</option>
                                    </select>
                                    <has-error :form="form" field="asal"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Tujuan: Kota</label>
                                <div class="col">
                                    <select v-model="form.kota" id="kota" name="kota" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('kota') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option v-for="da in kota" :value="da.kota" :key="da.id">{{ da.kota }}</option>
                                    </select>
                                    <has-error :form="form" field="kota"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Tujuan: Perusahaan</label>
                                <div class="col">
                                    <select v-if="form.asal == 'KRNG'" v-model="form.tujuan" id="tujuan" name="tujuan"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('tujuan') }"
                                        disabled>
                                        <option value hidden selected>== PILIH ==</option>
                                    </select>
                                    <select v-else v-model="form.tujuan" id="tujuan" name="tujuan" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('tujuan') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option v-for="da in pelanggan" :value="da.nama" :key="da.id">{{ da.nama }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="tujuan"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Ongkos: Vendor</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.ongkos_vendor"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('ongkos_vendor') }">
                                    </vue-numeric>
                                    <has-error :form="form" field="ongkos_vendor"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Ongkos: Invoice</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.ongkos_invoice"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('ongkos_invoice') }">
                                    </vue-numeric>
                                    <has-error :form="form" field="ongkos_invoice"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Supir @TON</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.supir_perton"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('supir_perton') }">
                                    </vue-numeric>
                                    <has-error :form="form" field="supir_perton"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Mobil @TON</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.mobil_perton"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('mobil_perton') }">
                                    </vue-numeric>
                                    <has-error :form="form" field="mobil_perton"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Bonus</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.bonus" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('bonus') }">
                                    </vue-numeric>
                                    <has-error :form="form" field="bonus"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Uang Panjar</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.panjar" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('panjar') }">
                                    </vue-numeric>
                                    <has-error :form="form" field="panjar"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-show="editmode" :disabled="form.busy"
                                class="btn btn-md btn-success float-right mr-2" type="submit">Update</button>
                            <button v-show="!editmode" :disabled="form.busy"
                                class="btn btn-md btn-primary float-right mr-2" type="submit">Simpan</button>
                            <button class="btn btn-md btn-danger float-right mr-2" type="button"
                                data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                data_ongkos: {},
                kota: {},
                pelanggan: {},
                form: new Form({
                    id: '',
                    asal: '',
                    tujuan: '',
                    kota: '',
                    ongkos_vendor: 0,
                    ongkos_invoice: 0,
                    supir_perton: 0,
                    mobil_perton: 0,
                    bonus: 0,
                    panjar: 0
                })
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/data-ongkos').then(({
                    data
                }) => (this.data_ongkos = data))
                axios.get('/api/data-kota').then(({
                    data
                }) => (this.kota = data))
                axios.get('/api/data-pelanggan').then(({
                    data
                }) => (this.pelanggan = data))
            },
            insertData() {
                this.editmode = false;
                this.form.reset();
                $('#Modal').modal('show')
            },
            insert() {
                this.$Progress.start();
                this.form.post('/api/data-ongkos')
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Ongkos Biaya Berhasil Ditambahkan'
                        });
                        this.$Progress.finish();
                        this.form.reset();
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
                        });
                        this.$Progress.fail();
                    });
            },
            editData(da) {
                this.editmode = true;
                this.form.fill(da);
                $('#Modal').modal('show');
            },
            edit() {
                this.$Progress.start();
                this.form.put('/api/data-ongkos/' + this.form.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Ongkos Biaya Berhasil Diubah'
                        });
                        this.$Progress.finish();
                        this.form.reset();
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
                        });
                        this.$Progress.fail();
                    });
            },
            deleteData(da) {
                Swal.fire({
                    title: 'Anda Yakin Ingin Menghapus Ongkos Biaya Asal "' + da.asal + '" Tujuan/Kota "' + da
                        .tujuan + '/' + da.kota + '" ?',
                    text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/data-ongkos/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Ongkos Biaya Berhasil Dihapus.',
                                'success',
                            );
                            Fire.$emit('reloadData');
                        }).catch(() => {
                            Swal.fire("Error!!", "Terjadi Kesalahan Saat Menghapus Data", "warning");
                        });
                    }
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
            document.title = 'Annisa Rizki - Ongkos Biaya';
            this.dt = $("#ongkos-biaya").DataTable({
                "responsive": false,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                }, ]
            });
        },
        watch: {
            data_ongkos(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#ongkos-biaya").DataTable({
                        "responsive": false,
                        "scrollX": true,
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            }
                        }, ]
                    });
                })
            }
        }
    }

</script>
