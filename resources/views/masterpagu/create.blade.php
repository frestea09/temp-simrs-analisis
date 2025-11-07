@extends('master')
@section('header')
  <h1>Daftar Master Pagu </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Pagu &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'masterpagu.store', 'class' => 'form-horizontal']) !!}

        <div class="form-group{{ $errors->has('biaya') ? ' has-error' : '' }}">
            {!! Form::label('biaya', 'Biaya', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::number('biaya', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('biaya') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
            {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('diagnosa_awal', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('kelas') ? ' has-error' : '' }}">
            {!! Form::label('kelas', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                <select class="form-control select2" style="width: 100%" name="kelas">
                  @foreach($kelas as $d)
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('kelas') }}</small>
            </div>
        </div>
        
        <div class="btn-group pull-right">
            <a href="{{ url('/masterpagu') }}" class="btn btn-warning btn-flat">Batal</a>
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
