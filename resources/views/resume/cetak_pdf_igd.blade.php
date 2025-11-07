<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Pasien</title>
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
            <th colspan="6">
                <b>RESUME MEDIS</b> <br>
                (SUMMARY LIST)
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
                {{ $reg->pasien->kelamin }}
            </td>
            <td>
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Nama Jelas DPJP</b>
            </td>
            <td colspan="5">
                {{ baca_dokter($reg->dokter_id) }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Jenis Pembayaran</b>
            </td>
            <td colspan="5">
                {{ baca_carabayar($reg->bayar) }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Riwayat Alergi</b>
            </td>
            <td colspan="5">
                
            </td>
        </tr>
        <tr>
            <th>Tanggal/Jam Berkunjung</th>
            <th>Pengobatan / Tindakan</th>
            <th>Anjuran</th>
            <th>Diagnosa Akhir</th>
            <th>Prosedur</th>
            <th>Dokter yang memeriksa</th>
        </tr>
        @foreach ($resume as $key => $d)
        <tr>
            <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y H:i:s') }}</td>
            <td>{{ $d->pengobatan }}</td>
            <td>{{ $d->bb }}</td>
            <td>{!! $d->diagnosa !!}</td>
            <td>{!! $d->tindakan !!}</td>
            {{-- <td>{{ baca_rencanakontrol($d->id) ? baca_rencanakontrol($d->id) : date('d-m-Y',strtotime($spri->tgl_rencana_kontrol)) }}</td> --}}
            <td>{{ $d->dokter }}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="2">Anamnesis</th>
            <th>Pemeriksaan (Fisik/Lab.DII)</th>
            <th>Prognosa</th>
            <th>Lain-lain</th>
            <th>Tanggal Dicetak</th>
        </tr>

        @if ($soap)
            @foreach ($soap as $item)
            <tr>
                <td colspan="2">{{$item->subject}}</td>
                <td>{{$item->object}}</td>
                <td>{{$item->assesment}}</td>
                <td>{{$item->planning}}</td>
                <td>{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</td>
            </tr>
                
            @endforeach
            
        @endif
    </table>
    <br>
    <!-- <table>
        <tr>
            <td style="text-align: right !important!;">
                Dicetak Tanggal<br>
                {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
            </td>
        </tr>
    </table> -->

  </body>
</html>
 