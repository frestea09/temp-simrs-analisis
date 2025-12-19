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
                <h5>Antrian Eresep</h5>
                <h4 style="font-size:13pt; font-weight:bold; margin-top: -5px;">{{ configrs()->nama }}</h4>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                  <b>
                    ANTRIAN ERESEP
                  </b>
                <br>
                <p>Nomor Antrian Anda:</p>
                    <p style="font-size: 65pt; margin-top: -30px; margin-bottom: -20px">
                        {{ @$nomor->kelompok.''.@$nomor->nomor }}<br/>
                    </p>
                <p>

                  {{ date('d-m-Y H:i:s' ) }}
                  <br>
                </p>

              </td>
            </tr>
          </table>
          <br>
  </body>
</html>
