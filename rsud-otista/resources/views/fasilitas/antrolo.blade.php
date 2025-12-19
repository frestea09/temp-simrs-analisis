@extends('master')

@section('header')
  <h1>Setting Antrian display</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">

      </div>
      <form action="{{route('antrolo.update')}}" method="post">
      {{csrf_field()}}
      <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        <table class="table table-stripped">
          @foreach ($data as $item)
            <tr>
              <td>Antrol O</td>
              <td>
                <input type="radio" name="aktif" value="0" {{$item->aktif == '0' ? 'checked' :''}}> Nonaktif
                <input type="radio" name="aktif" value="1" {{$item->aktif == '1' ? 'checked' :''}}> Aktif
                <br/>
                Nonaktifkan untuk menghilangkan huruf 'O' pada display antrian poli
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
