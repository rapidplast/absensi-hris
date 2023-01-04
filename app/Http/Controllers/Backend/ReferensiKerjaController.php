<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ReferensiKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReferensiKerjaController extends Controller
{
    function index(){
        $referensiKerja = ReferensiKerja::all();
        return view('admin.referensikerja.index', compact(['referensiKerja']));
    }

    function insert(){
        return view('admin.referensikerja.insert');
    }

    function store(Request $request){
        $validate = Validator::make($request->all(),[
            'nama'              => 'required',
        ], [
            'nama.required'          => 'Nama Harus Diisi!',
        ]);
        
        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Divisi!')->withErrors($validate);
        }

        ReferensiKerja::insert([
            'nama'      => $request->nama,
            'workin'    => $request->workin,
            'restout'   => $request->restout,
            'restin'    => $request->restin,
            'workout'   => $request->workout,
            'total_jam' => $request->total_jam,
            'rangerestout'  => $request->rangerestout,
            'rangerestin'  => $request->rangerestin
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->route('referensiKerja')->with('alert', 'Sukses Menambahkan Data');
    }

    function edit($id){
        $referensiKerja = ReferensiKerja::find($id);
        return view('admin.referensikerja.edit', compact(['referensiKerja']));
    }

    function update(Request $request, $id){
        $validate = Validator::make($request->all(),[
            'nama'              => 'required',
        ], [
            'nama.required'          => 'Nama Harus Diisi!',
        ]);
        
        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Divisi!')->withErrors($validate);
        }

        ReferensiKerja::where('id', $id)->update([
            'nama'      => $request->nama,
            'workin'    => $request->workin,
            'restout'   => $request->restout,
            'restin'    => $request->restin,
            'workout'   => $request->workout,
            'total_jam' => $request->total_jam,
            'rangerestout'  => $request->rangerestout,
            'rangerestin'  => $request->rangerestin
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->back()->with('alert', 'Sukses Menambahkan Data');
    }

    function destroy($id){
        $referensiKerja = ReferensiKerja::find($id);
        if($referensiKerja){
            ReferensiKerja::where('id', $id)->delete();
        }
    }
}
