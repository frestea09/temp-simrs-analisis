@extends('master')

@section('header')
  <h1>Master Icd10 </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data MasterIcd10 &nbsp;
          <a href="{{ route('icd10.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor Icd10</th>
                <th>Nama</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($icd10 as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nomor }}</td>
                <td>{{ $d->nama }}</td>
                <td>
                  <a href="{{ route('icd10.edit',$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
