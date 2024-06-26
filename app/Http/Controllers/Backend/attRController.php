<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\AbsenLog;
use App\Models\AbsenMentah;
use App\Models\HariKerja;
use App\Models\Jadwal;
use App\Models\Mesin;
use App\Models\Pegawai;
use App\Models\ReferensiKerja;
use App\Models\ReguKerja;
use App\Models\ShiftKerja;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use ZKLibrary;

class attRController extends Controller
{
    function index(Request $request){
        if($request->method() == 'GET'){
            $date = Carbon::now()->format('Y-m-d');
            $tanggal = Carbon::now()->format('d F Y');
            $tanggalCetak = Carbon::now()->format('Y-m-d');
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            $dbName = $year . str_pad($month, 2, '0', STR_PAD_LEFT).'HISTORY';

            // $absensi = Absen::all();
            $date = Carbon::now()->format('Y-m-d');
            $absensi = DB::select(
                "SELECT afh.id,afh.pid, p.nama, p.departement, afh.check_in, afh.check_out, afh.telat, afh.izin, afh.check_in1, afh.check_out1, afh.check_in2, afh.check_out2, afh.check_in3, afh.check_out3, afh.sync_date, afh.absen1, afh.absen2
                FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                WHERE p.pid = afh.pid AND DATE(afh.sync_date) = '$date'
                ORDER BY afh.id DESC"
            );
            return view('admin.absensi.index', compact(['absensi', 'tanggal', 'date', 'tanggalCetak', 'dbName']));
        }else{
            $date = Carbon::now()->format('Y-m-d');
            $year = date('Y', strtotime($request->tanggal));
            $month = date('m', strtotime($request->tanggal));
            $dbName = $year . str_pad($month, 2, '0', STR_PAD_LEFT).'HISTORY';
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            $tanggal2 = date('Y-m-d', strtotime($request->tanggal2));
            $tanggalCetak = date('Y-m-d', strtotime($request->tanggal));
            // return response()->json($tanggal);
            // $absensi = Absen::all();
            $absensi = DB::select(
                "SELECT afh.id,afh.pid, p.nama, p.departement, afh.check_in, afh.check_out, afh.telat, afh.izin, afh.check_in1, afh.check_out1, afh.check_in2, afh.check_out2, afh.check_in3, afh.check_out3, afh.sync_date, afh.absen1, afh.absen2
                FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2'
                ORDER BY afh.id DESC"
            );

            return view('admin.absensi.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName']));
        }
    }

    function syncData(Request $request){
        $tanggal    = $request->tanggal;
        $tanggal2   = $request->tanggal2;
        $mesin      = Mesin::where('is_default', 1)->first();
        $year       = Carbon::now()->format('Y');
        // $year4      = strtotime($year) + strtotime("-1 years");
        // $year4      = date('Y', strtotime($year. ' - 1 years'));
        // $year4      = date('Y' , $year4);
        $month      = Carbon::now()->format('m');
        
        // $month4     = strtotime($month) + strtotime("-1 month");
        // $month4     = date('m', $month4);
        $month4 = Carbon::now()->format('m');
        $month4 = $month4 - 1;
        $month4 = "0".$month4;
        $dbName = $year . str_pad($month, 2, '0', STR_PAD_LEFT).'HISTORY';
        // $dbName     = $year .''. $month4.'HISTORY';
        // return response()->json($dbName);

        // $month4 = Carbon::now()->format('m');
        // $month4 = date('m', $month4);
        if($month == 1){
            $year       = Carbon::now()->format('Y');
        // $year4      = strtotime($year) + strtotime("-1 years");
            $year4      = date('Y', strtotime($year. ' - 1 years'));
        }else{
            $year4      = Carbon::now()->format('Y');;
        }
        // return response()->json($year4);
        $dbName4 = $year4 . str_pad($month4, 2, '0', STR_PAD_LEFT).'HISTORY';
        $port       = 4370;
        // return response()->json($dbName4);
        $zk         = new ZKLibrary($mesin->tcpip,$port);
        $zk->connect();
        $log        = $zk->getAttendance();
        // return response()->json($log);
        // dd($log);

        if(!empty($log) == true){
            foreach($log as $data){
                $countData  = count($log) - 1;
                $checkAbsen = count(AbsenMentah::where(DB::raw('DATE(date)'), date('Y-m-d',strtotime($data[3])))->get());
                // return response()->json($checkAbsen);
                    if($checkAbsen === 0 || is_null($checkAbsen)){
                        for($i = 0 ; $i <= $countData ; $i++){
                            AbsenMentah::insert([
                                'pid'           => $log[$i][1],
                                'status'        => $log[$i][2],
                                'date'          => $log[$i][3],
                                'created_at'    => Carbon::now(),
                                'updated_at'    => Carbon::now(),
                            ]);
                        }
                    }                    
                }
                 if(strtotime($tanggal) === strtotime($tanggal2)){
                     $absenMentah = AbsenMentah::where(DB::raw('DATE(date)'), $tanggal)->get();
                 }else{
                     $absenMentah = AbsenMentah::whereBetween(DB::raw('DATE(date)'), [$tanggal, $tanggal2])->get();
                 }    
                // return response()->json($checkAbsen);
               // if(strtotime('2023-03-29') === strtotime('2023-03-29')){
                 //   $absenMentah = AbsenMentah::where(DB::raw('DATE(date)'), '2023-03-29')->get();
                //}else{
                  //  $absenMentah = AbsenMentah::whereBetween(DB::raw('DATE(date)'), ['2023-03-29', '2023-03-29'])->get();
               // }
                // return response()->json($absenMentah);
                if(!is_null($absenMentah)){
                    foreach($absenMentah as $row){
                        $checkDate  = date('Y-m-d' , strtotime($row->date));
                        $checkPegawai = DB::select("
                        SELECT db.* FROM absensi_frhistory.$dbName db
                        WHERE db.pid = '$row->pid' AND DATE(db.sync_date) = '$checkDate'
                        ");
                        $checkPegawai4 = DB::select("
                        SELECT db.* FROM absensi_frhistory.$dbName4 db
                        WHERE db.pid = '$row->pid' AND DATE(db.sync_date) = '$checkDate'
                        ");
                        // return response()->json($dbName);
                        if($checkPegawai === null || empty($checkPegawai) || $checkPegawai == ''){
                            // return response()->json($checkPegawai);
                            $pegawai    = Pegawai::where('pid', $row->pid)->first();
                            $ref = ReferensiKerja::where('id',$pegawai->ref_id)->first();
                            // return response()->json($ref);
                            // if(!empty()){

                            // }
                        if(!is_null($pegawai)){
                            // return response()->json($pegawai);          
                            $clock      = date('H:i:s' , strtotime($row->date));
                            // return response()->json(empty($ref));
                            if(empty($ref)){
                                if($row->status == 0 || $row->status == 4){
                                    // return response()->json(empty($ref));
                                    DB::connection('mysql2')->table($dbName)->insert([
                                        'pid'       => $row->pid,
                                        'sap'       => $pegawai->sap,
                                        'check_in'  => $clock,
                                        'telat'     => '00:00:00',
                                        'sync_date' => $row->date,
                                        'updated_at' => Carbon::now()
                                    ]);
                                    // return response()->json($a);
                                }elseif($row->status == 1 || $row->status == 5){
                                    DB::connection('mysql2')->table($dbName)->insert([
                                        'pid'       => $row->pid,
                                        'sap'       => $pegawai->sap,
                                        'check_out'  => $clock,
                                        'telat'     => '00:00:00',
                                        'sync_date' => $row->date,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                               
                            }elseif(!empty($ref)){
                            if($row->status == 0 || $row->status == 4){
                                // return response()->json($row->status);
                                DB::connection('mysql2')->table($dbName)->insert([
                                    'pid'       => $row->pid,
                                    'sap'       => $pegawai->sap,
                                    'check_in'  => $clock,
                                    'check_in1' => $ref->workin, 
                                    'check_out1' => $ref->workout,
                                    'telat'     => '00:00:00',
                                    'sync_date' => $row->date,
                                    'updated_at' => Carbon::now()
                                ]);
                            }elseif($row->status == 1 || $row->status == 5){
                                DB::connection('mysql2')->table($dbName)->insert([
                                    'pid'       => $row->pid,
                                    'sap'       => $pegawai->sap,
                                    'check_out'  => $clock, 
                                    'check_in1' => $ref->workin, 
                                    'check_out1' => $ref->workout,                                   
                                    'telat'     => '00:00:00',
                                    'sync_date' => $row->date,
                                    'updated_at' => Carbon::now()
                                ]);
                            }
                        }
                        
                    }
                    // return response()->json($pegawai);
                    }else{   
                        $checkAbsen = DB::connection('mysql2')->table($dbName)->where([
                            ['pid', $row->pid],
                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))]
                        ])->first();
                        // $i = date('Y-m-d', strtotime($row->date));
                            // return response()->json($i);
                    $pegawai    = Pegawai::where('pid', $row->pid)->first();
                    // return response()->json($pegawai);
                    if(!is_null($pegawai)){  
                    $clock      = date('H:i:s' , strtotime($row->date));
                    // return response()->json($clock);
                    if(empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && $row->status == 0 || $row->status == 4){
                        DB::connection('mysql2')->table($dbName)->where([
                            ['pid', $row->pid],
                            [DB::raw('DATE(sync_date)' ), date('Y-m-d',strtotime($row->date))]
                        ])->update([
                            'check_in'  => $clock,
                            'sync_date' => $row->date,
                            'updated_at' => Carbon::now()
                        ]);

                    }elseif(empty($checkAbsen->check_out) &&!empty($checkAbsen->check_in && $row->status == 1 || $row->status == 5)){
                        DB::connection('mysql2')->table($dbName)->where([
                            ['pid', $row->pid],
                            [DB::raw('DATE(sync_date)' ), date('Y-m-d',strtotime($row->date))]
                        ])->update([
                            'check_out'  => $clock,
                            'sync_date' => $row->date,
                            'updated_at' => Carbon::now()
                        ]);
                       }                     
                    }
                        // return response()->json($pegawai->sap);
                }
                

                if($checkPegawai4 === null || empty($checkPegawai4) || $checkPegawai4 == ''){
                    // return response()->json($checkPegawai);
                    $pegawai    = Pegawai::where('pid', $row->pid)->first();
                if(!is_null($pegawai)){                            
                    $clock      = date('H:i:s' , strtotime($row->date));
                    if($row->status == 0 || $row->status == 4){
                        DB::connection('mysql2')->table($dbName4)->insert([
                            'pid'       => $row->pid,
                            'sap'       => $pegawai->sap,
                            'check_in'  => $clock,
                            'telat'     => '00:00:00',
                            'sync_date' => $row->date,
                            'updated_at' => Carbon::now()
                        ]);
                    }else{
                        DB::connection('mysql2')->table($dbName4)->insert([
                            'pid'       => $row->pid,
                            'sap'       => $pegawai->sap,
                            'check_out'  => $clock,
                            'telat'     => '00:00:00',
                            'sync_date' => $row->date,
                            'updated_at' => Carbon::now()
                        ]);
                    }
                }
            }else{   
                $checkAbsen = DB::connection('mysql2')->table($dbName4)->where([
                    ['pid', $row->pid],
                    [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))]
                ])->first();
                    // return response()->json($checkAbsen);
            $pegawai    = Pegawai::where('pid', $row->pid)->first();
            // return response()->json($pegawai);
            if(!is_null($pegawai)){  
            $clock      = date('H:i:s' , strtotime($row->date));
            // return response()->json($clock);
            if(empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && $row->status == 0 || $row->status == 4){
                DB::connection('mysql2')->table($dbName4)->where([
                    ['pid', $row->pid],
                    [DB::raw('DATE(sync_date)' ), date('Y-m-d',strtotime($row->date))]
                ])->update([
                    'check_in'  => $clock,
                    'sync_date' => $row->date,
                    'updated_at' => Carbon::now()
                ]);

            }elseif(empty($checkAbsen->check_out)&& !empty($checkAbsen->check_in && $row->status == 1 || $row->status == 5)){
                DB::connection('mysql2')->table($dbName4)->where([
                    ['pid', $row->pid],
                    [DB::raw('DATE(sync_date)' ), date('Y-m-d',strtotime($row->date))]
                ])->update([
                    'check_out'  => $clock,
                    'sync_date' => $row->date,
                    'updated_at' => Carbon::now()
                ]);
               }                     
            }   
                // return response()->json($pegawai->sap);
        }


                
                }
            }
                $absenMentah = DB::select("
                DELETE FROM absen_mentahs
                ");

                AbsenLog::insert([
                    'mesin_id'      => $mesin->id,
                    'status_absen'  => 'Tarik Absen',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ]);
            }else{
                Session::put('sweetalert', 'error');
                return response()->json(['error' => 'Gagal Import Absensi ! Mungkin data sudah terhapus !']);
            }
        }
    }
