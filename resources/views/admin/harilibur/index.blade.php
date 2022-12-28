@extends('layouts.index', ['title' => 'Hari Libur'])

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
                <!-- <h1 class="m-0">Data Hari Libur</h1> -->
                <h1 class="m-0">Tanggal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <!-- <li class="breadcrumb-item active">Hari Libur</li> -->
                    <li class="breadcrumb-item active">Tanggal</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Tambah Data</h3>
                    </div>
                    <form action="{{ route('storeHariLibur') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="plant">Plant</label>
                                    <select name="plant" id="plant" class="form-control @error('plant') is-invalid @enderror">
                                        <option value="" selected disabled>==== Pilih Plant ====</option>
                                        <option value="Plant 1" @if(old('plant') == 'Plant 1') selected @endif>Plant 1</option>
                                        <option value="Plant 2" @if(old('plant') == 'Plant 2') selected @endif>Plant 2</option>
                                        <option value="Plant 3" @if(old('plant') == 'Plant 3') selected @endif>Plant 3</option>
                                        <option value="Plant 4" @if(old('plant') == 'Plant 4') selected @endif>Plant 4</option>
                                    </select>
                                    @error('plant')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="Keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" cols="10" rows="10" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan Hari Libur">{{ old('keterangan') }}</textarea>

                                    
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="tanggal">Tanggal Libur</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" placeholder="Tanggal Libur" value="{{ old('tanggal') }}">

                                    
                                    @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        </div>
                    </form>
                </div>
            </div> -->
            <!-- <div class="col-md-9"> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <!-- <h3 class="card-title">Data Hari Libur</h3> -->
                        <h3 class="card-title">Tanggal</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer')
<script src="{{asset('backend/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('backend/plugins/fullcalendar/main.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        events = {!! json_encode($events) !!};

        let calendar = $('#calendar').fullCalendar({
            events:  events,
            displayEventTime: true,
            selectable:true,
            selectHelper: true,
            eventClick:function(event){
                if(confirm("Are you sure you want to remove it?"))
                {
                    $.ajax({
                        url: "{{ url('Admin/Hari-Libur/Action') }}",
                        type:"POST",
                        data:{
                            id: event.id,
                            type:"delete"
                        },
                        success:function(response)
                        {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Deleted Successfully");
                            setTimeout(() => {
                                window.location.reload();
                            },1000)
                        }
                    })
                }
            }
        });
    })
</script>
@stop
