@extends('master')
@section('header')
  <h1>Pembayaran Obat Non Pasien</h1>

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
                <th>Nama Obat</th>
                {{-- <th class="text-center">Harga @</th> --}}
                <th class="text-center">Jumlah</th>
                <th class="text-center">Harga Total</th>
                <th class="text-center">Bayar</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rincian as $key => $d)
                 @php
                  $uang_jasa_racik = \Modules\Registrasi\Entities\Folio::where('namatarif', $d->no_resep)->sum('jasa_racik');
                  $total_racik = !empty($d->uang_racik) ? $d->uang_racik :0
                @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ App\Masterobat::find($d->masterobat_id)->nama }}</td>
                  {{-- <td class="text-center">{{ number_format($d->hargajual/$d->jumlah) }}</td> --}}
                  <td class="text-center">{{ $d->jumlah }}</td>
                  <td class="text-right">{{ number_format($d->hargajual+$total_racik) }}</td>
                  <td style="width: 12%">
                    <input type="text" name="" value="{{ number_format($d->hargajual+$total_racik) }}" class="form-control text-right">
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3" class="text-right">Total Tagihan </th>
                <th class="text-right">{{ number_format($total+$uang_racik+$jasa_racik) }}</th>
                <th><input type="text" name="dibayar" value="{{ number_format($total+$uang_racik+$jasa_racik) }}" class="form-control text-right"></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="pull-right btn-group">
          <a href="#" class="btn btn-warning btn-flat">Batal</a>
          <button type="submit" class="btn btn-success btn-flat"> Bayar </button>
        </div>
      {!! Form::close() !!}


    </div>
  </div>

@endsection
