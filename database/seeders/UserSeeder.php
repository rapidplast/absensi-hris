<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id'        => '1',
                'role_id'   => '1',
                'name'      => 'Admin',
                'email'     => 'admin@gmail.com',
                'password'  => bcrypt('admin'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'id'        => '2',
                'role_id'   => '1',
                'name'      => 'Admin2',
                'email'     => 'admin2@gmail.com',
                'password'  => bcrypt('admin'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'id'        => '3',
                'role_id'   => '2',
                'name'      => 'Pegawai',
                'email'     => 'pegawai@gmail.com',
                'password'  => bcrypt('pegawai'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'id'        => '4',
                'role_id'   => '2',
                'name'      => 'Pegawai2',
                'email'     => 'pegawai2@gmail.com',
                'password'  => bcrypt('pegawai'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
        ]);
    }
}
