<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockAngkutansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lock_angkutans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_angkutan');
            $table->string('status', 10);
            $table->string('password', 100)->nullable();
            $table->timestamps();
        });
        Schema::table('lock_angkutans', function (Blueprint $table) {
            $table->foreign('id_angkutan')->references('id')->on('angkutans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lock_angkutans');
    }
}
