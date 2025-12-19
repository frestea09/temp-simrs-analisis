@extends('master')
@section('header')
<h1>Laporan Penunjang </h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/lap-penunjang', 'class'=>'form-horizontal']) !!}
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="tanggal" class="col-md-3">Tanggal</label>
          <div class="col-md-4">
            <input type="text" autocomplete="off" name="tga" value="{{ !empty($_POST['tga']) ? $_POST['tga'] : '' }}"
              class="form-control datepicker">
            <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
          <div class="col-md-4">
            <input type="text" autocomplete="off" name="tgb" value="{{ !empty($_POST['tgb']) ? $_POST['tgb'] : '' }}"
              class="form-control datepicker">
            <small class="text-danger">{{ $errors->first('tgb') }}</small>
          </div>
        </div>
        {{-- dimas --}


        {{-- enddimas --}}


      </div>
      <div class="col-md-6">
        {{-- <div class="form-group">
          <label for="tanggal" class="col-md-3">Nama Poli</label>
          <div class="col-md-8">
            <select class="form-control select2" name="poli_id">
              <option value="">[Semua]</option>
              @foreach ($poli as $key => $d)
              @if (!empty($_POST['poli_id']) && $_POST['poli_id'] == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
              @else
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div> --}}
        {{-- <div class="form-group">
          <label for="tanggal" class="col-md-3">Nama Dokter</label>
          <div class="col-md-8">
            <select class="form-control select2" name="dokter_id">
              <option value="">[Semua]</option>
              @foreach ($dokter as $key => $d)
              @if (!empty($_POST['dokter_id']) && $_POST['dokter_id'] == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
              @else
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
              @endif

              @endforeach
            </select>
          </div>
        </div> --}}
        <div class="form-group">
          <label for="tanggal" class="col-md-3"> &nbsp; </label>
          <div class="col-md-8">
            <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
            {{-- <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL"> --}}
            {{-- <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-excel-o" value="CETAK"
              formtarget="_blank"> --}}
          </div>
        </div>

      </div>
    </div>

    {!! Form::close() !!}
    <hr>
    {{-- ================================================================================================== --}}
    <div class='table-responsive'>
      {{-- <table class='table table-striped table-bordered table-hover table-condensed' id='data'> --}}
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr>
            <th>No</th>
            <th>Penunjang</th>
            <th>Umum</th>
            <th>JKN</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Radiologi</td>
            <td>{{@$rad_umum ? $rad_umum : 0}}</td>
            <td>{{@$rad_jkn ? $rad_jkn : 0}}</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Laboratorium Patologi Klinik</td>
            <td>{{@$lab_umum ? $lab_umum : 0}}</td>
            <td>{{@$lab_jkn ? $lab_jkn : 0}}</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Laboratorium Patologi Anatomik</td>
            <td>{{@$lab_anatomi_umum ? $lab_anatomi_umum : 0}}</td>
            <td>{{@$lab_anatomi_jkn ? $lab_anatomi_jkn : 0}}</td>
          </tr>
          <tr>
            <td>4</td>
            <td>Farmasi</td>
            <td>{{@$farmasi_umum ? $farmasi_umum : 0}}</td>
            <td>{{@$farmasi_jkn ? $farmasi_jkn : 0}}</td>
          </tr>
          
        </tbody>
        <tfoot>
          <td colspan="2" class="text-right"><b>Total</b></td>
          <td>{{@$rad_umum+@$lab_umum+@$lab_anatomi_umum+@$farmasi_umum}}</td>
          <td>{{@$rad_jkn+@$lab_jkn+@$lab_anatomi_jkn+@$farmasi_jkn}}</td>
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