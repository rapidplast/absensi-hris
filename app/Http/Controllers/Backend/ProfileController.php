<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    function index($id){
        $profil = User::where('id', $id)->first();
        return view('admin.profil.index', compact(['profil', 'id']));
    }

    function edit(Request $request, $id){
        $validate = Validator::make($request->all(),[
            'name'      => 'required',
            'email'      => 'required',
        ], [
            'name.required'         => 'Nama Harus Diisi!',
            'email.required'         => 'Email Harus Diisi!',
        ]);

        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Mengubah Data Diri!')->withErrors($validate);
        }

        if(!empty($request->password)){
            User::where('id', $id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password
            ]);
        }else{
            User::where('id', $id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
            ]);
        }

        Session::put('sweetalert', 'success');
        return redirect()->route('profil', $id)->with('alert', 'Sukses Update Data Diri!');
    }
}
