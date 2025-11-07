<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ @$reg->pasien->no_rm }}_{{ @$reg->pasien->nama }}_usg</title>
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
          {{-- <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
          <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          {{-- <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}
          <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">

        </td>
      </tr>
    </table>
    <hr>
    <br>

    <table style="width: 100%; border: 0px solid;">
      <tr>
        <td style="width: 15%;">Nomor RM</td>
        <td style="width: 30%;">: {{ @$reg->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td>Nama Pasien</td>
        <td>: {{ @$reg->pasien->nama }}</td>
      </tr>
      <tr>
        <td>Umur</td>
        <td>: {{ hitung_umur(@$reg->pasien->tgllahir) }}</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>: {{ @$reg->pasien->alamat }}</td>
      </tr>
      <tr>
        <td>Hasil Pemeriksaan</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2">
          <textarea class="form-control" style="display: inline-block; width:99%;border: 1px solid;" rows="15">{{ @$emr->object }}</textarea>
        </td>
      </tr>
    </table>
    <br>

    <table style="width: 100%;" border="0">
      <tr>
        <td style="width:50%;"></td>
        <td style="width:50%; text-align:center;">Soreang, {{ \Carbon\Carbon::parse(@$reg->created_at)->format('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="width:50%;">
        </td>
        <td style="width:50%; text-align:center;">
          Dokter
          <br>
            @php
              $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
              $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip . ' | ' . $reg->created_at));
            @endphp
            <img src="data:image/png;base64, {!! $base64 !!} ">
            <br>
            {{$dokter->nama}} <br>
            NIP. {{$dokter->sip}}
        </td>
      </tr>
    </table>

  </body>
</html>
