<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->string('1', 16);
            $table->string('2', 16);
            $table->string('3', 16);
            $table->string('4', 16);
            $table->string('5', 16);
            $table->string('6', 16);
            $table->string('7', 16);
            $table->string('8', 16);
            $table->string('9', 16);
            $table->string('10', 16);
            $table->string('11', 16);
            $table->string('12', 16);
            $table->string('13', 16);
            $table->string('14', 16);
            $table->string('15', 16);
            $table->string('16', 16);
            $table->string('17', 16);
            $table->string('18', 16);
            $table->string('19', 16);
            $table->string('20', 16);
            $table->string('21', 16);
            $table->string('22', 16);
            $table->string('23', 16);
            $table->string('24', 16);
            $table->string('25', 16);
            $table->string('26', 16);
            $table->string('27', 16);
            $table->string('28', 16);
            $table->string('29', 16);
            $table->string('30', 16);
            $table->string('31', 16);
            $table->string('32', 16);
            $table->string('33', 16);
            $table->string('34', 16);
            $table->string('35', 16);
            $table->string('36', 16);
            $table->string('37', 16);
            $table->string('38', 16);
            $table->string('39', 16);
            $table->string('40', 16);
            $table->string('41', 16);
            $table->string('42', 16);
            $table->string('43', 16);
            $table->string('44', 16);
            $table->string('45', 16);
            $table->string('46', 16);
            $table->string('47', 16);
            $table->string('48', 16);
            $table->string('49', 16);
            $table->string('50', 16);
            $table->string('51', 16);
            $table->string('52', 16);
            $table->string('53', 16);
            $table->string('54', 16);
            $table->string('55', 16);
            $table->string('56', 16);
            $table->string('57', 16);
            $table->string('58', 16);
            $table->string('59', 16);
            $table->string('60', 16);
            $table->string('61', 16);
            $table->string('62', 16);
            $table->string('63', 16);
            $table->string('64', 16);
            $table->string('65', 16);
            $table->string('66', 16);
            $table->string('67', 16);
            $table->string('68', 16);
            $table->string('69', 16);
            $table->string('70', 16);
            $table->string('71', 16);
            $table->string('72', 16);
            $table->string('73', 16);
            $table->string('74', 16);
            $table->string('75', 16);
            $table->string('76', 16);
            $table->string('77', 16);
            $table->string('78', 16);
            $table->string('79', 16);
            $table->string('80', 16);
            $table->string('81', 16);
            $table->string('82', 16);
            $table->string('83', 16);
            $table->string('84', 16);
            $table->string('85', 16);
            $table->string('86', 16);
            $table->string('87', 16);
            $table->string('88', 16);
            $table->string('89', 16);
            $table->string('90', 16);
            $table->string('91', 16);
            $table->string('92', 16);
            $table->string('93', 16);
            $table->string('94', 16);
            $table->string('95', 16);
            $table->string('96', 16);
            $table->string('97', 16);
            $table->string('98', 16);
            $table->string('99', 16);
            $table->string('100', 16);
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
        Schema::dropIfExists('jadwals');
    }
}
