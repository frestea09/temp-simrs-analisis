@extends('master')
@section('header')
  <h1>Buat ICD 9 IM</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah ICD 9 IM &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'icd9-im.store', 'class' => 'form-horizontal']) !!}

        <div class="form-group{{ $errors->has('icd9') ? ' has-error' : '' }}">
            {!! Form::label('icd9', 'Nama ICD9', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              <select name="icd9[]" class="form-control select2" style="width: 100%;" multiple required>
                @foreach ($icd9 as $id => $nama)
                  <option value="{{ $id }}">{{ $nama }}</option>
                @endforeach
              </select>
                <small class="text-danger">{{ $errors->first('icd9') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('nama_icd9_im') ? ' has-error' : '' }}">
            {!! Form::label('nama_icd9_im', 'Nama ICD9 IM', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('nama_icd9_im', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('nama_icd9_im') }}</small>
            </div>
        </div>
        
        <div class="btn-group pull-right">
            <a href="{{ route('icd9-im') }}" class="btn btn-warning btn-flat">Batal</a>
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
