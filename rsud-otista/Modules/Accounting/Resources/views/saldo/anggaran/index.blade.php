@extends('master')

@section('header')
  <h1>Saldo Anggaran </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Saldo Anggaran &nbsp;
          <a data-toggle="modal" href="#modal-default" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>Tanggal</th>
                <th>Kode Saldo</th>
                <th>Total Debit</th>
                <th>Total Credit</th>
                <th>Total Nilai</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr>
                  {{-- <td>{{ $key+1 }}</td> --}}
                  <td>{{ date('d F Y', strtotime($d['tanggal'])) }}</td>
                  <td>{{ $d['code'] }}</td>
                  <td>{{ $d['debit'] }}</td>
                  <td>{{ $d['credit'] }}</td>
                  <td>{{ $d['total_transaksi'] }}</td>
                  <td>
                    <a href="{{ route('master.anggaran.show', $d['id']) }}" class="btn btn-success btn-sm"><i class="fa fa-info"></i></a>
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
                {!! Form::open(['method' => 'POST', 'route' => 'master.anggaran.import', 'files' => true]) !!}
                    <div class="modal-body">
                        <div class="form-group" style="padding-bottom: 10px;">
                            <label for="exampleInputFile">Data Akun Anggaran</label>
                            <br>
                            <a href="anggaran/getData">Unduh sample data</a>
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
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@stop