@extends('master')
@section('header')
  <h1>IGD - Laporan Pengunjung<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'igd-laporan-pengunjung', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal" class="col-md-3">Tanggal</label>
            <div class="col-md-4">
              <input type="text" name="tga" value="{{ !empty($_POST['tga']) ? $_POST['tga'] : '' }}" class="form-control datepicker" >
              <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <div class="col-md-4">
              <input type="text" name="tgb" value="{{ !empty($_POST['tgb']) ? $_POST['tgb'] : '' }}" class="form-control datepicker" >
              <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-3">Cara Bayar</label>
            <div class="col-md-8">
              <select class="form-control select2" style="width: 100%" name="jenis_pasien">
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
            <label for="tanggal" class="col-md-3">Kategori JKN</label>
            <div class="col-md-8">
              <select class="form-control select2" style="width: 100%" name="tipe_jkn">
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
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal" class="col-md-4">Nama Dokter</label>
            <div class="col-md-8">
              <select class="form-control select2" style="width: 100%" name="dokter_id">
                <option value="">[Semua]</option>
                @foreach ($dokter as $key => $d)
                  @if (!empty($_POST['dokter_id']) && $_POST['dokter_id'] == $d->id)
                    <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                  @else
                    <option value="{{ $d->id }}" >{{ $d->nama }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          {{-- <div class="form-group">
            <label for="tanggal" class="col-md-4">Cara Bayar</label>
            <div class="col-md-8">
              <select class="form-control" name="bayar">
                <option value="">[Semua]</option>
                <option value="1">JKN</option>
                <option value="2">Umum</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-4">Nama Kota</label>
            <div class="col-md-8">
              <select class="form-control" name="kota">
                <option value="">[Semua]</option>
                @foreach ($kota as $key => $d)
                  <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
              </select>
            </div>
          </div> --}}
          <div class="form-group">
            <label for="tanggal" class="col-md-4">Petugas Registrasi</label>
            <div class="col-md-8">
              <select class="form-control select2" style="width: 100%" name="user_create">
                <option value="">[Semua]</option>
                @foreach ($user_create as $key => $d)
                  @if (!empty($_POST['user_create']) && $_POST['user_create'] == $d->user_create)
                    <option value="{{ $d->user_create }}" selected>{{ App\User::find($d->user_create)->name }}</option>
                  @else
                    <option value="{{ $d->user_create }}" >{{ App\User::find($d->user_create)->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4">Tindakan</label>
            <div class="col-md-8">
              <select class="form-control select2" style="width: 100%" name="tindakan">
                <option value="">[Semua]</option>
                @foreach ($tarif as $t)
                  @if(!empty($_POST['tindakan']) && $_POST['tindakan'] == $t->id)
                    <option value="{{ $t->id }}" selected>{{ $t->nama }}</option>
                  @else 
                    <option value="{{ $t->id }}">{{ $t->nama }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>

          <div class="pull-left btn-group">
            <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
            <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
            <input type="submit" name="pdf" class="btn btn-danger btn-flat" value="CETAK">
          </div>

        </div>
      </div>

      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      @isset($reg)

      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th style="vertical-align: middle">No</th>
              <th style="vertical-align: middle">Nama</th>
              <th style="vertical-align: middle">No. RM</th>
              {{-- <th style="vertical-align: middle">Umur</th> --}}
              <th style="vertical-align: middle">L/P</th>
              {{-- <th>Alamat</th> --}}
              <th style="vertical-align: middle">Poli Tujuan</th>
              <th style="vertical-align: middle">Dokter</th>
              <th style="vertical-align: middle">Cara Bayar</th>
              <th style="vertical-align: middle">Tanggal</th>
              <th style="vertical-align: middle">Status</th>
              <th style="vertical-align: middle">Petugas</th>
              <th style="vertical-align: middle">Tarif</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->pasien->nama }}</td>
                <td>{{ $d->pasien->no_rm }}</td>
                {{-- <td>{{ hitung_umur($d->pasien->tgllahir, 'Y') }}</td> --}}
                <td>{{ $d->pasien->kelamin }}</td>
                {{-- <td>
                  {{ $d->pasien->alamat }}
                  {{ ucwords(strtolower(baca_kelurahan($d->pasien->village_id))) }}
                  {{ ucwords(strtolower(baca_kecamatan($d->pasien->district_id))) }}
                  {{ ucwords(strtolower(baca_kabupaten($d->pasien->regency_id))) }}
                </td> --}}
                <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                <td>{{ !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : '' }}</td>
                <td>{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                <td>{{ date("d-m-Y", strtotime($d->tanggal)) }}</td>
                <td>
                  @if ($d->status == 'baru')
                    Baru
                  @elseif($d->status == 'lama')
                    Lama
                  @endif
                </td>
                <td>{{ App\User::find($d->user_create)->name }}</td>
                <td class="text-right">{{ number_format($d->total) }}</td>
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
        $('.select2').select2()

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
