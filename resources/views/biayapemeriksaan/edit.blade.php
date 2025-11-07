@extends('master')

@section('header')
  <h1>Kofigurasi - Biaya Pemeriksaan {{baca_tipe_reg($jenis)}}</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Biaya Pemeriksaan &nbsp;
        </h3>
        <a href="{{url('/biayapemeriksaan')}}">Kembali</a>
      </div>
      <div class="box-body">
      {!! Form::model(@$biayapemeriksaan, ['route' => ['biayapemeriksaan.store'], 'method' => 'POST','class'=>'form-horizontal']) !!}
          
          @include('biayapemeriksaan._form')

          <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
              {!! Form::submit("Simpan", ['class' => 'btn btn-success']) !!}
          </div>

      {!! Form::close() !!}
      <br/>
      <br/>
      <table class="table table-bordered">
        <tr>
          <th>No</th>
          <th>Tarif</th>
          <th>Harga</th>
          <th>Untuk Pasien</th>
          <th>Poli</th>
          <th>-</th>
        </tr>
        @foreach ($biayapemeriksaan as $key=>$item)
        <tr>
          <td>{{$key+1}}</td>
          <td>{{$item->tarif->nama}}</td>
          <td>{{number_format($item->tarif->total)}}</td>
          <td>{!!$item->pasien == 'pasien_baru' ? '<span style="color:green">Pasien Baru</span>':'<span style="color:red">Pasien Lama</span>'!!}</td>
          <td>{{$item->poli_id ? @baca_poli(@$item->poli_id) : 'Semua'}}</td>
          <td>
            @if (count($biayapemeriksaan) > 1)
            <a href="{{url('biayapemeriksaan/'.$item->id.'/delete')}}" onclick="return confirm('Yakin akan hapus tarif?')">Hapus</a>
            @endif
          </td>
        </tr>
            
        @endforeach
      </table>
      </div>
    </div>
@stop
