@extends('master')
@section('header')
<h1>Laporan Perawat </h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/perawat', 'class'=>'form-horizontal']) !!}
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
        <div class="form-group">
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
        </div>
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
            {{-- <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT"> --}}
            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
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
						<td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
					</tr>
          {{-- <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No. RM</th>
            <th>SEP</th>
            <th>L/P</th>
            <th>Klinik Tujuan</th>
            <th>Dokter DPJP</th>
            <th>Cara Bayar</th>
            <th>Perawat</th>
            <th>Tanggal</th>
          </tr> --}}
        </thead>
        <tbody>
          @foreach ($reg as $key => $d)
          @php
          $tga = !empty($_POST['tga']) ? $_POST['tga'] : '';
          $tgb = !empty($_POST['tgb']) ? $_POST['tgb'] : '';

             $user = \Modules\Pegawai\Entities\Pegawai::where('user_id', $d->user_id)->first();
          @endphp
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->no_rm }}</td>
            <td class="text-center">{{ $d->sep }}</td>
            <td class="text-center">{{ $d->kelamin }}</td>
            <td>{{ baca_poli($d->poli_id) }}</td>
            <td>{{ baca_dokter($d->dokter_id) }}</td>
            <td>{{ baca_carabayar($d->bayar) }} {{ ($d->bayar == 1) ? $d->tipe_jkn : NULL }}</td>
            <td>{{ @$user->kategori_pegawai != 1 ? @$user->nama : '-' }}</td>
            <td>{{ $d->created_at->format('d-m-Y') }}</td>
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