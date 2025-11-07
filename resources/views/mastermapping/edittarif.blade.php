@extends('master')
@section('header')
  <h1>Master Mapping Tarif INACBG</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Master Mapping
      </h3>
    </div>
    <div class="box-body">
        <form action="{{url('mastermapping/edit-tarif')}}" method="post">
          <input type="hidden" name="nama" value="{{request()->get('nama')}}">
          {{csrf_field()}}
          NAMA TARIF
          <input type="text" class="form-control" name="namatarif" value="{{request()->get('nama')}}" required><br/>
          MASTERMAPPING
          <select name="mastermapping_id" class="form-control chosen-select" id="">
            {{-- <option value="">--Pilih--</option> --}}
            @foreach ($mapping as $item)
                <option value="{{$item->id}}">{{$item->mapping}} ({{$item->id}})</option>
            @endforeach
          </select><br/>
           
          MASTERMAPPING BIAYA (OPSIONAL)
          <select name="mapping_biaya_id" class="form-control chosen-select" id="">
            <option value="">--Pilih--</option>
            @foreach ($mapping_biaya as $item)
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
