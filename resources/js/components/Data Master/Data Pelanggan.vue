<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Data Pelanggan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Data Master</li>
                            <li class="breadcrumb-item active">Data Pelanggan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table id="data-pelanggan" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Nama Perusahaan</th>
                                    <th width="180px" scope="col" class="text-center">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="da in pelanggan" :key="da.id">
                                    <td class="font-weight-bold text-center align-middle">{{ da.nama }}</td>
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
                            Tambah Data Pelanggan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Data Pelanggan</h4>
                        <h4 v-show="!editmode" class="modal-title">Tambah Data Pelanggan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? edit() : insert()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nama Perusahaan</label>
                                <div class="col">
                                    <input v-model="form.nama" type="text" name="nama" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('nama') }"
                                        placeholder="Masukan Nama Perusahaan">
                                    <has-error :form="form" field="nama"></has-error>
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
                kota: {},
                pelanggan: {},
                form: new Form({
                    id: '',
                    nama: '',
                })
            }
        },
        methods: {
            LoadData() {
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
                this.form.post('/api/data-pelanggan')
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Pelanggan Berhasil Ditambahkan'
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
                this.form.put('/api/data-pelanggan/' + this.form.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Pelanggan Berhasil Diubah'
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
                    title: 'Anda Yakin Ingin Menghapus Data Pelanggan "' + da.nama + '" ?',
                    // text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/data-pelanggan/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Data Pelanggan "' + da.nama + '" Berhasil Dihapus.',
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
            document.title = 'Annisa Rizki - Data Pelanggan';
            this.dt = $("#data-pelanggan").DataTable({
                "responsive": false,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0]
                    }
                }, ]
            });
        },
        watch: {
            pelanggan(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#data-pelanggan").DataTable({
                        "responsive": false,
                        "scrollX": true,
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'print',
                            exportOptions: {
                                columns: [0]
                            }
                        }, ]
                    });
                })
            }
        }
    }

</script>
