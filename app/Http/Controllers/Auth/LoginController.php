<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function index(Request $request){
        
        if($request->method() == 'GET'){
            return view('auth.login');
        }elseif($request->method() == 'POST'){
            if(Auth::attempt([
                'email'     => $request->email,
                'password'  => $request->password,
                'role_id'   => 1
            ])){
                return redirect()->route('dashboard');
            }elseif(Auth::attempt([
                'email'     => $request->email,
                'password'  => $request->password,
                'role_id'   => 2
            ])){
                return redirect()->route('dashboard');
            }else{
                if(!$request->email && !$request->password){
                    Session::put('sweetalert', 'warning');
                    return redirect('login')->with('alert', 'Email dan Password Harus Diisi!');
                }
                Session::put('sweetalert', 'warning');
                return redirect('login')->with('alert', 'Email atau Password Salah!');
            }
        }
    }

    function logout(){
        Auth::logout();
        return redirect('/');
    }
}
