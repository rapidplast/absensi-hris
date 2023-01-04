<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesin;
use Illuminate\Support\Facades\Session;
use ZKLibrary;

class MesinController extends Controller
{
    function index(){
        $mesin = Mesin::all();
        return view('admin.mesin.index', compact(['mesin']));
    }

    function create(){
        return view('admin.mesin.create');
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'tcpip'         => 'required',
            'serial_number' => 'required|unique:mesins',
            'tipe'          => 'required',
        ], [
            'name.required'             => 'Nama Mesin Harus Diisi!',
            'tcpip.required'            => 'TCP IP Mesin Harus Diisi!',
            'serial_number.required'    => 'Serial Number Mesin Harus Diisi!',
            'serial_number.unique'      => 'Serial Number Mesin Harus Berbeda!',
            'tipe.required'             => 'Tipe Mesin Harus Diisi!',
        ]);

        if($request->is_default == 1){
            Mesin::where('is_default', $request->is_default)->update([
                'is_default'    => 0
            ]);
        }

        Mesin::insert([
            'name'          => $request->name,
            'tcpip'         => $request->tcpip,
            'serial_number' => $request->serial_number,
            'tipe'          => $request->tipe,
            'is_default'    => $request->is_default ? $request->is_default : 0
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->route('mesin')->with('alert', 'Sukses Menambahkan Data!');
    }

    function defaultMesin($id){
        $mesin = Mesin::select('is_default')->where([
                ['id', $id],
                ['is_default', 1]
            ])->get();
        if(!empty($mesin)){
            Mesin::where('is_default', 1)->update([
                'is_default' => 0
            ]);

            Mesin::where('id', $id)->update([
                'is_default' => 1
            ]);
        }else{
            Mesin::where('id', $id)->update([
                'is_default' => 1
            ]);
        }
    }

    function edit($id){
        $mesin = Mesin::where('id', $id)->first();
        return view('admin.mesin.edit', compact(['mesin']));
    }

    function update(Request $request, $id){
        $this->validate($request, [
            'name'          => 'required',
            'tcpip'         => 'required',
            'serial_number' => 'required',
            'tipe'          => 'required',
        ], [
            'name.required'             => 'Nama Mesin Harus Diisi!',
            'tcpip.required'            => 'TCP IP Mesin Harus Diisi!',
            'serial_number.required'    => 'Serial Number Mesin Harus Diisi!',
            'tipe.required'             => 'Tipe Mesin Harus Diisi!',
        ]);

        if($request->is_default == 1){
            Mesin::where('is_default', $request->is_default)->update([
                'is_default'    => 0
            ]);
        }

        Mesin::where('id', $id)->update([
            'name'          => $request->name,
            'tcpip'         => $request->tcpip,
            'serial_number' => $request->serial_number,
            'tipe'          => $request->tipe,
            'is_default'    => $request->is_default ? $request->is_default : 0
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->route('mesin')->with('alert', 'Sukses Mengubah Data!');
    }

    function destroy($id){
        $mesin = Mesin::where('id', $id)->first();
        if(!empty($mesin)){
            Mesin::where('id', $id)->delete();
        }
    }

    function deleteDataMesin($id){
        $mesin  = Mesin::where('id', $id)->first();
        $port = 4370;

        $zk = new ZKLibrary($mesin->tcpip, $port);
        $zk->connect();
        $zk->clearAttendance();
        $zk->disconnect();
    }
}
