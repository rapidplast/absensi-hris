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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SelfAttController extends Controller
{
    function index(Request $request){
        // dd(Auth()->user()->role->id);
        $absen = Pegawai::where('email', auth()->user()->email)-> first();
        $email = auth()->user()->email;

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
                FROM absensi_fingerprint.pegawais p
								LEFT JOIN absensi_fingerprint.users a ON (p.email = a.email)
								LEFT JOIN absensi_frhistory.$dbName afh ON (p.pid = afh.pid)
								WHERE
								p.pid = '$absen->pid' "
            );

            return view('admin.self.index', compact(['absensi', 'tanggal', 'date', 'tanggalCetak', 'dbName']));
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
                FROM absensi_fingerprint.pegawais p
								LEFT JOIN absensi_fingerprint.users a ON (p.email=a.email)
								LEFT JOIN absensi_frhistory.$dbName afh ON (p.pid = afh.pid)
								WHERE
                                DATE(afh.sync_date) BETWEEN '$tanggal' and '$tanggal2' and 
								p.pid = '$absen->pid'"
            );

            return view('admin.self.index', compact(['absensi', 'tanggal', 'date', 'tanggal2', 'tanggalCetak', 'dbName']));
        }
    }
}
