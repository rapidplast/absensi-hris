<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departement_id');
            $table->string('kode');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('departement_id')->references('id')->on('departements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisies');
    }
}
