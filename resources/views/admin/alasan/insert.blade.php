@extends('layouts.index', ['title' => 'Tambah Divisi'])

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
                <h1 class="m-0">Data Alasan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item">Alasan</li>
                    <li class="breadcrumb-item active">Tambah Data</li>
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
                    <h3 class="card-title">Tambah Alasan</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('storeAlasan')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Ketik Nama" value="{{ old('nama') }}">

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cuti">Cuti</label>
                            <div class="form-check">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><input type="radio" class="form-check-input @error('cuti') is-invalid @enderror" name="cuti" value="1">Ya</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label><input type="radio" class="form-check-input @error('cuti') is-invalid @enderror" name="cuti" value="0">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            @error('cuti')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rot">ROT</label>
                            <div class="form-check">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><input type="radio" class="form-check-input @error('rot') is-invalid @enderror" name="rot" value="1">Ya</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label><input type="radio" class="form-check-input @error('rot') is-invalid @enderror" name="rot" value="0">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            @error('rot')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rot">Tunha</label>
                            <div class="form-check">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label><input type="radio" class="form-check-input @error('tunha') is-invalid @enderror" name="tunha" value="0">Tidak Dapat Premi Hadir</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label><input type="radio" class="form-check-input @error('tunha') is-invalid @enderror" name="tunha" value="1">Mengurangi Premi Hadir</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label><input type="radio" class="form-check-input @error('tunha') is-invalid @enderror" name="tunha" value="2">Dapat Premi Hadir Penuh</label>
                                    </div>
                                </div>
                            </div>
                            @error('tunha')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop