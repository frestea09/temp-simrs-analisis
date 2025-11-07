<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transfer Internal - SBAR</title>
    <style>
        /* table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        } */

        @page {
          padding-bottom: 1cm;
        }

        .page_break_after{
          page-break-after: always;
        }

        .footer {
          position: fixed; 
          bottom: 0cm; 
          left: 0cm; 
          right: 0cm;
          height: 2cm;
          text-align: justify;
          font-size: 12px;
        }

        .border {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .p-1 {
            padding: .5rem;
        }

        .text-center {
            text-align: center;
        }
    </style>
  </head>
  <body>

    
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif

    <table style="border: none !important; width:100%;font-size:12px;"> 
        <tr>
          <td style="width:10%; text-align: center; width: 70%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 25px;"> <br>
            <b style="font-size:12px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:10px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
            <b style="font-size:10px; font-weight:normal;"> {{ configrs()->tlp }}</b><br/>
            <b style="font-size:10px; font-weight:normal;"> Laman : {{ configrs()->website }} <span style="font-size:10px; margin-left:5px">Email : {{ configrs()->email }}</span></b><br/>
          </td>
          <td style="width: 40%; vertical-align: top;" rowspan="2">
            <div style="border-radius: 10px; border: 1px solid black; padding: .5rem;">
                <div>
                    Nama : {{@$registrasi->pasien->nama}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Tanggal Lahir : {{@$registrasi->pasien->tgllahir}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    No. RM : {{@$registrasi->pasien->no_rm}} <br>
                </div>
            </div>
          </td>
        </tr>
      </table>

      @php
        $dataEkstra = @json_decode(@$emr->ekstra, true);
        $dataBackground = @json_decode(@$emr->background, true);
        $dataAssesment = @json_decode(@$emr->assesment, true);
        @endphp

      <table style="border: 1px solid black; width:100%;font-size:12px; margin-top: -2rem; border-collapse: collapse;"> 
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;">
              <h2 class="text-center" style="vertical-align: middle;">CATATAN TRANSFER PASIEN</h2>
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; padding: .3rem;">
                <div style="vertical-align: middle; display: inline-block">
                    Ruang asal :
                </div>
                <div style="vertical-align: middle; display: inline-block">
                    <input type="checkbox" class="form-check-input" style="vertical-align: middle;" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "IGD" ? "checked" : ""}} value="IGD">
                    <label style="font-weight: normal; display: inline-block; vertical-align: middle;">IGD</label>
                </div>
                <div style="vertical-align: middle; display: inline-block">
                    <input type="checkbox" class="form-check-input" style="vertical-align: middle;" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "IGD Kebidanan" ? "checked" : ""}} value="IGD Kebidanan">
                    <label style="font-weight: normal; display: inline-block; vertical-align: middle;">IGD Kebidananan</label>
                </div>
                <div style="vertical-align: middle; display: inline-block">
                    <input type="checkbox" class="form-check-input" style="vertical-align: middle;" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "IBS" ? "checked" : ""}} value="IBS">
                    <label style="font-weight: normal; display: inline-block; vertical-align: middle;">IBS</label>
                </div>
                <div style="vertical-align: middle; display: inline-block">
                    <input type="checkbox" class="form-check-input" style="vertical-align: middle;" name="ekstra[ruang_asal]" {{@$dataEkstra['ruang_asal'] == "Ruangan" ? "checked" : ""}} value="Ruangan">
                    <label style="font-weight: normal; display: inline-block; vertical-align: middle;">Ruangan</label>
                    {{@$dataEkstra['ruang_asal_detail']}}
                </div>
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; padding: .3rem;">
                Pindah ke :{{@$dataEkstra['pindah_ke']['ruangan']}}
                Tanggal :{{@$dataEkstra['pindah_ke']['tanggal']}}
                Jam :{{@$dataEkstra['pindah_ke']['jam']}}
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; padding: .3rem;">
                Dokter yang merawat :{{@$dataEkstra['dokter_yang_merawat']}}
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; padding: .3rem;">
                Alasan dirawat :{{@$dataEkstra['alasan_dirawat']}}
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; padding: .3rem;">
                Alasan pindah :{{@$dataEkstra['alasan_pindah']}}
            </td>
        </tr>
      </table>
      <br>
      <table style="border: 1px solid black; width:100%;font-size:12px; border-collapse: collapse;"> 
        <tr style="border: 1px solid black;">
            <td style="padding: .3rem 0 0 .3rem; width: 100%; border: 1px solid black; vertical-align: top">
                <b>SITUATION :</b> <br><br>
                {{@$emr->situation}}
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="padding: .3rem 0 0 .3rem; width: 100%; border: 1px solid black; vertical-align: top">
                <b>BACKGROUND :</b> <br><br>
                <b>Kondisi pasien saat pindah:</b>
                <br>
                <div>
                <b>Kesadaran :</b><br>
                <input type="checkbox" {{@$dataBackground['kesadaran']['compos'] == "Compos Mentis" ? "checked" : ""}} name="background[kesadaran][compos]" value="Compos Mentis">
                <label style="font-weight: normal;">Compos Mentis</label>
                <input type="checkbox" {{@$dataBackground['kesadaran']['apatis'] == "Apatis" ? "checked" : ""}} name="background[kesadaran][apatis]" value="Apatis">
                <label style="font-weight: normal;">Apatis</label>
                <input type="checkbox" {{@$dataBackground['kesadaran']['delirium'] == "Delirium" ? "checked" : ""}} name="background[kesadaran][delirium]" value="Delirium">
                <label style="font-weight: normal;">Delirium</label>
                <input type="checkbox" {{@$dataBackground['kesadaran']['sopor'] == "Sopor" ? "checked" : ""}} name="background[kesadaran][sopor]" value="Sopor">
                <label style="font-weight: normal;">Sopor</label>
                </div>
                <div>
                <b>GCS :</b><br>
                E :
                {{@$dataBackground['gcs']['e']}}
                M :
                {{@$dataBackground['gcs']['m']}}
                V :
                {{@$dataBackground['gcs']['v']}}
                </div>
                <div>
                <b>Tanda Vital :</b><br>
                Tekanan darah :
                {{@$dataBackground['tanda_vital']['tekanan_darah']}}
                Nadi :
                {{@$dataBackground['tanda_vital']['nadi']}}
                Pernafasan :
                {{@$dataBackground['tanda_vital']['pernafasan']}}
                Suhu :
                {{@$dataBackground['tanda_vital']['suhu']}}
                </div>
                <div>
                Penggunaan Oksigen :
                {{@$dataBackground['penggunaan_oksigen']['penggunaan']}}
                Cairan Parenteral :
                {{@$dataBackground['cairan_parenteral']['cairan']}}
                Transfusi :
                {{@$dataBackground['transfusi']['transfusi']}}
                </div>
                <div>
                <b>Penggunaan Kateter :</b>
                <input type="checkbox" name="background[penggunaan_kateter][detail]" {{@$dataBackground['penggunaan_kateter'] == "Ada" ? "checked" : ""}} value="Ada">
                <label style="font-weight: normal;">Ada</label>
                <input type="checkbox" name="background[penggunaan_kateter][detail]" {{@$dataBackground['penggunaan_kateter'] == "Tidak" ? "checked" : ""}} value="Tidak">
                <label style="font-weight: normal;">Tidak</label> <br>
                Pemakaian ke :
                {{@$dataBackground['penggunaan_kateter']['pemakaian_ke']}}
                Tanggal :
                {{@$dataBackground['penggunaan_kateter']['tanggal']}}
                Jam :
                {{@$dataBackground['penggunaan_kateter']['jam']}}
                </div>
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="padding: .3rem 0 0 .3rem; width: 100%; border: 1px solid black; vertical-align: top">
                <b>Hasil Pemeriksaan selama dirawat :</b> <br> <br>
                {{@$dataBackground['hasil_pemeriksaan_selama_dirawat']}}
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="padding: .3rem 0 0 .3rem; width: 100%; border: 1px solid black; vertical-align: top">
                <b>Prosedur / tindakan yang sudah dilakukan :</b> <br> <br>
                {{@$dataBackground['prosedur_tindakan_yang_dilakukan']}}
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="padding: .3rem 0 0 .3rem; width: 100%; border: 1px solid black; vertical-align: top">
                <b>ASSESMENT :</b> <br><br>
                <b>Diagnosa Medis:</b>
                <br>
                <div>
                  {{@$dataAssesment['diagnosa_medis']}}
                </div>
                <b>Diagnosa Keperawatan:</b>
                <br>
                <div>
                  {{@$dataAssesment['diagnosa_keperawatan']}}
                </div>
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="padding: .3rem 0 0 .3rem; width: 100%; border: 1px solid black; vertical-align: top">
                <b>RECOMENDASI :</b> <br><br>
                {{@$emr->recomendation}}
            </td>
        </tr>
      </table>
      <table style="width: 100%; font-size: 12px;">
            <tr>
                <td class="text-center">Mengetahui</td>
                <td>&nbsp;</td>
                <td class="text-center">Diserahkan</td>
                <td>&nbsp;</td>
                <td class="text-center">Diterima</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>{{baca_dokter(@$registrasi->rawat_inap->dokter_id)}}</td>
                <td>&nbsp;</td>
                <td class="text-center">Perawat</td>
                <td>&nbsp;</td>
                <td class="text-center">Perawat</td>
            </tr>
        </table>
  </body>
</html>
 