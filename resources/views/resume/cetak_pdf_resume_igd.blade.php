<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Pasien</title>
    <style>
        * {
          font-size: 11px;
        }
        table{
          width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
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
        .page_break_after{
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

    <table>
        <tr>
          <th colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"><br>
            <b style="font-size:12px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
          </th>
          <th colspan="5" style="font-size: 20px !important;">
            <b>E-RESUME RAWAT DARURAT</b>
          </th>
        </tr>
        <tr>
            <td colspan="2">
                <b>Nama Pasien</b><br>
                {{ $registrasi->pasien->nama }}
            </td>
            <td colspan="2">
                <b>Tgl. Lahir</b><br>
                {{ !empty($registrasi->pasien->tgllahir) ? hitung_umur($registrasi->pasien->tgllahir) : NULL }} 
            </td>
            <td>
                <b>Jenis Kelamin</b><br>
                {{ $registrasi->pasien->kelamin }}
            </td>
            <td>
                <b>No MR.</b><br>
                {{ $registrasi->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <b>Alamat Lengkap</b><br>
                {{ $registrasi->pasien->alamat }}
            </td>
            <td>
              <b>Poli</b><br>
              {{ @$registrasi->poli->nama }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $registrasi->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td colspan="3">
            <b>Tanggal Masuk</b><br>
            {{date('d-m-Y, H:i', strtotime($registrasi->created_at))}}
          </td>
          <td colspan="3">
            <b>Tanggal Keluar</b><br>
              @if ($registrasi->tgl_pulang)
                {{date('d-m-Y, H:i', strtotime($registrasi->tgl_pulang))}}
              @else
               -
              @endif
          </td>
        </tr>
        <tr>
          @php
              $data_triage = @\App\EmrInapPemeriksaan::where('registrasi_id', $registrasi->id)->where('type', 'triage-igd')->orderBy('id', 'DESC')->first();
              $triage = json_decode($data_triage->fisik, true);
          @endphp
          <td>
              <b>KESIMPULAN TRIAGE</b>
          </td>
          <td colspan="5">
            {{ @$triage['triage']['kesimpulan'] }}
          </td>
        </tr>
        <tr>
          <td>
              <b>ANAMNESA</b>
          </td>
          <td colspan="5">
              {{ @$content['anamnesa'] }}
          </td>
        </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN FISIK</b>
          </td>
          @php
                $pemeriksaan_fisik = str_replace(array("\r\n", "\r", "\n"), "&#13;&#13;", @$content['pemeriksaan_fisik']);
                $pemeriksaan_fisik = explode("&#13;&#13;", $pemeriksaan_fisik);
                $pemeriksaan_fisik = array_filter($pemeriksaan_fisik);
            @endphp
          <td colspan="5">
            @foreach ($pemeriksaan_fisik as $pemeriksaan)
              {{$pemeriksaan}} <br>
            @endforeach
          </td>
        </tr>
        <tr>
          <td>
              <b>DIAGNOSA UTAMA</b>
          </td>
          <td colspan="3">
            {{ @$content['diagnosa_utama'] }}
          </td>
          <td>
              <b>KODE ICD X</b>
          </td>
          <td colspan="1">
            {{ @$content['icdx_diagnosa_utama'] ? @$content['icdx_diagnosa_utama'] : baca_icd10(@$icd10Primary_jkn->icd10) }}
          </td>
        </tr>
        <tr>
          <td>
              <b>DIAGNOSA TAMBAHAN</b>
          </td>
          <td colspan="3">
            <ul style="padding: 0; margin: 0">
              <li>{{ @$content['diagnosa_tambahan'] }}</li>
              @if (is_array(@$content['tambahan_diagnosa_tambahan']))
              @foreach (@$content['tambahan_diagnosa_tambahan'] as $key => $diagnosa_tambahan)
                  <li>{{@$content['tambahan_diagnosa_tambahan'][$key]}}</li>
              @endforeach
              @endif
            </ul>
          </td>
          <td>
              <b>KODE ICD X</b>
          </td>
          <td colspan="1">
            <ul style="padding: 0; margin: 0">
              @if (@$icd10Secondary_jkn)
                  @foreach ($icd10Secondary_jkn as $icd)
                      <li>{{baca_icd10(@$icd->icd10)}}</li>
                  @endforeach
              @endif
                {{-- <li>{{ @$content['icdx_diagnosa_tambahan'] }}</li> --}}
                {{-- @if (is_array(@$content['tambahan_icdx_diagnosa_tambahan']))
                    @foreach (@$content['tambahan_diagnosa_tambahan'] as $key => $diagnosa_tambahan)
                        <li>{{@$content['tambahan_icdx_diagnosa_tambahan'][$key]}}</li>
                    @endforeach
                @endif --}}
            </ul>
          </td>
        </tr>
        <tr>
          <td colspan="3" style="vertical-align: top;">
              <b>TINDAKAN</b><br/>
              {{@$content['tindakan']}}
          </td>
          <td colspan="3" style="vertical-align: top;">
              <b>KODE ICD IX</b><br/>
              {{@$content['icdix_tindakan']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>PENGOBATAN</b>
          </td>
          <td colspan="5">
            {{@$content['pengobatan']}}
          </td>
        </tr>

    </table>
    <div class="page_break_after"></div>
    @php
        $ttd = \Modules\Pasien\Entities\Pasien::where('id', $registrasi->pasien_id)->first();
    @endphp
    <table>
      <tr>
        <td>
            <b>CARA PULANG</b>
        </td>
        <td colspan="5">
                {{@$content['cara_pulang']}} - {{ @$content['kondisi_pulang'] }}
        </td>
      </tr>
    </table>
    <br>
    <table style="border: 0px; margin-top: 3rem;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px; width: 60%;">
          Tanda Tangan Pasien / Keluarga atau Wali
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          Dokter
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">
          @if (@$ttd->tanda_tangan)
            <img src="{{public_path('images/upload/ttd/' . $ttd->tanda_tangan)}}" alt="ttd" width="200" height="100">
          @endif
        </td>
        <td colspan="3" style="text-align: center; border: 0px;height: 1cm;">
          @if (isset($proses_tte))
            #
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
          {{ $registrasi->pasien->nama }}
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ @$dokter->nama }}
        </td>
      </tr>
    </table>
  </body>
</html>
 