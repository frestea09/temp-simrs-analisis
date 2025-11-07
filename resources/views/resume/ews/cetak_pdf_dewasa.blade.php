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
        <b>EWS DEWASA</b>
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
      <td>Waktu</td>
      <td style="padding: 5px;">
        {{@$emr->waktu ? @$emr->waktu : date('H:i')}}
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Tingkat Kesadaran</td>
      <td style="padding: 5px;">
        <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',',
          @$ewss['tingkat_kesadaran'])[0]=='sadar' ? 'checked' : '' }} value="sadar,0"> Sadar (0)<br />
        <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',',
          @$ewss['tingkat_kesadaran'])[0]=='suara' ? 'checked' : '' }} value="suara,2"> Suara (2)<br />
        <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',',
          @$ewss['tingkat_kesadaran'])[0]=='bingung' ? 'checked' : '' }} value="bingung,3"> Bingung (3)<br />
        <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',',
          @$ewss['tingkat_kesadaran'])[0]=='nyeri' ? 'checked' : '' }} value="nyeri,3"> Nyeri (3)<br />
        <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',',
          @$ewss['tingkat_kesadaran'])[0]=='tidak_respon' ? 'checked' : '' }} value="tidak_respon,3"> Tidak Respon (3)
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Pernapasan</td>
      <td style="padding: 5px;">
        <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',', @$ewss['pernapasan'])[0]=='8'
          ? 'checked' : '' }} value="8,3"> Kurang dari atau sama dengan 8 (3)<br />
        <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',', @$ewss['pernapasan'])[0]=='9'
          ? 'checked' : '' }} value="9,1"> 9-11 (1)<br />
        <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',',
          @$ewss['pernapasan'])[0]=='12' ? 'checked' : '' }} value="12,0"> 12-20 (0)<br />
        <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',',
          @$ewss['pernapasan'])[0]=='21' ? 'checked' : '' }} value="21,2"> 21-24 (2)<br />
        <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',',
          @$ewss['pernapasan'])[0]=='25' ? 'checked' : '' }} value="25,3"> >= 25 (3)<br />
          <b>Nilai : {{@$ewss['nilai_pernapasan']}}</b>
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Saturasi Oksigen</td>
      <td style="padding: 5px;">
        <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]" {{@explode(',',
          @$ewss['saturasi_oksigen'])[0]=='91' ? 'checked' : '' }} value="91,3"> Kurang dari atau sama dengan 91
        (3)<br />
        <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]" {{@explode(',',
          @$ewss['saturasi_oksigen'])[0]=='92' ? 'checked' : '' }} value="92,2"> 92-93 (2)<br />
        <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]" {{@explode(',',
          @$ewss['saturasi_oksigen'])[0]=='94' ? 'checked' : '' }} value="94,1"> 94-95 (1)<br />
        <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]" {{@explode(',',
          @$ewss['saturasi_oksigen'])[0]=='96' ? 'checked' : '' }} value="96,0"> > = 96 (0) <br>
          <b>Nilai : {{@$ewss['nilai_saturasi_oksigen']}}</b>
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Penggunaan Oksigen</td>
      <td style="padding: 5px;">
        <input type="radio" class="input_skor" name="formulir[penggunaan_oksigen]" {{@explode(',',
          @$ewss['penggunaan_oksigen'])[0]=='ya' ? 'checked' : '' }} value="ya,2"> YA (2)<br />
        <input type="radio" class="input_skor" name="formulir[penggunaan_oksigen]" {{@explode(',',
          @$ewss['penggunaan_oksigen'])[0]=='tidak' ? 'checked' : '' }} value="tidak,0"> TIDAK (0)
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Tekanan Darah</td>
      <td style="padding: 5px;">
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='220' ? 'checked' : '' }} value="220,3"> >=220 (3)<br />
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='200' ? 'checked' : '' }} value="200,2"> 200-220 (2)<br />
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='160' ? 'checked' : '' }} value="160,1"> 160-199 (1)<br />
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='111' ? 'checked' : '' }} value="111,0"> 111-159 (0)<br />
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='101' ? 'checked' : '' }} value="101,1"> 101-110 (1)<br />
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='91' ? 'checked' : '' }} value="91,2"> 91-100 (2)<br />
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='90' ? 'checked' : '' }} value="90,3"> 60-90 (3)<br />
        <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',',
          @$ewss['tekanan_darah'])[0]=='60' ? 'checked' : '' }} value="60,3"> Kurang dari atau sama dengan 60 (3) <br>
          <b>Nilai : {{@$ewss['nilai_tekanan_darah']}}</b>
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Denyut Jantung</td>
      <td style="padding: 5px;">
        <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',',
          @$ewss['denyut_jantung'])[0]=='131' ? 'checked' : '' }} value="131,3"> 131 (3)<br />
        <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',',
          @$ewss['denyut_jantung'])[0]=='111' ? 'checked' : '' }} value="111,2"> 111-130 (2)<br />
        <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',',
          @$ewss['denyut_jantung'])[0]=='91' ? 'checked' : '' }} value="91,1"> 91-130 (1)<br />
        <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',',
          @$ewss['denyut_jantung'])[0]=='51' ? 'checked' : '' }} value="51,0"> 51-90 (0)<br />
        <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',',
          @$ewss['denyut_jantung'])[0]=='41' ? 'checked' : '' }} value="41,1"> 41-40 (1)<br />
        <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',',
          @$ewss['denyut_jantung'])[0]=='40' ? 'checked' : '' }} value="40,3"> Kurang dari atau sama dengan 40 (3)<br />
          <b>Nilai : {{@$ewss['nilai_denyut_jantung']}}</b>
      </td>
    </tr>
    <tr style="border-top:1px dotted #000">
      <td>Suhu</td>
      <td style="padding: 5px;">
        <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0]=='39'
          ? 'checked' : '' }} value="39,2"> >= 39,1 (2)<br />
        <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0]=='38'
          ? 'checked' : '' }} value="38,1"> 38,1 - 39,0 (1)<br />
        <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0]=='36'
          ? 'checked' : '' }} value="36,0"> 36,1 - 38,0 (0)<br />
        <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0]=='35'
          ? 'checked' : '' }} value="35,1"> 35,1 - 36,0 (1)<br />
        <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0]=='34'
          ? 'checked' : '' }} value="34,3"> Kurang dari atau sama dengan 35 (3)<br />
          <b>Nilai : {{@$ewss['nilai_suhu']}}</b>
      </td>
    </tr>
    <tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
      <td>Total Skor</td>
      <td style="padding: 5px;" id="total_skor">
          @php
              $tingkat_kesadaran = @explode(',', @$ewss['tingkat_kesadaran'])[1];
              $pernapasan = @explode(',', @$ewss['pernapasan'])[1];
              $saturasi_oksigen = @explode(',', @$ewss['saturasi_oksigen'])[1];
              $penggunaan_oksigen = @explode(',', @$ewss['penggunaan_oksigen'])[1];
              $tekanan_darah = @explode(',', @$ewss['tekanan_darah'])[1];
              $denyut = @explode(',', @$ewss['denyut_jantung'])[1];
              $suhu = @explode(',', @$ewss['suhu'])[1];

              $total_skor = $tingkat_kesadaran + $pernapasan + $saturasi_oksigen + $penggunaan_oksigen + $tekanan_darah + $denyut + $suhu;
          @endphp
          <b>{{$total_skor}}</b>
      </td>
  </tr>
  <tr>
    <td colspan="2">
        Skor Nyeri:<input value="{{@$ewss['skors_nyeri']}}" name="formulir[skors_nyeri]" type="text" style="width: 50px;">
        BB/TB:<input value="{{@$ewss['bbtb']}}" type="text"name="formulir[bbtb]" style="width: 50px;">
        Lingkar Kepala/lingkar perut:<input value="{{@$ewss['lingkep']}}" type="text" name="formulir[lingkep]" style="width: 50px;">
        Peroral/NGT:<input type="text" class="qty1" style="width: 50px;" name="formulir[ngt]" value="{{@$ewss['ngt']}}">
        Parenatal/Transfusi:<input class="qty1" value="{{@$ewss['parenatal']}}" type="text" name="formulir[parenatal]" style="width: 50px;">
        Jumlah:<input name="formulir[jumlah]" class="total" type="text" style="width: 50px;" value="{{@$ewss['jumlah']}}">
    </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      
      Feses:<input class="qty2" type="text"name="formulir[feses]" value="{{@$ewss['feses']}}" style="width: 50px;">
      Urin:<input class="qty2" type="text" name="formulir[urin]" value="{{@$ewss['urin']}}" style="width: 50px;">
      Muntah:<input type="text" class="qty2" style="width: 50px;" name="formulir[muntah]" value="{{@$ewss['muntah']}}">
      Darah/Drain:<input type="text" class="qty2" style="width: 50px;" name="formulir[darah]" value="{{@$ewss['darah']}}">
      IWL:<input type="text" style="width: 50px;" class="qty2" name="formulir[iwl]" value="{{@$ewss['iwl']}}">
      Jumlah:<input type="text" style="width: 50px;" class="total2" name="formulir[jumlah2]" value="{{@$ewss['jumlah2']}}">
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      
      Balance Cairan :<input type="text"name="formulir[balance]" style="width: 50px;" value="{{@$ewss['balance']}}">
      Lain-lain:<input type="text" name="formulir[lain]" style="width: 300px" value="{{@$ewss['lain']}}">
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
        @if (isset($cetak_tte) || isset($tte_nonaktif))
          @if (Auth::user()->pegawai->kategori_pegawai == 1)
            Dokter
          @else
            Perawat
          @endif
        @else
          @if (str_contains(baca_user($data->user_id),'dr.'))
              Dokter
          @else
              Perawat
          @endif
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
        @if (isset($cetak_tte) || isset($tte_nonaktif))
          {{ Auth::user()->pegawai->nama }}
        @else
          {{baca_user($data->user_id)}}
        @endif
      </td>
    </tr>
  </table>
</body>

</html>