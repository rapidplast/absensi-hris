<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\ReferensiKerja;
use App\Models\ReguKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReguKerjaController extends Controller
{
    function index(){
        $reguKerja = ReguKerja::all();
        return view('admin.regukerja.index', compact(['reguKerja']));
    }
    
    function insert(){
        $refKerja = ReferensiKerja::all();
        return view('admin.regukerja.insert', compact(['refKerja']));
    }

    function store(Request $request){
        $validate = Validator::make($request->all(),[
            'kode'          => 'required',
            'nama'          => 'required',
            'tgl_start'     => 'required',
            'hari'          => 'required',
        ], [
            'kode.required'        => 'Kode Harus Diisi!',
            'nama.required'        => 'Nama Harus Diisi!',
            'tgl_start.required'   => 'Tanggal Start Harus Diisi!',
            'hari.required'        => 'Hari Harus Diisi!',
        ]);
        
        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Regu Kerja!')->withErrors($validate);
        }

        $jadwal         = new Jadwal();
        $jadwal['1']    = $request['1'];
        $jadwal['2']    = $request['2'];
        $jadwal['3']    = $request['3'];
        $jadwal['4']    = $request['4'];
        $jadwal['5']    = $request['5'];
        $jadwal['6']    = $request['6'];
        $jadwal['7']    = $request['7'];
        $jadwal['8']    = $request['8'];
        $jadwal['9']    = $request['9'];
        $jadwal['10']   = $request['10'];
        $jadwal['11']    = $request['11'];
        $jadwal['12']    = $request['12'];
        $jadwal['13']    = $request['13'];
        $jadwal['14']    = $request['14'];
        $jadwal['15']    = $request['15'];
        $jadwal['16']    = $request['16'];
        $jadwal['17']    = $request['17'];
        $jadwal['18']    = $request['18'];
        $jadwal['19']    = $request['19'];
        $jadwal['20']   = $request['20'];
        $jadwal['21']    = $request['21'];
        $jadwal['22']    = $request['22'];
        $jadwal['23']    = $request['23'];
        $jadwal['24']    = $request['24'];
        $jadwal['25']    = $request['25'];
        $jadwal['26']    = $request['26'];
        $jadwal['27']    = $request['27'];
        $jadwal['28']    = $request['28'];
        $jadwal['29']    = $request['29'];
        $jadwal['30']    = $request['30'];
        $jadwal['31']    = $request['31'];
        $jadwal['32']    = $request['32'];
        $jadwal['33']    = $request['33'];
        $jadwal['34']    = $request['34'];
        $jadwal['35']    = $request['35'];
        $jadwal['36']    = $request['36'];
        $jadwal['37']    = $request['37'];
        $jadwal['38']    = $request['38'];
        $jadwal['39']    = $request['39'];
        $jadwal['40']    = $request['40'];
        $jadwal['41']    = $request['41'];
        $jadwal['42']    = $request['42'];
        $jadwal['43']    = $request['43'];
        $jadwal['44']    = $request['44'];
        $jadwal['45']    = $request['45'];
        $jadwal['46']    = $request['46'];
        $jadwal['47']    = $request['47'];
        $jadwal['48']    = $request['48'];
        $jadwal['49']    = $request['49'];
        $jadwal['50']    = $request['50'];
        $jadwal['51']    = $request['51'];
        $jadwal['52']    = $request['52'];
        $jadwal['53']    = $request['53'];
        $jadwal['54']    = $request['54'];
        $jadwal['55']    = $request['55'];
        $jadwal['56']    = $request['56'];
        $jadwal['57']    = $request['57'];
        $jadwal['58']    = $request['58'];
        $jadwal['59']    = $request['59'];
        $jadwal['60']    = $request['60'];
        $jadwal['61']    = $request['61'];
        $jadwal['62']    = $request['62'];
        $jadwal['63']    = $request['63'];
        $jadwal['64']    = $request['64'];
        $jadwal['65']    = $request['65'];
        $jadwal['66']    = $request['66'];
        $jadwal['67']    = $request['67'];
        $jadwal['68']    = $request['68'];
        $jadwal['69']    = $request['69'];
        $jadwal['70']    = $request['70'];
        $jadwal['71']    = $request['71'];
        $jadwal['72']    = $request['72'];
        $jadwal['73']    = $request['73'];
        $jadwal['74']    = $request['74'];
        $jadwal['75']    = $request['75'];
        $jadwal['76']    = $request['76'];
        $jadwal['77']    = $request['77'];
        $jadwal['78']    = $request['78'];
        $jadwal['79']    = $request['79'];
        $jadwal['80']    = $request['80'];
        $jadwal['81']    = $request['81'];
        $jadwal['82']    = $request['82'];
        $jadwal['83']    = $request['83'];
        $jadwal['84']    = $request['84'];
        $jadwal['85']    = $request['85'];
        $jadwal['86']    = $request['86'];
        $jadwal['87']    = $request['87'];
        $jadwal['88']    = $request['88'];
        $jadwal['89']    = $request['89'];
        $jadwal['90']    = $request['90'];
        $jadwal['91']    = $request['91'];
        $jadwal['92']    = $request['92'];
        $jadwal['93']    = $request['93'];
        $jadwal['94']    = $request['94'];
        $jadwal['95']    = $request['95'];
        $jadwal['96']    = $request['96'];
        $jadwal['97']    = $request['97'];
        $jadwal['98']    = $request['98'];
        $jadwal['99']    = $request['99'];
        $jadwal['100']   = $request['100'];
        $jadwal->save();

        $reguKerja              = new ReguKerja();
        $reguKerja->jadwal_id   = $jadwal->id;
        $reguKerja->kode        = $request->kode;
        $reguKerja->nama        = $request->nama;
        $reguKerja->tgl_start   = $request->tgl_start;
        $reguKerja->hari        = $request->hari;
        $reguKerja->created_at  = Carbon::now();
        $reguKerja->updated_at  = Carbon::now();
        $reguKerja->save();

        Session::put('sweetalert', 'success');
        return redirect()->route('reguKerja')->with('alert', 'Sukses Menambahkan Data');
    }

    function edit($id){
        $reguKerja = ReguKerja::find($id);
        $refKerja = ReferensiKerja::all();
        $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
        return view('admin.regukerja.edit', compact(['reguKerja', 'jadwal', 'refKerja']));
    }

    function update(Request $request, $id){
        $reguKerja = ReguKerja::find($id);
        $validate = Validator::make($request->all(),[
            'kode'          => 'required',
            'nama'          => 'required',
            'tgl_start'     => 'required',
            'hari'          => 'required',
        ], [
            'kode.required'        => 'Kode Harus Diisi!',
            'nama.required'        => 'Nama Harus Diisi!',
            'tgl_start.required'   => 'Tanggal Start Harus Diisi!',
            'hari.required'        => 'Hari Harus Diisi!',
        ]);
        
        if($validate->fails()){
            Session::put('sweetalert', 'warning');
            return redirect()->back()->with('alert', 'Gagal Menambahkan Regu Kerja!')->withErrors($validate);
        }

        ReguKerja::where('id', $id)->update([
            'kode'          => $request->kode,
            'nama'          => $request->nama,
            'tgl_start'     => $request->tgl_start,
            'hari'          => $request->hari,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        $jadwal = DB::table('jadwals')
                    ->where('id', $reguKerja->jadwal_id)
                    ->update([
                        '1'    => $request['1'],
                        '2'    => $request['2'],
                        '3'    => $request['3'],
                        '4'    => $request['4'],
                        '5'    => $request['5'],
                        '6'    => $request['6'],
                        '7'    => $request['7'],
                        '8'    => $request['8'],
                        '9'    => $request['9'],
                        '10'   => $request['10'],
                        '11'    => $request['11'],
                        '12'    => $request['12'],
                        '13'    => $request['13'],
                        '14'    => $request['14'],
                        '15'    => $request['15'],
                        '16'    => $request['16'],
                        '17'    => $request['17'],
                        '18'    => $request['18'],
                        '19'    => $request['19'],
                        '20'    => $request['20'],
                        '21'    => $request['21'],
                        '22'    => $request['22'],
                        '23'    => $request['23'],
                        '24'    => $request['24'],
                        '25'    => $request['25'],
                        '26'    => $request['26'],
                        '27'    => $request['27'],
                        '28'    => $request['28'],
                        '29'    => $request['29'],
                        '30'    => $request['30'],
                        '31'    => $request['31'],
                        '32'    => $request['32'],
                        '33'    => $request['33'],
                        '34'    => $request['34'],
                        '35'    => $request['35'],
                        '36'    => $request['36'],
                        '37'    => $request['37'],
                        '38'    => $request['38'],
                        '39'    => $request['39'],
                        '40'    => $request['40'],
                        '41'    => $request['41'],
                        '42'    => $request['42'],
                        '43'    => $request['43'],
                        '44'    => $request['44'],
                        '45'    => $request['45'],
                        '46'    => $request['46'],
                        '47'    => $request['47'],
                        '48'    => $request['48'],
                        '49'    => $request['49'],
                        '50'    => $request['50'],
                        '51'    => $request['51'],
                        '52'    => $request['52'],
                        '53'    => $request['53'],
                        '54'    => $request['54'],
                        '55'    => $request['55'],
                        '56'    => $request['56'],
                        '57'    => $request['57'],
                        '58'    => $request['58'],
                        '59'    => $request['59'],
                        '60'    => $request['60'],
                        '61'    => $request['61'],
                        '62'    => $request['62'],
                        '63'    => $request['63'],
                        '64'    => $request['64'],
                        '65'    => $request['65'],
                        '66'    => $request['66'],
                        '67'    => $request['67'],
                        '68'    => $request['68'],
                        '69'    => $request['69'],
                        '70'    => $request['70'],
                        '71'    => $request['71'],
                        '72'    => $request['72'],
                        '73'    => $request['73'],
                        '74'    => $request['74'],
                        '75'    => $request['75'],
                        '76'    => $request['76'],
                        '77'    => $request['77'],
                        '78'    => $request['78'],
                        '79'    => $request['79'],
                        '80'    => $request['80'],
                        '81'    => $request['81'],
                        '82'    => $request['82'],
                        '83'    => $request['83'],
                        '84'    => $request['84'],
                        '85'    => $request['85'],
                        '86'    => $request['86'],
                        '87'    => $request['87'],
                        '88'    => $request['88'],
                        '89'    => $request['89'],
                        '90'    => $request['90'],
                        '91'    => $request['91'],
                        '92'    => $request['92'],
                        '93'    => $request['93'],
                        '94'    => $request['94'],
                        '95'    => $request['95'],
                        '96'    => $request['96'],
                        '97'    => $request['97'],
                        '98'    => $request['98'],
                        '99'    => $request['99'],
                        '100'   => $request['100']
                    ]);

        Session::put('sweetalert', 'success');
        return redirect()->back()->with('alert', 'Sukses Mengedit Data');
    }

    function destroy($id){
        $reguKerja = ReguKerja::find($id);
        if($reguKerja){
            ReguKerja::where('id', $id)->delete();
        }
    }
}
