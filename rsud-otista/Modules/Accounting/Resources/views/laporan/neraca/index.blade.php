@extends('master')
@section('header')
  <h1>Laporan Neraca</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/neraca', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="tanggal" class="col-md-4">Tahun Laporan</label>
            <div class="col-md-6">
              <input type="text" autocomplete="off" name="tha" value="{{$tha}}" class="form-control yearPicker" >
              <small class="text-danger">{{ $errors->first('tha') }}</small>
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-4">Level</label>
            <div class="col-md-6">
              <select name="level" value="{{$level}}" class="form-control">
                <option value="1" @if ($level == '1') selected @endif>Level 1</option>
                <option value="2" @if ($level == '2') selected @endif>Level 2</option>
                {{-- <option value="3" @if ($level == '3') selected @endif>Level 3</option>
                <option value="4" @if ($level == '4') selected @endif>Level 4</option>
                <option value="5" @if ($level == '5') selected @endif>Level 5</option> --}}
              </select>
              <small class="text-danger">{{ $errors->first('level') }}</small>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-8 pull-right">
              <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="SUBMIT">
              {{-- <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="SAP">
              <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="SAK"> --}}
            </div>
          </div>
        </div>
        <div class="col-md-8">
        </div>
      </div>

      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='laporan_akutansi'>
          <thead>
            <tr>
              <th>Kode Akun</th>
              <th>Nama Akun</th>
              <th>Saldo</th>
              {{-- <th>@if (isset($ths)) {{$ths}} @else - @endif</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
              <tr @if (isset($d['tag']) && ($d['tag'] == 'b' || $d['tag'] == 'b0'))
                  style="font-weight: bold;"
              @endif>
                {{-- <td>{{ $key+1 }}</td> --}}
                <td>{{ $d['code'] }}</td>
                <td>{{ $d['nama'] }}</td>
                <td>
                  @if (!isset($d['tag']) || isset($d['total']))    
                    {{ number_format((int) $d['realisasi']) }}
                  @endif
                </td>
                {{-- <td>
                  @if (!isset($d['tag']) || isset($d['total']))    
                    {{ number_format((int) $d['realisasi_sebelum']) }}
                  @endif
                </td> --}}
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
