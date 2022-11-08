<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekapitulasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode', 25)->unique();
            $table->integer('ke');
            $table->string('jenis', 70);
            $table->string('nama', 100);
            $table->date('range_from');
            $table->date('range_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekapitulasis');
    }
}
