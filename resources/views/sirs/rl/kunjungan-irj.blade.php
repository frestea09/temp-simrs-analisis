@extends('master')
@section('header')
  <h1>Laporan RL 5.2 Kunjungan Rawat Jalan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kujungan-rawat-jalan', 'class'=>'form-hosizontal']) !!}
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
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
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
          <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode RS</th>
                <th>Nama RS</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Kab/Kota</th>
                <th>Kode Propinsi</th>
                <th>Jenis Kegiatan</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @if ( isset($irj) )
                  @php
                    $total_keseluruhan = 0;
                  @endphp
                @foreach ($irj as $rajal)
                  @php
                    $total = 0;
                  @endphp
                  @foreach ($rajal['conf_rl52'] as $k => $v)
                    <tr>
                      <td>{{ $k+1 }}</td>
                      <td>3204090</td>
                      <td>RSUD Soreang</td>
                      <td>{{ $rajal['month'] }}</td>
                      <td>{{ $rajal['year'] }}</td>
                      <td>Bandung</td>
                      <td>32Prop</td>
                      <td>{{ $v }}</td>
                      <td>
                        @foreach ($rajal['irj'] as $key => $d)
                            @if( ($d->poli_id == 15) && ($v == "Penyakit Dalam") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 7) && ($v == "Bedah") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 18) && ($v == "Kesehatan Anak (Neonatal)") )
                              @php
                                // $lahir 	= explode(',', $d->tgl_lahir);
                                // dd($lahir,$d->jumlah);
                                // $now	= time();
                                // $lhir 	= strtotime($l);
                                // $diff 	= $now - $lhir;
                                // $day 	= round($diff / (60 * 60 * 24));
                                // $timestemp = "2020-01-01 01:02:03";
                                // $month = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->month;
                                // dd( $month );
                              @endphp
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 18) && ($v == "Kesehatan Anak Lainnya") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 1) && ($v == "Obstetri & Gynecolog (Ibu Hamil)") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 1) && ($v == "Obstetri & Gynecolog Lainnya") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 1) && ($v == "Keluarga Berencana") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 13) && ($v == "Bedah Syaraf") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 5) && ($v == "Syaraf") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 6) && ($v == "Jiwa") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 6) && ($v == "Napza") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 3) && ($v == "THT") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 4) && ($v == "Mata") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 9) && ($v == "Kulit & Kelamin") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 2) && ($v == "Gigi & Mulut") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 99) && ($v == "Geriatri") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 99) && ($v == "Kardiologi") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            {{-- @elseif( ($d->poli_id == 27) && ($v == "Radiologi") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp --}}
                            @elseif( ($d->poli_id == 8) && ($v == "Bedah Ortopedi") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 10) && ($v == "Paru") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 99) && ($v == "Kusta") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 99) && ($v == "Umum") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            {{-- @elseif( ($d->poli_id == 99) && ($v == "Rawat Darurat") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp --}}
                            {{-- @elseif( $v == "Rehabilitasi Medik" )
                              {{ $rehabmedik }}
                              @php $total += $rehabmedik @endphp --}}
                            @elseif( ($d->poli_id == 99) && ($v == "Akupuntur Medik") )  
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 99) && ($v == "Konsultasi Gizi") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 99) && ($v == "Day Care") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @elseif( ($d->poli_id == 99) && ($v == "Lain-Lain") )
                              {{ $d->jumlah }}
                              @php $total += $d->jumlah @endphp
                            @endif
                        @endforeach
                        @if( $v == "Rehabilitasi Medik" )
                          {{ $rajal['rehabmedik'] }}
                          @php $total += $rajal['rehabmedik'] @endphp
                        @elseif( $v == "Radiologi" )
                          {{ $rajal['radiologi'] }}
                          @php $total += $rajal['radiologi'] @endphp
                        @elseif( $v == "Rawat Darurat" )
                          {{ $rajal['rawatdarurat'] }}
                          @php $total += $rajal['rawatdarurat'] @endphp
                        @endif
                      </td>
                    </tr>
                    @php
                      $total_keseluruhan += $total;
                    @endphp
                  @endforeach        
                @endforeach
                <tr>
                  <th colspan="3">###</th>
                  <th>Total</th>
                  <th>{{ number_format($total_keseluruhan) }}</th>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
  @endsection

  @section('script')
  <script>
    $('#data-table').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });
  </script>
  @endsection