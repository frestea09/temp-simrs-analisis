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
        <b>EWS ANAK</b>
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
      <td style="width:20%">Kategori Usia</td>
      <td style="padding: 5px;">{{@$ewss['kategori_usia']}}</td>
    </tr>
    <tr>
      <td style="width:20%">Tanggal</td>
      <td style="padding: 5px;">{{@$emr->tanggal ? @$emr->tanggal : date('Y-m-d')}}</td>
    </tr>
    <tr>
      <td>Waktu</td>
      <td style="padding: 5px;">
        {{@$emr->waktu ? @$emr->waktu : date('H:i')}}
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Perilaku</td>
      <td style="padding: 5px;">
          @foreach (perilaku_ews_anak() as $item)
              <input type="radio" class="input_skor" name="formulir[perilaku]" {{@ews(@$ewss['perilaku'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
      </td>
  </tr>
  <tr style="border-top:1px dotted #000">
    <td>RT/Warna Kulit</td>
    <td style="padding: 5px;">
        @foreach (kulit_ews_anak() as $item)
            <input type="radio" class="input_skor" name="formulir[kulit]" {{@ews(@$ewss['kulit'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
        @endforeach
    </td>
</tr>
<tr style="border-top:1px dotted #000">
    <td>Pernafasan</td>
    <td style="padding: 5px;">
        @foreach (pernafasan_ews_anak() as $item)
            <input type="radio" class="input_skor" name="formulir[pernafasan]" {{@ews(@$ewss['pernafasan'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
        @endforeach
    </td>
</tr>
<tr style="border-top:1px dotted #000">
    <td>Skor Lain</td>
    <td style="padding: 5px;">
        @foreach (skorlain_ews_anak() as $item)
            <input type="radio" class="input_skor" name="formulir[skor_lain]" {{@ews(@$ewss['skor_lain'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
        @endforeach
        <br/>
    </td>
</tr>
<tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
    <td>Total Skor</td>
    <td style="padding: 5px;" id="total_skor">
        @php
            $perilaku = @explode(',', @$ewss['perilaku'])[1];
            $kulit = @explode(',', @$ewss['kulit'])[1];
            $pernafasan = @explode(',', @$ewss['pernafasan'])[1];
            $skor_lain = @explode(',', @$ewss['skor_lain'])[1];

            $total_skor = $perilaku + $kulit + $pernafasan + $skor_lain;
        @endphp
        <b>{{$total_skor}}</b>
    </td>
</tr>
<tr>
  <td colspan="2">
      {{-- <b>Urine (+)</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;  --}}
      <b><span style="color:red">HR</span></b> : <input class="" value="{{@$ewss['hr']}}" name="formulir[hr]" type="text" style="width: 70px;">&nbsp;&nbsp;
      <b><span style="color:green">RR</span></b> : <input class="" value="{{@$ewss['rr']}}" name="formulir[rr]" type="text" style="width: 70px;">&nbsp;&nbsp;
      <b><span>T</span></b> : <input class="" value="{{@$ewss['t']}}" name="formulir[t]" type="text" style="width: 70px;">&nbsp;&nbsp;
      <b><span>TD</span></b> : <input class="" value="{{@$ewss['td']}}" name="formulir[td]" type="text" style="width: 70px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Skor Nyeri</b> : <input class="" value="{{@$ewss['skor_nyeri']}}" name="formulir[skor_nyeri]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Skor Resiko Jatuh</b> : <input class="" value="{{@$ewss['skor_resiko_jatuh']}}" name="formulir[skor_resiko_jatuh]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Berat Badan</b> : <input class="" value="{{@$ewss['bb']}}" name="formulir[bb]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Lingkar Lengan Atas</b> : <input class="" value="{{@$ewss['lla']}}" name="formulir[lla]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Lingkar Lengan Bawah</b> : <input class="" value="{{@$ewss['llb']}}" name="formulir[llb]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Lingkar Perut</b> : <input class="" value="{{@$ewss['lp']}}" name="formulir[lp]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Masuk</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Peroral / NGT : <input class="qty1" value="{{@$ewss['masuk']['peroral']}}" name="formulir[masuk][peroral]" type="text" style="width: 60px;">&nbsp;&nbsp;
      Parenteral : <input class="qty1" value="{{@$ewss['masuk']['Parenteral']}}" name="formulir[masuk][Parenteral]" type="text" style="width: 60px;">&nbsp;&nbsp;
      Tranfusi : <input class="qty1" value="{{@$ewss['masuk']['Tranfusi']}}" name="formulir[masuk][Tranfusi]" type="text" style="width: 60px;">&nbsp;&nbsp;
      Jumlah : <input class="total" value="{{@$ewss['masuk']['Jumlah']}}" name="formulir[masuk][Jumlah]" type="text" style="width: 60px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Keluar</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Feses : <input class="qty2" value="{{@$ewss['keluar']['Feses']}}" name="formulir[keluar][Feses]" type="text" style="width: 60px;">&nbsp;&nbsp;
      Urine : <input class="qty2" value="{{@$ewss['keluar']['Urine']}}" name="formulir[keluar][Urine]" type="text" style="width: 60px;">&nbsp;&nbsp;
      Muntah / NGT : <input class="qty2" value="{{@$ewss['keluar']['Muntah']}}" name="formulir[keluar][Muntah]" type="text" style="width: 60px;">&nbsp;&nbsp;
      Drain / Darah : <input class="qty2" value="{{@$ewss['keluar']['Drain']}}" name="formulir[keluar][Drain]" type="text" style="width: 60px;">&nbsp;&nbsp;
      IWL : <input class="qty2" value="{{@$ewss['keluar']['IWL']}}" name="formulir[keluar][IWL]" type="text" style="width: 60px;">&nbsp;&nbsp;
      Jumlah : <input class="total2" value="{{@$ewss['keluar']['Jumlah']}}" name="formulir[keluar][Jumlah]" type="text" style="width: 60px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Balance Cairan</b> : <input class="" value="{{@$ewss['blc_cairan']}}" name="formulir[blc_cairan]" type="text" style="width: 100px;">&nbsp;&nbsp;
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