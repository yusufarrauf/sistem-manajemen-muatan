<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataKendaraansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kendaraans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nopol', 25)->unique();
            $table->string('vendor', 50);
            $table->string('supir', 25);
            $table->string('status', 15);
            $table->timestamps();
        });
        Schema::table('data_kendaraans', function (Blueprint $table) {
            $table->foreign('vendor')->references('nama')->on('vendor_kendaraans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_kendaraans');
    }
}
