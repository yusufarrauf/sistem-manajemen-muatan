<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Data Gaji</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Penggajian</li>
                            <li class="breadcrumb-item active">Data Gaji</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table id="data-gaji" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th class="text-center" scope="col">Jabatan</th>
                                    <th class="text-center" scope="col">Gaji Pokok</th>
                                    <th scope="col">Biaya Lain</th>
                                    <th class="text-center" scope="col">Total Gaji</th>
                                    <th width="100px" scope="col" class="text-center">Status</th>
                                    <th width="180px" scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="da in data_penggajian" :key="da.id">
                                    <td class="font-weight-bold align-middle">{{ da.nama }}</td>
                                    <td class="text-center font-weight-bold align-middle">{{ da.jabatan }}</td>
                                    <td v-if="da.status == 1" class="text-center align-middle">Rp.
                                        {{ da.gaji_pokok | currency}}</td>
                                    <td v-else class="text-center align-middle">-</td>
                                    <td v-if="da.status == 1" class="align-middle font-weight-bold">
                                        <div v-for="da in dataBiayaLain(da)" :key="da">{{ da.split(':')[0] }} : Rp.
                                            {{ da.split(':')[1] | currency }}</div>
                                    </td>
                                    <td v-else class="text-center align-middle">-</td>
                                    <td v-if="da.status == 1" class="text-center align-middle">Rp.
                                        {{ da.total_gaji | currency}}</td>
                                    <td v-else class="text-center align-middle">-</td>
                                    <td v-if="da.status == 0"
                                        class="text-center bg-danger font-weight-bold align-middle">Gaji Belum Diinput
                                    </td>
                                    <td v-else class="text-center bg-success font-weight-bold align-middle">Gaji Sudah
                                        Diinput
                                    </td>
                                    <td class="text-center align-middle">
                                        <button v-if="da.status == 0" type="button" @click="insertData(da)"
                                            class="btn btn-danger btn-block font-weight-bold">
                                            <i class="fas fa-file-import"></i>
                                            Input Gaji</button>
                                        <button v-if="da.status == 1" type="button" @click="editData(da)"
                                            class="btn btn-secondary btn-block font-weight-bold">
                                            <i class="fas fa-edit"></i>
                                            Ubah Data Gaji</button>
                                        <button v-if="da.status == 1" type="button" @click="printSlip(da)"
                                            class="btn btn-primary btn-block font-weight-bold">
                                            <i class="fas fa-print"></i>
                                            Cetak Slip Gaji</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Data Gaji {{ form.nama }}</h4>
                        <h4 v-show="!editmode" class="modal-title">Input Gaji {{ form.nama }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? edit() : insert()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Nama Karyawan</label>
                                <div class="col">
                                    <input v-model="form.nama" type="text" name="nama" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Jabatan</label>
                                <div class="col">
                                    <input v-model="form.jabatan" type="text" name="nama" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Gaji Pokok</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="form.gaji_pokok"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="text-center font-weight-bold mb-1">Biaya Lain</div>
                            <div v-for="(da, index) in form.biaya_lain" class="form-group row" :key="index">
                                <div class="col">
                                    <div class="input-group">
                                        <input v-model="form.biaya_lain[index].nama" type="text" name="nama"
                                            class="form-control" placeholder="Masukan Nama Biaya" required>
                                        <vue-numeric v-on:keyup.native="calculate" currency="Rp." separator="."
                                            v-model="form.biaya_lain[index].jumlah" class="form-control" required>
                                        </vue-numeric>
                                        <button type="button" @click="deleteBiayaLain(index)"
                                            class="btn btn-danger ml-1">
                                            <i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" @click="addBiayaLain()" class="btn btn-success font-weight-bold">
                                    <i class="fas fa-plus"></i> Tambah Biaya Lain</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span style="left: 1em" class="float-left position-absolute font-weight-bold">Total Gaji :
                                Rp. {{ form.total_gaji | currency}}</span>
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
                data_penggajian: {},
                form: new Form({
                    id: '',
                    id_karyawan: '',
                    nama: '',
                    jabatan: '',
                    gaji_pokok: 0,
                    biaya_lain: [],
                    total_gaji: 0
                })
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/data-penggajian').then(({
                    data
                }) => (this.data_penggajian = data))
            },
            addBiayaLain() {
                let data = {};
                data.nama = "";
                data.jumlah = 0;
                this.form.biaya_lain.push(data);
            },
            calculate: function (evt) {
                let total = 0;
                total += this.form.gaji_pokok;
                for (let i = 0; i < this.form.biaya_lain.length; i++) {
                    total += parseInt(this.form.biaya_lain[i].jumlah);
                }
                this.form.total_gaji = total;
            },
            dataBiayaLain(da) {
                let data = da.biaya_lain.split(';');
                data.splice(data.length - 1, 1);
                return data;
            },
            deleteBiayaLain(index) {
                this.form.biaya_lain.splice(index, 1);
                let total = 0;
                total += this.form.gaji_pokok;
                for (let i = 0; i < this.form.biaya_lain.length; i++) {
                    total += parseInt(this.form.biaya_lain[i].jumlah);
                }
                this.form.total_gaji = total;
            },
            insertData(da) {
                this.editmode = false;
                this.form.reset();
                this.form.nama = da.nama;
                this.form.jabatan = da.jabatan;
                this.form.gaji_pokok = da.gaji_pokok;
                this.form.id_karyawan = da.id_karyawan;
                let total = 0;
                total += this.form.gaji_pokok;
                for (let i = 0; i < this.form.biaya_lain.length; i++) {
                    total += parseInt(this.form.biaya_lain[i].jumlah);
                }
                this.form.total_gaji = total;
                $('#Modal').modal('show')
            },
            insert() {
                this.$Progress.start();
                this.form.post('/api/input-penggajian')
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Informasi Gaji Berhasil Disimpan'
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
            printSlip(da) {
                let a = window.open('/cetak/slip-gaji/' + da.id_penggajian, '_blank');
                a.open();
                setTimeout(function () {
                    a.close();
                }, 2000);
            },
            editData(da) {
                this.editmode = true;
                this.form.nama = da.nama;
                this.form.jabatan = da.jabatan;
                this.form.gaji_pokok = da.gaji_pokok;
                this.form.id_karyawan = da.id_karyawan;
                this.form.id = da.id_penggajian;
                let biaya = da.biaya_lain.split(';');
                for (let i = 0; i < biaya.length - 1; i++) {
                    let detailBiaya = biaya[i].split(':');
                    let data = {};
                    data.nama = detailBiaya[0];
                    data.jumlah = detailBiaya[1];
                    this.form.biaya_lain.push(data);
                }
                let total = 0;
                total += this.form.gaji_pokok;
                for (let i = 0; i < this.form.biaya_lain.length; i++) {
                    total += parseInt(this.form.biaya_lain[i].jumlah);
                }
                this.form.total_gaji = total;
                $('#Modal').modal('show');
            },
            edit() {
                this.$Progress.start();
                this.form.put('/api/edit-penggajian/' + this.form.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Informasi Gaji Berhasil Diubah'
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

        },
        created() {
            this.LoadData();
            Fire.$on('reloadData', () => {
                this.LoadData();
            });
        },
        mounted() {
            document.title = 'Annisa Rizki - Input Penggajian';
            this.dt = $("#data-gaji").DataTable({
                "responsive": false,
                "scrollX": true,
            });
        },
        watch: {
            data_penggajian(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#data-gaji").DataTable({
                        "responsive": false,
                        "scrollX": true,
                    });
                })
            }
        }
    }

</script>
