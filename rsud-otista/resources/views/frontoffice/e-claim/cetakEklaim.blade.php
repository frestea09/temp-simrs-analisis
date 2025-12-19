<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak E-Klaim</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css" media="screen">
      body{
        font-size: 9pt;
      }
      hr{
        border-top: 1px solid #8c8b8b;
        margin-bottom: 10px;
        margin-top: 10px;
      }
      .logo{
        width: 70px;
        float: left;
        margin-right: 10px;
        margin-bottom: 10px;
      }
      .judul{
        padding-top: 15px;
        font-weight: bold;
        font-size: 12px;
        margin-left: 10px;
      }
      .judul small{
        font-weight: normal;
        font-size: 12px;
      }
      .tgl{
        float: right;
      }
    </style>

  </head>
  <body>
    <div class="logo">
      <img src="{{ public_path('/images/logo-kemenkes.jpg') }}" style="width: 100%" >
    </div>
    <div class="judul">
      KEMENTERIAN KESEHATAN REPUBLIK INDONESIA<br>
      <small><i>Berkas Klaim Individual Pasien</i></small>
    </div>
    <div class="tgl">
      {{ date('d/m/Y') }}
    </div>
    <div style="clear: both;"></div>
    <hr>

    <table style="width: 100%">
      <tr>
        <td style="width: 17%">Kode Rumah Sakit</td>
        <td style="width: 33%">: 3208013</td>
        <td style="width: 17%">Kelas Rumah Sakit</td>
        <td style="width: 33%">: C </td>
      </tr>
      <tr>
        <td>Nama RS</td> <td>: {{ strtoupper(config('app.name')) }}</td>
        <td>Jenis Tarif</td><td>: TARIF RS KELAS C PEMERINTAH</td>
      </tr>
    </table>

    <hr>

    <table style="width: 100%">
      <tr>
        <td style="width: 17%">Nomor Peserta</td>
        <td style="width: 33%">: {{ $data->no_kartu }}</td>
        <td style="width: 17%">Nomor SEP</td>
        <td style="width: 33%">: {{ $data->no_sep }}</td>
      </tr>
      <tr>
        <td>Nomor Rekam Medis</td> <td>: {{ $data->no_rm }}</td> <td>Tanggal Masuk</td><td>: {{ tanggal_eklaim($data->tgl_masuk) }}</td>
      </tr>
      <tr>
        <td>Umur Tahun</td> <td>: {{ hitung_umur($data->pasien_tgllahir) }}</td> <td>Tanggal Keluar</td><td>: {{ tanggal_eklaim($data->tgl_keluar) }}</td>
      </tr>
      <tr>
        <td>Umur Hari</td> <td>: </td>
        <td>Jenis Perawatan</td>
        <td>:
          @if (substr($registrasi->status_reg, 0, 1) == 'G' )
            2 - Rawat Jalan
          @elseif(substr($registrasi->status_reg, 0, 1) == 'J' )
            2 - Rawat Jalan
          @elseif(substr($registrasi->status_reg, 0, 1) == 'I' )
            1 - Rawat Inap
          @endif
        </td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td> <td>: {{ tgl_indo($data->pasien_tgllahir) }}</td> <td>Cara Pulang</td><td>: {{ $data->cara_keluar }} - {{ baca_carapulang($data->cara_keluar) }}</td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td> <td>: {{ ($data->pasien_kelamin == 'L') ? '1 - Laki-Laki' : '2 - Perempuan'  }}</td> <td>LOS</td><td>: {{ $data->los }} hari</td>
      </tr>
      <tr>
        <td>Kelas Perawatan</td> <td>: {{ $data->kelas_perawatan }}</td> <td>Berat Lahir</td><td>: </td>
      </tr>
    </table>

    <hr>
    @php
      $diagnosa = explode('#', $data->icd1);
      $prosedur = explode('#', $data->prosedur1);
    @endphp

    <table style="width: 100%">
        @for ($i = 0; $i < count($diagnosa) ; $i++)
          @if ($i == 0)
             <tr>
              <td style="width: 25%">Diagnosa Utama</td>
              <td>:</td>
              <td style="width: 70%">{{ $diagnosa[$i] }} - {{ baca_diagnosa($diagnosa[$i]) }}</td> <td style="width: 40%"></td>
            </tr>
          @elseif($i == 1)
             <tr>
              <td style="width: 25%">Diagnosa Sekunder</td>
              <td>:</td>
              <td style="width: 70%">{{ $diagnosa[$i] }} - {{ baca_diagnosa($diagnosa[$i]) }}</td> <td style="width: 40%"></td>
            </tr>
          @else
            <tr>
              <td style="width: 25%"></td>
              <td></td>
              <td style="width: 70%">{{ $diagnosa[$i] }} - {{ baca_diagnosa($diagnosa[$i]) }}</td> <td style="width: 40%"></td>
            </tr>
          @endif
        @endfor
    </table>

    <hr>

    <table style="width: 100%">
        @for ($i = 0; $i < count($prosedur); $i++)
          @if ($i == 0)
            <tr>
              <td style="width: 17%">Prosedur Utama</td>
                <td style="width: 43%">: {{ $prosedur[0] }} - {{ baca_prosedur($prosedur[0]) }}</td> <td style="width: 40%"></td>
            </tr>
          @else
            <tr>
              <td style="width: 17%">Prosedur Sekunder</td>
                <td style="width: 43%">: {{ $prosedur[0] }} - {{ baca_prosedur($prosedur[0]) }}</td> <td style="width: 40%"></td>
            </tr>
          @endif
        @endfor
    </table>
    @for ($i = 0; $i < 4; $i++)
      <br />
    @endfor
    <table style="width: 100%">
        <tr>
          <td style="width: 25%">ADL Sub Acute</td><td>: -</td>
          <td>ADL Chronic</td><td>: -</td>
        </tr>
    </table>

    <h5 style="font-weight: bold; font-size: 12px;">Hasil Grouping</h5><hr>
    <table style="width: 100%">
      <tr>
        <td style="width: 15%">INA-CBG</td>
        <td style="width: 15%">: {{ $data->kode }}</td>
        <td style="width: 50%">{{ $data->deskripsi_grouper }}</td>
        <td>Rp</td> <td class="text-right" style="width: 10%">{{ number_format($data->dijamin,'2','.',',') }}</td>
      </tr>
      <tr>
        <td>Sub Acute</td> <td>: -</td> <td>-</td> <td>Rp</td><td class="text-right">{{ number_format(0,'2','.',',') }}</td>
      </tr>
      <tr>
        <td>Chronic</td> <td>: -</td> <td>-</td> <td>Rp</td><td class="text-right">{{ number_format(0,'2','.',',') }}</td>
      </tr>
      <tr>
        <td>Special CMG</td> <td>: -</td> <td>-</td> <td>Rp</td><td class="text-right">{{ number_format(0,'2','.',',') }}</td>
      </tr>
    </table>
    <hr>
    <table style="width: 100%">
      <tr>
        <td style="width: 15%">Total Tarif</td>
        <td style="width: 15%">: -</td>
        <td style="width: 45%">-</td>
        <td>Rp</td>
        <td class="text-right" style="width: 10%">{{ number_format($data->dijamin,'2','.',',') }}</td>
      </tr>
    </table>

  </body>
</html>
