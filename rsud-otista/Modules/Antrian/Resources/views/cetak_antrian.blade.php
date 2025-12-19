<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Antrian</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=http://172.168.1.175:8000">

  </head>
  <body onload="print()">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <br>
          <div class="panel panel-default">
            <div class="panel-body text-center">
              <p>Nomor Antrian Anda:</p>
              <h1>{{ $nomor }}</h1>
            </div>
          </div>
        </div>
      </div>
    </div>



  {{-- <script language="javascript">
      window.location.href="{{ url('/antrian') }}";
   </script> --}}
  </body>
</html>
