<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Kendaraan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Data Master</li>
                            <li class="breadcrumb-item active">Kendaraan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <h3 class="card-header">Vendor Kendaraan</h3>
                            <div class="card-body row justify-content-center">
                                <div class="col-md-12">
                                    <table id="vendor-kendaraan"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Username</th>
                                                <th scope="col">Nama Vendor</th>
                                                <th scope="col">Alamat</th>
                                                <th width="180px" scope="col" class="text-center">Modify</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="da in vendor_kendaraan" :key="da.id">
                                                <td class="font-weight-bold align-middle">{{ da.username }}</td>
                                                <td class="font-weight-bold align-middle">{{ da.nama }}</td>
                                                <td class="font-weight-bold align-middle">{{ da.alamat }}</td>
                                                <td class="text-center align-middle">
                                                    <button type="button" class="btn btn-primary font-weight-bold"
                                                        @click="editVendor(da)"><i class="fa fa-edit"></i>
                                                        Ubah</button>
                                                    <button type="button" class="btn btn-danger font-weight-bold"
                                                        @click="deleteVendor(da)"><i class="fa fa-trash"></i>
                                                        Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2 mt-3">
                                    <button type="button" @click="insertVendor()"
                                        class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-plus"></i>
                                        Tambah Data Vendor</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="offset-md-8 col-md-4 col-sm-12 mb-2 mt-3">
                        <button type="button" @click="insertKendaraan()" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-plus"></i>
                            Tambah Data Kendaraan</button>
                    </div>
                    <div v-for="dav in vendor_kendaraan" class="col-md-12" :key="dav.id">
                        <div class="card">
                            <h3 class="card-header">Data Kendaraan {{ dav.nama }}</h3>
                            <div class="card-body row justify-content-center">
                                <div class="col-md-12">
                                    <table id="data-kendaraan" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Nomor Polisi</th>
                                                <th scope="col" style="width: 240px" class="text-center">Supir</th>
                                                <th scope="col" style="width: 240px" class="text-center">STATUS</th>
                                                <th scope="col" style="width: 240px" class="text-center">Modify</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="da in filter_kendaraan(dav.nama)" :key="da.id">
                                                <td class="text-center font-weight-bold align-middle">
                                                    {{ da.nopol | nopolFormat }}
                                                </td>
                                                <td class="text-center align-middle">{{ da.supir }}</td>
                                                <td v-if="da.status == 'AKTIF'" class="text-center align-middle">
                                                    <select id="status" :value="da.status" @change="editStatus(da.id)"
                                                        name="status" class=" form-control bg-success font-weight-bold">
                                                        <option value="AKTIF" hidden>AKTIF</option>
                                                        <option value="NON-AKTIF">NON-AKTIF</option>
                                                    </select>
                                                </td>
                                                <td v-else class="text-center align-middle">
                                                    <select id="status" :value="da.status" @change="editStatus(da.id)"
                                                        name="status" class=" form-control bg-danger font-weight-bold">
                                                        <option value="NON-AKTIF" hidden>NON-AKTIF</option>
                                                        <option value="AKTIF">AKTIF</option>
                                                    </select></td>
                                                <td class="text-center align-middle">
                                                    <button type="button" class="btn btn-primary font-weight-bold"
                                                        @click="editKendaraan(da)"><i class="fa fa-edit"></i>
                                                        Ubah</button>
                                                    <button type="button" class="btn btn-danger font-weight-bold"
                                                        @click="deleteKendaraan(da)"><i class="fa fa-trash"></i>
                                                        Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="vendorModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Vendor Kendaraan</h4>
                        <h4 v-show="!editmode" class="modal-title">Tambah Vendor Kendaraan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? vendorEdit() : vendorInsert()"
                        @keydown="vendor.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nama Vendor</label>
                                <div class="col">
                                    <input v-model="vendor.nama" type="text" name="nama" class="form-control"
                                        :class="{ 'is-invalid': vendor.errors.has('nama') }"
                                        placeholder="Masukan Nama Vendor" maxlength="50">
                                    <has-error :form="vendor" field="nama"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Alamat</label>
                                <div class="col">
                                    <textarea rows="4" v-model="vendor.alamat" type="text" name="alamat"
                                        class="form-control" :class="{ 'is-invalid': vendor.errors.has('alamat') }"
                                        placeholder="Isikan Alamat"></textarea>
                                    <has-error :form="vendor" field="alamat"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Username</label>
                                <div class="col">
                                    <input v-model="vendor.username" type="text" name="username" class="form-control"
                                        :class="{ 'is-invalid': vendor.errors.has('username') }"
                                        placeholder="Masukan Username" maxlength="50">
                                    <has-error :form="vendor" field="username"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Password</label>
                                <div class="col">
                                    <input v-model="vendor.password" type="password" name="password"
                                        class="form-control" :class="{ 'is-invalid': vendor.errors.has('password') }"
                                        placeholder="Masukan Password" maxlength="50">
                                    <has-error :form="vendor" field="password"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-show="editmode" :disabled="vendor.busy"
                                class="btn btn-md btn-success float-right mr-2" type="submit">Update</button>
                            <button v-show="!editmode" :disabled="vendor.busy"
                                class="btn btn-md btn-primary float-right mr-2" type="submit">Simpan</button>
                            <button class="btn btn-md btn-danger float-right mr-2" type="button"
                                data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="kendaraanModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Data Kendaraan</h4>
                        <h4 v-show="!editmode" class="modal-title">Tambah Data Kendaraan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? kendaraanEdit() : kendaraanInsert()"
                        @keydown="kendaraan.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-left">Nama Vendor</label>
                                <div class="col">
                                    <select v-model="kendaraan.vendor" name="nama_vendor" class="form-control"
                                        :class="{ 'is-invalid': kendaraan.errors.has('vendor') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option v-for="da in vendor_kendaraan" :value="da.nama" :key="da.id">
                                            {{ da.nama }}</option>
                                    </select>
                                    <has-error :form="kendaraan" field="vendor"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nomor Polisi</label>
                                <div class="col">
                                    <input v-model="kendaraan.nopol" type="text" name="nopol" class="form-control"
                                        :class="{ 'is-invalid': kendaraan.errors.has('nopol') }"
                                        placeholder="Masukan Nomor Polisi" maxlength="10">
                                    <has-error :form="kendaraan" field="nopol"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nama Supir</label>
                                <div class="col">
                                    <input v-model="kendaraan.supir" type="text" name="supir" class="form-control"
                                        :class="{ 'is-invalid': kendaraan.errors.has('supir') }"
                                        placeholder="Masukan Nama Supir">
                                    <has-error :form="kendaraan" field="supir"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-show="editmode" :disabled="kendaraan.busy"
                                class="btn btn-md btn-success float-right mr-2" type="submit">Update</button>
                            <button v-show="!editmode" :disabled="kendaraan.busy"
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
                vendor_kendaraan: {},
                data_kendaraan: {},
                form: new Form({
                    id: '',
                    status: ''
                }),
                vendor: new Form({
                    id: '',
                    nama: '',
                    alamat: '',
                    username: '',
                    password: ''
                }),
                kendaraan: new Form({
                    id: '',
                    vendor: '',
                    nopol: '',
                    supir: '',
                    status: ''
                })
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
            },
            editStatus(id) {
                this.$Progress.start();
                this.form.status = document.getElementById("status").value;
                this.form.id = id;
                this.form.post('/api/updateStatusKendaraan')
                    .then(() => {
                        Fire.$emit('reloadData');
                        Toast.fire({
                            icon: 'success',
                            title: 'Status Berhasil Di Update'
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
                    })
            },
            insertVendor() {
                this.editmode = false;
                this.vendor.reset();
                $('#vendorModal').modal('show')
            },
            editVendor(da) {
                this.editmode = true;
                this.vendor.fill(da);
                $('#vendorModal').modal('show');
            },
            insertKendaraan() {
                this.editmode = false;
                this.kendaraan.reset();
                $('#kendaraanModal').modal('show')
            },
            editKendaraan(da) {
                this.editmode = true;
                this.kendaraan.fill(da);
                $('#kendaraanModal').modal('show');
            },
            vendorInsert() {
                this.$Progress.start();
                this.vendor.post('/api/vendor-kendaraan')
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#vendorModal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Vendor Kendaraan Berhasil Ditambahkan'
                        });
                        this.$Progress.finish();
                        this.vendor.reset();
                    })
                    .catch((resp) => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!' + resp
                        });
                        this.$Progress.fail();
                    });
            },
            kendaraanInsert() {
                this.$Progress.start();
                this.kendaraan.post('/api/data-kendaraan')
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#kendaraanModal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Kendaraan Berhasil Ditambahkan'
                        });
                        this.$Progress.finish();
                        this.kendaraan.reset();
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
                        });
                        this.$Progress.fail();
                    });
            },
            vendorEdit() {
                this.$Progress.start();
                this.vendor.put('/api/vendor-kendaraan/' + this.vendor.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#vendorModal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Vendor Kendaraan Berhasil Diubah'
                        });
                        this.$Progress.finish();
                        this.vendor.reset();
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
                        });
                        this.$Progress.fail();
                    });
            },
            kendaraanEdit() {
                this.$Progress.start();
                this.kendaraan.put('/api/data-kendaraan/' + this.kendaraan.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#kendaraanModal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Kendaraan Berhasil Diubah'
                        });
                        this.$Progress.finish();
                        this.kendaraan.reset();
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
                        });
                        this.$Progress.fail();
                    });
            },
            deleteVendor(da) {
                Swal.fire({
                    title: 'Anda Yakin Ingin Menghapus Vendor Kendaraan "' + da.nama + '" ?',
                    text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        this.vendor.delete('/api/vendor-kendaraan/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Vendor Kendaraan "' + da.nama + '" Berhasil Dihapus.',
                                'success',
                            );
                            Fire.$emit('reloadData');
                        }).catch(() => {
                            Swal.fire("Error!!", "Terjadi Kesalahan Saat Menghapus Vendor", "warning");
                        });
                    }
                })
            },
            deleteKendaraan(da) {
                Swal.fire({
                    title: 'Anda Yakin Ingin Menghapus Data Kendaraan "' + da.nopol + '" ?',
                    text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        this.kendaraan.delete('/api/data-kendaraan/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Data Kendaraan "' + da.nopol + '" Berhasil Dihapus.',
                                'success',
                            );
                            Fire.$emit('reloadData');
                        }).catch(() => {
                            Swal.fire("Error!!", "Terjadi Kesalahan Saat Menghapus Data Kendaraan",
                                "warning");
                        });
                    }
                })
            },
            filter_kendaraan(data) {
                return _.pickBy(this.data_kendaraan, function (u) {
                    return u.vendor == data;
                });
            }
        },
        created() {
            this.LoadData();
            Fire.$on('reloadData', () => {
                this.LoadData();
            });
        },
        mounted() {
            document.title = 'Annisa Rizki - Kendaraan';
            this.dt = $("#vendor-kendaraan").DataTable({
                "responsive": false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                }],
                "scrollX": true,
            });
        },
        watch: {
            vendor_kendaraan(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#vendor-kendaraan").DataTable({
                        "responsive": false,
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excel',
                        }],
                        "scrollX": true,
                    });
                })
            },
        }
    }

</script>
