@extends('layouts.index', ['title' => 'Edit Departement'])

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
                <h1 class="m-0">Data Departement</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item">Departement</li>
                    <li class="breadcrumb-item active">Edit Data</li>
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
                    <h3 class="card-title">Departement {{$departement->nama}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('updateDepartement', $departement->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" id="kode" placeholder="Ketik Kode"  value="{{ $departement->kode }}">

                            @error('kode')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Ketik Nama" value="{{ $departement->nama }}">

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="plant">Pilih Plant</label>
                            <select name="plant" id="plant" class="form-control @error('plant') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Plant Rapid Plast</option>
                                <option value="PLANT 1" @if($departement->plant == 'PLANT 1') selected @endif>PLANT 1</option>
                                <option value="PLANT 2" @if($departement->plant == 'PLANT 2') selected @endif>PLANT 2</option>
                                <option value="PLANT 3" @if($departement->plant == 'PLANT 3') selected @endif>PLANT 3</option>
                                <option value="PLANT 4" @if($departement->plant == 'PLANT 4') selected @endif>PLANT 4</option>
                                <option value="PLANT 5" @if($departement->plant == 'PLANT 5') selected @endif>PLANT 5</option>
                            </select>

                            @error('plant')
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