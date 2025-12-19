<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Pasien</title>
    <style>
        /* table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        } */
        th, td {
            padding: 15px;
            /* text-align: left; */
        }

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
    @php
        error_reporting(0);
        libxml_use_internal_errors(true);
        // dd("A");
    @endphp

    
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif

    <table style="border: none !important; width:100%;font-size:12px;"> 
        <tr>
          <td style="width:10%; text-align: center; width: 30%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 25px;"> <br>
            <b style="font-size:8px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
            <b style="font-size:6px; font-weight:normal;"> {{ configrs()->tlp }}</b><br/>
            <b style="font-size:6px; font-weight:normal;"> Laman : {{ configrs()->website }} <span style="font-size:5px; margin-left:5px">Email : {{ configrs()->email }}</span></b><br/>
          </td>
          <td style="text-align: center; width: 30%; vertical-align: middle;">
              <h2 class="text-center" style="margin-top: -3rem; vertical-align: middle;">RESUME MEDIS PASIEN PULANG</h2>
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

      <table style="border: 1px solid black; width:100%;font-size:12px; margin-top: -5rem;"> 
        <tr>
            <td style="padding: .3rem; width: 20%">Tanggal masuk</td>
            <td style="padding: .3rem; width: 1%">:</td>
            <td style="padding: .3rem">{{date('d-m-Y', strtotime(@$registrasi->tgl_sep)) ?? date('d-m-Y H:i:s', strtotime(@$registrasi->rawat_inap->tgl_masuk))}}</td>
            <td style="padding: .3rem; width: 20%">Tanggal kontrol</td>
            <td style="padding: .3rem; width: 1%">:</td>
            <td style="padding: .3rem">{{@$content['tanggal_kontrol']}}</td>
        </tr>
        <tr>
            <td style="padding: .3rem; width: 20%">Tanggal keluar</td>
            <td style="padding: .3rem; width: 1%">:</td>
            {{-- <td style="padding: .3rem">{{date('d-m-Y H:i:s', strtotime(@$resume->created_at))}}</td> --}}
            <td style="padding: .3rem">{{date('d-m-Y H:i:s', strtotime(@$registrasi->rawat_inap->tgl_keluar))}}</td>
            <td style="padding: .3rem; width: 20%">Tujuan poliklinik</td>
            <td style="padding: .3rem; width: 1%">:</td>
            <td style="padding: .3rem">{{@$content['tujuan_poliklinik']}}</td>
        </tr>
      </table>
      <table style="border: 1px solid black; width:100%;font-size:12px;"> 
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>INDIKASI RAWAT INAP :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{{@$content['indikasi_rawat_inap']}}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%"><b>RINGKASAN RIWAYAT PENYAKIT :</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['ringkasan_riwayat_penyakit'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%"><b>PEMERIKSAAN FISIK :</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['pemeriksaan_fisik'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%"><b>PEMERIKSAAN PENUNJANG :</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['pemeriksaan_penunjang'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%"><b>TERAPI / PENGOBATAN SELAMA DI RUMAH SAKIT :</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['terapi_di_rumah_sakit'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%"><b>CATATAN :</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! nl2br(e(@$content['catatan'])) !!}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>REAKSI OBAT :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%;">
              <div style="display: inline-block;">
                <div style="vertical-align: middle; display: inline-block">
                    <input class="form-check-input"
                      style="vertical-align: middle;"
                        {{ @$content['pasien_usia_lanjut']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                        type="checkbox" value="Tidak">
                    <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Tidak</label>
                </div>
                <div style="vertical-align: middle; display: inline-block">
                    <input class="form-check-input"
                      style="vertical-align: middle;"
                        {{ @$content['pasien_usia_lanjut']['pilihan'] == 'Ya' ? 'checked' : '' }}
                        type="checkbox" value="Ya">
                    <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Ya</label>
                      {{@$content['pasien_usia_lanjut']['pilihan_ya']}}
                </div>
              </div>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>DIAGNOSA UTAMA :</b></td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>ICD X :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{{@$content['diagnosa_utama']}}</p>
            </td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{{@$content['icdx_diagnosa_utama'] ? @$content['icdx_diagnosa_utama'] : $icd10Primary_jkn->icd10.' '.baca_icd10(@$icd10Primary_jkn->icd10) }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>DIAGNOSA TAMBAHAN :</b></td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>ICD X :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">- {{@$content['diagnosa_tambahan']}}</p>
                @if (is_array(@$content['tambahan_diagnosa_tambahan']))
                  @foreach (@$content['tambahan_diagnosa_tambahan'] as $key => $diagnosa_tambahan)
                    <p style="margin: 0; padding: 0;">- {{@$content['tambahan_diagnosa_tambahan'][$key]}}</p>
                  @endforeach
                @endif
            </td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">
                  @if (@$icd10Secondary_jkn)
                    <ul>
                        @foreach (@$icd10Secondary_jkn as $icd)
                            <li>{{baca_icd10(@$icd->icd10)}}</li>
                        @endforeach
                    </ul>
                  @endif
                  {{-- - {{@$content['icdx_diagnosa_tambahan']}}</p> --}}
                {{-- @if (is_array(@$content['tambahan_icdx_diagnosa_tambahan']))
                  @foreach (@$content['tambahan_icdx_diagnosa_tambahan'] as $key => $icdx_diagnosa_tambahan)
                    <p style="margin: 0; padding: 0;">- {{@$content['tambahan_icdx_diagnosa_tambahan'][$key]}}</p>
                  @endforeach
                @endif --}}
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>TINDAKAN / PROSEDUR / OPERASI :</b></td>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>ICD IX :</b> {{@$content['icdix_tindakan']}}</td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
              <p style="margin: 0; padding: 0;">
                  {!! str_replace(',', '<br>', @$content['tindakan']) !!}
              </p>
              <p style="margin: 0; padding: 0;">
                  {!! is_array(@$content['tambahan_tindakan']) ? implode('<br>', @$content['tambahan_tindakan']) : str_replace(',', '<br>', @$content['tambahan_tindakan']) !!}
              </p>
            </td>        
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
              @if (count($icd9) > 0)
                <ul>
                  @foreach ($icd9 as $jkns9)
                    <li>{{$jkns9->icd9}} - {{baca_prosedur($jkns9->icd9)}}</li>
                  @endforeach
                </ul>
              @endif
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>INSTRUKSI PERAWAT LANJUTAN / EDUKASI :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{{@$content['edukasi']}}</p>
                <br>
                <p>Cara Pulang : </p>
                <div style="display: inline-block;">
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'Izin dokter' ? 'checked' : '' }}
                          type="checkbox" value="Izin dokter">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Izin dokter</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'Pindah RS' ? 'checked' : '' }}
                          type="checkbox" value="Pindah RS">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Pindah RS</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'APS' ? 'checked' : '' }}
                          type="checkbox" value="APS">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">APS</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['cara_pulang'] == 'Melariksan Diri' ? 'checked' : '' }}
                          type="checkbox" value="Melariksan Diri">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Melarikan Diri</label>
                  </div>
                </div>
                <br>
                <p>Kondisi Saat Pulang : </p>
                <div style="display: inline-block;">
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Sembuh' ? 'checked' : '' }}
                          type="checkbox" value="Sembuh">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Sembuh</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Perbaikan' ? 'checked' : '' }}
                          type="checkbox" value="Perbaikan">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Perbaikan</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Tidak sembuh' ? 'checked' : '' }}
                          type="checkbox" value="Tidak sembuh">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Tidak sembuh</label>
                  </div>
                  <div style="vertical-align: middle; display: inline-block">
                      <input class="form-check-input"
                        style="vertical-align: middle;"
                          {{ @$content['kondisi_pulang'] == 'Meninggal' ? 'checked' : '' }}
                          type="checkbox" value="Meninggal">
                      <label class="form-check-label" style="font-weight: 400; display: inline-block; vertical-align: middle;">Meninggal</label>
                  </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%"><b>TERAPI PULANG :</b></td>
        </tr>
        <tr>
            <td style="padding: .3rem 0 0 .3rem; width: 20%">
                <p style="margin: 0; padding: 0;">{!! nl2br(htmlspecialchars(@$content['terapi_pulang_detail'])) !!}</p>
            </td>
        </tr>
      </table>
      <table style="width: 100%; font-size: 12px;">
        @php
            $ttd_pasien = App\TandaTangan::where('registrasi_id', $resume->registrasi_id)->orderBy('id', 'DESC')->first();
            $sign_pad = App\TandaTangan::where('registrasi_id', $registrasi->id)->where('jenis_dokumen', 'e-resume')->orderBy('id', 'DESC')->first();
        @endphp
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="text-center">Soreang, {{date('d-m-Y', strtotime(@$resume->created_at))}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-center">
                  @if (ttdPasienBpjs($registrasi->created_at))
                    Tanda Tangan Pasien / Keluarga atau Wali
                  @elseif ($sign_pad)
                    @if ($sign_pad->nama_penanggung_jawab)
                      Tanda Tangan Keluarga atau Wali
                    @else
                      Tanda Tangan Pasien
                    @endif
                  @endif
                </td>
                <td>&nbsp;</td>
                <td class="text-center">Dokter penanggung jawab</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-center">
                  {{-- @if ($ttd_pasien)
                    <img src="{{public_path('images/upload/ttd/' . @$ttd_pasien->tanda_tangan)}}" alt="ttd" width="200" height="100">
                  @endif --}}
                  @if (ttdPasienBpjs($registrasi->created_at))
                    @if (@$ttd_pasien->tanda_tangan)
                      <img src="{{public_path('images/upload/ttd/' . $ttd_pasien->tanda_tangan)}}" alt="ttd" width="200" height="100">
                    @endif
                  @elseif ($sign_pad)
                    @if (@$sign_pad->tanda_tangan)
                      <img src="{{public_path('images/upload/ttd/' . $sign_pad->tanda_tangan)}}" alt="ttd" width="200" height="100">
                    @endif
                  @endif
                </td>
                <td>&nbsp;</td>
                <td class="text-center">
                  {{-- @if (isset($proses_tte))
                    #
                  @elseif (isset($tte_nonaktif)) --}}
                    @php
                      $pegawai = \Modules\Pegawai\Entities\Pegawai::find($registrasi->rawat_inap->dokter_id);
                      $base64  = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$pegawai->nama . ' | ' . @$pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                  {{-- @else
                    @php
                      $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$registrasi->rawat_inap->dokter_ahli->nama . ' | ' . @$registrasi->rawat_inap->dokter_ahli->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                  @endif

                  @if (isset($proses_tte))
                    <br><br>
                  @endif --}}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-center">
                  @if ($sign_pad)
                    @if ($sign_pad->nama_penanggung_jawab)
                      {{ @$sign_pad->nama_penanggung_jawab }}
                    @else
                      {{ @$registrasi->pasien->nama }}
                    @endif
                  @elseif (ttdPasienBpjs($registrasi->created_at))
                    {{ @$registrasi->pasien->nama }}
                  @endif
                </td>
                <td>&nbsp;</td>
                <td class="text-center">{{baca_dokter(@$registrasi->rawat_inap->dokter_id)}}</td>
            </tr>
        </table>
  </body>
</html>
 