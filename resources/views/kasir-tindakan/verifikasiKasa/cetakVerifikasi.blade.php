<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: 2cm;
      }
      body{
        font-size: 9pt;
        margin-left: 2cm;
        margin-right: 2cm;
        margin-bottom: 6cm;
      }
    </style>
  </head>
  <body>

    <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:80px;">
                </th>
                <th class="text-left">
                  <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
                  <p>{{ configrs()->alamat }} {{ configrs()->tlp }} </p>

                </th>
              </tr>

            </tbody>
          </table> <br>
      <hr> <br>

      <table style="width:100%">
            <tbody>
              {{-- <tr>
                <td colspan="2"></td>
              </tr> --}}
              <tr>
                <td style="width:25%">Nama / Jenis Kelamin</td> <td>: {{ !empty($reg->pasien->nama) ? strtoupper($reg->pasien->nama) : NULL }} 
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/  &nbsp;&nbsp;&nbsp; {{ !empty($reg->pasien->kelamin) ? strtoupper($reg->pasien->kelamin) : NULL }}</td>
              </tr>
              <tr>
                <td>Umur </td> <td>: {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }}</td>
              </tr>
              <tr>
                <td style="width:25%">Nomor Rekam Medis</td> <td>: {{  baca_norm($reg->pasien_id) }}</td>
              </tr>
              <tr>
                <td style="width:25%">Alamat</td> <td>: {{ !empty($reg->pasien->alamat) ? strtoupper($reg->pasien->alamat) : NULL }} {{ !empty($reg->pasien->regency_id) ? (strtoupper($reg->pasien->regency_id)) : NULL }}</td>
              </tr>
              @if (!empty($reg->no_sep))
                <tr>
                  <td>No. SEP</td><td>: {{ $reg->no_sep }}</td>
                </tr>
              @endif

              @if (!empty($reg->status_reg))
                  @if ( substr($reg->status_reg,0,1) == 'I' )
                    <tr>
                      <td>Tanggal Perawatan</td><td>: {{ tanggal($irna->tgl_masuk) }} s/d {{ tanggal($irna->tgl_keluar) }}</td>
                    </tr>
                    {{-- <tr>
                      <td>Bangsal / BED</td> <td>: {{ baca_kamar($irna->kamar_id) }} / {{ baca_bed($irna->bed_id) }}</td>
                    </tr> --}}
                    <tr>
                      <td>DPJP</td> <td>: {{ baca_dokter($irna->dokter_id) }}</td>
                    </tr>
                  @else
                    <tr>
                      <td>Tanggal Registrasi</td><td>: {{ $reg->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    <tr>
                      <td>Klinik Tujuan</td><td>: {{ strtoupper( baca_poli($reg->poli_id)) }}</td>
                    </tr>
                    <tr>
                      <td>DPJP</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
                    </tr>
                  @endif
                  
              @endif
             
                <tr>
                  <td>Cara Bayar</td> <td>: {{ !empty($reg->bayar) ? baca_carabayar($reg->bayar) : NULL }} {{ (!empty($reg->bayar) && !empty($reg->tipe_jkn)) ? $reg->tipe_jkn : NULL }}</td>
                </tr>
            </tbody>
          </table>
          <br>

          <h5 style="text-align: center;">Rincian Biaya Perawatan</h5>

            <table class="table table-bordered" style="width: 100%">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Tarif</th>
                  {{-- <th class="text-center">Biaya@</th> --}}
                  {{-- <th class="text-center">Qty</th> --}}
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($folio as $d)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    {{-- <td>{{ $d->tarif->nama }} {{ $d->namatarif }}</td> --}}
                    <td>{{$d->kelompok ? $d->kelompok : 'Penjualan/ADM'}}</td>
                    {{-- <td>{{ empty($d->tarif->nama) ? $d->tarif->nama : 'Tidak ada Tindakan Rawat Jalan' }}</td> --}}
                    {{-- <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : '-' }}</td> --}}
                    {{-- <td class="text-center">{{ ($d->tarif->total <> 0) ? round(($d->total / $d->tarif->total)) : NULL }}</td> --}}
                    {{-- <td class="text-center">{{ ($d->tarif->total <> 0 ) ? $d->jumlah : '-' }}</td> --}}
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-right">Total Biaya Perawatan</th>
                  <th class="text-right">{{ number_format($jml) }}</th>
                </tr>
              </tfoot>
            </table>

          <p><b><i>Terbilang: {{ terbilang($jml) }} {{ ($jml > 0) ? ' Rupiah' : NULL  }}</i></b></p>

          <table style="width: 100%">
            <tr>
              <td style="width: 50%"></td>
              <td style="width: 50%" class="text-center">
                {{ configrs()->kota }},

                @if ( substr($reg->status_reg,0,1) == 'I' )
                 {{ date('d-m-Y', strtotime($irna->tgl_keluar)) }}

                @else
                 {{ date('d-m-Y', strtotime($reg->created_at)) }}
                 @endif
                 
                 <br>
                Verifikator <br><br><br>
                <u><b>{{ !empty($user_kasa->verif_kasa_user) }}</b></u>
              </td>
            </tr>
          </table>

  </body>
</html>
