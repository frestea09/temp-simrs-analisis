<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Antrian Rawat Inap</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">

  </head>
  <body onload="print()" style="margin:0;">

          <table class="table  table-condensed">
            <tr>
              <td class="text-center" colspan="2">
                <h5></h5><br>
                <h4 style="font-size:13pt; font-weight:bold; margin-top: -5px;">{{ configrs()->nama }}</h4>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                  <b>
                    ANTRIAN RAWAT INAP
                  </b>
                <br>
                <p>Nomor Antrian Anda:</p>
                <p style="font-size: 70pt; margin-top: -30px; margin-bottom: -20px">
                  {{ $kelompok }}{{ $nomor }}
                </p>
                <p>

                  {{ date('d-m-Y H:i:s' ) }}
                  <br>
                  {{-- Tujuan: {{ baca_poli($poli_id) }} --}}
                </p>

              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                  <b>
                    ANTRIAN RAWAT INAP
                  </b>
                <br>
                <p>Nomor Antrian Anda:</p>
                <p style="font-size: 70pt; margin-top: -30px; margin-bottom: -20px">
                  {{ $kelompok }}{{ $nomor }}
                </p>
                <p>

                  {{ date('d-m-Y H:i:s' ) }}
                  <br>
                  {{-- Tujuan: {{ baca_poli($poli_id) }} --}}
                </p>

              </td>
            </tr>
          </table>
          <br>

          {{-- <META HTTP-EQUIV="REFRESH" CONTENT="2; URL=http://172.168.1.172:8000"> --}}
          {{-- @if( $print == 1 )
            <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ url('antrian-farmasi/print') }}">
          @else --}}
            {{-- <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ url('antrian-farmasi/touch') }}"> --}}
            <META HTTP-EQUIV="REFRESH" CONTENT="2; URL=http://172.168.1.175/antrian-rawatinap/touch">
          {{-- @endif --}}
  </body>
</html>
