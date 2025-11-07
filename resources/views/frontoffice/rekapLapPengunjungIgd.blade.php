<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style>
        body {
            font-size: 11px;
            margin: 1em;
        }

        .v-middle {
            vertical-align: middle !important;
        }

        .no-wrap {
            white-space: nowrap
        }

        .table-bordered th,
        .table-bordered td {
            border: 2px solid #ddd !important;
        }
    </style>
</head>

<body onload="print()">
    <h3 style="text-align: center">Gawat Darurat - Laporan Pengunjung</h3>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No. RM</th>
              <th>Umur</th>
              <th>Waktu Kunj</th>
              <th>Ibu kandung</th>
              <th>No Handphone</th>
              <th>provinsi</th>
              <th>kabupaten</th>
              <th>kecamatan</th>
              <th>desa</th>
              <th>Klinik Tujuan</th>
              <th>Cara Bayar</th>
              <th>Dokter</th>
              <th>Jenis Pasien</th>
              <th>Petugas</th>
              <th>Diagnosa</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              @php
                $reg = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
              @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->nama }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->alamat }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->no_rm }}</td>
                <td>{{ hitung_umur(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->tgllahir) }}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($d->created_at))}}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->ibu_kandung }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->nohp }}</td>
                <td>{{ Modules\Pasien\Entities\Province::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->province_id)->name }}</td>
                <td>{{ Modules\Pasien\Entities\Regency::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->regency_id)->name }}</td>
                <td>{{ Modules\Pasien\Entities\District::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->district_id)->name }}</td>
                <td>{{ Modules\Pasien\Entities\Village::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->village_id)->name }}</td>
                <td>
                  @if ($reg)
                    {{ baca_poli($reg->poli_id) }}
                  @else 
                    {{ NULL }}
                  @endif
                </td>
                <td>{{ baca_carabayar($d->bayar) }} {{@$d->tipe_jkn}}</td>
                <td>
                  @if ($reg)
                    {{ baca_dokter($reg->dokter_id) }}
                  @else 
                    {{ NULL }}
                  @endif
                </td>
                <td>
                  @if (!empty($reg->status) )
                    {{ $reg->status }}
                  @else 
                    {{ NULL }}
                  @endif
                </td>
                <td>{{ @baca_user(@$reg->user_create) }}</td>
                <td>{{ @$reg->diagnosa_awal }}</td>
                <td>{{ @$reg->keterangan }}</td>
              </tr>
            @endforeach

          </tbody>
    </table>
</body>

</html>