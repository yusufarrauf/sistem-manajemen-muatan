<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">User Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Data Master</li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table id="user_maintenance" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col" class="text-center">Username</th>
                                    <th scope="col" class="text-center">Level</th>
                                    <th width="180px" scope="col" class="text-center">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="da in userFilter" :key="da.id">
                                    <td class="font-weight-bold align-middle">{{ da.name }}</td>
                                    <td class="text-center align-middle">{{ da.username }}</td>
                                    <td class="text-center font-weight-bold align-middle">{{ da.level }}</td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-primary font-weight-bold" @click="editUser(da)"><i class="fa fa-edit"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger font-weight-bold" @click="deleteUser(da)"><i class="fa fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2 mt-3">
                        <button type="button" @click="insertUser()" class="btn btn-success btn-lg btn-block">
                            <i class="fas fa-plus"></i>
                            Tambah Data User</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="userModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Data User</h4>
                        <h4 v-show="!editmode" class="modal-title">Tambah Data User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? edit() : insert()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nama</label>
                                <div class="col">
                                    <input v-model="form.name" type="text" name="name" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('name') }"
                                        placeholder="Masukan Nama">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Username</label>
                                <div class="col">
                                    <input v-model="form.username" type="text" name="username" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('username') }"
                                        placeholder="Username Login">
                                    <has-error :form="form" field="username"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Level</label>
                                <div class="col">
                                    <select v-model="form.level" id="level" name="level" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('level') }">
                                        <option value hidden selected>== PILIH ==</option>
                                        <option value="Super Admin">Super Admin</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Keuangan">Keuangan</option>
                                    </select>
                                    <has-error :form="form" field="level"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Password</label>
                                <div class="col">
                                    <input v-model="form.password" type="password" name="password" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('password') }"
                                        placeholder="Password Login">
                                    <has-error :form="form" field="password"></has-error>
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
                user: {},
                form: new Form({
                    id: '',
                    name: '',
                    username: '',
                    level: '',
                    password: ''
                })
            }
        },
        computed: {
            userFilter: function(){
                return _.pickBy(this.user, function (u) {
                    return u.level != 'GUEST';
                });
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/users').then(({
                    data
                }) => (this.user = data))
            },
            insertUser(){
                this.editmode = false;
                this.form.reset();
                $('#userModal').modal('show')
            },
            insert(){
                this.$Progress.start();
                this.form.post('/api/users')
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#userModal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'User Berhasil Ditambahkan'
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
            editUser(da){
                this.editmode = true;
                this.form.fill(da);
                $('#userModal').modal('show');
            },
            edit(){
                this.$Progress.start();
                this.form.put('/api/users/' + this.form.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#userModal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'User Berhasil Diubah'
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
            deleteUser(da){
                Swal.fire({
                    title: 'Anda Yakin Ingin Menghapus User "' + da.name + '" ?',
                    // text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/users/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'User "' + da.name + '" Berhasil Dihapus.',
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
            document.title = 'Annisa Rizki - User Management';
            this.dt = $("#user_maintenance").DataTable({
                "responsive": false,
                        "scrollX": true,
                        dom: 'Bfrtip',
                        buttons: [
                            'print'
                        ]
            });
        },
        watch: {
            userFilter(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#user_maintenance").DataTable({
                        "responsive": false,
                        "scrollX": true,
                        dom: 'Bfrtip',
                        buttons: [
                            'print'
                        ]
                    });
                })
            }
        }
    }

</script>
