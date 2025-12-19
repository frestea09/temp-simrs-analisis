<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak SBPK</title>
    <!-- Bootstrap 3.3.7 -->
    {{--<link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">--}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
    <style type="text/css">
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
  <body onload="print()">
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
        <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;">SURAT BUKTI PELAYANAN KESEHATAN (SBPK)</h3>
              </td>
            </tr>
          </table>
 
          <table border=0 class="table table-borderless" style="text-align:start;" >
            <tr>
              <td>1. Nama Rs/Type/Kode RS</td> <td style="padding-left:28px">: {{ strtoupper(configrs()->nama) }} / B /</td>
              <td></td><td></td>
              <td></td><td></td>
            </tr>

            <tr>
              <td>2. Nama/RM/Kls/Pelayanan</td> <td style="padding-left:28px">: {{ @$reg->pasien->nama }} / {{ @$reg->pasien->no_rm }} </td>
              <td></td><td></td>
              <td></td><td></td>
            </tr>

            <tr>
              <td>3. Berat Bayi Lahir</td> <td style="padding-left:28px">: __________</td>
              <td></td><td></td>
            </tr>
            
            <tr>
              <td>4. Tanggal Masuk</td> <td style="padding-left:28px">: {{ date('Y-m-d',strtotime($reg->created_at)) }}</td>
              <td>Dokter Pemeriksa</td><td style="padding-left:28px"></td>
              <td></td><td></td>
            </tr>
            <tr>
              <td>5. Tanggal Keluar</td>
              <td style="padding-left:28px">: __________</td>
            </tr>
            <tr>
              <td>6. Jumal Biaya</td>
              <td style="padding-left:28px">: __________</td>
            </tr>
            <tr>
              <td>7. Jumlah Hari Dirawat</td> <td style="padding-left:28px">: __________     KODE INA-CGG-S: __________</td>
              <td></td><td></td>
              <td></td><td></td>
            </tr>
            <tr>
              <td>8. Cara Pulang</td>
              <td style="padding-left:28px">: 1.Sembuh | 2.Rujuk | 3.Permintaan Sendiri | 4.Meninggal</td>
            </tr>
            <tr>
              <td>9. No. Kartu / SEP</td>
              <td style="padding-left:28px">: {{ $reg->no_sep }}</td>
            </tr>
            <tr>
              <td>10. Diagnosa Utama</td>
              <td style="padding-left:28px">: _______________________________</td>
            </tr>
          </table>
        <table style="width:100%; text-align:start;" class="table">
          <tr>
            <td>11. Diagnosa Sekunder</td><td style="padding-left:28px">:</td>
            <td></td><td></td>
          </tr>
          <tr>
            <td>12. Jenis Pelayanan</td>
            <td style="padding-left:28px">: 1. Lab | 2. Radiologi | 3. USG</td>
            <td></td>
          </tr>
          <tr>
              <table  style="width:70%; text-align:start; margin-left:30px;" class="table">
                  <tr>
                      <td>No</td>
                      <td class="text-center">Kode</td>
                      <td class="text-center">Diagnosa Sekunder</td>
                  </tr>
                  <tr>
                      <td>1</td>
                      <td>__________</td>
                      <td>_______________________________________________________________________________________</td>
                  </tr>
                  <tr>
                      <td>2</td>
                      <td>__________</td>
                      <td>_______________________________________________________________________________________</td>
                  </tr>
                  <tr>
                      <td>3</td>
                      <td>__________</td>
                      <td>_______________________________________________________________________________________</td>
                  </tr>
              </table>
            </tr>
    </table>
    <tr>
      <td>
      <table style="width:100%; text-align:start;" class="table">
          <tr>
            <td>13. Kode</td><td style="padding-left:28px">:</td>
            <td></td><td></td>
          </tr>
          <tr>
              <table  style="width:70%; text-align:start; margin-left:30px;" class="table">
                  <tr>
                      <td>No</td>
                      <td class="text-center">Kode</td>
                      <td class="text-center">Prosedur</td>
                  </tr>
                  <tr>
                      <td>1</td>
                      <td>__________</td>
                      <td>_______________________________________________________________________________________</td>
                  </tr>
                  <tr>
                      <td>2</td>
                      <td>__________</td>
                      <td>_______________________________________________________________________________________</td>
                  </tr>
                  <tr>
                      <td>3</td>
                      <td>__________</td>
                      <td>_______________________________________________________________________________________</td>
                  </tr>
              </table>
            </tr>
      </td>
    </tr>
    








  </table>
          
    <br>
        

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

