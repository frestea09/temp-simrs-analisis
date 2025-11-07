@extends('master')

@section('header')
  <h1>Direksi - Tambah</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
            @if( isset($data['direksi']) )
              Update {{ ucWords($data['direksi']->content_title) }}
            @else
              Tambah Direksi Baru
            @endif
        </h3>
      </div>
      <div class="box-body">
        @if( isset($data['direksi']) )
        {!! Form::open(['method' => 'POST', 'url' => 'android/direksi/'.$data['direksi']->id, 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
        {!! Form::hidden('_method', 'PUT') !!}
        @else
        {!! Form::open(['method' => 'POST', 'url' => 'android/direksi', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
        @endif

        <div class="form-group{{ $errors->has('dir_nik') ? ' has-error' : '' }}">
            {!! Form::label('NIK', 'NIK', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('dir_nik', isset($data['direksi']->dir_nik) ? $data['direksi']->dir_nik : null, ['class' => 'form-control' ]) !!}
                <small class="text-danger">{{ $errors->first('dir_nik') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('dir_nama') ? ' has-error' : '' }}">
            {!! Form::label('Nama Lengkap', 'Nama Lengkap', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('dir_nama', isset($data['direksi']->dir_nama) ? $data['direksi']->dir_nama : null, ['class' => 'form-control' ]) !!}
                <small class="text-danger">{{ $errors->first('dir_nama') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('dir_tmplahir') ? ' has-error' : '' }}">
            {!! Form::label('Tempat Lahir', 'Tempat Lahir', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('dir_tmplahir', isset($data['direksi']->dir_tmplahir) ? $data['direksi']->dir_tmplahir : null, ['class' => 'form-control' ]) !!}
                <small class="text-danger">{{ $errors->first('dir_tmplahir') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('dir_tgllahir') ? ' has-error' : '' }}">
            {!! Form::label('Tanggal Lahir', 'Tanggal Lahir', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('dir_tgllahir', isset($data['direksi']->dir_tgllahir) ? $data['direksi']->dir_tgllahir : null, ['class' => 'form-control datepicker' ]) !!}
                <small class="text-danger">{{ $errors->first('dir_tgllahir') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('dir_kelamin') ? ' has-error' : '' }}">
            {!! Form::label('Jenis Kelamin', 'Jenis Kelamin', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('dir_kelamin', isset($data['jk']) ? $data['jk'] : null, null , ['class' => 'form-control chosen-select' ]) !!}
                <small class="text-danger">{{ $errors->first('dir_kelamin') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('dir_alamat') ? ' has-error' : '' }}">
            {!! Form::label('Alamat', 'Alamat', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::textarea('dir_alamat', isset($data['direksi']->dir_alamat) ? $data['direksi']->dir_alamat : null, ['class' => 'form-control' ]) !!}
                <small class="text-danger">{{ $errors->first('dir_alamat') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('agama_id') ? ' has-error' : '' }}">
            {!! Form::label('Agama', 'Agama', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('agama_id', isset($data['agama']) ? $data['agama'] : null, isset($data['direksi']->agama_id) ? $data['direksi']->agama_id : null , ['class' => 'form-control chosen-select' ]) !!}
                <small class="text-danger">{{ $errors->first('agama_id') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('manajemen_id') ? ' has-error' : '' }}">
            {!! Form::label('Manajemen', 'Manajemen', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('manajemen_id', isset($data['manajemen']) ? $data['manajemen'] : null, isset($data['direksi']->manajemen_id) ? $data['direksi']->manajemen_id : null , ['class' => 'form-control chosen-select' ]) !!}
                <small class="text-danger">{{ $errors->first('manajemen_id') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('jabatan_id') ? ' has-error' : '' }}">
            {!! Form::label('Jabatan', 'Jabatan', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('jabatan_id', isset($data['jabatan']) ? $data['jabatan'] : null, isset($data['direksi']->jabatan_id) ? $data['direksi']->jabatan_id : null , ['class' => 'form-control chosen-select' ]) !!}
                <small class="text-danger">{{ $errors->first('jabatan_id') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
            {!! Form::label('Photo', 'Photo', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::file('photo', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('photo') }}</small>
                @if( isset($data['direksi']) )
                    <img class="img-thumbnail" src="{{ url($data['direksi']->dir_photo_path.$data['direksi']->dir_photo) }}">
                @endif
            </div>
        </div>

        <hr>
        <div class="btn-group pull-right">
            {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
@endsection
  
@section('script')
{{-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    var editor_config = {
        path_absolute: "/",
        selector: "textarea.my-editor",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };
    tinymce.init(editor_config); 
</script> --}}
<script>
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    });
    $('.chosen-select').chosen();
</script>
@endsection