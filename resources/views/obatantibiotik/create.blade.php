@extends('master')
@section('header')
  <h1>Buat Obat Antibiotik</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Obat Antibiotik &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'obat-antibiotik.store', 'class' => 'form-horizontal']) !!}

        <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
          {!! Form::label('masterobat_id', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::select('masterobat_id', $masterobat, null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
          </div>
        </div>

        <div class="btn-group pull-right">
            <a href="{{ route('obat-antibiotik.store') }}" class="btn btn-warning btn-flat">Batal</a>
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
