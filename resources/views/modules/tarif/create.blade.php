@extends('master')

@section('header')
  <h1>Master Tarif </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Tarif &nbsp;
          <a href="{{ route('tarif.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'tarif.store', 'class' => 'form-horizontal']) !!}
            @if ($jenis == '')
              {!! Form::hidden('jenis', 'TI') !!}
            @elseif ($jenis == 'TA')
              {!! Form::hidden('jenis', 'TA') !!}
            @elseif ($jenis == 'TG')
              {!! Form::hidden('jenis', 'TG') !!}
            @endif

            @include('tarif::_form')

        {!! Form::close() !!}
      </div>
    </div>
  @endsection

  @section('script')
  <script type="text/javascript">
  $('.select2').select2();
  $(document).on('change','select[name="carabayar"]', function(){
    if( this.value == 8 ){
      $('#kode_jenpel').show();
    }else{
      $('#kode_jenpel').hide();
    }
  })
  </script>
  @endsection