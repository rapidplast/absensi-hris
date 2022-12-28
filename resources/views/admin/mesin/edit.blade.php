@extends('layouts.index', [$title = 'Edit Mesin '.$mesin->serial_number])

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Mesin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Mesin</li>
                    <li class="breadcrumb-item active">Edit {{$mesin->serial_number}}</li>
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
                    <h3 class="card-title">Tambah Mesin Fingerprint</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('updateMesin', $mesin->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Mesin</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Ketik Nama Mesin"  value="{{ $mesin->name }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tcpip">TCP IP</label>
                            <input type="text"  name="tcpip" id="tcpip" class="form-control @error('tcpip') is-invalid @enderror" placeholder="Ketik TCP IP" value="{{ $mesin->tcpip }}">

                            @error('tcpip')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number" id="serial_number" placeholder="Ketik Nomor Serial Number"  value="{{ $mesin->serial_number }}">

                            @error('serial_number')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tipe">Tipe</label>
                            <input type="text" class="form-control @error('tipe') is-invalid @enderror" name="tipe" id="tipe" placeholder="Ketik Tipe"  value="{{ $mesin->tipe }}">

                            @error('tipe')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="is_default">Mesin Default</label>
                            <select name="is_default" id="is_default" class="form-control">
                                <option value="" selected disabled>Pilih Default Mesin</option>
                                <option value="1" @if($mesin->is_default == 1) selected @endif>Yes</option>
                                <option value="0" @if($mesin->is_default == 0) selected @endif>No</option>
                            </select>

                            @error('tipe')
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