<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0;
          /* margin-left: 0.3cm; */
      }
    </style>

  </head>
  <body>
    <div>
      <br/>
      <h4 class="text-center">LAPORAN OPERASI</h4>
      {{-- <p>FAIQ</p> --}}
      <table style="width: 100%;font-size:11px;" border="1" cellspacing="0">
        {{-- row 1 --}}
        <tr>
          <td colspan="3" style="width:50%;">
            <table style="width:100%">
              <tr>
                <td style="width:100px;">NAMA</td>
                <td>: {{@$reg->pasien->nama}}</td>
              </tr>
              <tr>
                <td>TGLLAHIR/UMUR</td>
                <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
              </tr>
              <tr>
                <td>RUANG</td>
                <td>: {{@baca_poli($reg->poli_id)}}</td>
              </tr>
              <tr>
                <td>TANGGAL</td>
                <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td>
              </tr>
            </table>
          </td>
          <td colspan="3">
            <table style="width:100%">
              <tr>
                <td style="width:100px;">JENIS KELAMIN</td>
                <td>: {{@$reg->pasien->kelamin}}</td>
              </tr>
              <tr>
                <td>NO.RM</td>
                <td>: {{@$reg->pasien->no_rm}}</td>
              </tr>
              <tr>
                <td>KELAS</td>
                <td>: {{$reg->hakkelas}}</td>
              </tr>
              <tr>
                <td>JAM</td>
                <td>: {{date('H:i',strtotime($reg->created_at))}}</td>
              </tr>
            </table>
          </td>
        </tr>
        {{-- row 2 --}}
        <tr>
          <td colspan="2">
            NAMA AHLI BEDAH : <br/><br/>
            {{-- <p class="text-center"><b>{{baca_dokter(@$operasi->dokter)}}</b></p><br/><br/> --}}
            <p class="text-center"><b>drg. Nur Huda Alimin, Sp.BM</b></p><br/><br/>
          </td>
          <td colspan="2" style="vertical-align:top">
            NAMA ASISTEN :
          </td>
          <td colspan="2" style="vertical-align:top">
            NAMA PERAWAT :
          </td>
        </tr>
        {{-- row 3 --}}
         <tr>
          <td colspan="3" style="width:50%;">
            <table style="width:100%">
              <tr>
                <td style="width:100px;">
                  NAMA AHLI ANASTESI : <br/><br/>
                  {{-- <b>{{ baca_dokter(@$operasi->anestesi)}}</b><br/><br/> --}}
                  
                    <input type="checkbox" name="" id="" style="margin-top:10px;margin-left:30px;"> dr. Lismasari, Sp.An<br/>
                    <input type="checkbox" name="" id="" style="margin-top:10px;margin-left:30px;"> dr. Harpandi Rahim, Sp.An.,M.Kes<br/><br/>
                </td> 
              </tr> 
            </table>
          </td>
          <td colspan="3">
                JENIS ANASTESI : <br/><br/>
                <p class="text-center"><b>GENERAL ANASTESI</b></p><br/><br/>
          </td>
        </tr>
        {{-- row 4 --}}
        <tr>
          <td colspan="6" style="height:50px">
            DIAGNOSIS PRE-OPERATIF :
          </td> 
        </tr>
        {{-- row 5 --}}
        <tr>
          <td colspan="3" style="height:50px;vertical-align:top">
            DIAGNOSIS POST-OPERATIF :<br/><br/><br/>
            <p class="text-center"><b>SESUAI</b></p><br/><br/>
          </td>
          <td colspan="3" rowspan="2" style="height:50px">
            MACAM PEMBEDAHAN :<br/>
            <input type="checkbox" name="" id="" style="margin-top:10px;"> KHUSUS
            <input type="checkbox" name="" id="" style="margin-top:10px;margin-left:20px;"> ELECTIVE<br/>


            <input type="checkbox" name="" id="" style="margin-top:10px;"> BESAR
            <input type="checkbox" name="" id="" style="margin-top:10px;margin-left:20px;"> EMERGENCY<br/>
            <input type="checkbox" name="" id="" style="margin-top:10px;"> SEDANG<br/>
          </td>
        </tr>
        {{-- row 6 --}}
        <tr>
          <td colspan="3" style="height:50px;vertical-align:top">
            JENIS OPERASI :
          </td>
        </tr>
        {{-- row 7 --}}
        <tr>
          <td colspan="3" style="vertical-align:top">
            JARINGAN YANG DIEKSISI/INSISI : <br/><br/>
          </td>
          <td colspan="1" style="vertical-align:top">
            DIKIRIM UNTUK <br/>PEMERIKSAAN:<br/>
            PA&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="" id="" style="margin-top:10px;"> YA<br/>
            <input type="checkbox" name="" id="" style="margin-top:10px;margin-left:30px;"> TIDAK
          </td> 
          <td colspan="2" style="vertical-align:top">
            JENIS LUKA OPERASI<br/>
            <ol>
              <li>KOTOR</li>
              <li>KONTAMINASI</li>
              <li>PETENSIAL KONTAMINASI</li>
              <li>BERSIH</li>
            </ol>
          </td> 
        </tr>
        {{-- row 8 --}}
        <tr>
          <td colspan="1" style="height: 50px;vertical-align:top">TANGGAL OPERASI</td>
          <td colspan="1" style="vertical-align:top;text-align:center;">JAM OPERASI</td>
          <td colspan="2" style="text-align:center;vertical-align:top">JAM OPERASI SELESAI</td>
          <td colspan="2" style="vertical-align:top;text-align:center">LAMA OPERASI BERLANGSUNG</td>
        </tr>
        <tr>
          <td colspan="6" style="height: 200px;vertical-align:top">
            LAPORAN OPERASI :(JIKA PERLU DAPAT DILANJUTKAN DIHALAMAN SEBALIKNYA)<br/>
              <p class="text-right" style="margin-top:150px;">
                (................................................................)<br/>
                <span style="margin-right:15px;">Tanda Tangan dan Nama Terang</span>
              </p>
              {{-- <p class="text-right" name="f">Tanda Tangan & Nama Terang</p> --}}

          </td>
        </tr>
      </table>
    </div>
     

  </body>
</html>
