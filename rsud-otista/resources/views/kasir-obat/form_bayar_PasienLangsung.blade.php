@extends('master')
@section('header')
  <h1>Pembayaran Pasien Langsung</h1>

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <tbody>
            <tr>
              <th>Nama </th><td>{{ $pasien->nama }}</td>
            </tr>
            <tr>
              <th>Alamat </th><td>{{ $pasien->alamat }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {!! Form::open(['method' => 'POST', 'url' => '/kasir/rawatinap/save_bayar_lain_lain', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('registrasi_id', $pasien->registrasi_id) !!}
        {!! Form::hidden('total', $total) !!}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Tindakan</th>
                <th class="text-center">Harga @</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Harga Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rincian as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->namatarif }}</td>
                  <td class="text-right">{{ number_format($d->tarif->total) }}</td>
                  <td class="text-center">{{ number_format($d->total/$d->tarif->total) }}</td>
                  <td class="text-right">{{ number_format($d->total) }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-right">Total Tagihan</th>
                <th class="text-right">{{ number_format($total) }}</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="pull-right btn-group">
          <a href="#" class="btn btn-warning btn-flat">Batal</a>
          <button type="submit" class="btn btn-success btn-flat"> Bayar </button>
        </div>
        <input type="hidden" name="dibayar" value="{{ number_format($total) }}">
      {!! Form::close() !!}


    </div>
  </div>

@endsection
