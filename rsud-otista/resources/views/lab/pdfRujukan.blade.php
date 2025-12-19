<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Rujukan</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
   <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 3cm;
          margin-right: 3cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }
   

    </style>
  </head>
  <body>
    <table border=0 style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td>
      </tr>
    </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
        {{-- <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;">SURAT BUKTI PELAYANAN KESEHATAN (SBPK)</h3><br/>
              </td>
            </tr>
          </table> --}}

        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:100px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Soreang, {!! date('d M Y ') !!}</td>
            </tr>  
            <tr>
                <td colspan="4" scope="row" style="width:100px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Kepada<br><br></td>
            </tr>      
        </table>
        <table border=0 style="width:100%">
            <tr>
                <td style="width:40px"> Hal :</td>
                <td style="width:335px">Pengiriman Pemeriksaan Laboratorium</td>
                <td colspan="2" scope="row" style="text-align:left;width:100px"></td>
                <td style="text-align:left;width:100px;"></td>
                <td style="text-align:left;">Yth,</td>
            </tr>  
            <tr>
                <td style="width:40px"></td>
                <td style="width:335px"><u>{{ $registrasi->pasien->nama }}</u></td>
                <td colspan="2" scope="row" style="text-align:left;width:100px"></td>
                <td style="text-align:left;width:100px;"></td>
                <td style="text-align:left;">Teman Sejawat</td>
            </tr> 
            <tr>
                <td style="width:40px"></td>
                <td style="width:335px"></td>
                <td colspan="2" scope="row" style="text-align:left;width:100px"></td>
                <td style="text-align:left;width:100px;"></td>
                <td style="text-align:left;">Dokter Patologi Klinik</td>
            </tr> 
            <tr>
                <td style="width:40px"></td>
                <td style="width:335px"></td>
                <td colspan="2" scope="row" style="text-align:left;width:100px"></td>
                <td style="text-align:left;width:100px;"></td>
                <td style="text-align:left;">Di <u>Tempat<br><br><br></u></td>
            </tr>     
        </table>

        <table border=0 style="width:100%">
            <tr>
                <td style="width:40px">Dengan Hormat</td>
                <td style="width:335px"></td>
                <td colspan="2" scope="row" style="text-align:left;width:100px"></td>
                <td style="text-align:left;width:100px;"></td>
                <td style="text-align:left;"></td>
            </tr> 
            <tr>
                <td style="width:335px">Mohon pemeriksaan laboratorium : <br><br></td>
                <td style="width:335px"></td>
                <td colspan="2" scope="row" style="text-align:left;width:100px"></td>
                <td style="text-align:left;width:100px;"></td>
                <td style="text-align:left;"></td>
            </tr> 
        </table>
 
        <table border=0 class="table table-borderless">
          <tr>
            <td>Nama</td> <td style="padding-left:28px">: {{ $registrasi->pasien->nama }}</td>
            <td></td><td></td>
            <td></td><td></td>
           
          </tr>
          
          <tr>
            <td >Nomor Rekam Medis</td> <td style="padding-left:28px">: {{ $registrasi->pasien->no_rm }}</td>
            <td></td><td></td>
            <td></td><td></td>
            
          </tr>
          <tr>
            <td>Tanggal Lahir</td> <td style="padding-left:28px">: {{ tgl_indo($registrasi->pasien->tgllahir) }}</td>
            <td></td><td></td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>Alamat</td> <td style="padding-left:28px">: {{ $registrasi->pasien->alamat }}</td>
            <td></td><td></td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>Diagnosa</td> <td style="padding-left:28px">: .......</td>
            <td></td><td></td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>Tanggal pengambilan sampel</td> <td style="padding-left:28px">: .......</td>
            <td></td><td></td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>Tanggal pengiriman sampel</td> <td style="padding-left:28px">: .......</td>
            <td></td><td></td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>Parameter pemeriksaan</td> <td style="padding-left:28px">: .......</td>
            <td></td><td></td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>Dokter yang meminta</td> <td style="padding-left:28px">: .......</td>
            <td></td><td></td>
            <td></td><td></td>
          </tr>
          {{-- <tr>
            <td>4. Jenis Kelamin</td> <td style="padding-left:28px">:  @if ($pasien->kelamin == 'L')
                Laki - Laki
              @elseif ($pasien->kelamin == 'P')
                Perempuan
              @endif</td>
            <td></td><td></td>
            <td></td><td></td>
            <td><input type="checkbox"></td> <td style="padding-left:28px">Post Operasi</td>
          </tr> --}}
          
          {{--<tr>
            <td>Jenis Kelamin</td> 
            <td>: 
              @if ($pasien->kelamin == 'L')
                Laki - Laki
              @elseif ($pasien->kelamin == 'P')
                Perempuan
              @endif
            </td>
          </tr>--}}
        </table><br><br><br><br><br><br>

        <table border=0 style="width:100%">
            <tr>
                <td style="width:435px">Hasil dikirim ke e-mail laboratorium.rsudmeranti@gmail.com</td>
                <td style="width:335px"></td>
               
            </tr> 
            <tr>
                <td style="width:435px">Atas perhatian dan kerjasama kami ucapkan terima kasih</td>
                <td style="width:335px"></td>
             
            </tr> 
        </table>
       
        {{--<div class='footer'>
			<div>Selatpanjang, ...................</div>
			<div style='margin-top:30px; margin-right:5px;'>(.............................)</div>
			<div style='margin-top:10px; margin-left:30px;'> {!! Auth::user()->fullname !!}</div>
		</div>--}}
       
    <br><br><br>
        

        <style>

            .footer{
            padding-top: 20px;
            margin-left: 330px;
        }

        .table-border {
        border: 1px solid black;
        border-collapse: collapse;
        }

        </style>
       
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
</html>

