@extends('master')
@section('header')
  <h1>Farmasi - Master <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('supliyer') }}" ><img src="{{ asset('menu/fixed/suplier.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Suplier</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('satuanjual') }}" ><img src="{{ asset('menu/fixed/satuanjual.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Satuan Jual</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('satuanbeli') }}" ><img src="{{ asset('menu/fixed/satuanbeli.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Satuan Beli</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kategoriobat') }}" ><img src="{{ asset('menu/fixed/kategoriobat.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Kategori Obat</h5>
      </div>
      @role('logistikmedik')
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('masterobat') }}" ><img src="{{ asset('menu/fixed/masterobat.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Master Obat</h5>
      </div>
      @endrole
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('masterobat-batches') }}" ><img src="{{ asset('menu/fixed/masterbatches.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Master Batches</h5>
      </div> --}}
   
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('farmasi/etiket') }}" ><img src="{{ asset('menu/sidebar/Medical.svg') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Aturan Pakai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('penjualan/master-uang-racik') }}" ><img src="{{ asset('menu/fixed/masteruangracik.png') }}" width="50px" heigth="50px"  class="img-responsive" alt="" style="50%"/>
        </a>
        <h5>Master Uang Racik</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('penjualan/master-cara-minum') }}" ><img src="{{ asset('menu/fixed/mastercaraminum.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle l" alt="" style="50%"/>
        </a>
        <h5>Master Cara Minum</h5>
      </div> --}}
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/trucking.png') }}" width="50px" heigth="50px"  class="img-responsive" alt="" style="50%"/>
        </a>
        <h5>Faktur Masuk</h5>
      </div> --}}

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
