@extends('master')
@section('header')
  <h1>Management User</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Tambah User &nbsp;
      </h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'route' => 'user.store', 'class' => 'form-horizontal']) !!}
          @include('user::_form')
      {!! Form::close() !!}
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      if ($('select[name="role"]').val() == 'rawatinap') {
        $('#kelompokKelas').removeClass('hidden');
      }
    });

    $('select[name="role"]').on('change', function(event) {
      event.preventDefault();
      if ( $(this).val() == 'rawatinap' ) {
        $('#kelompokKelas').removeClass('hidden');
      } else {
        $('#kelompokKelas').addClass('hidden')
      }
    });
  </script>
@endsection
