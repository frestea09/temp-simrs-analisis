<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 9pt;
        margin-left: 2.5cm;
        margin-right: 2.5cm;
      }
    </style>
  </head>
  <body>

    <table style="width:100%; margin-bottom: -10px;">
      <tbody>
        <tr>
          <th style="width:20%">
            <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:150px;">
          </th>
          <th class="text-left">
            <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
            <p>{{ configrs()->alamat }} {{ configrs()->tlp }} </p>

          </th>
        </tr>

      </tbody>
    </table> <br>
    <hr> <br>

    <table>
      <tr>
        <td colspan="2">
          <h5><b> SHARING BIAYA PERAWATAN BPJS NAIK KELAS </b> </h5>
        </td>
        <td></td>
      </tr>
      <tr>
        <td style="width:35%">Nama </td> 
        <td>: {{ strtoupper($reg->pasien->nama) }}</td>
      </tr>
      <tr>
        <td>No Rekam Medis</td> 
        <td>: {{ $reg->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td>Alamat</td> 
        <td>: {{ strtoupper($reg->pasien->alamat) }} {{ strtoupper($reg->pasien->regency_id) }}</td>
      </tr>
      <tr>
        <td>Tanggal Masuk </td>
        <td>: {{ $irna->tgl_masuk }}</td>
      </tr>
      <tr>
          <td>Tanggal Keluar </td>
          <td>: {{ $irna->tgl_keluar }}</td>
        </tr>
      <tr>
          <td>Ruangan</td><td>:
          @if (substr($kuitansi->no_kwitansi,0,1) == 'I')
            {{ baca_kamar(App\Rawatinap::where('registrasi_id', $kuitansi->registrasi_id)->first()->kamar_id) }}
          @elseif(substr($kuitansi->no_kwitansi,0,1) == 'R')
            {{ strtoupper( baca_poli($reg->poli_id)) }}
          @endif
      </tr>
      {{--  <tr>
        <td>Lama Rawat</td>
        <td>: </td>
      </tr>  --}}
      <tr>
        <td colspan="2">
          =========================================================
        </td>
      </tr>
      </table>

      <table style="width: 33%;">
      <tr>
        <td colspan="4"><b>TARIF PENJAMINAN INA-CBG KELAS</b></td>
      </tr>

      <tr>
        @php
          $gruper = !empty($inacbg) ? $inacbg->dijamin : 0 ;
        @endphp
        <td> Hak kelas {{ !empty($inacbg) ? $inacbg->kelas_perawatan : NULL }} </td>
        <td colspan="3"> Rp. {{ !empty($inacbg) ? number_format($inacbg->dijamin) : 0 }} - Hak naik kelas Rp. {{ number_format($kuitansi->iur) }}</td>
      </tr>
      <tr>
        <td class="text-right"> = </td>
        <td> Rp. {{ number_format($gruper - $kuitansi->iur) }}</td>
      </tr>
      <tr>
        <td colspan="4">
          =========================================================
        </td>
      </tr>
    </table>
    <br>
    <table>
        <tr>
        <th class="text-center">
            Pesan / Catatan,
            <br>
            Dibuat Oleh,
            <br><br><br><br>
            <i><u>___________________</u></i>
            <br>
            Tgl. {{ date('d/m/Y') }}
        </th>
        <th colspan="2">&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
        <th class="text-center">
            Penerima Faktur :
            <br><br><br><br><br>
            <i><u>___________________</u></i>
            <br>
            Tgl. {{ date('d/m/Y') }}
        </th>
        
        </tr>
    </table>

      {{--  <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/lain-lain') }}">  --}}
  </body>
</html>
