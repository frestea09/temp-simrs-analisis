<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Transaksi Keluar</title>

    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0.5cm;
          margin-left: 1cm;
          width: 9.5cm;
          height: 20cm;
      }
    </style>


  </head>

  <body onload="window.print()">
    <table>
      <tr>
        <td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          ===========================================
        </td>
      </tr>
        </table>

      <table>
      <tr>
        <td style="width:25%">Nama </td> <td>:  {{ $diklat->nama }}</td>
      </tr>

    <br>
    <table>
        <tr>
          <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('Y-m-d')) }}<br><br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>
        </tr>
    </table>

  </body>
</html>
