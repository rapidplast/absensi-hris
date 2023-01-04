<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HariLiburController extends Controller
{
    function index(Request $request){
		$events = [];
        $hariLibur = HariLibur::all();
		foreach($hariLibur as $data){
			$events[] = [
				'id'	=> $data->id,
				'title' => $data->plant.'-'.$data->keterangan,
				'start'	=> $data->tanggal,
			];
		}

		// dd($events);

        return view('admin.harilibur.index', compact(['events']));
    }

	function store(Request $request){
		$validate = Validator::make($request->all(), [
			'plant'			=> 'required',
			'keterangan'	=> 'required',
			'tanggal'		=> 'required'
		], [
			'plant.required'		=> 'Plant Harus Memilih Salah Satu!',
			'keterangan.required'	=> 'Keterangan Harus Diisi!',
			'tanggal.required'		=> 'Tanggal Harus Diisi!',
		]);

		if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Data Hari Libur!')->withErrors($validate);
        }
		$data = HariLibur::insert([
			'plant'		            => $request->plant,
			'tanggal'			    => $request->tanggal,
			'keterangan'            => $request->keterangan,
		]);

		Session::put('sweetalert', 'success');
		return redirect()->back()->with('alert', 'Sukses Menambahkan Data Hari Libur!');
	}

    function action(Request $request){
        if($request->ajax())
    	{
    		if($request->type == 'delete')
    		{
    			$data = HariLibur::find($request->id)->delete();

    			return response()->json($data);
    		}
    	}
    }
}
