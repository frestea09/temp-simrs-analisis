<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cetak EWS_{{ @$reg->pasien->no_rm }}</title>
  <style>
    table {
      width: 100%;
    }

    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
    }

    th,
    td {
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

    .page_break_after {
      page-break-after: always;
    }
  </style>
</head>

<body>
  @if (isset($cetak_tte))
    <div class="footer">
      Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
    </div>
  @endif
  <table>
    <tr>
      <th colspan="1">
        <img src="{{ public_path('images/'.configrs()->logo) }}" style="width: 60px;">
      </th>
      <th colspan="5" style="font-size: 18pt;">
        <b>EWS NEONATUS</b>
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
        {{ $reg->pasien->kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}
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
        <b>Poli / Ruangan</b><br>
        {{ @$reg->rawat_inap ? @$reg->rawat_inap->kamar->nama : @$reg->poli->nama }}
      </td>
      <td>
        <b>No Telp</b><br>
        {{ $reg->pasien->nohp ?? '-' }}
      </td>
    </tr>
  </table>
  <br>
  @php
  libxml_use_internal_errors(true);
  @endphp
  <table>
    <tr>
      <td style="width:20%">Tanggal</td>
      <td style="padding: 5px;">{{@$emr->tanggal ? @$emr->tanggal : date('Y-m-d')}}</td>
    </tr>
    <tr>
      <td>Jam</td>
      <td style="padding: 5px;">
        {{@$emr->waktu ? @$emr->waktu : date('H:i')}}
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Suhu</td>
      <td style="padding: 5px;">
          @foreach (suhu_ews_neonatus() as $item)
              <input type="radio" class="input_skor" name="formulir[suhu]" {{@ews(@$ewss['suhu'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
          <br>
          <b>Nilai : {{@$ewss['nilai_suhu']}}</b>
          <br/>
      </td>
  </tr>
  <tr style="border-top:1px dotted #000">
      <td>Frekuansi Nafas</td>
      <td style="padding: 5px;">
          @foreach (frekuensi_nafas_ews_neonatus() as $item)
              <input type="radio" class="input_skor" name="formulir[frekuensi_nafas]" {{@ews(@$ewss['frekuensi_nafas'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
          <br>
          <b>Nilai : {{@$ewss['nilai_frekuensi_nafas']}}</b>
          <br/>
      </td>
  </tr>
  <tr style="border-top:1px dotted #000">
      <td>Denyut Jantung</td>
      <td style="padding: 5px;">
          @foreach (denyut_jantung_ews_neonatus() as $item)
              <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@ews(@$ewss['denyut_jantung'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
          <br>
          <b>Nilai : {{@$ewss['nilai_denyut_jantung']}}</b>
          <br/>
      </td>
  </tr>
  <tr style="border-top:1px dotted #000">
    <td>Sat. O2</td>
    <td style="padding: 5px;">
        @foreach (saturasi_ews_neonatus() as $item)
            <input type="radio" class="input_skor" name="formulir[saturasi]" {{@ews(@$ewss['saturasi'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
        @endforeach
        <br>
        <b>Nilai : {{@$ewss['nilai_saturasi']}}</b>
        <br/>
    </td>
  </tr>
  <tr style="border-top:1px dotted #000">
      <td>CRT</td>
      <td style="padding: 5px;">
          @foreach (crt_ews_neonatus() as $item)
              <input type="radio" class="input_skor" name="formulir[crt]" {{@ews(@$ewss['crt'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
          <br>
          <b>Nilai : {{@$ewss['nilai_crt']}}</b>
          <br/>
      </td>
  </tr>
  <tr style="border-top:1px dotted #000">
      <td>Tingkat Kesadaran</td>
      <td style="padding: 5px;">
          @foreach (tingkat_kesadaran_ews_neonatus() as $item)
              <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@ews(@$ewss['tingkat_kesadaran'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
          <br>
          <b>Nilai : {{@$ewss['nilai_tingkat_kesadaran']}}</b>
      </td>
  </tr>
  <tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
    <td>Total Skor</td>
    <td style="padding: 5px;" id="total_skor">
        @php
            $tingkat_kesadaran = @explode(',', @$ewss['tingkat_kesadaran'])[1];
            $suhu = @explode(',', @$ewss['suhu'])[1];
            $frekuensi_nafas = @explode(',', @$ewss['frekuensi_nafas'])[1];
            $denyut_jantung = @explode(',', @$ewss['denyut_jantung'])[1];
            $saturasi = @explode(',', @$ewss['saturasi'])[1];
            $crt = @explode(',', @$ewss['crt'])[1];

            $total_skor =   (is_numeric($tingkat_kesadaran) ? $tingkat_kesadaran : 0) +
                            (is_numeric($suhu) ? $suhu : 0) +
                            (is_numeric($frekuensi_nafas) ? $frekuensi_nafas : 0) +
                            (is_numeric($denyut_jantung) ? $denyut_jantung : 0) +
                            (is_numeric($saturasi) ? $saturasi : 0) +
                            (is_numeric($crt) ? $crt : 0);
        @endphp
        {{$total_skor}}
    </td>
  </tr>
  <tr>
    <td colspan="2">
        <br/>
        <b>Grunting</b> : <input class="" value="{{@$ewss['grunting']}}" name="formulir[grunting]" type="text" style="width: 100px;">&nbsp;&nbsp;
    </td>
</tr>
<tr>
    <td colspan="2">
        <br/>
        <b>Kejang</b> : <input class="" value="{{@$ewss['kejang']}}" name="formulir[kejang]" type="text" style="width: 100px;">&nbsp;&nbsp;
    </td>
</tr>
<tr>
    <td colspan="2">
        <br/>
        <b>Glukosa</b> : <input class="" value="{{@$ewss['glukosa']}}" name="formulir[glukosa]" type="text" style="width: 100px;">&nbsp;&nbsp;
    </td>
</tr>
  </table>

  <table style="border: 0px;margin-top: 3rem;">
    <tr style="border: 0px;">
      <td colspan="3" style="text-align: center; border: 0px;">
      </td>
      <td colspan="3" style="text-align: center; border: 0px;">
      </td>
      <td colspan="3" style="text-align: center; border: 0px;">
        @if (str_contains(baca_user($data->user_id),'dr.'))
            Dokter
        @else
            Perawat
        @endif
      </td>
    </tr>
    <tr style="border: 0px;">
      <td colspan="3" style="text-align: center; border: 0px;">
      </td>
      <td colspan="3" style="text-align: center; border: 0px;">
      </td>
      <td colspan="3" style="text-align: center; border: 0px;">
        @if (isset($cetak_tte))
        <span style="margin-left: 1rem;">
          #
        </span>
          <br>
          <br>
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

      </td>
      <td colspan="3" style="text-align: center; border: 0px;">

      </td>
      <td colspan="3" style="text-align: center; border: 0px;">
        {{baca_user($data->user_id)}}
      </td>
    </tr>
  </table>
</body>

</html>