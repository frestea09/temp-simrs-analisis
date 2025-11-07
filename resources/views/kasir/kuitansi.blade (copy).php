<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Rawat Jalan</title>

    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0;
          margin-left: 0.6cm;
          width: 19cm;
          height: 20cm;
      }
    </style>

    {{--
    @if (substr($kuitansi->no_kwitansi,0,2) == 'RD')
      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/igd') }}">
    @else
      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/rawatjalan') }}">
    @endif --}}

  </head>

  <body onload="window.print()">
    <table>
      <tr>
        <td><img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:150px;"></td>
        <td>
          <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} {{ configrs()->tlp }} </p>
        </td>
      </tr>
    </table>
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="">
          <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:150px;">
                </th>
                <th class="text-left">
                  <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
                  <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} {{ configrs()->tlp }} </p>

                </th>
              </tr>

            </tbody>
          </table>

          <table style="width:100%">
            <tbody>
              <tr>
                <td colspan="2">==========================================================================================================================================</td>
              </tr>
              <tr>
                <th colspan="2" class="text-center"><h5><b>FAKTUR PEMBAYARAN <br>No. KRJ: {{ $kuitansi->no_kwitansi }}</h5> </b></th>
              </tr>
              <tr>
                <td style="width:20%">Nama / Jenis Kelamin</td> <td>: {{ $kuitansi->pasien->nama }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/  &nbsp;&nbsp;&nbsp; {{ $kuitansi->pasien->kelamin }}</td>
              </tr>
              <tr>
                <td>Umur </td> <td>: {{ hitung_umur($kuitansi->pasien->tgllahir) }}</td>
              </tr>
              <tr>
                <td style="width:20%">Nomor Rekam Medis</td> <td>: {{ $kuitansi->pasien->no_rm }}</td>
              </tr>
              <tr>
                <td style="width:20%">Alamat</td> <td>: {{ $kuitansi->pasien->alamat }} {{ ucwords(strtolower(baca_kabupaten($kuitansi->pasien->regency_id))) }}</td>
              </tr>

            </tbody>
          </table>
          <h5><b><i>Rincian Pembayaran</i></b></h5>
          <table style="width:100%" class="table-condensed">
            <tbody>
              @foreach ($folio as $key => $d)
                <tr>
                  <td style="width: 20%">{{ $d->namatarif }}</td> <td>: Rp. {{ number_format($d->total) }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>JUMLAH</th>
                <th>: Rp. {{ number_format($jml) }}</th>
              </tr>
              <tr>
                <th colspan="2"><i>Terbilang: "{{ terbilang($jml) }} Rupiah"</i></th>
              </tr>
            </tfoot>
          </table>
          <br>
          <table style="width:100%">
            <tbody>
              <tr>
                <th style="width: 40%;"></th>
                <th class="text-center">Keluarga Pasien,<br><br><br><br><i><u>___________________________</u></i></th>
                <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('Y-m-d')) }}<br><br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </body>
</html>
