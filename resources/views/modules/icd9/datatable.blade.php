@extends('master')

@section('header')
  <h1>Master ICD9 </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data MasterICD9 &nbsp;
          <a href="{{ route('icd9.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table id='icd9View' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor ICD9</th>
                <th>Nama</th>
                <th>Edit</th>
              </tr>
            </thead>

          </table>
        </div>
      </div>
    </div>
@stop
