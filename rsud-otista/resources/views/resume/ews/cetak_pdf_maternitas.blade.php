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
        <b>EWS MATERNITAS</b>
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
      <td>Pernapasan</td>
      <td style="padding: 5px;">
          @foreach (pernapasan_ews_maternal() as $item)
              <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@ews(@$ewss['pernapasan'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
          <br>
          <b>Nilai : {{@$ewss['nilai_pernapasan']}}</b>
      </td>
  </tr>
  <tr style="border-top:1px dotted #000">
      <td>Sp.O2</td>
      <td style="padding: 5px;">
          @foreach (spo2_ews_maternal() as $item)
              <input type="radio" class="input_skor" name="formulir[spo2]" {{@ews(@$ewss['spo2'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
          @endforeach
          <br>
          <b>Nilai : {{@$ewss['nilai_spo2']}}</b>
      </td>
  </tr>
  <tr style="border-top:1px dotted #000">
    <td>Suhu</td>
    <td style="padding: 5px;">
        @foreach (suhu_ews_maternal() as $item)
            <input type="radio" class="input_skor" name="formulir[suhu]" {{@ews(@$ewss['suhu'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
        @endforeach
        <br>
        <b>Nilai : {{@$ewss['nilai_suhu']}}</b>
    </td>
</tr>
<tr style="border-top:1px dotted #000">
    <td>Frekuensi Jantung</td>
    <td style="padding: 5px;">
        @foreach (freqjan_ews_maternal() as $item)
            <input type="radio" class="input_skor" name="formulir[frekuensi_jantung]" {{@ews(@$ewss['frekuensi_jantung'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
        @endforeach
        <br>
        <b>Nilai : {{@$ewss['nilai_frekuensi_jantung']}}</b>
    </td>
</tr>
<tr style="border-top:1px dotted #000">
    <td>Tekanan Sistolik</td>
    <td style="padding: 5px;">
        @foreach (sitolik_ews_maternal() as $item)
            <input type="radio" class="input_skor" name="formulir[sitolik]" {{@ews(@$ewss['sitolik'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
        @endforeach
        <br>
        <b>Nilai : {{@$ewss['nilai_sitolik']}}</b>
    </td>
</tr>
<tr style="border-top:1px dotted #000">
  <td>Tekanan Diastolik</td>
  <td style="padding: 5px;">
      @foreach (diastolik_ews_maternal() as $item)
          <input type="radio" class="input_skor" name="formulir[diastolik]" {{@ews(@$ewss['diastolik'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
      @endforeach
      <br>
      <b>Nilai : {{@$ewss['nilai_diastolik']}}</b>
  </td>
</tr>
<tr style="border-top:1px dotted #000">
  <td>Nyeri</td>
  <td style="padding: 5px;">
      @foreach (nyeri_ews_maternal() as $item)
          <input type="radio" class="input_skor" name="formulir[nyeri]" {{@ews(@$ewss['nyeri'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
      @endforeach
      <br>
      <b>Nilai : {{@$ewss['nilai_nyeri']}}</b>
  </td>
</tr>
<tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
  <td>Total Skor</td>
  <td style="padding: 5px;" id="total_skor">
      @php
          $pernapasan = @ews(@$ewss['pernapasan'],'skor');
          $spo2 = @ews(@$ewss['spo2'],'skor');
          $suhu = @ews(@$ewss['suhu'],'skor');
          $frekuensi_jantung = @ews(@$ewss['frekuensi_jantung'],'skor');
          $sitolik = @ews(@$ewss['sitolik'],'skor');
          $diastolik = @ews(@$ewss['diastolik'],'skor');
          $nyeri = @ews(@$ewss['nyeri'],'skor');

          $total_skor = $pernapasan + $spo2 + $suhu + $frekuensi_jantung + $sitolik + $diastolik + $nyeri;
      @endphp
      {{$total_skor}}
  </td>
</tr>
<tr>
  <td colspan="2">
      <b>Urine (+)</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Protein:<input class="urine" value="{{@$ewss['urine']['protein']}}" name="formulir[urine][protein]" type="text" style="width: 50px;">&nbsp;&nbsp;
      Darah:<input class="urine" value="{{@$ewss['urine']['darah']}}" name="formulir[urine][darah]" type="text" style="width: 50px;">&nbsp;&nbsp;
      Keton:<input class="urine" value="{{@$ewss['urine']['keton']}}" name="formulir[urine][keton]" type="text" style="width: 50px;">&nbsp;&nbsp;
      Jumlah:<input name="formulir[urine][jumlah]" type="text" class="total1" style="width: 50px;" value="{{@$ewss['urine']['jumlah']}}">
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Pendarahan AnteNatal</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Kecoklatan : <input class="" {{@$ewss['antenatal']['kecoklatan'] ? 'checked' : ''}} name="formulir[antenatal][kecoklatan]" type="checkbox">&nbsp;&nbsp;
      Merah : <input class="" {{@$ewss['antenatal']['merah'] ? 'checked' : ''}} name="formulir[antenatal][merah]" type="checkbox">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Air Ketuban jika KPD</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Jernih : <input class="" {{@$ewss['ketuban']['jernih'] ? 'checked' : ''}} name="formulir[ketuban][jernih]" type="checkbox">&nbsp;&nbsp;
      Meconium : <input class="" {{@$ewss['ketuban']['Meconium'] ? 'checked' : ''}} name="formulir[ketuban][Meconium]" type="checkbox">&nbsp;&nbsp;
  </td>
</tr>
{{-- <tr>
  <td colspan="2">
      <br/>
      <b>Air Ketuban jika KPD</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Jernih : <input class="" {{@$ewss['ketuban']['jernih'] ? 'checked' : ''}} name="formulir[ketuban][jernih]" type="checkbox">&nbsp;&nbsp;
      Meconium : <input class="" {{@$ewss['ketuban']['Meconium'] ? 'checked' : ''}} name="formulir[ketuban][Meconium]" type="checkbox">&nbsp;&nbsp;
  </td>
</tr> --}}
<tr>
  <td colspan="2">
      <br/>
      <b>Tonus Uteri Post Natal</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Keras : <input class="" {{@$ewss['tonus']['Keras'] ? 'checked' : ''}} name="formulir[tonus][Keras]" type="checkbox">&nbsp;&nbsp;
      Lembek : <input class="" {{@$ewss['tonus']['Lembek'] ? 'checked' : ''}} name="formulir[tonus][Lembek]" type="checkbox">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Luka Kemerahan/<br/>Bengkak/Nyeri</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Ya : <input class="" {{@$ewss['kemerahan']['Ya'] ? 'checked' : ''}} name="formulir[kemerahan][Ya]" type="checkbox">&nbsp;&nbsp;
      Tidak : <input class="" {{@$ewss['kemerahan']['Tidak'] ? 'checked' : ''}} name="formulir[kemerahan][Tidak]" type="checkbox">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Lockea</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Normal : <input class="" {{@$ewss['lockea']['normal'] ? 'checked' : ''}} name="formulir[lockea][normal]" type="checkbox">&nbsp;&nbsp;
      Tidak Normal : <input class="" {{@$ewss['lockea']['Tidak'] ? 'checked' : ''}} name="formulir[lockea][Tidak]" type="checkbox">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Respon Neurologis</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Sadar : <input class="" {{@$ewss['Neurologis']['Sadar'] ? 'checked' : ''}} name="formulir[Neurologis][Sadar]" type="checkbox">&nbsp;&nbsp;
      Suara : <input class="" {{@$ewss['Neurologis']['Suara'] ? 'checked' : ''}} name="formulir[Neurologis][Suara]" type="checkbox">&nbsp;&nbsp;
      Nyeri : <input class="" {{@$ewss['Neurologis']['Nyeri'] ? 'checked' : ''}} name="formulir[Neurologis][Nyeri]" type="checkbox">&nbsp;&nbsp;
      Tidak Berespon : <input class="" {{@$ewss['Neurologis']['Tidak'] ? 'checked' : ''}} name="formulir[Neurologis][Tidak]" type="checkbox">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>Tinggi Fundus</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
       <input class="" value="{{@$ewss['tinggi_fundus']}}" name="formulir[tinggi_fundus]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>DJJ</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
       <input class="" value="{{@$ewss['djj']}}" name="formulir[djj]" type="text" style="width: 100px;">&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>INTAKE</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Peroral/NGT : <input class="intake" value="{{@$ewss['intake']['peroral']}}" name="formulir[intake][peroral]" type="text" style="width: 100px;">&nbsp;&nbsp;
      Parental : <input class="intake" value="{{@$ewss['intake']['parental']}}" name="formulir[intake][parental]" type="text" style="width: 100px;">&nbsp;&nbsp;
      Jumlah:<input name="formulir[intake][jumlah]" class="total2" type="text" style="width: 50px;" value="{{@$ewss['intake']['jumlah']}}">
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>OUTPUT</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
      Urine : <input class="output" value="{{@$ewss['output']['urine']}}" name="formulir[output][urine]" type="text" style="width: 70px;">&nbsp;&nbsp;
      Darah/Drain : <input class="output" value="{{@$ewss['output']['darah']}}" name="formulir[output][darah]" type="text" style="width: 70px;">&nbsp;&nbsp;
      Feses : <input class="output" value="{{@$ewss['output']['feses']}}" name="formulir[output][feses]" type="text" style="width: 70px;">&nbsp;&nbsp;
      Muntah : <input class="output" value="{{@$ewss['output']['muntah']}}" name="formulir[output][muntah]" type="text" style="width: 70px;">&nbsp;&nbsp;
      Jumlah:<input name="formulir[output][jumlah]" class="total3" type="text" style="width: 50px;" value="{{@$ewss['output']['jumlah']}}">
  </td>
</tr>
<tr>
  <td colspan="2">
      <br/>
      <b>BALANCE CAIRAN</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
       <input class="" value="{{@$ewss['balance']}}" name="formulir[balance]" type="text" style="width: 100px;">&nbsp;&nbsp;
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