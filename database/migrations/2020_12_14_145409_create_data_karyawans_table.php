<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_karyawans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 40);
            $table->string('tempat_lahir', 20);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 15);
            $table->string('alamat', 100);
            $table->string('handphone', 15);
            $table->string('jabatan', 20);
            $table->timestamps();
        });
        Schema::table('data_karyawans', function (Blueprint $table) {
            $table->foreign('jabatan')->references('nama')->on('data_gajis')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_karyawans');
    }
}
