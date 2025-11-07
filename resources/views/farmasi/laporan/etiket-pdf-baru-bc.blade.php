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
        font-size: 10pt;
    }
    .font2 {
        font-size: 9pt;
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
    {{-- <p class="centered">Instalasi Farmasi RSU ST.MADYANG</p> --}}
      {{-- <br> --}}
      {{-- <span style="font-size:8pt; "> Apoteker: MURNI MURSYID, S.Farm,.M.Si.APT</span> --}}
      <table>
        <thead style="text-align: center;">
          {{-- <tr>
            <td colspan="4" class="text-center">Instalasi Farmasi {{config('app.nama_rs')}}</td>
          </tr> --}}
          {{-- <tr>
            <td colspan="4" class="text-center">Apoteker: MURNI MURSYID, S.Farm,.M.Si.APT</td>
          </tr> --}}
        </thead>
      </table>
      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 40px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:9px;">{{ configrs()->nama }}</b><br/>
            <b style="font-size:9px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            <b style="font-size:9px;">INSTALASI FARMASI</b>
          </td>
          <td style="width:10%;">
            {{-- <img src="https://www.pontijaya.com/img/paripurna.jpg" style="width: 60px;"> --}}
          </td>
        </tr>
      </table>
      <br>
      <table>
        <thead style="text-align: left;">
          <tr>
            <td class="quantity font1">Tgl Pelayanan :  {{ date('d-m-Y', strtotime($penjualan->created_at)) }}</td>
            {{-- <td class="description font2" style="text-align: right;">:  {{ date('d-m-Y', strtotime($penjualan->created_at)) }}</td> --}}
          </tr>
          <tr>
            {{-- <td class="quantity">Nama Pasien</td> --}}
            <td class="description" >{{ strtoupper(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->nama) }} / {{ tgl_indo(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->tgllahir) }} / {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }} </td>
            {{-- <td class="quantity font1">No RM</td> --}}
            {{-- <td class="description font2">:  {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }}</td> --}}
          </tr>
          <tr>
            {{-- <td class="quantity font1">Tgl Lahir</td> --}}
            <td class="description font2">{{ substr(strtoupper($d->masterobat->nama),0,20) }} / {{ strtoupper($d->informasi1) }}</td>
            {{-- <td class="quantity font1">Indikasi Obat</td> --}}
            {{-- <td class="description font2" >:  {{ strtoupper($d->informasi1) }}</td> --}}
          </tr>
          {{-- <tr>
            <td class="quantity font1">No RM</td>
            <td class="description font2">:  {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }}</td>
          </tr> --}}
          <tr>
            {{-- <td class="quantity font1">Nama Obat</td> --}}
            {{-- <td class="description font2">:  {{ substr(strtoupper($d->masterobat->nama),0,20) }}</td> --}}
            {{-- <td class="quantity font1">Cara Minum</td> --}}
            @if (\App\masterCaraMinum::where('id',$d->cara_minum_id)->first())
            <td class="description font2"><b>{{ strtoupper(\App\masterCaraMinum::where('id',$d->cara_minum_id)->first()->nama) }}</b></td>
            @else
            <td class="description font2"></td>
            @endif
          </tr>
          <tr>
            {{-- {{ dd(\App\LogistikBatch::where('id', $d->logistik_batch_id)->first()) }} --}}
            {{-- <td class="quantity font1">Keterangan</td> --}}
            @if( \App\LogistikBatch::where('id', $d->logistik_batch_id)->first() )
            <td class="description font2"><b>{{ strtoupper($d->etiket) }} |  {{ strtoupper(baca_satuan_jual(\App\LogistikBatch::where('id', $d->logistik_batch_id)->first()->satuanjual_id)) }}</b></td>
            @else
            <td class="description font2"><b>{{ strtoupper($d->etiket) }} |  </b></td>
            @endif
          </tr>
          {{-- <tr>
            <td class="quantity font1">Cara Minum</td>
            @if (\App\masterCaraMinum::where('id',$d->cara_minum_id)->first())
            <td class="description font2">:  {{ strtoupper(\App\masterCaraMinum::where('id',$d->cara_minum_id)->first()->nama) }}</td>
            @else
            <td class="description font2">:  </td>
            @endif
          </tr> --}}
          {{-- <tr>
            <td class="quantity font1">Indikasi Obat</td>
            <td class="description font2" >:  {{ strtoupper($d->informasi1) }}</td>
          </tr> --}}
          <tr>
            {{-- <td class="quantity font1">Tgl Kadaluarsa</td> --}}
            @if( \App\LogistikBatch::where('id', $d->logistik_batch_id)->first() )
            <td class="description font2">  {{ strtoupper(\App\LogistikBatch::where('id', $d->logistik_batch_id)->first()->expireddate) }}</td>
            @else
            <td class="description font2">-</td>
            @endif
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

      <br>
  </div>
</body>
<META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('penjualan/jalan-baru') }}">
@endforeach
@endisset
</html>