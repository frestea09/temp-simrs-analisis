<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Barcode</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="print">
    @page {
          width: 10cm;
          margin-left: 0cm;
          margin-top: 0.1cm;
          height: 2.5;
          font-size: 8pt;
      }
      .box{
        width: 8cm;
        height: 2 cm;
        margin: 0.2cm;
        margin-bottom: 0.3cm;
      }
    </style>
  </head>
  <body onload="print()">
      {{-- <div class="box">
        <div style="font-weight:bold;"> {{ strtoupper($pasien->nama) }} </div>
        <b>{{ no_rm($pasien->no_rm) }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ {{ ($pasien->kelamin == 'L') ? 'Lk' : 'Pr' }}</b> <br>
        <div style="font-family: san serif; font-size: 9pt;">
          Tgl lhr: {{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'Y') }} <br>
          {{ strtoupper($pasien->alamat) }}  <br>
        </div>
        <div class="text-left">
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,18,array(1,1,1), true) }}" alt="">
        </div>
      </div> --}}
      {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,18,array(1,1,1), true) }}" alt=""> --}}
    
      {{-- {!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE', 5, 10) !!} --}}

     

      
       
     
      {{-- <div class="row">

        <div class="d-inline block">
          <img src="data:image/png;base64,{{DNS2D::getBarcodePNG($pasien->no_rm, 'QRCODE')}}" class="d-inline block" alt="barcode" />
        </div>

        <div class="box" style="font-size:12px !important">
         
          <div>No RM     : {{ $pasien->no_rm }} </div>
          <div>Nama      : {{ strtoupper($pasien->nama) }} </div>
          <div>Tgl.Lahir : {{ tgl_indo($pasien->tgllahir) }}{{ tgl_indo($pasien->tgllahir) }} </div>
          <div>Jenis Kelamin : {{ ($pasien->kelamin == 'L') ? 'Lk' : 'Pr' }} </div>
          <div>Alamat    : {{ substr($pasien->alamat,0,20) . '..' }} </div>
          <div>Registrasi: {{ $pasien->created_at }} </div>
        </div>
      </div> --}}

      <table style="padding-left: 30px">
        <tbody>
          <tr>
            <td>
              <img src="data:image/png;base64,{{DNS2D::getBarcodePNG($pasien->no_rm, 'QRCODE', 4,4)}}" class="d-inline block" alt="barcode" />
            </td>
            <td>
              {{-- <div>No RM     : {{ $pasien->no_rm }} </div>
              <div>Nama      : {{ strtoupper($pasien->nama) }} </div>
              <div>Tgl.Lahir : {{ tgl_indo($pasien->tgllahir) }} </div>
              <div>Jenis Kelamin : {{ ($pasien->kelamin == 'L') ? 'Lk' : 'Pr' }} </div>
              <div>Alamat    : {{ substr($pasien->alamat,0,20) . '..' }} </div>
              <div>Registrasi: {{ $pasien->created_at }} </div> --}}
              <div class="box" style="font-size:12px !important">
                  <div> {{ strtoupper($pasien->nama) }}
                    {{'- ' . baca_poli($reg_id->poli_id)}}
                  </div>
                  <div> <b>{{ $pasien->no_rm }}</b> ({{ $pasien->kelamin }}) 

                    @if ($pasien->jkn == null)
                        {{ "Umum" }}
                    @else
                        {{ "PBI" }}
                    @endif

                  </div>
                  <div>
                    @if (@$ruangan != null)
                          ({{ baca_kamar(@$ruangan->kamar_id) }}) 
                    @endif
                    </div>
                  <div>{{ hitung_umur($pasien->tgllahir) }} ({{ tgl_indo($pasien->tgllahir) }})</div>
                  <div>{{ @$registrasi->created_at }}</div>
                  <div> {{ strtoupper($pasien->alamat) }}</div>
                  <div> {{ baca_kecamatan($pasien->district_id) }} </div>
                  <div> {{ baca_kabupaten($pasien->regency_id) }} ({{ $pasien->nohp }})</div>
              </div>   
            </td>
          </tr>
        </tbody>
      </table>











    
      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak-irj') }}">
  </body>
</html>
