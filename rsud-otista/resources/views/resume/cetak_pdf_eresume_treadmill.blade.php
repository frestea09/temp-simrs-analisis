<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Pasien</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
        }
        @page {
            padding-bottom: 1cm;
        }

        .footer {
          position: fixed; 
          bottom: 0cm; 
          left: 0cm; 
          right: 0cm;
          height: 1cm;
          text-align: justify;
        }
    </style>
  </head>
  <body>
    @if (isset($cetak_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif

    <table>
        <tr>
          <th colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="5" style="font-size: 20pt;">
            <b>HASIL EKSPERTISE TREADMILL</b>
          </th>
        </tr>
        <tr>
            <td colspan="2">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} 
            </td>
            <td>
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin }}
            </td>
            <td>
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td>
              <b>Angina</b>
          </td>
          <td colspan="2">
            {{@$assesment['Angina']}}
          </td>
          <td>
              <b>HISTORY OF MI</b>
          </td>
          <td colspan="2">
            {{@$assesment['HISTORYOFMI']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>PRIOR OF CABG</b>
          </td>
          <td colspan="2">
            {{@$assesment['PRIOROFCABG']}}
          </td>
          <td>
              <b>PRIOR CATH</b>
          </td>
          <td colspan="2">
            {{@$assesment['PRIORCATH']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>DIABETIC</b>
          </td>
          <td colspan="2">
            {{@$assesment['DIABETIC']}}
          </td>
          <td>
              <b>SMOKING</b>
          </td>
          <td colspan="2">
            {{@$assesment['SMOKING']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>FAMILY HISTORY</b>
          </td>
          <td colspan="5">
            {{@$assesment['FAMILYHISTORY']}}
          </td> 
        </tr>
       
        
        <tr>
          <td>
              <b>INDICATIONS</b>
          </td>
          <td colspan="5">
            {{@$assesment['INDICATIONS']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>MEDICATIONS</b>
          </td>
          <td colspan="5">
            {{@$assesment['MEDICATIONS']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>REFERRING PHYSICIAN</b>
          </td>
          <td colspan="">
            {{@$assesment['REFERRINGPHYSICIAN']}}
          </td>
          <td>
              <b>LOCATION</b>
          </td>
          <td colspan="">
            {{@$assesment['LOCATION']}}
          </td>
          <td>
              <b>PROCEDURE TYPE</b>
          </td>
          <td colspan="">
            {{@$assesment['PROCEDURETYPE']}}
          </td>
        </tr>
       
        <tr>
          <td>
              <b>ATTENDING PHY</b>
          </td>
          <td colspan="">
            {{@$assesment['ATTENDINGPHY']}}
          </td>
          <td>
              <b>TARGET HR:(85%)</b>
          </td>
          <td colspan="">
            {{@$assesment['TARGETHR']}}
          </td>
          <td>
              <b>REASON FOR END</b>
          </td>
          <td colspan="">
            {{@$assesment['REASONFOR']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>TECHNICIAN</b>
          </td>
          <td colspan="">
            {{@$assesment['TECHNICIAN']}}
          </td>
          <td>
              <b>MAX HR : (% MPHR)</b>
          </td>
          <td colspan="">
            {{@$assesment['MAXHR']}}
          </td>
          <td>
              <b>SYMTOMS</b>
          </td>
          <td colspan="">
            {{@$assesment['SYMTOMS']}}
          </td>
        </tr>

        <tr>
          <td colspan="3" style="vertical-align: top;">
              <b>DIAGNOSIS</b><br/>
              {{@$assesment['DIAGNOSIS']}}
          </td>
          <td colspan="3" style="vertical-align: top;">
              <b>NOTES </b><br/>
              {{@$assesment['NOTES']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>CONCLUSIONS</b>
          </td>
          <td colspan="5">
            {{@$assesment['CONCLUSIONS']}}
          </td>
        </tr>
       
    </table>
    <br>
    <!-- <table>
        <tr>
            <td style="text-align: right !important!;">
                Dicetak Tanggal<br>
                {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
            </td>
        </tr>
    </table> -->
    <table style="border: 0px;margin-top: 3rem;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          @if (str_contains(baca_user(@$emr->user_id),'dr.'))
            
              Dokter
          @else
              Perawat
          @endif
        </td>
      </tr>
      <tr style="border: 0px; padding: 0;">
        <td colspan="3" style="text-align: center; border: 0px;">
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          @if (isset($cetak_tte))
          <span style="margin-left: 1rem;">
            #
          </span>
            <br>
            <br>
          @elseif (isset($tte_nonaktif))
            @php
              $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
            @endphp
            <img src="data:image/png;base64, {!! $base64 !!} ">
          @endif
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{baca_user(@$emr->user_id)}}
        </td>
      </tr>
    </table>

    
  </body>
</html>
 