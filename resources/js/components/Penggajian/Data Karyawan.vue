<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Data Karyawan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Penggajian</li>
                            <li class="breadcrumb-item active">Data Karyawan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table id="karyawan" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th class="text-center" scope="col">Tempat, Tanggal Lahir</th>
                                    <th class="text-center" scope="col">Jenis Kelamin</th>
                                    <th scope="col" class="none">Alamat</th>
                                    <th class="text-center" scope="col">Nomor HP</th>
                                    <th class="text-center" scope="col">Jabatan</th>
                                    <th width="150px" scope="col" class="text-center">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(da, index) in karyawan" :key="da.id">
                                    <td class="font-weight-bold align-middle">{{ index+1 }}</td>
                                    <td class="font-weight-bold align-middle">{{ da.nama }}</td>
                                    <td class="text-center align-middle">{{ da.tempat_lahir }}, {{ da.tanggal_lahir | dateReformat }}</td>
                                    <td class="text-center align-middle">{{ da.jenis_kelamin }}</td>
                                    <td class="align-middle">{{ da.alamat }}</td>
                                    <td class="text-center align-middle">{{ da.handphone }}</td>
                                    <td class="text-center align-middle">{{ da.jabatan }}</td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-primary font-weight-bold" @click="editData(da)"><i class="fa fa-edit"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger font-weight-bold" @click="deleteData(da)"><i class="fa fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2 mt-3">
                        <button type="button" @click="insertData()" class="btn btn-success btn-lg btn-block">
                            <i class="fas fa-plus"></i>
                            Tambah Data Karyawan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Data Karyawan</h4>
                        <h4 v-show="!editmode" class="modal-title">Tambah Data Karyawan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? edit() : insert()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nama Lengkap</label>
                                <div class="col">
                                    <input v-model="form.nama" type="text" name="nama" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('nama') }" placeholder="Masukan Nama Lengkap">
                                    <has-error :form="form" field="nama"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Tempat Lahir</label>
                                <div class="col">
                                    <input v-model="form.tempat_lahir" type="text" name="tempat_lahir" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('tempat_lahir') }" placeholder="Masukan Tempat Lahir">
                                    <has-error :form="form" field="tempat_lahir"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Tanggal Lahir</label>
                                <div class="col">
                                    <input v-model="form.tanggal_lahir" type="date" name="tanggal_lahir" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('tanggal_lahir') }" placeholder="Masukan Tanggal Lahir">
                                    <has-error :form="form" field="tanggal_lahir"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Jenis Kelamin</label>
                                <div class="col">
                                    <select v-model="form.jenis_kelamin" id="jenis_kelamin" name="jenis_kelamin" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('jenis_kelamin') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option value="LAKI-LAKI">LAKI-LAKI</option>
                                        <option value="PEREMPUAN">PEREMPUAN</option>
                                    </select>
                                    <has-error :form="form" field="jenis_kelamin"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Alamat</label>
                                <div class="col">
                                    <textarea rows="4" v-model="form.alamat" type="date" name="alamat" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('alamat') }" placeholder="Masukan Alamat"></textarea>
                                    <has-error :form="form" field="alamat"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nomor HP</label>
                                <div class="col">
                                    <input v-model="form.handphone" type="text" name="handphone" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('handphone') }" placeholder="Masukan Nomor HP">
                                    <has-error :form="form" field="handphone"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Jabatan</label>
                                <div class="col">
                                    <select v-model="form.jabatan" id="jabatan" name="jabatan" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('jabatan') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option v-for="da in data_gaji" :value="da.nama" :key="da.id">{{ da.nama }}</option>
                                    </select>
                                    <has-error :form="form" field="jabatan"></has-error>
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
                data_gaji: '',
                karyawan: {},
                form: new Form({
                    id: '',
                    nama: '',
                    tempat_lahir: '',
                    tanggal_lahir: '',
                    jenis_kelamin: '',
                    alamat: '',
                    handphone: '',
                    jabatan: '',

                })
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/karyawan').then(({
                    data
                }) => (this.karyawan = data))
                axios.get('/api/data-gaji').then(({
                    data
                }) => (this.data_gaji = data))
            },
            insertData() {
                this.editmode = false;
                this.form.reset();
                $('#Modal').modal('show')
            },
            insert() {
                this.$Progress.start();
                this.form.post('/api/karyawan')
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Karyawan Berhasil Ditambahkan'
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
                this.form.put('/api/karyawan/' + this.form.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Karyawan Berhasil Diubah'
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
                    title: 'Anda Yakin Ingin Menghapus Data Karyawan "' + da.nama + '" ?',
                    // text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/karyawan/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Data Karyawan "' + da.nama + '" Berhasil Dihapus.',
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
            document.title = 'Annisa Rizki - Data Karyawan';
            this.dt = $("#karyawan").DataTable({
                "responsive": false,
                        "scrollX": true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
                }, ]
            });
        },
        watch: {
            karyawan(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#karyawan").DataTable({
                        "responsive": false,
                        "scrollX": true,
                        dom: 'Bfrtip',
                buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
                }, ]
                    });
                })
            }
        }
    }

</script>
