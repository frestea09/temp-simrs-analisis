@extends('master')
@section('header')
  <h1>Edit ICD10 IM</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Edit ICD10 IM &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($icd10im, ['method' => 'PUT', 'route' => ['icd10-im.update', $icd10im->id], 'class' => 'form-horizontal']) !!}

        <div class="form-group{{ $errors->has('icd10') ? ' has-error' : '' }}">
          {!! Form::label('icd10', 'Nama ICD10', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              <select class="form-control select2" style="width: 100%" name="icd10">
                @foreach ($icd10 as $id => $nama)
                  <option value="{{ $id }}" {{ $id == $icd10im->icd10_id ? 'selected' : ''}}>
                    {{ $nama }}
                  </option>
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('icd10') }}</small>
          </div>
      </div>

        <div class="form-group{{ $errors->has('nama_icd10_im') ? ' has-error' : '' }}">
            {!! Form::label('nama_icd10_im', 'Nama ICD10 IM', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('nama_icd10_im', $icd10im->nama_icd10_im, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('nama_icd10_im') }}</small>
            </div>
        </div>
        
        <div class="btn-group pull-right">
            <a href="{{ route('icd10-im') }}" class="btn btn-warning btn-flat">Batal</a>
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
