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

class GajiController extends Controller
{
    function index(Request $request){
        $a = $request->flash();
        $dt = $request->old('tanggal2');
        Session::put('name',$request->old('tanggal2'));
        $value = Session::get('name');      

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
                AND a.ref_id = 62
                AND d.kode = a.divisi_id 
                AND a.divisi_id = 'BRG'  
                AND a.date ='$tanggal2'");
                return view('admin.gaji.index', compact(['pay','tanggal2', 'tanggal', 'date', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi']));
  

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
            AND d.kode = a.divisi_id 
            AND a.divisi_id = 'BRG'  
            AND a.date BETWEEN '$tanggal' 
            AND '$tanggal2'");
            return view('admin.gaji.index', compact([ 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi','pay']));
        }else{

            // return response()->json($request->all());
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
            
            $absensi = DB::select(
                "SELECT
                afh.id,
                afh.pid,
                p.nama,
                afh.check_in,
                afh.check_out,
                a.nama AS divisi,
                DATE(afh.sync_date) as tanggal,
            IF
                (
                    SUBTIME( afh.check_in, '$refer->workin' ) < ' 00:00:00',
                    '00:00:00',
                SUBTIME( afh.check_in, '$refer->workin' )) AS telat,
            IF
                (
                    afh.check_out < '$refer->workout',
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workin' ), '%k' ),
                DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) AS jam_kerja,
            IF
                (
                IF
                    (
                        afh.check_out < '$refer->workout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workin' ), '%k' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) > 0,
                    1,
                    0 
                ) AS jumlah_hari,
            IF
                (
                IF
                    (
                        afh.check_out < '$refer->workout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workin' ), '%k' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) >= 8,
                    100000 *
                IF
                    (
                    IF
                        (
                            afh.check_out < '$refer->workout',
                            DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workin' ), '%k' ),
                        DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' )) > 0,
                        1,
                        0 
                    ),
                    100000 / 8 *
                IF
                    (
                        afh.check_out < '$refer->workout',
                        DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workin' ), '%k' ),
                    DATE_FORMAT(( SUBTIME( afh.check_out, afh.check_in )), '%k' ))) AS upah,
            IF
                (
                    DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' ) <= 0,
                    0,
                DATE_FORMAT( SUBTIME( '$refer->workin', afh.check_in ), '%k' )) AS lembur_awal,
            IF
                (
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' )<= 0,
                    0,
                DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' )) AS lembur_akhir,
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
                    DATE_FORMAT( SUBTIME( afh.check_out, '$refer->workout' ), '%k' ))) AS total_lembur,
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
                AND DATE( afh.sync_date ) BETWEEN '$tanggal' 
                AND '$tanggal2' 
                AND p.ref_id = b.id 
                AND b.id = '$request->divisi' 
                AND a.kode = p.divisi_id 
                AND a.kode = 'BRG' 
            ORDER BY
                afh.id DESC"
            );
            // return response()->json($absensi);
            $pay = DB::select("SELECT
            a.id,
            a.pid,
            b.nama,
            e.check_in,
            e.check_out,
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
            absensi_fingerprint.gaji a,
            absensi_fingerprint.pegawais b,
            absensi_fingerprint.referensikerjas c,
            absensi_fingerprint.divisies d,
						absensi_frhistory.202302HISTORY e 
        WHERE
			a.pid = e.pid and 
            a.pid = b.pid 
            AND a.ref_id = c.id 
            AND a.ref_id = $request->divisi
            AND d.kode = a.divisi_id 
            AND a.divisi_id = 'BRG'  
            AND a.date BETWEEN '$tanggal' 
            AND '$tanggal2'
            ");
            
            // return response()->json($absensi); 
            foreach($absensi as $data){
                // $g = DB::select(" select * from gaji where pid = '20973' and date BETWEEN '2022-11-23' and '2022-11-23'");
                // $gaji = DB::connection('mysql')->table('gaji')->where([['pid',$data->pid]])->wherebetween('date',[$tanggal,$tanggal2])->first();
                $gaji = (object)Gaji::where([['pid',$data->pid]])->wherebetween('date',[$tanggal,$tanggal2])->first();  
                // $absen = $absensi->where('id',$data->id)->first();             
                // return response()->json($gaji->check_out == null);
                
            if($gaji->pid = $data->pid  && isset($data->tanggal) == isset($gaji->date)){
                // return response()->json($gaji->checkout);
                // $gaji->check_out == null || $gaji->check_in == null
            }else{
                $gaji = DB::connection('mysql')->table('gaji')->insert([
                    'pid' =>$data->pid , 
                    'check_in' =>$data->check_in , 
                    'check_out' =>$data->check_out , 
                    'divisi_id' => 'BRG', 
                    'ref_id' => $request->divisi, 
                    'date' =>$data->tanggal , 
                    'telat' =>$data->telat , 
                    'jam_kerja' =>$data->jam_kerja , 
                    'jum_hari' =>$data->jumlah_hari , 
                    'lembur_aw' =>$data->lembur_awal , 
                    'lembur_ak' =>$data->lembur_akhir , 
                    'tot_lembur' =>$data->total_lembur , 
                    'upah' =>$data->upah , 
                    'total_upah' =>$data->upah, 
                    'ket' =>$data->Keterangan , 
                    'created_at' =>Carbon::now() , 
                    'updated_at' =>Carbon::now() 

             ]);
            }
            // return response()->json(empty($gaji));
            if(!empty($gaji)){
                $gaji = (object)Gaji::where([['pid',$data->pid]])->wherebetween('date',[$tanggal,$tanggal2])->first();
                // return response()->json($gaji);
            if($gaji->check_in == null || $gaji->check_out == null || $gaji->check_in == '00:00:00' || $gaji->check_out == '00:00:00' ){
                $gaji = DB::connection('mysql')->table('gaji')->where('pid',$data->pid)->update([
                    'pid' =>$data->pid , 
                    'check_in' =>$data->check_in , 
                    'check_out' =>$data->check_out , 
                    'divisi_id' => 'BRG', 
                    'ref_id' => $request->divisi, 
                    'date' =>$data->tanggal , 
                    'telat' =>$data->telat , 
                    'jam_kerja' =>$data->jam_kerja , 
                    'jum_hari' =>$data->jumlah_hari , 
                    'lembur_aw' =>$data->lembur_awal , 
                    'lembur_ak' =>$data->lembur_akhir , 
                    'tot_lembur' =>$data->total_lembur , 
                    'upah' =>$data->upah , 
                    'total_upah' =>$data->upah, 
                    'ket' =>$data->Keterangan , 
                    'created_at' =>Carbon::now() , 
                    'updated_at' =>Carbon::now() 

             ]);
            }else{
                // return response()->json($request->lm);
            //     $gaji = DB::connection('mysql')->table('gaji')->where('pid',$data->pid)->update([
            //         'pid' =>$data->pid , 
            //         'check_in' =>$data->check_in , 
            //         'check_out' =>$data->check_out , 
            //         'divisi_id' => 'BRG', 
            //         'ref_id' => $request->divisi, 
            //         'date' =>$data->tanggal , 
            //         'telat' =>$data->telat , 
            //         'jam_kerja' =>$data->jam_kerja , 
            //         'jum_hari' =>$data->jumlah_hari , 
            //         'lembur_aw' =>$data->lembur_awal , 
            //         'lembur_ak' =>$data->lembur_akhir , 
            //         'tot_lembur' =>$data->total_lembur , 
            //         'upah' =>$data->upah , 
            //         'total_upah' =>$data->upah, 
            //         'ket' =>$data->Keterangan , 
            //         'created_at' =>Carbon::now() , 
            //         'updated_at' =>Carbon::now() 

            //  ]);
            }
        }
        }
            return view('admin.gaji.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi','pay'])); 
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
        
        return view('admin.gaji.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName', 'refin', 'refout', 'divisi','referensi','pay'])); 
        // return response()->json($pay->upah);
    }
}
