@extends('master')
@section('header')
  <h1>Laporan Jurnal Penerimaan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/journal', 'class'=>'form-horizontal']) !!}
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-md-6">
              <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                  </span>
                  {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('tga') }}</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-group{{ $errors->has('tgs') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default{{ $errors->has('tgs') ? ' has-error' : '' }}" type="button">Sampai Tanggal</button>
                  </span>
                  {!! Form::text('tgs', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('tgs') }}</small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 pull-right">
              <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="SUBMIT">
              {{-- <button type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                  value="daily">EXCEL</button>
            </div> --}}
          </div>
        </div>
        {!! Form::close() !!}
        {{-- {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/journal_export', 'class' =>
        'form-horizontal']) !!}
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-5">
                    <div class="input-group{{ $errors->has('tgea') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgea') ? ' has-error' : '' }}"
                                type="button">Bulan Awal</button>
                        </span>
                        {!! Form::text('tgea', null, ['class' => 'form-control monthpicker', 'required' =>
                        'required']) !!}
                        <small class="text-danger">{{ $errors->first('tgea') }}</small>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group{{ $errors->has('tges') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tges') ? ' has-error' : '' }}"
                                type="button">Bulan Akhir</button>
                        </span>
                        {!! Form::text('tges', null, ['class' => 'form-control monthpicker', 'required' =>
                        'required']) !!}
                        <small class="text-danger">{{ $errors->first('tges') }}</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-5 pull-right">
                    <button type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                        value="monthly">EXCEL</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!} --}}
      </div>
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive col-md-12'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='laporan_akutansi'>
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No Bukti</th>
              <th>Keterangan - [Akun]</th>
              <th>Kode Akun</th>
              <th>Debit</th>
              <th>Kredit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
              <tr>
                {{-- <td>{{ $key+1 }}</td> --}}
                <td>{{ $d['date'] }}</td>
                <td>{{ $d['code'] }}</td>
                <td @if ($d['keterangan'] == 'Total') style="font-weight:bold;" @endif>{{ $d['keterangan'] }}</td>
                <td>{{ $d['akun'] }}</td>
                <td @if ($d['keterangan'] == 'Total') style="font-weight:bold;" @endif>@if (is_int($d['debit'])) {{ number_format((int) $d['debit']) }} @endif</td>
                <td @if ($d['keterangan'] == 'Total') style="font-weight:bold;" @endif>@if (is_int($d['credit'])) {{ number_format((int) $d['credit']) }} @endif</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              {{-- <td>{{ $key+1 }}</td> --}}
              <th colspan="3">Total</th>
              <th style="font-weight:bold;">{{ number_format((int) $total['debit']) }}</th>
              <th style="font-weight:bold;">{{ number_format((int) $total['credit']) }}</th>
            </tr>
          </tfoot>
        </table>
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('.yearPicker').datepicker( {
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose: true
    });
    $('.select2').select2();

    if($('select[name="jenis_pasien"]').val() == 1) {
      $('select[name="tipe_jkn"]').removeAttr('disabled');
    } else {
      $('select[name="tipe_jkn"]').attr('disabled', true);
    }

    $('select[name="jenis_pasien"]').on('change', function () {
      if ($(this).val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }

    });
  });

</script>
@endsection
