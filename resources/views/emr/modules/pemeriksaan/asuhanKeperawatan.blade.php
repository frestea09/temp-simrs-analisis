@extends('master')

<style>
  .form-box td,
  select,
  input,
  textarea {
    font-size: 12px !important;
  }

  .history-family input[type=text] {
    height: 20px !important;
    padding: 0px !important;
  }

  .history-family-2 td {
    padding: 1px !important;
  }

  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }
  
  #myImg:hover {opacity: 0.7;}
  
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }
  
  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }
  
  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }
  
  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }
  
  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }
  
  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }
  
  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }
  
  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }
  
  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
  .select2-selection__rendered{
    padding-left: 20px !important;
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
@section('header')
<h1>fisik Fisik</h1>
@endsection

@section('content')
@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>

          {{-- Anamnesis --}}

          <div class="col-md-6">
            <div class="table-responsive" style="max-height: 550px !important;border:1px solid blue">
              <table class="table table-bordered" id="data" style="font-size: 12px;">
                @if (count($riwayats) == 0)
                  <tr>
                    <td>Belum Ada Record</td>
                  </tr>
                @else
                  @foreach ($riwayats as $d)
                    @php
                      $diag = json_decode($d->diagnosis, true);
                      $pemeriksaan = json_decode($d->pemeriksaandalam, true);
                      $fungsional = json_decode($d->fungsional, true);
                      $jam_tindakan  = json_decode(@$d->fisik, true) ?? @$d->fisik;
                      $keterangan  = json_decode(@$d->keterangan, true) ?? @$d->keterangan;
                    @endphp 
                    <tr style="background-color:#9ad0ef">
                      <th style="width: 50%;">{{@$d->registrasi->reg_id}}</th>
                      <th>
                        {{ @$d->user->name }}
                      </th>
                    </tr>
                    
                    <tr style="background-color:#9ad0ef">
                      <th style="width: 50%;">{{ date('d-m-Y H:i', strtotime(@$d->created_at)) }}</th>
                      <th>
                        {{ @$d->type == "asuhan-keperawatan" ? 'Asuhan Keperawatan' : 'Asuhan Kebidanan' }}
                      </th>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <span style="font-weight: bold;">Jam Tindakan :</span>
                        <br>
                        @if ($jam_tindakan)
                            @if (is_array($jam_tindakan))
                                @foreach ($jam_tindakan as $jam)
                                    @if (!empty($jam))
                                        *{{date('d-m-Y H:i', strtotime($jam))}} <br>
                                    @endif
                                @endforeach
                            @else
                              {{date('d-m-Y H:i', strtotime($d->fisik))}}
                            @endif
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <span style="font-weight: bold;">Keterangan :</span>
                        <br>
                        @if ($keterangan)
                            @if (is_array($keterangan))
                                @foreach ($keterangan as $ket)
                                    *{{$ket}} <br>
                                @endforeach
                            @else
                              {{$d->keterangan}}
                            @endif
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <span style="font-weight: bold;">Diagnosa :</span>
                        <br>
                        @if (is_array($diag))
                          @foreach ($diag as $diagnosa)
                            *{{ $diagnosa }} <br>
                          @endforeach
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <span style="font-weight: bold;">Intervensi :</span>
                        <br>
                        @if (is_array($pemeriksaan))
                          @foreach ($pemeriksaan as $intervensi)
                            *{{ $intervensi }} <br>
                          @endforeach
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <span style="font-weight: bold;">Implementasi :</span>
                        <br>
                        @if (is_array($fungsional))
                          @foreach ($fungsional as $i)
                            *{{ $i }} <br>
                          @endforeach
                        @endif
                      </td>
                    </tr>
                    @if (Auth::user()->id == $d->user_id)
                      <tr>
                        <td colspan="2">
                          <span class="pull-right">
                            <a href="{{url('emr-askep/delete/'.$d->id)}}" data-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');">
                              <i class="fa fa-trash text-danger"></i>
                            </a>
                          </span>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                @endif
              </table>
            </div>
          </div>

          <div class="col-md-6">
            
            @include('emr.modules.pemeriksaan.select-askep')

            <div style="text-align: right;">
              <button class="btn btn-success">Simpan</button>
            </div>
          </div>

        </div>
      </div>
    </form>
    @include('emr.modules.pemeriksaan.modal-tte-askep')
  </div>

    @if ($unit == "inap")
        @php
            $biaya_diagnosa_awal = @\App\PaguPerawatan::find($rawatinap->pagu_diagnosa_awal)->biaya ?? 0;
        @endphp
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title pull-left">
                    Total Tagihan Sementara Rp. {{ number_format($tagihan) }}
                </h3>
                <h3 class="box-title pull-right">Deposit : Rp.
                    {{ number_format(App\Deposit::where('registrasi_id', $reg->id)->sum('nominal')) }}</h3>
            </div>
            <div class="box-header with-border">
                <h3 class="box-title pull-left">
                    Biaya Diagnosa Awal {{"Rp. " . number_format($biaya_diagnosa_awal)}}
                </h3>
            </div>
            @if ($biaya_diagnosa_awal > 0)
                <div class="box-header with-border">
                        @php
                            $sisa_biaya  = $biaya_diagnosa_awal - $tagihan;
                            $sisa_persen = sprintf("%.2f", ($sisa_biaya / $biaya_diagnosa_awal) * 100);
                        @endphp
                        @if ($sisa_persen <= 0)
                            <h5 class="pull-left blink_me">
                                Melebihi Biaya Diagnosa Awal {{"Rp. " . number_format($tagihan - $biaya_diagnosa_awal)}}
                            </h5>
                        @else
                            <h5 class="pull-left {{$sisa_persen <= 20 ? 'blink_me' : ''}}">
                                Biaya Diagnosa Awal Tersisa {{"Rp. " . number_format($biaya_diagnosa_awal - $tagihan)}} ({{$sisa_persen . '%'}})
                            </h5>
                        @endif
                </div>
            @endif
            <div class="box-body">
                <div class="box box-info">
                    <div class="box-body">
                        {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/entry-tindakan/save', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('jenis', $reg->bayar) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('dokter_id', @$rawatinap->dokter_id ? @$rawatinap->dokter_id : $reg->dokter_id) !!}
                        <div class="row">
                            <div class="col-md-7">

                                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                    {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-10">
                                        {{-- {!! Form::select('pelaksana', $dokter, session('pelaksana') ? session('pelaksana') : null, ['class' => 'select2', 'style'=>'width:100%']) !!} --}}
                                        <select name="pelaksana" class="select2 form-control" style="width: 100%">
                                            <option value="" selected>Pilih Pelaksana</option>
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ @$rawatinap->dokter_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-10">
                                        <select name="tarif_id[]" id="select2Multiple" class="form-control" required
                                            multiple></select>
                                        <small class="text-info">Pilihan Tarif mengikuti kolom pilihan <b>Kelas</b>, tanpa harus
                                            mutasi</small>
                                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                    </div>
                                    {!! Form::label('bayar', 'Bayar', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <select name="cara_bayar_id" class="chosen-select">
                                            @foreach ($carabayar as $key => $item)
                                                @if ($key == $reg->bayar)
                                                    <option value="{{ $key }}" selected>{{ $item }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
                                    {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <select name="kelas_id" class="select2 form-control">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($kelas as $key => $item)
                                                <option value="{{ $key }}"
                                                    {{ $key == @$rawatinap->kelas->id ? 'selected' : '' }}>{{ $item }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('waktu_visit_dokter') ? ' has-error' : '' }}">
                                    {!! Form::label('waktu_visit_dokter', 'Waktu Visit Dokter', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <input type="time" class="form-control" name="waktu_visit_dokter">
                                        <small class="text-danger">{{ $errors->first('waktu_visit_dokter') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                                    {!! Form::label('cyto', 'Cito', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <select name="cyto" id="" class="form-control">
                                            <option value="" selected>Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                        <small class="text-danger">{{ $errors->first('cyto') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                    </div>
                                    <input type="hidden" name="dijamin" value="0">
                                    <div class="col-sm-4">
                                        <div class="btn-group pull-left">
                                            {!! Form::submit('Simpan', [
                                                'class' => 'btn btn-success btn-flat',
                                                'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                            </div>

                            <div class="col-md-5">
                                <div class='table-responsive' style="overflow: hidden;">
                                    <table class='table-striped table-bordered table-hover table-condensed table'>
                                        <tbody>
                                            <tr>
                                                <th>Nama Pasien</th>
                                                <td>{{ $reg->pasien->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>No. RM</th>
                                                <td>{{ $reg->pasien->no_rm }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{ $reg->pasien->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cara Bayar</th>
                                                <td>{{ baca_carabayar($reg->bayar) }}
                                                    @if ($reg->bayar == '1')
                                                        @if (!empty($reg->tipe_jkn))
                                                            - {{ $reg->tipe_jkn }}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($reg->bayar == '1')
                                                <tr>
                                                    <th>No. SEP</th>
                                                    <td>{{ $reg->no_sep ? $reg->no_sep : @\App\HistoriSep::where('registrasi_id', $reg->id)->first()->no_sep }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Kelas Perawatan </th>
                                                <td>{{ baca_kelas(@$rawatinap->kelas_id) }}</td>
                                                @php
                                                    session(['kelas_id' => @$reg->kelas_id]);
                                                @endphp
                                            </tr>
                                            <tr>
                                                <th>DPJP UTAMA</th>
                                                <td> <b> {{ baca_dokter(@$rawatinap->dokter_id) }} </b></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Masuk</th>
                                                <td> {{ tanggal_eklaim(@$rawatinap->tgl_masuk) }} </td>
                                            </tr>
                                            <tr>
                                                <th>Kamar </th>
                                                <td>{{ baca_kamar(@$rawatinap->kamar_id) }}</td>
                                            </tr>
                                            <tr>
                                                <th>ICD 9</th>
                                                <td>
                                                @if (!empty($icd9))
                                                    {{ implode(',', $icd9) }}
                                                @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ICD 10</th>
                                                <td> 
                                                    @if (!empty($icd10))
                                                        {{ implode(',', $icd10) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Diagnosa Awal</th>
                                                <th>
                                                    <div class="form-group">
                                                        <div style="margin-left: 18px; width: 90%">
                                                            <select name="biaya_diagnosa_awal" class="form-control select2" id="" style="width: 100%;">
                                                                <option value="">-- Pilih --</option>
                                                                @foreach ($pagu as $p)
                                                                    <option value="{{ $p->id }}" {{$p->id == @$rawatinap->pagu_diagnosa_awal ? 'selected' : ''}}>{{ $p->diagnosa_awal .' - '.$p->biaya }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>
                                                    <button class="btn btn-success" type="button" id="update_diagnosa_awal"><i class="fa fa-save"></i></button>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- ======================================================================================================================= --}}
                <div class="dataTindakanIrna">
                    {{-- progress bar --}}
                    <div class="progress progress-sm active">
                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">97% Complete</span>
                        </div>
                    </div>
                </div>

                <div class="pull-right">
                    <a href="{{ url('rawat-inap/billing') }}" class="btn btn-primary btn-sm btn-flat"><i
                            class="fa fa-step-backward"></i> SELESAI</a>
                </div>

            </div>
        </div>

        <div class="modal fade" id="editTindakanModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'class' => 'form-horizontal', 'id' => 'editTindakanForm']) !!}
                    <input type="hidden" name="folio_id" value="">
                    <input type="hidden" name="registrasi_id" value="">
                    <input type="hidden" name="id_tarif" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
                                {!! Form::label('dpjp', 'DPJP IRNA', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="dpjp" class="select2form-control" style="width: 100%">
                                        @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('dpjp') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="pelaksana" class="form-control" style="width: 100%">
                                        @foreach ($dokter as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                                {!! Form::label('perawat', 'Kepala Unit', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="perawat" class="form-control select2" style="width: 100%">
                                        @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('perawat') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="tarif_id" style="width: 100%">
                                        @foreach (Modules\Tarif\Entities\Tarif::whereIn('jenis', ['TI'])->get() as $d)
                                            <option value="{{ $d->id }}">{{ $d->kode }} |
                                                {{ $d->nama }} | {{ number_format($d->total) }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                    <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                                {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="cara_bayar_id" class="select2 form-control" style="width: 100%">
                                        @foreach ($carabayar as $key => $item)
                                            @if ($key == $reg->bayar)
                                                <option value="{{ $key }}" selected>{{ $item }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('dijamin') ? ' has-error' : '' }}">
                                {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                                    <small class="text-danger">{{ $errors->first('dijamin') }}</small>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-flat"
                            onclick="saveEditTindakan()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


  @endsection

  @section('script')

  <script type="text/javascript">
  status_reg = "<?= substr($reg->status_reg,0,1) ?>"
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);  
        
        $('#historiAskep').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriAskep').modal('show');
            $('#dataHistoriAskep').load("/emr-riwayat-askep/" + id);
        });
  </script>
   <script>
    function diberikan() {
      var checkBox = document.getElementById("edukasiDiberikan");
      var text = document.getElementById("edukasiDiberikanText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicara() {
      var checkBox = document.getElementById("bicaraId");
      var text = document.getElementById("bicaraText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicaraSeharihari() {
      var checkBox = document.getElementById("bicaraSeharihariId");
      var text = document.getElementById("bicaraSeharihariText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function alergi() {
      var checkBox = document.getElementById("alergiId");
      var text = document.getElementById("alergiText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    </script>
  <script>
    $('.select2-diagnosis').select2({
        placeholder: "Pilih Diagnosa",
        allowClear: true,
        width: '85%'
    });
    $('.select2-pemeriksaanDalam').select2({
        placeholder: "Pilih Intervensi",
        allowClear: true
    });
    $('.select2-fungsional').select2({
        placeholder: "Pilih Impelemntasi",
        allowClear: true
    });

    $('#select2-diagnosis').change(function(e){
      var intervensi = $('#select2-pemeriksaanDalam');
      var implementasi = $('#select2-fungsional');
      var diagnosa = $(this).val();

      intervensi.empty();
      implementasi.empty();

      $.ajax({
        url: '/emr-get-askep?namaDiagnosa='+diagnosa,
        type: 'get',
        dataType: 'json',
      })
      .done(function(res) {
        if(res[0].metadata.code == 200){
          $.each(res[1], function(index, val){
            intervensi.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
          })
          $.each(res[2], function(index, val){
            implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
          })
        }
      })

    });
  </script>

  @if ($unit == "inap")
    <script type="text/javascript">
      $(".skin-blue").addClass("sidebar-collapse");
      $(function() {
          //LOAD TINDAKAN IRNA
          var registrasi_id = $('input[name="registrasi_id"]').val()
          var loadData = $('.dataTindakanIrna').load('/rawat-inap/data-tindakan/' + registrasi_id);
          if (loadData == true) {
              $('.progress').addClass('hidden')
          }
      });
      // status_reg = "<?= substr($reg->status_reg, 0, 1) ?>"
      status_reg = "I"
      var settings = {
          kelas_id: "<?= @$rawatinap->kelas_id ? $rawatinap->kelas_id : 8 ?>"
      };
      // $('select[name="kelas_id"]').change(function(){
      //   settings.kelas_id = $('select[name="kelas_id"]').val()
      // });
      // function getURL() {
      //     $('select[name="kelas_id"]').change(function(){
      //       settings.kelas_id = $('select[name="kelas_id"]').val()
      //     });
      //     let kelas_id = $('select[name="kelas_id"]').val()
      //     return '/tindakan/ajax-tindakan/'+status_reg+'/'+kelas_id;
      // }


      // console.log(settings.kelas_id)
      let kelas_id = $('select[name="kelas_id"]').val()

      $('#select2Multiple').select2({
          placeholder: "Klik untuk isi nama tindakan",
          width: '100%',
          ajax: {
              url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
              dataType: 'json',
              data: function(params) {
                  return {
                      j: 1,
                      q: $.trim(params.term)
                  };
              },
              escapeMarkup: function(markup) {
                  return markup;
              },
              processResults: function(data) {
                  return {
                      results: data
                  };
              },
              cache: true
          }
      })



      $('#update_diagnosa_awal').click(function (e) {
          e.preventDefault();
          if (confirm('Apakah anda yakin ingin mengganti Biaya Diagnosa awal?')) {
              var registrasi_id = $('input[name="registrasi_id"]').val()
              let biaya = $('select[name="biaya_diagnosa_awal"]').val()
              $.ajax({
                  url: '/rawat-inap/entry-tindakan/update/pagu/' + registrasi_id,
                  type: 'POST',
                  data: {
                      "biaya_diagnosa_awal": biaya,
                      "_token": "{{ csrf_token() }}",
                  },
                  dataType: 'json',
                  success: function(data) {
                      if (data == "ok") {
                          location.reload();
                      }
                  }
              });
          }
      })

      // on kelas change
      $('select[name="kelas_id"]').on('change', function() {
          kelas_id = $(this).val();
          console.log(kelas_id);
          $('#select2Multiple').select2({
              placeholder: "Klik untuk isi nama tindakan",
              width: '100%',
              ajax: {
                  url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
                  dataType: 'json',
                  data: function(params) {
                      return {
                          j: 1,
                          q: $.trim(params.term)
                      };
                  },
                  escapeMarkup: function(markup) {
                      return markup;
                  },
                  processResults: function(data) {
                      return {
                          results: data
                      };
                  },
                  cache: true
              }
          })
      });

      function editTindakan(folio_id, tarif_id) {
          $('#editTindakanModal').modal('show');
          $('.modal-title').text('Edit Tindakan');
          $('.select2').select2();
          $.ajax({
              url: '/rawat-inap/edit-tindakan/' + folio_id + '/' + tarif_id,
              type: 'GET',
              dataType: 'json',
              success: function(data) {
                  console.log(data);
                  if (tarif_id != 10000) {
                      $('input[name="folio_id"]').val(data.folio.id);
                      $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                      $('input[name="id_tarif"]').val(data.folio.tarif_id);

                      $('select[name="dpjp"]').val(data.dokter.dokter_id).trigger('change');
                      $('select[name="pelaksana"]').val(data.folio.dokter_pelaksana).trigger('change');
                      $('select[name="perawat"]').val(data.folio.perawat).trigger('change');
                      $('select[name="cara_bayar_id"]').val(data.folio.cara_bayar_id).trigger('change');
                      $('select[name="tarif_id"]').val(data.folio.tarif_id).trigger('change');
                      $('input[name="dijamin"]').val(data.folio.dijamin);
                  } else {
                      $('input[name="folio_id"]').val(data.folio.id);
                      $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                      $('input[name="id_tarif"]').val(data.folio.tarif_id);
                  }
              }
          });
      }

      function saveEditTindakan() {
          var data = $('#editTindakanForm').serialize();
          $.ajax({
              url: '/rawat-inap/save-edit-tindakan',
              type: 'POST',
              dataType: 'json',
              data: data,
              success: function(data) {
                  if (data.sukses == true) {
                      $('#editTindakanModal').modal('hide');
                      location.reload();
                  }
              }
          });
      }

      function ribuan(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      $('select[name="kategoritarif_id"]').on('change', function() {
          var tarif_id = $(this).val();
          var reg_id = {{ $reg_id }}
          if (tarif_id) {
              $.ajax({
                  url: '/rawat-inap/getKategoriTarifID/' + tarif_id + '/' + reg_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                      //$('select[name="tarif_id"]').append('<option value=""></option>');
                      $('select[name="tarif_id"]').empty();
                      $.each(data, function(key, value) {
                          $('select[name="tarif_id"]').append('<option value="' + value.id +
                              '">' + value.nama + ' | ' + ribuan(value.total) +
                              '</option>');
                      });

                  }
              });
          } else {
              $('select[name="tarif_id"]').empty();
          }
      });

      // tindakan inhealth
      $(document).on('click', '.inhealth-tindakan', function() {
          let id = $(this).attr('data-id');
          let body = {
              _token: "{{ csrf_token() }}",
              poli: $('input[name="poli_inhealth"]').val(),
              kodedokter: $('input[name="dokter_pelaksana_inhealth"]').val(),
              nosjp: $('input[name="no_sjp_inhealth"]').val(),
              jenispelayanan: $('input[name="jenis_pelayanan_inhealth"]').val(),
              kodetindakan: $('input[name="kode_tindakan_inhealth"]').val(),
              tglmasukrawat: $('input[name="tglmasukrawat"]').val()
          };
          if (confirm('Yakin akan di Sinkron Inhealth?')) {
              $.ajax({
                  url: '/tindakan/inhealth/' + id,
                  type: "POST",
                  data: body,
                  dataType: "json",
                  beforeSend: function() {
                      $('button#btn-' + id).prop("disabled", true);
                  },
                  success: function(res) {
                      $('button#btn-' + id).prop("disabled", false);
                      if (res.status == true) {
                          $('button#btn-' + id).prop("disabled", true);
                          alert(res.msg);
                      } else {
                          alert(res.msg);
                      }
                  }
              });
          }
      })
      $('select[name="bayar"]').on('change', function() {
          $.get('/tindakan/updateCaraBayar/' + $(this).attr('id') + '/' + $(this).val(), function() {
              location.reload();
          });
      })

    </script>
  @endif
  @endsection