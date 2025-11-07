@extends('master')
@section('header')
  <h1>Logistik Non Medik - Master <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/master-gudang') }}" ><img src="{{ asset('menu/gedung.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Gudang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/satuan-barang') }}" ><img src="{{ asset('menu/office-material-1-2.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Satuan Barang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/master-barang') }}" ><img src="{{ asset('menu/giftbox.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Barang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/master-kategori') }}" ><img src="{{ asset('menu/office-material-1-2.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Kategori Master Barang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/barang-pergudang') }}" ><img src="{{ asset('menu/office-material-1-2.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Barang Per Gudang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/supplier-nonmedik') }}" ><img src="{{ asset('menu/rep.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Supplier Non Medik</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/master-bidang') }}" ><img src="{{ asset('menu/id-card.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Bidang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/master-golongan') }}" ><img src="{{ asset('menu/pencil.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Golongan</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/master-kelompok') }}" ><img src="{{ asset('menu/packing.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Kelompok</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/sub-kelompok') }}" ><img src="{{ asset('menu/packing-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Sub Kelompok</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/sub-subkelompok') }}" ><img src="{{ asset('menu/packing-2.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Sub Sub Kelompok</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/master-periode') }}" ><img src="{{ asset('menu/weekly-calendar.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Master Periode</h5>
        </div>
    </div>
    <div>
  </div>
@endsection
