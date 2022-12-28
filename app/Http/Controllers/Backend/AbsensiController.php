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
use Carbon\Carbon;
// use Dotenv\Validator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use ZKLibrary;


class AbsensiController extends Controller
{
    function index(Request $request){
        // return csrf_token();
        if($request->method() == 'GET'){
            $date = Carbon::now()->format('Y-m-d');
            $tanggal = Carbon::now()->format('d F Y');
            $tanggalCetak = Carbon::now()->format('Y-m-d');
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            $dbName = $year.''.$month.'HISTORY';

            // $absensi = Absen::all();
            $date = Carbon::now()->format('Y-m-d');
            $absensi = DB::select(
                "SELECT afh.id,afh.pid, p.nama, p.departement, afh.check_in, afh.check_out, afh.telat, afh.izin, afh.check_in1, afh.check_out1, afh.check_in2, afh.check_out2, afh.check_in3, afh.check_out3, afh.sync_date, afh.absen1, afh.absen2
                FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                WHERE p.pid = afh.pid AND DATE(afh.sync_date) = '$date'
                ORDER BY afh.id DESC"
            );

            return view('admin.absensi.index', compact(['absensi', 'tanggal', 'date', 'tanggalCetak', 'dbName']));
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
                "SELECT afh.id,afh.pid, p.nama, p.departement, afh.check_in, afh.check_out, afh.telat, afh.izin, afh.check_in1, afh.check_out1, afh.check_in2, afh.check_out2, afh.check_in3, afh.check_out3, afh.sync_date, afh.absen1, afh.absen2
                FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2'
                ORDER BY afh.id DESC"
            );

            return view('admin.absensi.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName']));
        }
    }

    function syncData(Request $request){
        $tanggal = $request->tanggal;
        $tanggal2 = $request->tanggal2;

        $mesin  = Mesin::where('is_default', 1)->first();
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $dbName = $year.''.$month.'HISTORY';
        $port = 4370;

        $zk = new ZKLibrary($mesin->tcpip, $port);
        $zk->connect();
        $log_kehadiran = $zk->getAttendance();
        return response()->json($log_kehadiran);


        if(!empty($log_kehadiran) == true){
            // return response()->json($tanggal);
            foreach($log_kehadiran as $data){
                $countData = count($log_kehadiran) - 1;
                $checkAbsen = COUNT(AbsenMentah::where(DB::raw('DATE(date)'), date('Y-m-d', strtotime($data[3])))->get());
                // return response()->json($data[3]);
                if($checkAbsen === 0 || is_null($checkAbsen)){
                    for($i = 0; $i <= $countData; $i++){
                        AbsenMentah::insert([
                            'pid'           => $log_kehadiran[$i][1],
                            'status'        => $log_kehadiran[$i][2],
                            'date'          => $log_kehadiran[$i][3],
                            'created_at'    => Carbon::now(),
                            'updated_at'    => Carbon::now()
                        ]);
                    }
                }
                // return response()->json($log_kehadiran[1][3]);
                
            }

            if(strtotime($tanggal) === strtotime($tanggal2)){
                $absenMentah = AbsenMentah::where(DB::raw('DATE(date)'), $tanggal)->get();
            }else{
                $absenMentah = AbsenMentah::whereBetween(DB::raw('DATE(date)'), [$tanggal, $tanggal2])->get();
            }
            
            // if(strtotime('2022-11-09') === strtotime('2022-11-09')){
            //     $absenMentah = AbsenMentah::where(DB::raw('DATE(date)'), '2022-11-09')->get();
            // }else{
            //     $absenMentah = AbsenMentah::whereBetween(DB::raw('DATE(date)'), ['2022-11-09', '2022-11-09'])->get();
            // }
	    // return response()->json($absenMentah);

            if(!is_null($absenMentah)){
                foreach($absenMentah as $row){
                    $checkDate = date('Y-m-d', strtotime($row->date));

                    $checkPegawai = DB::select("
                        SELECT db.* 
                        FROM absensi_frhistory.$dbName db
                        WHERE db.pid = '$row->pid' AND DATE(db.sync_date) = '$checkDate'
                    ");

                //     $checkPegawai = DB::select("
                //     SELECT db.* 
                //     FROM absensi_frhistory.202211HISTORY db
                //     WHERE db.pid = '511' AND DATE(db.sync_date) = '2022-11-07'
                // ");
                    // return response()->json($checkPegawai);
                    if($checkPegawai === null || empty($checkPegawai) || $checkPegawai == ''){
                        $pegawai = Pegawai::where('pid', $row->pid)->first();
                        // return response()->json($pegawai);
                        if(!is_null($pegawai)){
                            // Check regukerja_id is not null
                            if(!empty($pegawai->regukerja_id) || $pegawai->regukerja_id != 'null' || $pegawai->regukerja_id != null){
                                 $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                                //  return response()->json($reguKerja);
				 // $reguKerja = ReguKerja::where('kode', 'R. A')->first();

                                if($reguKerja != null){
                                    if($reguKerja->kode === 'Default' || $reguKerja->kode === 'DEFAULT'){
                                        $clock = date('H:i:s', strtotime($row->date));
                                        DB::connection('mysql2')->table($dbName)->insert([
                                            'pid'       => $row->pid,
                                            'sap'       => $pegawai->sap,
                                            'absen1'    => $clock,
                                            'telat'     => '00:00:00',
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }else{
                                        $awal  = date_create($reguKerja->tgl_start);
                                        // return response()->json($awal);
                                        $akhir = date_create($row->date); // waktu sekarang
                                        // return response()->json($akhir);
                                        $diff  = date_diff( $awal, $akhir );
                                        // return response()->json($diff);
                                        $hari = $diff->days % $reguKerja->hari;
                                        // return response()->json($hari);
                                        if($hari === 0){
                                            $hari = $reguKerja->hari;
                                            // return response()->json($hari);
                                        }
                                        // Get Jadwals
                                        $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                                        // return response()->json($jadwal);
                                        // Get Ref Kerja
                                        $refKerja = ReferensiKerja::where('kode', $jadwal[$hari])->first();
                                            // return response()->json([$refKerja, $hari]);
                                            // if(!$refKerja){
                                            //     $clock = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                                            // }
                                            //     $clock = ReferensiKerja::where('kode', $jadwal[$hari])->first();
                                            // return response()->json($clock);
                                        // Get Time in row

                                        // $checkAbsen = DB::connection('mysql2')->table('202211HISTORY')->where([
                                        //     ['pid', '566'],
                                        //     [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime('2022-11-08'))]
                                        // ])->first();
                                        // return response()->json($checkAbsen);
                                        $clock = date('H:i:s', strtotime($row->date));
                                        // return response()->json($clock);

                                        // $checkAbsen = DB::connection('mysql2')->table($dbName)->where([
                                        //     ['pid', $row->pid],
                                        //     [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))]
                                        // ])->first();
                                        // return response()->json($checkAbsen);

                                        // Get Time - 1 hour before workin
                                        if(!$refKerja){
                                            $workInBefore = date('H:i:s', (strtotime('08:00:00') - strtotime('01:00:00')));
                                            $workOutBefore = date('H:i:s', (strtotime('17:00:00') - strtotime('01:00:00')));
                                            if($clock >= $workInBefore){
                                                DB::connection('mysql2')->table($dbName)->insert([
                                                    'pid'       => $row->pid,
                                                    'sap'       => $pegawai->sap,
                                                    'absen1'    => $clock,
                                                    'telat'     => '00:00:00',
                                                    'sync_date'=>   $row->date,
                                                    'updated_at'=> Carbon::now()
                                                ]);
                                            }elseif($clock >= $workOutBefore){
                                                DB::connection('mysql2')->table($dbName)->insert([
                                                    'pid'       => $row->pid,
                                                    'sap'       => $pegawai->sap,
                                                    'absen2'    => $clock,
                                                    'telat'     => '00:00:00',
                                                    'sync_date'=>   $row->date,
                                                    'updated_at'=> Carbon::now()
                                                ]);
                                            }
                                        }else{
                                            $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
                                            $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));
                                            // 3 jam sebelum in atau out
                                            $workin3=date('H:i:s', (strtotime($refKerja->workin) - strtotime('03:00:00')));
                                            $workout3=date('H:i:s', (strtotime($refKerja->workout) - strtotime('03:00:00')));
                                            // $yono= $refKerja->workout;
                                            // return response()->json($yono);
                                            if($clock <= $refKerja->workout && $clock >= $workInBefore){
                                                // return response()->json($clock);
                                                if($clock >= $refKerja->workin){     
                                                    // return response()->json($clock);                           // When Late Work in
                                                    $timeLate = strtotime($clock) - strtotime($refKerja->workin);
                                                    $late = date('H:i:s', $timeLate);
                                                    DB::connection('mysql2')->table($dbName)->insert([
                                                        'pid'       => $row->pid,
                                                        'sap'       => $pegawai->sap,
                                                        'check_in'  => $clock,
                                                        'telat'     => $late,
                                                        'sync_date'=>   $row->date,
                                                        'updated_at'=> Carbon::now()
                                                    ]);
                                                }else{                                                          // When Not Late
                                                    DB::connection('mysql2')->table($dbName)->insert([
                                                        'pid'       => $row->pid,
                                                        'sap'       => $pegawai->sap,
                                                        'check_in'  => $clock,
                                                        'telat'     => '00:00:00',
                                                        'sync_date'=>   $row->date,
                                                        'updated_at'=> Carbon::now()
                                                    ]);
                                                }
                                            }elseif($clock >= $refKerja->workout && $clock >= $workOutBefore){
                                                DB::connection('mysql2')->table($dbName)->insert([ 
                                                    'pid'       => $row->pid,
                                                    'sap'       => $pegawai->sap,
                                                    'check_out'  => $clock,
                                                    'telat'     => '00:00:00',
                                                    'sync_date'=>   $row->date,
                                                    'updated_at'=> Carbon::now()
                                                ]);
                                                
                                            // }elseif($clock >=$workin3 && $clock <=$workout3){                                                     
                                            //         $timeFast = abs(strtotime($clock) - strtotime($refKerja->workin));
                                            //         $fast = date('H:i:s', $timeFast);
                                            //     DB::connection('mysql2')->table($dbName)->insert([
                                            //         'pid'       => $row->pid,
                                            //         'sap'       => $pegawai->sap,
                                            //         'check_in'  => $clock,
                                            //         'cepat'     => $fast,
                                            //         'sync_date'=>   $row->date,
                                            //         'updated_at'=> Carbon::now()
                                            //     ]);
                                            // }else{
                                            //     $timeFast = abs(strtotime($clock) - strtotime($refKerja->workout));
                                            //     $fast = date('H:i:s', $timeFast);
                                            //     DB::connection('mysql2')->table($dbName)->insert([
                                            //         'pid'       => $row->pid,
                                            //         'sap'       => $pegawai->sap,
                                            //         'check_out'  => $clock,
                                            //         'cepat'     => $fast,
                                            //         'sync_date'=>   $row->date,
                                            //         'updated_at'=> Carbon::now()
                                            //      ]);
                                            }
                                        }
                                        // dd($clock >= $refKerja->workin);
                                        // dd($clock >= $refKerja->workout && $clock >= $workOutBefore);
                                    }
                                }
                            }
                        }

                    }else{
                        $pegawai = Pegawai::where('pid', $row->pid)->first();                        
                        // return response()->json($pegawai);
                        if(!is_null($pegawai)){
                            if(!empty($pegawai->regukerja_id) || $pegawai->regukerja_id != 'null' || $pegawai->regukerja_id != null){
                                $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();

				if($reguKerja != null){
                                // Range date start and date request in machine
                                $tglStart = strtotime($reguKerja->tgl_start);
                                $tglReq = strtotime($row->date);
                                
                                $range = $tglReq - $tglStart;
                                $range = $range / 60 /60 /24;
                                $hari  = $range%$reguKerja->hari;
                                if($hari === 0){
                                    $hari = $reguKerja->hari;
                                }
        
                                // Get Jadwals
                                $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                                // Get Ref Kerja
                                $refKerja = ReferensiKerja::where('kode', $jadwal[$hari])->first();
                                // Get Time in row
                                $clock = date('H:i:s', strtotime($row->date));
                                // Get Time - 1 hour before workin
                                $checkAbsen = DB::connection('mysql2')->table($dbName)->where([
                                    ['pid', $row->pid],
                                    [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))]
                                ])->first();

                                if(!$refKerja){
                                    $workInBefore = date('H:i:s', (strtotime('08:00:00') - strtotime('01:00:00')));
                                    $workOutBefore = date('H:i:s', (strtotime('17:00:00') - strtotime('01:00:00')));

                                    if($clock >= $workInBefore){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'pid'       => $row->pid,
                                            'sap'       => $pegawai->sap,
                                            'absen1'    => $clock,
                                            'telat'     => '00:00:00',
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }elseif($clock >= $workOutBefore){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'pid'       => $row->pid,
                                            'sap'       => $pegawai->sap,
                                            'absen2'    => $clock,
                                            'telat'     => '00:00:00',
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }
                                }else{
                                    $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
                                    $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));

                                    if(!empty($checkAbsen->check_in) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'check_out'  => $clock,
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out)){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'check_in1'  => $clock,
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'check_out1'  => $clock,
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1)){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'check_in2'  => $clock,
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1) && !empty($checkAbsen->check_in2) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'check_out2'  => $clock,
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1) && !empty($checkAbsen->check_in2) && !empty($checkAbsen->check_out2)){
                                        DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'check_in3'  => $clock,
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }elseif(!empty($checkAbsen->check_out) && $clock <= $refKerja->workout && $clock >= $workInBefore){
                                        $test = DB::connection('mysql2')->table($dbName)->where([
                                            ['pid', $row->pid],
                                            [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                        ])->update([
                                            'check_in'  => $clock,
                                            'sync_date'=>   $row->date,
                                            'updated_at'=> Carbon::now()
                                        ]);
                                    }else{
                                        if(!empty($checkAbsen->check_in3) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                            DB::connection('mysql2')->table($dbName)->where([
                                                ['pid', $row->pid],
                                                [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                            ])->update([
                                                'check_out3'  => $clock,
                                                'sync_date'=>   $row->date,
                                                'updated_at'=> Carbon::now()
                                            ]);
                                        }elseif(!empty($checkAbsen->absen1)){
                                            DB::connection('mysql2')->table($dbName)->where([
                                                ['pid', $row->pid],
                                                [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                            ])->update([
                                                'pid'       => $row->pid,
                                                'sap'       => $pegawai->sap,
                                                'absen2'    => $clock,
                                                'telat'     => '00:00:00',
                                                'sync_date'=>   $row->date,
                                                'updated_at'=> Carbon::now()
                                            ]);
                                        }
                                    }
				}
                                }
                            }
                        }
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
            return response()->json(['errors' => 'Gagal Import Data Absensi! Mungkin data sudah terhapus!']);
        }
    }

    function create(){
        $pegawai=Pegawai::all();
        return view('admin.absensi.create',compact(['pegawai']));
    }
    function store(Request $request){

        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        // ***** GET 5 MONTH BEFORE ***** //
        $month4 = strtotime($month) + strtotime("-1 month");
        $month4 = date('m', $month4);
        $month3 = strtotime($month) + strtotime("-2 month");
        $month3 = date('m', $month3);
        $month2 = strtotime($month) + strtotime("-3 month");
        $month2 = date('m', $month2);
        $month1 = strtotime($month) + strtotime("-4 month");
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

        $this->validate($request,[
            'pid'       => 'required',
            'sap'       => 'max:20',
            'check_in'  => 'required',
            'check_out' => 'required',
            'telat'     =>'max:20',
            'check_in1'  => 'max:20',
            'check_out1' => 'max:20',
            'check_in2'  => 'max:20',
            'check_out2' => 'max:20',
            'check_in3'  => 'max:20',
            'check_out3' => 'max:20',
            'absen1'    =>'max:20',
            'absen2'    => 'max:20',
            'sync_date' => 'required',
            'izin' => 'max:20'],
            [
                'pid.required'         =>  'PID Harus Diisi!',
                'sap.required'          =>  'SAP Harus Diisi!',
                'check_in.required'         =>  'Check In Harus Diisi!',
                'check_out.required'          =>  'Check Out Diisi!'
            ]);
        $absen = DB::connection('mysql2')->table($dbName)->insert([
            'pid'       => $request->pid,
            'sap'       => $request->sap,
            'check_in'  =>  $request->check_in,
            'check_out' => $request->check_out,
            'telat'     =>  $request->telat,
            'check_in1'  => $request->check_in1,
            'check_out1' => $request->check_out1,
            'check_in2'  => $request->check_in2,
            'check_out2' => $request->check_out2,
            'check_in3'  => $request->check_in3,
            'check_out3' => $request->check_out3,
            'absen1'    => $request->absen1,
            'absen2'    => $request->absen2,
            'izin'      => $request->izin,
            'sync_date'    => $request->sync_date,
            'updated_at'    => Carbon::now()
            
        ]);          
        Session::put('sweetalert', 'success');
        return redirect()->route('addAbsen')->with('alert', 'Sukses Menambahkan Data');
    }


    function edit(request $request,$id,$pid,$date){        
        $in      = $request->check_in;        
        $out     = $request->check_out;        
        // return response()->json($date);
        $year   = Carbon::now()->format('Y');
        $month  = Carbon::now()->format('m');                
             
        $month4 = strtotime($month) + strtotime("-1 month");
        $month4 = date('m', $month4);
        $month3 = strtotime($month) + strtotime("-2 month");
        $month3 = date('m', $month3);
        $month2 = strtotime($month) + strtotime("-3 month");
        $month2 = date('m', $month2);
        $month1 = strtotime($month) + strtotime("-4 month");
        $month1 = date('m', $month1);
        
        $dbName = $year.''.$month.'HISTORY';
        $dbName4 = $year.''.$month4.'HISTORY';
        $dbName3 = $year.''.$month3.'HISTORY';
        $dbName2 = $year.''.$month2.'HISTORY';
        $dbName1 = $year.''.$month1.'HISTORY';

        // $absen   = DB::connection('mysql2')->table($dbName)
        // ->select(DB::raw());
        
        $dbCheck4 = Schema::connection('mysql2')->hasTable($dbName4);
        // return response()->json($dbCheck4);
        $dbCheck3 = Schema::connection('mysql2')->hasTable($dbName3);
        $dbCheck2 = Schema::connection('mysql2')->hasTable($dbName2);
        $dbCheck1 = Schema::connection('mysql2')->hasTable($dbName1);
        // return response()->json($dbCheck4);        
        // $absensi = DB::connection('mysql2')->table($dbName)->where('id',$id)->first(); 
        $Absensi = DB::connection('mysql2')->table($dbName)->where([
            ['id',$id],
            [DB::raw('DATE(sync_date)'),$date]])->first(); 

        $Absensi4 = DB::connection('mysql2')->table($dbName4)->where([
            ['id',$id],
            [DB::raw('DATE(sync_date)'),$date]])->first();

        $Absensi3 = DB::connection('mysql2')->table($dbName4)->where([
                ['id',$id],
                [DB::raw('DATE(sync_date)'),$date]])->first(); 

        $Absensi2 = DB::connection('mysql2')->table($dbName4)->where([
                    ['id',$id],
                    [DB::raw('DATE(sync_date)'),$date]])->first(); 
                    
        $Absensi1 = DB::connection('mysql2')->table($dbName4)->where([
                        ['id',$id],
                        [DB::raw('DATE(sync_date)'),$date]])->first();  
              
        // return response()->json($Absensi4);

        if(!empty($Absensi)){                      
            // return response()->json($Absensi);
            $absenmentah = AbsenMentah::where([                        
                ['pid', $Absensi->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi->sync_date))]
                ])->get();
            
                $absen =(object)DB::connection('mysql2')->table($dbName)->where('check_in',$Absensi->check_in)->first();

                foreach($absen as $a){
                    $b = $absen->check_in;
                }
                foreach($absen as $a){
                    $c = $absen->check_out;
                }
                foreach($absen as $a){    
                    $d = DATE('Y-m-d' , strtotime($absen->sync_date));
                }
                foreach($absen as $a){      
        
                        $pegawai = Pegawai::where('pid', $absen->pid)->first();
                        $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                        $awal   = date_create($reguKerja->tgl_start);
                        $akhir  = date_create(date('Y-m-d', strtotime(Carbon::now())));        
                        $diff   = date_diff($awal,$akhir);
                        $modulus = $diff->d % $reguKerja->hari;
                        if ($modulus == 0){
                            $modulus = $reguKerja->hari;
                        }
        
                    $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                    $jam    = ReferensiKerja::where('kode',$jadwal[$modulus]) ->first();
                    $check_in   = $absen->check_in;
                    if ($check_in >= $jam->workin){
                            $telat      = strtotime($check_in) - strtotime($jam->workin) ;
                            $late       = date('H:i:s', $telat);
                            // return response()->json($late);
                        // Useless
                // $awal = strtotime($reguKerja->tgl_start);
                // $akhir = strtotime(Carbon::now());
                // $diff = $akhir - $awal ;
                // $hasil = Round($diff / 60/ 60 /24);
                // $modulus = $hasil % 7;        
        
                    } else {                
                        $telat       = strtotime('00:00:00');
                        $late        = date('H:i:s', $telat);
                        // return response()->json($late);
                    }            
                }    
                // return response()->json($late);

        }elseif(!empty($Absensi4)){
            $absenmentah = AbsenMentah::where([                        
                ['pid', $Absensi4->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi4->sync_date))]
                ])->get();
            
                $absen =(object)DB::connection('mysql2')->table($dbName4)->where('check_in',$Absensi4->check_in)->first();

                foreach($absen as $a){
                    $b = $absen->check_in;
                }
                foreach($absen as $a){
                    $c = $absen->check_out;
                }
                foreach($absen as $a){    
                    $d = DATE('Y-m-d' , strtotime($absen->sync_date));
                }
                foreach($absen as $a){      
        
                        $pegawai = Pegawai::where('pid', $absen->pid)->first();
                        $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                        $awal   = date_create($reguKerja->tgl_start);
                        $akhir  = date_create(date('Y-m-d', strtotime(Carbon::now())));        
                        $diff   = date_diff($awal,$akhir);
                        $modulus = $diff->d % $reguKerja->hari;
                        if ($modulus == 0){
                            $modulus = $reguKerja->hari;
                        }
        
                    $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                    $jam    = ReferensiKerja::where('kode',$jadwal[$modulus]) ->first();
                    $check_in   = $absen->check_in;
                    if ($check_in >= $jam->workin){
                            $telat      = strtotime($check_in) - strtotime($jam->workin) ;
                            $late       = date('H:i:s', $telat);
                            // return response()->json($late);
                        // Useless
                // $awal = strtotime($reguKerja->tgl_start);
                // $akhir = strtotime(Carbon::now());
                // $diff = $akhir - $awal ;
                // $hasil = Round($diff / 60/ 60 /24);
                // $modulus = $hasil % 7;        
        
                    } else {                
                        $telat       = strtotime('00:00:00');
                        $late        = date('H:i:s', $telat);
                        // return response()->json($late);
                    }            
                }    

                // return response()->json($late);
        }elseif(!empty($Absensi3)){
            $absenmentah = AbsenMentah::where([                        
                ['pid', $Absensi3->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi3->sync_date))]
                ])->get();
            
                $absen =(object)DB::connection('mysql2')->table($dbName4)->where('check_in',$Absensi3->check_in)->first();

                foreach($absen as $a){
                    $b = $absen->check_in;
                }
                foreach($absen as $a){
                    $c = $absen->check_out;
                }
                foreach($absen as $a){    
                    $d = DATE('Y-m-d' , strtotime($absen->sync_date));
                }
                foreach($absen as $a){      
        
                        $pegawai = Pegawai::where('pid', $absen->pid)->first();
                        $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                        $awal   = date_create($reguKerja->tgl_start);
                        $akhir  = date_create(date('Y-m-d', strtotime(Carbon::now())));        
                        $diff   = date_diff($awal,$akhir);
                        $modulus = $diff->d % $reguKerja->hari;
                        if ($modulus == 0){
                            $modulus = $reguKerja->hari;
                        }
        
                    $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                    $jam    = ReferensiKerja::where('kode',$jadwal[$modulus]) ->first();
                    $check_in   = $absen->check_in;
                    if ($check_in >= $jam->workin){
                            $telat      = strtotime($check_in) - strtotime($jam->workin) ;
                            $late       = date('H:i:s', $telat);
                            // return response()->json($late);
                        // Useless
                // $awal = strtotime($reguKerja->tgl_start);
                // $akhir = strtotime(Carbon::now());
                // $diff = $akhir - $awal ;
                // $hasil = Round($diff / 60/ 60 /24);
                // $modulus = $hasil % 7;        
        
                    } else {                
                        $telat       = strtotime('00:00:00');
                        $late        = date('H:i:s', $telat);
                        // return response()->json($late);
                    }            
                }    

                // return response()->json($late);

        }elseif(!empty($Absensi2)){
            $absenmentah = AbsenMentah::where([                        
                ['pid', $Absensi2->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi2->sync_date))]
                ])->get();
            
                $absen =(object)DB::connection('mysql2')->table($dbName4)->where('check_in',$Absensi2->check_in)->first();

                foreach($absen as $a){
                    $b = $absen->check_in;
                }
                foreach($absen as $a){
                    $c = $absen->check_out;
                }
                foreach($absen as $a){    
                    $d = DATE('Y-m-d' , strtotime($absen->sync_date));
                }
                foreach($absen as $a){      
        
                        $pegawai = Pegawai::where('pid', $absen->pid)->first();
                        $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                        $awal   = date_create($reguKerja->tgl_start);
                        $akhir  = date_create(date('Y-m-d', strtotime(Carbon::now())));        
                        $diff   = date_diff($awal,$akhir);
                        $modulus = $diff->d % $reguKerja->hari;
                        if ($modulus == 0){
                            $modulus = $reguKerja->hari;
                        }
        
                    $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                    $jam    = ReferensiKerja::where('kode',$jadwal[$modulus]) ->first();
                    $check_in   = $absen->check_in;
                    if ($check_in >= $jam->workin){
                            $telat      = strtotime($check_in) - strtotime($jam->workin) ;
                            $late       = date('H:i:s', $telat);
                            // return response()->json($late);
                        // Useless
                // $awal = strtotime($reguKerja->tgl_start);
                // $akhir = strtotime(Carbon::now());
                // $diff = $akhir - $awal ;
                // $hasil = Round($diff / 60/ 60 /24);
                // $modulus = $hasil % 7;        
        
                    } else {                
                        $telat       = strtotime('00:00:00');
                        $late        = date('H:i:s', $telat);
                        // return response()->json($late);
                    }            
                }    

                // return response()->json($late);

        }elseif(!empty($Absensi1)){
            $absenmentah = AbsenMentah::where([                        
                ['pid', $Absensi1->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi1->sync_date))]
                ])->get();
            
                $absen =(object)DB::connection('mysql2')->table($dbName4)->where('check_in',$Absensi1->check_in)->first();

                foreach($absen as $a){
                    $b = $absen->check_in;
                }
                foreach($absen as $a){
                    $c = $absen->check_out;
                }
                foreach($absen as $a){    
                    $d = DATE('Y-m-d' , strtotime($absen->sync_date));
                }
                foreach($absen as $a){      
        
                        $pegawai = Pegawai::where('pid', $absen->pid)->first();
                        $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                        $awal   = date_create($reguKerja->tgl_start);
                        $akhir  = date_create(date('Y-m-d', strtotime(Carbon::now())));        
                        $diff   = date_diff($awal,$akhir);
                        $modulus = $diff->d % $reguKerja->hari;
                        if ($modulus == 0){
                            $modulus = $reguKerja->hari;
                        }
        
                    $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                    $jam    = ReferensiKerja::where('kode',$jadwal[$modulus]) ->first();
                    $check_in   = $absen->check_in;
                    if ($check_in >= $jam->workin){
                            $telat      = strtotime($check_in) - strtotime($jam->workin) ;
                            $late       = date('H:i:s', $telat);
                            // return response()->json($late);
                        // Useless
                // $awal = strtotime($reguKerja->tgl_start);
                // $akhir = strtotime(Carbon::now());
                // $diff = $akhir - $awal ;
                // $hasil = Round($diff / 60/ 60 /24);
                // $modulus = $hasil % 7;        
        
                    } else {                
                        $telat       = strtotime('00:00:00');
                        $late        = date('H:i:s', $telat);
                        // return response()->json($late);
                    }            
                }    

                // return response()->json($late);
        }

        // USELESS //
        // $Absensi = DB::connection('mysql2')->table($dbName)->where('id',$id)->first();
        // $Absensi4 = DB::connection('mysql2')->table($dbName4)->where('id',$id)->first();
        // $Absensi3 = DB::connection('mysql2')->table($dbName3)->where('id',$id)->first();
        // $Absensi2 = DB::connection('mysql2')->table($dbName2)->where('id',$id)->first();
        // $Absensi1 = DB::connection('mysql2')->table($dbName1)->where('id',$id)->first();


        // FROM HERE U SHOULD DO AGAIN // ////////////////////////////////////////////////////////////
        // return response()->json($Absensi);
        // $absenmentah = AbsenMentah::where([                        
        //     ['pid', $Absensi4->pid],
        //     [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi4->sync_date))]
        //     ])->get();
            // return response()->json($absenmentah);

        // ADDING NEW SHOULD BE CONTINUED //
        // if(!empty($Absensi) && ((date('Y-m-d', strtotime($Absensi->sync_date))) === date('Y-m-d',$absenmentah->date))){
        //     $a = (date('Y-m-d', strtotime($Absensi->sync_date))) === date('Y-m-d',$absenmentah->date);
        //     return response()->json($a);
        // }

        // $month4 = strtotime($month) + strtotime("-1 month");
        // $month4 = date('m', $month4);
        // $dbName4 = $year.''.$month4.'HISTORY';
        // $absensi = DB::connection('mysql2')->table($dbName)->where('id',$id)->first();
        // return response()->json($absensi);
        // $absen =(object)DB::connection('mysql2')->table($dbName)->where('check_in',$Absensi->check_in)->first();

        // foreach($absen as $a){
        //     $b = $absen->check_in;
        // }
        // foreach($absen as $a){
        //     $c = $absen->check_out;
        // }
        // foreach($absen as $a){    
        //     $d = DATE('Y-m-d' , strtotime($absen->sync_date));
        // }
        // foreach($absen as $a){      

        //         $pegawai = Pegawai::where('pid', $absen->pid)->first();
        //         $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
        //         $awal   = date_create($reguKerja->tgl_start);
        //         $akhir  = date_create(date('Y-m-d', strtotime(Carbon::now())));        
        //         $diff   = date_diff($awal,$akhir);
        //         $modulus = $diff->d % $reguKerja->hari;
        //         if ($modulus == 0){
        //             $modulus = $reguKerja->hari;
        //         }

        //     $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
        //     $jam    = ReferensiKerja::where('kode',$jadwal[$modulus]) ->first();
        //     $check_in   = $absen->check_in;
        //     if ($check_in >= $jam->workin){
        //             $telat      = strtotime($check_in) - strtotime($jam->workin) ;
        //             $late       = date('H:i:s', $telat);
                    // return response()->json($late);

        // $awal = strtotime($reguKerja->tgl_start);
        // $akhir = strtotime(Carbon::now());
        // $diff = $akhir - $awal ;
        // $hasil = Round($diff / 60/ 60 /24);
        // $modulus = $hasil % 7;        

        //     } else {                
        //         $telat       = strtotime('00:00:00');
        //         $late        = date('H:i:s', $telat);
        //         // return response()->json($late);
        //     }            
        // }
        
        // $Absensi =(object)DB::connection('mysql2')->table($dbName)->get();
        // $count = (COUNT($Absensi) - 1 );  

        return view('admin.absensi.edit', compact(['Absensi','id','b','c','d','late']));
        // return response()->json($d);
        
        // $Absensi = DB::connection('mysql2')->table($dbName) ->where([
        //     [DB::raw('id'),$id],
        //     [DB::raw('check_in',$absensi[3])]
        //     ])->get();

           
        // $absensi = DB::connection('mysql2')->table($dbName)->first();
        // $id     = $absensi->id;
        // $Absensi = $absensi->id;
        // $absensi = DB::connection('mysql2')->table($dbName)->where('id','2')->where('check_in','07:46:08')->get();
        // return response()->json($absensi);
                                      
        // $a = $absensi->check_in;
        
        // foreach($absensi as $ab){   
        //     // for($i = 0 ; $i <= $count ; $i++){
        //             //  $array[1][3];               
        //                 $b =$ab->check_in ;                          
            // }
            
        // return response()->json($b); 
        // $check   = DB::connection('mysql2')->table($dbName) ->where([
        //                                                             [DB::raw('id'),$id],
        //                                                             [DB::raw('check_in',$absensi[3])]
        // ])->get();                                                    
        // return response()->json($check);
        // $Absensi = DB::connection('mysql2')->table($dbName)->where('id',$id)->first();        
        
            // return response()->json($Absensi);
        // $absensi = DB::connection('mysql2')->table($dbName)->where('check_in','16:56:00')->first();
        // dd($id);
        // return response()->json($Absensi);
       
        // dd($id);
        // }
    }
    
    function update(Request $request, $id){
        $date  = $request->sync_date;         
        // $tangga = (object)($request->sync_date);
        // return response()->json($date);
        $year   = Carbon::now()->format('Y');
        $month  = Carbon::now()->format('m');
        $dbName = $year.''.$month.'HISTORY';
        // return response()->json($dbName);
        //GET 5 MONTH BEFORE//
        $month4 = strtotime($month) + strtotime("-1 month");
        $month4 = date('m', $month4);
        $month3 = strtotime($month) + strtotime("-2 month");
        $month3 = date('m', $month3);
        $month2 = strtotime($month) + strtotime("-3 month");
        $month2 = date('m', $month2);
        $month1 = strtotime($month) + strtotime("-4 month");
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
        // return response()->json($dbCheck4);
                
        // $absensi    = (object)DB::connection('mysql2')->table($dbName)->first();
        // $Absensi    = (object)DB::connection('mysql2')->table($dbName)->where('id',$id)->first();
        // return response()->json($Absensi);
        // $pegawai    = Pegawai::where('pid',$Absensi->pid)->first();
        // return response()->json($pegawai);
        $Absensi = DB::connection('mysql2')->table($dbName)->where([
            ['id',$id],
            [DB::raw('DATE(sync_date)'),$date]])->first(); 

        $Absensi4 = DB::connection('mysql2')->table($dbName4)->where([
            ['id',$id],
            [DB::raw('DATE(sync_date)'),$date]])->first();
            // return response()->json($date);
        // $Absensi3 = DB::connection('mysql2')->table($dbName3)->where([
        //         ['id',$id],
        //         [DB::raw('DATE(sync_date)'),$date]])->first(); 

        // $Absensi2 = DB::connection('mysql2')->table($dbName2)->where([
        //             ['id',$id],
        //             [DB::raw('DATE(sync_date)'),$date]])->first(); 
                    
        // $Absensi1 = DB::connection('mysql2')->table($dbName1)->where([
        //                 ['id',$id],
        //                 [DB::raw('DATE(sync_date)'),$date]])->first();

        
        // return response()->json($request->all());
        // $data = $request->all();
        //             $a = $data['sync_date'];
            // return response()->json($request['sync_date']);
        if(!empty($Absensi)){            
            $absenmentah = AbsenMentah::where([            
                ['pid', $Absensi->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi->sync_date))]
                ])->first();
                
                // return response()->json($request->sync_date1);
                // return response()->json($request->all());
                // return response()->json($request['sync_date']);
                // dd($request->sync_date);

                $jam        = (date('H:i:s', strtotime($request->check_in)));
                $tanggal    = (date('Y-m-d' , strtotime($request->sync_date)));                
                // return response()->json($tanggal);
                $input      = $tanggal.' '.$jam;
                $datetime   = date('Y-m-d H:i:s', strtotime($input));
                // return response()->json($jam);
                $absen=Absenmentah::where([
                    ['pid', $Absensi->pid],
                    [DB::raw('DATE(date)'),date('Y-m-d' , strtotime($Absensi->sync_date))]
                ])->update([
                'date'              => $datetime,
                'created_at'        => $request->sync_date,
                'updated_at'        => Carbon::now()
                ]);
                // return response()->json($absen);
              DB::connection('mysql2')->table($dbName)->where('id', $id)->update([
                    'check_in'  =>  $request->check_in,
                    'check_out' => $request->check_out,
                    'telat'     =>  $request->telat,
                    'check_in1'  => $request->check_in1,
                    'check_out1' => $request->check_out1,
                    'check_in2'  => $request->check_in2,
                    'check_out2' => $request->check_out2,
                    'check_in3'  => $request->check_in3,
                    'check_out3' => $request->check_out3,
                    'absen1' => $request->absen1,
                    'absen2'  => $request->absen2,
                    'izin' => $request->izin,
                    'sync_date'    => $tanggal,
                    'updated_at'    => Carbon::now()
                ]);
                // return response()->json($tanggal);
        }elseif(!empty($Absensi4)){
            $absenmentah = AbsenMentah::where([            
                ['pid', $Absensi4->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi4->sync_date))]
                ])->get();    
                // return response()->json($absenmentah4);
                    $jam        = (date('H:i:s', strtotime($request->check_in)));
                    $tanggal    = (date('Y-m-d' , strtotime($request->sync_date)));
                    $input      = $tanggal.' '.$jam;
                    $datetime   = date('Y-m-d H:i:s', strtotime($input));
                    // return response()->json($jam);
                    $absen=Absenmentah::where([
                        ['pid', $Absensi4->pid],
                        [DB::raw('DATE(date)'),date('Y-m-d' , strtotime($Absensi4->sync_date))]
                    ])            
                        ->update([
                    'date'              => $datetime,
                    'created_at'        => $request->sync_date,
                    'updated_at'        => Carbon::now()
                    ]);
                    // return response()->json($absen);
                    DB::connection('mysql2')->table($dbName4)->where('id', $id)->update([
                        'check_in'  =>  $request->check_in,
                        'check_out' => $request->check_out,
                        'telat'     =>  $request->telat,
                        'check_in1'  => $request->check_in1,
                        'check_out1' => $request->check_out1,
                        'check_in2'  => $request->check_in2,
                        'check_out2' => $request->check_out2,
                        'check_in3'  => $request->check_in3,
                        'check_out3' => $request->check_out3,
                        'absen1' => $request->absen1,
                        'absen2'  => $request->absen2,
                        'izin' => $request->izin,
                        'sync_date'    => $tanggal,
                        'updated_at'    => Carbon::now()
                    ]);
        }elseif(!empty($Absensi3)){
            $absenmentah = AbsenMentah::where([            
                ['pid', $Absensi3->pid],
                [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi3->sync_date))]
                ])->get();    
                // return response()->json($absenmentah4);
                    $jam        = (date('H:i:s', strtotime($request->check_in)));
                    $tanggal    = (date('Y-m-d' , strtotime($request->sync_date)));
                    $input      = $tanggal.' '.$jam;
                    $datetime   = date('Y-m-d H:i:s', strtotime($input));
                    // return response()->json($jam);
                    $absen=Absenmentah::where([
                        ['pid', $Absensi3->pid],
                        [DB::raw('DATE(date)'),date('Y-m-d' , strtotime($Absensi3->sync_date))]
                    ])            
                        ->update([
                    'date'              => $datetime,
                    'created_at'        => $request->sync_date,
                    'updated_at'        => Carbon::now()
                    ]);
                    // return response()->json($absen);
                    DB::connection('mysql2')->table($dbName3)->where('id', $id)->update([
                        'check_in'  =>  $request->check_in,
                        'check_out' => $request->check_out,
                        'telat'     =>  $request->telat,
                        'check_in1'  => $request->check_in1,
                        'check_out1' => $request->check_out1,
                        'check_in2'  => $request->check_in2,
                        'check_out2' => $request->check_out2,
                        'check_in3'  => $request->check_in3,
                        'check_out3' => $request->check_out3,
                        'absen1' => $request->absen1,
                        'absen2'  => $request->absen2,
                        'izin' => $request->izin,
                        'sync_date'    => $request->sync_date,
                        'updated_at'    => Carbon::now()
                    ]);
                }elseif(!empty($Absensi2)){
                    $absenmentah = AbsenMentah::where([            
                        ['pid', $Absensi2->pid],
                        [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi2->sync_date))]
                        ])->get();    
                        // return response()->json($absenmentah4);
                            $jam        = (date('H:i:s', strtotime($request->check_in)));
                            $tanggal    = (date('Y-m-d' , strtotime($request->sync_date)));
                            $input      = $tanggal.' '.$jam;
                            $datetime   = date('Y-m-d H:i:s', strtotime($input));
                            // return response()->json($jam);
                            $absen=Absenmentah::where([
                                ['pid', $Absensi2->pid],
                                [DB::raw('DATE(date)'),date('Y-m-d' , strtotime($Absensi2->sync_date))]
                            ])            
                                ->update([
                            'date'              => $datetime,
                            'created_at'        => $request->sync_date,
                            'updated_at'        => Carbon::now()
                            ]);
                            // return response()->json($absen);
                            DB::connection('mysql2')->table($dbName2)->where('id', $id)->update([
                                'check_in'  =>  $request->check_in,
                                'check_out' => $request->check_out,
                                'telat'     =>  $request->telat,
                                'check_in1'  => $request->check_in1,
                                'check_out1' => $request->check_out1,
                                'check_in2'  => $request->check_in2,
                                'check_out2' => $request->check_out2,
                                'check_in3'  => $request->check_in3,
                                'check_out3' => $request->check_out3,
                                'absen1' => $request->absen1,
                                'absen2'  => $request->absen2,
                                'izin' => $request->izin,
                                'sync_date'    => $request->sync_date,
                                'updated_at'    => Carbon::now()
                            ]);
                        }else{
                            // $absenmentah = AbsenMentah::where([            
                            //     ['pid', $Absensi1->pid],
                            //     [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi1->sync_date))]
                            //     ])->get();    
                            //     // return response()->json($absenmentah4);
                            //         $jam        = (date('H:i:s', strtotime($request->check_in)));
                            //         $tanggal    = (date('Y-m-d' , strtotime($request->sync_date)));
                            //         $input      = $tanggal.' '.$jam;
                            //         $datetime   = date('Y-m-d H:i:s', strtotime($input));
                            //         // return response()->json($jam);
                            //         $absen=Absenmentah::where([
                            //             ['pid', $Absensi1->pid],
                            //             [DB::raw('DATE(date)'),date('Y-m-d' , strtotime($Absensi1->sync_date))]
                            //         ])            
                            //             ->update([
                            //         'date'              => $datetime,
                            //         'created_at'        => $request->sync_date,
                            //         'updated_at'        => Carbon::now()
                            //         ]);
                            //         // return response()->json($absen);
                            //         DB::connection('mysql2')->table($dbName1)->where('id', $id)->update([
                            //             'check_in'  =>  $request->check_in,
                            //             'check_out' => $request->check_out,
                            //             'telat'     =>  $request->telat,
                            //             'check_in1'  => $request->check_in1,
                            //             'check_out1' => $request->check_out1,
                            //             'check_in2'  => $request->check_in2,
                            //             'check_out2' => $request->check_out2,
                            //             'check_in3'  => $request->check_in3,
                            //             'check_out3' => $request->check_out3,
                            //             'absen1' => $request->absen1,
                            //             'absen2'  => $request->absen2,
                            //             'izin' => $request->izin,
                            //             'sync_date'    => $request->sync_date,
                            //             'updated_at'    => Carbon::now()
                            //         ]);
                                }
        // return response()->json($absenmentah4);
        // $Absensi = DB::connection('mysql2')->table($dbName)->where('id',$id)->first();
        // $Absensi4 = DB::connection('mysql2')->table($dbName4)->where('id',$id)->first();
        // $Absensi3 = DB::connection('mysql2')->table($dbName3)->where('id',$id)->first();
        // $Absensi2 = DB::connection('mysql2')->table($dbName2)->where('id',$id)->first();
        // $Absensi1 = DB::connection('mysql2')->table($dbName1)->where('id',$id)->first();
            
            // return response()->json($Absensi4);
        //  GET ABSENMENTAH FIELD CONSIDER PID AND DATE // 

        // $absenmentah = AbsenMentah::where([            
        //     ['pid', $Absensi->pid],
        //     [DB::raw('DATE(date)') , date('Y-m-d', strtotime($Absensi->sync_date))]
        //     ])->get();

        //     $jam        = (date('H:i:s', strtotime($request->check_in)));
        //     $tanggal    = (date('Y-m-d' , strtotime($request->sync_date)));
        //     $input      = $tanggal.' '.$jam;
        //     $datetime   = date('Y-m-d H:i:s', strtotime($input));

        //     $absen=Absenmentah::where([
        //         ['pid', $Absensi->pid],
        //         [DB::raw('DATE(date)'),date('Y-m-d' , strtotime($Absensi->sync_date))]
        //     ])            
        //         ->update([
        //     'date'              => $datetime,
        //     'created_at'        => $request->sync_date,
        //     'updated_at'        => Carbon::now()
        //     ]);

        //     DB::connection('mysql2')->table($dbName)->where('id', $id)->update([
        //         'check_in'  =>  $request->check_in,
        //         'check_out' => $request->check_out,
        //         'telat'     =>  $request->telat,
        //         'check_in1'  => $request->check_in1,
        //         'check_out1' => $request->check_out1,
        //         'check_in2'  => $request->check_in2,
        //         'check_out2' => $request->check_out2,
        //         'check_in3'  => $request->check_in3,
        //         'check_out3' => $request->check_out3,
        //         'absen1' => $request->absen1,
        //         'absen2'  => $request->absen2,
        //         'izin' => $request->izin,
        //         'sync_date'    => $request->sync_date,
        //         'updated_at'    => Carbon::now()
        //     ]);
        //     return response()->json($absenmentah);
        // // ADDING NEW AND SHOULD BE CONTINUED ///////////////////////
        // if(!empty($Absensi) && ((date('Y-m-d', strtotime($Absensi->sync_date))) == date('Y-m-d',$absenmentah->date))){

        // }


        // return response()->json($absenmentah);
        // dd($id);

        // if(!empty($absenmentah)){ 
        //     // $date = date('Y-m-d H:i:s' , ((int)(strtotime($request->sync_date).''.(int)(strtotime($request->check_in)))));
        //     $jam        = (date('H:i:s', strtotime($request->check_in)));
        //     $tanggal    = (date('Y-m-d' , strtotime($request->sync_date)));
        //     $input      = $tanggal.' '.$jam;
        //     $datetime   = date('Y-m-d H:i:s', strtotime($input));

        //     $absen=Absenmentah::where([
        //         ['pid', $Absensi->pid],
        //         [DB::raw('DATE(date)'),date('Y-m-d' , strtotime($Absensi->sync_date))]
        //     ])            
        //         ->update([
        //     'date'              => $datetime,
        //     'created_at'        => $request->sync_date,
        //     'updated_at'        => Carbon::now()
        //     ]);

        //     // ->first();
        //     // return response()->json(date('Y-m-d H:i:s' , ((int)(strtotime($request->sync_date).''.(int)(strtotime($request->check_in))))));
        //     // return response()->json($absen);
        // }
        // // return response()->json(date('Y-m-d H:i:s',($request->sync_date . $request->check_in)));
        // DB::connection('mysql2')->table($dbName)->where('id', $id)->update([
        //     'check_in'  =>  $request->check_in,
        //     'check_out' => $request->check_out,
        //     'telat'     =>  $request->telat,
        //     'check_in1'  => $request->check_in1,
        //     'check_out1' => $request->check_out1,
        //     'check_in2'  => $request->check_in2,
        //     'check_out2' => $request->check_out2,
        //     'check_in3'  => $request->check_in3,
        //     'check_out3' => $request->check_out3,
        //     'absen1' => $request->absen1,
        //     'absen2'  => $request->absen2,
        //     'izin' => $request->izin,
        //     'sync_date'    => $request->sync_date,
        //     'updated_at'    => Carbon::now()
        // ]);
        


    //    Session::put('Sweetalert','success');
       
    //    return view('admin.absensi.edit', compact(['absensi']));
       return redirect()->route('absensi', $id)->with('success',$id);;
    //    ->with('alert','Sukses Mengedit Data Absensi '.$id);
    //    dd($id);
    }

    function destroy($id){
        $year       = Carbon::now()->format('Y');
        $month      = Carbon::now()->format('m');
        $dbName     = $year.''.$month.'HISTORY';

        $absen      = DB::connection('mysql2')->table($dbName)
        ->where('id',$id)->first();

        if(!empty($absen)){
            DB::connection('mysql2')->table($dbName)->where('id',$id)->delete();
        }
        // return response()->json(!empty($absen));
    }

    function syncData2(Request $request){
        $tanggal = $request->tanggal;
        $tanggal2 = $request->tanggal2;

        $mesin  = Mesin::where('is_default', 1)->first();
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $dbName = $year.''.$month.'HISTORY';
        $port = 4370;

        $zk = new ZKLibrary($mesin->tcpip, $port);
        $zk->connect();
        $log_kehadiran = $zk->getAttendance();
        
        if(!empty($log_kehadiran) == true){
            foreach($log_kehadiran as $data){
                $countData = count($log_kehadiran) - 1;
                $checkAbsen = COUNT(AbsenMentah::where(DB::raw('DATE(date)'), date('Y-m-d', strtotime($data[3])))->get());

                if($checkAbsen === 0 || is_null($checkAbsen)){
                    for($i = 0; $i <= $countData; $i++){
                        AbsenMentah::insert([
                            'pid'           => $log_kehadiran[$i][1],
                            'status'        => $log_kehadiran[$i][2],
                            'date'          => $log_kehadiran[$i][3],
                            'created_at'    => Carbon::now(),
                            'updated_at'    => Carbon::now()
                        ]);
                    }
                }
            }
        }
    }
}
