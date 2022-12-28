<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Mesin;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\ReferensiKerja;
use App\Models\ReguKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use ZKLibrary;

class PegawaiController extends Controller
{
    function index(){
        $pegawai = DB::select("
            SELECT p.id, p.user_id, p.pid, p.nama, p.no_ktp, p.alamat, p.sap, p.email, p.departement_id, p.regukerja_id
            FROM pegawais p
            ORDER BY p.id ASC
        ");

        return view('admin.pegawai.index', compact(['pegawai']));
    }

    function create(){
        $jabatan = Jabatan::all();
        $departement = Departement::all();
        $divisi      = Divisi::all();
        $reguKerja = ReguKerja::all();
        return view('admin.pegawai.create', compact(['jabatan', 'departement', 'divisi', 'reguKerja']));
    }

    function store(Request $request){
        // $this->validate($request, [
        //     'nama'          => 'required',
        //     'jabatan_id'    => 'required',
        //     'no_ktp'        => 'required|unique:pegawais',
        //     'departement'   => 'required',
        //     'email'         => 'required|unique:users',
        //     'sap'           => 'required',
        //     'pid'           => 'required'
        // ], [
        //     'nama.required'         =>  'Nama Harus Diisi!',
        //     'jabatan_id.required'   =>  'Jabatan Harus Diisi!',
        //     'no_ktp.required'       =>  'Nomor KTP Harus Diisi!',
        //     'no_ktp.unique'         =>  'Nomor KTP Harus Berbeda!',
        //     'departement.required'  =>  'Departement Harus Diisi!',
        //     'email.required'        =>  'Email Harus Diisi!',
        //     'sap.required'          =>  'SAP Harus Diisi!',
        //     'email.unique'          =>  'Email Harus Berbeda!',
        //     'pid.required'          =>  'PID Harus Diisi!'
        // ]);

        $this->validate($request, [
            'nama'          => 'required',
            'pid'           => 'required'
        ], [
            'nama.required'         =>  'Nama Harus Diisi!',
            'pid.required'          =>  'PID Harus Diisi!'
        ]);

        $user               = new User();
        $user->role_id      = 2;
        $user->name         = $request->nama;
        $user->email        = $request->email;
        $user->password     = bcrypt('pegawai');
        $user->created_at   = Carbon::now();
        $user->updated_at   = Carbon::now();
        $user->save();

        $pegawai = Pegawai::findOrCreate([
            'user_id'           => $user->id,
            'jabatan_id'        => $request->jabatan_id,
            'departement_id'    => $request->departement,
            'divisi_id'         => $request->divisi,
            'regukerja_id'      => $request->regukerja_id,
            'pid'               => $request->pid,
            'nama'              => $request->nama,
            'no_ktp'            => $request->no_ktp,
            'email'             => $request->email,
            'sap'               => $request->nsap,
            'alamat'            => $request->alamat,
        ]);
        
        Session::put('sweetalert', 'success');
        return redirect()->route('pegawai')->with('alert', 'Sukses Menambahkan Data');
    }

    function edit($id){
        $pegawai = Pegawai::where('id', $id)->first();
        
        // $pegawai = Pegawai::find($id);
        $jabatan = Jabatan::all();
        $divisi = Divisi::all();
        $departement = Departement::all();
        $reguKerja = ReguKerja::all();
        return view('admin.pegawai.edit', compact(['pegawai', 'id', 'jabatan', 'divisi', 'departement', 'reguKerja']));
    // dd($id);
    }

    function update(Request $request, $id){
        // $this->validate($request, [
        //     'nama'          => 'required',
        //     'email'         => 'required'
        // ], [
        //     'nama.required'         =>  'Nama Harus Diisi!',
        //     'email.required'        =>  'Email Harus Diisi!'
        // ]);

        // ***** GET MONTH NOW ***** //
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

        // ***** Variable for check if table is exist ***** //
        $dbCheck4 = Schema::connection('mysql2')->hasTable($dbName4);
        $dbCheck3 = Schema::connection('mysql2')->hasTable($dbName3);
        $dbCheck2 = Schema::connection('mysql2')->hasTable($dbName2);
        $dbCheck1 = Schema::connection('mysql2')->hasTable($dbName1);


        $pegawai = Pegawai::where('id', $id)->first();

        // User::where('id', $pegawai->user_id)->update([
        //     'email'         => $request->email,
        //     'updated_at'    => Carbon::now()
        // ]);

        DB::connection('mysql2')->table($dbName)->where('pid', $pegawai->pid)->update([
            'pid'   => $request->pid,
            'sap'   => $request->nsap
        ]);

        // ***** when data sap or pid update, changes pid or sap in frhistory ***** //
        if($dbCheck4 === true){
            DB::connection('mysql2')->table($dbName4)->where('pid', $pegawai->pid)->update([
                'pid'   => $request->pid,
                'sap'   => $request->nsap
            ]);
        }
        if($dbCheck3 === true){
            DB::connection('mysql2')->table($dbName3)->where('pid', $pegawai->pid)->update([
                'pid'   => $request->pid,
                'sap'   => $request->nsap
            ]);
        }
        if($dbCheck2 === true){
            DB::connection('mysql2')->table($dbName2)->where('pid', $pegawai->pid)->update([
                'pid'   => $request->pid,
                'sap'   => $request->nsap
            ]);
        }
        if($dbCheck1 === true){
            DB::connection('mysql2')->table($dbName1)->where('pid', $pegawai->pid)->update([
                'pid'   => $request->pid,
                'sap'   => $request->nsap
            ]);
        }

        Pegawai::where('id', $id)->update([
            'jabatan_id'        => $request->jabatan_id,
            'departement_id'    => $request->departement,
            'divisi_id'         => $request->divisi,
            'regukerja_id'      => $request->regukerja_id,
            'pid'               => $request->pid,
            'nama'              => $request->nama,
            'no_ktp'            => $request->no_ktp,
            'departement'       => $request->departement,
            'email'             => $request->email,
            'sap'               => $request->nsap,
            'alamat'            => $request->alamat,
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->route('editPegawai', $id)->with('alert', 'Sukses Mengubah '.$pegawai->nama);
    }

    function destroy($id){
        $pegawai = Pegawai::where('id', $id)->first();
        if(!empty($pegawai)){
            // User::where('id', $pegawai->user_id)->delete();
            Pegawai::where('id', $id)->delete();
        }
    }

    function syncPegawai(){
        $mesin  = Mesin::where('is_default', 1)->first();
        $port = 4370;

        $zk = new ZKLibrary($mesin->tcpip, $port);
        $zk->connect();
        $pegawai = $zk->getUser();
        // return response()->json($pegawai);

        foreach($pegawai as $data){
            $check = Pegawai::where('pid', $data[0])->first();
            $email = User::where('email', $data[1].'@gmail.com')->first();
            if(empty($check)){
                $user               = new User();
                $user->role_id      = 2;
                $user->name         = $data[1];
                if($email){
                    $user->email        = $data[1].''.rand(10,100).'2@gmail.com';
                }else{
                    $user->email        = $data[1].'@gmail.com';
                }
                $user->password     = bcrypt('pegawai');
                $user->created_at   = Carbon::now();
                $user->updated_at   = Carbon::now();
                $user->save();

                Pegawai::insert([
                    'user_id'       => $user->id,
                    'jabatan_id'    => 61,
                    'pid'           => $data[0],
                    'nama'          => $data[1],
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ]);
            }
        }
        Session::put('sweetalert', 'success');
        return redirect()->back()->with('alert', 'Sukses Menambahkan pegawai dari mesin fingerprint '.$mesin->ip);
    }
}
