<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Divisi;
use App\Models\Pegawai;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\isNull;

class LaporanAbsensiController extends Controller
{
    public function index(Request $request){
        if($request->method() == 'GET'){
            $tanggalSekarang = Carbon::now()->format('Y-m-d');
            $departement = Departement::all();
            $divisi = Divisi::all();
            $pegawai = Pegawai::all();
            return view('admin.laporanabsensi.index', compact(['tanggalSekarang', 'departement', 'divisi','pegawai']));
        }else{
            $tanggal = $request->tanggal;
            $tanggal2 = $request->tanggal2;
            $departement = Departement::all();
            $pegawai = Pegawai::all();
            $divisi = Divisi::all();
            $checkMonth1 = date('m', strtotime($request->tanggal));
            $checkMonth2 = date('m', strtotime($request->tanggal2));
            

            if($checkMonth1 == $checkMonth2){
                $year = date('Y', strtotime($tanggal));
                $month = date('m', strtotime($tanggal));
                $dbName = $year.''.$month.'HISTORY';
                
                if(!is_null($request->nipAwal) && !is_null($request->nipAkhir)){
                    $absensi = DB::select(
                        "SELECT afh.pid, p.nama, p.departement, count(afh.sync_date) as total_absen
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                        WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2' AND afh.pid >= '$request->nipAwal' AND afh.pid <= '$request->nipAkhir'
                        GROUP BY p.pid
                        ORDER BY afh.id DESC"
                    );
                }elseif(!is_null($request->departementAwal) && $request->departementAkhir){
                    $absensi = DB::select(
                        "SELECT afh.pid, p.nama, p.departement, count(afh.sync_date) as total_absen
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                        WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2' AND p.departement_id = '$request->departementAwal' OR p.departement_id = '$request->departementAkhir'
                        GROUP BY p.pid
                        ORDER BY afh.id DESC"
                    );
                }elseif(!is_null($request->divisiAwal) && !is_null($request->divisiAkhir)){
                    $absensi = DB::select(
                        "SELECT afh.pid, p.nama, p.departement, count(afh.sync_date) as total_absen
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                        WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2' AND p.divisi_id = '$request->divisiAwal' OR p.divisi_id = '$request->divisiAkhir'
                        GROUP BY p.pid
                        ORDER BY afh.id DESC"
                    );
                }else{
                    $absensi = DB::select(
                        "SELECT afh.pid, p.nama, p.departement, count(afh.sync_date) as total_absen
                        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
                        WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2'
                        GROUP BY p.pid
                        ORDER BY afh.id DESC"
                    );
                }
            }else{
                Session::put('sweetalert', 'error');
                return redirect()->back()->with(['errors' => 'Gagal Export Laporan Absensi! Harus 1 Bulan!']);
            }
            
            return view('admin.laporanabsensi.index', compact(['tanggal', 'tanggal2', 'departement', 'divisi', 'absensi', 'request']));
        }
    }

    public function cetak(Request $request)
    {

        $tanggal = $request->tanggal;
        $tanggal2 = $request->tanggal2;
        $checkMonth1 = date('m', strtotime($request->tanggal));
        $checkMonth2 = date('m', strtotime($request->tanggal2));
        //
        // $array = [];
        //     $period     = new DatePeriod(
        //         new DateTime($tanggal),
        //         new DateInterval('P1D'),
        //         new DateTime($tanggal2)
        //     );
        //     foreach($period as $date){  
        //         $array[]=$date->format('Y-m-d');
        //     }
        //     print_r($array);
            //
        if ($checkMonth1 == $checkMonth2) {
            $year = date('Y', strtotime($tanggal));
            $month = date('m', strtotime($tanggal));
            $dbName = $year.''.$month.'HISTORY';

            
            if(!is_null($request->nipAwal) && !is_null($request->nipAkhir)){
                $pegawai = DB::select("
                    SELECT pid, nama, departement_id, divisi_id, regukerja_id
                    FROM pegawais
                    where pid >= '$request->nipAwal' AND  pid <= '$request->nipAkhir'
                ");
            }elseif(!is_null($request->departementAwal) && $request->departementAkhir){
                $pegawai = DB::select("
                    SELECT pid, nama, departement_id, divisi_id, regukerja_id
                    FROM pegawais
                    where departement_id = '$request->departementAwal' AND divisi_id = '$request->departementAkhir'
                ");
            }elseif(!is_null($request->divisiAwal) && !is_null($request->divisiAkhir)){
                $pegawai = DB::select("
                    SELECT pid, nama, departement_id, divisi_id, regukerja_id
                    FROM pegawais
                    where departement_id = '$request->divisiAwal' AND divisi_id = '$request->divisiAkhir'
                ");
            }elseif(!is_null($request->pegawai_name)){
                $pegawai = DB::select("
                SELECT pid, nama, departement_id, divisi_id, regukerja_id
                FROM pegawais
                where pid = '$request->pegawai_name' 
            ");
            }
            else{
                return redirect()->back()->with('alert', 'Gagal Export Laporan Absensi! Harus Memilih Kategori!');
            }
        }else{
            return redirect()->back()->with('alert', 'Gagal Export Laporan Absensi! Harus 1 Bulan!');
        }

        $pdf = PDF::loadview('admin.laporanabsensi.cetak', [
            'pegawai'   => $pegawai,
            'tanggal'   => $tanggal,
            'tanggal2'  => $tanggal2,
            'dbName'    => $dbName
         ]);
    	return $pdf->stream();
    }
}
