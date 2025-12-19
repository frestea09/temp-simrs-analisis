<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak SUSPEK</title>
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
        <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <b style="font-size:17px;">FORMULIR KRETERIA/KATEGORI PASIEN SUSPEK</b><br/>
                <b style="font-size:17px;">RSUD OTO ISKANDAR DI NATA BANDUNG</b>
              </td>
            </tr>
          </table><br/><br/>
 
        <table border=0 class="table table-borderless">
          <tr>
            <td >NO.RM</td> <td style="padding-left:28px">: {{ @$pasien->no_rm }}</td>
          </tr>
          <tr>
            <td>NAMA PASIEN</td> <td style="padding-left:28px">: {{ @$pasien->nama }}</td>
          </tr>
          <tr>
            <td>TEMPAT / TANGGAL LAHIR</td> <td style="padding-left:28px">: {{ @$pasien->alamat }} / {{ @$pasien->tgllahir }}</td>
          </tr>
          
        </table>
        <table border=0 class="table table-borderless">
            <tr>
                <td></td> <td style="padding-left:28px"></td>
                <td ></td><td style="width:60px"></td>
                <td></td><td style="width:30px"></td>
                <td></td> <td style="padding-left:28px"></td>
              </tr>
        </table>

        <br><br>
                <table border=0.7 cellpadding="5" style="width:100%" class="table table-border">
                <tr>
                    <th style="width:8px;text-align:center;">NO</th>
                    <th style="width:200px;">Kreteria Suspek</th>
                    <th style="width:20px;">Ya</th>
                    <th style="width:10px;">Tidak</th>
                </tr>
                <tr>
                    <td colspan="1" style="width:8px;text-align:center;">1</td>
                    <td>Demam akut dan batuk</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td rowspan="12" style="width:8px;text-align:center;">2</td>
                    <td>Tiga(3) dari gejala berikut :</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>a. Demam</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>b. Batuk</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>c. Lemas</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>e. Sakit kepala</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>f. Nyeri otot</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>g. Nyeri tenggorokan</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>h. Pilek/hidung tersumbat</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>i. Sesak nafas</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>j. Anoreksia/mual/muntah</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>k. Diare</td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td>l. Penurunan kesadaran</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="1" style="width:8px;text-align:center;">3</td>
                    <td>Ada batuk, pilek, dan demam(>38C) dan batuk 10 hari terakhir</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="1" style="width:8px;text-align:center;">4</td>
                    <td>Anosmia (kehilangan penciuman) akut tanpa penyebab lain yang teridentifikasi</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="1" style="width:8px;text-align:center;">5</td>
                    <td>Ageusia (kehilangan pengecapan) akut tanpa penyebab lain yang teridentifikasi</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="1" style="width:8px;text-align:center;">6</td>
                    <td>Memiliki riwayat kontak dengan kasus probable/konfirmasi Covid-19/kluster Covid-19</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
     
    <br><br><br>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b>Mengetahui</td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Soreang, {{date('d F Y')}}<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">Petugas Rumah Sakit</td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Pasien</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
                <td colspan="4" scope="row" style="width:170px;"><br><br><br><br><br>(...............................................)</td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"><br><br><br><br><br>({{ @$pasien->nama }})</td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
                <td></td>
                <td></td>
                <td><div style='margin-top:10px; text-align:center;'></div></td>
            </tr>
    </table>

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

