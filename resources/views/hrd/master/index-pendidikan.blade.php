@extends('master')
@section('header')
  <h1>Pendidikan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Pendidikan &nbsp;
        {{-- <a href="{{ url('hrd/master/pendidikan/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a> --}}
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Kualifikasi Pendidikan</th>
                <th>Pendidikan</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data['pendidikan'] as $key => $d)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ ucWords($d->nama) }} 
                    <div class="text-right">
                    <a href="{{ url('hrd/master/pendidikan/create/'.$d->id) }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </td>
                <td colspan="2">
                    <table class='table table-striped table-bordered table-hover table-condensed'>
                    @foreach($d->pendidikan as $v)
                    <tr>
                        <td>{{ $v->pendidikan }}</td>
                        <td><a href="{{ url('hrd/master/pendidikan/'.$v->id.'/edit') }}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-edit"></i></a></td>
                    </tr>
                    @endforeach
                    </table>
                </td>
              <tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
@endsection
