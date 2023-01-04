<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DivisiController extends Controller
{
    function index(){
        $divisi = Divisi::all();
        return view('admin.divisi.index', compact(['divisi']));
    }

    function insert(){
        return view('admin.divisi.insert');
    }

    function store(Request $request){
        $validate = Validator::make($request->all(),[
            'kode'      => 'required',
            'nama'      => 'required',
        ], [
            'kode.required'         => 'Kode Harus Diisi!',
            'nama.required'         => 'Nama Harus Diisi!',
        ]);

        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Divisi!')->withErrors($validate);
        }

        Divisi::insert([
            'kode'          => $request->kode,
            'nama'          => $request->nama,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->route('divisi')->with('alert', 'Sukses Menambahkan Data');
    }

    function edit($id){
        $divisi = Divisi::find($id);
        return view('admin.divisi.edit', compact(['divisi']));
    }

    function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'kode'      => 'required',
            'nama'      => 'required',
        ], [
            'kode.required'         => 'Kode Harus Diisi!',
            'nama.required'         => 'Nama Harus Diisi!',
        ]);

        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Mengedit Divisi!')->withErrors($validate);
        }

        Divisi::where('id', $id)->update([
            'kode'      => $request->kode,
            'nama'      => $request->nama,
            'updated_at'    => Carbon::now()
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->back()->with('alert', 'Sukses Mengedit Data Divisi');
    }

    function destroy($id){
        $divisi = Divisi::find($id);
        if($divisi){
            Divisi::where('id', $id)->delete();
        }
    }
}
