@extends('master')
@section('header')
  <h1>Master Obat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Kembali
          <a href="{{ url('masterobat/'.$masterobat->id.'/edit') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($masterobat, ['url' => url('/masterobat-batch-update'), 'method' => 'POST', 'class'=>'form-horizontal']) !!}
          <input type="hidden" value="{{$batch->id}}" name="id_batch">
          @include('masterobat._form_batch')

        {!! Form::close() !!}

      </div>
      

    </div>
@stop

@section('script')

<script type="text/javascript">
  $('.select2').select2();
</script>


@endsection