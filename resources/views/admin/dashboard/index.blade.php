@extends('layouts.index', [$title = 'Dashboard'])

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Pegawai</span>
                    <span class="info-box-number">{{totPegawai()}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hands"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Mesin</span>
                    <span class="info-box-number">{{totMesin()}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Data Terbackup</span>
                    <span class="info-box-number">{{totAbsenBackup()}}</span>
                </div>
            </div>
        </div> 
        <div class="col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-boxes"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Data Log Terbackup</span>
                    <span class="info-box-number">{{totLogBackup()}}</span>
                </div>
            </div>
        </div> 
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Chart</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    {!! $bar->container() !!}
                </div>
                <div class="col-md-4">
                    @if($checkIn !== 0 || $checkOut !== 0)
                    {!! $pie->container() !!}
                    @else
                    <p class="text-danger">Tidak Ada Data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('footer')
<script src="{{ $pie->cdn() }}"></script>
{{ $pie->script() }}
{{ $bar->script() }}
<script src="{{ $bar->cdn() }}"></script>
@stop
