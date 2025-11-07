@extends('master')
@section('header')
  <h1>Laporan - Expired Date<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <form method="POST" action="">
      {{ csrf_field() }}
    <div class="box-header with-border">
      {{-- <h4>Periode Tanggal</h4> --}}
        <input type="submit" name="excel" class="btn btn-success btn-flat" value="Excel">
    </div>
    </form>
    <div class="box-body">
      <table class="table table-hover table-bordered table-condensed" id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>Nomor Batch</th>
            <th>Nama Obat</th>
            <th>Stok Saat Ini</th>
            <th>Expired Date</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @forelse( $data['obat'] as $key => $item)
          @php

            $keterangan = '-';
            $alert = false;

            if( isset($item->logistik_batch) ){

              // $date   = \Carbon\Carbon::parse($item->logistik_batch->expireddate);
              // $now    = \Carbon\Carbon::now();
              // $day    = $date->diffInDays($now);
             
              $dueDate = \Carbon\Carbon::parse($item->logistik_batch->expireddate);
              //$dueSoon = $dueDate->diffInDays(now()) <= 40 && $dueDate->diffInDays(now()) > 0;
              $day = @$dueDate->diffInDays(now());
              //$isPast  = $dueDate->isPast();
          
              if( $day < 40 ) {
                $keterangan = '<label class="text-danger">Kadaluarsa '.$day.' hari lagi</label>'; 
                $alert = true;
              }else{
                $keterangan = 'Kadaluarsa '.$day.' hari lagi';
                $alert = false;
              }

            } 
          @endphp
          <tr style="{{ ($alert) ? 'background-color: #ff9393;' : '' }}">
            <td>{{ $key+1 }}</td>
            <td>{{ isset($item->logistik_batch) ? $item->logistik_batch->nomorbatch : '-' }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ @$item->logistik_batch->stok }}</td>
            <td>{{ isset($item->logistik_batch) ?  date('d/m/Y', strtotime($item->logistik_batch->expireddate)) : '-' }}</td>
            <td>
              {!! $keterangan !!}
            </td>
          </tr>
          @empty
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection