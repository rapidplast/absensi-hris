<?php

namespace App\Http\Controllers\Backend;

use App\Exports\AbsenMentahExport;
use App\Exports\AbsenMentahExportSearch;
use App\Http\Controllers\Controller;
use App\Models\AbsenMentah;
use App\Models\Jadwal;
use App\Models\Pegawai;
use App\Models\ReferensiKerja;
use App\Models\ReguKerja;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;

class cetakTxtController extends Controller
{
    public function cetakTXT($tanggal, $dbName)
    {
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $absen = DB::connection('mysql2')->table($dbName)
                ->select('pid', DB::raw("DATE_FORMAT(sync_date, '%d.%m.%Y%H:%i:%s') as sync_date"), 'check_in', 'check_out')
                ->where(DB::raw('DATE(sync_date)'), $tanggal)
                ->get();

        // return response()->json($absen);

                $txt = "\tNO.IDTgl/Waktu\t  Status";                
                $txt .= "\r\n";
                // return response()->json($txt);
                foreach($absen as $data){
                    $sap = Pegawai::where('pid', $data->pid)->value('sap');
                    // return response()->json($sap);
                    $pegawai = Pegawai::where('pid', $data->pid)->first();
                    // return response()->json($pegawai);
                    if(!empty($sap) && $sap != 0){
                        $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                        // return response()->json($reguKerja);
                        if(!empty($reguKerja)){
                            $tglStart = strtotime($reguKerja->tgl_start);
                            $tglReq = strtotime($data->sync_date);
                            $range = $tglReq - $tglStart;
                            $range = $range / 60 /60 /24;
                            $hari  = $range%$reguKerja->hari;
                            if($hari === 0){
                                $hari = $reguKerja->hari;
                            }
        
                            // Get Jadwals
                            $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                            // return response()->json($jadwal);
                            // Get Ref Kerja
                            $refKerja = ReferensiKerja::where('kode', $jadwal[$hari])->first();
                            // return response()->json($refKerja);
                            $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
                            $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));
                            // return response()->json($data->check_in);
                            // return response()->json($sap);
                            if(!empty($data->check_in)){
                                // return response()->json(strlen($data->check_in <= $refKerja->workout));
                                if(strlen($sap) === 0){
                                    $txt .="\r\n        ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 1){
                                    $txt .="\r\n       ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 2){
                                    $txt .="\r\n      ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 3){
                                    $txt .="\r\n     ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 4){
                                    $txt .="\r\n    ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 5){
                                    $txt .="\r\n   ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                    // return response()->json(!empty($data->check_in));
                                }elseif(strlen($sap) == 6){
                                    $txt .="\r\n  ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 7){
                                    $txt .="\r\n ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }else{
                                    $txt .="\r\n".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }
                            }
                            if(!empty($data->check_out)){
                                if(strlen($sap) === 0){
                                    $txt .="\r\n        ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 1){
                                    $txt .="\r\n       ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 2){
                                    $txt .="\r\n      ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 3){
                                    $txt .="\r\n     ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 4){
                                    $txt .="\r\n    ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 5){
                                    $txt .="\r\n   ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 6){
                                    $txt .="\r\n  ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 7){
                                    $txt .="\r\n ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }else{
                                    $txt .="\r\n".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }
                            }
                        }
                    }
                }
        return response($txt)
        ->withHeaders([
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'attachment; filename="Tarik Absen '.$tanggal.'.txt"',
        ]);
    }

    public function cetakTXTSearch($tanggal, $tanggal2, $dbName)
    {

        $absen = DB::connection('mysql2')->table($dbName)
                ->select('pid', DB::raw("DATE_FORMAT(sync_date, '%d.%m.%Y%H:%i:%s') as sync_date"), 'check_in', 'check_out')
                ->whereDate(DB::raw('DATE(sync_date)'), '>=',$tanggal)
                ->whereDate(DB::raw('DATE(sync_date)'), '<=',$tanggal2)
                ->get();

                $txt = "\tNO.IDTgl/Waktu\t  Status";
                $txt .= "\r\n";
                foreach($absen as $data){
                    $sap = Pegawai::where('pid', $data->pid)->value('sap');
                    if(!empty($sap) && $sap != 0){
                        $pegawai = Pegawai::where('pid', $data->pid)->first();
                        $reguKerja = ReguKerja::where('kode', $pegawai->regukerja_id)->first();
                        if(!empty($reguKerja)){
                            $tglStart = strtotime($reguKerja->tgl_start);
                            $tglReq = strtotime($data->sync_date);
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
			    if($refKerja !== null || !empty($refKerja)){
			    $workInBefore = date('H:i:s', (strtotime($refKerja->workin) - strtotime('01:00:00')));
                            $workOutBefore = date('H:i:s', (strtotime($refKerja->workout) - strtotime('01:00:00')));
        
                            if(!empty($data->check_in)){
                                if(strlen($sap) === 0){
                                    $txt .="\r\n        ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 1){
                                    $txt .="\r\n       ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 2){
                                    $txt .="\r\n      ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 3){
                                    $txt .="\r\n     ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 4){
                                    $txt .="\r\n    ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 5){
                                    $txt .="\r\n   ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 6){
                                    $txt .="\r\n  ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }elseif(strlen($sap) == 7){
                                    $txt .="\r\n ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }else{
                                    $txt .="\r\n".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_in.'P10';
                                }
                            }
                            if(!empty($data->check_out)){
                                if(strlen($sap) === 0){
                                    $txt .="\r\n        ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 1){
                                    $txt .="\r\n       ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 2){
                                    $txt .="\r\n      ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 3){
                                    $txt .="\r\n     ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 4){
                                    $txt .="\r\n    ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 5){
                                    $txt .="\r\n   ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 6){
                                    $txt .="\r\n  ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }elseif(strlen($sap) == 7){
                                    $txt .="\r\n ".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }else{
                                    $txt .="\r\n".$sap.''.date('d.m.Y', strtotime($data->sync_date)).''.$data->check_out.'P20';
                                }
                            }
			    }
                        }
                    }
                }
        return response($txt)
        ->withHeaders([
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'attachment; filename="Tarik Absen '.$tanggal.' sampai '.$tanggal2.'.txt"',
        ]);
    }
}