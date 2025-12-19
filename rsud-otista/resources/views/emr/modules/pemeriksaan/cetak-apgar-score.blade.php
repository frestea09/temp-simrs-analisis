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
    $apgar = @json_decode(@$apgarScore->fisik, true);
  @endphp
  <div class="col-md-12">
    <h5 class="text-center"><b>APGAR SCORE</b></h5>
    <table style="width:100%">
      <tr>
        <td style="width:100px;">NAMA</td>
        <td>: {{@$reg->pasien->nama}}</td>

        <td>TGLLAHIR/UMUR</td>
        <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
      </tr>
      
      <tr>
        <td>RUANG</td>
        <td>: {{@baca_poli($reg->poli_id)}}</td>
        <td>TANGGAL</td>
        <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td>
      </tr>
    </table>
    <table class="border" style="width: 100%;">
        <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Parameter</td>
            <td style="width: 10%;" class="border bold p-1 text-center">Nilai</td>
        </tr>
        <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Sikap tubuh</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$apgar['ballard_score']['sikap_tubuh']['nilai']}}
            </td>
        </tr>
        <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Persegi jendela (pergelangan tangan)</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$apgar['ballard_score']['persegi_jendela']['nilai']}}
            </td>
        </tr>
        <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Rekoli lengan</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$apgar['ballard_score']['rekoli_lengan']['nilai']}}
            </td>
        </tr>
        <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Sudut popliteal</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$apgar['ballard_score']['sudut_popliteal']['nilai']}}
            </td>
        </tr>
        <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Tanda selempang</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$apgar['ballard_score']['tanda_selempang']['nilai']}}
            </td>
        </tr>
        <tr class="border">
            <td style="width: 25%" class="border bold p-1 text-center">Tumit ke kuping</td>
            <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$apgar['ballard_score']['tumit_ke_kuping']['nilai']}}
            </td>
        </tr>
      </table>
    <table class="border" style="width: 100%; margin-top: 3rem;" id="table_terapi">
      <tr class="border">
          <td class="border bold p-1 text-center">KATEGORI</td>
          <td class="border bold p-1 text-center">1 MENIT</td>
          <td class="border bold p-1 text-center">5 MENIT</td>
          <td class="border bold p-1 text-center">10 MENIT</td>
          <td class="border bold p-1 text-center">>15 MENIT</td>
      </tr>
      <tr class="border">
          <td class="border p-1 text-center">Warna</td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['warna']['1_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['warna']['5_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['warna']['10_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['warna']['15_menit']}}
          </td>
      </tr>
      <tr class="border">
          <td class="border p-1 text-center">Denyut Jantung</td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['denyut_jantung']['1_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['denyut_jantung']['5_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['denyut_jantung']['10_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['denyut_jantung']['15_menit']}}
          </td>
      </tr>
      <tr class="border">
          <td class="border p-1 text-center">Reflek</td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['reflek']['1_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['reflek']['5_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['reflek']['10_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['reflek']['15_menit']}}
          </td>
      </tr>
      <tr class="border">
          <td class="border p-1 text-center">Tonus otot</td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['tonus_otot']['1_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['tonus_otot']['5_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['tonus_otot']['10_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['tonus_otot']['15_menit']}}
          </td>
      </tr>
      <tr class="border">
          <td class="border p-1 text-center">Pernapasan</td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['pernapasan']['1_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['pernapasan']['5_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['pernapasan']['10_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['pernapasan']['15_menit']}}
          </td>
      </tr>
      <tr class="border">
          <td class="border p-1 text-center bold">Jumlah</td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['jumlah']['1_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['jumlah']['5_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['jumlah']['10_menit']}}
          </td>
          <td class="border bold p-1 text-center">
            {{@$apgar['kategori']['jumlah']['15_menit']}}
          </td>
      </tr>
    </table>
    <table style="font-size:12px; width: 100%;" class="border">
        <tr>
            <td style="width:30%; font-weight:bold;" class="border">Obat-obatan</td>
            <td class="border">
                <div>
                    <input class="form-check-input"
                        name="fisik[obat_obatan][tidak_diberikan]"
                        {{ @$apgar['obat_obatan']['tidak_diberikan'] == 'Tidak diberikan' ? 'checked' : '' }}
                        type="checkbox" value="Tidak diberikan">
                    <label class="form-check-label" style="font-weight: 400;">Tidak diberikan</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[obat_obatan][hepatitis_b]"
                        {{ @$apgar['obat_obatan']['hepatitis_b'] == 'Hepatitis B' ? 'checked' : '' }}
                        type="checkbox" value="Hepatitis B">
                    <label class="form-check-label" style="font-weight: 400;">Hepatitis B</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[obat_obatan][salep_mata]"
                        {{ @$apgar['obat_obatan']['salep_mata'] == 'Salep mata' ? 'checked' : '' }}
                        type="checkbox" value="Salep mata">
                    <label class="form-check-label" style="font-weight: 400;">Salep mata</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[obat_obatan][cardiotonika]"
                        {{ @$apgar['obat_obatan']['cardiotonika'] == 'Cardiotonika' ? 'checked' : '' }}
                        type="checkbox" value="Cardiotonika">
                    <label class="form-check-label" style="font-weight: 400;">Cardiotonika</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[obat_obatan][antibiotika]"
                        {{ @$apgar['obat_obatan']['antibiotika'] == 'Antibiotika' ? 'checked' : '' }}
                        type="checkbox" value="Antibiotika">
                    <label class="form-check-label" style="font-weight: 400;">Antibiotika</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[obat_obatan][vitamin]"
                        {{ @$apgar['obat_obatan']['vitamin'] == 'Vitamin 1mg/0.5mg' ? 'checked' : '' }}
                        type="checkbox" value="Vitamin 1mg/0.5mg">
                    <label class="form-check-label" style="font-weight: 400;">Vitamin 1mg/0.5mg</label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:30%; font-weight:bold;" class="border">Tindakan Resusitasi</td>
            <td class="border">
                <div>
                    <input class="form-check-input"
                        name="fisik[resusitasi][resusitasi_tanpa_tindak_lanjut]"
                        {{ @$apgar['resusitasi']['resusitasi_tanpa_tindak_lanjut'] == 'Resusitasi tanpa tindak lanjut' ? 'checked' : '' }}
                        type="checkbox" value="Resusitasi tanpa tindak lanjut">
                    <label class="form-check-label" style="font-weight: bold;">Tidak</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[resusitasi][resusitasi_dengan_tindak_lanjut]"
                        {{ @$apgar['resusitasi']['resusitasi_dengan_tindak_lanjut'] == 'Resusitasi dengan tindak lanjut' ? 'checked' : '' }}
                        type="checkbox" value="Resusitasi dengan tindak lanjut">
                    <label class="form-check-label" style="font-weight: bold;">Ya</label>
                </div>
                <div style="margin-left: 1.5rem;">
                    <div>
                      <input class="form-check-input"
                          name="fisik[resusitasi][langkah_awal]"
                          {{ @$apgar['resusitasi']['langkah_awal'] == 'Langkah awal' ? 'checked' : '' }}
                          type="checkbox" value="Langkah awal">
                      <label class="form-check-label" style="font-weight: 400;">Langkah awal</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[resusitasi][perawatan_rutin]"
                          {{ @$apgar['resusitasi']['perawatan_rutin'] == 'Perawatan rutin' ? 'checked' : '' }}
                          type="checkbox" value="Perawatan rutin">
                      <label class="form-check-label" style="font-weight: 400;">Perawatan rutin</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[resusitasi][vtp]"
                          {{ @$apgar['resusitasi']['vtp'] == 'VTP' ? 'checked' : '' }}
                          type="checkbox" value="VTP">
                      <label class="form-check-label" style="font-weight: 400;">VTP</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[resusitasi][intubasi]"
                          {{ @$apgar['resusitasi']['intubasi'] == 'Intubasi' ? 'checked' : '' }}
                          type="checkbox" value="Intubasi">
                      <label class="form-check-label" style="font-weight: 400;">Intubasi</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[resusitasi][kompres_dada]"
                          {{ @$apgar['resusitasi']['kompres_dada'] == 'Kompres dada' ? 'checked' : '' }}
                          type="checkbox" value="Kompres dada">
                      <label class="form-check-label" style="font-weight: 400;">Kompres dada</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[resusitasi][obat_obatan]"
                          {{ @$apgar['resusitasi']['obat_obatan'] == 'Obat obatan' ? 'checked' : '' }}
                          type="checkbox" value="Obat obatan">
                      <label class="form-check-label" style="font-weight: 400;">Obat obatan</label>
                      <div style="margin-left: 1.5rem;">
                        1. {{@$apgar['resusitasi']['daftar_obat']['1'] ?? '-'}} <br>
                        2. {{@$apgar['resusitasi']['daftar_obat']['2'] ?? '-'}} <br>
                        3. {{@$apgar['resusitasi']['daftar_obat']['3'] ?? '-'}} <br>
                        4. {{@$apgar['resusitasi']['daftar_obat']['4'] ?? '-'}} <br>
                        5. {{@$apgar['resusitasi']['daftar_obat']['5'] ?? '-'}} <br>
                      </div>
                    </div>
                  </div>
            </td>
        </tr>
        <tr>
          <td style="font-weight:bold;" class="border" colspan="2">PEMERIKSAAN FISIK</td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Warna</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][warna][biasa]"
                      {{ @$apgar['pemeriksaan_fisik']['warna']['biasa'] == 'Biasa' ? 'checked' : '' }}
                      type="checkbox" value="Biasa">
                  <label class="form-check-label" style="font-weight: 400;">Biasa</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][warna][pucat]"
                      {{ @$apgar['pemeriksaan_fisik']['warna']['pucat'] == 'Pucat' ? 'checked' : '' }}
                      type="checkbox" value="Pucat">
                  <label class="form-check-label" style="font-weight: 400;">Pucat</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][warna][pletora]"
                      {{ @$apgar['pemeriksaan_fisik']['warna']['pletora'] == 'Pletora' ? 'checked' : '' }}
                      type="checkbox" value="Pletora">
                  <label class="form-check-label" style="font-weight: 400;">Pletora</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][warna][sianosis]"
                      {{ @$apgar['pemeriksaan_fisik']['warna']['sianosis'] == 'Sianosis' ? 'checked' : '' }}
                      type="checkbox" value="Sianosis">
                  <label class="form-check-label" style="font-weight: 400;">Sianosis</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][warna][ikterus]"
                      {{ @$apgar['pemeriksaan_fisik']['warna']['ikterus'] == 'Ikterus' ? 'checked' : '' }}
                      type="checkbox" value="Ikterus">
                  <label class="form-check-label" style="font-weight: 400;">Ikterus</label>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Pernapasan</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][pernapasan][frekuensi]"
                      {{ @$apgar['pemeriksaan_fisik']['pernapasan']['frekuensi'] == 'Frekuensi' ? 'checked' : '' }}
                      type="checkbox" value="Frekuensi">
                  <label class="form-check-label" style="font-weight: 400;">Frekuensi</label>
                  <span>Frekuensi x/menit</span>
                  {{@$apgar['pemeriksaan_fisik']['pernapasan']['frekuensi_detail']}}
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][pernapasan][tipe_abodminothoracal]"
                      {{ @$apgar['pemeriksaan_fisik']['pernapasan']['tipe_abodminothoracal'] == 'Tipe Abdomonithoracal' ? 'checked' : '' }}
                      type="checkbox" value="Tipe Abdomonithoracal">
                  <label class="form-check-label" style="font-weight: 400;">Tipe Abdomonithoracal</label>
                  {{@$apgar['pemeriksaan_fisik']['pernapasan']['tipe_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Keadaan umum</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][keadaan_umum][state]"
                      {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['state'] == 'State' ? 'checked' : '' }}
                      type="checkbox" value="State">
                  <label class="form-check-label" style="font-weight: 400;">State</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][keadaan_umum][1]"
                      {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['1'] == '1' ? 'checked' : '' }}
                      type="checkbox" value="1">
                  <label class="form-check-label" style="font-weight: 400;">1</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][keadaan_umum][2]"
                      {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['2'] == '2' ? 'checked' : '' }}
                      type="checkbox" value="2">
                  <label class="form-check-label" style="font-weight: 400;">2</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][keadaan_umum][3]"
                      {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['3'] == '3' ? 'checked' : '' }}
                      type="checkbox" value="3">
                  <label class="form-check-label" style="font-weight: 400;">3</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][keadaan_umum][4]"
                      {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['4'] == '4' ? 'checked' : '' }}
                      type="checkbox" value="4">
                  <label class="form-check-label" style="font-weight: 400;">4</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][keadaan_umum][5]"
                      {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['5'] == '5' ? 'checked' : '' }}
                      type="checkbox" value="5">
                  <label class="form-check-label" style="font-weight: 400;">5</label>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Kepala</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][kepala][simetris]"
                      {{ @$apgar['pemeriksaan_fisik']['kepala']['simetris'] == 'Simetris/Asimetris' ? 'checked' : '' }}
                      type="checkbox" value="Simetris/Asimetris">
                  <label class="form-check-label" style="font-weight: 400;">Simetris/Asimetris</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][kepala][caput]"
                      {{ @$apgar['pemeriksaan_fisik']['kepala']['caput'] == 'Caput Sukcadaneum' ? 'checked' : '' }}
                      type="checkbox" value="Caput Sukcadaneum">
                  <label class="form-check-label" style="font-weight: 400;">Caput Sukcadaneum</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][kepala][sefal_hematoma]"
                      {{ @$apgar['pemeriksaan_fisik']['kepala']['sefal_hematoma'] == 'Sefal hematoma' ? 'checked' : '' }}
                      type="checkbox" value="Sefal hematoma">
                  <label class="form-check-label" style="font-weight: 400;">Sefal hematoma</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][kepala][lain]"
                      {{ @$apgar['pemeriksaan_fisik']['kepala']['lain'] == 'Lain-lain' ? 'checked' : '' }}
                      type="checkbox" value="Lain-lain">
                  <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                  {{@$apgar['pemeriksaan_fisik']['kepala']['lain_detail']}}
              </div>
          </td>
        </tr>
        <tr>
        <td style="width:30%; font-weight:bold;">Fontanel</td>
        <td>
            <div>
                {{-- <span>Frekuensi</span> --}}
                <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][fontanel][frekuensi1]" value="{{@$apgar['pemeriksaan_fisik']['fontanel']['frekuensi1']}}" class="form-control" />x
                <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][fontanel][frekuensi2]" value="{{@$apgar['pemeriksaan_fisik']['fontanel']['frekuensi2']}}" class="form-control" /><br/>
                <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][fontanel][kelainan]" value="{{@$apgar['pemeriksaan_fisik']['fontanel']['kelainan']}}" class="form-control" />
            </div> 
        </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Fontanel</td>
          <td class="border">
            <div class="btn-group">
                {{@$apgar['pemeriksaan_fisik']['fontanel_1']}} x <br>
                {{@$apgar['pemeriksaan_fisik']['fontanel_2']}} cm <br>
            </div>
            <span>Kelainan</span>
            {{@$apgar['pemeriksaan_fisik']['fontanel_keterangan']}}
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Sutura</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][sutura][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['sutura']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][sutura][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['sutura']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['sutura']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Rambut</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][rambut][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['rambut']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][rambut][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['rambut']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['rambut']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Mata</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][mata][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['mata']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][mata][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['mata']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['mata']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Hidung</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][hidung][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['hidung']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][hidung][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['hidung']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['hidung']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Mulut</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][mulut][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['mulut']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][mulut][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['mulut']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['mulut']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Lidah</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][lidah][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['lidah']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][lidah][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['lidah']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['lidah']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Gigi</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][gigi][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['gigi']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][gigi][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['gigi']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['gigi']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Leher</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][leher][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['leher']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][leher][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['leher']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['leher']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
            <td style="width:30%; font-weight:bold;">Telinga</td>
            <td>
                <div>
                    <input class="form-check-input"
                        name="fisik[pemeriksaan_fisik][telinga][normal]"
                        {{ @$apgar['pemeriksaan_fisik']['telinga']['normal'] == 'Normal' ? 'checked' : '' }}
                        type="checkbox" value="Normal">
                    <label class="form-check-label" style="font-weight: 400;">Normal</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[pemeriksaan_fisik][telinga][tidak_normal]"
                        {{ @$apgar['pemeriksaan_fisik']['telinga']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                        type="checkbox" value="Tidak normal">
                    <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                    <input type="text" name="fisik[pemeriksaan_fisik][telinga][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['telinga']['tidak_normal_detail']}}" class="form-control" />
                </div>
            </td>
            </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Kulit</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][kulit][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['kulit']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][kulit][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['kulit']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['kulit']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Jaringan subkutis</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][jaringan_subkutis][kurang]"
                      {{ @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['kurang'] == 'Kurang' ? 'checked' : '' }}
                      type="checkbox" value="Kurang">
                  <label class="form-check-label" style="font-weight: 400;">Kurang</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][jaringan_subkutis][cukup]"
                      {{ @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['cukup'] == 'Cukup' ? 'checked' : '' }}
                      type="checkbox" value="Cukup">
                  <label class="form-check-label" style="font-weight: 400;">Cukup</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][jaringan_subkutis][tidak_ada]"
                      {{ @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                      type="checkbox" value="Tidak ada">
                  <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Genitalia</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][genitalia][l]"
                      {{ @$apgar['pemeriksaan_fisik']['genitalia']['l'] == 'L' ? 'checked' : '' }}
                      type="checkbox" value="L">
                  <label class="form-check-label" style="font-weight: 400;">L</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][genitalia][p]"
                      {{ @$apgar['pemeriksaan_fisik']['genitalia']['p'] == 'P' ? 'checked' : '' }}
                      type="checkbox" value="P">
                  <label class="form-check-label" style="font-weight: 400;">P</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][genitalia][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['genitalia']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][genitalia][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['genitalia']['tidak_normal'] == 'Tidak Normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak Normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak Normal</label>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Testiskulorum</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][testiskulorum][belum_lengkap]"
                      {{ @$apgar['pemeriksaan_fisik']['testiskulorum']['belum_lengkap'] == 'Belum lengkap' ? 'checked' : '' }}
                      type="checkbox" value="Belum lengkap">
                  <label class="form-check-label" style="font-weight: 400;">Belum lengkap</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][testiskulorum][lengkap]"
                      {{ @$apgar['pemeriksaan_fisik']['testiskulorum']['lengkap'] == 'Lengkap' ? 'checked' : '' }}
                      type="checkbox" value="Lengkap">
                  <label class="form-check-label" style="font-weight: 400;">Lengkap</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][testiskulorum][tidak_ada]"
                      {{ @$apgar['pemeriksaan_fisik']['testiskulorum']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                      type="checkbox" value="Tidak ada">
                  <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Neurologi</td>
          <td class="border">
              <div>
                  <span>Reflek Moro</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_moro_plus']}} / 
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_moro_minus']}}
                  </div>
              </div>
              <div>
                  <span>Reflek Hidap</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_hisap_plus']}} /
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_hisap_minus']}}
                  </div>
              </div>
              <div>
                  <span>Reflek Pegang</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_pegang_plus']}} / 
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_pegang_minus']}}
                  </div>
              </div>
              <div>
                  <span>Reflek Rooting</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_rooting_plus']}} /
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_rooting_minus']}}
                  </div>
              </div>
              <div>
                  <span>Reflek Babinsky</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_babynsky_plus']}} / 
                    {{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_babynsky_minus']}}
                  </div>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Toraks</td>
          <td class="border">
              <div>
                  <span>Bentuk</span>
                  {{@$apgar['pemeriksaan_fisik']['toraks']['bentuk']}}
              </div>
              <div>
                  <span>Pergerakan</span>
                  {{@$apgar['pemeriksaan_fisik']['toraks']['pergerakan']}}
              </div>
              <div>
                  <span>Retraksi Intercostal</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['toraks']['retraksi_intercostal_plus']}} / 
                    {{@$apgar['pemeriksaan_fisik']['toraks']['retraksi_intercostal_minus']}}
                  </div>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Paru-paru</td>
          <td class="border">
              <div>
                  <span>Suara pernafasan bronchovascular</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_pernapasan_plus']}} / 
                    {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_pernapasan_minus']}}
                  </div>
              </div>
              <div>
                  <span>Suara tambahan</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_plus']}} / 
                    {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_minus']}} <br>
                    jelaskan : {{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_detail']}}
                  </div>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Jantung</td>
          <td class="border">
              <div>
                  <span>Frekuensi</span>
                  {{@$apgar['pemeriksaan_fisik']['jantung']['frekuensi']}}
              </div>
              <div>
                  <span>Bising</span>
                  <div class="btn-group">
                    {{@$apgar['pemeriksaan_fisik']['jantung']['bising_plus']}} /
                    {{@$apgar['pemeriksaan_fisik']['jantung']['bising_minus']}}
                  </div>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Abdomen</td>
          <td class="border">
            {{@$apgar['pemeriksaan_fisik']['abdomen']}}
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Hati</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][hati][tidak_teraba]"
                      {{ @$apgar['pemeriksaan_fisik']['hati']['tidak_teraba'] == 'Tidak teraba' ? 'checked' : '' }}
                      type="checkbox" value="Tidak teraba">
                  <label class="form-check-label" style="font-weight: 400;">Tidak teraba</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][hati][teraba]"
                      {{ @$apgar['pemeriksaan_fisik']['hati']['teraba'] == 'Teraba' ? 'checked' : '' }}
                      type="checkbox" value="Teraba">
                  <label class="form-check-label" style="font-weight: 400;">Teraba</label>
                  {{@$apgar['pemeriksaan_fisik']['hati']['teraba_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Limpa</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][limpa][tidak_teraba]"
                      {{ @$apgar['pemeriksaan_fisik']['limpa']['tidak_teraba'] == 'Tidak teraba' ? 'checked' : '' }}
                      type="checkbox" value="Tidak teraba">
                  <label class="form-check-label" style="font-weight: 400;">Tidak teraba</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][limpa][teraba]"
                      {{ @$apgar['pemeriksaan_fisik']['limpa']['teraba'] == 'Teraba' ? 'checked' : '' }}
                      type="checkbox" value="Teraba">
                  <label class="form-check-label" style="font-weight: 400;">Teraba, Schiffner</label>
                  {{@$apgar['pemeriksaan_fisik']['limpa']['teraba_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Umbilikus</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][umbilikus][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['umbilikus']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][umbilikus][kelainan]"
                      {{ @$apgar['pemeriksaan_fisik']['umbilikus']['kelainan'] == 'Kelainan' ? 'checked' : '' }}
                      type="checkbox" value="Kelainan">
                  <label class="form-check-label" style="font-weight: 400;">Kelainan</label>
                  {{@$apgar['pemeriksaan_fisik']['umbilikus']['kelainan_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Pembesaran kelenjar di</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][pembesaran_kelenjar][ada]"
                      {{ @$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['ada'] == 'Ada' ? 'checked' : '' }}
                      type="checkbox" value="Ada">
                  <label class="form-check-label" style="font-weight: 400;">Ada</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][pembesaran_kelenjar][tidak_ada]"
                      {{ @$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                      type="checkbox" value="Tidak ada">
                  <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                  {{@$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['tidak_ada_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Anus</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][anus][ada]"
                      {{ @$apgar['pemeriksaan_fisik']['anus']['ada'] == 'Ada' ? 'checked' : '' }}
                      type="checkbox" value="Ada">
                  <label class="form-check-label" style="font-weight: 400;">Ada</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][anus][tidak_ada]"
                      {{ @$apgar['pemeriksaan_fisik']['anus']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                      type="checkbox" value="Tidak ada">
                  <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Ektremitas bawah</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][ektremitas_bawah][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['ektremitas_bawah']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][ektremitas_bawah][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['ektremitas_bawah']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['ektremitas_bawah']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Ektremitas atas</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][ektremitas_atas][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['ektremitas_atas']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][ektremitas_atas][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['ektremitas_atas']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['ektremitas_atas']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
        <tr>
          <td style="width:30%; font-weight:bold;" class="border">Tulang-tulang</td>
          <td class="border">
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][tulang_tulang][normal]"
                      {{ @$apgar['pemeriksaan_fisik']['tulang_tulang']['normal'] == 'Normal' ? 'checked' : '' }}
                      type="checkbox" value="Normal">
                  <label class="form-check-label" style="font-weight: 400;">Normal</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[pemeriksaan_fisik][tulang_tulang][tidak_normal]"
                      {{ @$apgar['pemeriksaan_fisik']['tulang_tulang']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                      type="checkbox" value="Tidak normal">
                  <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                  {{@$apgar['pemeriksaan_fisik']['tulang_tulang']['tidak_normal_detail']}}
              </div>
          </td>
        </tr>
    </table>
    <div class="form-group" style="margin-top: 10px;">
      {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
    </div> 
  </div>
  </body>
</html>