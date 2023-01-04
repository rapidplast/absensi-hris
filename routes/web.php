<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PegawaiController;
use App\Http\Controllers\Backend\AbsensiController;
use App\Http\Controllers\Backend\AbsensiMentahController;
use App\Http\Controllers\Backend\AbsensiWfhController;
use App\Http\Controllers\Backend\AlasanController;
use App\Http\Controllers\Backend\attController;
use App\Http\Controllers\Backend\attRController;
use App\Http\Controllers\Backend\CetakAbsenMentahController;
use App\Http\Controllers\Backend\cetakTxtController;
use App\Http\Controllers\Backend\CutiController;
use App\Http\Controllers\Backend\DepartementController;
use App\Http\Controllers\Backend\DivisiController;
use App\Http\Controllers\Backend\HariLiburController;
use App\Http\Controllers\Backend\LaporanAbsensiController;
use App\Http\Controllers\Backend\MesinController;
use App\Http\Controllers\Backend\ReferensiKerjaController;
use App\Http\Controllers\Backend\ReguKerjaController;
use App\Http\Controllers\Backend\SelfAttController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\WorkFromHomeController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\DevController; //wsidik 13.09.2022
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('/login',[LoginController::class, 'index'])->name('loginPost');
Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

//wsidik 13.09.2022 add dev
Route::get('/dev',[DevController::class, 'syncData'])->name('dev');


Route::group(['middleware' => ['web', 'auth', 'roles']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawaii');
 

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensii');
    // Self Attendance
    Route::get('/self', [SelfAttController::class, 'index'])->name('self');
    Route::post('/Cari-DataS', [SelfAttController::class, 'index'])->name('searchSelf');
       // // Profile 
    Route::get('/{id}', [ProfileController::class, 'index'])->name('profile');
    Route::post('/Edit-Data/{id}', [ProfileController::class, 'edit'])->name('profilEditt');
    //Admin  
    Route::group(['roles' => 'Admin', 'prefix' => 'Admin'], function(){

        // Route::get('/txt', function(){
        //     $fileText = ["This" => 'data', 'is', 'data'];
        //     $myName = "ThisDownload.txt";
        //     $headers = ['Content-type'=>'text/plain', 'Content-Disposition'=>sprintf('attachment; filename="%s"', $myName),];
        //     return Response::make($fileText, 200, $headers);
        // });

        // ========== Pegawai Route ========== //
        Route::group(['prefix' => 'Pegawai'], function(){
            Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
            // Add Data
            Route::get('/Tambah-Data', [PegawaiController::class, 'create'])->name('addPegawai');
            Route::post('/Tambah-Data/Create-Data', [PegawaiController::class, 'store'])->name('createPegawai');
            // Edit Data
            Route::get('/Edit/{id}', [PegawaiController::class, 'edit'])->name('editPegawai');
            Route::post('/Update/{id}', [PegawaiController::class, 'update'])->name('updatePegawai');
            // Delete Data
            Route::delete('/Delete/{id}', [PegawaiController::class, 'destroy'])->name('destroyPegawai');
            // Sync Pegawai
            Route::post('/synchronous-pegawai', [PegawaiController::class, 'syncPegawai'])->name('syncPegawai');
        });

        // DATA USERS
        Route::group(['prefix' => 'Users'], function(){
            Route::get('/', [UsersController::class, 'index'])->name('Users');
            // Add Data
            Route::get('/Tambah-Data', [UsersController::class, 'create'])->name('addUsers');
            Route::post('/Tambah-Data/Create-Data', [UsersController::class, 'store'])->name('createUsers');
            // Edit Data
            Route::get('/Edit/{id}', [UsersController::class, 'edit'])->name('editUsers');
            Route::post('/Update/{id}', [UsersController::class, 'update'])->name('updateUsers');
            // Delete Data
            Route::delete('/Delete/{id}', [UsersController::class, 'destroy'])->name('destroyUsers');

        });

        // ========== Absensi Route ========== //
        Route::group(['prefix' => 'Absensi'], function(){
            Route::get('/', [AbsensiController::class, 'index'])->name('absensi');
            // Tambah Data Absensi
            Route::get('/Tambah-Data',[AbsensiController::class,'create'])->name('addAbsen');
            // Tambah Data Absensi 
            Route::get('/Tambah-Data/Create-Data', [AbsensiController::class, 'store'])->name('storeAbsen');
            // Data Synchronous Data
            Route::post('/Data-Synchronous-Absensi', [AbsensiController::class, 'syncData'])->name('syncDataAbsensi');
            // Data Synchronous Data
            Route::post('/Data-Synchronous-Absensi2', [AbsensiController::class, 'syncData2'])->name('syncDataAbsensi');
            // Cetak Absensi TXT
            Route::get('/Cetak-Absensi-TXT/{tanggal}/{dbName}', [cetakTxtController::class, 'cetakTXT'])->name('cetak.TXT');
            Route::get('/Cetak-Absensi-TXT-Search/{tanggal}/{tanggal2}/{dbName}', [cetakTxtController::class, 'cetakTXTSearch'])->name('cetakSearch.TXT');
            // Cetak Absensi TXT BARU
            Route::get('/CTxt/{tanggal}/{dbName}', [CetakAbsenMentahController::class, 'cetakTXT'])->name('CTxt');
            Route::get('/CTxt/{tanggal}/{tanggal2}/{dbName}', [CetakAbsenMentahController::class, 'cetakTXTSearch'])->name('CTxtS');
            //Edit Absensi
            Route::get('/Edit-Data/{id}/{pid}/{date}', [AbsensiController::class, 'edit'])->name('editAbsensi');
            // Update Absensi
            Route::post('/Update-Data/{id}', [AbsensiController::class, 'update'])->name('updateAbsensi');
            // Delete Absensi
            Route::delete('/Delete/{id}',[AbsensiController::class, 'destroy'])->name('destroyAbsensi');
            // Cari Data
            Route::post('Cari-Data', [AbsensiController::class, 'index'])->name('searchAbsensi');
        });

        // ========== Absensi Log ========== //
        Route::group(['prefix' => 'Absensi-Log'], function(){
            Route::get('/', [AbsensiMentahController::class, 'index'])->name('absensilog');
            // Data Synchronous Data
            Route::post('/Data-Synchronous-Absensi2', [AbsensiMentahController::class, 'syncData2'])->name('syncDataAbsensi');            
            Route::post('Cari-Data', [AbsensiMentahController::class, 'index'])->name('searchAbsensilog');
        });

        // ========== Attendance ========== //
        Route::group(['prefix' => 'Attendance'], function(){
            Route::get('/', [attController::class, 'index'])->name('attendance');                    
            Route::post('Cari-Data', [attController::class, 'index'])->name('searchAbsensilog');
        });
        // ========== Attendance Real ========== //
        Route::group(['prefix' => 'AttR'], function(){
            Route::get('/', [attRController::class, 'index'])->name('attendance');   
            Route::post('/sync-dt', [attRController::class, 'syncData'])->name('syncR');                             
            Route::post('Cari-Data', [attRController::class, 'index'])->name('searchAbsensilog');
        });

        // =========== Laporan Absensi =========== //
        Route::group(['prefix' => 'Laporan-Absensi'], function(){
            Route::get('/', [LaporanAbsensiController::class, 'index'])->name('laporanAbsensi');
            Route::post('/', [LaporanAbsensiController::class, 'index'])->name('searchAbsensiLaporan');
            Route::post('/', [LaporanAbsensiController::class, 'cetak'])->name('cetakAbsensiLaporan');
        });
        // =========== Laporan Absensi =========== //


        // ========== Mesin Route ========== //
        Route::group(['prefix' => 'Mesin'], function(){
            Route::get('/', [MesinController::class, 'index'])->name('mesin');
             // Add Data
             Route::get('/Tambah-Data', [MesinController::class, 'create'])->name('addMesin');
             Route::post('/Tambah-Data/Create-Data', [MesinController::class, 'store'])->name('storeMesin');
             // Default Mesin
             Route::get('/Default/{id}', [MesinController::class, 'defaultMesin'])->name('defaultMesin');
             // Edit Data
             Route::get('/Edit/{id}', [MesinController::class, 'edit'])->name('editMesin');
             Route::post('/Update/{id}', [MesinController::class, 'update'])->name('updateMesin');
             // Delete Data
             Route::delete('/Delete/{id}', [MesinController::class, 'destroy'])->name('destroyMesin');
             // Delete Data Mesin
             Route::delete('/Delete-Data-Mesin/{id}', [MesinController::class, 'deleteDataMesin'])->name('deleteDataMesin');
        });
            
        // ========== Departement Route ========== //
        Route::group(['prefix' => 'Departement'], function(){
            Route::get('/', [DepartementController::class, 'index'])->name('departement');
            // Add Data
            Route::get('/Tambah-Data', [DepartementController::class, 'insert'])->name('addDepartement');
            Route::post('/Tambah-Data/Create-Data', [DepartementController::class, 'store'])->name('storeDepartement');
            // Edit Data
            Route::get('/Edit-Data/{id}', [DepartementController::class, 'edit'])->name('editDepartement');
            Route::post('/Edit-Data/{id}', [DepartementController::class, 'update'])->name('updateDepartement');
            // Delete Data
            Route::delete('/Delete/{id}', [DepartementController::class, 'destroy'])->name('destroyDepartement');
        });
        // ========== Departement Route ========== //

        // ========== Divisi Route ========== //
        Route::group(['prefix' => 'Divisi'], function(){
            Route::get('/', [DivisiController::class, 'index'])->name('divisi');
            // Add Data
            Route::get('/Tambah-Data', [DivisiController::class, 'insert'])->name('addDivisi');
            Route::post('/Tambah-Data/Create-Data', [DivisiController::class, 'store'])->name('storeDivisi');
            // Edit Data
            Route::get('/Edit-Data/{id}', [DivisiController::class, 'edit'])->name('editDivisi');
            Route::post('/Edit-Data/{id}', [DivisiController::class, 'update'])->name('updateDivisi');
            // Delete Data
            Route::delete('/Delete/{id}', [DivisiController::class, 'destroy'])->name('destroyDivisi');
        });
        // ========== Divisi Route ========== //

        // ========== Alasan Route ========== //
        Route::group(['prefix' => 'Alasan'], function(){
            Route::get('/', [AlasanController::class, 'index'])->name('alasan');
            // Add Data
            Route::get('/Tambah-Data', [AlasanController::class, 'insert'])->name('addAlasan');
            Route::post('/Tambah-Data/Create-Data', [AlasanController::class, 'store'])->name('storeAlasan');
            // Edit Data
            Route::get('/Edit-Data/{id}', [AlasanController::class, 'edit'])->name('editAlasan');
            Route::post('/Edit-Data/{id}', [AlasanController::class, 'update'])->name('updateAlasan');
            // Delete Data
            Route::delete('/Delete/{id}', [AlasanController::class, 'destroy'])->name('destroyAlasan');
        });
        // ========== Alasan Route ========== //

        // ========== Referensi Kerja Route ========== //
        Route::group(['prefix' => 'Referensi-Kerja'], function(){
            Route::get('/', [ReferensiKerjaController::class, 'index'])->name('referensiKerja');
            // Add Data
            Route::get('/Tambah-Data', [ReferensiKerjaController::class, 'insert'])->name('addReferensiKerja');
            Route::post('/Tambah-Data/Create-Data', [ReferensiKerjaController::class, 'store'])->name('storeReferensiKerja');
            // Edit Data
            Route::get('/Edit-Data/{id}', [ReferensiKerjaController::class, 'edit'])->name('editReferensiKerja');
            Route::post('/Edit-Data/{id}', [ReferensiKerjaController::class, 'update'])->name('updateReferensiKerja');
            // Delete Data
            Route::delete('/Delete/{id}', [ReferensiKerjaController::class, 'destroy'])->name('destroyReferensiKerja');
        });
        // ========== Referensi Kerja Route ========== //

        // ========== Regu Kerja Route ========== //
        Route::group(['prefix' => 'Regu-Kerja'], function(){
            Route::get('/', [ReguKerjaController::class, 'index'])->name('reguKerja');
            // Add Data
            Route::get('/Tambah-Data', [ReguKerjaController::class, 'insert'])->name('addReguKerja');
            Route::post('/Tambah-Data/Create-Data', [ReguKerjaController::class, 'store'])->name('storeReguKerja');
            // Edit Data
            Route::get('/Edit-Data/{id}', [ReguKerjaController::class, 'edit'])->name('editReguKerja');
            Route::post('/Edit-Data/{id}', [ReguKerjaController::class, 'update'])->name('updateReguKerja');
            // Delete Data
            Route::delete('/Delete/{id}', [ReguKerjaController::class, 'destroy'])->name('destroyReguKerja');
        });
        // ========== Regu Kerja Route ========== //

        // ========== Hari Libur Route ========== //
        Route::group(['prefix' => 'Hari-Libur'], function(){
            Route::get('/', [HariLiburController::class, 'index'])->name('hariLibur');
            // Tambah Data
            Route::post('/Tambah-Data', [HariLiburController::class, 'store'])->name('storeHariLibur');
            // Action Data
            Route::post('/Action', [HariLiburController::class, 'action'])->name('actionHariLibur');
        });
        // ========== Hari Libur Route ========== //

        // ========== Hari Libur Route ========== //
        Route::group(['prefix' => 'Profil-Saya'], function(){
            Route::get('/{id}', [ProfileController::class, 'index'])->name('profil');
            // Edit Data
            Route::post('/Edit-Data/{id}', [ProfileController::class, 'edit'])->name('profilEdit');
        });
        // ========== Hari Libur Route ========== //
        
        // ========== Cuti Route ========== //
        Route::group(['prefix' => 'Cuti'], function(){
            Route::get('/', [CutiController::class, 'index'])->name('cuti');
            Route::post('/', [CutiController::class, 'index'])->name('searchCuti');
            // Konfirmasi Cuti
            Route::get('/Konfirmasi-Cuti/{id}', [CutiController::class, 'konfirmasi'])->name('cutiKonfirmasi');
            // Tolak Cuti
            Route::get('/Tolak-Cuti/{id}', [CutiController::class, 'tolak'])->name('cutiTolak');
        });
        // ========== Cuti Route ========== //

        // ========== Work From Home Route ========== //
        Route::group(['prefix' => 'Work-From-Home'], function(){
            Route::get('/', [WorkFromHomeController::class, 'index'])->name('wfh');
            Route::post('/', [WorkFromHomeController::class, 'index'])->name('searchWfh');
            // Konfirmasi  Work From Home
            Route::get('/Konfirmasi-Data/{id}', [WorkFromHomeController::class, 'konfirmasi'])->name('wfhKonfirmasi');
            // Tolak  Work From Home
            Route::get('/Tolak-Data/{id}', [WorkFromHomeController::class, 'tolak'])->name('wfhTolak');
        });
        // ==========  Work From Home Route ========== //

        // ========== Absensi Work From Home Route ========== //
        Route::group(['prefix' => 'Absensi-Work-From-Home'], function(){
            Route::get('/', [AbsensiWfhController::class, 'index'])->name('absensiWfh');
            Route::post('/', [AbsensiWfhController::class, 'index'])->name('searchAbsensiWfh');
        });
        // ========== Absensi Work From Home Route ========== //
    });

    //USER
    // Route::group(['roles' => 'Pegawai', 'prefix' => 'Pegawai'], function(){
    //     Route::group(['prefix' => 'Pegawai'], function(){
    //         Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
    //     });

    //     Route::group(['prefix' => 'Absensi'], function(){
    //         Route::get('/', [AbsensiController::class, 'index'])->name('absensi');
    //         Route::post('Cari-Data', [AbsensiController::class, 'index'])->name('searchAbsensi');
    //     });
        
    // });
});
