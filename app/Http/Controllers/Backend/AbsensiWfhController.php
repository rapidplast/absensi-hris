<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiWfhController extends Controller
{
    public function index(Request $request)
    {
        if($request->method() == 'GET'){
            $tanggalSekarang = Carbon::now()->format('Y-m-d');
            $month = Carbon::now()->format('m');
            $absensiwfh = DB::select("
                SELECT p.*, aw.*, p.id as p_id, aw.id as aw_id
                FROM  pegawais p, absensi_wfhs aw
                WHERE p.id = aw.pegawai_id AND DATE(aw.created_at) = '$tanggalSekarang'
                ORDER BY aw.id DESC
            ");

            return view('admin.absensiwfh.index', compact(['absensiwfh', 'tanggalSekarang']));
        }else{
            $tanggal = $request->tanggal;
            $tanggal2 = $request->tanggal2;
            $absensiwfh = DB::select("
                SELECT p.*, aw.*, p.id as p_id, aw.id as aw_id
                FROM  pegawais p, absensi_wfhs aw
                WHERE p.id = aw.pegawai_id AND DATE(aw.created_at) >= '$tanggal' AND DATE(aw.created_at) <= '$tanggal2'
                ORDER BY aw.id DESC
            ");
            return view('admin.absensiwfh.index', compact(['absensiwfh', 'tanggal', 'tanggal2']));
        }
    }
}
