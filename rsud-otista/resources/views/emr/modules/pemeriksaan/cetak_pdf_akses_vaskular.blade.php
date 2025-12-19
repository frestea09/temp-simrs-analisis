<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Vaskular Hemodialisis</title>
    <style>
        * {
          font-size: 15px;
        }
        table{
          width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px 8px;
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
        .no-border, .no-border td, .no-border th {
            border: none !important;
        }
    </style>
  </head>
  <body>
  <table border=0 style="width: 100%;"> 
        <tr>
          <th colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="5" style="font-size: 18pt;">
            <b>LAPORAN PENGGUNAAN AKSES VASKULAR AV-SHUNT</b>
          </th>
        </tr>
        <tr>
          <td colspan="6">
            Tanggal Pemeriksaan : {{ date('d-m-Y',strtotime(@$assesments->created_at)) }}
          </td>
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
            <td colspan="5">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td>1. POSISI AV-SHUNT</td>
          <td colspan="5" style="padding: 5px;">
            {{ @$assesment['aksesVaskular']['posisiAVShunt'] }}
          </td>
        </tr>
        <tr>
          <td>2. TANGGAL PERTAMA PENGGUNAAN AV-SHUNT</td>
          <td colspan="5" style="padding: 5px;">
            {{@$assesment['aksesVaskular']['tglPertama']}}
          </td>
        </tr>

        <tr>
          <td rowspan="2">3. KONDISI LUKA OPERASI</td>
          <td colspan="5" style="padding: 5px;">
            {{@$assesment['aksesVaskular']['kondisiLukaOperasi']}}
          </td>
        </tr>
        <tr>
          <td colspan="5">
            <label for="" style="font-weight: normal; margin-right: 10px;">a. Bruit</label>
            <input type="radio" id="bruit1" name="fisik[aksesVaskular][bruit][pilihan]" value="plus" {{@$assesment['aksesVaskular']['bruit']['pilihan'] == 'plus' ? 'checked' : ''}}>
            <label for="bruit1" style="font-weight: normal;">+</label>
            <input type="radio" id="bruit2" name="fisik[aksesVaskular][bruit][pilihan]" value="minus" {{@$assesment['aksesVaskular']['bruit']['pilihan'] == 'minus' ? 'checked' : ''}}>
            <label for="bruit2" style="font-weight: normal;">-</label><br>

            <label for="" style="font-weight: normal; margin-right: 10px;">b</label>
            <input type="radio" id="b1" name="fisik[aksesVaskular][b][pilihan]" value="besar" {{@$assesment['aksesVaskular']['b']['pilihan'] == 'besar' ? 'checked' : ''}}>
            <label for="b1" style="font-weight: normal;">Besar</label>
            <input type="radio" id="b2" name="fisik[aksesVaskular][b][pilihan]" value="kecil" {{@$assesment['aksesVaskular']['b']['pilihan'] == 'kecil' ? 'checked' : ''}}>
            <label for="b2" style="font-weight: normal;">Kecil</label><br>

            <label for="" style="font-weight: normal; margin-right: 10px;">c. Besar Aliran Darah</label>
            {{@$assesment['aksesVaskular']['besarAliranDarah']}} ml/menit
          </td>
        </tr>

        <tr>
          <td>4. DOKTER PELAKSANA OPERASI AV-SHUNT</td>
          <td colspan="5" style="padding: 5px;">
            <label for="" style="font-weight: normal">Dokter :</label>
              {{ @$assesment['aksesVaskular']['pelaksanaOperasi']['namaDokter'] }}
            <br>
            <label for="" style="font-weight: normal">Tanggal :</label>
            {{ @$assesment['aksesVaskular']['pelaksanaOperasi']['tanggal'] }}
          </td>
        </tr>
        <tr>
          @php
              $gambar = App\EmrInapPenilaian::where('registrasi_id', $reg->id)->first();
              if ($gambar && $gambar->fisik != null) {
                  $ketGambar = json_decode($gambar->fisik, true);
              }
          @endphp
          <td rowspan="2">5. STATUS LOKALIS</td>
          <td colspan="5" style="padding: 5px; border:1px solid #000;">
                @if (@$gambar->image != null)
                    <img src="{{ public_path('images/' . @$gambar->image) }}" alt=""
                        style="width: 400px; height: 200px;">
                @else
                    <h4><i>Tidak Ada Status Lokalis</i></h4>
                @endif 
          </td>
        </tr>
        <tr>
          <td colspan="5">
            <ol>
              <li>{{ @$ketGambar['keterangan'][0][1] ? @$ketGambar['keterangan'][0][1] : '-' }} </li>
              <li>{{ @$ketGambar['keterangan'][1][2] ? @$ketGambar['keterangan'][1][2] : '-' }} </li>
              <li>{{ @$ketGambar['keterangan'][2][3] ? @$ketGambar['keterangan'][2][3] : '-' }} </li>
              <li>{{ @$ketGambar['keterangan'][3][4] ? @$ketGambar['keterangan'][3][4] : '-' }} </li>
              <li>{{ @$ketGambar['keterangan'][4][5] ? @$ketGambar['keterangan'][4][5] : '-' }} </li>
              <li>{{ @$ketGambar['keterangan'][5][6] ? @$ketGambar['keterangan'][5][6] : '-' }} </li>
            </ol>
              {{ @$assesment['keterangan_status_lokalis'] }}
          </td>
        </tr>
        <tr>
          <td>6. RIWAYAT LAIN TERKAIT AV-SHUNT</td>
          <td style="padding: 5px;" colspan="5">
            <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
              <input class="form-check-input"  name="fisik[riwayatLain][kegagalan][pilihan]" type="hidden" value="">
              <input class="form-check-input"  name="fisik[riwayatLain][kegagalan][pilihan]" type="checkbox" value="true" {{@$assesment['riwayatLain']['kegagalan']['pilihan'] == 'true' ? 'checked' : ''}}>
              Kegagalan
            </label>
            <label for="" style="font-weight: normal; margin-right: 15px;">, Jam</label>
            {{@$assesment['riwayatLain']['kegagalan']['jam']}}
            <label for="" style="font-weight: normal">Penyebab</label>
            {{@$assesment['riwayatLain']['kegagalan']['penyebab']}}
            <br>

              <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
                <input class="form-check-input"  name="fisik[riwayatLain][kematian][pilihan]" type="hidden" value="">
                <input class="form-check-input"  name="fisik[riwayatLain][kematian][pilihan]" type="checkbox" value="true" {{@$assesment['riwayatLain']['kematian']['pilihan'] == 'true' ? 'checked' : ''}}>
                Kematian AV-Shunt
              </label>
              <label for="" style="font-weight: normal; margin-right: 15px;">, Jam</label>
              {{@$assesment['riwayatLain']['kematian']['jam']}}
              <label for="" style="font-weight: normal">Penyebab</label>
              {{@$assesment['riwayatLain']['kematian']['penyebab']}}
              <br>

              <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][pilihan]" type="hidden" value="">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][pilihan]" type="checkbox" value="true" {{@$assesment['riwayatLain']['komplikasi']['pilihan'] == 'true' ? 'checked' : ''}}>
                Komplikasi :
              </label>
              <br>
              <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][1]" type="hidden" value="">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][1]" type="checkbox" value="true" {{@$assesment['riwayatLain']['komplikasi']['1'] == 'true' ? 'checked' : ''}}>
                Aneurissma
              </label>
              <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][2]" type="hidden" value="">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][2]" type="checkbox" value="true" {{@$assesment['riwayatLain']['komplikasi']['2'] == 'true' ? 'checked' : ''}}>
                Fenomena Hambatan Aliran Arteri
              </label>
              <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][3]" type="hidden" value="">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][3]" type="checkbox" value="true" {{@$assesment['riwayatLain']['komplikasi']['3'] == 'true' ? 'checked' : ''}}>
                Hipertensi Vena
              </label>
              <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][4]" type="hidden" value="">
                <input class="form-check-input"  name="fisik[riwayatLain][komplikasi][4]" type="checkbox" value="true" {{@$assesment['riwayatLain']['komplikasi']['4'] == 'true' ? 'checked' : ''}}>
                Infeksi
              </label>

            <label class="form-check-label" style="font-weight: normal; margin-right: 15px;">
              <input class="form-check-input"  name="fisik[riwayatLain][lainnya][pilihan]" type="hidden" value="">
              <input class="form-check-input"  name="fisik[riwayatLain][lainnya][pilihan]" type="checkbox" value="true" {{@$assesment['riwayatLain']['lainnya']['pilihan'] == 'true' ? 'checked' : ''}}>
              Lain-Lain (Sebutkan)
            </label>
            {{@$assesment['riwayatLain']['lainnya']['sebutkan']}}
      </tr>
    </table>
    <br>
    <table style="border: 0px;">
      <tr style="border: 0px;">
        <td colspan="3" style="width: 50%; text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="width: 50%; text-align: center; border: 0px;">
          Dokter
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">
          <br><br><br>
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ baca_dokter(@$reg->dokter_id) }}
        </td>
      </tr>
    </table>
  </body>
</html>
 