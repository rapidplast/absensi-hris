@extends('layouts.index', [$title = 'Edit Pegawai '.$pegawai->nama])

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
                <h1 class="m-0">Pegawai</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Pegawai</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pegawai</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('updatePegawai', $id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Pegawai</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Ketik Nama"  value="{{ $pegawai->nama }}">

                        @error('nama')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jabatan_id">Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror">
                            <option value="" readonly>Pilih Jabatan</option>
                            @foreach($jabatan as $data)
                                <option value="{{$data->id}}" @if($data->id == $pegawai->jabatan_id) selected @endif>{{$data->nama}}</option>
                            @endforeach
                        </select>

                        @error('jabatan_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_ktp">No KTP</label>
                        <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" name="no_ktp" id="no_ktp" placeholder="Ketik Nomor KTP"  value="{{ $pegawai->no_ktp }}">

                        @error('no_ktp')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pid">No PID</label>
                        <input type="number" class="form-control @error('pid') is-invalid @enderror" name="pid" id="pid" placeholder="Ketik Nomor PID"  value="{{ $pegawai->pid }}">

                        @error('pid')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="departement">Departement</label>
                        <select name="departement" id="departement" class="form-control @error('departement') is-invalid @enderror">
                            <option value="" selected disabled>===== Pilih Departement =====</option>
                            @foreach($departement as $depart)
                                <option value="{{$depart->kode}}" @if($pegawai->departement_id == $depart->kode) selected @endif>{{$depart->kode}} | {{$depart->nama}}</option>
                            @endforeach
                        </select>

                        @error('departement')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="divisi">Divisi</label>
                        <select name="divisi" id="divisi" class="form-control @error('divisi') is-invalid @enderror">
                            <option value="" selected disabled>===== Pilih Divisi =====</option>
                            @foreach($divisi as $divisi)
                                <option value="{{$divisi->kode}}" @if($pegawai->divisi_id == $divisi->kode) selected @endif>{{$divisi->kode}} | {{$divisi->nama}}</option>
                            @endforeach
                        </select>

                        @error('divisi')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="regukerja_id">Regu Kerja</label>
                        <select name="regukerja_id" id="regukerja_id" class="form-control @error('regukerja_id') is-invalid @enderror">
                            <option value="" selected disabled>===== Pilih Regu Kerja =====</option>
                            @foreach($reguKerja as $reguKerja)
                                <option value="{{$reguKerja->kode}}" @if($pegawai->regukerja_id == $reguKerja->kode) selected @endif>{{$reguKerja->kode}} | {{$reguKerja->nama}}</option>
                            @endforeach
                        </select>

                        @error('regukerja_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter email"  value="{{ $pegawai->email }}">

                        @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nsap">Nomor SAP</label>
                        <input type="number" class="form-control @error('sap') is-invalid @enderror" name="nsap" id="nsap" placeholder="Enter SAP"  value="{{ $pegawai->sap }}">

                        @error('nsap')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Alamat</label>
                        <textarea name="alamat" id="alamat" cols="30" rows="10" placeholder="Ketik Alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ $pegawai->alamat }}"></textarea>

                        @error('alamat')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop