<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HASIL MEDICAL CHECKUP</title>
    <style>
        table, th, td {
            /* border: 1px solid black; */
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
        }
        .border-top{
            border-top: 0.5px solid rgb(85, 83, 83);
        }
        .border-right{
            border-right: 0.5px solid rgb(85, 83, 83) !important;
        }
        .borderles-table{
            border: none;
        }
    </style>
  </head>
  <body>

    <table style="border: 1px solid">
      <tr >
        <th colspan="3" style="font-size: 20pt; border: 1px solid; text-align: center;">
          <img src="{{ public_path('images/'.configrs()->logo) }}" style="width: 60px;"><br>
          <div style="font-size:12px; font-weight:bold;">RSUD OTO ISKANDAR DINATA</div>
          <div style="font-size:6px; font-weight:normal; margin-top: 1px;">{{ configrs()->alamat }}</div>
        </th>
        <th colspan="3" style="font-size: 20pt !important; border: 1px solid;">
          <b>HASIL MEDICAL CHECK UP</b>
        </th>
      </tr>
      <tr>
        <td colspan="2" style="border: none;">
          <b>Pemeriksaan MCU</b>
          <b>Tujuan MCU</b>
          <b>Tanggal Pemeriksaan</b>
          <b>Nomor Reg</b>
        </td>
        <td colspan="4">
         : {{ @json_decode(@$mcu->fisik, true)['pemeriksaan_mcu'] }} <br>
         : {{ @json_decode(@$mcu->fisik, true)['tujuan_mcu'] }} <br>
         : {{ @json_decode(@$mcu->fisik, true)['tgl_pemeriksaan'] }} <br>
         {{-- : {{ @json_decode(@$mcu->fisik, true)['nomor_reg'] }} <br> --}}
         : {{ @$mcu->nomor }} <br>
        </td>
      </tr>
        <tr>
            <td style="border: 1px solid;">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2" style="border: 1px solid;">
                <b>Tempat/Tgl. Lahir</b><br>
                {{ ($reg->pasien->tmplahir) }} / {{ ($reg->pasien->tgllahir) }} 
            </td>
            <td style="border: 1px solid;">
                <b>Agama</b><br>
                {{ baca_agama($reg->pasien->agama_id) !== null ? baca_agama($reg->pasien->agama_id) : '-' }}
            </td>
            <td colspan="2" style="border: 1px solid;">
                <b>Alamat</b><br>
                {{ $reg->pasien->alamat ? : '-' }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid;">
                <b>Pendidikan</b><br>
                {{ $reg->pasien->pendidikan ? : '-' }}
            </td>
            <td colspan="2" style="border: 1px solid;">
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
            </td>
            <td style="border: 1px solid;">
                <b>Status Marital</b><br>
                {{ $reg->pasien->status_marital ? : '-' }}
            </td>
            <td style="border: 1px solid;">
                <b>Warga Negara</b><br>
                {{ $reg->pasien->negara ? : '-' }}
            </td>
            <td style="border: 1px solid;">
                <b>Pekerjaan</b><br>
                {{ $reg->pasien->pekerjaan ? : '-' }}
            </td>
        </tr>
        <tr>
          <td colspan="6"><b>Riwayat Penyakit Dahulu :</b></td>
        </tr>
        @foreach($mcu_perawat as $d)
        <tr>
          <td style="border: 1px solid;">
              <b>Pemeriksaan Fisik</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>Keadaan Umum</b> <br/>
            - Berat Badan : {{ @json_decode(@$d->fisik, true)['tanda_vital']['BB'] }} Kg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Tinggi Badan : {{ @json_decode(@$d->fisik, true)['tanda_vital']['TB'] }} Cm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Kesadaran : {{ @json_decode(@$d->fisik, true)['statusGeneralis']['keadaanUmum']['kesadaran'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Habitus : {{ @json_decode(@$d->fisik, true)['statusGeneralis']['keadaanUmum']['habitus'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Tekanan Darah : {{ @json_decode(@$d->fisik, true)['tanda_vital']['tekanan_darah'] }} mmHG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Nadi : {{ @json_decode(@$d->fisik, true)['tanda_vital']['nadi'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - RR : {{ @json_decode(@$d->fisik, true)['tanda_vital']['RR'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Temp : {{ @json_decode(@$d->fisik, true)['tanda_vital']['temp'] }} °C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;" rowspan="2">
            {{-- <b>Pemeriksaan Fisik</b> --}}
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>Kepala</b> <br/>
            - Ukuran kepala : {{ @json_decode(@$d->fisik, true)['statusLokalis']['ukuranKepala']['ukuran'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Kelainan Mata : {{ @json_decode(@$d->fisik, true)['statusLokalis']['kelainanMata']['pilihan'] }} {{ @json_decode(@$d->fisik, true)['statusLokalis']['kelainanMata']['sebutkan'] ? ', ' . @json_decode(@$d->fisik, true)['statusLokalis']['kelainanMata']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Kacamata : {{ @json_decode(@$d->fisik, true)['statusLokalis']['kacamata']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          </td>
        </tr>
        <tr>
          <td colspan="5" style="border: 1px solid;">
            <b>Leher</b><br/>
            - Pembesaran Kelenjar : {{ @json_decode(@$d->fisik, true)['statusLokalis']['leher']['pembesaranKelenjar']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Pembesaran Vena Jugularis : {{ @json_decode(@$d->fisik, true)['statusLokalis']['leher']['pembesaranVenaJugularis']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          </td>
        </tr>
    </table>
    <table style="border: 1px solid">
        <tr>
          <td style="border: 1px solid;" rowspan="3">
            <b></b>
          </td>
          <td colspan="6" style="border: 1px solid;">
            <b>Dada</b><br/>
            - Bentuk dan Gerak Paru-Paru : {{ @json_decode(@$d->fisik, true)['statusLokalis']['dada']['bentukParu']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Periksa Raba (Palpasi) : {{ @json_decode(@$d->fisik, true)['statusLokalis']['dada']['palpasi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Periksa Ketok (Perkusi) : {{ @json_decode(@$d->fisik, true)['statusLokalis']['dada']['perkusi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Bising Nafas : {{ @json_decode(@$d->fisik, true)['statusLokalis']['dada']['bisingNafas']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Ronchi Basah : {{ @json_decode(@$d->fisik, true)['statusLokalis']['dada']['ronchiBasah']['pilihan'] }} {{ @json_decode(@$d->fisik, true)['statusLokalis']['dada']['ronchiBasah']['sebutkan'] ? ', ' . @json_decode(@$d->fisik, true)['statusLokalis']['dada']['ronchiBasah']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          </td>
        </tr>
        <tr>
          <td colspan="6" style="border: 1px solid;">
            <b>Abdomen</b><br/>
            - Inspeksi : {{ @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['inspeksi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Palpasi : {{ @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['palpasi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Nyeri Tekan : {{ @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['nyeriTekan']['pilihan'] }} {{ @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['nyeriTekan']['lokasi'] ? ', ' . @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['nyeriTekan']['lokasi'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Hernia : {{ @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['hernia']['pilihan'] }} {{ @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['hernia']['lokasi'] ? ', ' . @json_decode(@$d->fisik, true)['statusLokalis']['abdomen']['hernia']['lokasi'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          </td>
        </tr>
        @endforeach
        <tr>
          <td style="border: none;">
              <b>Anggota Gerak/Reflek</b><br>
              <b>Pemeriksaan Penunjang</b><br>
              <b>Kesimpulan</b><br>
              <b>Catatan</b><br>
          </td>
          <td colspan="5">
              @php
                  $fisik = json_decode($mcu->fisik ?? '{}', true);
              @endphp
              : 
              @if(isset($fisik['anggota_gerak']['value']))
                  {{ $fisik['anggota_gerak']['value'] }}
                  @if(isset($fisik['anggota_gerak']['text']))
                      ({{ $fisik['anggota_gerak']['text'] }})
                  @endif
              @else
                  -
              @endif
              <br>
              : {{ $fisik['penunjang'] ?? '-' }} <br>
              : {{ $fisik['kesimpulan'] ?? '-' }} <br>
              : {{ $fisik['catatan'] ?? '-' }} <br>
          </td>
        </tr>          
    </table>
    <table style="margin-top: 25px" border="0">
      @php
          $dokter = Modules\Pegawai\Entities\Pegawai::where('user_id', $mcu->user_id)->first();
          // $base64  = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dokter->nama . ' | ' . @$dokter->sip))
      @endphp
      <tr>
          <td style="width: 50%;"></td>
          <td style="width: 50%;text-align:center">
            Soreang, {{date('d-m-Y', strtotime($mcu->created_at))}}<br>
            Dokter Pemeriksa
          </td>
      </tr>
      <tr style="height: 80px">
          <td style="width: 50%;vertical-align: bottom;text-align:center"></td>
          <td style="width: 50%; vertical-align: bottom;text-align:center">
            @if (isset($proses_tte))
            <br><br><br>
              #
            <br><br><br>
            @elseif (isset($tte_nonaktif))
              <img src="data:image/png;base64, {!! $base64 !!} ">
            @else
              <br><br>
            @endif
          </td>
      </tr>
      <tr style="height: 80px">
          <td style="width: 50%;vertical-align: bottom;text-align:center"></td>
          <td style="width: 50%; vertical-align: bottom;text-align:center">{{ Auth::user()->name }}</td>
      </tr>
    </table>
    
  </body>
</html>
 