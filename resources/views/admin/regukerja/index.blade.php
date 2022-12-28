@extends('layouts.index', ['title' => 'Master Regu Kerja'])

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
                <h1 class="m-0">Data Regu Kerja</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Regu Kerja</li>
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
                <div class="card-header">
                    <h3 class="card-title">Data Regu Kerja</h3>
                    <a href="{{route('addReguKerja')}}" class="text-decoration-none">
                        <button type="button" class="btn btn-sm btn-success float-right">
                            Tambah Data
                        </button>
                    </a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example11" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tanggal Start</th>
                                <th>Hari</th>
                                <th>Jadwal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                            ?>
                            @foreach($reguKerja as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->kode }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ date('d F Y' ,strtotime($data->tgl_start)) }}</td>
                                <td>{{ $data->hari }}</td>
                                <td>{{ $data->jadwal }}</td>
                                <td>
                                    <a href="{{ route('editReguKerja', $data->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                                    <button class="btn btn-sm btn-danger" id="btn-delete" onclick="destroy('{{$data->id}}')">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tanggal Start</th>
                                <th>Hari</th>
                                <th>Jadwal</th>
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
    function destroy(id){
        swal({
            title: "Anda Yakin?",
            text: "Untuk menghapus Regu kerja ini?",
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
                        url: "{{url('Admin/Regu-Kerja/Delete')}}/"+id,
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
                swal("Data Regu Kerja Batal Dihapus", "", "info")
            }
        })
    }
</script>
@stop