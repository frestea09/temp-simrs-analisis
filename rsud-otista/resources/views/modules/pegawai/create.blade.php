@extends('master')

@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Pegawai &nbsp;
          <a href="{{ URL::previous() }}" class="btn btn-default btn-sm"><i class="fa fa-backward"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-8">
            {!! Form::open(['method' => 'POST', 'route' => 'pegawai.store', 'class' => 'form-horizontal']) !!}

                @include('pegawai::_form')

            {!! Form::close() !!}
          </div>
        </div>

      </div>
    </div>
@stop

@section('script')
  <script type="text/javascript">
    $('.select2').select2()

    $(function() {
      $('select[name="kategori_pegawai"]').change(function(e) {
      e.preventDefault()
      if($(this).val() == 1){
        $('.kodeBpjs').removeClass('hidden')
        $('.kode_inhealth').removeClass('hidden')
      } else if($(this).val() != 1){
        $('.kodeBpjs').addClass('hidden')
        $('.kode_inhealth').addClass('hidden')
      } else {
        $('.kodeBpjs').addClass('hidden')
        $('.kode_inhealth').addClass('hidden')
      }
    });
    });


  </script>
@endsection