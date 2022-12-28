
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Absensi Rapid Plast</title>
  {{-- <title>Login | Absensi BMN</title> --}}

  <!-- Icon Web -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/backend/file/images/RAPIDPLAST.jpg')}}">
  {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/backend/file/images/berdikari.jpg')}}"> --}}
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/backend/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{route('login')}}"><b>Rapid Plast </b>Absensi</a>
    {{-- <a href="{{route('login')}}"><b>PT BMN </b>Absensi</a> --}}
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div class="login-logo">
        <a href="{{route('login')}}">
          <img src="{{asset('public/backend/file/images/logo3.png')}}" width="auto" height="200" >
          {{-- <img src="{{asset('public/backend/file/images/berdikari.png')}}" width="300" height="200" > --}}
        </a>
      </div>
      <p class="login-box-msg">Masuk untuk mulai</p>
      @if(\Session::has('alert'))
        <div class="alert alert-danger">
          <div>{{Session::get('alert')}}</div>
        </div>
      @endif
      <form action="{{route('loginPost')}}" method="post">
      @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('public/backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/backend/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
