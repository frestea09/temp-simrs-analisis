@extends('master')
@section('header')
  <h1>Logistik Medik - @role(['po','pphp']) PO @endrole @role(['penerimaanpo']) Penerimaan @endrole <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
       <div class="box-body">
        @role(['po','pphp'])
        <div class="col-sm-3 text-center text-center iconModule">
        <a href="{{ url('logistikmedik/po') }}" ><img src="{{ asset('menu/fixed/po.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>PO</h5>
        </div>
        @endrole
        @role(['penerimaanpo'])
        <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/penerimaan') }}" ><img src="{{ asset('menu/fixed/faktur.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Faktur (Penerimaan)</h5>
        </div>
      @endrole

    </div>
    <div class="box-footer">

    </div>
  </div>


@endsection

@section('script')
  <script type="text/javascript">


  </script>
@endsection
