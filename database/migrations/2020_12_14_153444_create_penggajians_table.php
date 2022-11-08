<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenggajiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penggajians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_karyawan');
            $table->bigInteger('gaji_pokok');
            $table->string('biaya_lain', 191);
            $table->bigInteger('total_gaji');
            $table->timestamps();
        });
        Schema::table('penggajians', function (Blueprint $table) {
            $table->foreign('id_karyawan')->references('id')->on('data_karyawans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penggajians');
    }
}
