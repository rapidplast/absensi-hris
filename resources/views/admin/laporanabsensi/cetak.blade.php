<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        @page {size: A4 landscape}

        body{
            border: 1px solid black
        }

        .header{
            margin: 5px;
            flex-direction: row-reverse;
        }

        .address{
            margin-left: 5px;
        }

        .title{
            margin-top: -60px;
            text-align: center;
        }

        .date{
            margin-top: -20px
        }

        .pegawai{
            flex-direction: row;
            text-align: center;
        }

        .nip{
            margin-left: 25px;
        }

        .name{
            margin-left: 25px;
        }

        .dept{
            margin-left: 100px;
        }

        .divisi{
            margin-left: 20px;
        }

        table{
            margin-left:auto; 
            margin-right:auto;
        }

        table, td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <title>Document</title>
</head>
<?php

use App\Models\Departement;
use App\Models\Divisi;
use App\Models\Jadwal;
use App\Models\ReferensiKerja;
use App\Models\ReguKerja;
use Illuminate\Support\Facades\DB;

    $no = 1;
?>
@foreach($pegawai as $data)
<?php
    $reguKerja = ReguKerja::where('kode', $data->regukerja_id)->first();
    $absensi = DB::select(
        "SELECT afh.*, p.*
        FROM absensi_fingerprint.pegawais p, absensi_frhistory.$dbName afh
        WHERE p.pid = afh.pid AND DATE(sync_date) >= '$tanggal' AND DATE(sync_date) <= '$tanggal2' AND afh.pid = '$data->pid'
        ORDER BY afh.sync_date ASC"
    );
    $depart = Departement::where('kode', $data->departement_id)->value('nama');
    $divisi = Divisi::where('kode', $data->divisi_id)->value('nama');
?>
@if(!empty($absensi))
<body>
    <div class="header">
        
        <span style="float: right;">Halaman {{$no++}}</span>
    </div>
    <br>
    <div class="address">
        <span>PT RAPID PLAST</span> <br>
        <span>Jl. Berbek Industri V / 10, Sidoarjo 61256</span> <br>
        <span>East Java, Indonesia</span>
    </div>
    <div class="title">
        <h2>Laporan Detail Absensi Karyawan</h2>
        <p class="date">Dari Tanggal : {{date('d F Y', strtotime($tanggal))}} s/d {{date('d F Y', strtotime($tanggal2))}}</p>
    </div>
    <br>
    <div class="pegawai">
        <span class="nip">{{$data->pid}}</span>
        <span class="name">{{$data->nama}}</span>
        <span class="dept">Dept : {{$depart}}</span>
        <span class="divisi">Divisi : {{$divisi}}</span>
    </div>
    <div class="tabel">
        <table>
            <thead style="text-align: center; font-size: 11;">
                <tr>
                    <th rowspan="2">Tanggal</th>
                    <th colspan="2">Referensi</th>
                    <th colspan="6">Absensi</th>
                    <th rowspan="2">Total Ijin</th>
                    <th rowspan="2">Late</th>
                    <th rowspan="2">Absen</th>
                    <th rowspan="2">Lmb Oleh</th>
                    <th rowspan="2">Jam OT</th>
                    <th colspan="3">P U R E</th>
                    <th colspan="3">Perhitungan</th>
                </tr>
                <tr>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>RotOt</th>
                    <th>Rot</th>
                    <th>Ot</th>
                    <th>RotOt</th>
                    <th>Rot</th>
                    <th>Ot</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $num = 1;
                $sum = 0;
            ?>
            @foreach($absensi as $dt)
            <?php 
                $sum += strtotime($dt->telat);
                $totalTelat = date('H:i:s', $sum);

                $awal  = date_create($reguKerja->tgl_start);
                $akhir = date_create($dt->sync_date); // waktu sekarang
                $diff  = date_diff( $awal, $akhir );
                $hari = $diff->days % $reguKerja->hari;

                if($hari === 0){
                    $hari = $reguKerja->hari;
                }

                // Get Jadwals
                $jadwal = Jadwal::where('id', $reguKerja->jadwal_id)->first();
                // Get Ref Kerja
                $refKerja = ReferensiKerja::where('kode', $jadwal[$hari])->first();
            ?>
                <tr>
                    <td style="text-align: center; font-size: 8;">{{date('d F Y',strtotime($dt->sync_date))}}</td>
                    <td style="text-align: center; font-size: 8;">{{$refKerja->workin}}</td>
                    <td style="text-align: center; font-size: 8;">{{$refKerja->workout}}</td>
                    <td style="text-align: center; font-size: 8;">{{$dt->check_in ? $dt->check_in : '-'}}</td>
                    <td style="text-align: center; font-size: 8;">{{$dt->check_out ? $dt->check_out : '-'}}</td>
                    <td style="text-align: center; font-size: 8;">{{$dt->check_in1 ? $dt->check_in1 : '-'}}</td>
                    <td style="text-align: center; font-size: 8;">{{$dt->check_out1 ? $dt->check_out1 : '-'}}</td>
                    <td style="text-align: center; font-size: 8;">{{$dt->check_in2 ? $dt->check_in2 : '-'}}</td>
                    <td style="text-align: center; font-size: 8;">{{$dt->check_out2 ? $dt->check_out2 : '-'}}</td>
                    <td style="text-align: center; font-size: 8;"></td>
                    <td style="text-align: center; font-size: 8;">{{$dt->telat}}</td>
                    <td style="text-align: center; font-size: 8;">0</td>
                    <td style="text-align: center; font-size: 8;"></td>
                    <td style="text-align: center; font-size: 8;"></td>
                    <td style="text-align: center; font-size: 8;">0</td>
                    <td style="text-align: center; font-size: 8;">0</td>
                    <td style="text-align: center; font-size: 8;">0</td>
                    <td style="text-align: center; font-size: 8;">0</td>
                    <td style="text-align: center; font-size: 8;">0</td>
                    <td style="text-align: center; font-size: 8;">0</td>
                </tr>
            </tbody>
            @endforeach
            <tfoot style="text-align: center; font-size: 8;">
                @if($totalTelat == '00:00:00' || $totalTelat == null || $totalTelat == '')
                <tr>
                    <td colspan="9">Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @else
                <tr>
                    <td colspan="9">Total</td>
                    <td></td>
                    <td>{{$totalTelat}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
            </tfoot>
        </table>
    </div>
</body>
@endif
@endforeach
</html>