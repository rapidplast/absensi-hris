<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
class attController extends Controller
{
    function index(Request $request){
        if($request->method() == 'GET'){
            $date   = Carbon::now()->format('Y-m-d');
            $tanggal    = Carbon::now()->format('d F Y');
            $tanggalCetak   = Carbon::now()->format('Y-m-d');
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            $dbName = $year.''.$month.'HISTORY';

            $date = Carbon::now()->format('Y-m-d');

            $absensi = DB::select(
                "SELECT
                a.NIP,
                a.date,
                a.JAM AS Cin,
                b.JAM AS Cout 
            FROM
                (
                SELECT
                    STR_TO_DATE( a.CDATE, '%Y%m%d' ) AS date,
                    b.NIP,
                    b.JAM,
                    a.IO 
                FROM
                    HRATTEND.DATAMC4SAP AS a,
                    HRFINGERS.$dbName AS b 
                WHERE
                    a.NIP = b.NIP 
                    AND STR_TO_DATE( a.CDATE, '%Y%m%d' ) = DATE( b.TANGGAL ) 
                    AND STR_TO_DATE( a.CTIME, '%H%i' ) = b.JAM 		
                    AND a.IO = '0' 
                ) AS a,
                (
                SELECT
                    STR_TO_DATE( a.CDATE, '%Y%m%d' ) AS date,
                    b.NIP,
                    b.JAM,
                    a.IO 
                FROM
                    HRATTEND.DATAMC4SAP AS a,
                    HRFINGERS.$dbName AS b 
                WHERE
                    a.NIP = b.NIP 
                    AND STR_TO_DATE( a.CDATE, '%Y%m%d' ) = DATE( b.TANGGAL ) 
                    AND STR_TO_DATE( a.CTIME, '%H%i' ) = b.JAM 
                    AND a.IO = '1' 
                ) AS b 
            WHERE
                a.NIP = b.NIP 
                and a.date = b.date
                and a.date BETWEEN '$tanggal' and '$tanggalCetak'
                ORDER BY a.date"
            );
        } else {
            $date = Carbon::now()->format('Y-m-d');
            $year = date('Y', strtotime($request->tanggal));
            $month = date('m', strtotime($request->tanggal));
            $dbName = $year.''.$month.'HISTORY';
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            $tanggal2 = date('Y-m-d', strtotime($request->tanggal2));
            $tanggalCetak = date('Y-m-d', strtotime($request->tanggal));
            // $absensi = Absen::all();
            $absensi = DB::select(
                "SELECT
                a.NIP,
                a.date,
                a.JAM AS Cin,
                b.JAM AS Cout 
            FROM
                (
                SELECT
                    STR_TO_DATE( a.CDATE, '%Y%m%d' ) AS date,
                    b.NIP,
                    b.JAM,
                    a.IO 
                FROM
                    HRATTEND.DATAMC4SAP AS a,
                    HRFINGERS.202209HISTORY AS b 
                WHERE
                    a.NIP = b.NIP 
                    AND STR_TO_DATE( a.CDATE, '%Y%m%d' ) = DATE( b.TANGGAL ) 
                    AND STR_TO_DATE( a.CTIME, '%H%i' ) = b.JAM 		
                    AND a.IO = '0' 
                ) AS a,
                (
                SELECT
                    STR_TO_DATE( a.CDATE, '%Y%m%d' ) AS date,
                    b.NIP,
                    b.JAM,
                    a.IO 
                FROM
                    HRATTEND.DATAMC4SAP AS a,
                    HRFINGERS.202209HISTORY AS b 
                WHERE
                    a.NIP = b.NIP 
                    AND STR_TO_DATE( a.CDATE, '%Y%m%d' ) = DATE( b.TANGGAL ) 
                    AND STR_TO_DATE( a.CTIME, '%H%i' ) = b.JAM 
                    AND a.IO = '1' 
                ) AS b 
            WHERE
                a.NIP = b.NIP 
                and a.date = b.date
                and a.date BETWEEN '$tanggal' and '$tanggalCetak'
                ORDER BY a.date"
            );
            return view('admin.absensi.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName']));
        }
    }
}
