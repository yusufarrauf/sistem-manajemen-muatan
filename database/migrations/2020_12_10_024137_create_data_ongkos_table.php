<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataOngkosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_ongkos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asal', 25);
            $table->string('tujuan', 50)->nullable();
            $table->string('kota', 50);
            $table->bigInteger('ongkos_vendor');
            $table->bigInteger('ongkos_invoice');
            $table->bigInteger('supir_perton');
            $table->bigInteger('mobil_perton');
            $table->bigInteger('bonus');
            $table->bigInteger('panjar');
            $table->timestamps();
        });
        Schema::table('data_ongkos', function (Blueprint $table) {
            $table->foreign('tujuan')->references('nama')->on('data_pelanggans')->onUpdate('cascade');
            $table->foreign('kota')->references('kota')->on('data_kotas')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_ongkos');
    }
}
