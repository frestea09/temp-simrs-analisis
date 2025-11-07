@extends('master')
@section('header')
  <h1>Radiologi - Laporan Kunjungan<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/radiologi/laporan-kunjungan', 'class' => 'form-horizontal']) !!}

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-3 control-label','autocomplete'=>"off"]) !!}
                <div class="col-sm-4">
                    {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
                <div class="col-md-4">
                  {!! Form::text('tgb', null, ['class' => 'form-control datepicker','autocomplete'=>"off"]) !!}
                  <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Jenis Pasien</label>
              <div class="col-md-8">
                <select class="form-control" name="status">
                  <option value="">[Semua]</option>
                  <option value="1">Baru</option>
                  <option value="2">Lama</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Petugas</label>
              <div class="col-md-8">
                <select class="form-control" name="petugas">
                  <option value="">[Semua]</option>
                  @foreach ($petugas as $key => $d)
                    <option value="{{ $d->who_update }}">{{ $d->who_update }}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Nama Dokter</label>
              <div class="col-md-8">
                <select class="form-control" name="dokter">
                  <option value="">[Semua]</option>
                  @foreach ($dokter as $key => $d)
                    @if (!empty($_POST['dokter']) && $_POST['dokter'] == $d->dokter)
                      <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                    @else
                      <option value="{{ $d->id }}" >{{ $d->nama }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Cara Bayar</label>
              <div class="col-md-8">
                <select class="form-control" name="jenis_pasien">
                  @if (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 1)
                    <option value="">[Semua]</option>
                    <option value="1" selected>JKN</option>
                    <option value="2">Umum</option>
                  @elseif (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 2)
                    <option value="">[Semua]</option>
                    <option value="1">JKN</option>
                    <option value="2" selected>Umum</option>
                  @else
                    <option value="">[Semua]</option>
                    <option value="1">JKN</option>
                    <option value="2">Umum</option>
                  @endif

                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Kategori JKN</label>
              <div class="col-md-8">
                <select class="form-control" name="tipe_jkn">
                  @if (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'PBI')
                    <option value="">[Semua]</option>
                    <option value="PBI" selected>PBI</option>
                    <option value="NON PBI">NON PBI</option>
                  @elseif (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'NON PBI')
                    <option value="">[Semua]</option>
                    <option value="PBI">PBI</option>
                    <option value="NON PBI" selected>NON PBI</option>
                  @else
                    <option value="">[Semua]</option>
                    <option value="PBI">PBI</option>
                    <option value="NON PBI">NON PBI</option>
                  @endif

                </select>
              </div>
            </div>
            <div class="btn-group">
              <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
              <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
              <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="&#xf1c1; CETAK">
            </div>

          </div>
        </div>

      {!! Form::close() !!}
      <hr>
      @isset($reg)
        <div class='table-responsive'>
          <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th style="vertical-align: middle;">No</th>
                <th style="vertical-align: middle;">No.RM</th>
                <th style="vertical-align: middle;">Nama </th>
                <th style="vertical-align: middle;">Alamat</th>
                <th style="vertical-align: middle;">Umur</th>
                <th style="vertical-align: middle;">L/P</th>
                <th style="vertical-align: middle;">Cara Bayar</th>
                <th style="vertical-align: middle;">Poli</th>
                <th style="vertical-align: middle;">Dokter Radiologi</th>
                <th style="vertical-align: middle;">Tanggal</th>
                <th style="vertical-align: middle;">Petugas</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($reg as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ $d->pasien->alamat }}</td>
                  <td>{{ hitung_umur($d->pasien->tgllahir, 'Y') }}</td>
                  <td>{{ $d->pasien->kelamin }}</td>
                  <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ $d->created_at->format('d-m-y H:i:s') }}</td>
                  <td>{{ $d->who_update }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endisset

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
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
