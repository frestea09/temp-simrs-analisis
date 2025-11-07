@extends('master')
@section('header')
  <h1>Master Idrg Tarif INACBG</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Master Idrg
      </h3>
    </div>
    <div class="box-body">
        <form action="{{url('masteridrg/edit-tarif')}}" method="post">
          <input type="hidden" name="nama" value="{{request()->get('nama')}}">
          {{csrf_field()}}
          NAMA TARIF
          <input type="text" class="form-control" name="namatarif" value="{{request()->get('nama')}}" required><br/>
          MASTERIDRG
          <select name="masteridrg_id" class="form-control chosen-select" id="">
            {{-- <option value="">--Pilih--</option> --}}
            @foreach ($idrg as $item)
                <option value="{{$item->id}}">{{$item->idrg}} ({{$item->id}})</option>
            @endforeach
          </select><br/>
           
          MASTERIDRG BIAYA (OPSIONAL)
          <select name="idrg_biaya_id" class="form-control chosen-select" id="">
            <option value="">--Pilih--</option>
            @foreach ($idrg_biaya as $item)
                <option value="{{$item->id}}">{{$item->kelompok}}</option>
            @endforeach
          </select>
          <br/>
          <br/>
          <button class="btn btn-success pull-right">SIMPAN</button>
        </form>
    </div>
  </div> 
@endsection

@section('script')

@endsection
