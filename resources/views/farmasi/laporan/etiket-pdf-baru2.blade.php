<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/thermal.css">
  <title>Cetak Etiket</title>
  <style>
    /* .font1 {
        font-size: 5pt;
    }
    .font2 {
        font-size: 3pt;
    } */
    @page {
          width: 100px;
          margin-left: 2cm;
          /* margin-bottom: 10cm; */
          height: 50px;
          font-size: 8pt;
          align-items: center;
          text-align: center;
          justify-items: center;
          justify-content: center;
          margin-top: 1cm;
}
  </style>
</head>
@isset($penjualan->id)
        @php
          $det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->groupBy('masterobat_id')->select('*', DB::raw('SUM(jumlah) as jumlahTotal'), DB::raw('SUM(hargajual) as hargaTotal'))->get();
          $no =1;
        @endphp
@foreach ($det as $key => $d)
<body onload="print()">
  <div class="ticket">
      <table>
        <thead style="text-align: center;">
        </thead>
      </table>
      <table> 
        <tr>
          <td>
            <img src="{{ asset('/images/'.configrs()->logo) }}"style="width: 50px;height:50px">
          </td>
          
      
          <td style="text-align: left">
            <div class="text-center">
              <span style="font-size:8px;font-family:Arial" class="text-ceter"><b>INSTALASI FARMASI</b></span>
            </div>
            <span style="font-size:8px;font-family:Arial"><b>{{ configrs()->nama }}</b></span><br>
            <span style="font-size:8px;font-family:Arial"><b>Telp : {{ configrs()->tlp }}</b></span><br>
            <span style="font-size:8px;font-family:Arial"><b>Apoteker : Apt.Adiyah, S.Farm.,MMRS</b></span><br>
            <span style="font-size:8px;font-family:Arial"><b>503/0403-SIPA/DPMPTSP/XII/2022</span><br></b>
           <hr>
          </td>
        </tr>
      </table>
      <table style="text-align: left;">
        <tbody>
          {{-- <tr>
            <th style="font-size:12px;font-family:Arial"></th> <td style="font-size:12px;">{{ date('d-m-Y h:i', strtotime($penjualan->created_at)) }}</td>
            <th style="font-size:12px;font-family:Arial"></th> <td style="font-size:12px;"></td> 
          </tr> --}}
          {{-- <tr>
            <th style="font-size:12px;font-family:Arial">No.RM</th> <td style="font-size:12px;">: {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }} , Tgl.Lahir : {{ tgl_indo(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->tgllahir) }}</td>
           
          </tr> --}}
          {{-- <tr>
            <th style="font-size:12px;font-family:Arial">Nama</th> <td style="font-size:12px;">: {{ strtoupper(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->nama) }} / {{ strtoupper(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->kelamin == 'L') ? 'L' : 'P' }} / {{ hitung_umur(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->tgllahir,'Y') }} </td>
          </tr> --}}

          <tr>
            <th style="font-size:10px;font-family:Arial"> {{ @$resep_dokter->kelompok }} {{ @$resep_dokter->nomor }}/{{ @$reg->poli->kode_loket == 'B' ? 'lt G' : (@$reg->poli->kode_loket == 'C' ? 'lt 1' : '-') }}</th> <td style="font-size:10px;font-family:Arial;padding-left:130px"><b>Tgl : {{ date('d-m-Y', strtotime($penjualan->created_at)) }}</b></td>
            <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"> </td>
          </tr>
          <tr>
            <th style="font-size:10px;font-family:Arial">Pro </th> <td style="font-size:10px;font-family:Arial"><b> : {{ @$reg->pasien->nama }} / {{ strtoupper( @$reg->pasien->kelamin == 'L') ? 'L' : 'P' }} / {{ hitung_umur(@$reg->pasien->tgllahir,'Y') }}</b></td>
            <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"> </td>
          </tr>
          <tr>
            <th style="font-size:10px;font-family:Arial">No.RM</th> <td style="font-size:10px;font-family:Arial"><b> : {{ @$reg->pasien->no_rm }}</b></td>
            <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"></td>
          </tr>
          {{-- <tr>
            <th style="font-size:10px;font-family:Arial">Tgl.Lahir </th> <td style="font-size:10px;font-family:Arial"><b> : {{ @$reg->pasien->tgllahir }}</b></td>
            <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"> </td>
          </tr>
          <tr>
            <th style="font-size:10px;font-family:Arial">Lantai </th> <td style="font-size:10px;font-family:Arial"><b> : {{ @$reg->poli->kode_loket == 'B' ? 'lt G' : (@$reg->poli->kode_loket == 'C' ? 'lt 1' : '-') }}</b></td>
            <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"> </td>
          </tr> --}}
          {{-- <tr>
            <th style="font-size:10px;font-family:Arial"></th> <td style="font-size:10px;font-family:Arial; text-align: center;">Aturan Pakai</td>
            <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"></td>
          </tr> --}}
          {{-- <tr>
            <th style="font-size:10px;font-family:Arial"></th> <td style="font-size:10px;font-family:Arial; text-align: center;">CARA MINUM</td>
            <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"></td>
          </tr> --}}
         


        </tbody>
        <table style="text-align: left">
          <tbody>
            <tr style="text-align: center;">
              @if (\App\masterCaraMinum::where('id',$d->cara_minum_id)->first())
              <td style="font-size:10px;font-family:Arial; text-align: center"><b>{{ strtoupper($d->etiket) }}</b></td> 
              @else
              <td style="font-size:11px;font-family:Arial; text-align: center"><b>{{ @$d->etiket == null || @$d->etiket == '-' ? @$d->cara_minum : @$d->etiket }}</b></td> 
              {{-- <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial"></td>  --}}
              @endif
            </tr>
            <br>
            <tr style="text-align: center;">
             @php
                  $namaobat = substr(strtoupper($d->masterobat->nama),0,20);
              @endphp
              @if (\App\masterCaraMinum::where('id',$d->cara_minum_id)->first())
              <td style="font-size:10px;font-family:Arial; text-align: center;"><b>{{ strtoupper(\App\masterCaraMinum::where('id',$d->cara_minum_id)->first()->nama) }}</b>
              @if (strpos(strtolower($namaobat), 'infus') !== false)
                <br/>
                1. Dipasang tanggal :<br/>
                2. Tetesan Infus :<br/>
                3. Habis dalam : ................................... Jam
              @endif
              </td>
              @else
              <td style="font-size:10px;"></td> 
              @endif
              
            </tr>
            <tr>
              <td style="font-size:10px;font-family:Arial"><b>{{ $namaobat }} </b></td>
              @if( \App\LogistikBatch::where('id', $d->logistik_batch_id)->first() )
                <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial; padding-left:130px;"></b><b>{{ strtoupper($d->jumlahTotal) }}.0 </b></b></td>
              @else
                <th style="font-size:10px;"></th> <td style="font-size:10px;font-family:Arial">  </td>
              @endif
            </tr>
            <tr><td style="font-size:10px;font-family:Arial"><b>{{ strtoupper($d->informasi1) }} </b></td></tr>
            <tr><td style="font-size:10px;font-family:Arial"><b>{{ strtoupper($d->bud) }} </b></td></tr>
          </tbody>
        </table>
        {{-- <thead style="text-align: left;">
          <tr>
            <td class="quantity font1">Tgl Pelayanan :  {{ date('d-m-Y', strtotime($penjualan->created_at)) }}</td>
          </tr>
          <tr>
            <td class="description" >{{ strtoupper(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->nama) }} / {{ tgl_indo(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->tgllahir) }} / {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }} </td>
          </tr>
          <tr>
            <td class="description font2">{{ substr(strtoupper($d->masterobat->nama),0,20) }} / {{ strtoupper($d->informasi1) }}</td>
          </tr>
          <tr>
            @if (\App\masterCaraMinum::where('id',$d->cara_minum_id)->first())
            <td class="description font2"><b>{{ strtoupper(\App\masterCaraMinum::where('id',$d->cara_minum_id)->first()->nama) }}</b></td>
            @else
            <td class="description font2"></td>
            @endif
          </tr>
          <tr>
            @if( \App\LogistikBatch::where('id', $d->logistik_batch_id)->first() )
            <td class="description font2"><b>{{ strtoupper($d->etiket) }} |  {{ strtoupper(baca_satuan_jual(\App\LogistikBatch::where('id', $d->logistik_batch_id)->first()->satuanjual_id)) }}</b></td>
            @else
            <td class="description font2"><b>{{ strtoupper($d->etiket) }} |  </b></td>
            @endif
          </tr>
          <tr>
            @if( \App\LogistikBatch::where('id', $d->logistik_batch_id)->first() )
            <td class="description font2">  {{ strtoupper(\App\LogistikBatch::where('id', $d->logistik_batch_id)->first()->expireddate) }}</td>
            @else
            <td class="description font2">-</td>
            @endif
          </tr>
        </thead> --}}
      </table>
      <br>
  </div>
</body>
{{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('penjualan/jalan-baru') }}"> --}}
@endforeach
@if (@count(@$resep_dokter->resep_detail) > 0)
<div class="ticket">
  <table class="table  table-condensed">
    <tr>
      <td colspan="2" style="text-align: center; font-size: 8pt">
          <b>
            ANTRIAN E-RESEP
          </b>
        <p style=" margin: 0;">Nomor Antrian Anda:</p>
        <b><span style="font-size: 8pt;">{{ @$reg->pasien->nama }} / {{ @$reg->pasien->no_rm }}</span></b>
        <p style=" margin: 0;"><span style="font-weight: bold; font-size: 8pt;">
          @if (!empty($ranap))
            {{ @baca_dokter($ranap->dokter_id) }} ({{ baca_kamar(@$ranap->kamar_id) }})
          @else
            {{ @$reg->dokter_umum->nama }} ({{ @$reg->poli->nama }})
          @endif
        </span></p>
        <p style="font-size: 15pt; font-weight: bold; margin: 0;">
          {{ @$resep_dokter->kelompok.''.@$resep_dokter->nomor }}
        </p>
          <span style="font-size: 8pt">{{ date('d-m-Y H:i:s' ) }}</span>
        @foreach ($resep_dokter->resep_detail as $detail)
          <p style=" margin: 0;"><span style="font-weight: bold; font-size: 8pt;">{{ @$detail->logistik_batch->master_obat->nama }}</span> <span>[{{ @$detail->qty }}]</span></p>
        @endforeach
  
      </td>
    </tr>
  </table>
</div>
@endif
@endisset
</html>