<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Antrian</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('antrian') }}">

  </head>
  {{-- <body onload="print()"> --}}
  <body onload="print()" style="margin:0;">

          <table class="table table-bordered">
            <tr>
              <td class="text-center" colspan="2">
                {{-- <img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive" style="width: 1.5cm; float:left;"> --}}
                <h6>Antrian Pendaftaran Rawat Jalan</h6>
                <h4 style="font-size:13pt; font-weight:bold;">{{ configrs()->nama }}</h4>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                <br>
                <p>Nomor Antrian Anda:</p>
                <p style="font-size: 75pt; margin-top: -30px; margin-bottom: -20px">{{ $nomor }}</p>
                <p>Sisa Antrian: {{ $sisa }}</p>
              </td>
            </tr>
          </table>
          <br>


  {{-- <script language="javascript">
      window.location.href="{{ url('/antrian') }}";
  </script> --}}
  </body>
</html>
