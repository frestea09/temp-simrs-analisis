@extends('master')

@section('header')
  <h1>Android - Page</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
            @if( isset($data) )
              Update {{ ucWords($data->content_title) }}
            @else
              Tambah Page Baru
            @endif
        </h3>
      </div>
      <div class="box-body">
        @if( isset($data) )
        {!! Form::open(['method' => 'POST', 'url' => 'android/pages/'.$data->id, 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
        {!! Form::hidden('_method', 'PUT') !!}
        @else
        {!! Form::open(['method' => 'POST', 'url' => 'android/pages/store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
        {!! Form::hidden('type_id', $id) !!}
        @endif

        <div class="form-group{{ $errors->has('content_title') ? ' has-error' : '' }}">
            {!! Form::label('Judul', 'Judul', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('content_title', isset($data->content_title) ? $data->content_title : null, ['class' => 'form-control' ]) !!}
                <small class="text-danger">{{ $errors->first('content_title') }}</small>
            </div>
        </div>
        
        <div class="form-group{{ $errors->has('content_description') ? ' has-error' : '' }}">
            {!! Form::label('Content', 'Content', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::textarea('content_description', isset($data->content_description) ? $data->content_description : null , ['class' => 'form-control my-editor', "width" => 300]) !!}
                <small class="text-danger">{{ $errors->first('content_description') }}</small>
            </div>
        </div>

        @if( isset($data->content_description) )
            @if( $data->type_id == 3 || $data->type_id == 6 )
            <div class="form-group{{ $errors->has('content_thumbnail') ? ' has-error' : '' }}">
                {!! Form::label('Gambar', 'Gambar', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::file('content_thumbnail', ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('content_thumbnail') }}</small>
                </div>
            </div>
            <div class="text-center">
                <img src="{{ url($data->content_path.$data->content_thumbnail) }}" class="img-thumbnail" width="150" height="150">
            </div>
            @endif
        @else
            @if(isset($id))
                @if( $id == 3 || $id == 6 )
                <div class="form-group{{ $errors->has('content_thumbnail') ? ' has-error' : '' }}">
                    {!! Form::label('Gambar', 'Gambar', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::file('content_thumbnail', ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('content_thumbnail') }}</small>
                    </div>
                </div>
                @endif
            @endif
        @endif

        <hr>
        <div class="btn-group pull-right">
            {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
@endsection
  
@section('script')
{{-- <script src="//cdn.tinymce.com/5/tinymce.min.js"></script> --}}
<script src="{{ asset('src/tinymce/js/tinymce/tinymce.min.js') }}"></script>
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
</script>
@endsection