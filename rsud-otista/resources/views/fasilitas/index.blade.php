@extends('master')

@section('header')
  <h1>Fasilitas Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">

      </div>
      <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

        {!! Form::model($fasilitas, ['route' => ['fasilitas.update', $fasilitas ? $fasilitas->id : ''], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('fasilitas') ? ' has-error' : '' }}">
                {!! Form::label('fasilitas', 'Fasilitas', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::textarea('fasilitas', null, ['class' => 'form-control wysiwyg']) !!}
                    <small class="text-danger">{{ $errors->first('fasilitas') }}</small>
                </div>
            </div>

            <div class="btn-group pull-right">
                {!! Form::submit("Simpan", ['class' => 'btn btn-success']) !!}
            </div>
        {!! Form::close() !!}

        <script type="text/javascript">
          CKEDITOR.replace( 'fasilitas', {
            height: 300,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
          });

        </script>


      </div>
    </div>




@stop
