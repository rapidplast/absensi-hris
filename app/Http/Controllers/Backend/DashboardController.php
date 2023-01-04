<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        checkDB();
        $tanggal = Carbon::now()->format('d F Y');
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $monthName = Carbon::now()->format('F');
        $dbName = $year.''.$month.'HISTORY';

        // ***** GET 5 MONTH BEFORE ***** //
        $month4 = strtotime($month) + strtotime("-1 month");
        $month4Name = date('F', $month4);
        $month4 = date('m', $month4);
        $month3 = strtotime($month) + strtotime("-2 month");
        $month3Name = date('F', $month3);
        $month3 = date('m', $month3);
        $month2 = strtotime($month) + strtotime("-3 month");
        $month2Name = date('F', $month2);
        $month2 = date('m', $month2);
        $month1 = strtotime($month) + strtotime("-4 month");
        $month1Name = date('F', $month1);
        $month1 = date('m', $month1);
        $dbName = $year.''.$month.'HISTORY';
        $dbName4 = $year.''.$month4.'HISTORY';
        $dbName3 = $year.''.$month3.'HISTORY';
        $dbName2 = $year.''.$month2.'HISTORY';
        $dbName1 = $year.''.$month1.'HISTORY';

        
        $dbCheck4 = Schema::connection('mysql2')->hasTable($dbName4);
        $dbCheck3 = Schema::connection('mysql2')->hasTable($dbName3);
        $dbCheck2 = Schema::connection('mysql2')->hasTable($dbName2);
        $dbCheck1 = Schema::connection('mysql2')->hasTable($dbName1);

        $checkIn = count(DB::select(
                    "SELECT afh.check_in
                    FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                    WHERE p.pid = afh.pid AND MONTH(afh.sync_date) = '$month' AND afh.check_in IS NOT NULL
                    ORDER BY afh.id DESC"
                ));
        $checkOut = count(DB::select(
                    "SELECT afh.check_out
                    FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                    WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month' AND afh.check_in IS NOT NULL AND afh.check_out IS NOT NULL
                    ORDER BY afh.id DESC"
                ));
        $telat = count(DB::select(
                    "SELECT afh.check_out
                    FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                    WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month' AND afh.telat IS NOT NULL
                    ORDER BY afh.id DESC"
                ));

        if($dbCheck1 === true){
            $checkIn1 = count(DB::select(
                        "SELECT afh.check_in
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName1 afh
                        WHERE p.pid = afh.pid AND MONTH(afh.sync_date) = '$month2' AND afh.check_in IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $checkOut1 = count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName1 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month2' AND afh.check_in IS NOT NULL AND afh.check_out IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $telat1= count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName1 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month2' AND afh.telat IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
        }else{
            $checkIn1 = 0;
            $checkOut1 = 0;
            $telat1 = 0;
        }

        if($dbCheck2 === true){
            $checkIn2 = count(DB::select(
                        "SELECT afh.check_in
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName2 afh
                        WHERE p.pid = afh.pid AND MONTH(afh.sync_date) = '$month2' AND afh.check_in IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $checkOut2 = count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName2 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month2' AND afh.check_in IS NOT NULL AND afh.check_out IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $telat2= count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName2 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month2' AND afh.telat IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
        }else{
            $checkIn2 = 0;
            $checkOut2 = 0;
            $telat2 = 0;
        }

        if($dbCheck3 === true){
            $checkIn3 = count(DB::select(
                        "SELECT afh.check_in
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName3 afh
                        WHERE p.pid = afh.pid AND MONTH(afh.sync_date) = '$month3' AND afh.check_in IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $checkOut3 = count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName3 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month3' AND afh.check_in IS NOT NULL AND afh.check_out IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $telat3 = count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName3 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month3' AND afh.telat IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
        }else{
            $checkIn3 = 0;
            $checkOut3 = 0;
            $telat3 = 0;
        }

        if($dbCheck4 === true){
            $checkIn4 = count(DB::select(
                        "SELECT afh.check_in
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName4 afh
                        WHERE p.pid = afh.pid AND MONTH(afh.sync_date) = '$month4' AND afh.check_in IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $checkOut4 = count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName4 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month4' AND afh.check_in IS NOT NULL AND afh.check_out IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
            $telat4 = count(DB::select(
                        "SELECT afh.check_out
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName4 afh
                        WHERE p.pid = afh.pid AND Month(afh.sync_date) = '$month4' AND afh.telat IS NOT NULL
                        ORDER BY afh.id DESC"
                    ));
        }else{
            $checkIn4 = 0;
            $checkOut4 = 0;
            $telat4 = 0;
        }



        $bar = (new LarapexCHart)->barChart()
                ->setTitle('Bar Absensi')
                ->setSubtitle('Check In, Check Out & Telat')
                ->addData('Check In', [$checkIn, $checkIn1, $checkIn2, $checkIn3, $checkIn4])
                ->addData('Check Out', [$checkOut, $checkOut1, $checkOut2, $checkOut3, $checkOut4])
                ->addData('Telat', [$telat, $telat2, $telat3, $telat4])
                ->setXAxis([$monthName, $month1Name,$month2Name, $month3Name, $month4Name]);
    
        $pie = (new LarapexChart)->pieChart()
                ->setTitle('Data Check In & Check Out')
                ->setSubtitle($tanggal)
                ->addData([intval($checkIn), intval($checkOut)])
                ->setLabels(['Check In', 'Check Out']);
        return view('admin.dashboard.index', compact(['bar', 'pie', 'checkIn', 'checkOut']));
    }
}
