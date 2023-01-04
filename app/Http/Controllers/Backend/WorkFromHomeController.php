<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Wfh;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WorkFromHomeController extends Controller
{
    public function index(Request $request)
    {
        if($request->method() == 'GET'){
            $tanggalSekarang = Carbon::now()->format('Y-m-d');
            $month = Carbon::now()->format('m');
            $wfh = DB::select("
                SELECT p.*, w.*, p.id as p_id, w.id as w_id
                FROM  pegawais p, wfhs w
                WHERE p.id = w.pegawai_id AND MONTH(w.tanggal_cuti) = '$month'
                ORDER BY w.id DESC
            ");

            return view('admin.wfh.index', compact(['wfh', 'tanggalSekarang']));
        }else{
            $tanggal = $request->tanggal;
            $tanggal2 = $request->tanggal2;
            $wfh = DB::select("
                SELECT p.*, w.*, p.id as p_id, w.id as w_id
                FROM  pegawais p, wfhs w
                WHERE p.id = w.pegawai_id AND DATE(w.tanggal_cuti) >= '$tanggal' AND DATE(w.tanggal_cuti) <= '$tanggal2'
                ORDER BY w.id DESC
            ");
            return view('admin.wfh.index', compact(['wfh', 'tanggal', 'tanggal2']));
        }
    }

    public function konfirmasi($id)
    {
        $wfh = Wfh::find($id);
        if($wfh){
            Wfh::where('id', $id)->update([
                'status'        => 2,
                'updated_at'    => Carbon::now()
            ]);
            Session::put('sweetalert', 'error');
            return response()->json(['errors' => 'Berhasil Konfirmasi Data!']);
        }else{
            Session::put('sweetalert', 'error');
            return response()->json(['errors' => 'Gagal Konfirmasi Data! Something Error!']);
        }
    }

    public function tolak($id)
    {
        $wfh = Wfh::find($id);
        if($wfh){
            Wfh::where('id', $id)->update([
                'status'        => 1,
                'updated_at'    => Carbon::now()
            ]);
            Session::put('sweetalert', 'error');
            return response()->json(['errors' => 'Berhasil Konfirmasi Data!']);
        }else{
            Session::put('sweetalert', 'error');
            return response()->json(['errors' => 'Gagal Konfirmasi Data! Something Error!']);
        }
    }
}
