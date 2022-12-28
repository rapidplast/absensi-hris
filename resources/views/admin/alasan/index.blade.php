@extends('layouts.index', ['title' => 'Master Alasan'])

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
                <h1 class="m-0">Data Alasan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Alasan</li>
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
                    <h3 class="card-title">Data Alasan</h3>
                    <a href="{{route('addAlasan')}}" class="text-decoration-none">
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
                        <th>Nama</th>
                        <th>Cuti</th>
                        <th>ROT</th>
                        <th>TunHa</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                        ?>
                        @foreach($alasan as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nama }}</td>
                            @if($data->cuti == 1)
                                <td>Yes</td>
                            @else
                                <td>No</td>
                            @endif
                            @if($data->rot == 1)
                                <td>Yes</td>
                            @else
                                <td>No</td>
                            @endif
                            @if($data->tunha == 0)
                                <td>Tidak Dapat Premi Hadir</td>
                            @elseif($data->tunha == 1)
                                <td>Mengurangi Premi Hadir</td>
                            @else
                                <td>Dapat Premi Hadir Penuh</td>
                            @endif
                            <td>
                                <a href="{{ route('editAlasan', $data->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <button class="btn btn-sm btn-danger" id="btn-delete" onclick="destroy('{{$data->id}}')">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Cuti</th>
                            <th>ROT</th>
                            <th>TunHa</th>
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
            text: "Untuk menghapus alasan ini?",
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
                        url: "{{url('Admin/Alasan/Delete')}}/"+id,
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
                swal("Data Alasan Batal Dihapus", "", "info")
            }
        })
    }
</script>
@stop