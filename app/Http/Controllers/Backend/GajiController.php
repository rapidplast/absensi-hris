<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\AbsenLog;
use App\Models\AbsenMentah;
use App\Models\Divisi;
use App\Models\HariKerja;
use App\Models\Jadwal;
use App\Models\Mesin;
use App\Models\Token;
use App\Models\Pegawai;
use App\Models\ReferensiKerja;
use App\Models\ReguKerja;
use App\Models\ShiftKerja;
use Carbon\Carbon;
use Auth;
// use Dotenv\Validator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GajiController extends Controller
{
    function index(Request $request){
        // dd($request->all());
        $absen = Pegawai::where('email', auth()->user()->email)-> first();
        $email = auth()->user()->email;
        // return response()->json($absen->pid);
        if($request->method() == 'GET'){
            $date = Carbon::now()->format('Y-m-d');
            $tanggal = Carbon::now()->format('d F Y');
            $tanggalCetak = Carbon::now()->format('Y-m-d');
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            $dbName = $year.''.$month.'HISTORY';
            $refin = Carbon::now()->format('h:i:s');
            $refout = Carbon::now()->format('h:i:s');
            $divisi = Divisi::all();
            // $absensi = Absen::all();
            $date = Carbon::now()->format('Y-m-d');
            $absensi = DB::select(
                "SELECT
                afh.id,
                afh.pid,
                p.nama,
                afh.check_in,
                afh.check_out,
            IF
                (
                    SUBTIME( afh.check_in, '$refin' ) < ' 00:00:00',
                    '00:00:00',
                SUBTIME( afh.check_in, '$refin' )) AS telat,
            IF
                (
                    afh.check_out < '$refout',
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) AS jam_kerja,
            IF
                (
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                    1,
                    0 
                ) AS jumlah_hari,
            IF
                (
                    DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                    0,
                DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) AS lembur_awal,
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )) AS lembur_akhir,
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )))* 12500 
                ) AS jam_lembur,
            IF
                (
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) >= 8,
                    100000 *
                IF
                    (
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                        1,
                        0 
                    ),
                    100000 / 8 *
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' ))) AS upah,
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )))* 12500 
                    ) + (
                IF
                    (
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) >= 8,
                        100000 *
                    IF
                        (
                        IF
                            (
                                afh.check_out < '$refout',
                                DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                            DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                            1,
                            0 
                        ),
                        100000 / 8 *
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )))) AS total_upah,
            IF
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )) > 0 
                        ),
                    'Lembur',
                    '' 
                ) AS Keterangan ,
            DATE(afh.sync_date) as tanggal
            FROM
                absensi_fingerprint.pegawais p,
                absensi_frhistory.$dbName afh 
            WHERE
                p.pid = afh.pid 
                AND DATE( afh.sync_date ) = '$date'                 
            ORDER BY
                afh.id DESC"
            );

            return view('admin.gaji.index', compact(['absensi', 'tanggal', 'date', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi']));
        } else if(empty($request->divisi)){            
            $date = Carbon::now()->format('Y-m-d');
            $year = date('Y', strtotime($request->tanggal));
            $month = date('m', strtotime($request->tanggal));
            $dbName = $year.''.$month.'HISTORY';
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            $tanggal2 = date('Y-m-d', strtotime($request->tanggal2));
            $tanggalCetak = date('Y-m-d', strtotime($request->tanggal));
            $refin = date('H:i:s',strtotime($request->refin)) ;
            $refout = date('H:i:s',strtotime($request->refout));
            $divisi = Divisi::all();
            $divisi1 = $request->divisi;
            // dd($request->all());
            // $absensi = Absen::all();
            $absensi = DB::select(
                "SELECT
                afh.id,
                afh.pid,
                p.nama,
                afh.check_in,
                afh.check_out,                
            IF
                (
                    SUBTIME( afh.check_in, '$refin' ) < ' 00:00:00',
                    '00:00:00',
                SUBTIME( afh.check_in, '$refin' )) AS telat,
            IF
                (
                    afh.check_out < '$refout',
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) AS jam_kerja,
            IF
                (
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                    1,
                    0 
                ) AS jumlah_hari,
            IF
                (
                    DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                    0,
                DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) AS lembur_awal,
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )) AS lembur_akhir,
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )))* 12500 
                ) AS jam_lembur,
            IF
                (
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) >= 8,
                    100000 *
                IF
                    (
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                        1,
                        0 
                    ),
                    100000 / 8 *
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' ))) AS upah,
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )))* 12500 
                    ) + (
                IF
                    (
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) >= 8,
                        100000 *
                    IF
                        (
                        IF
                            (
                                afh.check_out < '$refout',
                                DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                            DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                            1,
                            0 
                        ),
                        100000 / 8 *
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )))) AS total_upah,
            IF
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )) > 0 
                        ),
                    'Lembur',
                    '' 
                ) AS Keterangan ,
            DATE(afh.sync_date) as tanggal
            FROM            
                absensi_fingerprint.pegawais p,
                absensi_frhistory.$dbName afh                
            WHERE
                p.pid = afh.pid 
                AND DATE( afh.sync_date ) BETWEEN '$tanggal' 
                AND '$tanggal2'                                               
            ORDER BY
                afh.id DESC"
            );

            return view('admin.gaji.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi']));
        }else{
            $date = Carbon::now()->format('Y-m-d');
            $year = date('Y', strtotime($request->tanggal));
            $month = date('m', strtotime($request->tanggal));
            $dbName = $year.''.$month.'HISTORY';
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            $tanggal2 = date('Y-m-d', strtotime($request->tanggal2));
            $tanggalCetak = date('Y-m-d', strtotime($request->tanggal));
            $refin = date('H:i:s',strtotime($request->refin)) ;
            $refout = date('H:i:s',strtotime($request->refout));
            $divisi = Divisi::all();
            $divisi1 = $request->divisi;
            // dd($request->all());
            // $absensi = Absen::all();
            $absensi = DB::select(
                "SELECT
                afh.id,
                afh.pid,
                p.nama,
                afh.check_in,
                afh.check_out,
                a.nama as divisi,
            IF
                (
                    SUBTIME( afh.check_in, '$refin' ) < ' 00:00:00',
                    '00:00:00',
                SUBTIME( afh.check_in, '$refin' )) AS telat,
            IF
                (
                    afh.check_out < '$refout',
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) AS jam_kerja,
            IF
                (
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                    1,
                    0 
                ) AS jumlah_hari,
            IF
                (
                    DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                    0,
                DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) AS lembur_awal,
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )) AS lembur_akhir,
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )))* 12500 
                ) AS jam_lembur,
            IF
                (
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) >= 8,
                    100000 *
                IF
                    (
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                        1,
                        0 
                    ),
                    100000 / 8 *
                IF
                    (
                        afh.check_out < '$refout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' ))) AS upah,
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )))* 12500 
                    ) + (
                IF
                    (
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) >= 8,
                        100000 *
                    IF
                        (
                        IF
                            (
                                afh.check_out < '$refout',
                                DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                            DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )) > 0,
                            1,
                            0 
                        ),
                        100000 / 8 *
                    IF
                        (
                            afh.check_out < '$refout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refin' ), '%H' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%H' )))) AS total_upah,
            IF
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '$refin', afh.check_in ), '%H' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refout' ), '%H' )) > 0 
                        ),
                    'Lembur',
                    '' 
                ) AS Keterangan ,
            DATE(afh.sync_date) as tanggal
            FROM            
                absensi_fingerprint.pegawais p,
                absensi_frhistory.$dbName afh, 
                absensi_fingerprint.divisies a
            WHERE
                p.pid = afh.pid 
                AND DATE(afh.sync_date ) BETWEEN '$tanggal' 
                AND '$tanggal2'   
                AND a.kode = p.divisi_id 
                AND a.kode = '$divisi1'              
            ORDER BY
                afh.id DESC"
            );
            return view('admin.gaji.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi'])); 
        }
    }

}
