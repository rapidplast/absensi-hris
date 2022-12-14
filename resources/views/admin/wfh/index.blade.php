@extends('layouts.index', ['title' => 'Master WFH'])

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
                <h1 class="m-0">Data Work From Home</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Work From Home</li>
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
                    </div>
                    <form action="{{route('searchWfh')}}" method="POST" enctype="multipart/form-data" id="form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <span>Dari Tanggal</span>
                                    @if(Route::is('searchWfh'))
                                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{$tanggal}}" required>
                                    @else
                                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{$tanggalSekarang}}" required>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <span>Ke Tanggal</span>
                                    @if(Route::is('searchWfh'))
                                    <input type="date" id="tanggal2" name="tanggal2" class="form-control" value="{{ $tanggal2 }}" required>
                                    @else
                                    <input type="date" id="tanggal2" name="tanggal2" class="form-control" value="{{ $tanggalSekarang }}" required>
                                    @endif
                                </div>
                                <div class="col-md-2 text-center">
                                    <button type="submit" class="btn btn-success mt-4">Cari Data</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Work From Home</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example11" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alasan WFH</th>
                        <th>Tanggal WFH</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                        ?>
                        @foreach($wfh as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->keterangan }}</td>
                            <td>{{ date('d F Y', strtotime($data->tanggal_cuti)) }}</td>
                            <td>
                                @if($data->status == 2)
                                    <span class="btn-sm btn-success" aria-disabled="true">Terkonfirmasi</span>
                                @elseif($data->status == 1)
                                    <span class="btn-sm btn-danger" aria-disabled="true">Ditolak</span>
                                @else
                                    <button class="btn btn-sm btn-success" id="btn-delete" onclick="confirm('{{$data->w_id}}')">Konfirmasi</button>
                                    <button class="btn btn-sm btn-danger" id="btn-delete" onclick="reject('{{$data->w_id}}')">Tolak</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alasan WFH</th>
                            <th>Tanggal WFH</th>
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
@stop

@section('footer')
<script type="text/javascript">
    function confirm(id){
        swal({
            title: "Anda Yakin?",
            text: "Untuk Konfirmasi WFH ini?",
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
                        url: "{{url('Admin/Work-From-Home/Konfirmasi-Data')}}/"+id,
                        method: 'GET',
                        success: function (results) {
                            swal("Berhasil!", "Data Berhasil Dikonfirmasi!", "success");
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000)
                        },
                        error: function (results) {
                            swal("GAGAL!", "Gagal Konfirmasi Data!", "error");
                        }
                    });
            }else{
                swal("Data WFH Batal Konfirmasi", "", "info")
            }
        })
    }
</script>
<script type="text/javascript">
    function reject(id){
        swal({
            title: "Anda Yakin?",
            text: "Untuk Tolak WFH ini?",
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
                        url: "{{url('Admin/Work-From-Home/Tolak-Data')}}/"+id,
                        method: 'GET',
                        success: function (results) {
                            swal("Berhasil!", "Data Berhasil Tolak!", "success");
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000)
                        },
                        error: function (results) {
                            swal("GAGAL!", "Gagal Tolak Data!", "error");
                        }
                    });
            }else{
                swal("Data WFH Batal Tolak", "", "info")
            }
        })
    }
</script>
@stop