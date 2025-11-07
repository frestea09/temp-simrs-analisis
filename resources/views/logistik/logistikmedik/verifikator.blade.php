@extends('master')
@section('header')
  <h1>Logistik Medik - Penerimaan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-sm-3 text-center text-center iconModule">
        <a href="{{ url('logistikmedik/verifikasi') }}" ><img src="{{ asset('menu/fixed/verifikatorpo.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Verifikator PO</h5>
      </div>
    </div>
    <div class="box-footer">

    </div>
  </div>


@endsection

@section('script')
  <script type="text/javascript">


  </script>
@endsection
