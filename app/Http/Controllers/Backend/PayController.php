<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\AbsenLog;
use App\Models\AbsenMentah;
use App\Models\Divisi;
use App\Models\Gaji;
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
use Redirect;
// use Dotenv\Validator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PayController extends Controller
{
    function index(Request $request){
        // return response()->json($request->all());
        $a = $request->flash();
        $dt = $request->old('tanggal2');
        Session::put('name',$request->old('tanggal2'));
        $value = Session::get('name');      
        $nipAwal = $request->nipAwal;
        $nipAkhir = $request->nipAkhir;
        $absen = Pegawai::where('email', auth()->user()->email)-> first();
        $email = auth()->user()->email;

        if(empty($request->tanggal2 ) && empty( $request->tanggal)){             
            $date = Carbon::now()->format('Y-m-d');
            $tanggal = Carbon::now()->format('d F Y');
            $tanggal2 = Carbon::now()->format('Y-m-d');
            $tanggalCetak = Carbon::now()->format('Y-m-d');

            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            $dbName = $year.''.$month.'HISTORY';
            $refin = Carbon::now()->format('h:i:s');
            $refout = Carbon::now()->format('h:i:s');
            $divisi = Divisi::all();            
            $referensi  = ReferensiKerja::all();
            $refer = ReferensiKerja::where('id',62)->first();            
            $date = Carbon::now()->format('Y-m-d');
            // return response()->json($refer->workin);
            $pay = DB::select(
                "SELECT
                afh.id,
                DATE( afh.sync_date ) AS date,
                afh.pid,
                p.nama,
                b.workin,
                b.workout,
                afh.check_in,
                afh.check_out,
                a.nama AS divisi,
            IF
                (
                    SUBTIME( afh.check_in, '06:00:00' ) < ' 00:00:00', '00:00:00', SUBTIME( afh.check_in, '06:00:00' )) AS telat, IF ( afh.check_in > '06:00:00',
                    DATE_FORMAT( SUBTIME( '14:00:00', afh.check_in ), '%k' ),
                IF
                ( DATE_FORMAT( SUBTIME( '14:00:00', afh.check_in ), '%k' )>= 8, 8, NULL )) AS jam_kerja,
            IF
                (
                    afh.check_out < '14:00:00',
                    DATE_FORMAT( SUBTIME( afh.check_out, '06:00:00' ), '%k' ),
                DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) AS jam_kerja_full,
            IF
                (
                IF
                    (
                        afh.check_out < '14:00:00',
                        DATE_FORMAT( SUBTIME( afh.check_out, '06:00:00' ), '%k' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) > 8,
                    1,
                    '' 
                ) AS jumlah_hari,
                (
                IF
                    (
                        afh.check_in > '06:00:00',
                        DATE_FORMAT( SUBTIME( '14:00:00', afh.check_in ), '%k' ),
                    IF
                    ( DATE_FORMAT( SUBTIME( '14:00:00', afh.check_in ), '%k' )>= 8, 8, NULL ))* 12500 
                ) AS upah,
            IF
                (
                    DATE_FORMAT( SUBTIME( '06:00:00', afh.check_in ), '%k' ) <= 0,
                    0,
                DATE_FORMAT( SUBTIME( '06:00:00', afh.check_in ), '%k' )) AS lembur_awal,
                NULL AS cek_a,
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_out, '14:00:00' ), '%k' )<= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_out, '14:00:00' ), '%k' )) AS lembur_akhir,
                NULL AS cek_ak,
                (
                IF
                    (
                        DATE_FORMAT( SUBTIME( '06:00:00', afh.check_in ), '%k' ) <= 0,
                        0,
                    DATE_FORMAT( SUBTIME( '06:00:00', afh.check_in ), '%k' ))+
                IF
                    (
                        DATE_FORMAT( SUBTIME( afh.check_out, '14:00:00' ), '%k' )<= 0,
                        0,
                    DATE_FORMAT( SUBTIME( afh.check_out, '14:00:00' ), '%k' ))* 12500 
                    )+(
                IF
                    (
                        afh.check_in > '06:00:00',
                        DATE_FORMAT( SUBTIME( '14:00:00', afh.check_in ), '%k' ),
                    IF
                    ( DATE_FORMAT( SUBTIME( '14:00:00', afh.check_in ), '%k' )>= 8, 8, NULL ))* 12500 
                ) AS total_upah,
            IF
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( '06:00:00', afh.check_in ), '%k' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( '06:00:00', afh.check_in ), '%k' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, '14:00:00' ), '%k' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, '14:00:00' ), '%k' )) > 0 
                        ),
                    'Lembur',
                    '' 
                ) AS Keterangan 
            FROM
                absensi_fingerprint.pegawais p,
                absensi_frhistory.$dbName afh,
                absensi_fingerprint.divisies a,
                absensi_fingerprint.referensikerjas b 
            WHERE
                p.pid = afh.pid 

                AND p.ref_id = b.id 
                AND DATE( afh.sync_date ) = $date
                AND a.kode = p.divisi_id 
                AND a.kode = 'BRG' 
            ORDER BY
                afh.id DESC"
            );
                return view('admin.pay.index', compact(['nipAwal','nipAkhir','pay','tanggal2', 'tanggal', 'date', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi']));
  

        } else if(empty($request->tanggal2 ) && empty( $request->tanggal)){            
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
            $nipAwal = $request->nipAwal;
            $nipAkhir = $request->nipAkhir;
            $referensi  = ReferensiKerja::all();
            $refer = ReferensiKerja::where('id',$request->divisi)->first(); 
      
            $pay = DB::select("SELECT
            afh.id,
            DATE( afh.sync_date ) AS date,
            afh.pid,
            p.nama,
            b.workin,
            b.workout,
            afh.check_in,
            afh.check_out,
            a.nama AS divisi,
        IF
            (
                SUBTIME( afh.check_in, '$refer->workin' ) < ' 00:00:00', '00:00:00', SUBTIME( afh.check_in, '$refer->workin' )) AS telat, IF ( afh.check_in > '$refer->workin',
                DATE_FORMAT( SUBTIME( '$refer->workout', afh.check_in ), '%k' ),
            IF
            ( DATE_FORMAT( SUBTIME( '$refer->workout', afh.check_in ), '%k' )>= 8, 8, NULL )) AS jam_kerja,
        IF
            (
                afh.check_out < '$refer->workout',
                DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workin' ), '%k' ),
            DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) AS jam_kerja_full,
        IF
            (
            IF
                (
                    afh.check_out < '$refer->workout',
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workin' ), '%k' ),
                DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) > 8,
                1,
                '' 
            ) AS jumlah_hari,
            (
            IF
                (
                    afh.check_in > '$refer->workin',
                    DATE_FORMAT( SUBTIME( '$refer->workout', afh.check_in ), '%k' ),
                IF
                ( DATE_FORMAT( SUBTIME( '$refer->workout', afh.check_in ), '%k' )>= 8, 8, NULL ))* 12500 
            ) AS upah,
        IF
            (
                DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' ) <= 0,
                0,
            DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' )) AS lembur_awal,
            NULL AS cek_a,
        IF
            (
                DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' )<= 0,
                0,
            DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' )) AS lembur_akhir,
            NULL AS cek_ak,
            (
            IF
                (
                    DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' ) <= 0,
                    0,
                DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' ))+
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' )<= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' ))* 12500 
                )+(
            IF
                (
                    afh.check_in > '$refer->workin',
                    DATE_FORMAT( SUBTIME( '$refer->workout', afh.check_in ), '%k' ),
                IF
                ( DATE_FORMAT( SUBTIME( '$refer->workout', afh.check_in ), '%k' )>= 8, 8, NULL ))* 12500 
            ) AS total_upah,
        IF
            ((
                IF
                    (
                        DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' ) <= 0,
                        0,
                    DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' )) +
                IF
                    (
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' )<= 0,
                        0,
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' )) > 0 
                    ),
                'Lembur',
                '' 
            ) AS Keterangan 
        FROM
            absensi_fingerprint.pegawais p,
            absensi_frhistory.$dbName afh,
            absensi_fingerprint.divisies a,
            absensi_fingerprint.referensikerjas b 
        WHERE
            p.pid = afh.pid 
            AND afh.pid BETWEEN '$nipAwal' 
            AND '$nipAkhir' 
            AND p.ref_id = b.id 
            AND DATE( afh.sync_date ) BETWEEN '$tanggal' 
            AND '$tanggal2' 
            AND a.kode = p.divisi_id 
            AND a.kode = 'BRG' 
        ORDER BY
            afh.id DESC");
            return view('admin.pay.index', compact([ 'nipAwal','nipAkhir','tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi','pay']));
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
            $nipAwal = $request->nipAwal;            
            $nipAkhir = $request->nipAkhir;
            // return response()->json($nipAkhir);
            $divisi1 = $request->divisi;
            $referensi  = ReferensiKerja::all();
            $refer = ReferensiKerja::where('id',$request->divisi)->first();
            // $db = DB::connection('mysql2')->table($dbName);
            // return response()->json($db);
            $pay = DB::select(
                "SELECT
                afh.id,
                DATE( afh.sync_date ) AS date,
                afh.pid,
                p.nama,
                afh.check_in1,
                afh.check_out1,
                afh.check_in,
                afh.check_out,
                a.nama AS divisi,
            IF
                (
                    SUBTIME( afh.check_in, afh.check_in1 ) < ' 00:00:00', '00:00:00', SUBTIME( afh.check_in, afh.check_in1 )) AS telat, IF ( afh.check_in > afh.check_in1,
                    DATE_FORMAT( SUBTIME( afh.check_out1, afh.check_in ), '%k' ),
                IF
                ( DATE_FORMAT( SUBTIME( afh.check_out1, afh.check_in ), '%k' )>= 8, 8, NULL )) AS jam_kerja,
            IF
                (
                    afh.check_out < afh.check_out1,
                    DATE_FORMAT( SUBTIME( afh.check_out, afh.check_in1 ), '%k' ),
                DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) AS jam_kerja_full,
            IF
                (
                IF
                    (
                        afh.check_out < afh.check_out1,
                        DATE_FORMAT( SUBTIME( afh.check_out, afh.check_in1 ), '%k' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) >= 8,
                    1,
                    '' 
                ) AS jumlah_hari,
                (
                IF
                    (
                        afh.check_in > afh.check_in1,
                        DATE_FORMAT( SUBTIME( afh.check_out1, afh.check_in ), '%k' ),
                    IF
                    ( DATE_FORMAT( SUBTIME( afh.check_out1, afh.check_in ), '%k' )>= 8, 8, NULL ))* 12500 
                ) AS upah,
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_in1, afh.check_in ), '%k' ) <= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_in1, afh.check_in ), '%k' )) AS lembur_awal,
                NULL AS cek_a,
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_out, afh.check_out1 ), '%k' )<= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_out, afh.check_out1 ), '%k' )) AS lembur_akhir,
                NULL AS cek_ak,
                ((
		IF
			(
				DATE_FORMAT( SUBTIME( afh.check_in1, afh.check_in ), '%k' ) <= 0,
				0,
			DATE_FORMAT( SUBTIME( afh.check_in1, afh.check_in ), '%k' ))+
		IF
			(
				DATE_FORMAT( SUBTIME( afh.check_out, afh.check_out1 ), '%k' )<= 0,
				0,
			DATE_FORMAT( SUBTIME( afh.check_out, afh.check_out1 ), '%k' )))* 12500 
		) + (
	IF
		(
			afh.check_in > afh.check_in1,
			DATE_FORMAT( SUBTIME( afh.check_out1, afh.check_in ), '%k' ),
		IF
		( DATE_FORMAT( SUBTIME( afh.check_out1, afh.check_in ), '%k' )>= 8, 8, NULL ))* 12500 
	) AS total_upah,
            IF
                ((
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_in1, afh.check_in ), '%k' ) <= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_in1, afh.check_in ), '%k' )) +
                    IF
                        (
                            DATE_FORMAT( SUBTIME( afh.check_out, afh.check_out1 ), '%k' )<= 0,
                            0,
                        DATE_FORMAT( SUBTIME( afh.check_out, afh.check_out1 ), '%k' )) > 0 
                        ),
                    'Lembur',
                    '' 
                ) AS Keterangan 
            FROM
                absensi_fingerprint.pegawais p,
                absensi_frhistory.$dbName afh,
                absensi_fingerprint.divisies a,
                absensi_fingerprint.referensikerjas b 
            WHERE
                p.pid = afh.pid 
                AND afh.pid BETWEEN '$nipAwal' 
                AND '$nipAkhir' 
                AND p.ref_id = b.id 
                -- AND p.ref_id = '$request->divisi'
                AND DATE( afh.sync_date ) BETWEEN '$tanggal' 
                AND '$tanggal2' 
                AND a.kode = p.divisi_id 
                AND a.kode = 'BRG' 
            ORDER BY
                afh.id DESC"
            );
            // return response()->json($pay);
            return view('admin.pay.index', compact([ 'nipAwal','nipAkhir','tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi','pay'])); 
        }
        
    }
    
    function update(Request $request, $id){
        // return response()->json($request->method() == 'POST');
        // $a = $request->flash();
        // $b = session::all();
        Session::put('name',$request->old('tanggal2'));
        $value = Session::get('name');      
        // return response()->json($value);        
        if($request->method() == 'POST'){
        $pay = Gaji::where('id',$id)->first();
        // return response()->json($request->lm);
        Gaji::where('id',$id)->update([
            'tot_lembur' =>$request->lm , 
            'total_upah' =>($pay->upah + (12500 * $request->lm)),
        ]);    
         
        // return redirect()->route('searchGaji', $id)->with('alert', 'Sukses Mengubah '.$pay->id);
        return redirect()->back()->withInput($request->all());
        // return response()->json($pay->upah);
    }
    // return response()->json($request->old('tanggal2'));   
}
    function display(Request $request){
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
        $referensi  = ReferensiKerja::all();
        $refer = ReferensiKerja::where('id',$request->divisi)->first();
        $pay = DB::select("SELECT
        a.id,
        a.pid,
        b.nama,
        a.check_in,
        a.check_out,
        a.divisi_id,
        c.nama as ref,
        date,
        a.telat,
        a.jam_kerja,
        a.jum_hari,
        a.lembur_aw,
        a.lembur_ak,
        a.tot_lembur,
        a.upah,
        a.total_upah 
    FROM
        gaji a,
        pegawais b,
        referensikerjas c,
        divisies d 
    WHERE
        a.pid = b.pid 
        AND a.ref_id = c.id 
        AND a.ref_id = $request->divisi
        AND d.kode = a.divisi_id 
        AND a.divisi_id = 'BRG'  
        AND a.date BETWEEN '$tanggal' 
        AND '$tanggal2'");
        
        return view('admin.pay.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi','pay'])); 
        // return response()->json($pay->upah);
    }
}
