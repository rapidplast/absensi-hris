<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">
    <img src="{{asset('public/backend/file/images/rapidplast.ico')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Rapid Plast</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-header">Home</li>
        <li class="nav-item">
          <a href="{{route('dashboard')}}" class="nav-link {{request()->is('dashboard') ? 'active' : ''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-header">Master Pegawai</li>
        <li class="nav-item">
          {{-- <a href="{{route('pegawai')}}" class="nav-link {{request()->is('Admin/Pegawai') || request()->is('Admin/Pegawai/*') ? 'active' : ''}}"> --}}
            <a href="{{route('pegawaii')}}" class="nav-link {{request()->is('/pegawai') || request()->is('/pegawai/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Data Pegawai
            </p>
          </a>
        </li>
        <li class="nav-item">
          @if(Auth()->user()->role->id == 1 )
          <a href="{{route('Users')}}" class="nav-link {{request()->is('Admin/Users') || request()->is('Admin/Users/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Data Users
            </p>
          </a>
          @endif
        </li>
        
        <li class="nav-header">Master Absensi</li>
        <li class="nav-item">
          @if(Auth()->user()->role->id == 1 )
          {{-- <a href="{{route('absensi')}}" class="nav-link {{request()->is('Admin/Absensi') || request()->is('Admin/Absensi/*')  ? 'active' : ''}}"> --}}
            <a href="{{route('absensii')}}" class="nav-link {{request()->is('absensi') || request()->is('absensi/*')  ? 'active' : ''}}">
            <i class="nav-icon fas fa-clock"></i>
            <p>
              Data Absensi
            </p>
          </a>
      @endif
        </li>
        <li class="nav-item">
          @if(Auth()->user()->role->id == 1 )
          {{-- <a href="{{route('absensi')}}" class="nav-link {{request()->is('Admin/Absensi') || request()->is('Admin/Absensi/*')  ? 'active' : ''}}"> --}}
            <a href="{{route('gaji')}}" class="nav-link {{request()->is('gaji') || request()->is('gaji/*')  ? 'active' : ''}}">
            <i class="nav-icon fas fa-comments"></i>
            <p>
              Data Payroll
            </p>
          </a>
      @endif
        </li>
        <li class="nav-item">
          @if(Auth()->user()->role->id == 2)
          {{-- <a href="{{route('absensi')}}" class="nav-link {{request()->is('Admin/Absensi') || request()->is('Admin/Absensi/*')  ? 'active' : ''}}"> --}}
            <a href="{{route('self')}}" class="nav-link {{request()->is('self') || request()->is('self/*')  ? 'active' : ''}}">
            <i class="nav-icon fas fa-clock"></i>
            <p>
              Data Self Attendance
            </p>
          </a>
        @endif
        </li>
        @if(Auth()->user()->role->id == 1 )
        <li class="nav-item">
          <a href="{{route('absensilog')}}" class="nav-link {{request()->is('Admin/Absensi-Log') || request()->is('Admin/Absensi-Log/*')  ? 'active' : ''}}">
            <i class="nav-icon fas fa-box"></i>
            <p>
              Data Absensi Log
            </p>
          </a>
          @endif
        </li>
        <li class="nav-item">
          @if(Auth()->user()->role->id == 1  )
          <a href="{{route('mesin')}}" class="nav-link {{request()->is('Admin/Mesin') || request()->is('Admin/Mesin/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-hands"></i>
            <p>
              Data Mesin
            </p>
          </a>
        </li>
        <li class="nav-header">Master Data</li>
        <li class="nav-item">
          <a href="{{route('departement')}}" class="nav-link {{request()->is('Admin/Departement') || request()->is('Admin/Departement/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-building"></i>
            <p>
              Departement
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('divisi')}}" class="nav-link {{request()->is('Admin/Divisi') || request()->is('Admin/Divisi/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-divide"></i>
            <p>
              Divisi
            </p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a href="{{route('alasan')}}" class="nav-link {{request()->is('Admin/Alasan') || request()->is('Admin/Alasan/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-comments"></i>
            <p>
              Alasan
            </p>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="{{route('referensiKerja')}}" class="nav-link {{request()->is('Admin/Referensi-Kerja') || request()->is('Admin/Referensi-Kerja/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>
              Referensi Kerja
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('reguKerja')}}" class="nav-link {{request()->is('Admin/Regu-Kerja') || request()->is('Admin/Regu-Kerja/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Regu Kerja
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('hariLibur')}}" class="nav-link {{request()->is('Admin/Hari-Libur') || request()->is('Admin/Hari-Libur/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-calendar"></i>
            <p>
              <!-- Hari Libur -->
              Tanggal
            </p>
          </a>
        </li>
        <li class="nav-header">Lain-Lain</li>
        <!-- <li class="nav-item">
          <a href="{{route('cuti')}}" class="nav-link {{request()->is('Admin/Cuti') || request()->is('Admin/Cuti/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-building"></i>
            <p>
              Cuti
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('wfh')}}" class="nav-link {{request()->is('Admin/Work-From-Home') || request()->is('Admin/Work-From-Home/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-building"></i>
            <p>
              Work From Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('absensiWfh')}}" class="nav-link {{request()->is('Admin/Absensi-Work-From-Home') || request()->is('Admin/Absensi-Work-From-Home/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-building"></i>
            <p>
              Absensi WFH
            </p>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="{{route('laporanAbsensi')}}" class="nav-link {{request()->is('Admin/Laporan-Absensi') || request()->is('Admin/Absensi-Work-From-Home/*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-file"></i>
            <p>
              Laporan Absensi
            </p>
          </a>
        </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>