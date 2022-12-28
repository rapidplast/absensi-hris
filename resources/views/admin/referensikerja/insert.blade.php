@extends('layouts.index', ['title' => 'Tambah Referensi Kerja'])

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
                <h1 class="m-0">Data Referensi Kerja</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item">Referensi Kerja</li>
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
                    <h3 class="card-title">Tambah Referensi Kerja</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('storeReferensiKerja')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                        <div class="row">
                            <div class="col-md-3">
                                <label for="workin">Work In</label>
                                <input type="time" class="form-control @error('workin') is-invalid @enderror" name="workin" placeholder="Work In" value="{{ old('workin') }}">

                                @error('workin')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="restout">Rest Out</label>
                                <input type="time" class="form-control @error('restout') is-invalid @enderror" name="restout" placeholder="Rest Out" value="{{ old('restout') }}">

                                 @error('restout')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="restin">Rest In</label>
                                <input type="time" class="form-control @error('restin') is-invalid @enderror" name="restin" placeholder="Rest Out" value="{{ old('restin') }}">

                                 @error('restin')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="workout">Work Out</label>
                                <input type="time" class="form-control @error('workout') is-invalid @enderror" name="workout" placeholder="Rest Out" value="{{ old('workout') }}">

                                 @error('workout')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="total_jam">Total Jam</label>
                                <input type="time" class="form-control @error('total_jam') is-invalid @enderror" name="total_jam" placeholder="Work In" value="{{ old('total_jam') }}">

                                 @error('total_jam')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="rangerestout">Range Rest Out</label>
                                <input type="time" class="form-control @error('rangerestout') is-invalid @enderror" name="rangerestout" placeholder="Range Rest Out" value="{{ old('rangerestout') }}">
                                
                                 @error('rangerestout')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="rangerestin">Range Rest In</label>
                                <input type="time" class="form-control @error('rangerestin') is-invalid @enderror" name="rangerestin" placeholder="Range Rest Out" value="{{ old('rangerestin') }}">

                                 @error('rangerestin')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
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