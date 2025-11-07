<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Detail Penjualan</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <style media="screen">
    /* @page {
          margin-top: 0.5cm;
          margin-left: 1cm;
          width: 12.5cm;
          height: 20cm;
      } */

      body{
        width: auto;
        margin-left: 25%;
        margin-right: 25%;
        font-size: 8pt;
      }

    </style>
  </head>
  <body onload="print()">

      <table style="width: 100%;">
        <tr class="text-center">
          {{-- <td style="width:23%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="height:105px;"></td> --}}
          <td>
            <h4 style="font-size: 14pt; font-weight: bold; margin-bottom: -6px;">{{ configrs()->nama }} </h4>
            {{-- {{ configrs()->pt }}  --}}
            {{-- <br> 
            NPWP: {{ configrs()->npwp }}  --}}
            {{ configrs()->alamat }}
            <br>
            Tlp. {{ configrs()->tlp }}
          </td>
        </tr>
        <tr>
          <td colspan="2">
            __________________________________________________________________________________________________________________
           </td>
        </tr>
        </table>
      <table style="100%" class="table table-bordered table-condensed">
          <tbody>
              <tr>
                  <th style="width:25%">Tanggal </th> <td>{{ $penjualan->created_at->format('m-d-y H:i:s') }}</td>
              </tr>
              <tr>
                  <th>Nama </th> <td>{{ $pasien->nama }}</td>
                  <th>No. Kuitansi </th> <td>{{ $penjualan->no_resep }}</td>
              </tr>
              <tr>
                  <th>Alamat </th> <td>{{ $pasien->alamat }}</td>
                  <th>Nama Dokter </th> <td>{{ $pasien->dokter }}</td>
              </tr>
             {{--  <tr>
                  <th>Tgl Lahir / Umur </th> <td>{{ tgl_indo($reg->pasien->tgllahir) }}  /  {{ hitung_umur($reg->pasien->tgllahir) }}</td>
              </tr>
              <tr>
                  <th>Jenis Kelamin </th> <td>{{ $reg->pasien->kelamin }}</td>
              </tr>
              <tr>
                  <th>No. RM</th> <td>{{ $reg->pasien->no_rm }}</td>
              </tr> --}}
          </tbody>
      </table>

      <table style="100%" class="table table-condensed table-bordered table-condensed">
          <thead>
              <tr>
                  <th class="text-center">No</th>
                  <th>Nama Obat</th>
                  <th class="text-center" colspan="2">Qty</th>
                  {{-- <th class="text-center">Harga</th> --}}
                  {{-- <th class="text-center">Harga Total</th> --}}
                  {{-- <th class="text-center">Uang R.</th> --}}
                  <th class="text-center">Total</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($detail as $key => $d)
                  <tr>
                      <td class="text-center">{{ $no++ }}</td>
                      <td>{{ $d->masterobat->nama }}</td>
                      <td class="text-center" colspan="2">{{ $d->jumlah }}</td>
                      {{-- <td style="text-align: right">{{ number_format(($d->hargajual))  }}</td> --}}
                      {{-- <td style="text-align: right">{{ number_format($d->uang_racik)  }}</td> --}}
                      {{-- <td style="text-align: right">{{ number_format(($d->hargajual / $d->jumlah))  }}</td> --}}
                      <td style="text-align: right">{{ number_format($d->hargajual+$d->uang_racik) }}</td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Sub Harga</th>
                  <th class="text-right">{{ number_format($total+$total_uang_racik) }}</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">Jasa</th>
                  <th class="text-right">{{ !empty($folio->jasa_racik) ? number_format($folio->jasa_racik) : 0 }}</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">Harga Total</th>
                  <th class="text-right">{{ number_format($total+ (!empty($folio->jasa_racik) ? $folio->jasa_racik : 0)+$total_uang_racik)}}</th>
                </tr>
          </tfoot>
      </table>

      <i><b>Terbilang: {{ terbilang($total+(!empty($folio->jasa_racik) ? $folio->jasa_racik : 0)+$total_uang_racik) }} Rupiah</b></i>

      <div class="pull-right">
          <div class="col-md-4">
              <table class="table">
                  <tr>
                      <td class="text-center">
                          Pembeli,
                          <br>
                          <br>
                          <br>____________________
                      </td>
                      <td class="text-center">
                          Penerima,
                          <br>
                          <br>
                          <br>____________________
                      </td>
                  </tr>
              </table>
          </div>
      </div>

      <br>
      <br>
      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('penjualanbebas') }}">

  </body>
</html>
