<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Barcode 2</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="print">
    @page {
          width: 10cm;
          margin-left: 0cm;
          margin-top: 0.1cm;
          height: 2.5;
          font-size: 8pt;
      }
      .box{
        width: 8cm;
        height: 2 cm;
        margin: 0.2cm;
        margin-bottom: 0.3cm;
      }
    </style>
  </head>
  <body onload="print()">
      {{-- <div class="box">
        <div style="font-weight:bold;"> {{ strtoupper($pasien->nama) }} </div>
        <b>{{ no_rm($pasien->no_rm) }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ {{ ($pasien->kelamin == 'L') ? 'Lk' : 'Pr' }}</b> <br>
        <div style="font-family: san serif; font-size: 9pt;">
          Tgl lhr: {{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'Y') }} <br>
          {{ strtoupper($pasien->alamat) }}  <br>
        </div>
        <div class="text-left">
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,18,array(1,1,1), true) }}" alt="">
        </div>
      </div> --}}
      {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,18,array(1,1,1), true) }}" alt=""> --}}

      <table style="padding-left: 30px">
        <tbody>
          <tr>
            <td>
              <img src="data:image/png;base64,{{DNS2D::getBarcodePNG($pasien->no_rm, 'QRCODE', 4,4)}}" class="d-inline block" alt="barcode" />
            </td>
            <td>
              <div class="box" style="font-size:15px !important">
                  <div> {{ strtoupper($pasien->nama) }}</div>
                  {{-- <div> <b>{{ $pasien->no_rm }}</b> ({{ $pasien->kelamin }}) {{ baca_carabayar(@$reg_id->bayar) }}{{ baca_carabayar(@$registrasi->bayar) }} {{@$registrasi->tipe_jkn? @$registrasi->tipe_jkn : ''}}</div> --}}
                  <div> <b>{{ $pasien->no_rm }}</b> ({{ $pasien->kelamin }}) {{ baca_carabayar(@$reg_id->bayar) }}{{ baca_carabayar(@$registrasi->bayar) }}</div>
                  <div>{{ hitung_umur($pasien->tgllahir) }} ({{ tgl_indo($pasien->tgllahir) }})</div>
                  <div>{{ baca_poli($reg_id->poli_id) }}</div>
                  <div>{{ $reg_id->created_at }}</div>
              </div>   
            </td>
          </tr>
        </tbody>
      </table>











    
      {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak-irj') }}"> --}}
    <script>
      window.onload = function () {
        window.print();
        setTimeout(function () {
          window.history.back();
        }, 2000);
      };
    </script>
  </body>
</html>
