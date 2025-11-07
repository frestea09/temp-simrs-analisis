@extends('master')
@section('header')
  <h1>Logistik Medik <small>LAPORAN</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/permintaan') }}" ><img src="{{ asset('menu/fixed/permintaanstok.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Permintaan Stok</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/transfer-permintaan/') }}" ><img src="{{ asset('menu/fixed/kirimpermintaan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Kirim Permintaan Stok</h5>
      </div>
      {{-- <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Permintaan</h5>
      </div> --}}
      {{-- <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Tagihan</h5>
      </div>
      <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Pemakaian</h5>
      </div>
      <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Stock Opname</h5>
      </div>
      <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Stock Depo</h5>
      </div>
      <div class="col-sm-3 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Buffer</h5>
      </div> --}}



    </div>
    <div class="box-footer">

    </div>
  </div>


@endsection

@section('script')
  <script type="text/javascript">


  </script>
@endsection
