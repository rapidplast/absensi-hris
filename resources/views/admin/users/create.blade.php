@extends('layouts.index', [($title = 'Tambah Users')])

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                            <h3 class="card-title">Tambah Users</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('createUsers') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="role_id">Role</label>
                                    <select name="role_id" id="role_id"
                                        class="form-control @error('role_id') is-invalid @enderror">
                                        <option value="" readonly>Pilih Role</option>
                                        @foreach ($role as $data)
                                            <option value="{{ $data->id }}">{{$data->id }} | {{$data->role}}</option>
                                        @endforeach
                                    </select>

                                    @error('role_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="role_id">Nama Code</label>
                                    <input type="text" name="role_id"
                                        class="form-control @error('role_id') is-invalid @enderror" id="role_id"
                                        placeholder="Ketik ID" value="{{ old('role_id') }}">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> --}}
                                <div class="form-group">
                                    <label for="name">Nama Users</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        placeholder="Ketik Nama" value="{{ old('name') }}">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email1">Email Untuk Login(@example.com)</label>
                                    <input type="email" class="form-control @error('email1') is-invalid @enderror"
                                        name="email1" id="email1" placeholder="Ketik Email"
                                        value="{{ old('email1') }}">

                                    @error('email1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>                      
                                <div class="form-group">
                                    <label for="password1">Password</label>
                                    <input type="password" class="form-control @error('password1') is-invalid @enderror"
                                        name="password1" id="password1" placeholder="Ketik password"
                                        value="{{ old('password1') }}">

                                    @error('password1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
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
