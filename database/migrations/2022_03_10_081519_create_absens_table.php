<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->integer('pid');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->time('telat')->nullable();
            $table->time('check_in1')->nullable();
            $table->time('check_out1')->nullable();
            $table->time('check_in2')->nullable();
            $table->time('check_out2')->nullable();
            $table->time('check_in3')->nullable();
            $table->time('check_out3')->nullable();
            $table->time('izin')->nullable();
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
        Schema::dropIfExists('absens');
    }
}
