
<!DOCTYPE html>
<html lang="en" id="html">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$title ?? 'Absensi Rapid Plast'}}</title>

  <!-- Icon Web -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/backend/file/images/RAPIDPLAST.jpg')}}">
  {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/backend/file/images/berdikari.jpg')}}"> --}}
   <!-- CSRF_TOKEN -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/backend/dist/css/adminlte.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Toasr -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
  
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  @yield('header')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{asset('public/backend/file/images/logo3.png')}}" alt="Rapid Plast" height="60" width="60">
    {{-- <img class="animation__wobble" src="{{asset('public/backend/file/images/berdikari.png')}}" alt="Rapid Plast" height="60" width="60"> --}}
  </div>

@include('layouts.partial.navbar')
@include('layouts.partial.sidebar')

  
                   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  @yield('content')
    
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Modal Sign Out -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">WARNING!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Anda yakin untuk keluar dari aplikasi?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{route('logout')}}">
          <button type="button" class="btn btn-danger">Logout</button>
        </a>
      </div>
    </div>
  </div>
</div>
  <!-- Modal Sign Out -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('public/backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('public/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/backend/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('public/backend/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('public/backend/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('public/backend/plugins/chart.js/Chart.min.js')}}"></script>

<!-- 
<script src="{{asset('backend/dist/js/pages/dashboard2.js')}}"></script> -->
<!-- DataTables  & Plugins -->
<script src="{{asset('public/backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Sweet Alert -->
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $("#example11").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!-- Toasr -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
    $(function() {
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });

        $('.swalDefaultSuccess').show(function() {
        Toast.fire({
            icon: 'success',
            title: '{{Session::get('alert')}}'
        })
        });
        $('.swalDefaultInfo').show(function() {
        Toast.fire({
            icon: 'info',
            title: '{{Session::get('alert')}}'
        })
        });
        $('.swalDefaultError').show(function() {
        Toast.fire({
            icon: 'error',
            title: '{{Session::get('alert')}}'
        })
        });
        $('.swalDefaultWarning').show(function() {
        Toast.fire({
            icon: 'warning',
            title: '{{Session::get('alert')}}'
        })
        });
        $('.swalDefaultQuestion').show(function() {
        Toast.fire({
            icon: 'question',
            title: '{{Session::get('alert')}}'
        })
        });
    });
</script>
<script>
  $(document).ready(function() {
      $('.refKerja').select2();
  });
  $(document).ready(function() {
      $('#departement').select2();
  });
  $(document).ready(function() {
      $('#divisi').select2();
  });
  $(document).ready(function() {
      $('#departementAwal').select2();
  });
  $(document).ready(function() {
      $('#departementAkhir').select2();
  });
  $(document).ready(function() {
      $('#divisiAwal').select2();
  });
  $(document).ready(function() {
      $('#divisiAkhir').select2();
  });
  $(document).ready(function() {
      $('#regukerja_id').select2();
  });
  $(document).ready(function() {
      $('#jabatan_id').select2();
  });
    $(document).ready(function() {
      $('#pegawai_name').select2();
  });
  $(document).ready(function() {
      $('#pid').select2();
  });
  $(document).ready(function() {
      $('#sap').select2();
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
@yield('footer')
</body>
</html>
