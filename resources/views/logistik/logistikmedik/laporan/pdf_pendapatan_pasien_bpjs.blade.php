<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    
  </head>
  <body>
    <h3>Laporan Pendapatan Pasien BPJS</h3>
        <table class="table table-bordered table-striped" id="data" border="1">
            <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Pasien</th>
                <th class="text-center">Jumlah</th>
            </tr>
            </thead>
            <tbody>
                @if (!empty($reg))
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($reg as $d)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ !empty($d->pasien_id) ? baca_pasien($d->pasien_id) :'' }}</td>
                            <td>{{ number_format(\Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('tarif_id', 10000)->sum('total')) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
  </body>
</html>
