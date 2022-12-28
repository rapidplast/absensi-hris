<?php

use App\Models\AbsensiWfh;
use App\Models\Mesin;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

    function totPegawai(){
        return count(Pegawai::all());
    }

    function totMesin(){
        return count(Mesin::all());
    }

    function totAbsenBackup(){
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $dbName = $year.''.$month.'HISTORY';

        return count(DB::select(
            "SELECT afh.pid, p.nama, p.departement, afh.check_in, afh.check_out, afh.telat, afh.izin, afh.check_in1, afh.check_out1, afh.check_in2, afh.check_out2, afh.check_in3, afh.check_out3
            FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
            WHERE p.pid = afh.pid AND MONTH(afh.sync_date) = '$month'
            ORDER BY afh.id DESC"
        ));
    }

    function totLogBackup(){
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        return count(DB::select(
            "SELECT * FROM absensi_fingerprint.absen_mentahs"
        ));
    }

    function absensiWFH()
    {
        return count(AbsensiWfh::all());
    }

    function clockMin($num){
        if($num < 10){
            return '0'.$num;
        }
        return $num;
    }

    function clockCount($num){
        $tot = 0;
        $tot += $num;
        return $tot;
    }

    function checkDB(){
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $dbName = $year.''.$month.'HISTORY';
        
        if(!Schema::connection('mysql2')->hasTable($dbName)){
            Schema::connection('mysql2')->create($dbName, function(Blueprint $table){
                $table->id();
                $table->unsignedBigInteger('pid');
                $table->unsignedBigInteger('sap')->nullable();
                $table->time('check_in')->nullable();
                $table->time('check_out')->nullable();
                $table->time('telat')->nullable();
                $table->time('check_in1')->nullable();
                $table->time('check_out1')->nullable();
                $table->time('check_in2')->nullable();
                $table->time('check_out2')->nullable();
                $table->time('check_in3')->nullable();
                $table->time('check_out3')->nullable();
                $table->time('absen1')->nullable();
                $table->time('absen2')->nullable();
                $table->time('izin')->nullable();
                $table->timestamp('sync_date')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
        }


        // ***** GET 6 MONTH BEFORE ***** //
        $month6 = strtotime($month) + strtotime("-5 month");
        $month6 = date('m', $month6);
        $dbName6 = $year.''.$month6.'HISTORY';

        // ***** Variable for check if table is exist ***** //
        $dbCheck6 = Schema::connection('mysql2')->hasTable($dbName6);
        if($dbCheck6 === true){
            Schema::connection('mysql')->dropIfExists($dbName6);
        }
    }
?>