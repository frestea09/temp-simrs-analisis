<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data PDF</title>
  <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
  <style>
    *{
      font-family: 'Times New Roman', Times, serif
    }
    .page_break {
      /* page-break-after: always; */
    }
  </style>
</head>

<body>
  <div class="page_break">
    <div id="header">
      {{-- <center> --}}
        <div class="logo">
          {{-- <img src="https://stmadyang.id/assets/upload/image/1572563316logo.jpg" class="img img-responsive"
            style="float:left;margin-right:40px !important;" width="70px;"> --}}
          <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive"
            style="float:left;margin-right:40px !important;" width="70px;">
        </div>
        <div class="tanggal" style="float:right;color:green">MR.12a/RI/2018</div>
        <div class="nama">
          <b style="font-size:17px;color:red">{!! config('app.nama').'&nbsp;'.strtoupper(config('app.kota')) !!}</b> <br>
          <div class="alamat" style="color:green"> {{ configrs()->pt }} <br> {{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}</div>
        </div>
        
        {{--
      </center> --}}
    </div>
    <div style="float:none;clear:both;"></div>
    <br>
    <hr/>
    <br>
    <br>
    <table class="" border="1" cellpadding="3" cellspacing="0" style="font-size:12px;width: 100%"> 
      <tr>
        <td>&nbsp;</td>
        <th class="text-center">Hitungan Pertama</th>
        <th class="text-center">Tambahan Selama Operasi</th>
        <th class="text-center">Jumlah</th>
        <th class="text-center">Hitungan Akhir</th>
        <th class="text-center">Alat yang Dipasang / Dipaka</th>
      </tr>
      <tr>
        <td>1. Kasa Lipat</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_lipat']['hitungan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_lipat']['tambahan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_lipat']['jumlah']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_lipat']['hitungan_akhir']}}</td>
        <td>ETT No. : {{@json_decode($data_emr,true)['alat']['ett']}}</td>
      </tr>
      <tr>
        <td>2. Kasa Perut</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_perut']['hitungan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_perut']['tambahan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_perut']['jumlah']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['kasa_perut']['hitungan_akhir']}}</td>
        <td>NGT No. : {{@json_decode($data_emr,true)['alat']['ngt']}}</td>
      </tr>
      <tr>
        <td>3. Jarum</td>
        <td class="text-center">{{@json_decode($data_emr,true)['jarum']['hitungan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['jarum']['tambahan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['jarum']['jumlah']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['jarum']['hitungan_akhir']}}</td>
        <td>Urine Kateter No. : {{@json_decode($data_emr,true)['alat']['urine']}}</td>
      </tr>
      <tr>
        <td>4. Nama Set</td>
        <td class="text-center">{{@json_decode($data_emr,true)['nama_set']['hitungan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['nama_set']['tambahan']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['nama_set']['jumlah']}}</td>
        <td class="text-center">{{@json_decode($data_emr,true)['nama_set']['hitungan_akhir']}}</td>
        <td>I.V Kateter No. : {{@json_decode($data_emr,true)['alat']['iv']}}</td>
      </tr>
      <tr>
        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        <td>CPV di : {{@json_decode($data_emr,true)['alat']['cpv']}}</td>
      </tr>
      <tr>
        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        <td>Drainage di : {{@json_decode($data_emr,true)['alat']['drainage']}}</td>
      </tr>
      <tr>
        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        <td>GIPS : {{@json_decode($data_emr,true)['alat']['gips']}}</td>
      </tr>
      <tr>
        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        <td>Traksi : {{@json_decode($data_emr,true)['alat']['traksi']}}</td>
      </tr>
      <tr>
        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        <td>Tampon di :  {{@json_decode($data_emr,true)['alat']['tampon']}}
          Jum : {{@json_decode($data_emr,true)['alat']['jum']}}
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        <td>Monitor : {{@json_decode($data_emr,true)['alat']['monitor']}}</td>
      </tr>
    </table>
    <br/>
            <table border="1" style="font-size:12px;width: 100%" cellspacing="0"> 
              <tr>
                <td><b>Jaringan dikirim ke PA / Mikrobiologi</b>  &nbsp;&nbsp;&nbsp; :
                  <br/><input type="checkbox" {{@json_decode($data_emr,true)['jaringan']['ya'] ? 'checked' : ''}}> Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <br/><input type="checkbox" {{@json_decode($data_emr,true)['jaringan']['tidak'] ? 'checked' : ''}}> Tidak
                  <br/>1 {{@json_decode($data_emr,true)['jaringan']['1']}}<br/>
                  <br/>2 {{@json_decode($data_emr,true)['jaringan']['2']}}<br/>
                  <br/>3 {{@json_decode($data_emr,true)['jaringan']['3']}}
                </td>
                <td colspan="2"><b>Klasifikasi Luka :</b> &nbsp;&nbsp;&nbsp; :
                  <br/><input type="checkbox" {{@json_decode($data_emr,true)['klasifikasi']['bersih'] ? 'checked' : ''}}> Bersih&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <br/><input type="checkbox" {{@json_decode($data_emr,true)['klasifikasi']['terkontaminasi'] ? 'checked' : ''}}> Terkontaminasi
                  <br/><input type="checkbox" {{@json_decode($data_emr,true)['klasifikasi']['infeksi'] ? 'checked' : ''}}> Infeksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
               
                
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <b>Obat-Obatan / Irigasi Selama Operasi :</b><br/>
                  {{@json_decode($data_emr,true)['obat']}}
                </td>
                  <td style="padding: 5px;">
                    <b>Instrumen yang disterilkan O.K</b><br/>
                    {{@json_decode($data_emr,true)['instrumen']}}
                  </td>
              </tr>
              

              <tr>
                <td colspan="3"><b>Perawatan dilanjutkan ke Kamar Pemulihan ( R.R )</b> &nbsp;&nbsp;&nbsp; :<br/>
                  Masuk Kamar Pemulihan :<br/>
                  &nbsp;Tanggal : {{@date('d-m-Y',strtotime(@json_decode($data_emr,true)['perawatan']['tanggal']))}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Jam : {{@json_decode($data_emr,true)['perawatan']['jam']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Diterima Oleh : {{@json_decode($data_emr,true)['perawatan']['diterima']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <br/>&nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  CATATAN LAIN :<br/>
                  {{@json_decode($data_emr,true)['catatan']}}

                </td>
                <td>
                  PERAWAT INSTRUMEN :<br/>
                  {{@json_decode($data_emr,true)['perawat_instrumen']}}

                </td>
                <td>
                  PERAWAT SIRKULER :<br/>
                  {{@json_decode($data_emr,true)['perawat_sirkuler']}}
                </td>
              </tr>
            </table>
    {{-- <table style="float:right">
      <tr>
        <td colspan="3" class="text-right">
          <div style="margin-right:30px;">

            Palopo, {{date('d-m-Y')}} Jam {{date('H:i')}} <br/>Dokter Penanggung Jawab Pelayanan,<br/>
            <br/><br/><br/>
            <span style="margin-right:200px;">(</span> <span>)</span><br/>
            Tanda Tangan dan Nama Lengkap
            <br/><br/>
          </div>
          </td>
        </tr>
    </table> --}}
    
    <br />
  </div>

  {{-- PAGE 2 --}}
  {{-- <div class="">
    <div class="header">
        <div class="logo">
          <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive"
            style="float:left;margin-right:40px !important;" width="70px;">
        </div>
        <div class="nama">
          <b style="font-size:20px;">{!! config('app.nama').'&nbsp;'.strtoupper(config('app.kota')) !!}</b> <br>
          <div class="alamat"> {{ configrs()->pt }} <br> {{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}</div>
        </div>
        <div class="tanggal">
          <script type="text/javascript">
            show_hari();
          </script>
        </div>
    </div>
    <div style="float:none;clear:both;"></div>
    <br>
    <hr />
    <br>
    <table style="width: 100%" border="1" cellspacing="0" cellpadding="5">
      <tr>
        <th colspan="2">LANGKAH - LANGKAH DITERAPKAN UNTUK MENGURANGI RESIKO JATUH PADA PASIEN RAWAT JALAN</th>
        <th rowspan="2" class="text-center">YA</th>
       </tr>
       <tr>
        <th class="text-center" width="50px">NO</th>
        <th  width="90%">TATALAKSANA PENCEGAHAN RESIKO JATUH AREA RAWAT JALAN</th>
       </tr>
       <tr>
        <td class="text-center">1</td>
        <td>Membantu pasien saat berjalan atau berpindah duduk</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['1']}}</td>
       </tr>
       <tr>
        <td class="text-center">2</td>
        <td>Mengawasi pasien saat beraktivitas</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['2']}}</td>
       </tr>
       <tr>
        <td class="text-center">3</td>
        <td>Mengingatkan pasien untuk menggunakan alat bantu berjalan/tongkat, kursi roda, walker, tripod/kwadripod bila terlihat saat berjala tidak seimbang.</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['3']}}</td>
       </tr>
       <tr>
        <td class="text-center">4</td>
        <td>Mengingatkan pasien untuk menggunakan alat bantu penglihatan/ pendengaran bila memang sudah di anjurkan dokter</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['4']}}</td>
       </tr>
       <tr>
        <td class="text-center">5</td>
        <td>Menghindari jalan licin/basah/gelap</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['5']}}</td>
       </tr>
       <tr>
        <td class="text-center">6</td>
        <td>Tidak membiarkan Pasien seorang diri</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['6']}}</td>
       </tr>
       <tr>
        <td class="text-center">7</td>
        <td>Menganjurkan pasien menggunakan alas kaki yang tidak licin</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['7']}}</td>
       </tr>
       <tr>
        <td class="text-center">8</td>
        <td>Jika beresiko tinggi maka pasien akan di pasangkan PIN resiko jatuh berwarna kuning dan istirahatkan di area prioritas resiko jatuh</td>
        <td class="text-center">{{@json_decode(@$data->formulir,true)['langkah']['8']}}</td>
       </tr>
    </table>
    <br />
  </div> --}}



</body>

</html>