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
      @php
          $content = [];
          if ($resume) {
              $content = json_decode($resume->content, true);
          }
      @endphp
        <tr>
          <th colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"><br>
            <b style="font-size:12px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
          </th>
          <th colspan="5" style="font-size: 20px !important;">
            <b>E-RESUME {{ $reg->poli->politype == 'G' ? 'RAWAT DARURAT' : 'RAWAT JALAN' }}</b>
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
            <td colspan="4">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
              <b>Poli</b><br>
              {{ @$reg->poli->nama }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td colspan="3">
            <b>Tanggal Masuk</b><br>
            {{date('d-m-Y, H:i', strtotime(@$reg->created_at))}}
          </td>
          <td colspan="3">
            
            <b>Tanggal Keluar</b><br>

            @if (@$reg->tgl_pulang)
              {{date('d-m-Y, H:i', strtotime(@$reg->tgl_pulang))}}
            @else    
              @if ($soap || $soap_perawat)
                @if (!empty(@json_decode(@$soap_perawat->fisik, true)['selesai_evaluasi_perawatan']))
                  {{date('d-m-Y, H:i', strtotime(@json_decode(@$soap_perawat->fisik, true)['selesai_evaluasi_perawatan']))}}
                @else
                  {{date('d-m-Y, H:i', strtotime(@$soap->created_at))}}
                @endif
              @elseif ($cppt)
                {{date('d-m-Y, H:i', strtotime(@$cppt->created_at))}}
              @else
                -
              @endif
            @endif
          </td>
        </tr>
        {{-- Poli Kemuning --}}
        @if ($reg->poli_id == 16)
          <tr>
            <td><b>Dokter Pemeriksa</b></td>
            <td colspan="5">
              {{@$cppt->user->Pegawai->nama}}
            </td>
          </tr>
        @endif
        {{-- End Poli Kemuning --}}
        @if(@$reg->poli->politype == 'G')
          <tr>
            <td>
                <b>KESIMPULAN TRIAGE</b>
            </td>
            <td colspan="5">
              {{ @$triage['triage']['kesimpulan'] }}
            </td>
          </tr>
        @endif
        <tr>
          <td>
              <b>ANAMNESA</b>
          </td>
          <td colspan="5">
            @if (!empty($content))
              {{ @$content['anamnesa'] }}
            @else
              @if ($cppt)
                {{ @$cppt->subject }}
              @elseif ($soap)
                {{@json_decode(@$soap->fisik, true)['anamnesa']}}
              @endif
            @endif
          </td>
        </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td colspan="5">
            @if (!empty($content))
              @php
                $pemeriksaan_fisik = str_replace(array("\r\n", "\r", "\n"), "&#13;&#13;", @$content['pemeriksaan_fisik']);
                $pemeriksaan_fisik = explode("&#13;&#13;", $pemeriksaan_fisik);
                $pemeriksaan_fisik = array_filter($pemeriksaan_fisik);
              @endphp

              @foreach ($pemeriksaan_fisik as $pemeriksaan)
                {{$pemeriksaan}} <br>
              @endforeach
            @elseif ($cppt)
              {{ @$cppt->object }}
              <br>
              @if ($cpptPerawat)
                <ul>
                  <li>
                    Tanda Vital<br/>
                    <ul>
                      <li>TD : {{ @$cpptPerawat->tekanan_darah }} mmHG</li>
                      <li>Nadi : {{ @$cpptPerawat->nadi }} x/menit</li>
                      <li>RR : {{ @$cpptPerawat->frekuensi_nafas }} x/menit</li>
                      <li>Temp : {{ @$cpptPerawat->suhu }} °C</li>
                      <li>Berat Badan : {{ @$cpptPerawat->berat_badan }} Kg</li>
                    </ul>
                  </li>
                </ul>
              @endif
            @elseif ($soap)
              {{@json_decode(@$soap->fisik, true)['pemeriksaan_fisik']}}
              <br>
              <ul>
                <li>
                  Tanda Vital<br/>
                  <ul>
                    <li>TD : {{ @$soap['tanda_vital']['tekanan_darah'] }} mmHG</li>
                    <li>Nadi : {{ @$soap['tanda_vital']['nadi'] }} x/menit</li>
                    <li>RR : {{ @$soap['tanda_vital']['RR'] }} x/menit</li>
                    <li>Temp : {{ @$soap['tanda_vital']['temp'] }} °C</li>
                    <li>Berat Badan : {{ @$soap['tanda_vital']['BB'] }} Kg</li>
                    <li>Tinggi Badan : {{ @$soap['tanda_vital']['TB'] }} Cm</li>
                  </ul>
                </li>
              </ul>
            @endif
          </td>
        </tr>
        <tr>
          <td>
              <b>DIAGNOSA UTAMA</b>
          </td>
          <td colspan="3">
            @if (!empty($content))
              {{ @$content['diagnosa_utama'] }}
            @else
              @if ($cppt)
                {{ @$cppt->assesment }}
              @elseif ($soap)
                {{@json_decode(@$soap->fisik, true)['diagnosis']}}
              @endif
            @endif
          </td>
          <td>
              <b>KODE ICD X</b>
          </td>
          <td colspan="1">
            @if (!empty($content))
              @php
                  $icd10Primary_jkn = App\JknIcd10::where('registrasi_id', $reg->id)
                      ->where('kategori', 'Primary')
                      ->first();
              @endphp
              {{ @$content['icdx_diagnosa_utama'] ? @$content['icdx_diagnosa_utama'] : baca_icd10(@$icd10Primary_jkn->icd10) }}
            @else
              <ul>
                {{-- @foreach ($icd10Primary as $icd)
                  <li>{{baca_icd10($icd->icd10)}} - {{$icd->icd10}}</li>
                @endforeach --}}
                @foreach ($icd10Primary_jkn as $icd)
                  <li>{{baca_icd10($icd->icd10)}}</li>
                @endforeach
              </ul>
            @endif
          </td>
        </tr>
        <tr>
          <td>
              <b>DIAGNOSA TAMBAHAN</b>
          </td>
          <td colspan="3">
            @if (!empty($content))
              <ul style="padding: 0; margin: 0">
                <li>{{ @$content['diagnosa_tambahan'] }}</li>
                @if (is_array(@$content['tambahan_diagnosa_tambahan']))
                @foreach (@$content['tambahan_diagnosa_tambahan'] as $key => $diagnosa_tambahan)
                    <li>{{@$content['tambahan_diagnosa_tambahan'][$key]}}</li>
                @endforeach
                @endif
              </ul>
            @else
              @if ($cppt)
                {{ @$cppt->diagnosistambahan }}
              @elseif ($soap)
                {{@json_decode(@$soap->fisik, true)['diagnosistambahan']}}
              @endif
            @endif
          </td>
          <td>
              <b>KODE ICD X</b>
          </td>
          <td colspan="1">
            <ul>
              {{-- @foreach ($icd10Secondary as $icd)
                <li>{{baca_icd10($icd->icd10)}} - {{$icd->icd10}}</li>
              @endforeach --}}
              @foreach ($icd10Secondary_jkn as $icd)
                <li>{{baca_icd10($icd->icd10)}}</li>
              @endforeach
            </ul>
          </td>
        </tr>
        <tr>
          <td colspan="3" style="vertical-align: top;">
              <b>TINDAKAN</b><br/>
              @if (!empty($content))
                {{@$content['tindakan']}}
              @else
                @if ($cppt)
                  {{ @$cppt->planning }} <br>
                @elseif ($soap)
                  {{@json_decode(@$soap->fisik, true)['planning']}} <br>
                @endif
                @foreach (@$folio as $tindakan)
                - {{ @$tindakan->namatarif }}<br>
                @endforeach
              @endif
          </td>
          <td colspan="3" style="vertical-align: top;">
              <b>KODE ICD IX</b><br/>
              @if (!empty($content))
                {{@$content['icdix_tindakan']}}
              @else
                <ul>
                  {{-- @foreach ($icd9 as $icd)
                    <li>{{baca_icd9($icd->icd9)}} - {{$icd->icd9}}</li>
                  @endforeach --}}
                  @foreach ($icd9_jkn as $icd)
                    <li>{{baca_icd9($icd->icd9)}}</li>
                  @endforeach
                </ul>
              @endif
          </td>
        </tr>
        <tr>
          <td>
              <b>PENGOBATAN</b>
          </td>
          <td colspan="5">
            @if (!empty($content))
              {{@$content['pengobatan']}}
            @else
              @foreach (@$obats as $obat)
              - {{ substr(strtoupper(baca_obat(@$obat->masterobat_id)), 0, 40) }}<br>
              @endforeach
            @endif
          </td>
        </tr>

    </table>
    <div class="page_break_after"></div>
    <table>
      <tr>
        <td>
            <b>CARA PULANG</b>
        </td>
        @php
          if ($soap) {
            @$assesments  = @json_decode(@$soap->fisik, true);
          } elseif ($cppt) {
            @$assesments  = @json_decode(@$cppt->discharge, true);
          }
        @endphp
        <td colspan="5">
          @if (!empty($content))
            {{@$content['cara_pulang']}} - {{ @$content['kondisi_pulang'] }}
          @else
                <input type="checkbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                <input type="checkbox" name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB" {{@$assesments['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                <input type="checkbox" name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat" {{@$assesments['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                <input type="checkbox" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesments['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                <input type="checkbox" name="fisik[dischargePlanning][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesments['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                <input type="checkbox" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesments['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                <input type="checkbox" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesments['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
          @endif
        </td>
      </tr>

    @if (@$reg->poli_id == 6)
      @if (@$gambar2->image != null)
      
          <tr>
            <td colspan="6" style="text-align: center;">
              <b>GAMBAR STATUS LOKALIS 2</b>
              <br/><br/><br>

              <img src="{{ public_path('images/'.@$gambar2->image) }}" alt="" style="width: 300px; height: 100px;">
              <br><br>
              {{ @$soaps['lokalis2']['keterangan'] }}
              {{-- <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
            </td>
          </tr>
        @endif
        @if (@$gambar3->image != null)
          <tr>
            <td colspan="6" style="text-align: center;">
              <b>GAMBAR STATUS LOKALIS 3</b>
              <br/><br/><br>
              <img src="{{ public_path('images/'.@$gambar3->image) }}" alt="" style="width: 300px; height: 100px;">
              <br><br>
              {{ @$soaps['lokalis3']['keterangan'] }}
              {{-- <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
            </td>
          </tr>
        @endif
        @if (@$gambar1->image != null)
          <tr>
            <td colspan="6" style="text-align: center;">
              @if (@$gambar1->image != null)
                        <img src="{{ public_path('images/'.@$gambar1->image) }}" alt="" style="height: 420px;">
              @endif
            </td>
          </tr>
        @endif
    @endif
    </table>
    <br>
    @php
        $ttd = \Modules\Pasien\Entities\Pasien::where('id', $reg->pasien_id)->first();
        $sign_pad = App\TandaTangan::where('registrasi_id', $reg->id)->where('jenis_dokumen', 'e-resume')->orderBy('id', 'DESC')->first();
    @endphp
    <table style="border: 0px; margin-top: 3rem;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px; width: 60%;">
          @if (ttdPasienBpjs($reg->created_at))
            Tanda Tangan Pasien / Keluarga atau Wali
          @elseif ($sign_pad)
            @if ($sign_pad->nama_penanggung_jawab)
              Tanda Tangan Keluarga atau Wali
            @else
              Tanda Tangan Pasien
            @endif
          @endif
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          Dokter
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;height: 1cm;">
          @if (ttdPasienBpjs($reg->created_at))
            @if (@$ttd->tanda_tangan)
              <img src="{{public_path('images/upload/ttd/' . $ttd->tanda_tangan)}}" alt="ttd" width="200" height="100">
            @endif
          @elseif ($sign_pad)
            @if (@$sign_pad->tanda_tangan)
              <img src="{{public_path('images/upload/ttd/' . $sign_pad->tanda_tangan)}}" alt="ttd" width="200" height="100">
            @endif
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
          @if (ttdPasienBpjs($reg->created_at))
            {{ @$reg->pasien->nama }}
          @elseif ($sign_pad)
            @if ($sign_pad->nama_penanggung_jawab)
              {{ @$sign_pad->nama_penanggung_jawab }}
            @else
              {{ @$reg->pasien->nama }}
            @endif
          @endif
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ @$dokter->nama }}
        </td>
      </tr>
    </table>
  </body>
</html>
 