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
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::User()->name}}</span>
          <i class="nav-icon fas fa-user fa-lg"></i>
          <!-- <div class="image">
                <img src="{{asset('public/backend/file/images/rapidplast.ico')}}" class="img-circle elevation-2" alt="User Image" width=30>
            </div> -->
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <div class="dropdown-divider"></div>
          <a href="{{ route('profil', Auth()->user()->id) }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{route('logout')}}" class="dropdown-item" data-toggle="modal" data-target="#exampleModalCenter">
            <i class="fas fa-sign-out-alt"></i> Log Out
          </a>
        </div>
      </li>

     
    </ul>
  </nav>
  <!-- /.navbar -->
