<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    function index(){
        $departement = Departement::all();
        return view('admin.departement.index', compact(['departement']));
    }

    function insert(){
        return view('admin.departement.insert');
    }

    function store(Request $request){
        $validate = Validator::make($request->all(),[
            'kode'      => 'required',
            'nama'      => 'required',
            'plant'     => 'required'
        ], [
            'kode.required'         => 'Kode Harus Diisi!',
            'nama.required'         => 'Nama Harus Diisi!',
            'plant.required'        => 'Plant Harus Diisi!',
        ]);

        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Departement!')->withErrors($validate);
        }

        Departement::insert([
            'kode'          => $request->kode,
            'nama'          => $request->nama,
            'plant'         => $request->plant,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->route('departement')->with('alert', 'Sukses Menambahkan Data');
    }

    function edit($id){
        $departement = Departement::find($id);
        // return response()->json($departement);
        // dd($departement);
        return view('admin.departement.edit', compact(['departement']));
    }

    function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'kode'      => 'required',
            'nama'      => 'required',
            'plant'     => 'required'
        ], [
            'kode.required'         => 'Kode Harus Diisi!',
            'nama.required'         => 'Nama Harus Diisi!',
            'plant.required'        => 'Plant Harus Diisi!',
        ]);

        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Mengedit Departement!')->withErrors($validate);
        }

        Departement::where('id', $id)->update([
            'kode'      => $request->kode,
            'nama'      => $request->nama,
            'plant'     => $request->plant,
            'updated_at'    => Carbon::now()
        ]);

        Session::put('sweetalert', 'success');
        return redirect()->back()->with('alert', 'Sukses Mengedit Data Departement');
    }

    function destroy($id){
        $departement = Departement::find($id);
        if($departement){
            Departement::where('id', $id)->delete();
        }
    }
}
