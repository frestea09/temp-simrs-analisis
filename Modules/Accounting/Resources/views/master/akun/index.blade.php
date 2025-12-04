@extends('master')

@section('header')
  <h1>Master Akun COA </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Akun COA &nbsp;
          <a href="{{ route('akun_coa.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
        {{-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="modal" data-target="#modal-default">
                    <i class="fa fa-upload"> Upload Akun</i></button>
        </div> --}}
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='laporan_akutansi'>
            <thead>
              <tr>
                <th>Kode Akun</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($coa as $c)
                @php
                    $space = "";
                    $bold = str_split($c['code']);
                    if ($bold[2] != 0) {
                      $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    if ($bold[3] != 0) {
                      $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    if ($bold[4] != 0) {
                      $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    if ($bold[5] != 0) {
                      $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    if ($bold[6] != 0) {
                      $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    if ($bold[7] != 0) {
                      $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    if ($bold[8] != 0) {
                      $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                @endphp
                <tr @if (end($bold) == 0) style="font-weight: bold;" @endif>
                  <td>{{ $space }}{{ $c['code'] }}</td>
                  <td>{{ $space }}{{ $c['nama'] }}</td>
                  <td>@if ($c['status'] == 1) Active @else Inactive @endif</td>
                  <td>
                    @if (isset($c['id']))
                      <a href="{{ route('akun_coa.edit', $c['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-default" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Upload Data Akun COA</h4>
                </div>
                {!! Form::open(['method' => 'POST', 'route' => 'akun_coa.import', 'files' => true]) !!}
                    <div class="modal-body">
                        <div class="form-group" style="padding-bottom: 10px;">
                            <label for="exampleInputFile">Sample Data</label>
                            <br>
                            <a href="{{asset('accounting/Akun.xlsx')}}">Unduh sample data</a>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Upload Data</label>
                            {!!Form::file('akun')!!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        {!! Form::submit("Upload", ['class' => 'btn btn-success btn-flat']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
