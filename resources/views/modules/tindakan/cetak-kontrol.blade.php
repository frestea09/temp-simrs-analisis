<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Kontrol</title>
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
            @if (@$rencana_kontrol)
            <tr>
              <td colspan="2">
                <table style="width: 100%;">
                  <tr>
                    <td style="text-align: end; width: 50%; padding-right: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">No. Rencana Kontrol :</span>
                    </td>
                    <td style="text-align: start; width: 50%; padding-left: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">{{ @$rencana_kontrol->no_surat_kontrol }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: end; width: 50%; padding-right: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">Tgl Rencana Kontrol :</span>
                    </td>
                    <td style="text-align: start; width: 50%; padding-left: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">{{ @$rencana_kontrol->tgl_rencana_kontrol ? date('d-m-Y', strtotime(@$rencana_kontrol->tgl_rencana_kontrol)) : '' }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: end; width: 50%; padding-right: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">Nama / No. RM :</span>
                    </td>
                    <td style="text-align: start; width: 50%; padding-left: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">{{ @$reg->pasien->nama }} / {{ @$reg->pasien->no_rm }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: end; width: 50%; padding-right: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">Poli Tujuan :</span>
                    </td>
                    <td style="text-align: start; width: 50%; padding-left: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">{{ @baca_poli(@$rencana_kontrol->poli_id) }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: end; width: 50%; padding-right: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">Diagnosa :</span>
                    </td>
                    <td style="text-align: start; width: 50%; padding-left: 2rem;">
                      <span style="font-weight: bold; font-size: 18pt;">{{ @$rencana_kontrol->diagnosa_awal }}</span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            @else
            <tr>
                <td colspan="2">
                    <h5 style="text-align: center">Tidak ada rencana kontrol</h5>
                </td>
            </tr>
            @endif
          </table>
          <br>

          {{-- <META HTTP-EQUIV="REFRESH" CONTENT="2; URL=http://172.168.1.172:8000"> --}}
          {{-- @if( $print == 1 )
            <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ url('antrian-farmasi/print') }}">
          @else --}}
            {{-- <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ url('antrian-farmasi/touch') }}"> --}}
            {{-- <META HTTP-EQUIV="REFRESH" CONTENT="2; URL=http://172.168.1.175/farmasi/eresep-cetak"> --}}
          {{-- @endif --}}
  </body>
</html>
