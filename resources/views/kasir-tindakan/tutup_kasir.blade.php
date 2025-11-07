@extends('master')
@section('header')
  <h1>Laporan Tutup Kasir <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kasir/tutup-kasir', 'class' => 'form-horizontal']) !!}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-4">
                      {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                      <small class="text-danger">{{ $errors->first('tga') }}</small>
                  </div>
                  <div class="col-sm-4">
                      {!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
                      <small class="text-danger">{{ $errors->first('tgb') }}</small>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('petugas', 'Petugas', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-8">
                      <select class="form-control" name="petugas">
                        <option value="">[Semua]</option>
                        @foreach ($user as $key => $d)
                          @if (!empty($_POST['petugas']) && $_POST['petugas'] == $d->user_id)
                              <option value="{{ $d->user_id }}" selected>{{ $d->nama }}</option>
                          @else
                              <option value="{{ $d->user_id }}">{{ $d->nama }}</option>
                          @endif
                        @endforeach
                      </select>
                      <small class="text-danger">{{ $errors->first('petugas') }}</small>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    <div class="btn-group ">
                        <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                        <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
                        <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="&#xf1c1; CETAK">
                    </div>
                  </div>
              </div>

            </div>
          </div>
      {!! Form::close() !!}
      <hr>
      @isset($pembayaran)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">No. Kuitansi</th>
                <th style="vertical-align: middle;">Tgl / Waktu</th>
                <th style="vertical-align: middle;">No. RM</th>
                <th style="vertical-align: middle;">Nama</th>
                <th style="vertical-align: middle;">Cara Bayar</th>
                <th style="vertical-align: middle;">Tunai</th>
                <th style="vertical-align: middle;">Sharing</th>
                <th style="vertical-align: middle;">Subsidi</th>
                <th style="vertical-align: middle;">Kasir</th>
                <th style="vertical-align: middle;">Poli</th>
                <th style="vertical-align: middle;">Nama Dokter</th>
                {{-- <th style="vertical-align: middle;">Shift</th>
                <th style="vertical-align: middle;">Tipe Layanan</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($pembayaran as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->no_kwitansi }}</td>
                  <td>{{ tanggal($d->created_at) }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ !empty($d->bayar) ? baca_carabayar($d->bayar) : '' }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>{{ ($d->jenis == 'tunai') ? number_format($d->dibayar) : '' }}</td>
                  <td>{{ ($d->jenis == 'piutang') ? number_format($d->dibayar) : '' }}</td>
                  <td>{{ $d->subsidi }}</td>
                  <td>{{ App\User::find($d->user_id)->name }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  {{-- <td></td>
                  <td></td> --}}
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="6" class="text-right">Total</th>
                <th>{{ number_format($tunai) }}</th>
                <th>{{ number_format($piutang) }}</th>
                <th colspan="6"></th>
              </tr>
              <tr>
                <th colspan="2">Total</th>
                <th colspan="10">{{ number_format($tunai + $piutang) }}</th>
              </tr>

              <tr>
                <th colspan="2"><i>Terbilang</i></th>
                <th colspan="10"><i>{{ terbilang($tunai + $piutang) }} Rupiah</i></th>
              </tr>
            </tfoot>
          </table>
        </div>
      @endisset



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
