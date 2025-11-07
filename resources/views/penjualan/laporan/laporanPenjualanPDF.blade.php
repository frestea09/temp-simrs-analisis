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
    <h3>Laporan Penjualan</h3>

    @isset ($penjualan)
        <h4>Periode: {{ $tga }} s/d {{ $tgb }}</h4>
        <div class="table-responsive">
            <table class="table-hover table-condensed table-bordered table-report table">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">RAWAT JALAN</th>
                        <th class="text-center">RAWAT INAP</th>
                        <th class="text-center">GAWAT DARURAT</th>
                        <th class="text-center">IBS</th>
                        <th class="text-center">Penjualan Bebas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Jumlah Penjualan</b></td>
                        <td>{{ number_format(@$hasilJalan['jumlah_penjualan']) }}</td>
                        <td>{{ number_format(@$hasilIRNA['jumlah_penjualan']) }}</td>
                        <td>{{ number_format(@$hasilIGD['jumlah_penjualan']) }}</td>
                        <td>{{ number_format(@$hasilOperasi['jumlah_penjualan']) }}</td>
                        <td>{{ number_format(@$hasilBebas['jumlah_penjualan']) }}</td>
                    </tr>
                    <tr>
                        <td><b>Jumlah Penjualan</b></td>
                        <td>{{ number_format(@$hasilJalan['total_harga_jual']) }}</td>
                        <td>{{ number_format(@$hasilIRNA['total_harga_jual']) }}</td>
                        <td>{{ number_format(@$hasilIGD['total_harga_jual']) }}</td>
                        <td>{{ number_format(@$hasilOperasi['total_harga_jual']) }}</td>
                        <td>{{ number_format(@$hasilBebas['total_harga_jual']) }}</td>
                    </tr>
                    <tr>
                        <td><b>Jumlah Penjualan</b></td>
                        <td>{{ number_format(@$hasilJalan['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilIRNA['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilIGD['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilOperasi['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilBebas['total_harga_jual_pokok']) }}</td>
                    </tr>
                    <tr>
                        <td><b>Jumlah Penjualan</b></td>
                        <td>{{ number_format(@$hasilJalan['total_harga_jual'] - @$hasilJalan['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilIRNA['total_harga_jual'] - @$hasilIRNA['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilIGD['total_harga_jual'] - @$hasilIGD['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilOperasi['total_harga_jual'] - @$hasilOperasi['total_harga_jual_pokok']) }}</td>
                        <td>{{ number_format(@$hasilBebas['total_harga_jual'] - @$hasilBebas['total_harga_jual_pokok']) }}</td>
                    </tr> - 
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table-hover table-bordered table-condensed table" id="dataPenjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Faktur</th>
                        <th>Nama Pasien</th>
                        <th>No. RM</th>
                        <th class="text-center">Total</th>
                        <th>Jenis Pasien</th>
                        <th class="text-center">Tanggal</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    @if (true)
                        @foreach ($penjualan as $d)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $d->namatarif }}</td>
                                <td>{{ @$d->pasien_id == 0 ? 'Pasien Langsung' : @$d->nama_pasien }}</td>
                                <td>{{ $d->pasien_id == 0 ? 'Pasien Langsung' : @$d->no_rm }}</td>
                                <td class="text-right">{{ number_format($d->total) }}</td>
                                <td class="text-center">
                                    {{ !empty($d->cara_bayar_id) ? $d->carabayar : 'Penjualan Langsung' }}</td>
                                <td class="text-right">{{ $d->created_at->format('d-m-Y') }}</td>
                                <td>{{ $d->username }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th class="text-center" colspan="8">Data lebih dari 3000 tidak bisa di tampilkan</th>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
      @endisset
  </body>
</html>
