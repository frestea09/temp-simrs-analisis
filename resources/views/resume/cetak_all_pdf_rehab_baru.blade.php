<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Rehab Baru</title>
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
      .page-break {
        page-break-after: always;
      }
    </style>
  </head>
  <body onload="print()">
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif

    @if (count($rehabBaru) > 0)
      @foreach ($rehabBaru as $index => $baru)
        @php
          $reg = $baru->registrasi;
          $ttd = App\TandaTangan::where('registrasi_id', $reg->id)
                  ->where('jenis_dokumen', 'rehab-baru')
                  ->first();
          $soap = $baru;
          $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
        @endphp

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

    <table style="width: 100%; border: 0px solid;">
      <tr>
        <td colspan="2" style="padding-left: 20px;">
            <b>
              Identitas Pasien
            </b>        
        </td>
      </tr>
      <tr>
        <td style="width: 30%; padding-left: 20px;">Nomor Rekam Medis</td>
        <td style="width: 70%;">: {{ @$reg->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td style="padding-left: 20px;">NAMA</td>
        <td>: {{ @$reg->pasien->nama }}</td>
      </tr>
      <tr>
        <td style="padding-left: 20px;">TANGGAL LAHIR</td>
        <td>: {{ \Carbon\Carbon::parse(@$reg->pasien->tgllahir)->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td style="padding-left: 20px;">ALAMAT</td>
        <td>: {{ @$reg->pasien->alamat }}</td>
      </tr>
    </table>
    <br>

    <table style="width: 100%;" class="">
      <tr>
        <td style="width: 30%; vertical-align: top;">Subjective</td>
        <td style="width: 60%;">
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['subjective'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top;">Objective</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['objective'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top;">Assessment</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['assessment'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="width: 100%; vertical-align: top;">Planning</td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top; padding-left: 20px;">a.	Goal of Treatment:</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['planning']['goal_treatment'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top; padding-left: 20px;">b.	Tindakan/Program Rehabilitasi Medik:</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['planning']['tindakan_rehab'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top; padding-left: 20px;">c.	Edukasi:</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['planning']['edukasi'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td style="width: 30%; vertical-align: top; padding-left: 20px;">d.	Frekuensi Kunjungan:</td>
        <td>
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['planning']['frekuensi_kunjungan'] }}</textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="width: 30%; vertical-align: top;">Rencana Tindak Lanjut (Evaluasi/Rujuk/Selesai)*</td>
      </tr>
      <tr>
        <td colspan="2">
          <textarea class="form-control" style="display: inline-block; width:90%;border: 1px solid;" rows="8">{{ @json_decode(@$soap->fisik, true)['planning']['frekuensi_kunjungan'] }}</textarea>
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
          TTE Dokter<br>
          @if (isset($proses_tte))
          <br><br><br>
            #
          <br><br><br><br>
          @elseif (isset($tte_nonaktif))
          <br><br>
            @php
              $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
            @endphp
            <img src="data:image/png;base64, {!! $base64 !!} ">
            <br>
          @else
            @php
              $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dokter->nama . ' | ' . @$dokter->nip))
            @endphp
            <br><br><br>
            <img src="data:image/png;base64, {!! $base64 !!} ">
            <br>
          @endif

          
          @if (isset($proses_tte))
            {{Auth::user()->pegawai->nama}}
          @else
            {{@$dokter->nama}}
          @endif
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    @if ($index < count($rehabBaru) - 1)
            <div class="page-break"></div>
        @endif
      @endforeach
    @endif

  </body>
</html>
