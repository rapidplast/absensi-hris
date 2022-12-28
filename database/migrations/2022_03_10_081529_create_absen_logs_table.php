<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mesin_id');
            $table->integer('pin');
            $table->datetime('date_time');
            $table->integer('ver');
            $table->integer('status_absen_id');
            $table->timestamps();

            $table->foreign('mesin_id')->references('id')->on('mesins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_logs');
    }
}
