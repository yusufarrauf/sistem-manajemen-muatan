<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>403: FORBIDDEN</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-danger">403</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-danger"></i>FORBIDDEN</h3>

                    <p>
                         Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini!!.
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        mounted() {
            document.title = 'Annisa Rizki - 403 Forbidden';
        },
    }

</script>
