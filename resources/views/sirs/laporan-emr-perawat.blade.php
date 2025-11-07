@extends('master')
@section('header')
  <h1>Laporan Pengisian EMR Perawat </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/laporan-pengisian-emr-perawat', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
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
              {!! Form::select('poli', $poli,null, ['style'=>'width: 100%;', 'class' => 'form-control select2','placeholder'=>'Pilih salah satu', 'onchange'=>"getPerawat(this.value)"]) !!}
          </div>
        </div>
        <div class="col-md-4">
          <br/>
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" id="" type="button">Perawat</button>
            </span>
              <select name="perawat" class="form-control select2" id="selectPerawat" style="width: 100%;">
                <option value="">Pilih salah satu</option>
                @foreach($perawats as $id => $nama)
                <option value="{{ $id }}" {{ @$perawatSelect == $id ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
              </select>
          </div>
        </div>

        <div class="col-md-3">
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
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Reg ID</th>
                <th>Pasien</th>
                <th>RM</th>
                <th>NIK</th>
                <th>ASWAL</th>
                <th>CPPT</th>
                <th>ASKEP/ASKEB</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $emrLengkap = 0;
                @endphp
                @foreach ($registrasi as $reg)
                    @if ((count($reg->aswal_perawat) > 0 || count($reg->cppt_perawat) > 0))
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
                        <td>{{ count($reg->aswal_perawat) > 0 ? 'Lengkap' : '-' }}</td>
                        <td>{{ count($reg->cppt_perawat) > 0 ? 'Lengkap' : '-' }}</td>
                        <td>{{ (count($reg->aswal_perawat) > 0 || count($reg->cppt_perawat) > 0) ? 'Lengkap' : '-' }}</td>
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
                DATA PENGISIAN PASIEN YANG DILAKUKAN OLEH PERAWAT ADALAH {{$emrLengkap}} DATA    
            </b></h6>
        @endif
    </div>
  </div>

@endsection
@section('script')
  <script>
        $('.select2').select2();

        function getPerawat(poli){
          var selectPerawat = $('#selectPerawat');
          selectPerawat.empty();

          $.ajax({
            url: '/sirs/rl/get-perawat?poli='+poli,
            type: 'get',
            dataType: 'json',
          })
          .done(function(res) {
            // console.log(res);
            if(res.metaData.code == 200){
              selectPerawat.append('<option value="">Pilih salah satu</option>');
              $.each(res.list, function(index, val){
                selectPerawat.append('<option value="'+ val.idPerawat +'">'+ val.namaPerawat +'</option>');
              })
            }else{
              return alert(res.metaData.message)
            }
          })
        }
  </script>
@endsection