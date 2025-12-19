<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0;
          /* margin-left: 0.3cm; */
      }
      .border {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>

  </head>
  <body>
    @php
    $laporan = @json_decode(@$laporan->fisik, true);
  @endphp
  <div class="col-md-12">
    <h5 class="text-center"><b>CATATAN PERSALINAN</b></h5>
    <table style="width:100%">
      <tr>
        <td style="width:100px;">NAMA</td>
        <td>: {{@$reg->pasien->nama}}</td>

        <td>TGLLAHIR/UMUR</td>
        <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
      </tr>
      <div class="row">
        <div class="col-md-6">
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
               <tr>
                    <td style="font-weight: bold">Tanggal</td>
                    <td>
                      {{@$laporan['tanggal']}}
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">Nama bidan</td>
                    <td>
                      {{@$laporan['nama_bidan']}}
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">Tempat Persalinan</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[tempat_persalinan][pilihan]"
                                {{ @$laporan['tempat_persalinan']['pilihan'] == 'Rumbah Ibu' ? 'checked' : '' }}
                                type="radio" value="Rumbah Ibu">
                            <label class="form-check-label" style="font-weight: 400;">Rumbah Ibu</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[tempat_persalinan][pilihan]"
                                {{ @$laporan['tempat_persalinan']['pilihan'] == 'Polindes' ? 'checked' : '' }}
                                type="radio" value="Polindes">
                            <label class="form-check-label" style="font-weight: 400;">Polindes</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[tempat_persalinan][pilihan]"
                                {{ @$laporan['tempat_persalinan']['pilihan'] == 'Klinik Swasta' ? 'checked' : '' }}
                                type="radio" value="Klinik Swasta">
                            <label class="form-check-label" style="font-weight: 400;">Klinik Swasta</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[tempat_persalinan][pilihan]"
                                {{ @$laporan['tempat_persalinan']['pilihan'] == 'Puskesmas' ? 'checked' : '' }}
                                type="radio" value="Puskesmas">
                            <label class="form-check-label" style="font-weight: 400;">Puskesmas</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[tempat_persalinan][pilihan]"
                                {{ @$laporan['tempat_persalinan']['pilihan'] == 'Rumah Sakit' ? 'checked' : '' }}
                                type="radio" value="Rumah Sakit">
                            <label class="form-check-label" style="font-weight: 400;">Rumah Sakit</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[tempat_persalinan][pilihan]"
                                {{ @$laporan['tempat_persalinan']['pilihan'] == 'Lainnya' ? 'checked' : '' }}
                                type="radio" value="Lainnya">
                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                            {{@$laporan['tempat_persalinan']['pilihan_lainnya']}}
                        </div>
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">ALamat tempat persalinan</td>
                    <td>
                      {{@$laporan['alamat_persalinan']}}
                    </td>
                </tr>
               <tr>
                    <td style="font-weight: bold">Catatan: rujuk, kala</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[catatan][pilihan]"
                                {{ @$laporan['catatan']['pilihan'] == 'I' ? 'checked' : '' }}
                                type="radio" value="I">
                            <label class="form-check-label" style="font-weight: 400;">I</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[catatan][pilihan]"
                                {{ @$laporan['catatan']['pilihan'] == 'II' ? 'checked' : '' }}
                                type="radio" value="II">
                            <label class="form-check-label" style="font-weight: 400;">II</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[catatan][pilihan]"
                                {{ @$laporan['catatan']['pilihan'] == 'III' ? 'checked' : '' }}
                                type="radio" value="III">
                            <label class="form-check-label" style="font-weight: 400;">III</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[catatan][pilihan]"
                                {{ @$laporan['catatan']['pilihan'] == 'IV' ? 'checked' : '' }}
                                type="radio" value="IV">
                            <label class="form-check-label" style="font-weight: 400;">IV</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Alasan merujuk:</td>
                    <td>
                      {{@$laporan['alasan_merujuk']}}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Tempat rujukan:</td>
                    <td>
                      {{@$laporan['tempat_rujukan']}}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Pendamping pada saat merujuk:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pendamping][pilihan]"
                                {{ @$laporan['pendamping']['pilihan'] == 'Bidan' ? 'checked' : '' }}
                                type="radio" value="Bidan">
                            <label class="form-check-label" style="font-weight: 400;">Bidan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pendamping][pilihan]"
                                {{ @$laporan['pendamping']['pilihan'] == 'Suami' ? 'checked' : '' }}
                                type="radio" value="Suami">
                            <label class="form-check-label" style="font-weight: 400;">Suami</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pendamping][pilihan]"
                                {{ @$laporan['pendamping']['pilihan'] == 'Keluarga' ? 'checked' : '' }}
                                type="radio" value="Keluarga">
                            <label class="form-check-label" style="font-weight: 400;">Keluarga</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pendamping][pilihan]"
                                {{ @$laporan['pendamping']['pilihan'] == 'Teman' ? 'checked' : '' }}
                                type="radio" value="Teman">
                            <label class="form-check-label" style="font-weight: 400;">Teman</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pendamping][pilihan]"
                                {{ @$laporan['pendamping']['pilihan'] == 'Dukun' ? 'checked' : '' }}
                                type="radio" value="Dukun">
                            <label class="form-check-label" style="font-weight: 400;">Dukun</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pendamping][pilihan]"
                                {{ @$laporan['pendamping']['pilihan'] == 'Tidak ada' ? 'checked' : '' }}
                                type="radio" value="Tidak ada">
                            <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                        </div>
                    </td>
                </tr>
            </table>

            <h5><b>KALA I</b></h5>
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
               <tr>
                    <td style="font-weight: bold">Partograf melewati gariw waspada:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_1][partograf_melewati_garis_waspada][pilihan]"
                                {{ @$laporan['kala_1']['partograf_melewati_garis_waspada'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_1][partograf_melewati_garis_waspada][pilihan]"
                                {{ @$laporan['kala_1']['partograf_melewati_garis_waspada'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">Masalah lain, sebutkan:</td>
                    <td>
                      {{@$laporan['kala_1']['masalah_lain']}}
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">Penatalaksanaan masalah tsb:</td>
                    <td>
                      {{@$laporan['kala_1']['penatalaksanaan_masalah']}}
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">Hasilnya:</td>
                    <td>
                      {{@$laporan['kala_1']['hasilnya']}}
                    </td>
               </tr>
            </table>

            <h5><b>KALA II</b></h5>
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
               <tr>
                    <td style="font-weight: bold">Episiotomi:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][episiotomi][pilihan]"
                                {{ @$laporan['kala_2']['episiotomi'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, indikasi</label>
                            {{@$laporan['kala_2']['episiotomi']['pilihan_ya']}}
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][episiotomi][pilihan]"
                                {{ @$laporan['kala_2']['episiotomi'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">Pendamping pada saat persalinan:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][pendamping][pilihan]"
                                {{ @$laporan['kala_2']['pendamping']['pilihan'] == 'Suami' ? 'checked' : '' }}
                                type="radio" value="Suami">
                            <label class="form-check-label" style="font-weight: 400;">Suami</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][pendamping][pilihan]"
                                {{ @$laporan['kala_2']['pendamping']['pilihan'] == 'Keluarga' ? 'checked' : '' }}
                                type="radio" value="Keluarga">
                            <label class="form-check-label" style="font-weight: 400;">Keluarga</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][pendamping][pilihan]"
                                {{ @$laporan['kala_2']['pendamping']['pilihan'] == 'Teman' ? 'checked' : '' }}
                                type="radio" value="Teman">
                            <label class="form-check-label" style="font-weight: 400;">Teman</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][pendamping][pilihan]"
                                {{ @$laporan['kala_2']['pendamping']['pilihan'] == 'Dukun' ? 'checked' : '' }}
                                type="radio" value="Dukun">
                            <label class="form-check-label" style="font-weight: 400;">Dukun</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][pendamping][pilihan]"
                                {{ @$laporan['kala_2']['pendamping']['pilihan'] == 'Tidak ada' ? 'checked' : '' }}
                                type="radio" value="Tidak ada">
                            <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Gawat janin:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][gawat_janin][pilihan]"
                                {{ @$laporan['kala_2']['gawat_janin'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, tindakan yang dilakukan</label>
                            {{@$laporan['kala_2']['gawat_janin']['pilihan_ya_1']}} <br>
{{@$laporan['kala_2']['gawat_janin']['pilihan_ya_2']}} <br>
{{@$laporan['kala_2']['gawat_janin']['pilihan_ya_3']}} <br>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][gawat_janin][pilihan]"
                                {{ @$laporan['kala_2']['gawat_janin'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Distosia bahu:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][distosia_bahu][pilihan]"
                                {{ @$laporan['kala_2']['distosia_bahu'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, tindakan yang dilakukan</label>
                            {{@$laporan['kala_2']['distosia_bahu']['pilihan_ya_1']}} <br>
{{@$laporan['kala_2']['distosia_bahu']['pilihan_ya_2']}} <br>
{{@$laporan['kala_2']['distosia_bahu']['pilihan_ya_3']}} <br>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_2][distosia_bahu][pilihan]"
                                {{ @$laporan['kala_2']['distosia_bahu'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Masalah lain, sebutkan:</td>
                    <td>
                      {{@$laporan['kala_2']['masalah_lain']}}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Penatalaksanaan masalah tersebut:</td>
                    <td>
                      {{@$laporan['kala_2']['penatalaksanaan']}}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Hasilnya:</td>
                    <td>
                      {{@$laporan['kala_2']['hasilnya']}}
                    </td>
                </tr>
            </table>

            <h5><b>KALA III</b></h5>
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
               <tr>
                    <td style="font-weight: bold">Lama kala III (Menit):</td>
                    <td>
                      {{@$laporan['kala_3']['lama_kala']}}
                    </td>
               </tr>
               <tr>
                    <td style="font-weight: bold">Pemberian Oktsithosin 10 U M ?:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][pemberian_oktsithosin][pilihan]"
                                {{ @$laporan['kala_3']['pemberian_oktsithosin']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                            {{@$laporan['kala_3']['pemberian_oktsithosin']['pilihan_ya']}}
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][pemberian_oktsithosin][pilihan]"
                                {{ @$laporan['kala_3']['pemberian_oktsithosin']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                            {{@$laporan['kala_3']['pemberian_oktsithosin']['pilihan_tidak']}}
                        </div>
                    </td>
                </tr>
               <tr>
                    <td style="font-weight: bold">Pemberian ulang Oktsithosin ?:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][pemberian_ulang_oktsithosin][pilihan]"
                                {{ @$laporan['kala_3']['pemberian_ulang_oktsithosin']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                            {{@$laporan['kala_3']['pemberian_ulang_oktsithosin']['pilihan_ya']}}
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][pemberian_ulang_oktsithosin][pilihan]"
                                {{ @$laporan['kala_3']['pemberian_ulang_oktsithosin']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                            {{@$laporan['kala_3']['pemberian_ulang_oktsithosin']['pilihan_tidak']}}
                        </div>
                    </td>
                </tr>
               <tr>
                    <td style="font-weight: bold">Penegangan tali pusat terkendali ?:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][penegangan_tali_pusat][pilihan]"
                                {{ @$laporan['kala_3']['penegangan_tali_pusat']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                            {{@$laporan['kala_3']['penegangan_tali_pusat']['pilihan_ya']}}
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][penegangan_tali_pusat][pilihan]"
                                {{ @$laporan['kala_3']['penegangan_tali_pusat']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                            {{@$laporan['kala_3']['penegangan_tali_pusat']['pilihan_tidak']}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                <tr>
                     <td style="font-weight: bold">Masase Fundus Uteri?:</td>
                     <td>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][masase_fundus_uteri][pilihan]"
                                 {{ @$laporan['kala_3']['masase_fundus_uteri']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                 type="radio" value="Ya">
                             <label class="form-check-label" style="font-weight: 400;">Ya</label>
                         </div>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][masase_fundus_uteri][pilihan]"
                                 {{ @$laporan['kala_3']['masase_fundus_uteri']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                 type="radio" value="Tidak">
                             <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                             {@$laporan['kala_3']['masase_fundus_uteri']['pilihan_tidak']}}
                         </div>
                     </td>
                 </tr>
                <tr>
                     <td style="font-weight: bold">Plasenta lahir lengkap?:</td>
                     <td>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][plasenta_lahir_lengkap][pilihan]"
                                 {{ @$laporan['kala_3']['plasenta_lahir_lengkap']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                 type="radio" value="Ya">
                             <label class="form-check-label" style="font-weight: 400;">Ya</label>
                         </div>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][plasenta_lahir_lengkap][pilihan]"
                                 {{ @$laporan['kala_3']['plasenta_lahir_lengkap']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                 type="radio" value="Tidak">
                             <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                         </div>
                         
                         <label class="form-check-label" style="font-weight: 400;">Jika tidak lengkap, tindakan yang dilakukan :</label>
                         {{@$laporan['kala_3']['plasenta_lahir_lengkap']['pilihan_tidak_1']}} <br>
{{@$laporan['kala_3']['plasenta_lahir_lengkap']['pilihan_tidak_2']}} <br>
{{@$laporan['kala_3']['plasenta_lahir_lengkap']['pilihan_tidak_3']}} <br>
                     </td>
                 </tr>
                <tr>
                     <td style="font-weight: bold">Plasenta tidak lahir > 30 menit?:</td>
                     <td>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][plasenta_tidak_lahir][pilihan]"
                                 {{ @$laporan['kala_3']['plasenta_tidak_lahir']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                 type="radio" value="Ya">
                             <label class="form-check-label" style="font-weight: 400;">Ya</label>
                         </div>
                         <label class="form-check-label" style="font-weight: 400;">Ya, Tindakan :</label>
                         {{@$laporan['kala_3']['plasenta_tidak_lahir']['pilihan_ya_1']}} <br>
{{@$laporan['kala_3']['plasenta_tidak_lahir']['pilihan_ya_2']}} <br>
{{@$laporan['kala_3']['plasenta_tidak_lahir']['pilihan_ya_3']}} <br>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][plasenta_tidak_lahir][pilihan]"
                                 {{ @$laporan['kala_3']['plasenta_tidak_lahir']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                 type="radio" value="Tidak">
                             <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                         </div>
                     </td>
                 </tr>
                <tr>
                     <td style="font-weight: bold">Lasensat:</td>
                     <td>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][lasensat][pilihan]"
                                 {{ @$laporan['kala_3']['lasensat']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                 type="radio" value="Ya">
                             <label class="form-check-label" style="font-weight: 400;">Ya, dimana</label>
                         </div>
                         {{@$laporan['kala_3']['lasensat']['pilihan_ya']}}
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][lasensat][pilihan]"
                                 {{ @$laporan['kala_3']['lasensat']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                 type="radio" value="Tidak">
                             <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                         </div>
                     </td>
                 </tr>
                <tr>
                     <td style="font-weight: bold">Jika lasersatperneum, derajat:</td>
                     <td>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                 {{ @$laporan['kala_3']['lasersatperneum_derajat']['pilihan'] == '1' ? 'checked' : '' }}
                                 type="radio" value="1">
                             <label class="form-check-label" style="font-weight: 400;">1</label>
                         </div>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                 {{ @$laporan['kala_3']['lasersatperneum_derajat']['pilihan'] == '2' ? 'checked' : '' }}
                                 type="radio" value="2">
                             <label class="form-check-label" style="font-weight: 400;">2</label>
                         </div>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                 {{ @$laporan['kala_3']['lasersatperneum_derajat']['pilihan'] == '3' ? 'checked' : '' }}
                                 type="radio" value="3">
                             <label class="form-check-label" style="font-weight: 400;">3</label>
                         </div>
                         <div>
                             <input class="form-check-input"
                                 name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                 {{ @$laporan['kala_3']['lasersatperneum_derajat']['pilihan'] == '4' ? 'checked' : '' }}
                                 type="radio" value="4">
                             <label class="form-check-label" style="font-weight: 400;">4</label>
                         </div>
                     </td>
                </tr>
                <tr>
                    <td>Tindakan:</td>
                    <td>
                      {@$laporan['kala_3']['lasersatperneum_derajat']['tindakan']}}
                    </td>
                </tr>
                <tr>
                    <td>Penjahitan:</td>
                    <td>
                      {@$laporan['kala_3']['lasersatperneum_derajat']['penjahitan']}}
                    </td>
                </tr>
                <tr>
                    <td>Tidak dijahit, alasan:</td>
                    <td>
                      {@$laporan['kala_3']['lasersatperneum_derajat']['alasan_tidak_dijahit']}}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Alonia Utari?:</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][alinea_utari][pilihan]"
                                {{ @$laporan['kala_3']['alinea_utari']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                        <label class="form-check-label" style="font-weight: 400;">Ya, Tindakan :</label>
                        {{@$laporan['kala_3']['alinea_utari']['pilihan_ya_1']}}
{{@$laporan['kala_3']['alinea_utari']['pilihan_ya_2']}}
{{@$laporan['kala_3']['alinea_utari']['pilihan_ya_3']}}
                        <div>
                            <input class="form-check-input"
                                name="fisik[kala_3][alinea_utari][pilihan]"
                                {{ @$laporan['kala_3']['alinea_utari']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Jumlah pendarahan (ml):</td>
                    <td>
                      {{@$laporan['kala_3']['jumlah_pendarahan']}}
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Masalah lain, sebutkan:</td>
                    <td>
                      {{@$laporan['kala_3']['masalah_lain']}}
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Hasilnya:</td>
                    <td>
                      {{@$laporan['kala_3']['hasilnya']}}
                    </td>
               </tr>
             </table>

             <h5><b>BAYI BARU LAHIR</b></h5>
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                <tr>
                    <td style="font-weight: bold">Berat badan (gram)</td>
                    <td>
                      {{@$laporan['bayi_baru_lahir']['berat_badan']}}
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Panjang</td>
                    <td>
                      {{@$laporan['bayi_baru_lahir']['panjang']}}
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Jenis Kelamin</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][jenis_kelamin][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['jenis_kelamin']['pilihan'] == 'L' ? 'checked' : '' }}
                                type="radio" value="L">
                            <label class="form-check-label" style="font-weight: 400;">L</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][jenis_kelamin][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['jenis_kelamin']['pilihan'] == 'P' ? 'checked' : '' }}
                                type="radio" value="P">
                            <label class="form-check-label" style="font-weight: 400;">P</label>
                        </div>
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Penilaian bayi baru lahir</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][penilaian_bayi_lahir][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['penilaian_bayi_lahir']['pilihan'] == 'Baik' ? 'checked' : '' }}
                                type="radio" value="Baik">
                            <label class="form-check-label" style="font-weight: 400;">Baik</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][penilaian_bayi_lahir][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['penilaian_bayi_lahir']['pilihan'] == 'ada penyakit' ? 'checked' : '' }}
                                type="radio" value="ada penyakit">
                            <label class="form-check-label" style="font-weight: 400;">ada penyakit</label>
                        </div>
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Bayi Lahir</td>
                    <td>
                        &nbsp;
                    </td>
               </tr>
                <tr>
                    <td>Normal tindakan</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Mengeringkan' ? 'checked' : '' }}
                                type="radio" value="Mengeringkan">
                            <label class="form-check-label" style="font-weight: 400;">Mengeringkan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Menghangatkan' ? 'checked' : '' }}
                                type="radio" value="Menghangatkan">
                            <label class="form-check-label" style="font-weight: 400;">Menghangatkan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Rangsangan' ? 'checked' : '' }}
                                type="radio" value="Rangsangan">
                            <label class="form-check-label" style="font-weight: 400;">Rangsangan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Bungkus bayi dan tempatkan di sisi ibu' ? 'checked' : '' }}
                                type="radio" value="Bungkus bayi dan tempatkan di sisi ibu">
                            <label class="form-check-label" style="font-weight: 400;">Bungkus bayi dan tempatkan di sisi ibu</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'tindakan pencegahan infeksi mata' ? 'checked' : '' }}
                                type="radio" value="tindakan pencegahan infeksi mata">
                            <label class="form-check-label" style="font-weight: 400;">tindakan pencegahan infeksi mata</label>
                        </div>
                    </td>
               </tr>
                <tr>
                    <td>Aspliksis ringan / pucat / biru / lemas, tindakan</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Mengeringkan' ? 'checked' : '' }}
                                type="radio" value="Mengeringkan">
                            <label class="form-check-label" style="font-weight: 400;">Mengeringkan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Menghangatkan' ? 'checked' : '' }}
                                type="radio" value="Menghangatkan">
                            <label class="form-check-label" style="font-weight: 400;">Menghangatkan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Rangsangan' ? 'checked' : '' }}
                                type="radio" value="Rangsangan">
                            <label class="form-check-label" style="font-weight: 400;">Rangsangan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Bungkus bayi dan tempatkan di sisi ibu' ? 'checked' : '' }}
                                type="radio" value="Bungkus bayi dan tempatkan di sisi ibu">
                            <label class="form-check-label" style="font-weight: 400;">Bungkus bayi dan tempatkan di sisi ibu</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'bebaskan jalan napas' ? 'checked' : '' }}
                                type="radio" value="bebaskan jalan napas">
                            <label class="form-check-label" style="font-weight: 400;">bebaskan jalan napas</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'lain lain' ? 'checked' : '' }}
                                type="radio" value="lain lain">
                            <label class="form-check-label" style="font-weight: 400;">lain lain, sebutkan</label>
                            {{@$laporan['bayi_lahir']['normal_tindakan']['pilihan_lain']}}
                        </div>
                    </td>
               </tr>
               <tr>
                        <td style="font-weight: bold">Cacat bawaan, sebutkan</td>
                        <td>
                          {{@$laporan['bayi_baru_lahir']['bayi_lahir']['cacat_bawaan']}}
                        </td>
                </tr>
               <tr>
                        <td style="font-weight: bold">Hipotermia, tindakan</td>
                        <td>
                          {{@$laporan['bayi_baru_lahir']['bayi_lahir']['hipotermia_1']}} <br>
{{@$laporan['bayi_baru_lahir']['bayi_lahir']['hiportemia_2']}} <br>
{{@$laporan['bayi_baru_lahir']['bayi_lahir']['hiportemia_3']}} <br>
                        </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Pemberian ASI</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][pemberian_asi][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['pemberian_asi']['pilihan'] == 'Ya, waktu' ? 'checked' : '' }}
                                type="radio" value="Ya, waktu">
                            <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                            {{@$laporan['bayi_baru_lahir']['pemberian_asi']['pilihan_ya']}}
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[bayi_baru_lahir][pemberian_asi][pilihan]"
                                {{ @$laporan['bayi_baru_lahir']['pemberian_asi']['pilihan'] == 'Tidak, alasan' ? 'checked' : '' }}
                                type="radio" value="Tidak, alasan">
                            <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                            {{@$laporan['bayi_baru_lahir']['pemberian_asi']['pilihan_tidak']}}
                        </div>
                    </td>
              </tr>
              <tr>
                      <td style="font-weight: bold">Masalah lain, sebutkan</td>
                      <td>
                        {{@$laporan['bayi_baru_lahir']['masalah_lain']['sebutkan']}}
                      </td>
              </tr>
              <tr>
                      <td style="font-weight: bold">Hasilnya</td>
                      <td>
                        {{@$laporan['bayi_baru_lahir']['hasilnya']['jelaskan']}}
                      </td>
              </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5><b>PEMANTAUAN PERSALINAN KALA IV</b></h5>
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                <tr>
                    <td>Jam Ke</td>
                    <td>Waktu</td>
                    <td>Tekanan darah</td>
                    <td>Nadi</td>
                    <td>Temperatur</td>
                    <td>Tinggi Fundus Utari</td>
                    <td>Konstraksi Utarus</td>
                    <td>Kandung Kemih</td>
                    <td>Pendarahan</td>
                </tr>
                <tr>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['jam_ke'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['waktu'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['tekanan_darah'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['nadi'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['temperatur'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['tinggi_fundus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['konstraksi_utarus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['kandung_kamuh'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_1']['pendarahan'] ?? '&nbsp;'}}
                    </td>
                </tr>
                <tr>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['jam_ke'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['waktu'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['tekanan_darah'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['nadi'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['temperatur'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['tinggi_fundus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['konstraksi_utarus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['kandung_kamuh'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_2']['pendarahan'] ?? '&nbsp;'}}
                    </td>
                </tr>
                <tr>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['jam_ke'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['waktu'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['tekanan_darah'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['nadi'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['temperatur'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['tinggi_fundus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['konstraksi_utarus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['kandung_kamuh'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_3']['pendarahan'] ?? '&nbsp;'}}
                    </td>
                </tr>
                <tr>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['jam_ke'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['waktu'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['tekanan_darah'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['nadi'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['temperatur'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['tinggi_fundus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['konstraksi_utarus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['kandung_kamuh'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_4']['pendarahan'] ?? '&nbsp;'}}
                    </td>
                </tr>
                <tr>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['jam_ke'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['waktu'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['tekanan_darah'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['nadi'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['temperatur'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['tinggi_fundus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['konstraksi_utarus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['kandung_kamuh'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_5']['pendarahan'] ?? '&nbsp;'}}
                    </td>
                </tr>
                <tr>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['jam_ke'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['waktu'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['tekanan_darah'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['nadi'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['temperatur'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['tinggi_fundus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['konstraksi_utarus'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['kandung_kamuh'] ?? '&nbsp;'}}
                    </td>
                    <td>
                      {{@$laporan['pemantauan_persalinan_kala_iv']['param_6']['pendarahan'] ?? '&nbsp;'}}
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold">Masalah Kala IV:</td>
                    <td colspan="9">
                      {{@$laporan['pemantauan_persalinan_kala_iv']['masalah_kala_iv']}}
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Penatalaksanaan yang dilakukan untuk masalah tersebut:</td>
                    <td colspan="9">
                      {{@$laporan['pemantauan_persalinan_kala_iv']['penatalaksanaan']}}
                    </td>
               </tr>
                <tr>
                    <td style="font-weight: bold">Bagaimana hasilnya:</td>
                    <td colspan="9">
                      {{@$laporan['pemantauan_persalinan_kala_iv']['hasilnya']}}
                    </td>
               </tr>
            </table>
        </div>
    </div>
      <tr>
        <td>RUANG</td>
        <td>: {{@baca_poli($reg->poli_id)}}</td>
        <td>TANGGAL</td>
        <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td>
      </tr>
    </table>
  </div>
  </body>
</html>