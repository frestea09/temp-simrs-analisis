<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Barcode</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    {{-- <link href="{{ asset('css/pdf.css') }}" rel="stylesheet"> --}}
    <style media="screen">
    @page {
          margin-top: 0;
          margin-left: 0.3cm;
      }
    </style>

  </head>
  <body>

    <table style="width: 30%">
      <tbody>
        @role('admission')
          <tr>
            <td>
              <p style="font-size: 8pt; line-height: 100%" class="text-left">
              No. RM: {{ $pasien->no_rm }} <br>
              Nama: {{ $pasien->nama }}<br>
              Tgl Lahir:{{ tgl_indo($pasien->tgllahir) }}<br>
              Alamat; {{ $pasien->alamat }} <br>
              {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, 'C39',1.4,20, array(0,0,0)) }}" class="img img-responsive" style="margin-top:3px;" alt="barcode" /> --}}
              <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,24,array(1,1,1), true) }}" alt="">
            </td>
          </tr>
        @endrole
        @role(['rekammedis', 'supervisor', 'administrator'])
          @for($i=0; $i<=3;$i++)
            <tr>
              <td>
                <br>
                <p style="font-size: 10pt; line-height: 100%" class="text-left">
                {{ $pasien->no_rm }} <br>
                <b>{{ $pasien->nama }}</b><br>
                {{ tgl_indo($pasien->tgllahir) }}<br>
                {{ $pasien->alamat }} <br>
              
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1.6,24,array(1,1,1), true) }}" alt="">
              </td>
            </tr>
          @endfor
        @endrole
      </tbody>
    </table>

  </body>
</html>
