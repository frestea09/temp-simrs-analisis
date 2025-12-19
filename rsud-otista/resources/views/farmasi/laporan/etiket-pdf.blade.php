<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/thermal.css">
  <title>Cetak Etiket</title>
  <style>
    .font1 {
        font-size: 14pt;
    }
    .font2 {
        font-size: 11pt;
    }
  </style>
</head>

@isset($penjualan->id)
        @php
          $det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->get();
          $no =1;
        @endphp
@foreach ($det as $key => $d)

<body onload="print()">
  <div class="ticket">
    <p class="centered">{{config('app.nama_rs')}}
      <br>
      <span style="font-size:8pt; "> Apoteker: MURNI MURSYID, S.Farm,.M.Si.APT</span>
      <table>
        <thead style="text-align: left;">
          
          <tr>
            <td class="quantity font1">Tgl Pelayanan</td>
            <td class="description font2">:  {{ date('d-m-Y', strtotime($penjualan->created_at)) }}</td>
          </tr>
          <tr>
            <td class="quantity">Nama Pasien</td>
            <td class="description" >: {{ strtoupper(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->nama) }} </td>
          </tr>
          <tr>
            <td class="quantity font1">Tgl Lahir</td>
            <td class="description font2">: {{ tgl_indo(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->tgllahir) }}</td>
          </tr>
          <tr>
            <td class="quantity font1">No RM</td>
            <td class="description font2">:  {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }}</td>
          </tr>
          <tr>
            <td class="quantity font1">Nama Obat</td>
            <td class="description font2">:  {{ substr(strtoupper($d->masterobat->nama),0,20) }}</td>
          </tr>
          <tr>
            <td class="quantity font1">Keterangan</td>
            <td class="description font2">:  {{ strtoupper($d->etiket) }} |  {{ @strtoupper(@baca_satuan_jual(@\App\LogistikBatch::where('id', $d->logistik_batch_id)->first()->satuanjual_id)) }}</td>
          </tr>
          <tr>
            <td class="quantity font1">Cara Minum</td>
            @if (\App\masterCaraMinum::where('id',$d->cara_minum_id)->first())
            <td class="description font2">:  {{ strtoupper(\App\masterCaraMinum::where('id',$d->cara_minum_id)->first()->nama) }}</td>
            @else
            <td class="description font2">:  </td>
            @endif
          </tr>
          <tr>
            <td class="quantity font1">Indikasi Obat</td>
            <td class="description font2" >:  {{ strtoupper($d->informasi1) }}</td>
          </tr>
          <tr>
            <td class="quantity font1">Tgl Kadaluarsa</td>
            <td class="description font2">:  {{ @strtoupper(@\App\LogistikBatch::where('id', $d->logistik_batch_id)->first()->expireddate) }}</td>
          </tr>
          
          {{-- <tr style="text-align: center;">
            <td class="description" colspan="2" > <b> {{ $d->etiket }} </b></td>
          </tr> --}}
          {{-- <tr>
            <td class="quantity">Pagi</td>
            <td class="description">: 07.00 - 08.00</td>
          </tr>
          <tr>
            <td class="quantity">Siang</td>
            <td class="description">: 13.00 - 14.00 </td>
          </tr>
          <tr>
            <td class="quantity">Malam</td>
            <td class="description">: 19.00 - 20.00</td>
          </tr> --}}
        </thead>
      </table>
  </div>
</body>
@endforeach
@endisset
</html>