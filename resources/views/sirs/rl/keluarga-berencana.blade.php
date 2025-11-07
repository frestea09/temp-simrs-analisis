@extends('master')
@section('header')
  <h1>Laporan RL 3.12 Keluarga Berencana </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kegiatan-keluarga-berencana', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        {{-- <div class="col-md-3">
          <div class="input-group{{ $errors->has('batas') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('batas') ? ' has-error' : '' }}" type="button">Batas</button>
              </span>
              {!! Form::number('batas', 10, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('batas') }}</small>
          </div>
        </div> --}}
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
          <tr>
						<th class="text-center" rowspan="2" valign="top">No</th>
						<th class="text-center" rowspan="2" valign="top">METODA</th>
						<th class="text-center" colspan="2" valign="top">KONSELING</th>
            <th class="text-center" colspan="4">KB BARU DENGAN CARA MASUK</th>
            <th class="text-center" colspan="3">KB BARU DENGAN KONDISI</th>
            <th class="text-center" rowspan="2">KUNJUNG AN ULANG</th>
            <th class="text-center" colspan="2">KELUHAN EFEK SAMPING</th>
					</tr>
					<tr>
						<th class="text-center">ANC</th>
						<th class="text-center">Pasca Persalinan</th>
						<th class="text-center">BUKAN RUJUKAN</th>
						<th class="text-center">RUJUKAN INAP</th>
            <th class="text-center">RUJUKAN JALAN</th>
						<th class="text-center">TOTAL</th>
            <th class="text-center">PASCA PERSALIN AN/NIFAS</th>
            <th class="text-center">ABORTUS</th>
            <th class="text-center">LAINYA</th>
            <th class="text-center">JUMLAH</th>
            <th class="text-center">DIRUJUK</th>
					</tr>
          </thead>
          <tbody>
            @if ( isset($result) )
              @php
                $totAnc = 0;
                $totPasca = 0;
                $totBukanRujukan = 0;
                $totRujukanInap = 0;
                $totRujukanJalan = 0;
                $totCaraMasuk = 0;
                $totNifas = 0;
                $totAbortus = 0;
                $totLainnya = 0;
                $totUlang = 0;
              @endphp
              @foreach ($result as $key => $d)
              @php
                $totAnc += $d['konseling']['anc'];
                $totPasca += $d['konseling']['pasca persalinan'];
                $totBukanRujukan += $d['cara_masuk']['bukan rujukan'];
                $totRujukanInap += $d['cara_masuk']['rujukan rawat inap'];
                $totRujukanJalan += $d['cara_masuk']['rujukan rawat jalan'];
                $totCaraMasuk += ($d['cara_masuk']['bukan rujukan'] + $d['cara_masuk']['rujukan rawat inap'] + $d['cara_masuk']['rujukan rawat jalan']);
                $totNifas += $d['kondisi']['pasca persalinan'];
                $totAbortus += $d['kondisi']['abortus'];
                $totLainnya += $d['kondisi']['lainnya'];
                $totUlang += $d['kunjungan_ulang']['Y'];
              @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td class="text-center">{{ $d['metoda'] }}</td>
                  <td class="text-center">{{ $d['konseling']['anc'] }}</td>
                  <td class="text-center">{{ $d['konseling']['pasca persalinan'] }}</td>
                  <td class="text-center">{{ $d['cara_masuk']['bukan rujukan'] }}</td>
                  <td class="text-center">{{ $d['cara_masuk']['rujukan rawat inap'] }}</td>
                  <td class="text-center">{{ $d['cara_masuk']['rujukan rawat jalan'] }}</td>
                  <td class="text-center">{{ $d['cara_masuk']['bukan rujukan'] + $d['cara_masuk']['rujukan rawat inap'] + $d['cara_masuk']['rujukan rawat jalan'] }}</td>
                  <td class="text-center">{{ $d['kondisi']['pasca persalinan'] }}</td>
                  <td class="text-center">{{ $d['kondisi']['abortus'] }}</td>
                  <td class="text-center">{{ $d['kondisi']['lainnya'] }}</td>
                  <td class="text-center">{{ $d['kunjungan_ulang']['Y'] }}</td>
                  <td class="text-center">{{ 0 }}</td>
                  <td class="text-center">{{ 0 }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfooter>
              <tr>
                <th class="text-center">###</th>
                <th class="text-center">Total</th>
                <th class="text-center">{{ $totAnc }}</th>
                <th class="text-center">{{ $totPasca }}</th>
                <th class="text-center">{{ $totBukanRujukan }}</th>
                <th class="text-center">{{ $totRujukanInap }}</th>
                <th class="text-center">{{ $totRujukanJalan }}</th>
                <th class="text-center">{{ $totCaraMasuk }}</th>
                <th class="text-center">{{ $totNifas }}</th>
                <th class="text-center">{{ $totAbortus }}</th>
                <th class="text-center">{{ $totLainnya }}</th>
                <th class="text-center">{{ $totUlang }}</th>
                <th class="text-center">{{ 0 }}</th>
                <th class="text-center">{{ 0 }}</th>
              </tr>
            </tfooter>
            @endif
          </table>
        </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
  @endsection
