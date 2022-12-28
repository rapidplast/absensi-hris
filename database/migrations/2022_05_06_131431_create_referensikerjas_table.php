<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferensikerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referensikerjas', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->time('workin')->nullable();
            $table->time('restout')->nullable();
            $table->time('restin')->nullable();
            $table->time('workout')->nullable();
            $table->time('total_jam')->nullable();
            $table->time('rangerestout')->nullable();
            $table->time('rangerestin')->nullable();
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
        Schema::dropIfExists('referensikerjas');
    }
}
