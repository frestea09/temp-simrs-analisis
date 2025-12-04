@extends('master')

@section('header')
  <h1>Master Anggaran</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          @if (isset($is_edit) && $is_edit == 1) Ubah Anggaran {{$data['code']}} @else Tambah Anggaran @endif  &nbsp;

        </h3>
      </div>
      <div class="box-body">
          @if (isset($is_edit) && $is_edit == 1)
            {!! Form::model($data, ['route' => ['saldo.anggaran.update', $data['id']], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
          @else
            {!! Form::open(['method' => 'POST', 'route' => 'saldo.anggaran.store', 'class' => 'form-horizontal']) !!}
          @endif
            <div class="col-sm-6">
                <div class="form-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
                    {!! Form::label('tahun', 'Tahun Periode', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('tahun', date('Y'), ['class' => 'form-control yearpicker']) !!}
                        <small class="text-danger">{{ $errors->first('tahun') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('keterangan', 'Anggaran tahun ' . date('Y'), ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
              <hr>
              <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed' id='table'>
                  <thead>
                    <tr>
                      {{-- <th>No</th> --}}
                      <th>Kode</th>
                      <th>Akun</th>
                      <th>Saldo Normal</th>
                      <th>Debit</th>
                      <th>Kredit</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($akun_coa as $key => $d)
                      <tr>
                        {{-- <td>{{ $key+1 }}</td> --}}
                        <td>{{ $d['code'] }}</td>
                        <td>{{ $d['nama'] }}</td>
                        <td>{{ ucfirst($d['saldo_normal']) }}</td>
                        <td>{!! Form::text('debit['.$d['id'].']', null, ['class' => 'form-control input-sm uang']) !!}</td>
                        <td>{!! Form::text('kredit['.$d['id'].']', null, ['class' => 'form-control input-sm uang']) !!}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              </div>
              <div class="col-sm-12">
                <hr>
                <div class="btn-group pull-right">
                    <a href="{{ route('saldo.anggaran.index') }}" class="btn btn-warning btn-flat">Batal</a>
                    {{-- <button type="button" class="button"></button> --}}
                    {!! Form::button("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
                </div>
            </div>
            {!! Form::close() !!}
      </div>
    </div>
@stop