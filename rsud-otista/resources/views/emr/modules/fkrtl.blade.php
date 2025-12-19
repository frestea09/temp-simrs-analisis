@extends('master')

<style>
   .form-box td,
   select,
   input,
   textarea {
      font-size: 12px !important;
   }

   .history-family input[type=text] {
      height: 20px !important;
      padding: 0px !important;
   }

   .history-family-2 td {
      padding: 1px !important;
   }
</style>
@section('header')
<h1>I-Care FKRTL</h1>
<style>
   path:hover,
   rect:hover {
      fill: #000 !important;
   }
</style>
@endsection

@section('content')
<div class="box box-primary">
   <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
   </div>
   <div class="box-body">
      <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


      @include('emr.modules.addons.profile')
      <form method="POST" action="{{ url('emr-odontogram/odontogram/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
         <div class="row">
            <div class="col-md-12">
               @include('emr.modules.addons.tabs')
               {{ csrf_field() }}
               {!! Form::hidden('registrasi_id', $reg->id) !!}
               {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
               {!! Form::hidden('cara_bayar', $reg->bayar) !!}
               {!! Form::hidden('unit', $unit) !!}
               <br>
            </div>

            <div class="row" style="margin-top:50px;">
               <div class="col-md-12">
                  @if (@$url)
                  <iframe width="100%" height="100%"
                     src="{{@$url}}"
                     title="ICARE" frameborder="0"
                     allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                     allowfullscreen></iframe>
                  @else
                  <div class="panel panel-warning">
                     <div class="panel-heading">Maaf</div>
                     <div class="panel-body">Data belum tersedia</div>
                   </div>
                  @endif

               </div>
            </div>
         </div>
   </div>
</div>
</form>
@endsection

@section('script')
@endsection