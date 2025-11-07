@extends('master')

@section('header')
  <h1>Setting Jam Laporan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">

      </div>
      <form action="{{route('lock_apm.update')}}" method="post">
      {{csrf_field()}}
      <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        <table class="table table-stripped">
          {{-- @foreach ($data as $item) --}}
          <input type="hidden" value="9" name="id">
            <tr>
              <td>{{ $data->consid }}</td>
              <td>
                <input type="radio" name="aktif" value="0" {{$data->aktif == '0' ? 'checked' :''}}> Nonaktif
                <input type="radio" name="aktif" value="1" {{$data->aktif == '1' ? 'checked' :''}}> Aktif
                {{-- Menit <input name="jam_tutup[{{$item->id}}]"  type="time" value="{{$item->jam_tutup}}" > --}}
              </td>
            </tr>
            {{-- @endforeach --}}
            <tr>
              <td><button class="btn btn-success" type="submit">Simpan</button></td>
            </tr>
        </table> 
      </div>
    </form> 
    </div>




@stop
