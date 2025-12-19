@extends('master')

@section('header')
  <h1>Pasien </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Edit Data Pasien &nbsp;
          <a href="{{ route('pasien') }}" class="btn btn-default btn-sm btn-flat"><i class="fa fa-backward"> </i> BATAL</a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($pasien, ['route' => ['pasien.update', $pasien->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'Nomor RM', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    {!! Form::text('no_rm', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                    <small class="text-danger">Jangan masukkan no rm terbaru ! jika ingin menggunakan rm terbaru, gunakan tombol "PERBARUI RM"</small>
                    <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
                </div>
              </div>
            </div>        
            @if (Auth::user()->id == '1' || Auth::user()->id == '566')
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                    {!! Form::label('no_rm', 'UPDATE RM', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <a onClick="return confirm('Yakin akan membeperbarui? karena RM akan update menjadi RM terbaru')" href="{{url('/sinkron-rm/'.$pasien->id)}}" class="btn btn-success"> PERBARUI RM</a>
                    </div>
                  </div>
                </div>
              </div>
            @endif

            @include('pasien::_form')

            <div class="btn-group pull-right">
                <a href="{{ route('pasien') }}" class="btn btn-warning btn-flat">Batal</a>
                {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
            </div>

        {!! Form::close() !!}

      </div>
    </div>
@stop
