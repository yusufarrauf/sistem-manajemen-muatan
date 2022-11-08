<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalPerawatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_perawatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nopol', 10)->nullable();
            $table->date('tanggal')->nullable();
            $table->string('sparepart', 100)->nullable();
            $table->bigInteger('harga')->nullable();
            $table->integer('satuan')->nullable();
            $table->bigInteger('total')->nullable();
            $table->tinyInteger('isApprove')->default(0);
            $table->timestamps();
        });
        Schema::table('approval_perawatans', function (Blueprint $table) {
            $table->foreign('nopol')->references('nopol')->on('data_kendaraans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approval_perawatans');
    }
}
