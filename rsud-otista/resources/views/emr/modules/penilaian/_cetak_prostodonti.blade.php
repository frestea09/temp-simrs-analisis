<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Prostodonti</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
    <style media="screen">

      .border {
        border: 1px solid black;
        border-collapse: collapse !important;
      }

      .bold {
          font-weight: bold;
      }

      .p-1 {
          padding: .2rem;
      }

      .text-center {
        text-align: center;
      }

      @media print {
        body {-webkit-print-color-adjust: exact !important;}
      }
    </style>
  </head>
  <body onload="window.print()">
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
        <table style="width: 100%; border: 0px solid;">
          <tr>
            <td style="width: 15%;">Nomor RM</td>
            <td style="width: 30%;">: {{ @$pasien->no_rm }}</td>
            <td style="width: 15%;">Tanggal Lahir</td>
            <td style="width: 30%;">: {{ @$pasien->tgllahir }}</td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>: {{ @$pasien->nama }}</td>
            <td>Umur</td>
            <td>: {{ hitung_umur(@$pasien->tgllahir) }}</td>
          </tr>
          <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ @$pasien->kelamin == 'L' ? 'Laki-Laki' : (@$pasien->kelamin == 'P' ? 'Perempuan' : '-') }}</td>
            <td>Alamat</td>
            <td>: {{ @$pasien->alamat }}</td>
          </tr>
        </table>
        <table style="width: 100%; border: 0px solid;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;">
                    FORMULIR LABORATORIUM DENTAL
                </h3>
              </td>
            </tr>
        </table><br><br><br><br>
        @if (@$gambar->image != null)
            <img src="{{ public_path('images/' . @$gambar['image']) }}" id="dataImage" style="width: 400px; height:400px;">
        @endif
        <table style="width: 100%; border: 0px solid;"> 
          <tr>
            <td style="">
              <b>Keterangan</b>
            </td>
          </tr>
          <tr>
            <td><b>RA :</b> {{ @$ketGambar['keterangan'][0][1] ? @$ketGambar['keterangan'][0][1] : '-' }}</td>
          </tr><br>
          <tr>
            <td><b>RB :</b> {{ @$ketGambar['keterangan'][1][2] ? @$ketGambar['keterangan'][1][2] : '-' }}</td>
          </tr>
        </table>
        <table style="width: 100%; border: 0px solid;">
          <tr style="text-align: center;">
            <td>Dokter</td>
          </tr>
          <tr style="text-align: center;">
            <td>
              <br><br><br>
            </td>
          </tr>
          <tr style="text-align: center;">
            <td>
              {{ @$dokter->nama }} <br>
              SIP. {{ @$dokter->sip }}
            </td>
          </tr>
        </table>
        </div>
      </div>
  </body>
</html>

