<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
  </head>
  <body>
    <h3>Laporan Pemakaian Obat</h3>
    <br>
    <h4 class="box-title">Detail List Pemakaian Obat</h4>
    <table class="table table-bordered table-striped" border="1" id="data">
        <thead class="bg-olive">
        <tr>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Harga Obat (Rp.)</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Terpakai (item)</th>
            <th>Stok (item)</th>
            <th>Expired</th>
            <th>Keterangan</th>
        </tr>
        </thead>
        <tbody>
            @if (!empty($pemakaian))
                @foreach ($pemakaian as $key => $d)
                <tr>
                    <td>{{ baca_obat($d->masterobat_id) }}</td>
                    <td>{{ @baca_satuan_jual_report($d->masterobat_id) }}</td>
                    <td>{{ number_format(baca_obat_harga($d->masterobat_id)) }}</td>
                    <td>{{ @historimasuk($d->masterobat_id) }}</td>
                    <td>{{ @historikeluar($d->masterobat_id) }}</td>
                    <td>{{ $d->jumlah_total+$d->jml_kronis_total }}</td>
                    <td>{{ @stok($d->masterobat_id) }}</td>
                    <td>{{ @expired($d->masterobat_id) }}</td>
                    <td>{{ @Ket($d->masterobat_id) }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
  </body>
</html>
