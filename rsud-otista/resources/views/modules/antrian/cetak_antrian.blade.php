<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Antrian</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">

  </head>
  <body onload="print()" style="margin:0;">

          <table class="table  table-condensed">
            <tr>
              <td class="text-center" colspan="2">
                <h5>Antrian Pendaftaran Rawat Jalan</h5>
                <h4 style="font-size:13pt; font-weight:bold; margin-top: -5px;">{{ configrs()->nama }}</h4>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                  <b>
                    ANTRIAN RAWAT JALAN
                  </b>
                <br>
                <p>Nomor Antrian Anda:</p>
                <p style="font-size: 65pt; margin-top: -30px; margin-bottom: -20px">
                  {{ $kelompok }}{{ $nomor }}<br/>
                </p>
                @if (@$antrian_polis)
                <p style="font-size: 14pt;">
                  Antrian Poli : <b>{{@$antrian_polis->kelompok}}{{@$antrian_polis->nomor}}</b>
                </p>
                @endif
                {{@baca_poli(@$poli_id)}}
                <p>

                  {{ date('d-m-Y H:i:s' ) }}
                  <br>
                  {{-- Tujuan: {{ baca_poli($poli_id) }} --}}
                </p>

              </td>
            </tr>
          </table>
          <br>

          <META HTTP-EQUIV="REFRESH" CONTENT="2; URL=http://172.168.1.175:8000">

  </body>
</html>
