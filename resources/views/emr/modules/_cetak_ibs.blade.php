<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pre Operatif</title>
    <style>
        table, th, td {
            /* border: 1px solid black; */
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
        }
        .border-top{
            border-top: 0.5px solid rgb(85, 83, 83);
        }
        .border-right{
            border-right: 0.5px solid rgb(85, 83, 83) !important;
        }
        .borderles-table{
            border: none;
        }
    </style>
  </head>
  <body>
    @php
      $asessment = json_decode($ibs->fisik, true);
    @endphp
    <table style="border: 1px solid">
      <tr >
        <th colspan="1" style="border: 1px solid;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </th>
        <th colspan="5" style="font-size: 20pt; border: 1px solid;">
          <b>Asuhan Keperawatan Perioperatif Instalasi Bedah Sentral</b>
        </th>
      </tr>
      <tr>
        <td colspan="6" style="border: 1px solid;">
          <b>TANGGAL PEMERIKSAAN : </b>
          {{ date('d-m-Y',strtotime(@$ibs->created_at)) }}
        </td>
      </tr>
        <tr>
            <td colspan="2" style="border: 1px solid;">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2" style="border: 1px solid;">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} 
            </td>
            <td style="border: 1px solid;">
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin }}
            </td>
            <td style="border: 1px solid;">
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="5" style="border: 1px solid;">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td style="border: 1px solid;">
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>A. DATA PERAWATAN PRE OPERATIF</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            1. Kesadaran : {{@$asessment['preOperatif']['kesadaran']}} <br>
            2. Sistem Pernafasan : {{@$asessment['preOperatif']['sistemPernafasan']}} ,  Suara nafas : {{@$asessment['preOperatif']['suaraNafas']}}, Alat Bantu : {{@$asessment['preOperatif']['alatBantuNafas']}} <br>
            3. Sistem Kardiopulmona : Edema Perife : {{@$asessment['preOperatif']['kardiopulmonal']['edemaPerifer']['ada']}}, {{@$asessment['preOperatif']['kardiopulmonal']['edemaPerifer']['keterangan']}}, Alat Bantu : {{@$asessment['preOperatif']['kardiopulmonal']['alatBantu']}} , Kulit : {{@$asessment['preOperatif']['kardiopulmonal']['kulit']}} <br>
            4. Sistem Muskuloskeleta : {{@$asessment['preOperatif']['sistemMuskuloskeleta']}} <br>
            5. Sistem Perkemihan : {{@$asessment['preOperatif']['sistemPerkemihan']}} <br>
            6. Sistem neursensor : {{@$asessment['preOperatif']['sistemNeurosensor']}} <br>
            7. Alat Bantu : {{@$asessment['preOperatif']['alatBantu']}} <br>
            8. Keluhan Nyeri : {{@$asessment['preOperatif']['keluhanNyeri']['pilihan']}} , Skala Nyeri : {{@$asessment['preOperatif']['keluhanNyeri']['skalaNyeri']}}, Lokasi : {{@$asessment['preOperatif']['keluhanNyeri']['lokasi']}} , Yang meringankan / memperberat nyeri : {{@$asessment['preOperatif']['keluhanNyeri']['yang_meringankan_atau_memperberat']}}, Waktu : {{@$asessment['preOperatif']['keluhanNyeri']['waktu']}} <br>
            9. Status Psikologi : {{@$asessment['preOperatif']['statusPsikologi']}} <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>B. DATA PERAWATAN INTRA OPERATIF</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>1. TTV</b> <br/>
              - TD : {{@$asessment['intraOperatif']['td']}}<br>
              - SpO2 : {{@$asessment['intraOperatif']['spo2']}}<br>
              - HR : {{@$asessment['intraOperatif']['hr']}}<br>
            <br>
            <b>2. Pendarahan</b><br/>
              - Kasa : {{@$asessment['intraOperatif']['kasa']}}<br>
              - Suction : {{@$asessment['intraOperatif']['suction']}}<br>
            <br>
            <b>3. Irigasi Pencucian</b><br/>
              {{@$asessment['intraOperatif']['irigasiPencucian']}}
            <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>C. DATA PERAWATAN POST OPERATIF</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>1. Keluhan Nyeri</b> <br/>
              {{@$asessment['postOperatif']['keluhanNyeri']}}, Skala Nyeri : {{@$asessment['postOperatif']['skalaNyeri']}}
            <br>
            <b>2. Kondisi Kulit</b><br/>
              {{@$asessment['postOperatif']['kondisiKulit']}}
            <br>
            <b>3. Kesadaran</b><br/>
              {{@$asessment['postOperatif']['kesadaran']}}
            <br>
            <b>4. TTV</b><br/>
              - TD : {{@$asessment['postOperatif']['td']}}<br>
              - SpO2 : {{@$asessment['postOperatif']['spo2']}}<br>
              - HR : {{@$asessment['postOperatif']['hr']}}<br>
            <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>D. ALASAN PEMBATALAN / PENUNDAAN OPERASI</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{@$asessment['alasanPembatalan']}} <br><br>
            <b>Post Operasi Ke :</b> {{@$asessment['postOperasiKe']}}, <b>Dengan : </b> {{@$asessment['pergiDengan']}}
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>E. Discharge Planning (Khusus ODS)</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            @if (@$asessment['dischargePlanning'] == "tanya")
              Tanyakan apakah ada pusing, mual, dll. Bila ada biarkan pasien istirahat sampai keluhan hilang
            @elseif (@$asessment['dischargePlanning'] == "jelaskan")
              Jelaskan cara dan rute penggunaan obat, perawatan luka dirumah (rekomendasikan ke puskesmas/RS terdekat)
            @elseif (@$asessment['dischargePlanning'] == "informasi")
              Informasikan dengan jelas tanggal kontrol
            @elseif (@$asessment['dischargePlanning'] == "pastikan")
              Pastiksan Pasien Tidak Pulang Sendiri
            @endif
          </td>
        </tr>
    </table>
    <table style="border: 0px;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          Dokter
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ baca_user($ibs->user_id) }}
        </td>
      </tr>
    </table>
    
  </body>
</html>
 