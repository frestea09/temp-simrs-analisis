@extends('master')
@section('header')
  <h1>Edit Intervensi Keperawatan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Edit Intervensi Keperawatan &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($implementasi, ['method' => 'PUT', 'route' => ['master-implementasi.update', $implementasi->id], 'class' => 'form-horizontal']) !!}

        <div class="form-group{{ $errors->has('diagnosa') ? ' has-error' : '' }}">
          {!! Form::label('diagnosa', 'Nama Diagnosa', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              <select class="form-control select2" style="width: 100%" name="diagnosa">
                @foreach ($diagnosas as $id => $nama)
                  <option value="{{ $id }}" {{ $id == $implementasi->diagnosa_keperawatan_id ? 'selected' : ''}}>
                    {{ $nama }}
                  </option>
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('diagnosa') }}</small>
          </div>
      </div>

        <div class="form-group{{ $errors->has('nama_implementasi') ? ' has-error' : '' }}">
            {!! Form::label('nama_implementasi', 'Nama Implementasi', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('nama_implementasi', $implementasi->nama_implementasi, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('nama_implementasi') }}</small>
            </div>
        </div>
        
        <div class="btn-group pull-right">
            <a href="{{ route('master-implementasi') }}" class="btn btn-warning btn-flat">Batal</a>
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
