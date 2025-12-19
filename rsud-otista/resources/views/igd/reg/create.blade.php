@extends('master')
@section('header')
  <h1>Pendaftaran IGD JKN</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Pasien Baru &nbsp;

      </h3>
    </div>
    <div class="box-body">
      @if ($pasien)
        {!! Form::model($pasien, ['route' => ['registrasi.update', $pasien->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
      @else
        {!! Form::open(['method' => 'POST', 'route' => 'registrasi.store', 'class' => 'form-horizontal']) !!}
      @endif

          @include('pasien::_form')
          <hr>
          @include('igd.reg._form')

      {!! Form::close() !!}
    </div>
  </div>
@endsection

@push('js')
<script>
   $(document).on('change','select[name="pengirim_rujukan"]',function(){
        console.log(this.value)
        if( this.value == 6 ){
          $('.form-add-puskesmas').show();
          $('.form-add-dokter').show();
        }else{
          $('.form-add-dokter').show();
          $('.form-add-puskesmas').hide();
        }
      })
</script>
@endpush