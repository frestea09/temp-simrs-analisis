<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lap Stock Opname</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
  </head>
  <body>
    {{-- <h3 class="text-center">LAPORAN OPNAME</h3> --}}
    <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    <br>
    <hr>
    <br>
    <h3 class="text-center">LAPORAN OPNAME</h3>
    <br>
    @if (!empty($opnames))
    <b class="box-title">Periode : Tgl {{ $tgl1 }}   s/d  {{ $tgl2 }}</b>
    @endif
    <table class="table table-bordered table-striped" border="1" id="data">
        <thead class="bg-olive">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Uraian Persediaan</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Awal</th>
            <th class="text-center">Masuk</th>
            <th class="text-center">Keluar</th>
            <th class="text-center">Sisa</th>
            <th class="text-center">Selisih</th>
            <th class="text-center">Harga Persatuan</th>
            <th class="text-center">Jumlah Harga</th>
            <th class="text-center">Harga Selisih</th>
            <th class="text-center">Expired Date</th>
            <th class="text-center">Keterangan</th>
            
        </tr>
        </thead>
        <tbody>
            @if (!empty($opnames))
                @foreach ($opnames as $key => $d)
                <tr>
                    <td class="text-center">{{ ++$key }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ @baca_satuan_jual($d->satuanjual_id) }}</td>
                    <td>{{ $d->awal }}</td>
                    <td>{{ $d->masuk }}</td>
                    <td>{{ $d->keluar }}</td>
                    <td>{{ $d->sisa }}</td>
                    <td>{{ $d->awal - $d->sisa }}</td>
                    <td>{{ number_format($d->hargajual_umum) }}</td>
                    <td>{{ number_format($d->jumlah_harga*$d->sisa) }}</td>
                    <td>{{ number_format($d->hargajual_umum) }}</td>
                    <td>{{ $d->expired_date }}</td>
                    <td>{{ $d->keterangan }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
  </body>
</html>
