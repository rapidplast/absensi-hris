<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Alasan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AlasanController extends Controller
{
    function index(){
        $alasan = Alasan::all();
        return view('admin.alasan.index', compact(['alasan']));
    }

    function insert(){
        return view('admin.alasan.insert');
    }

    function store(Request $request){
        $validate = Validator::make($request->all(),[
            'nama'      => 'required',
            'cuti'      => 'required',
            'rot'       => 'required',
            'tunha'     => 'required'
        ], [
            'nama.required'         => 'Nama Harus Diisi!',
            'cuti.required'         => 'Cuti Harus Diisi!',
            'rot.required'         => 'ROT Harus Diisi!',
            'tunha.required'         => 'Tunha Harus Diisi!',
        ]);
        
        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Alasan!')->withErrors($validate);
        }

        Alasan::insert([
            'nama'          => $request->nama,
            'cuti'          => $request->cuti,
            'rot'           => $request->rot,
            'tunha'         => $request->tunha,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->route('alasan')->with('alert', 'Sukses Menambahkan Data');

    }

    function edit($id){
        $alasan = Alasan::find($id);
        return view('admin.alasan.edit', compact(['alasan']));
    }

    function update(Request $request,  $id){
        $validate = Validator::make($request->all(),[
            'nama'      => 'required',
            'cuti'      => 'required',
            'rot'       => 'required',
            'tunha'     => 'required'
        ], [
            'nama.required'        => 'Nama Harus Diisi!',
            'cuti.required'        => 'Cuti Harus Diisi!',
            'rot.required'         => 'ROT Harus Diisi!',
            'tunha.required'       => 'Tunha Harus Diisi!',
        ]);
        
        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Mengubah Alasan!')->withErrors($validate);
        }

        Alasan::where('id', $id)->update([
            'nama'          => $request->nama,
            'cuti'          => $request->cuti,
            'rot'           => $request->rot,
            'tunha'         => $request->tunha,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->back()->with('alert', 'Sukses Mengubah Data');
    }

    function destroy($id){
        $alasan = Alasan::find($id);
        if($alasan){
            Alasan::where('id', $id)->delete();
        }
    }
}
