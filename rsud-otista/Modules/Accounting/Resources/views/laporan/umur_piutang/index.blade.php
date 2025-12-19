@extends('master')
@section('header')
  <h1>Laporan Umur Piutang </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/umur_piutang', 'class'=>'form-horizontal']) !!}
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-md-4">
              <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                  </span>
                  {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('tga') }}</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group{{ $errors->has('tgs') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default{{ $errors->has('tgs') ? ' has-error' : '' }}" type="button">Sampai Tanggal</button>
                  </span>
                  {!! Form::text('tgs', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('tgs') }}</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group{{ $errors->has('tgs') ? ' has-error' : '' }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default{{ $errors->has('tgs') ? ' has-error' : '' }}" type="button">Jenis Pembayaran</button>
                  </span>
                  {!! Form::select('pembayaran', $cara_bayar, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                  <small class="text-danger">{{ $errors->first('tgs') }}</small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-4 pull-right">
              <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="SUBMIT">
              <button type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                  value="daily">EXCEL</button>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='laporan_akutansi'>
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No Bukti</th>
              <th>Jenis Pembayaran</th>
              <th>Keterangan</th>
              <th>Total Transaksi</th>
              <th>Total Piutang</th>
              <th>Umur (Hari)</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
              <tr>
                {{-- <td>{{ $key+1 }}</td> --}}
                <td>{{ date('d-M-Y', strtotime($d['tanggal'])) }}</td>
                <td>{{ $d['code'] }}</td>
                <td>@switch(true)
                    @case(strpos($d['type'], '_umum') >= 0)
                        Umum
                        @break
                    @case(strpos($d['type'], '_bpjs') >= 0)
                        JKN BPJS
                        @break
                    @case(strpos($d['type'], '_jamkesda') >= 0)
                        Jamkesda
                        @break
                    @case(strpos($d['type'], '_asuransi') >= 0)
                        Asuransi
                        @break
                    @case(strpos($d['type'], '_jasa_raharja') >= 0)
                        Jasa Raharja
                        @break
                    @case(strpos($d['type'], '_jampersal') >= 0)
                        Jasa Raharja
                        @break
                @endswitch</td>
                <td>{{ $d['ket'] }}</td>
                <td>{{ number_format((int) $d['total_transaksi']) }}</td>
                <td>{{ number_format((int) $d['debit']) }}</td>
                <td>{{ date_diff(new DateTime($d['tanggal']), new DateTime())->days }}</td>
              </tr>
            @endforeach
          </tbody>
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
