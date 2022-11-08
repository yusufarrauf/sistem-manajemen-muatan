<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Ubah Data Perawatan</h1>
                        <h3 class="bg-secondary rounded">Nomor Polisi: <strong
                                class="text-success">{{ $route.params.nopol }}</strong> | Tanggal: <strong
                                class="text-success">{{ $route.params.tanggal | dateReformat }}</strong></h3>
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
                                    <input v-model="form.tanggal" type="date" name="tanggal"
                                        class="form-control text-center font-weight-bold" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Nomor Polisi</label>
                                <div class="col-4">
                                    <input v-model="form.nopol" type="text" name="nopol"
                                        class="form-control text-center font-weight-bold" disabled>
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
                                            <button type="button" @click="deleteData(index)"
                                                class="btn btn-outline-danger btn-block">
                                                <i class="fas fa-trash"></i></button>
                                        </div>
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    tanggal: '',
                    nopol: '',
                    sparepart: [{
                        id: '',
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
                axios.get('/api/perawatan/' + this.$route.params.nopol + '/' + this.$route.params.tanggal).then(({
                    data
                }) => {
                    this.form.fill(data[0]);
                });
            },
            total(index) {
                this.form.sparepart[index].total = this.form.sparepart[index].harga * this.form.sparepart[index].satuan;
            },
            deleteData(index) {
                 Swal.fire({
                    title: 'Anda Yakin Ingin Menghapus Data Sparepart "' + this.form.sparepart[index].nama + '" ?',
                    text: "Data Yang Sudah Dihapus Tidak Dapat Kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/perawatan/' + this.form.sparepart[index].id).then(() => {
                            Swal.fire(
                                'Terhapus!',
                                'Data Sparepart "' + this.form.sparepart[index].nama + '" Telah Dihapus.',
                                'success',
                            );
                            this.form.sparepart.splice(index, 1);
                            if (this.form.sparepart.length == 0){
                                window.location.replace("/laporan/perawatan");
                            }
                        }).catch((response) => {
                            Swal.fire("Error!!", "Terjadi Kesalahan Saat Menghapus Data : "+ response, "warning");
                        });
                    }
                })

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
                        window.location.replace("/laporan/perawatan");
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!!'
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
