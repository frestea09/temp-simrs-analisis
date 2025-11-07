@extends('master')
@section('header')
  <h1>Management User</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Edit User &nbsp;
      </h3>
    </div>
    <div class="box-body">
      {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
          @include('user::_formupdate')
      {!! Form::close() !!}
    </div>
  </div>
@endsection


@section('script')
  <script type="text/javascript">
    $.ajax({
      url: "{{ url('/user/getUser/'.$user->id) }}",
      type: "GET",
      dataType: "json",
    })
    .done(function(data) {
      $.each(data.role, function(i, role) {
        $('input[value="'+role.name+'"]').attr('checked', true)
      });
    });
    $('.select2').select2();
  </script>
@endsection
