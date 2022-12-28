@extends('layouts.index', ['title' => 'Profil Saya'])

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
                <h1 class="m-0">Profil Saya</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Profil Saya</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Personal Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="media align-items-center mb-4">
                                    <img class="mr-3 img-circle" src="{{asset('public/backend/file/images/rapidplast.ico')}}" width="80" height="80" alt="">
                                    {{-- <img class="mr-3 img-circle" src="{{asset('public/backend/file/images/berdikari.ico')}}" width="80" height="80" alt=""> --}}
                                    <div class="media-body">
                                        <h3 class="mb-0">{{Auth()->user()->name}}</h3>
                                        <p class="text-muted mb-0">{{Auth()->user()->role->role}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <span>Email : </span><label for="Keterangan">{{Auth()->user()->email}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Edit Data</h3>
                    </div>
                    <form action="{{ route('profilEdit', $id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nama Anda" value="{{$profil->name}}">
                                </div>
                                <div class="col-md-12">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email Anda" value="{{$profil->email}}">
                                </div>
                                <div class="col-md-12">
                                    <label for="password">Password <span class="text-danger">* Isi jika ganti password</span></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                </div>
                                <div class="col-md-12">
                                    <label for="email">Confirm Password <span class="text-danger">* Isi jika ganti password</span></label>
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                                <button type="submit" class="btn btn-success mt-4 float-right">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer')
<script type="text/javascript">
    
//Password Change Validation
$('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else 
    $('#message').html('Not Matching').css('color', 'red');
});
</script>
@stop