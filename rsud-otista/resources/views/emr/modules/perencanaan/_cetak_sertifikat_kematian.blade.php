<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Sertifikat Kematian</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
   <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 3cm;
          margin-right: 3cm;
      }
    .border {
        border: 2px solid black;
        border-collapse: collapse !important;
    }
    </style>
  </head>
  <body>
     <table style="width: 100%;" class="border"> 
        <tr>
          <td style="width:15%; text-align:center; padding: 20px;" class="border">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center; font-size: 18px;" class="border">
           <b>SERTIFIKAT MEDIS <br>
              PENYEBAB KEMATIAN</b>
          </td>
          <td style="width:45%; padding: 5px;" class="border">
            <table>
              <tr>
                <td><b>No RM</b></td>
                <td>:</td>
                <td>{{@$pasien->no_rm}}</td>
              </tr>
              <tr>
                <td><b>Nama</b></td>
                <td>:</td>
                <td>{{@$pasien->nama}}</td>
              </tr>
              <tr>
                <td><b>Tgl. Lahir</b></td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse(@$pasien->tgllahir)->format('d-m-Y') }}</td>
              </tr>
              {{-- <tr>
                <td><b>Suku Bangsa</b></td>
                <td>:</td>
                <td>{{@$pasien->suku_bangsa}}</td>
              </tr> --}}
            </table>
          </td>
        </tr>
     </table>
     <table style="width: 100%;" class="border">
        <tr>
          <td colspan="4" style="padding: 5px; font-size: 14px;"><b>Tgl. Masuk :</b> {{\Carbon\Carbon::parse(@$form['tanggal_masuk'])->format('d-m-Y')}} {{@$form['jam_masuk']}}</td>
        </tr>
        <tr>
          <td colspan="4" style="padding: 5px; font-size: 14px;"><b>Tgl. Meninggal :</b> {{\Carbon\Carbon::parse(@$form['tanggal_meninggal'])->format('d-m-Y')}} {{@$form['jam_meninggal']}}</td>
        </tr>
        <tr>
          <td colspan="4" style="padding: 5px; font-size: 14px;"><b>Nomor :</b> {{@$form['nomor']}}</td>
        </tr>
        <tr>
            <th class="bold p-1 border text-center" style="width: 5%;">No</th>
            <th class="bold p-1 border text-center" style="width: 60%" colspan="2">Penyebab Kematian</th>
            <th class="bold p-1 border text-center" style="width: 35%;">Perkiraan Interval Antara Awalnya dan Kematian</th>
        </tr>
        <tr>
            <td class="p-1 border text-center" style="vertical-align: top; text-align:center;" rowspan="3">1</td>
            <td class="p-1 border" style="vertical-align: top; padding: 5px;">a. Penyakit atau kondisi yang langsung menuju kematian</td>
            <td class="p-1 border" style="vertical-align: top; padding: 5px;">
                (a) {{@$form['penyebab_kematian']['1']['penyakit']}} <br>
                <small><i>penyakit atau kondisi tersebut akibat (atau sebagai konsekuensi dari)</i></small>
            </td>
            <td class="p-1 border" style="vertical-align: top; padding: 5px;">
                {{@$form['perkiraan_interval']['1']['penyakit']}}
            </td>
        </tr>
        <tr>
            <td class="p-1 border" rowspan="2" style="vertical-align: top; padding: 5px;">b. Penyebab pendahulu Kondisi sakit, kalau ada, yang menimbulkan penyebab diatas, dengan meletakkan kondisi dasar paling akhir</td>
            <td class="p-1 border" style="vertical-align: top; padding: 5px;">
                (b) {{@$form['penyebab_kematian']['1']['penyebab']}} <br>
                <small><i>penyakit atau kondisi tersebut akibat (atau sebagai konsekuensi dari)</i></small>
            </td>
            <td class="p-1 border" style="vertical-align: top; padding: 5px;;">
                {{@$form['perkiraan_interval']['1']['penyebab']}}
            </td>
        </tr>
        <tr>
            <td class="p-1 border" style="vertical-align: top; padding: 5px;">
                (c) {{@$form['penyebab_kematian']['1']['lainnya']}}
            </td>
            <td class="p-1 border" style="vertical-align: top; padding: 5px;">
                {{@$form['perkiraan_interval']['1']['lainnya']}}
            </td>
        </tr>
        <tr>
            <td rowspan="3" class="p-1 border text-center" style="vertical-align: top; text-align:center;">2</td>
            <td rowspan="3" class="p-1 border" style="vertical-align: top; padding: 5px;">Kondisi penting lain yang ikut menyebabkan kematian, tapi tidak berhubungan dengan penyakit atau kondisi penyebab kematian.</td>
            <td style="padding: 5px;">
                (1) {{@$form['penyebab_kematian']['2']['1']}}
            </td>
            <td class="p-1" style="border-left: 2px solid black; padding: 5px;">{{@$form['perkiraan_interval']['2']['1']}}</td>>
        </tr>
        <tr>
            <td style="padding: 5px;">
                (2) {{@$form['penyebab_kematian']['2']['2']}}
            </td>
            <td class="p-1" style="border-left: 2px solid black; padding: 5px;">{{@$form['perkiraan_interval']['2']['2']}}</td>
        </tr>
        <tr>
            <td style="padding: 5px;">
                (3) {{@$form['penyebab_kematian']['2']['3']}}
            </td>
            <td class="p-1" style="border-left: 2px solid black; padding: 5px;">{{@$form['perkiraan_interval']['2']['3']}}</td>
        </tr>
        <tr>
          <td colspan="3" class="p-1 border" style="padding: 5px;">
            * ini tidak sama dengan cara kematian, seperti kegagalan jantung atau kegagalan pernapasan.
            ini adalah penyakit, cedera, atau komplikasi yang menyebabkan kematian
          </td>
          <td class="p-1 border"></td>
        </tr>
      </table>
      <br><br><br>
      <table style="width: 100%;">
        <tr>
          <td style="width: 50%;"></td>
          <td style="width: 50%; text-align:center;">
            {{-- Soreang, {{(@$riwayat->created_at)->format('d-m-Y')}} <br> --}}
            Dokter yang Bertugas / DPJP
            <br><br>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="text-align: center;">
            @if (isset($proses_tte))
                #
            @elseif (isset($tte_nonaktif))
              @php
                $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip . '|' . $cetak->created_at))
              @endphp
                <div style="margin-bottom: 40px;">
                  <img src="data:image/png;base64, {!! $base64 !!}">
                </div>
            @else
            <br><br><br><br><br>
            @endif
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="text-align: center;">
            <br><br><br>
            {{baca_dokter(@$reg->dokter_id)}}
          </td>
        </tr>
      </table>
  </body>
</html>

