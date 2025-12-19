@extends('master')
@section('header')
  <h1>Buat Diagnosa Keperawatan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Diagnosa Keperawatan &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'diagnosa-keperawatan.store', 'class' => 'form-horizontal']) !!}

        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
            {!! Form::label('nama', 'Nama Diagnosa', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'mis : DIARE']) !!}
                <small class="text-danger">{{ $errors->first('nama') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
            {!! Form::label('kode', 'Kode', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('kode', null, ['class' => 'form-control', 'placeholder' => 'mis : D.0020']) !!}
                <small class="text-danger">{{ $errors->first('kode') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
            {!! Form::label('jenis', 'Jenis', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                <select class="form-control select2" style="width: 100%" name="jenis">
                    <option value="Askep">Askep</option>
                    <option value="Askeb">Askeb</option>
                </select>
                <small class="text-danger">{{ $errors->first('jenis') }}</small>
            </div>
        </div>
        
        <div class="btn-group pull-right">
            <a href="{{ route('diagnosa-keperawatan.store') }}" class="btn btn-warning btn-flat">Batal</a>
            {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
        </div>        
            
        {!! Form::close() !!}
      </div>
    </div>
@stop

@section('script')
<script type="text/javascript">
  $('.select2').select2();
</script>
@endsection
