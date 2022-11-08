<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Rekapitulasi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Laporan</li>
                            <li class="breadcrumb-item active">Rekapitulasi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <form @submit.prevent="filterData()" @keydown="form.onKeydown($event)">
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-left">Bulan </label>
                                <div class="col-md-3">
                                    <select v-model="filter.bulan" id="bulan" name="bulan"
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
                                <label for="name" class="col-md-2 col-form-label text-md-left">Tahun </label>
                                <div class="col-md-3">
                                    <select v-model="filter.tahun" id="tahun" name="tahun"
                                        class="form-control text-center" data-live-search="true">
                                        <option v-for="n in 51" :value="1999 + n" :key="n">{{ 1999 + n }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-2">
                                    <button type="submit" class="btn btn-primary float-right ml-2"><i
                                            class="fas fa-search"></i> Cari Data</button>
                                    <button @click="reset()" type="button" class="btn btn-danger float-right"><i
                                            class="fas fa-undo"></i>
                                        Reset</button>
                                </div>
                            </div>
                        </form>
                        <div class="card">
                            <h3 class="card-header">DATA REKAP</h3>
                            <div class="card-body row justify-content-center">
                                <div class="col-12">
                                    <table id="rekapitulasi"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kode Rekap</th>
                                                <th scope="col">Inisial Rekap</th>
                                                <th scope="col" class="text-center">Invoice Ke-</th>
                                                <th scope="col">Jenis Rekap</th>
                                                <th scope="col" class="text-center">Range Rekap</th>
                                                <th scope="col" class="text-center">Tanggal Rekap</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="da in rekapitulasi" :key="da.id">
                                                <td class="font-weight-bold align-middle">{{ da.kode }}</td>
                                                <td class="align-middle font-weight-bold">{{ da.nama }}</td>
                                                <td class="text-center font-weight-bold align-middle">{{ da.ke }}</td>
                                                <td class="font-weight-bold align-middle">
                                                    <div v-if="da.jenis.split(';')[0] == 1">* <span
                                                            class="text-danger">HAOHAN
                                                            CEMENT</span></div>
                                                    <div v-if="da.jenis.split(';')[1] == 1">* <span
                                                            class="text-danger">KRNG</span></div>
                                                    <div v-if="da.jenis.split(';')[2] == 1">* <span
                                                            class="text-danger">WANGDA</span></div>
                                                    <div v-if="da.jenis.split(';')[3] == 1">* <span
                                                            class="text-danger">WSD</span></div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="font-weight-bold">{{ explode(da.range_from) }}</span>
                                                    s/d
                                                    <span
                                                        class="font-weight-bold">{{ da.range_to | dateReformat }}</span>
                                                </td>
                                                <td class="text-center align-middle font-weight-bold">
                                                    {{ da.created_at | dateReformat }}</td>
                                                <td class="text-center align-middle">
                                                    <div class="mb-1"><button @click="exportExcel(da)" type="button"
                                                            class="btn btn-primary btn-block text-left font-weight-bold"><i
                                                                class="fas fa-file-export"></i> EXCEL</button>
                                                    </div>
                                                    <div class="mb-1"><button @click="printInvoice(da)" type="button"
                                                            class="btn btn-primary btn-block text-left font-weight-bold"><i
                                                                class="fas fa-print"></i> INVOICE</button>
                                                    </div>
                                                    <div class="mb-1">
                                                        <button @click="printAngkutan(da)" type="button"
                                                            class="btn btn-primary btn-block text-left font-weight-bold"><i
                                                                class="fas fa-print"></i> ANGKUTAN</button>
                                                    </div>
                                                    <button @click="editData(da)" type="button"
                                                        class="btn btn-success"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button @click="deleteData(da)" type="button"
                                                        class="btn btn-danger ml-2"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2 mt-3">
                                    <button type="button" @click="insertData()"
                                        class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-plus"></i>
                                        Buat Data Rekap Baru</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-show="editmode" class="modal-title">Ubah Data Rekap {{ form.kode }}</h4>
                        <h4 v-show="!editmode" class="modal-title">Buat Rekap Baru</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="editmode ? edit() : insert()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Inisial Rekap</label>
                                <div class="col">
                                    <input v-model="form.nama" type="text" name="nama" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('nama') }" placeholder="Masukan Nama">
                                    <has-error :form="form" field="nama"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Invoice Ke-</label>
                                <div class="col">
                                    <input v-model="form.ke" min="1" type="number" name="ke"
                                        class="form-control text-center"
                                        :class="{ 'is-invalid': form.errors.has('ke') }">
                                    <has-error :form="form" field="ke"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Jenis</label>
                                <div class="col align-self-center">
                                    <div class="form-check">
                                        <input @change="selectAll()" class="form-check-input" type="checkbox"
                                            id="select_all" :class="{ 'is-invalid': form.errors.has('jenis') }">
                                        <label class="font-weight-bold form-check-label">PILIH SEMUA</label>
                                    </div>
                                    <div class="form-check">
                                        <input @change="selectPartial()" v-model="form.jenis.haohan_cement"
                                            class="form-check-input" type="checkbox" id="haohan_cement"
                                            :class="{ 'is-invalid': form.errors.has('jenis') }">
                                        <label class="font-weight-bold form-check-label">HAOHAN CEMENT</label>
                                    </div>
                                    <div class="form-check">
                                        <input @change="selectPartial()" v-model="form.jenis.krng"
                                            class="form-check-input" type="checkbox" id="krng"
                                            :class="{ 'is-invalid': form.errors.has('jenis') }">
                                        <label class="font-weight-bold form-check-label">KRNG</label>
                                    </div>
                                    <div class="form-check">
                                        <input @change="selectPartial()" v-model="form.jenis.wangda"
                                            class="form-check-input" type="checkbox" id="wangda"
                                            :class="{ 'is-invalid': form.errors.has('jenis') }">
                                        <label class="font-weight-bold form-check-label">WANGDA</label>
                                    </div>
                                    <div class="form-check">
                                        <input @change="selectPartial()" v-model="form.jenis.wsd"
                                            class="form-check-input" type="checkbox" id="wsd"
                                            :class="{ 'is-invalid': form.errors.has('jenis') }">
                                        <label class="font-weight-bold form-check-label">WSD</label>
                                    </div>
                                    <has-error style="display: block; font-weight: bold" :form="form" field="jenis">
                                    </has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Dari</label>
                                <div class="col">
                                    <input v-model="form.range_from" type="date" name="range_from"
                                        :class="{ 'is-invalid': form.errors.has('range_from') }"
                                        class="form-control text-center font-weight-bold">
                                    <has-error :form="form" field="range_from"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-left">Sampai</label>
                                <div class="col">
                                    <input v-model="form.range_to" type="date" name="range_to"
                                        :class="{ 'is-invalid': form.errors.has('range_to') }"
                                        class="form-control text-center font-weight-bold">
                                    <has-error :form="form" field="range_to"></has-error>
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
                rekapitulasi: {},
                filter: new Form({
                    bulan: '',
                    tahun: '',
                }),
                form: new Form({
                    kode: '',
                    nama: '',
                    ke: 1,
                    jenis: {
                        haohan_cement: false,
                        krng: false,
                        wangda: false,
                        wsd: false
                    },
                    range_from: '',
                    range_to: '',
                }),
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/rekapitulasi').then(({
                    data
                }) => (this.rekapitulasi = data))
                this.filter.bulan = new Date().getMonth();
                this.filter.tahun = new Date().getFullYear();
            },
            filterData() {
                this.filter.post('/api/filterLaporanRekapitulasi').then(({
                    data
                }) => (this.rekapitulasi = data))
            },
            reset() {
                this.LoadData();
                this.filter.reset();
            },
            explode(date) {
                let numb = date.split("-");
                return numb[2];
            },
            selectAll() {
                let select_all = document.getElementById("select_all");
                if (select_all.checked || select_all.indeterminate) {
                    this.form.jenis.haohan_cement = true;
                    this.form.jenis.krng = true;
                    this.form.jenis.wangda = true;
                    this.form.jenis.wsd = true;
                } else {
                    this.form.jenis.haohan_cement = false;
                    this.form.jenis.krng = false;
                    this.form.jenis.wangda = false;
                    this.form.jenis.wsd = false;
                }
            },
            selectPartial() {
                let count = 0;
                let select_all = document.getElementById("select_all");
                Object.values(this.form.jenis).forEach(val => {
                    if (val == true) {
                        count += 1;
                    }
                });
                if (count == 4) {
                    select_all.indeterminate = false;
                    select_all.checked = true;
                } else if (count > 0 && count < 4) {
                    select_all.indeterminate = true;
                } else {
                    select_all.indeterminate = false;
                    select_all.checked = false;
                }
            },
            insertData() {
                this.editmode = false;
                this.form.reset();
                $('#Modal').modal('show')
            },
            editData(da) {
                let count = 0;
                this.editmode = true;
                this.form.fill(da);
                let jenis = da.jenis.split(";");
                this.form.jenis = {
                    haohan_cement: Boolean(Number(jenis[0])),
                    krng: Boolean(Number(jenis[1])),
                    wangda: Boolean(Number(jenis[2])),
                    wsd: Boolean(Number(jenis[3]))
                }
                this.selectPartial();
                $('#Modal').modal('show');
            },
            insert() {
                this.$Progress.start();
                this.form.post('/api/rekapitulasi')
                    .then(() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Rekap Berhasil Dibuat'
                        });
                        this.$Progress.finish();
                        this.form.reset();
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                    })
                    .catch((result) => {
                        Toast.fire({
                            icon: 'error',
                            title: result.response.data.message,
                        });
                        this.$Progress.fail();
                    });
            },
            edit() {
                this.$Progress.start();
                this.form.put('/api/rekapitulasi/' + this.form.kode)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#Modal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Rekap Berhasil Diubah'
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
            printInvoice(da) {
                let a = window.open('/cetak/rekap/invoice/' + da.kode, "_blank");
                a.open();
                setTimeout(function () {
                    a.close();
                }, 3000);
            },
            exportExcel(da) {
                let a = window.open('/excel/' + da.kode, "_blank");
                a.open();
            },
            printAngkutan(da) {
                let a = window.open('/cetak/rekap/angkutan/' + da.kode, "_blank");
                a.open();
                setTimeout(function () {
                    a.close();
                }, 3000);
            },
            deleteData(da) {
                Swal.fire({
                    title: 'Anda Yakin Ingin Menghapus Data Rekap "' + da.kode + '" ?',
                    text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/rekapitulasi/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Data Rekap "' + da.kode + '" Telah Dihapus.',
                                'success',
                            );
                            Fire.$emit('reloadData');

                        }).catch((response) => {
                            Swal.fire("Error!!", "Terjadi Kesalahan Saat Menghapus Data : " + response,
                                "warning");
                        });
                    }
                })
            }
        },
        created() {
            this.LoadData();
            Fire.$on('reloadData', () => {
                this.LoadData();
            });
        },
        mounted() {
            document.title = 'Annisa Rizki - Laporan Rekapitulasi';
            this.dt = $("#rekapitulasi").DataTable({
                "responsive": false,
                        "scrollX": true,
            });
        },
        watch: {
            rekapitulasi(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#rekapitulasi").DataTable({
                        "responsive": false,
                        "scrollX": true,
                    });
                })
            },
        }
    }

</script>
