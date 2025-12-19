<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Detail Penjualan</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <script type="text/javascript">
      // function closeMe() {
      //     window.close();
      // }
      // setTimeout(closeMe, 10000);
    </script>
    <style media="screen">
    /* @page {
          margin-top: 0.5cm;
          margin-left: 1cm;
          width: 12.5cm;
          height: 20cm;
      } */

      body{
        width: auto;
        margin-left: 25%;
        margin-right: 25%;
      }

    </style>
  </head>
  @if ($total > 0)
    <body onload="print()">
  @else
    <body>
  @endif

      <table style="width: 100%;">
        <tr>
          {{-- <td style="width:23%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="height:105px;"></td> --}}
          <td>
            <h4 style="font-size: 18pt; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
            <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            ================================================================================================
          </td>
        </tr>
          </table>
        @if ($faktur)
          <h3 class="text-center">Obat Non Kronis</h3>
        @else
          <h3 class="text-center">Faktur Penjualan Apotik Rawat Jalan</h3>
        @endif
      <table style="100%" class="table table-bordered table-condensed">
          <tbody>
              <tr>
                  <th style="width:25%">Tanggal </th> <td>{{ $penjualan->created_at->format('m-d-y H:i:s') }}</td>
              </tr>
              <tr>
                  <th>No. Kuitansi </th> <td>{{ $penjualan->no_resep }}</td>
              </tr>
              <tr>
                  <th>Nama </th> <td>{{ $reg->pasien->nama }}</td>
              </tr>
              <tr>
                  <th>Alamat </th> <td>{{ $reg->pasien->alamat }}</td>
              </tr>
              <tr>
                  <th>Tgl Lahir / Umur </th> <td>{{ tgl_indo($reg->pasien->tgllahir) }}  /  {{ hitung_umur($reg->pasien->tgllahir) }}</td>
              </tr>
              <tr>
                  <th>Jenis Kelamin </th> <td>{{ $reg->pasien->kelamin }}</td>
              </tr>
              <tr>
                  <th>No. RM</th> <td>{{ $reg->pasien->no_rm }}</td>
              </tr>
              <tr>
                  <th>Nama Dokter </th> <td>{{ baca_dokter($reg->dokter_id) }}</td>
              </tr>
          </tbody>
      </table>

      <br>
      <table style="100%" class="table table-condensed table-bordered table-condensed">
          <thead>
              <tr>
                  <th class="text-center" style="width:50px !important;">No</th>
                  <th>Nama Obat</th>
                  <th class="text-center">Harga</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Total</th>
              </tr>
          </thead>
          <tbody>
            @php
                $subtotal = 0;
            @endphp
              @foreach ($detail as $key => $d)
              @php
                  $subtotal += $d->hargaTotal;
              @endphp
                  <tr>
                      <td class="text-center">{{ $no++ }}</td>
                      <td>{{ $d->masterobat->nama }}</td>
                      <td class="text-right">{{$reg->bayar == 1 ? number_format($d->masterobat->logistik_batch->hargajual_jkn) : number_format($d->masterobat->logistik_batch->hargajual_umum)}}</td>
                      <td class="text-center">{{ $d->jumlahTotal }}</td>
                      <td class="text-right">{{ number_format( $d->hargaTotal ) }}</td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th class="text-right" colspan="4">Uang Racik</th>
              <th class="text-right">{{number_format($uang_racik)}}</th>
            </tr>
              <tr>
                <th style="text-align: right" colspan="4">Sub Total</th>
                <th style="text-align: right">{{ number_format($subtotal) }}</th>
              </tr>
              {{-- <tr>
                <th colspan="2"></th>
                <th style="text-align: right" colspan="2">Jasa</th>
                <th style="text-align: right">{{ number_format($folio->jasa_racik+$uang_racik) }}</th>
              </tr> --}}
              <tr>
                <td style="font-size:11px;" colspan="2"><i>Terbilang: {{ terbilang($subtotal+$uang_racik) }} rupiah</i></td>
                <th style="text-align: right" colspan="2">Total Tagihan</th>
                <th style="text-align: right">{{ number_format($subtotal+$uang_racik) }}</th>
              </tr>
          </tfoot>
      </table>

      <p><i><b>Terbilang: {{ terbilang($total) }} Rupiah</b></i></p>

      <div class="pull-right">
          <div class="col-md-4">
            {{-- @if ($faktur)
              <table class="table">
                  <tr>
                      <td class="text-center">
                          Pembeli,
                          <br>
                          <br>
                          <br>
                          <br>____________________
                      </td>
                      <td class="text-center">
                          Penerima,
                          <br>
                          <br>
                          <br>
                          <br>____________________
                      </td>
                  </tr>
              </table>
            @else --}}
              <table class="table">
                  <tr>
                      <td class="text-center">
                          Petugas <br/><br/>
                          {{ Auth::user()->ttd }} <br/><br/>
                          {{ Auth::user()->name }}
                      </td>
                  </tr>
              </table>
            {{-- @endif --}}
          </div>
      </div>

      <br>
      <br>
{{--  
        @if (URL::previous() == url('farmasi/laporan/penjualan'))
          <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ URL::previous() }}">
        @else
          @if ( substr(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->status_reg,0,1) == 'I' )
            <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('penjualan/irna') }}">
          @else
            <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('penjualan') }}">
          @endif
        @endif  --}}

  </body>
</html>
