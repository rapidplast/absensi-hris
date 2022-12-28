<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Mesin;
use App\Models\Pegawai;
use App\Models\ReferensiKerja;
use App\Models\ReguKerja;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use ZKLibrary;
class UsersController extends Controller
{


        function index(){
            $users = DB::select("
            SELECT p.id,a.role,p.name,p.email,p.password
            FROM users p,roles a
            WHERE p.role_id = a.id
            ORDER BY p.id ASC

            ");
    
            return view('admin.users.index', compact(['users']));
        }
    
        function create(){
            $role = Role::all();
            return view('admin.users.create', compact(['role']));
            // return response()->json($role);
        }
    
        function store(Request $request){

            // $user = User::all();
            // return response()->json($request->all());
            // dd($request);
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
            // return response()->json($request->all());
            // $this->validate($request, [
            //     'role_id'         => ['required'],
            //     'name'            => ['required','string','max:255'],
            //     'email'           => ['required','string','email','max:255','unique:users'],
            //     'password'        => ['required','string','min:8','confirmed']
            // ]);

            $request->validate([
            'role_id'     => 'required',
            'email'    => 'required'| 'string'| 'email'| 'max:255'| 'unique:users',
            'password' => 'required'| 'string'| 'min:8'| 'confirmed',
                ]);
            // return response()->json($request->all());
            $user = User::insert([
                'role_id'       => $request->role_id,
                'name'          => $request->name,
                'email'         => $request->email1,
                'password'      => bcrypt($request->password1),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
            // return response()->json($user);
                // $user = new User();
                // $user->role_id       = $request->role;
                // $user->name          = $request->nama;
                // $user->email         = $request->email;
                // $user->password      = bcrypt($request->password);
                // $user->created_at    = Carbon::now();
                // $user->updated_at    = Carbon::now();
                // $user->save();

            Session::put('sweetalert', 'success');
            return redirect()->route('Users')->with('alert', 'Sukses Menambahkan Data');
        }
    
        function edit($id){
            // $pegawai = Pegawai::where('id', $id)->first();
            $user   = User::where('id',$id)->first();
            // $pegawai = Pegawai::find($id);
            $role   = Role::all();
            return view('admin.users.edit', compact(['user', 'id', 'role']));
        // dd($id);
        }
    
        function update(Request $request, $id){
            
            $user = User::where('id', $id)->first();
    
            User::where('id', $id)->update([
                'role_id'       => $request->role_id,
                'name'          => $request->name,
                'email'         => $request->email1,
                'password'      => bcrypt($request->password1),
            ]);
    
            Session::put('sweetalert', 'success');
            return redirect()->route('editUsers', $id)->with('alert', 'Sukses Mengubah '.$user->name);
        }
    
        function destroy($id){
            $user = User::where('id', $id)->first();
            if(!empty($user)){
                // User::where('id', $pegawai->user_id)->delete();
                User::where('id', $id)->delete();
            }
        }
}

