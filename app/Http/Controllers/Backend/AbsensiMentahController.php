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
class AbsensiMentahController extends Controller
{
    function index(Request $request){
        if($request->method() == 'GET'){
            $date = Carbon::now()->format('Y-m-d');
            $tanggal = Carbon::now()->format('d F Y');
            $tanggalCetak = Carbon::now()->format('Y-m-d');
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            $dbName = $year.''.$month.'HISTORY';
            $date = Carbon::now()->format('Y-m-d');
            $absensi = DB::select(
                "SELECT afh.pid, p.nama, p.departement,(DATE(afh.date)) as tanggal, (TIME(afh.date)) as jam 
                FROM absensi_fingerprint.pegawais p, absen_mentahs afh 
                WHERE p.pid = afh.pid AND DATE(afh.date) >= '$tanggal' and DATE(afh.date)<='$tanggalCetak'
                ORDER BY afh.id ASC"
            );

            return view('admin.log.index', compact(['absensi', 'tanggal', 'date', 'tanggalCetak', 'dbName']));
        }else{
            $date = Carbon::now()->format('Y-m-d');
            $year = date('Y', strtotime($request->tanggal));
            $month = date('m', strtotime($request->tanggal));
            $dbName = $year.''.$month.'HISTORY';
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            $tanggal2 = date('Y-m-d', strtotime($request->tanggal2));
            $tanggalCetak = date('Y-m-d', strtotime($request->tanggal));
            $absensi = DB::select(
            "SELECT afh.pid, p.nama, p.departement,(DATE(afh.date)) as tanggal, (TIME(afh.date)) as jam 
            FROM absensi_fingerprint.pegawais p, absen_mentahs afh 
            WHERE p.pid = afh.pid AND DATE(afh.date) >= '$tanggal' and DATE(afh.date)<='$tanggal2'
            ORDER BY afh.id ASC"
        );
        return view('admin.log.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName']));
    }
    }
}
