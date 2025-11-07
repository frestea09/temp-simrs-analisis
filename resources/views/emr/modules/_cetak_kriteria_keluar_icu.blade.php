<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kriteria Keluar ICU</title>
<style>
  * {
    font-family: sans-serif;
    font-size: 10pt;
  }

  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid black;
    padding: 5px;
    vertical-align: top;
    word-wrap: break-word;
  }

  th {
    text-align: center;
    font-weight: bold;
  }

  .text-center { text-align: center; }
  .bold { font-weight: bold; }

  @page { margin: 20px; }
  body { margin: 10px; }

  .check {
    font-family: 'DejaVu Sans', sans-serif;
    font-weight: bold;
    font-size: 12pt;
  }
  .no-border,
  .no-border th,
  .no-border td {
    border: none !important;
  }
</style>
</head>
<body>

<table>
  <tr>
    <th colspan="6" style="font-size: 14pt;">FORMULIR KRITERIA PASIEN KELUAR ICU</th>
  </tr>
  <tr>
    <td colspan="6"><b>TANGGAL PEMERIKSAAN:</b> {{ date('d-m-Y', strtotime(@$cetak->created_at)) }}</td>
  </tr>
  <tr>
    <td colspan="2"><b>Nama Pasien</b><br>{{ $reg->pasien->nama }}</td>
    <td colspan="2"><b>Tgl. Lahir</b><br>{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }}</td>
    <td><b>Jenis Kelamin</b><br>{{ $reg->pasien->kelamin }}</td>
    <td><b>No MR</b><br>{{ $reg->pasien->no_rm }}</td>
  </tr>
  <tr>
    <td colspan="5"><b>Alamat Lengkap</b><br>{{ $reg->pasien->alamat }}</td>
    <td><b>No Telp</b><br>{{ $reg->pasien->nohp }}</td>
  </tr>
</table>

<br>

@php
  $assesment = json_decode($cetak->fisik, true);
  function centang($val) {
      return $val == 'YA' ? '&#10004;' : '';
  }
  function silang($val) {
      return $val == 'TIDAK' ? '&#10004;' : '';
  }
@endphp


<table style="width:100%; border-collapse: collapse;">
  <thead>
    <tr>
      <th style="width:5%;">No</th>
      <th style="width:75%;">KRITERIA</th>
      <th style="width:10%;">Ya</th>
      <th style="width:10%;">Tidak</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center">1</td>
      <td colspan="3" class="bold">KRITERIA PASIEN KELUAR ICU</td>
    </tr>

    <tr>
      <td></td>
      <td>1. Pasien tidak lagi memerlukan alat atau obat life support</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_keluar']['checkbox']['1']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_keluar']['checkbox']['1']['1']) !!}</td>
    </tr>

    <tr>
      <td></td>
      <td>2. Masker NRM / RM / NIV / Ventilator</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_keluar']['checkbox']['1']['2']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_keluar']['checkbox']['1']['2']) !!}</td>
    </tr>

    <tr>
      <td></td>
      <td>3. Penghentian obat-obat vasoaktif (Dopamin, Dobutamin, NE (Norepineprin), Adrenalin)</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_keluar']['checkbox']['1']['3']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_keluar']['checkbox']['1']['3']) !!}</td>
    </tr>

    <tr>
      <td class="text-center">2</td>
      <td>Terapi telah dinyatakan gagal, prognosis jangka pendek jelek dan manfaat terapi intensif kecil (misal gagal multi organ tidak berespon terhadap terapi agresif)</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_keluar']['checkbox']['2']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_keluar']['checkbox']['2']['1']) !!}</td>
    </tr>

    <tr>
      <td class="text-center">3</td>
      <td>Pasien dalam kondisi stabil (sesuai parameter baseline) dan kemungkinan kebutuhan terapi intensif mendadak kecil <br>
        Tensi: {{ @$assesment['pasien_keluar']['tensi'] }} mmHg,
        HR: {{ @$assesment['pasien_keluar']['hr'] }} x/menit,
        Suhu: {{ @$assesment['pasien_keluar']['suhu'] }} °C,
        GCS: {{ @$assesment['pasien_keluar']['gcs'] }},
        SpO2: {{ @$assesment['pasien_keluar']['spo2'] }} %,
        RR: {{ @$assesment['pasien_keluar']['rr'] }} x/menit
      </td>
      <td class="text-center check">{!! centang(@$assesment['pasien_keluar']['checkbox']['3']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_keluar']['checkbox']['3']['1']) !!}</td>
    </tr>

    <tr>
      <td class="text-center">4</td>
      <td>Manfaat terapi intensif kecil karena penyakit primer sudah terminal, tidak berespon terhadap terapi ICU, prognosis jangka pendek buruk, dan tidak ada terapi potensial untuk memperbaikinya</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_keluar']['checkbox']['4']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_keluar']['checkbox']['4']['1']) !!}</td>
    </tr>

    <tr>
      <td class="text-center">5</td>
      <td>Lain-lain<br>Diagnosa: {{ @$assesment['pasien_keluar']['lain_lain'] }}</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_keluar']['checkbox']['5']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_keluar']['checkbox']['5']['1']) !!}</td>
    </tr>

  </tbody>
</table>
<br><br>
<span>Berdasarkan kondisi diatas maka pasien tersebut memenuhi kriteria untuk keluar dari ruangan ICU</span>
<table style="width: 100%;" class="no-border text-center">
  <tr>
    <td style="width: 50%;"></td>
    <td style="width: 50%;">Dokter</td>
  </tr>
  <tr>
    <td style="width: 50%;"></td>
    <td style="width: 50%;"><br><br><br></td>
  </tr>
  <tr>
    <td style="width: 50%;"></td>
    <td style="width: 50%;">{{@$dokter->nama}}</td>
  </tr>
</table>
</body>
</html>
