@extends('master')
@section('header')
  <h1>Eresep<small><a href="{{url('farmasi/lcd-eresep')}}" class="btn btn-default" id="tambah"> Kembali </a></small></h1>
@endsection
@section('content')
  <hr style="border-top: 1px solid red;"/>
  <div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <tr>
        <td>Nama</td>
        <td>{{@$reg->pasien->nama}}</td>
      </tr>
      <tr>
        <td>RM</td>
        <td>{{@$reg->pasien->no_rm}}</td>
      </tr>
      <tr>
        <td>Dokter</td>
        <td>{{baca_dokter(@$reg->dokter_id)}}</td>
      </tr>
      <tr>
        <td>Poli</td>
        <td>
          @php
              $histori = \App\HistorikunjunganIRJ::where('registrasi_id',@$reg->id)->orderBy('id','DESC')->first();
          @endphp
          @if ($histori)
          {{baca_poli(@$histori->poli_id)}}  
          @else
          {{@$reg->poli->nama}}
          @endif
        </td>
      </tr>
    </table>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <thead> 
        <tr>
          <th>Nama Obat</th>
          <th style="width: 10%" class="text-center">Batch</th>
          <th style="width: 10%" class="text-center">Jumlah</th> 
          <th>Tiket</th>
          <th>Cara Minum</th>
          <th>Takaran</th>
          <th>Informasi</th>
          {{-- <th style="width: 10%" class="text-center">Cara Bayar</th>  --}}
          {{-- <th style="width: 10%" class="text-center">Total INACBG</th>  --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($resep_detail as $key => $res)
        @php
            $obat = \App\LogistikBatch::where('id', $res->logistik_batch_id)->first();
          @endphp
        <tr>
        <td>
          @if ($res->obat_racikan == 'Y')
              <span style="color:green">Racikan</span>
          @endif
          {{ !empty($res->logistik_batch_id) ? baca_batches($res->logistik_batch_id) : $res->masterobat->nama }}</td>
        <td>{{ !empty($obat->nomorbatch) ? $obat->nomorbatch : '' }}</td>
        <td class="text-center">{{ $res->qty }}</td>
        <td>{{ $res->tiket }}</td>
        <td>{{ $res->cara_minum }}</td>
        <td>{{ $res->takaran }}</td>
        <td>{{ $res->informasi }}</td>
        </tr>
        @endforeach 
      </tbody>
      <tfoot> 
        <tr>
          <th>

          </th> 
        </tr>
      </tfoot>
    </table>
  </div>
  @endsection