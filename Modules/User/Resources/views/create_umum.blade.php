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
          <h3>Umum / Iks</h3>
          {{-- @include('user::_form') --}}

      {!! Form::close() !!}
    </div>
  </div>
@endsection
