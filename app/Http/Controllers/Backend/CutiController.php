<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        if($request->method() == 'GET'){
            $tanggalSekarang = Carbon::now()->format('Y-m-d');
            $month = Carbon::now()->format('m');
            $cuti = DB::select("
                SELECT p.*, c.*, p.id as p_id, c.id as c_id
                FROM  pegawais p, cuties c
                WHERE p.id = c.pegawai_id AND MONTH(c.tanggal_cuti) = '$month'
                ORDER BY c.id DESC
            ");
            return view('admin.cuti.index', compact(['cuti', 'tanggalSekarang']));
        }else{
            $tanggal = $request->tanggal;
            $tanggal2 = $request->tanggal2;
            $cuti = DB::select("
                SELECT p.*, c.*, p.id as p_id, c.id as c_id
                FROM  pegawais p, cuties c
                WHERE p.id = c.pegawai_id AND DATE(c.tanggal_cuti) >= '$tanggal' AND DATE(c.tanggal_cuti) <= '$tanggal2'
                ORDER BY c.id DESC
            ");
            return view('admin.cuti.index', compact(['cuti', 'tanggal', 'tanggal2']));
        }
    }

    public function konfirmasi($id)
    {
        $cuti = Cuti::find($id);
        if($cuti){
            Cuti::where('id', $id)->update([
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
        $cuti = Cuti::find($id);
        if($cuti){
            Cuti::where('id', $id)->update([
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
