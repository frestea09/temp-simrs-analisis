@extends('master')
@section('header')
  <h1>Laporan Pengisian EMR Dokter </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/laporan-pengisian-emr-dokter', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <br/>
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" id="" type="button">Poli</button>
            </span>
              {!! Form::select('poli', $poli,null, ['class' => 'form-control select2','placeholder'=>'Pilih salah satu']) !!}
          </div>
        </div>
        <div class="col-md-4">
          <br/>
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" id="" type="button">Dokter</button>
            </span>
              {!! Form::select('dokter', $dokter,null, ['class' => 'form-control select2','placeholder'=>'Pilih salah satu']) !!}
          </div>
        </div>

        <div class="col-md-4">
          <br/>
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
        
      </div>
      <br/>
        
      </div>
      {!! Form::close() !!}
      <hr>
      @if ( isset($registrasi) )
        <div class='table-responsive'>
        <h6><b>Tanggal : {{$tga ? date('d m Y', strtotime($tga)) : '-'}} / {{$tgb ? date('d m Y', strtotime($tgb)) : '-'}}</b></h6>
        <h6><b>Poliklinik : {{$filter_poli ? baca_poli($filter_poli) : '-'}}</b></h6>
        <h6><b>Dokter : {{$filter_dokter ? baca_dokter($filter_dokter) : '-'}}</b></h6>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Reg ID</th>
                <th>Pasien</th>
                <th>RM</th>
                <th>NIK</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>ASWAL</th>
                <th>CPPT</th>
                <th>RESUME TTE</th>
                <th>E-RESEP TTE</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $emrLengkap = 0;
                @endphp
                @foreach ($registrasi as $reg)
                    @if (count($reg->aswal_dokter) > 0 || count($reg->cppt_dokter) > 0)
                    {{-- @if (!empty(json_decode(@$reg->tte_resume_pasien)->base64_signed_file) || @$reg->tte_resume_pasien_status) --}}
                        @php
                            $emrLengkap++;
                        @endphp
                    <tr>
                    @else
                    <tr style="background-color: red;">
                    @endif
                        <td>{{$loop->iteration}}</td>
                        <td>{{ @$reg->id }}</td>
                        <td>{{ @$reg->pasien->nama }}</td>
                        <td>{{ @$reg->pasien->no_rm}}</td>
                        <td>{{ @$reg->pasien->nik}}</td>
                        <td>{{ baca_poli(@$reg->poli_id)}}</td>
                        <td>{{ @$reg->dokter_umum->nama }}</td>
                        <td>{{ count($reg->aswal_dokter) > 0 ? 'Lengkap' : '-' }}</td>
                        <td>{{ count($reg->cppt_dokter) > 0 ? 'Lengkap' : '-' }}</td>
                        <td>
                          @if(!empty(json_decode(@$reg->tte_resume_pasien)->base64_signed_file) || @$reg->tte_resume_pasien_status)
                          Lengkap
                          @else
                          -
                          @endif
                        </td>
                        <td>{{ @$reg->eResepTTE ? 'Lengkap' : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      @endif


    </div>
    <div class="box-footer">
        @if (isset($registrasi))
            <h6><b>JUMLAH KUNJUNGAN PASIEN PADA TANGGAL 
                {{@$tga ? date('d m Y', strtotime(@$tga)) : '-'}} 
                SAMPAI DENGAN {{@$tgb ? date('d m Y', strtotime(@$tgb)) : '-'}} ADALAH {{count(@$registrasi)}} PASIEN.
            </b></h6>
            <h6><b>
                DATA PENGISIAN PASIEN YANG DILAKUKAN OLEH DOKTER ADALAH {{$emrLengkap}} DATA    
            </b></h6>
        @endif
    </div>
  </div>

@endsection

@section('script')
  <script>
        $('.select2').select2();
  </script>
@endsection