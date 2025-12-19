<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Hemodialisis</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
        }
        .no-border {
            border: none !important;
            padding: 5px;
        }
    </style>
  </head>
  <body>


    <table style="border: none !important; width:100%;font-size:12px;"> 
        <tr>
          <td style="width:10%; text-align: center; width: 30%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 25px;"> <br>
            <b style="font-size:8px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
            <b style="font-size:6px; font-weight:normal;"> {{ configrs()->tlp }}</b><br/>
            <b style="font-size:6px; font-weight:normal;"> Laman : {{ configrs()->website }} <span style="font-size:5px; margin-left:5px">Email : {{ configrs()->email }}</span></b><br/>
          </td>
          <td style="text-align: center; width: 40%; vertical-align: middle;">
              <h2 class="text-center" style="vertical-align: middle;">LAPORAN HEMODIALISIS UNIT HEMODIALISIS</h2>
          </td>
          <td style="width: 30%; vertical-align: top;">
            <div>
                <div>
                    Nama : {{@$reg->pasien->nama}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Tanggal Lahir : {{@$reg->pasien->tgllahir}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    No. RM : {{@$reg->pasien->no_rm}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Jenis Kelamin : {{kelamin(@$reg->pasien->kelamin)}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Umur : {{hitung_umur(@$reg->pasien->tgllahir)}} <br>
                </div>
            </div>
          </td>
        </tr>
    </table>
    <br>
    {{-- {{dd($assesments)}} --}}
    <table style="width: 100%; padding: 0%;" class="table table-striped table-bordered table-hover table-condensed form-box">
      <tr>
        <td class="no-border" colspan="4">
          <b>Laporan Tindakan</b>
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Tanggal</td>
        <td class="no-border" style="width: 25%">
          : {{ @$assesment['laporanTindakan']['tgl'] }}
        </td>
        <td class="no-border" style="width: 5%;">Waktu HD</td>
        <td class="no-border" style="width: 45%;">
          : Pukul {{ @$assesment['laporanTindakan']['waktuHD']['awal'] }} s/d Pukul {{ @$assesment['laporanTindakan']['waktuHD']['akhir'] }} WIB
        </td>
      </tr>
       <tr>
        <td class="no-border" style="width: 25%">Ruang Rawat</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['laporanTindakan']['ruangRawat'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Dilakukan Program</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          :
          <label for="program_1" style="margin-right: 10px;">
            <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="HD" id="program_1" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'HD' ? 'checked' : '' }}>
            HD
          </label>
          <label for="program_2" style="margin-right: 10px;">
            <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="SLEED" id="program_2" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'SLEED' ? 'checked' : '' }}>
            SLEED
          </label>
          <label for="program_3" style="margin-right: 10px;">
            <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="HFR" id="program_3" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'HFR' ? 'checked' : '' }}>
            HFR
          </label>
          <label for="program_4" style="margin-right: 10px;">
            <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="HDF" id="program_4" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'HDF' ? 'checked' : '' }}>
            HDF
          </label>
          {{ @$assesment['laporanTindakan']['program']['lainnya'] }} dengan :
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Time Dialisis</td>
        <td class="no-border" style="width: 25%">
          : {{ @$assesment['laporanTindakan']['timeDialisis'] }} Jam
        </td>
        <td class="no-border" style="width: 5%;">Suhu</td>
        <td class="no-border" style="width: 45%;">
          : {{ @$assesment['laporanTindakan']['suhu'] }} °C
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">UF GOAL</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['laporanTindakan']['ufGoal'] }} ml
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Quick Blood</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['laporanTindakan']['quickBlood'] }} ml / mnt
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Quick Dialysat</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['laporanTindakan']['quickDialysat'] }} ml / mnt
        </td>
      </tr>
      <tr>
        <td colspan="4" class="no-border">Profiling</td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">UF</td>
        <td class="no-border" style="width: 25%;">
          : {{ @$assesment['laporanTindakan']['profiling']['uf'] }}
        </td>
        <td class="no-border" style="width: 5%">Lainnya</td>
        <td class="no-border" style="width: 45%;">
          : {{ @$assesment['laporanTindakan']['profiling']['lainnya'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Na</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['laporanTindakan']['profiling']['na'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Akses Sirkulasi</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          :
          <label for="aksesSirkulasi_1" style="margin-right: 10px;">
            <input type="radio" name="fisik[laporanTindakan][aksesSirkulasi][pilihan]" value="Cimino" id="aksesSirkulasi_1" {{ @$assesment['laporanTindakan']['aksesSirkulasi']['pilihan'] == 'Cimino' ? 'checked' : '' }}>
            Cimino
          </label>
          <label for="aksesSirkulasi_2" style="margin-right: 10px;">
            <input type="radio" name="fisik[laporanTindakan][aksesSirkulasi][pilihan]" value="Femoral" id="aksesSirkulasi_2" {{ @$assesment['laporanTindakan']['aksesSirkulasi']['pilihan'] == 'Femoral' ? 'checked' : '' }}>
            Femoral
          </label>
          <label for="aksesSirkulasi_3" style="margin-right: 10px;">
            <input type="radio" name="fisik[laporanTindakan][aksesSirkulasi][pilihan]" value="Double Lumen Catheter" id="aksesSirkulasi_3" {{ @$assesment['laporanTindakan']['aksesSirkulasi']['pilihan'] == 'Double Lumen Catheter' ? 'checked' : '' }}>
            Double Lumen Catheter
          </label>
          {{ @$assesment['laporanTindakan']['aksesSirkulasi']['sebutkan'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Tindakan Keperawatan</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['laporanTindakan']['tindakan_keperawatan'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">
          <b>Pre HD</b>
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Keluhan Utama</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['preHD']['keluhanUtama'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Keadaan Umum</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          :
          <label for="keadaanUmum_1" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Tampak Tidak Sakit" id="keadaanUmum_1" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
            Tampak Tidak Sakit
          </label>
          <label for="keadaanUmum_2" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Sakit Ringan" id="keadaanUmum_2" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Sakit Ringan' ? 'checked' : '' }}>
            Sakit Ringan
          </label>
          <label for="keadaanUmum_3" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Sakit Sedang" id="keadaanUmum_3" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Sakit Sedang' ? 'checked' : '' }}>
            Sakit Sedang
          </label>
          <label for="keadaanUmum_4" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Sakit Berat" id="keadaanUmum_4" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Sakit Berat' ? 'checked' : '' }}>
            Sakit Berat
          </label>
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Kesadaran</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          :
          <label for="kesadaran_1" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Compos Mentis" id="kesadaran_1" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Compos Mentis' ? 'checked' : '' }}>
            Compos Mentis
          </label>
          <label for="kesadaran_2" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Apatis" id="kesadaran_2" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Apatis' ? 'checked' : '' }}>
            Apatis
          </label>
          <label for="kesadaran_3" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Somnolen" id="kesadaran_3" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Somnolen' ? 'checked' : '' }}>
            Somnolen
          </label>
          <label for="kesadaran_4" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Sopor" id="kesadaran_4" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Sopor' ? 'checked' : '' }}>
            Sopor
          </label>
          <label for="kesadaran_5" style="margin-right: 10px;">
            <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Coma" id="kesadaran_5" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Coma' ? 'checked' : '' }}>
            Coma
          </label>
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Tanda Vital</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : 
          TD : {{ @$assesment['preHD']['tanda_vital']['tekanan_darah'] }} mmHg,
          Nadi : {{ @$assesment['preHD']['tanda_vital']['nadi'] }} x/mnt,
          Pernapasan : {{ @$assesment['preHD']['tanda_vital']['pernapasan'] }} x/mnt,
          Suhu : {{ @$assesment['preHD']['tanda_vital']['suhu'] }} °C,
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">
          <b>On HD</b>
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">
          {{ @$assesment['onHD'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">
          <b>Post HD</b>
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">
          {{ @$assesment['postHD'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">
          <b>Hasil Akhir HD</b>
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Time Dialisis</td>
        <td class="no-border" style="width: 25%;">
          : {{ @$assesment['hasilAkhirHD']['timeDialisis'] }} Jam
        </td>
        <td class="no-border" style="width: 5%">UF GOAL</td>
        <td class="no-border" style="width: 40%;">
          : {{ @$assesment['hasilAkhirHD']['ufGoal'] }} ml
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Transfusi</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['hasilAkhirHD']['transfusi'] }} ml
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Terapi Cairan</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['hasilAkhirHD']['terapiCairan'] }} ml
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Asupan Cairan Oral / NGT</td>
        <td colspan="3" class="no-border" style="width: 75%;">
          : {{ @$assesment['hasilAkhirHD']['asupanCairanOral'] }}ml
        </td>
      </tr>
      <tr>
        <td class="no-border" style="width: 25%">Jumlah</td>
        <td class="no-border" style="width: 25%;">
          : {{ @$assesment['hasilAkhirHD']['jumlah'] }} ml
        </td>
        <td class="no-border" style="width: 5%">UF Total</td>
        <td class="no-border" style="width: 40%;">
          : {{ @$assesment['hasilAkhirHD']['ufTotal'] }} ml
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">Keterangan Lain :</td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">
          {{ @$assesment['hasilAkhirHD']['keteranganLain'] }}
        </td>
      </tr>
      <tr>
        <td class="no-border" colspan="4">Darah Untuk Pemeriksaan Laboratorium <b>{{ @$assesment['hasilAkhirHD']['darahPemeriksaan']['pilihan']}}</b></td>
      </tr>
    </table>

    <table style="border: 0px;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">
          Dokter Jaga
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          Perawat
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
          {{ baca_dokter(@$reg->dokter_id) }}
        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ baca_user(@$cetak->user_id) }}
        </td>
      </tr>
    </table>

  </body>
</html>
 