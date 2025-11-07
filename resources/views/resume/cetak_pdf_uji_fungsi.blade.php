<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ @$reg->pasien->no_rm }}_{{ @$reg->pasien->nama }}_uji fungsi</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 10pt;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
      }
      .border{
        border: 1px solid;
        border-collapse: collapse;
      }
      th, td {
        padding: 0px 5px 0px 5px;
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
  <body onload="print()">
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    <table style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          {{-- <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          {{-- <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}

        </td>
      </tr>
    </table>
    <hr>
    <br>

    <table style="width: 100%; border: 1px solid;">
      <tr>
        <td colspan="4">
          <h5>
            <b>
              LEMBAR HASIL TINDAKAN UJI FUNGSI / PROSEDUR KFR ROM (KODING) .........................................
            </b>
          </h5>
        </td>
      </tr>
      <tr>
        <td style="width: 15%;">NO. RM</td>
        <td style="width: 30%;">: {{ @$reg->pasien->no_rm }}</td>
        <td style="width: 15%;">L / P</td>
        <td style="width: 30%;">: {{ @$reg->pasien->kelamin }}</td>
      </tr>
      <tr>
        <td>NAMA PASIEN</td>
        <td>: {{ @$reg->pasien->nama }}</td>
        <td>TANGGAL</td>
        <td></td>
      </tr>
      <tr>
        <td>TANGGAL LAHIR</td>
        <td>: {{ \Carbon\Carbon::parse(@$reg->pasien->tgllahir)->format('d/m/Y') }}</td>
        <td>PEMERIKSAAN</td>
        <td>: {{ \Carbon\Carbon::parse(@$reg->created_at)->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td>USIA</td>
        <td>: {{ hitung_umur(@$reg->pasien->tgllahir) }}</td>
        <td>DIAGNOSIS FUNGSIONAL</td>
        {{-- <td>: {{ @json_decode(@$soap->fisik, true)['diagnosis_fungsional'] }}</td> --}}
        <td>: Gangguan ADL</td>
      </tr>
      <tr>
        <td>ALAMAT</td>
        <td>: {{ @$reg->pasien->alamat }}</td>
        <td>DIAGNOSIS MEDIS</td>
        {{-- <td>: {{ @json_decode(@$soap->fisik, true)['diagnosis_medis'] }}</td> --}}
        <td>: {{ @$cppt->assesment ?? '' }}</td>
      </tr>
      <tr>
        <td>TELEPON</td>
        <td>: {{ $reg->pasien->nohp ? @$reg->pasien->nohp : @$reg->pasien->notlp }}</td>
        {{-- <td>DIAGNOSIS</td>
        <td>: </td> --}}
      </tr>
    </table>
    <br>

    <table style="width: 100%;" class="border">
      <tr>
        <td colspan="2">
          <h5><b>INSTRUMEN UJI FUNGSI / PROSEDUR KFR</b></h5>
        </td>
      </tr>
      {{-- <tr>
        <td style="width: 30%; vertical-align: top;">DIAGNOSA</td>
        <td style="width: 60%;">
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['diagnosa'] }}</textarea>
        </td>
      </tr> --}}
      <tr>
        <td style="width: 30%; vertical-align: top;">HASIL YANG DIDAPAT</td>
        <td style="width: 60%;">
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['hasilDidapat'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top;">KESIMPULAN</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['kesimpulan'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top;">REKOMENDASI</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['rekomendasi'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td style="text-align: center;">Soreang, {{ \Carbon\Carbon::parse(@$reg->created_at)->format('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="text-align: center;">
        </td>
        <td style="text-align: center;">
          Cap dan TTD Dokter
          {{-- @if (isset($proses_tte))
          <br><br><br>
            #
          <br><br><br><br>
          @elseif (isset($tte_nonaktif)) --}}
          <br><br>
            @php
              $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
              $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
            @endphp
            <img src="data:image/png;base64, {!! $base64 !!} ">
            <br>
          {{-- @else
            <br><br><br>
            <br><br><br><br>
          @endif --}}
          
          {{-- @if (isset($proses_tte) || isset($tte_nonaktif)) --}}
            {{$dokter->nama}} <br>
            NIP. {{$dokter->sip}}
          {{-- @else
          ............................
          @endif --}}
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

  </body>
</html>
