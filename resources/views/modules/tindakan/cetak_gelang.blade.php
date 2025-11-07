<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Gelang Pasien</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
   <style media="print">
    /* @page {
          width: 8cm;
          margin-left: 15cm;
          margin-top: 5cm;
          height: 2.5;
          font-size: 8pt;
      }
      .box{
        width: 7.5cm;
        height: 2 cm;
        margin: 0.2cm;
        margin-bottom: 0.3cm;
      } */
    </style>
    

  </head>
        
        <body onload="print()">
          
           {{-- <div class="box">
            <img src="{{ asset('/images/'.configrs()->logo) }}"style="width: 50px;height:50px">
            <div style="font-weight:bold;"> {{ strtoupper($pasien->nama) }} </div>
            <div style="font-family: san serif; font-size: 9pt;">
              Tgl lahir: {{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'Y') }} <br>
            </div>
            
            <b>{{ $pasien->no_rm }}</b> <br>
            <div style="font-family: san serif; font-size: 9pt;">
              {{@$pasien->nik }}  <br>
            </div>
          </div> --}}
          <table> 
            <tr>
              <td>
                <img src="{{ asset('/images/'.configrs()->logo) }}"style="width: 50px;height:50px">
              </td>
              
          
              <td style="text-align: left">
                <div class="box">
                  <div style="font-weight:bold;"> {{ strtoupper($pasien->nama) }} </div>
                  <div style="font-family: san serif; font-size: 9pt;">
                    <b>RM: {{ $pasien->no_rm }} / {{ $pasien->kelamin }} / JKN </b><br>
                  </div>
                  <div style="font-family: san serif; font-size: 9pt;">
                    <b>NIK: {{ $pasien->nik }} </b> <br>
                  </div>
                  <div style="font-family: san serif; font-size: 9pt;">
                    <b> Tgl lahir: {{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'Y') }} </b> <br>
                  </div>
              </td>
            </tr>
          </table>
          <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak-igd') }}">
        </body>



  
</html>