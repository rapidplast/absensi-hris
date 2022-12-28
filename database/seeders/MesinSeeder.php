<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class MesinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mesins')->insert([
            [
                'name'          => 'Pos Satpam',
                'tcpip'         => '192.168.0.12',
                'serial_number' => '0ID02192193',
                'tipe'          => 'X231-C',
                'is_default'    => '0',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'Mesin IRL',
                'tcpip'         => '192.168.3.12',
                'serial_number' => '0ID030812',
                'tipe'          => 'X231-A',
                'is_default'    => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
        ]);
    }
}
