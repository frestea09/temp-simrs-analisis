<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Program Terapi</title>
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

    @if (count($programTerapi) > 0)
      @foreach ($programTerapi as $index => $program)
        @php
          $reg = $program->registrasi;
          $ttd = App\TandaTangan::where('registrasi_id', $reg->id)
                  ->where('jenis_dokumen', 'program-terapi')
                  ->first();
          $soap = $program;
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

    <table style="width: 100%; border: 1px solid;">
      <tr>
        <td style="width: 25%">NO. RM</td>
        <td colspan="2">: {{ @$reg->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td style="width: 25%">NAMA PASIEN</td>
        <td colspan="2">: {{ @$reg->pasien->nama }}</td>
      </tr>
      <tr>
        <td style="width: 25%">DIAGNOSA</td>
        <td colspan="2">: </td>
      </tr>
    </table>
    <br>

    <table style="width: 100%; border: 1px solid;">
      <tr>
        <td style="width: 25%">PERMINTAAN TERAPI</td>
        <td colspan="2">: {{ @json_decode(@$soap->fisik, true)['permintaanTerapi'] }}</td>
      </tr>
    </table>
    <br>

    <table style="width: 100%;" class="border">
      <thead>
        <tr>
          <th rowspan="2" style="text-align: center;" class="border">PROGRAM</th>
          <th rowspan="2" style="text-align: center;" class="border">TANGGAL</th>
          <th colspan="2" style="text-align: center;" class="border">TTD</th>
        </tr>
        <tr>
          {{-- <th style="text-align: center;" class="border">PASIEN</th> --}}
          <th style="text-align: center;" class="border">DOKTER</th>
          <th style="text-align: center;" class="border">TERAPIS</th>
        </tr>
      </thead>
      <tbody>
        @php
          $data = json_decode(@$soap->fisik, true);
          $maxRows = 8;
          $rowsCount = count($data['program'] ?? []);
        @endphp

        @for ($i = 1; $i <= $maxRows; $i++)
            <tr>
                <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">
                    {{ $data['program'][$i] ?? '' }}
                </td>
                <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">
                    {{ $data['tgl'][$i] ?? '' }}
                </td>
                {{-- <td class="border" style="padding-left: 5px; width: 20%; height: 50px;" align="center">
                    @if ($ttd && !empty($data['program'][$i]))
                        <img src="{{ asset('images/upload/ttd/' . $ttd->tanda_tangan) }}" alt="" width="100" height="50">
                    @endif
                </td> --}}
                <td class="border" style="padding-left: 5px; width: 20%; height: 50px;" align="center">
                    {{-- {{dd($ttd_dokter)}} --}}
                    @if ($ttd_dokter && !empty($data['program'][$i]))
                        <img src="{{ public_path('images/' . $ttd_dokter) }}" alt="" width="100" height="50">
                    @endif
                </td>
                <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
            </tr>
        @endfor
        
        {{-- <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['2'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['2'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['3'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['3'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['4'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['4'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['5'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['5'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['6'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['6'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['7'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['7'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['8'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['8'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['9'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['9'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr>
        <tr>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;">{{ @json_decode(@$soap->fisik, true)['program']['10'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px; text-align: center;">{{ @json_decode(@$soap->fisik, true)['tgl']['10'] }}</td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
          <td class="border" style="padding-left: 5px; width: 20%; height: 50px;"></td>
        </tr> --}}
      </tbody>
      
    </table>
    <br>
    <table style="width: 100%">
      <tr>
        <td colspan="2" style="width: 50%;"></td>
        {{-- <td style="text-align: center;">Soreang, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> --}}
      </tr>
      <tr>
        <td style="text-align: center;">
          {{-- @if (@$ttd)
          Tanda Tangan Pasien<br><br><br>
              <img src="{{public_path('images/upload/ttd/' . $ttd->tanda_tangan)}}" alt="ttd" width="200" height="100">
          <br>
              {{@$reg->pasien->nama}}
          @else
          Tanda Tangan Pasien
          <br><br><br><br><br><br><br><br>
          .............................
          @endif --}}
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
    </table>
    @if ($index < count($programTerapi) - 1)
            <div class="page-break"></div>
        @endif
      @endforeach
    @endif

  </body>
</html>
