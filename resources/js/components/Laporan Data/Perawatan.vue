<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Data Perawatan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Laporan</li>
                            <li class="breadcrumb-item active">Data Perawatan</li>
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
                                <label class="col-md-2 col-form-label text-md-left">Nomor Polisi</label>
                                <div class="col-md-3">
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
                                <label class="col-md-2 col-form-label text-md-left">Bulan </label>
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
                                <label class="col-md-2 col-form-label text-md-left">Tahun </label>
                                <div class="col-md-3">
                                    <select v-model="form.tahun" id="tahun" name="tahun"
                                        class="form-control text-center" data-live-search="true">
                                        <option v-for="n in 51" :value="1999 + n" :key="n">{{ 1999 + n }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-2"></label>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary float-right ml-2"><i
                                            class="fas fa-search"></i> Cari Data</button>
                                    <button @click="reset()" type="button" class="btn btn-danger float-right ml-2"><i
                                            class="fas fa-undo"></i>
                                        Reset</button>
                                    <button @click="print(form.bulan, form.tahun, form.nopol)" type="button"
                                        class="btn btn-secondary float-right"><i class="fas fa-print"></i>
                                        Print</button>
                                </div>
                            </div>
                        </form>

                        <table id="perawatan" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col">Biaya (Sparepart)</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Harga</th>
                                    <th scope="col" class="text-center">Jumlah</th>
                                    <th scope="col" class="text-center">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sp, key) in perawatan" :key="sp.id">
                                    <td class="text-center font-weight-bold align-middle">
                                        {{ sp.tanggal | dateReformat }}</td>
                                    <td class="font-weight-bold">{{ sp.sparepart }}</td>
                                    <td class="text-center font-weight-bold">{{ sp.satuan }}</td>
                                    <td class="text-center font-weight-bold">Rp. {{ sp.harga | currency }}</td>
                                    <td class="font-weight-bold text-right">Rp. {{ sp.total | currency }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary font-weight-bold"
                                            @click="editData(sp)"><i class="fa fa-edit"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger font-weight-bold"
                                            @click="deleteData(sp)"><i class="fa fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                                <tr
                                    v-if="perawatan.length != 0 || Object.keys(perawatan).length != 0 || perawatan != ''">
                                    <td></td>
                                    <td class="font-weight-bold">Biaya Perawatan Mobil</td>
                                    <td></td>
                                    <td></td>
                                    <td class="font-weight-bold text-right">Rp. 1.000.000</td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-bold text-right text-danger">Jumlah</th>
                                    <th class="text-bold text-right text-danger"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
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
        <div class="modal fade" id="EditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Data Perawatan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form @submit.prevent="edit()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Tanggal</label>
                                <div class="col">
                                    <input v-model="sparepart.tanggal" type="date" name="tanggal"
                                        class="form-control text-center font-weight-bold" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Biaya (Sparepart)</label>
                                <div class="col">
                                    <input v-model="sparepart.sparepart" type="text" name="sparepart"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Harga</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="sparepart.harga"
                                        class="form-control">
                                    </vue-numeric>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Satuan</label>
                                <div class="col">
                                    <input min="1" @change="total()" v-model="sparepart.satuan" type="number"
                                        class="form-control" placeholder="Satuan" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-left">Total</label>
                                <div class="col">
                                    <vue-numeric currency="Rp." separator="." v-model="sparepart.total"
                                        class="form-control" disabled>
                                    </vue-numeric>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button :disabled="form.busy" class="btn btn-md btn-success float-right mr-2"
                                type="submit">Update</button>
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
                kendaraan: {},
                perawatan: '',
                form: new Form({
                    nopol: '',
                    bulan: {},
                    tahun: {},
                }),
                sparepart: new Form({
                    id: '',
                    tanggal: '',
                    sparepart: '',
                    harga: 0,
                    satuan: 0,
                    total: 0
                }),
            }
        },
        methods: {
            LoadData() {
                axios.get('/api/data-kendaraan').then(({
                    data
                }) => (this.kendaraan = data))
                this.form.bulan = new Date().getMonth();
                this.form.tahun = new Date().getFullYear();
            },
            openKendaraan() {
                $('#Modal').modal('show')
            },
            getKendaraan(index) {
                let data = this.ac.row(index).data();
                this.form.nopol = data[0];
                $('#Modal').modal('hide')
            },
            filter() {
                this.form.post('/api/filterLaporanPerawatan').then(({
                    data
                }) => (this.perawatan = data))
            },
            reset() {
                this.form.reset();
                this.form.bulan = new Date().getMonth();
                this.form.tahun = new Date().getFullYear();
                this.perawatan = [];
            },
            total() {
                this.sparepart.total = this.sparepart.harga * this.sparepart.satuan;
            },
            editData(da) {
                this.sparepart.fill(da);
                $('#EditModal').modal('show');
            },
            edit() {
                this.$Progress.start();
                this.sparepart.put('/api/perawatan/' + this.sparepart.id)
                    .then(() => {
                        Fire.$emit('reloadData');
                        $('#DataModal').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Berhasil Diubah'
                        });
                        this.$Progress.finish();
                        this.sparepart.reset();
                        $('#EditModal').modal('hide');
                        this.filter();
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
                    title: 'Anda Yakin Ingin Menghapus Data Sparepart "' + da.sparepart + '" ?',
                    text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/perawatan/' + da.id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Data Sparepart "' + da.sparepart + '" Telah Dihapus.',
                                'success',
                            );
                            this.filter();
                        }).catch((response) => {
                            Swal.fire("Error!!", "Terjadi Kesalahan Saat Menghapus Data : " + response,
                                "warning");
                        });
                    }
                })
            },
            print(bulan, tahun, nopol) {
                if (nopol == '') {
                    Toast.fire({
                        icon: 'error',
                        title: 'Silahkan Pilih Nomor Polisi Terlebih Dahulu!!'
                    });
                    this.$Progress.fail();
                } else {
                    nopol = nopol.split(' ');
                    let newnopol = nopol[0] + nopol[1] + nopol[2];
                    let a = window.open('/cetak/perawatan/' + (bulan + 1) + '/' + tahun + '/' + newnopol, '_blank');
                    a.open();
                    setTimeout(function () {
                        a.close();
                    }, 3000);
                }
            }
        },
        created() {
            this.LoadData();
            Fire.$on('reloadData', () => {
                this.LoadData();
            });
        },
        mounted() {
            document.title = 'Annisa Rizki - Laporan Data Perawatan';
            this.dt = $("#perawatan").DataTable({
                "responsive": true,
                'rowsGroup': [0],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                }],
                order: [],
            });
            this.ac = $("#kendaraan").DataTable({
                "responsive": true,
            });
            $(document).on('destroy.dt', function (e, settings) {
                var api = new $.fn.dataTable.Api(settings);
                api.off('order.dt');
                api.off('preDraw.dt');
                api.off('column-visibility.dt');
                api.off('search.dt');
                api.off('page.dt');
                api.off('length.dt');
                api.off('xhr.dt');
            });
        },
        watch: {
            perawatan(val) {
                this.dt.destroy();
                this.$nextTick(() => {
                    this.dt = $("#perawatan").DataTable({
                        "responsive": true,
                        'rowsGroup': [0],
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excel',
                        }],
                        order: [[0, 'desc']],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(),
                                data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function (i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\Rp. ,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column(4)
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Update footer
                            $(api.column(4).footer()).html(
                                "Rp. " + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                            );
                        }
                    });
                })
            },
            kendaraan(val) {
                this.ac.destroy();
                this.$nextTick(() => {
                    this.ac = $("#kendaraan").DataTable({
                        "responsive": true,
                    });
                })
            },
        }
    }

</script>
