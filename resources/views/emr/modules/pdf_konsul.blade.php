<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Konsul {{ $dataKonsul['namaPasien'] }}</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
        }
    </style>
  </head>
  <body>


    <table>
        <tr>
          <th colspan="1" style="width: 25%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="2" style="font-size: 18pt;">
            <b>KONSULTASI ANTAR DOKTER</b>
          </th>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Nama Pasien</b>
            </td>
            <td colspan="2">
              {{ $dataKonsul['namaPasien'] }}
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>No RM</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['noRM'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Tanggal Konsul</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['waktuKonsul'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Dokter Pengirim Konsul</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['dokterPengirim'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Isi Konsul</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['alasanKonsul'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Dokter Penjawab Konsul</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['dokterPenjawab'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Jawaban Konsul</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['jawabKonsul'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Anjuran</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['anjuran'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Keterangan</b>
            </td>
            <td colspan="2">
             {{ $dataKonsul['keterangan'] }}
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width: 25%;">
                <b>Tanggal Jawab Konsul</b>
            </td>
            <td colspan="2">
             {{ @$dataKonsul['tanggalJawab'] }}
            </td>
        </tr>
    </table>

    <table style="width: 100%; border: none !important; border-collapse: collapse !important;">
        @php
            $pegawai = Modules\Pegawai\Entities\Pegawai::find(@$reg->dokter_id);
            $base64  = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dataKonsul['dokterPenjawab'] . ' | ' . @$dataKonsul['waktuKonsul']))
        @endphp
        <tr>
            <td style="width: 50%; text-align:center; border: none !important;"></td>
            <td style="width: 50%; text-align:center; border: none;">Dokter</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align:center; border: none !important;"></td>
            <td style="width: 50%; text-align:center; border: none !important;">
                <img src="data:image/png;base64, {!! $base64 !!} ">
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align:center; border: none !important;"></td>
            <td style="width: 50%; text-align:center; border: none !important;">{{ $dataKonsul['dokterPenjawab'] }}</td>
        </tr>
    </table>

  </body>
</html>
 