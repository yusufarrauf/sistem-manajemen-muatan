<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAngkutansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angkutans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nopol', 25);
            $table->date('tanggal');
            $table->string('transportir', 15);
            $table->string('jenis_angkutan', 20); // Material
            $table->string('asal_pemuatan', 30); // asal
            $table->string('no_surat', 100);
            $table->string('tujuan', 50); // tujuan
            $table->string('kota', 50);
            $table->decimal('tonase');
            $table->bigInteger('ongkos_angkut');
            $table->bigInteger('supir_perton');
            $table->decimal('max_tonase');
            $table->bigInteger('ferry');
            $table->bigInteger('bonus_supir');
            $table->decimal('ton_bonus');
            $table->bigInteger('total_uj');
            $table->bigInteger('panjar');
            $table->bigInteger('sisa_uj');
            $table->tinyInteger('isFiltered')->default(0);
            $table->string('status', 15);
            $table->timestamps();
        });
        Schema::table('angkutans', function (Blueprint $table) {
            $table->foreign('nopol')->references('nopol')->on('data_kendaraans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis_angkutan')->references('muatan')->on('data_muatans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kota')->references('kota')->on('data_kotas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tujuan')->references('nama')->on('data_pelanggans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('angkutans');
    }
}
