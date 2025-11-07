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
          margin-top: 1cm;
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
  <div class="col-md-12">
    <h5 class="text-center"><b>LAPORAN PERSALINAN</b></h5>
    <table style="width:100%">
      <tr>
        <td style="width:100px;">NAMA</td>
        <td>: {{@$reg->pasien->nama}}</td>

        <td>TGLLAHIR/UMUR</td>
        <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
      </tr>
      
      <tr>
        {{-- <td>RUANG</td>
        <td>: {{@baca_poli($reg->poli_id)}}</td> --}}
        <td>TANGGAL</td>
        {{-- <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td> --}}
        <td>: {{@$laporan['jam_1']['jam_1'] ? @date('d-m-Y H:i', strtotime($laporan['jam_1']['jam_1'])) : ''}}</td>
        {{-- <td>: {{@$laporan->created_at}}</td> --}}
        <td></td>
        <td></td>
      </tr>
    </table>
    <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
      <tr>
          <td rowspan="6" style="width: 10%;">
              Jam
          </td>
          <td rowspan="6" style="width: 15%;">
            {{@$laporan['jam_1']['jam'] ? @date('d-m-Y H:i:s', strtotime($laporan['jam_1']['jam'])) : ''}}
          </td>
          <td style="width: 15%;">
              <label>Lahir Bayi</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[jam_1][lahir_bayi][pilihan]"
                      {{ @$laporan['jam_1']['lahir_bayi']['pilihan'] == 'Laki-laki' ? 'checked' : '' }}
                      type="radio" value="Laki-laki">
                  <label class="form-check-label" style="font-weight: 400;">Laki-laki</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[jam_1][lahir_bayi][pilihan]"
                      {{ @$laporan['jam_1']['lahir_bayi']['pilihan'] == 'Perempuan' ? 'checked' : '' }}
                      type="radio" value="Perempuan">
                  <label class="form-check-label" style="font-weight: 400;">Perempuan</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Jenis Persalinan</label>
          </td>
          <td style="width: 60%;">
            <div>
                <input class="form-check-input"
                    name="fisik[jam_1][spontan][pilihan][EF]"
                    {{ @$laporan['jam_1']['spontan']['pilihan']['EF'] == 'E.F' ? 'checked' : '' }}
                    type="checkbox" value="E.F">
                <label class="form-check-label" style="font-weight: 400;">E.F</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[jam_1][spontan][pilihan][Evc]"
                    {{ @$laporan['jam_1']['spontan']['pilihan']['Evc'] == 'E.Vc' ? 'checked' : '' }}
                    type="checkbox" value="E.Vc">
                <label class="form-check-label" style="font-weight: 400;">E.Vc</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[jam_1][spontan][pilihan][SC]"
                    {{ @$laporan['jam_1']['spontan']['pilihan']['SC'] == 'SC' ? 'checked' : '' }}
                    type="checkbox" value="SC">
                <label class="form-check-label" style="font-weight: 400;">SC</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[jam_1][spontan][pilihan][ManualAID]"
                    {{ @$laporan['jam_1']['spontan']['pilihan']['ManualAID'] == 'Manual AID' ? 'checked' : '' }}
                    type="checkbox" value="Manual AID">
                <label class="form-check-label" style="font-weight: 400;">Manual AID</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[jam_1][spontan][pilihan][Bracht]"
                    {{ @$laporan['jam_1']['spontan']['pilihan']['Bracht'] == 'Bracht' ? 'checked' : '' }}
                    type="checkbox" value="Bracht">
                <label class="form-check-label" style="font-weight: 400;">Bracht</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[jam_1][spontan][pilihan][Spontan]"
                    {{ @$laporan['jam_1']['spontan']['pilihan']['Spontan'] == 'Spontan' ? 'checked' : '' }}
                    type="checkbox" value="Spontan">
                <label class="form-check-label" style="font-weight: 400;">Spontan</label>
            </div>
        </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Berat Badan (gr)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['jam_1']['berat_badan']}}
              
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Panjang Badan (cm)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['jam_1']['panjang_badan']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Lilitan Tali Pusat (+/-)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['jam_1']['lilitan_tali_pusat']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Episiotomi (+/-)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['jam_1']['episiotomi']}}
          </td>
      </tr>

      <tr>
          <td rowspan="6" style="width: 10%;">
              Jam
          </td>
          <td rowspan="6" style="width: 15%;">
            {{@$laporan['jam_2']['jam'] ? date('d-m-Y H:i:s', strtotime($laporan['jam_2']['jam'])) : ''}}
          </td>
          <td style="width: 15%;">
              <label>Plasenta lahir</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[jam_2][plasenta_lahir][pilihan]"
                      {{ @$laporan['jam_2']['plasenta_lahir']['pilihan'] == 'Spontan' ? 'checked' : '' }}
                      type="radio" value="Spontan">
                  <label class="form-check-label" style="font-weight: 400;">Spontan</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[jam_2][plasenta_lahir][pilihan]"
                      {{ @$laporan['jam_2']['plasenta_lahir']['pilihan'] == 'Manual' ? 'checked' : '' }}
                      type="radio" value="Manual">
                  <label class="form-check-label" style="font-weight: 400;">Manual</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Kelengkapan</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[jam_2][kelengkapan][pilihan]"
                      {{ @$laporan['jam_2']['kelengkapan']['pilihan'] == 'Lengkap' ? 'checked' : '' }}
                      type="radio" value="Lengkap">
                  <label class="form-check-label" style="font-weight: 400;">Lengkap</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[jam_2][kelengkapan][pilihan]"
                      {{ @$laporan['jam_2']['kelengkapan']['pilihan'] == 'Tidak lengkap' ? 'checked' : '' }}
                      type="radio" value="Tidak lengkap">
                  <label class="form-check-label" style="font-weight: 400;">Tidak lengkap</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Berat Badan (gr)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['jam_2']['berat_badan']}}
              
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Ukuran (cm)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['jam_2']['ukuran']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Pendarahan (cc)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['jam_2']['pendarahan']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Jahitan Perineum</label>
          </td>
          <td style="width: 60%;">
            <div>
                <input class="form-check-input"
                    name="fisik[jam_2][jahitan_perineum][pilihan][]"
                    {{ @in_array('Luar', @$laporan['jam_2']['jahitan_perineum']['pilihan'] ?? []) ? 'checked' : '' }}
                    type="checkbox" value="Luar">
                <label class="form-check-label" style="font-weight: 400;">Luar</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[jam_2][jahitan_perineum][pilihan][]"
                    {{ @in_array('Dalam', @$laporan['jam_2']['jahitan_perineum']['pilihan'] ?? []) ? 'checked' : '' }}
                    type="checkbox" value="Dalam">
                <label class="form-check-label" style="font-weight: 400;">Dalam</label>
            </div>
          </td>
      </tr>

      <tr>
          <td rowspan="5" style="width: 10%;">
              Post Partum
          </td>
          <td rowspan="5" style="width: 15%;">
              &nbsp;
          </td>
          <td style="width: 15%;">
              <label>Keadaan Ibu</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[post_partum][keadaan_ibu][pilihan]"
                      {{ @$laporan['post_partum']['keadaan_ibu']['pilihan'] == 'Baik' ? 'checked' : '' }}
                      type="radio" value="Baik">
                  <label class="form-check-label" style="font-weight: 400;">Baik</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[post_partum][keadaan_ibu][pilihan]"
                      {{ @$laporan['post_partum']['keadaan_ibu']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                      type="radio" value="Tidak baik">
                  <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Tinggi Fu</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['post_partum']['tinggi_fu']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Konstrasksi Rahim</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[post_partum][konstraksi_rahim][pilihan]"
                      {{ @$laporan['post_partum']['konstraksi_rahim']['pilihan'] == 'Baik' ? 'checked' : '' }}
                      type="radio" value="Baik">
                  <label class="form-check-label" style="font-weight: 400;">Baik</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[post_partum][konstraksi_rahim][pilihan]"
                      {{ @$laporan['post_partum']['konstraksi_rahim']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                      type="radio" value="Tidak baik">
                  <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Perdarahan</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[post_partum][perdarahan][pilihan]"
                      {{ @$laporan['post_partum']['perdarahan']['pilihan'] == 'Ada' ? 'checked' : '' }}
                      type="radio" value="Ada">
                  <label class="form-check-label" style="font-weight: 400;">Ada</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[post_partum][perdarahan][pilihan]"
                      {{ @$laporan['post_partum']['perdarahan']['pilihan'] == 'Tidak Ada' ? 'checked' : '' }}
                      type="radio" value="Tidak Ada">
                  <label class="form-check-label" style="font-weight: 400;">Tidak Ada</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Terapi</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['post_partum']['terapi']}}
          </td>
      </tr>

      <tr>
          <td rowspan="6" style="width: 10%;">
              2 Jam Post Partum
          </td>
          <td rowspan="6" style="width: 15%;">
              &nbsp;
          </td>
          <td style="width: 15%;">
              <label>Keadaan Ibu</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[2_jam_post_partum][keadaan_ibu][pilihan]"
                      {{ @$laporan['2_jam_post_partum']['keadaan_ibu']['pilihan'] == 'Baik' ? 'checked' : '' }}
                      type="radio" value="Baik">
                  <label class="form-check-label" style="font-weight: 400;">Baik</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[2_jam_post_partum][keadaan_ibu][pilihan]"
                      {{ @$laporan['2_jam_post_partum']['keadaan_ibu']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                      type="radio" value="Tidak baik">
                  <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Tensi (mmHg)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['2_jam_post_partum']['tensi']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Nadi (x/menit)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['2_jam_post_partum']['nadi']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Respirasi (x/menit)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['2_jam_post_partum']['respirasi']}}
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Konstrasksi Rahim</label>
          </td>
          <td style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[2_jam_post_partum][konstraksi_rahim][pilihan]"
                      {{ @$laporan['2_jam_post_partum']['konstraksi_rahim']['pilihan'] == 'Baik' ? 'checked' : '' }}
                      type="radio" value="Baik">
                  <label class="form-check-label" style="font-weight: 400;">Baik</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[2_jam_post_partum][konstraksi_rahim][pilihan]"
                      {{ @$laporan['2_jam_post_partum']['konstraksi_rahim']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                      type="radio" value="Tidak baik">
                  <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
              </div>
          </td>
      </tr>
      <tr>
          <td style="width: 15%;">
              <label>Perdarahan (cc)</label>
          </td>
          <td style="width: 60%;">
            {{@$laporan['2_jam_post_partum']['perdarahan']}}
          </td>
      </tr>

      <tr>
          <td style="width: 10%;">
              <label>Diagnosa :</label>
          </td>
          <td colspan="3" style="width: 60%;">
            {{@$laporan['diagnosa']}}
          </td>
      </tr>

      <tr>
          <td style="width: 10%;">
              <label>Konstrasepsi :</label>
          </td>
          <td colspan="3" style="width: 60%;">
              <div>
                  <input class="form-check-input"
                      name="fisik[konstrasepsi][pilihan]"
                      {{ @$laporan['konstrasepsi']['pilihan'] == 'Pil' ? 'checked' : '' }}
                      type="radio" value="Pil">
                  <label class="form-check-label" style="font-weight: 400;">Pil</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[konstrasepsi][pilihan]"
                      {{ @$laporan['konstrasepsi']['pilihan'] == 'Suntik' ? 'checked' : '' }}
                      type="radio" value="Suntik">
                  <label class="form-check-label" style="font-weight: 400;">Suntik</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[konstrasepsi][pilihan]"
                      {{ @$laporan['konstrasepsi']['pilihan'] == 'Implant' ? 'checked' : '' }}
                      type="radio" value="Implant">
                  <label class="form-check-label" style="font-weight: 400;">Implant</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[konstrasepsi][pilihan]"
                      {{ @$laporan['konstrasepsi']['pilihan'] == 'AKDR' ? 'checked' : '' }}
                      type="radio" value="AKDR">
                  <label class="form-check-label" style="font-weight: 400;">AKDR</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[konstrasepsi][pilihan]"
                      {{ @$laporan['konstrasepsi']['pilihan'] == 'MOW' ? 'checked' : '' }}
                      type="radio" value="MOW">
                  <label class="form-check-label" style="font-weight: 400;">MOW</label>
              </div>
          </td>
      </tr>
    </table>
    <table style="width: 100%; font-size: 12px; margin-top: 5rem; text-align:center;">
        <tr>
            <td style="width: 50%;">&nbsp;</td>
            <td style="width: 50%;" class="text-center">Soreang, 
                {{-- {{date('d-m-Y', strtotime(@$laporan->created_at))}} --}}
                {{@$laporan['jam_1']['jam'] ? date('d-m-Y', strtotime($laporan['jam_1']['jam'])) : ''}}
            </td>
        </tr>
        <tr>
            <td class="text-center"></td>
            <td class="text-center">Dokter</td>
        </tr>
        <tr>
            <td class="text-center"></td>
            <td class="text-center">
                @php
                    $dokter = \Modules\Pegawai\Entities\Pegawai::find(@$reg->dokter_id);
                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dokter->nama . ' | ' . @$dokter->nip))
                @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
            </td>
        </tr>
        <tr>
            <td class="text-center"></td>
            <td class="text-center">{{baca_dokter(@$reg->dokter_id)}}</td>
        </tr>
    </table>
  </div>
  </body>
</html>