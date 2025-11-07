<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Layanan Rehab</title>
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
      @page {
          padding-bottom: 2cm;
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
  <body>

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

    @if (count($layananRehab) > 0)
      @foreach ($layananRehab as $index => $layanan)
        @php
          $reg = $layanan->registrasi;
          $ttd = App\TandaTangan::where('registrasi_id', $reg->id)
                  ->where('jenis_dokumen', 'layanan-rehab')
                  ->first();
          $soap = $layanan;
          $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
        @endphp
        <table style="width: 100%">
          <tr>
            <td style="text-align: center">
              <b>Lembar Formulir Rawat Jalan</b>
            </td>
          </tr>
          <tr>
            <td style="text-align: center">
              <b>Layanan Kedokteran Fisik dan Rehabilitasi</b>
            </td>
          </tr>
        </table>
        <br>
    
        <table style="width: 100%; border: 1px solid">
          <tr>
            <td colspan="3">
              <b>Diisi oleh Pasien / Peserta</b>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">NO. RM</td>
            <td colspan="2">: {{ @$reg->pasien->no_rm }}</td>
          </tr>
          <tr>
            <td style="width: 25%">Nama Pasien</td>
            <td colspan="2">: {{ @$reg->pasien->nama }}</td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td colspan="2">: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td colspan="2">: {{ @$reg->pasien->alamat }}</td>
          </tr>
          <tr>
            <td>Telp / HP</td>
            <td colspan="2">: {{$reg->pasien->nohp ? @$reg->pasien->nohp : @$reg->pasien->notlp}}</td>
          </tr>
          {{-- <tr>
            <td>Hubungan dengan Tertanggung</td>
            <td colspan="2">
              : 
              <label class="form-check-label">
                <input class="form-check-input"  name="" type="checkbox">
                Suami / Istri
              </label>
              <label class="form-check-label">
                <input class="form-check-input"  name="" type="checkbox">
                Anak
              </label>
            </td>
          </tr> --}}
        </table>
        <br>
    
        <table style="width: 100%; border: 1px solid;">
          @php
            $created_at = \Carbon\Carbon::parse($reg->created_at);
          @endphp
          <tr>
            <td colspan="3">
              <b>Diisi oleh Dokter SpKFR</b>
            </td>
          </tr>
          <tr>
            <td style="width: 30%">Tanggal Pelayanan</td>
            <td colspan="2">:  {{Carbon\Carbon::parse(@$reg->created_at)->format('d-m-Y')}}</td>
          </tr>
          <tr>
            <td style="width: 30%">Anamnesa</td>
            <td colspan="2">: {{ @json_decode(@$soap->fisik, true)['anamnesa'] }}</td>
          </tr>
          <tr>
            <td style="width: 30%">Pemeriksaan Fisik dan Uji Fungsi</td>
            <td colspan="2">: {{ @json_decode(@$soap->fisik, true)['pemeriksaan_fisik'] }}</td>
          </tr>
          <tr>
            <td style="width: 30%">Diagnosa Medis (ICD-10)</td>
            <td colspan="2">
              : {{ @json_decode(@$soap->fisik, true)['icd10'] }}
            </td>
          </tr>
          <tr>
            <td style="width: 30%">Pemeriksaan Penunjang</td>
            <td colspan="2">: {{ @json_decode(@$soap->fisik, true)['pemeriksaan_penunjang'] }}</td>
          </tr>
          <tr>
            <td style="width: 30%">Tata Laksana KFR (ICD-9)</td>
            <td colspan="2">
              : {{ @json_decode(@$soap->fisik, true)['icd9'] }}
            </td>
          </tr>
          <tr>
            <td style="width: 30%">Anjuran</td>
            {{-- <td colspan="2">: {{ @json_decode(@$soap->fisik, true)['anjuran'] }}</td> --}}
            <td colspan="2">: 2x /minggu</td>
          </tr>
          <tr>
            <td style="width: 30%">Evaluasi</td>
            @if ($created_at->year == 2024 && $created_at->month <= 11){
              <td colspan="2">: 1 bulan</td>
            }
            @else
              <td colspan="2">: 2 minggu</td>
            @endif
            {{-- <td colspan="2">: {{ @json_decode(@$soap->fisik, true)['evaluasi'] }}</td> --}}
          </tr>
          <tr>
            <td style="width: 30%">Suspek Penyakit Akibat Kerja</td>
            <td colspan="2">
              : {{ @json_decode(@$soap->fisik, true)['penyakitAkibatkerja']['pilihan'] }}. {{ @json_decode(@$soap->fisik, true)['penyakitAkibatkerja']['keterangan'] }}
            </td>
          </tr>
          
        </table>
        <br>
        <table style="width: 100%">
          <tr>
            <td style="width: 50%;"></td>
            <td style="text-align: center;">Soreang, {{Carbon\Carbon::parse(@$reg->created_at)->format('d-m-Y')}}</td>
          </tr>
          <tr>
            <td style="text-align: center;">
              @if (@$ttd)
              Tanda Tangan Pasien<br><br><br>
                  <img src="{{public_path('images/upload/ttd/' . $ttd->tanda_tangan)}}" alt="ttd" width="200" height="100">
              <br>
                  {{@$reg->pasien->nama}}
              @else
              Tanda Tangan Pasien
              <br><br><br><br><br><br><br><br>
              .............................
              @endif
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
        @if ($index < count($layananRehab) - 1)
            <div class="page-break"></div>
        @endif
      @endforeach
    @endif

  </body>
</html>
