@extends('layouts.index', ['title' => 'Tambah Regu Kerja'])

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
                    <li class="breadcrumb-item">Regu Kerja</li>
                    <li class="breadcrumb-item active">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Regu Kerja</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('storeReguKerja')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Ketik Kode" value="{{ old('kode') }}">

                            @error('kode')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Ketik Nama" value="{{ old('nama') }}">

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_start">Tanggal Start</label>
                            <input type="date" name="tgl_start" id="tgl_start" class="form-control @error('tgl_start') is-invalid @enderror" placeholder="Pilih Tanggal Start" value="{{ old('tgl_start') }}">

                            @error('tgl_start')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <input type="number" name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror" placeholder="Ketik Hari" value="{{ old('hari') }}">

                            @error('hari')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jadwal">Jadwal</label>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="1" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>1</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="2" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>2</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="3" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>3</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="4" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>4</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="5" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>5</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="6" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>6</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="7" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>7</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="8" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>8</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="9" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>9</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="10" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>10</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="11" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>11</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="12" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>12</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="13" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>13</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="14" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>14</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="15" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>15</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="16" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>16</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="17" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>17</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="18" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>18</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="19" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>19</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="20" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>20</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="21" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>21</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="22" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>22</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="23" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>23</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="24" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>24</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="25" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>25</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="26" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>26</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="27" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>27</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="28" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>28</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="29" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>29</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="30" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>30</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="31" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>31</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="32" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>32</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="33" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>33</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="34" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>34</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="35" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>35</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="36" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>36</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="37" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>37</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="38" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>38</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="39" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>39</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="40" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>40</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="41" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>41</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="42" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>42</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="43" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>43</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="44" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>44</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="45" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>45</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="46" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>46</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="47" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>47</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="48" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>48</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="49" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>49</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="50" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>50</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="51" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>51</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="52" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>52</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="53" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>53</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="54" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>54</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="55" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>55</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="56" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>56</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="57" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>57</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="58" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>58</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="59" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>59</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="60" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>60</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="61" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>61</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="62" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>62</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="63" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>63</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="64" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>64</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="65" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>65</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="66" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>66</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="67" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>67</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="68" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>68</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="69" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>69</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="70" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>70</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="71" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>71</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="72" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>72</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="73" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>73</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="74" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>74</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="75" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>75</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="76" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>76</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="77" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>77</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="78" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>78</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="79" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>79</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="80" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>80</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="81" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>81</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="82" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>82</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="83" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>83</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="84" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>84</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="85" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>85</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="86" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>86</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="87" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>87</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="88" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>88</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="89" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>89</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="90" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>90</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="91" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>91</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="92" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>92</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="93" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>93</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="94" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>94</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="95" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>95</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="96" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>96</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="97" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>97</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="98" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>98</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="99" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>99</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="100" class="refKerja form-control" style="width: 200px;" >
                                                <option value="" selected disabled>100</option>
                                                @foreach($refKerja as $data)
                                                    <option value="{{$data->kode}}">{{$data->kode}} | {{$data->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop