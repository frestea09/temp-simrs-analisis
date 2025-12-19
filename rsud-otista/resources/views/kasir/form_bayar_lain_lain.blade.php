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
            @php
              $total_bayar = 0;
            @endphp
            <tbody>
              @foreach ($rincian as $key => $d)
              @php
                $total_bayar += $d->hargajual;
              @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ App\Masterobat::find($d->masterobat_id)->nama }}</td>
                  {{-- <td class="text-center">{{ number_format($d->hargajual/$d->jumlah) }}</td> --}}
                  <td class="text-center">{{ $d->jumlah }}</td>
                  <td class="text-right">{{ number_format($d->hargajual) }}</td>
                  <td style="width: 12%">
                    <input type="text" name="" value="{{ number_format($d->hargajual) }}" class="form-control text-right">
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-right">Diskon Rp</th>
                <th style="width: 15%"> {!! Form::text('diskon_rupiah', 0, ['class' => 'form-control input-sm uang', 'onkeyup'=>'hitungDiskonRupiah()']) !!}</th>
              </tr>
              <tr>
                <th colspan="4" class="text-right">Diskon %</th>
                <th style="width: 15%"> {!! Form::number('diskon_persen', @$data_obat->diskon ?@$data_obat->diskon :0, ['class' => 'form-control input-sm', 'onkeyup'=>'hitungDiskonPersen()']) !!}</th>
              </tr>
              <tr>
                <th colspan="3" class="text-right">Total Tagihan </th>
                <th class="text-right">{{ number_format($total_bayar) }}</th>
                <th><input type="text" name="dibayar" value="{{ number_format($total_bayar) }}" class="form-control text-right"></th>
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

@section('script')
  <script type="text/javascript">
   $('form').submit(function() {
        $('#btnSave').prop('disabled',true);
    });
    
    
    
    $('input[name="dibayar"]').val('{{ number_format($total_bayar) }}')
    // Currency
    $('.uang').maskNumber({
      thousands: ',',
      integer: true,
    });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    function hitungDiskonRupiah() {
      var total_tagihan = $('input[name="total"]').val();
      var diskon_rupiah = $('input[name="diskon_rupiah"]').val();
      var totalTagihan  = parseInt( total_tagihan.split(',').join("") );
      var diskonRupiah  = parseInt( diskon_rupiah.split(',').join("") );
      var totalBayar    = Math.round(totalTagihan - diskonRupiah);
      var persen        = Math.round((diskonRupiah / totalTagihan)*100);
      // console.log(totalBayar);
      $('input[name="dibayar"]').val(ribuan(totalBayar));
      $('input[name="diskon_persen"]').val(persen);
      $('input[name="harusBayar"]').val(ribuan(totalBayar));
    }

    function hitungDiskonPersen(){
      var total_tagihan = $('input[name="total"]').val();
      var diskon_rupiah = $('input[name="diskon_persen"]').val();
      var totalTagihan  = parseInt( total_tagihan.split(',').join("") );
      var diskonPersen  = Math.round((diskon_rupiah / 100) * totalTagihan);
      var totalBayar    = Math.round(totalTagihan - diskonPersen);
      $('input[name="dibayar"]').val(ribuan(totalBayar));
      $('input[name="diskon_rupiah"]').val(ribuan(diskonPersen));
      $('input[name="harusBayar"]').val(ribuan(totalBayar));
    }
    function totalHarusBayar()
    {
      var total = $('input[name="total"]').val();
      var iur = $('input[name="iur"]').val();
      var dijamin = parseInt( iur.split(',').join("") );
      var totalBayar = total - dijamin;
      $('input[name="totalBayar"]').val(ribuan(totalBayar));
    }
    if($('input[name="diskon_persen"]').val() > 0){
      hitungDiskonPersen()
    }
  </script>
@endsection
