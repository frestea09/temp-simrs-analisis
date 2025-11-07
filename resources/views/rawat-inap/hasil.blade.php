@extends('master')
@section('header')
<h1>Hasil Penunjang<small></small></h1>
@endsection

@section('content')
<style>
    .td-btn{
        margin: 0 !important;
        padding: 0 !important;
        vertical-align: middle !important;
    }
    .vertical-center{
        vertical-align: middle !important;
    }

</style>
<div class="box box-primary">
  <div class="box-header with-border">
    {{-- <h4>Periode Tanggal :</h4> --}}
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/hasil-filter', 'class'=>'form-horizontal']) !!}
    {{-- <input type="hidden" name="jenis_reg" value="I2"> --}}
    <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
          </div>
        </div> 
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Kelompok</button>
          </span>
          <select name="kelompok_kelas" class="form-control select2" onchange="this.form.submit()" id="">
              <option value=""> --Semua-- </option>
              @foreach ($kelompok_kelas as $key => $item)
              <option value="{{ $item }}" {{$item == @$kelas_selected ? 'selected' :''}}>{{ str_replace('_',' ',$item) }}</option>
              @endforeach
          </select>
        </div>
      </div>
    </div>
    
    {!! Form::close() !!}
    <hr>
    {{-- {{dd(count($inap))}} --}}
    @if(@count($inap) > 0)
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data' style="font-size: 12px">
          <thead>
            <tr>
              
              {{-- <th class="text-center" style="vertical-align: middle">No</th> --}}
              <th class="text-center" style="vertical-align: middle">RM</th>
              <th class="text-center" style="vertical-align: middle">Pasien</th>
              <th class="text-center" style="vertical-align: middle">DPJP</th>
              <th class="text-center" style="vertical-align: middle">Usia</th>
              <th class="text-center" style="vertical-align: middle">Tgl.Lahir</th>
              <th class="text-center" style="vertical-align: middle">Kelas</th>
              <th class="text-center" style="vertical-align: middle">Kamar</th>
              <th class="text-center" style="vertical-align: middle">Bed</th>
              <th class="text-center" style="vertical-align: middle">Bayar</th>
              <th class="text-center" style="vertical-align: middle">Masuk</th>
              <th class="text-center" style="vertical-align: middle">Keluar</th>
              <th class="text-center" style="vertical-align: middle">Hasil Radiologi</th>
              <th class="text-center" style="vertical-align: middle">Hasil Radiologi Gigi</th>
              <th class="text-center" style="vertical-align: middle">Hasil Laboratorium</th>
              <th class="text-center" style="vertical-align: middle">Hasil Laboratorium PA</th>
            </tr>
          </thead>
          
          <tbody>
            @foreach($inap as $key => $d)
              <tr>
                {{-- <td>{{ @$no++ }}</td> --}}
                <td>{{ @$d->registrasi->pasien->no_rm }}</td>
                <td>{{ @$d->registrasi->pasien->nama }}</td>
                <td>{{ @$d->dokter_ahli->nama }}</td>
                <td>{{ hitung_umur(@$d->registrasi->pasien->tgllahir, 'buln') }}</td>
                <td>{{ date("d/m/Y", strtotime(@$d->registrasi->pasien->tgllahir)) }}</td>
                <td>{{ @$d->kelas->nama }}</td>
                <td>{{ @$d->kamar->nama }}</td>
                <td>{{ @$d->bed->nama }}</td>
                <td>{{ @$d->registrasi->bayars->carabayar }}
                  {{ !empty(@$d->registrasi->tipe_jkn) ? ' - '.@$d->registrasi->tipe_jkn : '' }}
                </td>
                <td onclick="updateTgl({{ $d->registrasi_id }})">{{date('d-m-Y H:i',strtotime($d->tgl_masuk)) }}</td>
                <td class="text-center">{{ $d->tgl_keluar ? tanggal_eklaim($d->tgl_keluar) : '-'}}</td>
                <td> 
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-success">Cetak</button>
                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                      @foreach (@$d->registrasi->ekspertise as $p)
                        <li>
                          <a href="{{ url("radiologi/cetak-ekpertise/".@$p->id."/".@$d->registrasi_id."/".@$p->folios_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </td>
                <td> 
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-success">Cetak</button>
                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                      @foreach (@$d->registrasi->ekspertise_gigi as $p)
                        <li>
                          <a href="{{ url("radiologi-gigi/cetak-ekpertise/".@$p->id."/".@$d->registrasi_id."/".@$p->folios_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success">Cetak</button>
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                          @foreach (@$d->registrasi->hasilLab_klinis as $k)
                              {{-- <li><a href="{{ url('pemeriksaanlab/cetak/'.@$d->registrasi_id.'/'.@$k->id) }}" class="btn btn-flat btn-sm" target="_blank"> {{ @$k->no_lab }}</a></li> --}}
                              <li><a href="{{ url('cetak-lis-pdf/' . $k->no_lab . '/' . $d->registrasi_id) }}" class="btn btn-flat btn-sm" target="_blank"> {{ @$k->no_lab }}</a></li>
                          @endforeach
                        </ul>
                    </div>         
                </td>
                <td>
                  <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-success">Cetak</button>
                      <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        @foreach (@$d->registrasi->hasilLab_patalogi as $p)
                            <li><a href="{{ url('pemeriksaanlabCommon/cetak/'.$d->id.'/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank"> {{ $p->created_at }}</a></li>
                        @endforeach
                      </ul>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>

@endsection