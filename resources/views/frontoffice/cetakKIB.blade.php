<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Barcode</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}

  </head>
  <body onload="print()" style="margin:0;">
  {{-- <body> --}}
    @for ($j=0; $j < 1; $j++)
      <div class="row">
          @for ($i=0; $i < 1; $i++)
            <div class="col-md-2" style="width: 5cm;" >
              <div class="text-center" style="font-weight:bold; border-bottom: 1px solid grey; font-size: 8pt">
                No. RM: {{ $pasien->no_rm }}
              </div>
              <p style="line-height: 75%">
                <span style="font-size: 8pt">
                <b style="font-weight: bold;">{{ $pasien->nama }}</b>  <br>
                <b>tgl lhr:{{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'Y') }}</b> <br>
                {{ $pasien->alamat }}
                </span>
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, 'C39',2,28) }}" class="img img-responsive" alt="barcode" />
              </p>
            </div>
          @endfor
      </div>
      <br>
    @endfor






  </body>
</html>
