@extends('layouts.index', [$title = 'Absensi Pegawai'])

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
                <h1 class="m-0">Data Absensi</h1>
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
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Search Data</h3>
                        <button type="button"  class="btn btn-sm btn-light float-right ml-2" style="border-radius: 50%;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fas fa-question"></i>
                        </button>
                    </div>
                    <form action="{{route('searchAbsensi')}}" method="POST" enctype="multipart/form-data" id="form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <span>Dari Tanggal</span>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{$tanggalCetak}}" required>
                                </div>
                                <div class="col-md-3">
                                    <span>Ke Tanggal</span>
                                    @if(Route::is('searchAbsensi'))
                                    <input type="date" id="tanggal2" name="tanggal2" class="form-control" value="{{ $tanggal2}}" required>
                                    @else
                                    <input type="date" id="tanggal2" name="tanggal2" class="form-control" value="{{$tanggalCetak}}" required>
                                    @endif
                                </div>
                                <!-- <div class="col-md-1 text-center">
                                    <button type="button" id="sync-absensi" class="btn btn-warning mt-4">
                                        Tarik Absensi
                                    </button>
                                </div> -->
                                <div class="col-md-2 text-right">
                                    <button type="button" id="sync-absensi3" class="btn btn-warning mt-4">
                                        Tarik Attendance
                                    </button>
                                </div>
                                <!--<div class="col-md-1 text-center">
                                    <button type="button" id="sync-absensi2" class="btn btn-danger mt-4">
                                        Tarik Log 
                                    </button>
                                </div>-->
                                <div class="col-md-2 ">
                                    <button type="submit" class="btn btn-success mt-4">Load Data</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Absensi</h3>
                    {{-- @if(Route::is('searchAbsensi'))
                        <a href="{{route('cetakSearch.TXT', ['tanggal' => $tanggal, 'tanggal2' => $tanggal2, 'dbName' => $dbName])}}">
                            <button type="button" class="btn btn-warning btn-sm float-right mr-2" >
                                Cetak .TXT
                            </button>
                        </a>
                    @else
                        <a href="{{route('cetak.TXT', ['tanggal' => $tanggal, 'dbName' => $dbName])}}">
                            <button type="button" class="btn btn-warning btn-sm float-right mr-2" >
                                Cetak .TXT
                            </button>
                        </a>
                    @endif --}}
                    @if(Route::is('searchAbsensi'))
                    <a href="{{route('cetakSearch.TXT', ['tanggal' => $tanggal, 'tanggal2' => $tanggal2, 'dbName' => $dbName])}}">
                        <button type="button" class="btn btn-warning btn-sm float-right mr-2" >
                            CetakB .TXT
                        </button>
                    </a>
                @else
                    <a href="{{route('cetak.TXT', ['tanggal' => $tanggal, 'dbName' => $dbName])}}">
                        <button type="button" class="btn btn-warning btn-sm float-right mr-2" >
                            CetakB .TXT
                        </button>
                    </a>
                @endif
                    <a href="{{route('addAbsen')}}" class="text-decoration-none">
                        <button type="button" class="btn btn-sm btn-success float-right">
                            Tambah Data
                        </button>
                    </a>
                
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable" aria-describedby="example1_info">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Telat</th>
                        <th>Check In 1</th>
                        <th>Check Out 1</th>
                        <th>Check In 2</th>
                        <th>Check Out 2</th>
                        <th>Absen 1</th>
                        <th>Absen 2</th>
                        <th>Izin</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                        ?>
                        @foreach($absensi as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->pid}}</td>
                            <td>{{$data->nama}}</td>
                            <td>{{date('d F Y', strtotime($data->sync_date))}}</td>
                            <td>{{$data->check_in}}</td>
                            <td>{{$data->check_out}}</td>
                            <td>{{$data->telat}}</td>
                            <td>{{$data->check_in1}}</td>
                            <td>{{$data->check_out1}}</td>
                            <td>{{$data->check_in2}}</td>
                            <td>{{$data->check_out2}}</td>
                            <td>{{$data->absen1}}</td>
                            <td>{{$data->absen2}}</td>
                            <td>{{$data->izin}}</td>
                            <td>
                                <a href="{{ route('editAbsensi',['id' => $data->id, 'pid' => $data->pid, 'date' => date('Y-m-d', strtotime($data->sync_date))]) }}"  class="btn btn-sm btn-warning">Ubah</a>
                                <button class="btn btn-sm btn-danger" id="btn-delete" onclick="destroy('{{$data->id}}')">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Telat</th>
                            <th>Check In 1</th>
                            <th>Check Out 1</th>
                            <th>Check In 2</th>
                            <th>Check Out 2</th>
                            <th>Absen 1</th>
                            <th>Absen 2</th>
                            <th>Izin</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Cara Tarik Data Pegawai dari Mesin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="carouselExampleControls" class="carousel slide" data-interval="0" data-ride="carousel" data-bs-pause="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <p>Pastikan mesin "ON" secara default sesuai dengan data absensi yang ingin ditarik. Berikut tutorial cara cek apakah mesin "ON".</p>
                        <img src="{{asset('public/tutorial/TarikPegawai1.gif')}}" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <p>Jika tidak ada mesin "ON", klik button "OFF" pada kolom default. Ketika muncul pop up dengan text "Anda Yakin? Untuk Default Mesin Ini?", Klik "OK".</p>
                        <img src="{{asset('public/tutorial/TarikPegawai2.gif')}}" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <p>Setelah menyalakan mesin "ON", kembali ke halaman Data Absensi, lalu klik button "Tarik Absen". Tunggu beberapa saat, jika berhasil terdapat pop up berhasil dan halaman akan reload.</p>
                        <img src="{{asset('public/tutorial/TarikAbsensi.gif')}}" class="d-block w-100">
                    </div>
                </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
        </div>
    </div>
  </div>
</div>
@stop

@section('footer')
<script type="text/javascript">
    $(document).ready(function(){
        $('#sync-absensi').on('click', function(e){
            e.preventDefault();

            let tanggal = $('#tanggal').val();
            let tanggal2 = $('#tanggal2').val();

            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })

                    $.ajax({
                        url     : "{{url('Admin/Absensi/Data-Synchronous-Absensi')}}",
                        method  : "POST",
                        data    : {tanggal:tanggal, tanggal2:tanggal2},
                        success : function(success){
                            console.log(success);
                            if(success.errors){
                                swal("GAGAL!", success.errors, "error")
                            }else{
                                swal("Sukses!", "Berhasil Sync Data Absensi!", "success");
                                setInterval(() => {
                                   window.location.reload();
                                }, 2000);
                            }
                        },
                        error : function(error){
                            console.log(error);
                            swal("Gagal!", "Gagal Sync Data Absensi!\n Periksa Jaringan Anda!", "error");
                        }
                    });
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sync-absensi2').on('click', function(e){
            e.preventDefault();

            let tanggal = $('#tanggal').val();
            let tanggal2 = $('#tanggal2').val();

            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })

                    $.ajax({
                        url     : "{{url('Admin/Absensi/Data-Synchronous-Absensi2')}}",
                        method  : "POST",
                        data    : {tanggal:tanggal, tanggal2:tanggal2},
                        success : function(success){
                            console.log(success);
                            if(success.errors){
                                swal("GAGAL!", success.errors, "error")
                            }else{
                                swal("Sukses!", "Berhasil Sync Data Absensi2!", "success");
                                setInterval(() => {
                                   window.location.reload();
                                }, 2000);
                            }
                        },
                        error : function(error){
                            console.log(error);
                            swal("Gagal!", "Gagal Sync Data Absensi!\n Periksa Jaringan Anda!", "error");
                        }
                    });
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sync-absensi3').on('click', function(e){
            e.preventDefault();

            let tanggal = $('#tanggal').val();
            let tanggal2 = $('#tanggal2').val();

            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })

                    $.ajax({
                        url     : "{{url('Admin/AttR/sync-dt')}}",
                        method  : "POST",
                        data    : {tanggal:tanggal, tanggal2:tanggal2},
                        success : function(success){
                            console.log(success);
                            if(success.errors){
                                swal("GAGAL!", success.errors, "error")
                            }else{
                                swal("Sukses!", "Berhasil Sync Data Attendance!", "success");
                                setInterval(() => {
                                   window.location.reload();
                                }, 2000);
                            }
                        },
                        error : function(error){
                            console.log(error);
                            swal("Gagal!", "Gagal Sync Data Attendance!\n Periksa Jaringan Anda!", "error");
                        }
                    });
        })
    })
</script>
<script type="text/javascript">
    function destroy(id){
        swal({
            title: "Anda Yakin?",
            text: "Untuk menghapus departement ini?",
            icon: 'warning',
            buttons: true,
            dangerMode: true
        })
        .then((willDelete) => {
            if(willDelete) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        url: "{{url('Admin/Absensi/Delete')}}/"+id,
                        method: 'DELETE',
                        success: function (results) {
                            swal("Berhasil!", "Data Berhasil Dihapus!", "success");
                            window.location.reload();
                        },
                        error: function (results) {
                            swal("GAGAL!", "Gagal Menghapus Data!", "error");
                        }
                    });
            }else{
                swal("Data Departement Batal Dihapus", "", "info")
            }
        })
    }
</script>

@stop
