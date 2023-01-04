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
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use ZKLibrary;

class DevController extends Controller
{
    function index(Request $request){
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
                "SELECT afh.pid, p.nama, p.departement, afh.check_in, afh.check_out, afh.telat, afh.izin, afh.check_in1, afh.check_out1, afh.check_in2, afh.check_out2, afh.check_in3, afh.check_out3, afh.sync_date, afh.absen1, afh.absen2
                FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                WHERE p.pid = afh.pid AND DATE(afh.sync_date) = '$date'
                ORDER BY afh.id DESC"
            );

            return view('admin.absensi.index', compact(['absensi', 'tanggal', 'date', 'tanggalCetak', 'dbName']));
        } else{
            $date = Carbon::now()->format('Y-m-d');
            $year = date('Y', strtotime($request->tanggal));
            $month = date('m', strtotime($request->tanggal));
            $dbName = $year.''.$month.'HISTORY';
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            $tanggal2 = date('Y-m-d', strtotime($request->tanggal2));
            $tanggalCetak = date('Y-m-d', strtotime($request->tanggal));
            // $absensi = Absen::all();
            $absensi = DB::select(
                "SELECT afh.pid, p.nama, p.departement, afh.check_in, afh.check_out, afh.telat, afh.izin, afh.check_in1, afh.check_out1, afh.check_in2, afh.check_out2, afh.check_in3, afh.check_out3, afh.sync_date, afh.absen1, afh.absen2
                FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2'
                ORDER BY afh.id DESC"
            );

            return view('admin.absensi.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName']));
        }
    }

    function syncData(){
        $tanggal = '2022-09-12';
        $tanggal2 = '2022-09-13';

        $mesin  = Mesin::where('id', 15)->first();
        echo "<pre>";
        // print_r($mesin);
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $dbName = $year.''.$month.'HISTORY';
        $port = 4370;

        echo $mesin->tcpip;
        $zk = new ZKLibrary($mesin->tcpip, $port);
        $zk->connect();
        $log_kehadiran = $zk->getAttendance();
        // print_r($log_kehadiran);
        // return count($log_kehadiran);
        // $absenMentah = array();
        // foreach($log_kehadiran as $data){
        //     $countData = count($log_kehadiran) - 1;
        //     $checkAbsen = COUNT(AbsenMentah::where(DB::raw('DATE(date)'), date('Y-m-d', strtotime($data[3])))->get());
        //     echo $checkAbsen;
        //     if($checkAbsen === 0 || is_null($checkAbsen)){
        //         for($i = 0; $i <= $countData; $i++){
        //             array_push($absenMentah, array(
        //                 'pid'           => $log_kehadiran[$i][1],
        //                 'status'        => $log_kehadiran[$i][2],
        //                 'date'          => $log_kehadiran[$i][3],
        //                 'created_at'    => Carbon::now(),
        //                 'updated_at'    => Carbon::now()
        //             ));
        //         }
        //     }
        // }
        foreach($log_kehadiran as $data){
                if( substr($data[3],0,10) != '2022-09-12' && $data[1] != '121527') continue;
                $countData = count($log_kehadiran) - 1;
                $checkAbsen = COUNT(AbsenMentah::where(DB::raw('DATE(date)'), date('Y-m-d', strtotime($data[3])))->get());
                // print_r($checkAbsen);

                if($checkAbsen === 0 || is_null($checkAbsen)){
                    for($i = 0; $i <= $countData; $i++){
                        if($log_kehadiran[$i][1] != '121527') continue;
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
            // return true;
            if(strtotime($tanggal) === strtotime($tanggal2)){
                $absenMentah = AbsenMentah::where(DB::raw('DATE(date)'), $tanggal)->get();
            }else{
                $absenMentah = AbsenMentah::whereBetween(DB::raw('DATE(date)'), [$tanggal, $tanggal2])->get();
            }
            // foreach($absenMentah as $row){
            //         echo "PID".$row->pid;
            //         $checkDate = date('Y-m-d', strtotime($row->date));
            //         $pegawai = Pegawai::where('pid', $row->pid)->first();
            //         // print_r($pegawai);
            // }
            if(strtotime($tanggal) === strtotime($tanggal2)){
                $absenMentah = AbsenMentah::where(DB::raw('DATE(date)'), $tanggal)->get();
            }else{
                $absenMentah = AbsenMentah::whereBetween(DB::raw('DATE(date)'), [$tanggal, $tanggal2])->get();
            }
            // return response()->json($absenMentah);

            if(!is_null($absenMentah)){
                echo "masuk sini";
                $ot_cico = array();
                foreach($absenMentah as $row){
                    $checkDate = date('Y-m-d', strtotime($row->date));

                    $checkPegawai = DB::select("
                        SELECT db.* 
                        FROM absensi_frhistory.$dbName db
                        WHERE db.pid = '$row->pid' AND DATE(db.sync_date) = '$checkDate'
                    ");

                    if($checkPegawai === null || empty($checkPegawai) || $checkPegawai == ''){
                        echo "masuk no pegaia di history";
                        $pegawai = Pegawai::where('pid', $row->pid)->first();

                        if(!is_null($pegawai)){
                            echo $pegawai->sap;
                            echo "ada data pegawai";
                            // Check regukerja_id is not null
                            if(!empty($pegawai->regukerja_id) || $pegawai->regukerja_id != 'null' || $pegawai->regukerja_id != null){
                                echo "masuk ada data regu kerja";
                                 $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                                 // $reguKerja = ReguKerja::where('kode', 'R. A')->first();

                                if($reguKerja != null){
                                    echo "ada regu kerja data";
                                    echo $reguKerja->kode;
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
                                        $akhir = date_create($row->date); // waktu sekarang
                                        $diff  = date_diff( $awal, $akhir );
                                        $hari = ($diff->days % $reguKerja->hari);
                                        if($hari === 0){
                                            $hari = $reguKerja->hari;
                                        }
                                        echo $reguKerja->tgl_start;
                                        echo $hari;
                                        echo "<br>hari ini ".$row->date;
                                        echo "<br>hari kerja ".$reguKerja->hari;
                                        echo "<br>hari ke berapa? ".$diff->days;
                                        echo "<br>hari modulo? ".($diff->days % $reguKerja->hari);

                                        // Get Jadwals
                                        $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                                        // Get Ref Kerja
                                        $refKerja = ReferensiKerja::where('kode', $jadwal[$hari])->first();
                                        print_r($refKerja);
                                        // return response()->json([$refKerja, $hari]);
                                        // Get Time in row
                                        $clock = date('H:i:s', strtotime($row->date));
                                        // Get Time - 1 hour before workin
                                        if(!$refKerja){
                                            echo "ref kerja ga ada";
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
                                            if(empty($refKerja->workin) || empty($reguKerja->workout)){
                                                $data_cico = array('pid' => $row->pid, 'sap' => $pegawai->sap, 'sync_date' => $row->date);
                                                $date_key = date('Y-m-d', strtotime($row->date));

                                                if(isset($ot_cico[$row->pid][$date_key])){
                                                    array_push($ot_cico[$row->pid][$date_key], $data_cico);
                                                }else{
                                                    $ot_cico[$row->pid][$date_key] = array($data_cico);
                                                }
                                            }
                                            echo "ref kerja ada";
                                            $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
                                            $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));
                                            echo "clock:".$clock;
                                            echo $refKerja->workout;
                                            echo "<br>workInBefore? ".$workInBefore;
                                            echo "<br>workout? ".$refKerja->workout;

                                            // $clock = '08:30:09';
                                            if( ($refKerja->workin < $refKerja->workout && $clock <= $refKerja->workout && $clock >= $workInBefore) ||
                                            ($refKerja->workin > $refKerja->workout && $clock >= $refKerja->workout && $clock >= $workInBefore) ){
                                                if($clock >= $refKerja->workin){                                // When Late Work in
                                                    $timeLate = strtotime($clock) - strtotime($refKerja->workin);
                                                    $late = date('H:i:s', $timeLate);
                                                    $data =
                                                        [
                                                        'pid'       => $row->pid,
                                                        'sap'       => $pegawai->sap,
                                                        'check_in'  => $clock,
                                                        'telat'     => $late,
                                                        'sync_date'=>   $row->date,
                                                        'updated_at'=> Carbon::now()
                                                    ];
                                                }else{                                                          // When Not Late
                                                    $data =[
                                                        'pid'       => $row->pid,
                                                        'sap'       => $pegawai->sap,
                                                        'check_in'  => $clock,
                                                        'telat'     => '00:00:00',
                                                        'sync_date'=>   $row->date,
                                                        'updated_at'=> Carbon::now()
                                                    ];
                                                }
                                            }elseif($clock >= $refKerja->workout && $clock >= $workOutBefore){
                                                $data =[ 
                                                    'pid'       => $row->pid,
                                                    'sap'       => $pegawai->sap,
                                                    'check_out'  => $clock,
                                                    'telat'     => '00:00:00',
                                                    'sync_date'=>   $row->date,
                                                    'updated_at'=> Carbon::now()
                                                ];
                                            }
                                            // else{
                                            //     echo "masuk else jadwal";
                                            //     $data = [ 
                                            //         'pid'       => $row->pid,
                                            //         'sap'       => $pegawai->sap,
                                            //         'check_in'  => $clock,
                                            //         'telat'     => '00:00:00',
                                            //         'sync_date'=>   $row->date,
                                            //         'updated_at'=> Carbon::now()
                                            //     ];
                                            // }
                                            // print_r($data);
                                        }
                                        // dd($clock >= $refKerja->workout && $clock >= $workOutBefore);
                                    }
                                }
                            }
                        }

                    }else{
                        $pegawai = Pegawai::where('pid', $row->pid)->first();

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

                                    // if($clock >= $workInBefore){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'pid'       => $row->pid,
                                    //         'sap'       => $pegawai->sap,
                                    //         'absen1'    => $clock,
                                    //         'telat'     => '00:00:00',
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }elseif($clock >= $workOutBefore){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'pid'       => $row->pid,
                                    //         'sap'       => $pegawai->sap,
                                    //         'absen2'    => $clock,
                                    //         'telat'     => '00:00:00',
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }
                                }else{
                                    //wsidik 16.09.2022
                                    //save data OT
                                    if(empty($refKerja->workin) || empty($reguKerja->workout)){
                                        $data_cico = array('pid' => $row->pid, 'sap' => $pegawai->sap, 'sync_date' => $row->date);
                                        $date_key = date('Y-m-d', strtotime($row->date));
                                        if(isset($ot_cico[$row->pid][$date_key])){
                                            array_push($ot_cico[$row->pid][$date_key], $data_cico);
                                        }else{
                                            $ot_cico[$row->pid][$date_key] = array($data_cico);
                                        }
                                    }
                                    $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
                                    $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));

                                    // if(!empty($checkAbsen->check_in) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'check_out'  => $clock,
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out)){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'check_in1'  => $clock,
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'check_out1'  => $clock,
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1)){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'check_in2'  => $clock,
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1) && !empty($checkAbsen->check_in2) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'check_out2'  => $clock,
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1) && !empty($checkAbsen->check_in2) && !empty($checkAbsen->check_out2)){
                                    //     DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'check_in3'  => $clock,
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }elseif(!empty($checkAbsen->check_out) && $clock <= $refKerja->workout && $clock >= $workInBefore){
                                    //     $test = DB::connection('mysql2')->table($dbName)->where([
                                    //         ['pid', $row->pid],
                                    //         [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //     ])->update([
                                    //         'check_in'  => $clock,
                                    //         'sync_date'=>   $row->date,
                                    //         'updated_at'=> Carbon::now()
                                    //     ]);
                                    // }else{
                                    //     if(!empty($checkAbsen->check_in3) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
                                    //         DB::connection('mysql2')->table($dbName)->where([
                                    //             ['pid', $row->pid],
                                    //             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //         ])->update([
                                    //             'check_out3'  => $clock,
                                    //             'sync_date'=>   $row->date,
                                    //             'updated_at'=> Carbon::now()
                                    //         ]);
                                    //     }elseif(!empty($checkAbsen->absen1)){
                                    //         DB::connection('mysql2')->table($dbName)->where([
                                    //             ['pid', $row->pid],
                                    //             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
                                    //         ])->update([
                                    //             'pid'       => $row->pid,
                                    //             'sap'       => $pegawai->sap,
                                    //             'absen2'    => $clock,
                                    //             'telat'     => '00:00:00',
                                    //             'sync_date'=>   $row->date,
                                    //             'updated_at'=> Carbon::now()
                                    //         ]);
                                    //     }
                                    // }
                            }
                                }
                            }
                        }
                    }
                }
                // print_r($ot_cico);
                foreach ($ot_cico as $rpid => $perdate) {
                    $min = '';
                    $max = '';
                    foreach ($perdate as $rdate => $dot) {
                        foreach ($dot as $idx => $data) {
                            if($idx == 0){
                                $clock = date('H:i:s', strtotime($data['sync_date']));
                                $input = array(
                                    'pid'       => $rpid,
                                    'sap'       => $data['sap'],
                                    'telat'     => '00:00:00',
                                    'sync_date'=>   $data['sync_date'],
                                    'updated_at'=> Carbon::now()
                                );
                                $min = $data['sync_date'];
                                $max = $data['sync_date'];
                            }else{
                                if($data['sync_date'] < $min) $min = $data['sync_date'];
                                if($data['sync_date'] > $max) $max = $data['sync_date'];
                            }
                        }
                        $input['check_in'] = date('H:i:s', strtotime($min));
                        if($min != $max) $input['check_out'] = date('H:i:s', strtotime($max));
                        echo "print data";
                        print_r($input);
                    }
                }


            }

            // $absenMentah = DB::select("
            //     DELETE FROM absen_mentahs
            // ");

            // AbsenLog::insert([
            //     'mesin_id'      => $mesin->id,
            //     'status_absen'  => 'Tarik Absen',
            //     'created_at'    => Carbon::now(),
            //     'updated_at'    => Carbon::now()
            // ]);

        // print_r($absenMentah);
        return "end";
    }



//         if(!empty($log_kehadiran) == true){
//             foreach($log_kehadiran as $data){
//                 $countData = count($log_kehadiran) - 1;
//                 $checkAbsen = COUNT(AbsenMentah::where(DB::raw('DATE(date)'), date('Y-m-d', strtotime($data[3])))->get());

//                 if($checkAbsen === 0 || is_null($checkAbsen)){
//                     for($i = 0; $i <= $countData; $i++){
//                         AbsenMentah::insert([
//                             'pid'           => $log_kehadiran[$i][1],
//                             'status'        => $log_kehadiran[$i][2],
//                             'date'          => $log_kehadiran[$i][3],
//                             'created_at'    => Carbon::now(),
//                             'updated_at'    => Carbon::now()
//                         ]);
//                     }
//                 }
//             }

//             if(strtotime($tanggal) === strtotime($tanggal2)){
//                 $absenMentah = AbsenMentah::where(DB::raw('DATE(date)'), $tanggal)->get();
//             }else{
//                 $absenMentah = AbsenMentah::whereBetween(DB::raw('DATE(date)'), [$tanggal, $tanggal2])->get();
//             }
// 	           // return response()->json($absenMentah);

//             if(!is_null($absenMentah)){
//                 foreach($absenMentah as $row){
//                     $checkDate = date('Y-m-d', strtotime($row->date));

//                     $checkPegawai = DB::select("
//                         SELECT db.* 
//                         FROM absensi_frhistory.$dbName db
//                         WHERE db.pid = '$row->pid' AND DATE(db.sync_date) = '$checkDate'
//                     ");

//                     if($checkPegawai === null || empty($checkPegawai) || $checkPegawai == ''){
//                         $pegawai = Pegawai::where('pid', $row->pid)->first();

//                         if(!is_null($pegawai)){
//                             // Check regukerja_id is not null
//                             if(!empty($pegawai->regukerja_id) || $pegawai->regukerja_id != 'null' || $pegawai->regukerja_id != null){
//                                  $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
// 				                    // $reguKerja = ReguKerja::where('kode', 'R. A')->first();

//                                 if($reguKerja != null){
//                                     if($reguKerja->kode === 'Default' || $reguKerja->kode === 'DEFAULT'){
//                                         $clock = date('H:i:s', strtotime($row->date));
//                                         DB::connection('mysql2')->table($dbName)->insert([
//                                             'pid'       => $row->pid,
//                                             'sap'       => $pegawai->sap,
//                                             'absen1'    => $clock,
//                                             'telat'     => '00:00:00',
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }else{
//                                         $awal  = date_create($reguKerja->tgl_start);
//                                         $akhir = date_create($row->date); // waktu sekarang
//                                         $diff  = date_diff( $awal, $akhir );
//                                         $hari = $diff->days % $reguKerja->hari;
//                                         if($hari === 0){
//                                             $hari = $reguKerja->hari;
//                                         }
//                                         // Get Jadwals
//                                         $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
//                                         // Get Ref Kerja
//                                         $refKerja = ReferensiKerja::where('kode', $jadwal[$hari])->first();
//                                         // return response()->json([$refKerja, $hari]);
//                                         // Get Time in row
//                                         $clock = date('H:i:s', strtotime($row->date));
//                                         // Get Time - 1 hour before workin
//                                         if(!$refKerja){
//                                             $workInBefore = date('H:i:s', (strtotime('08:00:00') - strtotime('01:00:00')));
//                                             $workOutBefore = date('H:i:s', (strtotime('17:00:00') - strtotime('01:00:00')));
//                                             if($clock >= $workInBefore){
//                                                 DB::connection('mysql2')->table($dbName)->insert([
//                                                     'pid'       => $row->pid,
//                                                     'sap'       => $pegawai->sap,
//                                                     'absen1'    => $clock,
//                                                     'telat'     => '00:00:00',
//                                                     'sync_date'=>   $row->date,
//                                                     'updated_at'=> Carbon::now()
//                                                 ]);
//                                             }elseif($clock >= $workOutBefore){
//                                                 DB::connection('mysql2')->table($dbName)->insert([
//                                                     'pid'       => $row->pid,
//                                                     'sap'       => $pegawai->sap,
//                                                     'absen2'    => $clock,
//                                                     'telat'     => '00:00:00',
//                                                     'sync_date'=>   $row->date,
//                                                     'updated_at'=> Carbon::now()
//                                                 ]);
//                                             }
//                                         }else{
//                                             $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
//                                             $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));

//                                             if($clock <= $refKerja->workout && $clock >= $workInBefore){
//                                                 if($clock >= $refKerja->workin){                                // When Late Work in
//                                                     $timeLate = strtotime($clock) - strtotime($refKerja->workin);
//                                                     $late = date('H:i:s', $timeLate);
//                                                     DB::connection('mysql2')->table($dbName)->insert([
//                                                         'pid'       => $row->pid,
//                                                         'sap'       => $pegawai->sap,
//                                                         'check_in'  => $clock,
//                                                         'telat'     => $late,
//                                                         'sync_date'=>   $row->date,
//                                                         'updated_at'=> Carbon::now()
//                                                     ]);
//                                                 }else{                                                          // When Not Late
//                                                     DB::connection('mysql2')->table($dbName)->insert([
//                                                         'pid'       => $row->pid,
//                                                         'sap'       => $pegawai->sap,
//                                                         'check_in'  => $clock,
//                                                         'telat'     => '00:00:00',
//                                                         'sync_date'=>   $row->date,
//                                                         'updated_at'=> Carbon::now()
//                                                     ]);
//                                                 }
//                                             }elseif($clock >= $refKerja->workout && $clock >= $workOutBefore){
//                                                 DB::connection('mysql2')->table($dbName)->insert([ 
//                                                     'pid'       => $row->pid,
//                                                     'sap'       => $pegawai->sap,
//                                                     'check_out'  => $clock,
//                                                     'telat'     => '00:00:00',
//                                                     'sync_date'=>   $row->date,
//                                                     'updated_at'=> Carbon::now()
//                                                 ]);
//                                             }
//                                         }
//                                         // dd($clock >= $refKerja->workout && $clock >= $workOutBefore);
//                                     }
//                                 }
//                             }
//                         }

//                     }else{
//                         $pegawai = Pegawai::where('pid', $row->pid)->first();

//                         if(!is_null($pegawai)){
//                             if(!empty($pegawai->regukerja_id) || $pegawai->regukerja_id != 'null' || $pegawai->regukerja_id != null){
//                                 $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();

// 				                 if($reguKerja != null){
//                                 // Range date start and date request in machine
//                                 $tglStart = strtotime($reguKerja->tgl_start);
//                                 $tglReq = strtotime($row->date);
//                                 $range = $tglReq - $tglStart;
//                                 $range = $range / 60 /60 /24;
//                                 $hari  = $range%$reguKerja->hari;
//                                 if($hari === 0){
//                                     $hari = $reguKerja->hari;
//                                 }
        
//                                 // Get Jadwals
//                                 $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
//                                 // Get Ref Kerja
//                                 $refKerja = ReferensiKerja::where('kode', $jadwal[$hari])->first();
//                                 // Get Time in row
//                                 $clock = date('H:i:s', strtotime($row->date));
//                                 // Get Time - 1 hour before workin
//                                 $checkAbsen = DB::connection('mysql2')->table($dbName)->where([
//                                     ['pid', $row->pid],
//                                     [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))]
//                                 ])->first();

//                                 if(!$refKerja){
//                                     $workInBefore = date('H:i:s', (strtotime('08:00:00') - strtotime('01:00:00')));
//                                     $workOutBefore = date('H:i:s', (strtotime('17:00:00') - strtotime('01:00:00')));

//                                     if($clock >= $workInBefore){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'pid'       => $row->pid,
//                                             'sap'       => $pegawai->sap,
//                                             'absen1'    => $clock,
//                                             'telat'     => '00:00:00',
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }elseif($clock >= $workOutBefore){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'pid'       => $row->pid,
//                                             'sap'       => $pegawai->sap,
//                                             'absen2'    => $clock,
//                                             'telat'     => '00:00:00',
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }
//                                 }else{
//                                     $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
//                                     $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));

//                                     if(!empty($checkAbsen->check_in) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'check_out'  => $clock,
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out)){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'check_in1'  => $clock,
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'check_out1'  => $clock,
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1)){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'check_in2'  => $clock,
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1) && !empty($checkAbsen->check_in2) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'check_out2'  => $clock,
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }elseif(!empty($checkAbsen->check_in) && !empty($checkAbsen->check_out) && !empty($checkAbsen->check_in1) && !empty($checkAbsen->check_out1) && !empty($checkAbsen->check_in2) && !empty($checkAbsen->check_out2)){
//                                         DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'check_in3'  => $clock,
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }elseif(!empty($checkAbsen->check_out) && $clock <= $refKerja->workout && $clock >= $workInBefore){
//                                         $test = DB::connection('mysql2')->table($dbName)->where([
//                                             ['pid', $row->pid],
//                                             [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                         ])->update([
//                                             'check_in'  => $clock,
//                                             'sync_date'=>   $row->date,
//                                             'updated_at'=> Carbon::now()
//                                         ]);
//                                     }else{
//                                         if(!empty($checkAbsen->check_in3) && $clock >= $refKerja->workout && $clock >= $workOutBefore){
//                                             DB::connection('mysql2')->table($dbName)->where([
//                                                 ['pid', $row->pid],
//                                                 [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                             ])->update([
//                                                 'check_out3'  => $clock,
//                                                 'sync_date'=>   $row->date,
//                                                 'updated_at'=> Carbon::now()
//                                             ]);
//                                         }elseif(!empty($checkAbsen->absen1)){
//                                             DB::connection('mysql2')->table($dbName)->where([
//                                                 ['pid', $row->pid],
//                                                 [DB::raw('DATE(sync_date)'), date('Y-m-d', strtotime($row->date))] 
//                                             ])->update([
//                                                 'pid'       => $row->pid,
//                                                 'sap'       => $pegawai->sap,
//                                                 'absen2'    => $clock,
//                                                 'telat'     => '00:00:00',
//                                                 'sync_date'=>   $row->date,
//                                                 'updated_at'=> Carbon::now()
//                                             ]);
//                                         }
//                                     }
// 				}
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }

//             $absenMentah = DB::select("
//                 DELETE FROM absen_mentahs
//             ");

//             AbsenLog::insert([
//                 'mesin_id'      => $mesin->id,
//                 'status_absen'  => 'Tarik Absen',
//                 'created_at'    => Carbon::now(),
//                 'updated_at'    => Carbon::now()
//             ]);
        
//         }else{
//             Session::put('sweetalert', 'error');
//             return response()->json(['errors' => 'Gagal Import Data Absensi! Mungkin data sudah terhapus!']);
//         }
    // }
}
