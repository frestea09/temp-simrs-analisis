@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Laboratorium  &nbsp;
          <a href="{{ route('lab.create') }}" class="btn btn-default btn-sm btn-flat"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Kategori Lab</th>
                <th>Nama</th>
                <th>Nilai Rujukan</th>
                <th>Nilai Rujukan Bawah</th>
                <th>Nilai Rujukan Atas</th>
                <th>Satuan</th>
                <th>Edit/Hapus</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $e)
              <form action="{{ route('lab.destroy', $e->id) }}" method="POST">
                {{ csrf_field() }} {{ method_field('DELETE') }}
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->labkategori->nama }}</td>
                <td>{{ $e->nama }}</td>
                <td>{{ $e->rujukan}}</td>
                <td>{{ $e->nilairujukanbawah }}</td>
                <td>{{ $e->nilairujukanatas }}</td>
                <td>{{ $e->satuan }}</td>
                <td>
                  <a href="{{ url('lab/'.$e->id.'/edit') }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
                  {{-- <button type="submit" onclick="return confirm('Yakin data ini akan dihapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i></button> --}}
                </td>
              </tr>
              </form>
            @endforeach

            </tbody>
          </table>
        </div>

      </div>
    </div>
@stop
