<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Detail Copy Resep</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <script type="text/javascript">
      function closeMe() {
          window.close();
      }
      setTimeout(closeMe, 10000);
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
      <h3 class="text-center">Obat Kronis</h3>
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
                  <th class="text-center">No</th>
                  <th>Nama Obat</th>
                  {{-- <th class="text-center">Harga</th> --}}
                  <th class="text-center">Qty</th>
                  {{-- <th class="text-center">Total</th> --}}
              </tr>
          </thead>
          <tbody>
              @foreach ($detail as $key => $d)
                  <tr>
                      <td class="text-center">{{ $no++ }}</td>
                      <td>{{ !empty($d->masterobat_id) ? baca_obat($d->masterobat_id) :'' }}</td>
                      {{-- <td class="text-right">{{ ($d->hargajual_kronis > 0) ? number_format( $d->hargajual_kronis / $d->jml_kronis ) : NULL}}</td> --}}
                      <td class="text-center">{{ $d->jml_kronis }}</td>
                      {{-- <td class="text-right">{{ number_format( $d->hargajual_kronis ) }}</td> --}}
                  </tr>
              @endforeach
          </tbody>
          {{-- <tfoot>
              <tr>
                <td colspan="2"><i>Terbilang: {{ terbilang($total) }} rupiah</i></td>
                <th style="text-align: right" colspan="2">Sub Total</th>
                <th style="text-align: right">{{ number_format($total) }}</th>
              </tr>
              <tr>
                <th style="text-align: right" colspan="4">Total Tagihan</th>
                <th style="text-align: right">{{ number_format($total) }}</th>
              </tr>
          </tfoot> --}}
      </table>

      {{-- <p><i><b>Terbilang: {{ terbilang($total) }} Rupiah</b></i></p> --}}

      <div class="pull-right">
          <div class="col-md-4">
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
