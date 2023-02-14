@extends('layouts.index', [$title = 'Tambah Absen'])

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Absensi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Absensi</li>
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
                    <h3 class="card-title">Tambah Absen</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('storeAbsen')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                    <div class="form-group">
                        <label for="pid">Nomor Pegawai</label>
                        <select name="pid" id="pid" class="form-control @error('pid') is-invalid @enderror">
                            <option value="" readonly>Pilih Nomor Pegawai</option>
                            @foreach($pegawai as $data)
                                <option value="{{$data->pid}}">{{$data->pid}}||{{$data->nama}}</option>
                            @endforeach
                        </select>

                        @error('pid')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sap">Nomor SAP</label>
                        <select name="sap" id="sap" class="form-control @error('sap') is-invalid @enderror">
                            <option value="" readonly>Pilih Nomor SAP</option>
                            @foreach($pegawai as $data)
                                <option value="{{$data->sap}}">{{$data->sap}}||{{$data->nama}}</option>
                            @endforeach
                        </select>

                        @error('sap')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sync_date">Tanggal</label>
                        <input type="date" class="form-control @error('sync_date') is-invalid @enderror" name="sync_date" id="sync_date" placeholder="Ketik Tanggal Checkin"  value="{{ old('sync_date') }}">

                        @error('sync_date')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_in">Check In</label>
                        <input type="time" class="form-control @error('check_in') is-invalid @enderror" name="check_in" id="check_in" placeholder="Ketik Jam Checkin"  value="{{ old('check_in') }}">

                        @error('check_in')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="check_out">Check Out</label>
                        <input type="time" class="form-control @error('check_out') is-invalid @enderror" name="check_out" id="check_out" placeholder="Ketik Jam CheckOut"  value="{{ old('check_out') }}">

                        @error('check_out')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telat">Telat </label>
                        <input type="time" class="form-control @error('telat') is-invalid @enderror" name="telat" id="telat" placeholder="Ketik Telat"  value="{{ old('telat') }}">

                        @error('telat')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_in1">Check In1</label>
                        <input type="time" class="form-control @error('check_in1') is-invalid @enderror" name="check_in1" id="check_in1" placeholder="Ketik Jam Checkin"  value="{{ old('check_in1') }}">

                        @error('check_in1')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_out1">Check Out1</label>
                        <input type="time" class="form-control @error('check_out1') is-invalid @enderror" name="check_out1" id="check_out1" placeholder="Ketik Jam CheckOut"  value="{{ old('check_out1') }}">

                        @error('check_out1')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_in2">Check In2</label>
                        <input type="time" class="form-control @error('check_in2') is-invalid @enderror" name="check_in2" id="check_in2" placeholder="Ketik Jam Checkin"  value="{{ old('check_in2') }}">

                        @error('check_in2')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_out2">Check Out2</label>
                        <input type="time" class="form-control @error('check_out2') is-invalid @enderror" name="check_out2" id="check_out2" placeholder="Ketik Jam CheckOut"  value="{{ old('check_out2') }}">

                        @error('check_out2')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_in3">Check In3</label>
                        <input type="time" class="form-control @error('check_in3') is-invalid @enderror" name="check_in3" id="check_in3" placeholder="Ketik Jam Checkin"  value="{{ old('check_in3') }}">

                        @error('check_in3')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_out3">Check Out3</label>
                        <input type="time" class="form-control @error('check_out3') is-invalid @enderror" name="check_out3" id="check_out3" placeholder="Ketik Jam CheckOut"  value="{{ old('check_out3') }}">

                        @error('check_out3')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Absen 1</label>
                        <textarea name="absen1" id="absen1" cols="30" rows="10" placeholder="Ketik Absen 1" class="form-control @error('absen1') is-invalid @enderror" value="{{ old('absen1') }}"></textarea>

                        @error('absen1')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Absen 2</label>
                        <textarea name="absen2" id="absen2" cols="30" rows="10" placeholder="Ketik Absen 2" class="form-control @error('absen2') is-invalid @enderror" value="{{ old('absen2') }}"></textarea>

                        @error('absen2')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Izin</label>
                        <textarea name="izin" id="izin" cols="30" rows="10" placeholder="Ketik Izin" class="form-control @error('izin') is-invalid @enderror" value="{{ old('izin') }}"></textarea>

                        @error('izin')
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