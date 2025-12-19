<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kriteria Masuk ICU</title>
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
    <th colspan="6" style="font-size: 14pt;">FORMULIR KRITERIA PASIEN MASUK ICU</th>
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
      <th style="width:75%;">PRIORITAS</th>
      <th style="width:10%;">Ya</th>
      <th style="width:10%;">Tidak</th>
    </tr>
  </thead>
  <tbody>
    <!-- PRIORITAS I -->
    <tr>
      <td class="text-center" style="width:5%;">1</td>
      <td colspan="3" class="bold" style="width:95%;">PRIORITAS I</td>
    </tr>
    <tr>
      <td></td>
      <td>1. Pasien kritis tidak stabil <br>
        Tensi: {{ @$assesment['pasien_masuk']['tensi'] }} mmHg,
        HR: {{ @$assesment['pasien_masuk']['hr'] }} x/menit,
        Suhu: {{ @$assesment['pasien_masuk']['suhu'] }} °C,
        GCS: {{ @$assesment['pasien_masuk']['gcs'] }},
        SpO2: {{ @$assesment['pasien_masuk']['spo2'] }} %,
        RR: {{ @$assesment['pasien_masuk']['rr'] }} x/menit
      </td>
      <td class="text-center check">{!! centang(@$assesment['pasien_masuk']['prioritasI']['checkbox']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_masuk']['prioritasI']['checkbox']['1']) !!}</td>
    </tr>
    <tr>
      <td></td>
      <td>
        2. Pasien memerlukan bantuan ventilasi/intubasi (RM, NRM, NIV, Ventilator) <br>
        a. Adanya gagal napas <br>
        &nbsp;- Apneu / Henit napas <br>
        &nbsp;- Inadekuat ventilasi <br>
        &nbsp;- Inadekuat oksigenasi <br>
        b. Insufiensi fungsi respirasi dengan gagal tumbuh kembang <br>
        c. Insufiensi kardiak/syok <br>
        &nbsp;- Mengurangi work of breathing <br>
        &nbsp;- Mengurangi konsumsi oksigen <br>
        d. Disfungsi neurologis <br>
        e. Hipoventilasi sentral / frequent apnea <br>
        f. Penurunan kesadaran/ GCS ≤ 8 <br>
        g. Ketidakmampuan mempertahankan jalan napas  <br>
      </td>
      <td class="text-center check">{!! centang(@$assesment['pasien_masuk']['prioritasI']['checkbox']['2']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_masuk']['prioritasI']['checkbox']['2']) !!}</td>
    </tr>
    <tr>
      <td></td>
      <td>3. Pasien memerlukan obat-obat vasoaktif (dopamin, dobutamin, NE (Norepineprin), adrenalin)</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_masuk']['prioritasI']['checkbox']['3']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_masuk']['prioritasI']['checkbox']['3']) !!}</td>
    </tr>

    <!-- PRIORITAS II -->
    <tr>
      <td class="text-center">2</td>
      <td colspan="3" class="bold">PRIORITAS II</td>
    </tr>
    <tr>
      <td></td>
      <td>Pasien yang memerlukan observasi ketat dan kondisinya sewaktu-waktu dapat berubah</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_masuk']['prioritasII']['checkbox']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_masuk']['prioritasII']['checkbox']['1']) !!}</td>
    </tr>

    <!-- PRIORITAS III -->
    <tr>
      <td class="text-center">3</td>
      <td colspan="3" class="bold">PRIORITAS III</td>
    </tr>
    <tr>
      <td></td>
      <td>Pasien dengan kriteria primer berat atau terminal dengan komplikasi penyakit akut kritis yang memerlukan pertolongan untuk penyakit kritisnya tetapi tidak sampai intubasi dan RJP</td>
      <td class="text-center check">{!! centang(@$assesment['pasien_masuk']['prioritasIII']['checkbox']['1']) !!}</td>
      <td class="text-center check">{!! silang(@$assesment['pasien_masuk']['prioritasIII']['checkbox']['1']) !!}</td>
    </tr>

    <!-- SESUAI DIAGNOSA PENYAKIT -->
    <tr>
      <td class="text-center">4</td>
      <td colspan="3" class="bold">SESUAI DIAGNOSA PENYAKIT</td>
    </tr>

    @php
      $diagnosa = [
        1 => ['label' => 'a. Pasien Kardiovaskuler', 'field' => 'pasien_kardiovaskuler'],
        2 => ['label' => 'b. Pasien Pernapasan', 'field' => 'pasien_pernapasan'],
        3 => ['label' => 'c. Pasien Neurologis', 'field' => 'pasien_neurologis'],
        4 => ['label' => 'd. Pasien Overdosis / Keracunan Obat', 'field' => 'pasien_overdosis'],
        5 => ['label' => 'e. Pasien Gastrointestinal', 'field' => 'pasien_gastrointesinal'],
        6 => ['label' => 'f. Pasien Endokrin', 'field' => 'pasien_endokrin'],
        7 => ['label' => 'g. Pasien Bedah', 'field' => 'pasien_bedah'],
        8 => ['label' => 'h. Lain-lain', 'field' => 'lain_lain']
      ];
    @endphp

    @foreach ($diagnosa as $i => $d)
      <tr>
        <td></td>
        <td>{{ $d['label'] }}<br>Diagnosa: {{ @$assesment[$d['field']] }}</td>
        <td class="text-center check">{!! centang(@$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox'][$i]) !!}</td>
        <td class="text-center check">{!! silang(@$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox'][$i]) !!}</td>
      </tr>
    @endforeach

  </tbody>
</table>
<br><br>
{{-- <span>Berdasarkan kondisi diatas maka pasien tersebut memenuhi kriteria untuk keluar dari ruangan ICU</span> --}}
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
