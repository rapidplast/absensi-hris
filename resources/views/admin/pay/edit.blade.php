@extends('layouts.index', ['title' => 'Edit Absensi'])

@section('content')
    @if (Session::has('alert'))
        @if (Session::get('sweetalert') == 'success')
            <div class="swalDefaultSuccess">
            </div>
        @elseif(Session::get('sweetalert') == 'error')
            <div class="swalDefaultError">
            </div>
        @elseif(Session::get('sweetalert') == 'warning')
            <div class="swalDefaultWarning">
            </div>
        @endif
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Absensi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Absensi</li>
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
                            {{-- @if (isset($Absensi)) --}}
                            {{-- @foreach ($Absensi as $absensi)                                --}}
                            <h3 class="card-title">Absensi </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- <?php $absensi = Session::get('absensi');?> --}}
                        {{-- @if(is_array($absensi)||is_object($absensi)) --}}
                        {{-- @foreach((object)$absensi as $data) --}}
                        
                        <form action="{{ route('updateAbsensi', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="check_in">Check In</label>
                                    
                                    <input type="time" class="form-control @error('check_in') is-invalid @enderror"
                                        name="check_in" id="check_in" placeholder="Ketik Jam Checkin" value="{{$b}}">                                    
                                    @error('check_in')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>                                        
                                    @enderror
                                    
                                </div>

                                <div class="form-group">
                                    <label for="check_out">Check Out</label>
                                    <input type="time" class="form-control @error('check_out') is-invalid @enderror"
                                        name="check_out" id="check_out" placeholder="Ketik Jam CheckOut"
                                        value="{{$c}}">

                                    @error('check_out')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label for="sync_date">Tanggal</label>
                                    <input type="date" class="form-control @error('sync_date') is-invalid @enderror"
                                        name="sync_date" id="sync_date" placeholder="Ketik Tanggal"
                                        value="{{$d}}">

                                    @error('sync_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="telat">Telat </label>
                                    <input type="time" class="form-control @error('telat') is-invalid @enderror"
                                        name="telat" id="telat" placeholder="Ketik Telat" value="{{ $late }}">

                                    @error('telat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="check_in1">Check In1</label>
                                    <input type="time" class="form-control @error('check_in1') is-invalid @enderror"
                                        name="check_in1" id="check_in1" placeholder="Ketik Jam Checkin"
                                        value="{{ old('check_in1') }}">

                                    @error('check_in1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="check_out1">Check Out1</label>
                                    <input type="time" class="form-control @error('check_out1') is-invalid @enderror"
                                        name="check_out1" id="check_out1" placeholder="Ketik Jam CheckOut"
                                        value="{{ old('check_out1') }}">

                                    @error('check_out1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="check_in2">Check In2</label>
                                    <input type="time" class="form-control @error('check_in2') is-invalid @enderror"
                                        name="check_in2" id="check_in2" placeholder="Ketik Jam Checkin"
                                        value="{{ old('check_in2') }}">

                                    @error('check_in2')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="check_out2">Check Out2</label>
                                    <input type="time" class="form-control @error('check_out2') is-invalid @enderror"
                                        name="check_out2" id="check_out2" placeholder="Ketik Jam CheckOut"
                                        value="{{ old('check_out2') }}">

                                    @error('check_out2')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="check_in3">Check In3</label>
                                    <input type="time" class="form-control @error('check_in3') is-invalid @enderror"
                                        name="check_in3" id="check_in3" placeholder="Ketik Jam Checkin"
                                        value="{{ old('check_in3') }}">

                                    @error('check_in3')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="check_out3">Check Out3</label>
                                    <input type="time" class="form-control @error('check_out3') is-invalid @enderror"
                                        name="check_out3" id="check_out3" placeholder="Ketik Jam CheckOut"
                                        value="{{ old('check_out3') }}">

                                    @error('check_out3')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Absen 1</label>
                                    <textarea name="absen1" id="absen1" cols="30" rows="10" placeholder="Ketik Absen 1"
                                        class="form-control @error('absen1') is-invalid @enderror" value="{{ old('absen1') }}"></textarea>

                                    @error('absen1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Absen 2</label>
                                    <textarea name="absen2" id="absen2" cols="30" rows="10" placeholder="Ketik Absen 2"
                                        class="form-control @error('absen2') is-invalid @enderror" value="{{ old('absen2') }}"></textarea>

                                    @error('absen2')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Izin</label>
                                    <textarea name="izin" id="izin" cols="30" rows="10" placeholder="Ketik Izin"
                                        class="form-control @error('izin') is-invalid @enderror" value="{{ old('izin') }}"></textarea>

                                    @error('izin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    {{-- @endforeach --}}
                                    {{-- @endif --}}
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        {{-- @endforeach --}}
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
