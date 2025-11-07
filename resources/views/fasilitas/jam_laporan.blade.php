@extends('master')

@section('header')
  <h1>Setting Jam Laporan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">

      </div>
      <form action="{{route('jam_laporan.update')}}" method="post">
      {{csrf_field()}}
      <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        <table class="table table-stripped">
          @foreach ($data as $item)
          {{-- <input type="hidden" value="{{$item->id}}" name="{{$item->id}}"> --}}
            <tr>
              <td>{{ $item->nama }}</td>
              <td>
                Jam Buka <input  name="jam_buka[{{$item->id}}]" type="time" value="{{$item->jam_buka}}" > - 
                Jam Tutup <input name="jam_tutup[{{$item->id}}]"  type="time" value="{{$item->jam_tutup}}" >
              </td>
            </tr>
            @endforeach
            <tr>
              <td><button class="btn btn-success" type="submit">Simpan</button></td>
            </tr>
        </table> 
      </div>
    </form> 
    </div>




@stop
