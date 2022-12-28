 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-dark">
  <!-- Right navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <div class="image">
              <img src="{{asset('public/backend/file/images/rapidplast.ico')}}" class="img-circle elevation-2" alt="User Image" width=30>
              {{-- <img src="{{asset('public/backend/file/images/berdikari.ico')}}" class="img-circle elevation-2" alt="User Image" width=30> --}}
            </div>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
        <div class="dropdown-divider"></div>
        <a href="{{ route('profile', Auth()->user()->id) }}" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{route('logout')}}" class="dropdown-item" data-toggle="modal" data-target="#exampleModalCenter">
          <i class="fas fa-users mr-2"></i> Log Out
        </a>
      </div>
    </li>

   
  </ul>
</nav>
<!-- /.navbar -->
