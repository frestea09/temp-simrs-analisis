@extends('master')
@section('header')
  <h1>Logistik Medik - Admin <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/pegawai.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import Barang Gudang Pusat</h5>
      </div>
      <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import Barang Depo</h5>
      </div>
      <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/dpjp.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Adjust Kartu Stock</h5>
      </div>
       <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/hapusreg.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Adjust Semua Stock</h5>
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
