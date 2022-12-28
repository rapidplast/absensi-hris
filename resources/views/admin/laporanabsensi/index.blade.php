@extends('layouts.index', ['title' => 'Laporan Absensi'])

@section('content')
@if(Session::has('alert'))
  @if(Session::get('sweetalert')=='success')
    <div class="swalDefaultSuccess">
    </div>
  @elseif(Session::get('sweetalert')=='error')
    <div class="swalDefaultError">
    </div>
    @elseif(Session::get('sweetalert')=='warning')
    <div class="swalDefaultWarning">
    </div>
  @endif
@endif

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Absensi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Absensi</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Search Data</h3>
                    </div>
                    <form action="{{route('cetakAbsensiLaporan')}}" method="POST" enctype="multipart/form-data" id="form-data" target="_blank">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="tanggal">Dari Tanggal</label>
                                    @if(Route::is('searchAbsensiLaporan'))
                                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{$tanggal}}" required>
                                    @else
                                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{$tanggalSekarang}}" required>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                <label for="tanggal2">Ke Tanggal</label>
                                    @if(Route::is('searchAbsensiLaporan'))
                                    <input type="date" id="tanggal2" name="tanggal2" class="form-control" value="{{ $tanggal2 }}" required>
                                    @else
                                    <input type="date" id="tanggal2" name="tanggal2" class="form-control" value="{{ $tanggalSekarang }}" required>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label for="kriteria">Pilih Kriteria</label>
                                    <select name="kriteria" id="kriteria" class="form-control">
                                        <option value="" selected disabled>===== Pilih Kriteria =====</option>
                                        <option value="pegawai">Pegawai</option>
                                        <option value="nip">NIP Karyawan</option>
                                        <option value="departement">Departement</option>
                                        <option value="divisi">Divisi</option>
                                    </select>
                                </div>
                            </div>
                            <!-- PEGAWAI -->
                            <div class="row" id="pegawaiView" style="display: none;">
                                <div class="col-md-6">
                                    <label for="pegawai_name">Pegawai</label> <br>
                                    <select name="pegawai_name" id="pegawai_name" class="form-control">
                                        <option value="" selected disabled>===== Pilih Pegawai =====</option>
                                        @foreach($pegawai as $data)
                                            <option value="{{$data->pid}}">{{$data->pid}} | {{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                     
                            </div>
                            <!-- NIP -->
                            <div class="row" id="nipView" style="display: none;">
                                <div class="col-md-6">
                                    <label for="nipAwal">NIP Awal</label>
                                    <input type="number" name="nipAwal" id="nipAwal" class="form-control" placeholder="Tanpa Titik">
                                </div>
                                <div class="col-md-6">
                                    <label for="nipAkhir">NIP Akhir</label>
                                    <input type="number" name="nipAkhir" id="nipAkhir" class="form-control" placeholder="Tanpa Titik">
                                </div>
                            </div>
                            <!-- Departement -->
                            <div class="row" id="departementView" style="display: none;">
                                <div class="col-md-6">
                                    <label for="departementAwal">Departement Awal</label> <br>
                                    <select name="departementAwal" id="departementAwal" class="form-control">
                                        <option value="" selected disabled>===== Pilih Departement =====</option>
                                        @foreach($departement as $data)
                                            <option value="{{$data->id}}">{{$data->kode}} | {{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="departementAkhir">Departement Akhir</label> <br>
                                    <select name="departementAkhir" id="departementAkhir" class="form-control">
                                        <option value="" selected disabled>===== Pilih Departement =====</option>
                                        @foreach($departement as $data)
                                            <option value="{{$data->id}}">{{$data->kode}} | {{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Divisi -->
                            <div class="row" id="divisiView" style="display: none;">
                                <div class="col-md-6">
                                    <label for="divisiAwal">Divisi Awal</label> <br>
                                    <select name="divisiAwal" id="divisiAwal" class="form-control">
                                        <option value="" selected disabled>===== Pilih Divisi =====</option>
                                        @foreach($divisi as $data)
                                            <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="divisiAkhir">Divisi Akhir</label> <br>
                                    <select name="divisiAkhir" id="divisiAkhir" class="form-control">
                                        <option value="" selected disabled>===== Pilih Divisi =====</option>
                                        @foreach($divisi as $data)
                                            <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-end">Cetak Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('footer')

<script type="text/javascript">
    $(document).ready(function(){
        var form = document.getElementById('form-data');
        var nip,departement,divisi,pegawai;
        nip = document.createAttribute('action');
        nip.value = "";

        departement = document.createAttribute('action');
        departement.value = "";

        divisi = document.createAttribute('action');
        divisi.value = "";

        pegawai = document.createAttribute('action');
        pegawai.value = "";

        $('#kriteria').click(function(){
            var value = $(this).val();
            console.log(value);
            if(value == "nip"){
                $('#nipView').each(function(){
                    form.setAttributeNode(nip);
                    $(this).show();
                });
                $('#departementView').each(function(){
                    form.removeAttribute(departement);
                    $(this).hide();
                });
                $('#divisiView').each(function(){
                    form.removeAttribute(divisi);
                    $(this).hide();
                });
                $('#pegawaiView').each(function(){
                    form.removeAttribute(pegawai);
                    $(this).hide();
                });
            }else if(value == "departement"){
                $('#nipView').each(function(){
                    form.removeAttribute(nip);
                    $(this).hide();
                });
                $('#departementView').each(function(){
                    form.setAttributeNode(departement);
                    $(this).show();
                });
                $('#divisiView').each(function(){
                    form.removeAttribute(divisi);
                    $(this).hide();
                });
                $('#pegawaiView').each(function(){
                    form.removeAttribute(pegawai);
                    $(this).hide();
                });
            }else if(value == "divisi"){
                $('#nipView').each(function(){
                    form.removeAttribute(nip);
                    $(this).hide();
                });
                $('#departementView').each(function(){
                    form.removeAttribute(departement);
                    $(this).hide();
                });
                $('#divisiView').each(function(){
                    form.setAttributeNode(divisi);
                    $(this).show();
                });
                $('#pegawaiView').each(function(){
                    form.removeAttribute(pegawai);
                    $(this).hide();
                });
            }else if(value == "pegawai"){
                $('#nipView').each(function(){
                    form.removeAttribute(nip);
                    $(this).hide();
                });
                $('#departementView').each(function(){
                    form.removeAttribute(departement);
                    $(this).hide();
                });
                $('#divisiView').each(function(){
                    form.removeAttribute(divisi);
                    $(this).hide();
                });
                     $('#pegawaiView').each(function(){
                    form.setAttributeNode(pegawai);
                    $(this).show();
                });
            }
        });
    
    });

</script>
<script>
    @if (session('alert'))
        swal({{ session('alert') }});
    @endif
</script>
@stop