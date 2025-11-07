@extends('master')
@section('header')
    <h1>Logistik Medik - Setup <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="col-sm-3 iconModule text-center text-center">
                <a href="{{ url('/masterobat') }}"><img src="{{ asset('menu/fixed/obatgenerik.png') }}" width="50px"
                        heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Master Obat</h5>
            </div>
            <div class="col-sm-3 iconModule text-center text-center">
                <a href="{{ url('logistikmedik/view-pejabat') }}"><img src="{{ asset('menu/fixed/masterpejabat.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Master Pejabat</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/gudang') }}"><img src="{{ asset('menu/fixed/setupgudang.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Setup Gudang</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/supplier') }}"><img src="{{ asset('menu/fixed/mastersuplier.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Master Supplier</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/periode') }}"><img src="{{ asset('menu/fixed/masterperiode.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Master Periode</h5>
            </div>
            <div class="col-sm-3 iconModule bpjs text-center">
                <a href="{{ url('logistikmedik/pengirimpenerima') }}"><img
                        src="{{ asset('menu/fixed/bahanpelayanan.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Bahan Pelayanan</h5>
            </div>

            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-narkotik') }}"><img src="{{ asset('menu/fixed/obatnarkotik.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat Narkotik</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-high-alert') }}"><img
                        src="{{ asset('menu/fixed/obathighalert.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Obat High Alert</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-generik') }}"><img src="{{ asset('menu/fixed/obatgenerik.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat Generik</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-non-generik') }}"><img src="{{ asset('menu/fixed/obatgenerik.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat Non-Generik</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-formularium') }}"><img
                        src="{{ asset('menu/fixed/obatformularium.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Obat Formularium</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-non-formularium') }}"><img
                        src="{{ asset('menu/fixed/obatnonformula.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Obat Non Formularium</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-psikotoprik') }}"><img src="{{ asset('menu/fixed/obatpsiko.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat Psikotoprik</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-bebas') }}"><img src="{{ asset('menu/fixed/obatbebas.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat Bebas</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-e-katalog') }}"><img
                        src="{{ asset('menu/fixed/obatekatalog.png') }}" width="50px" heigth="50px" width="50px"
                        heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat E-Katalog</h5>
            </div>

            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-fornas') }}"><img src="{{ asset('menu/fixed/obatfornas.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat Fornas</h5>
            </div>


            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-lasa') }}"><img src="{{ asset('menu/fixed/obatlasa.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Obat Lasa</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/obat-antibiotik') }}"><img src="{{ asset('menu/fixed/antibiotik.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Antibiotik</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('logistikmedik/pengelompokan-obat') }}"><img
                        src="{{ asset('menu/fixed/obathighalert.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Pengelompokan Obat</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('farmasi/etiket') }}" ><img src="{{ asset('menu/sidebar/Medical.svg') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
                </a>
                <h5>Aturan Pakai</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('penjualan/master-uang-racik') }}" ><img src="{{ asset('menu/fixed/masteruangracik.png') }}" width="50px" heigth="50px"  class="img-responsive" alt="" style="50%"/>
                </a>
                <h5>Master Uang Racik</h5>
            </div>
            <div class="col-sm-3 iconModule text-center">
                <a href="{{ url('penjualan/master-cara-minum') }}" ><img src="{{ asset('menu/fixed/mastercaraminum.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle l" alt="" style="50%"/>
                </a>
                <h5>Master Cara Minum</h5>
            </div>
        </div>
    </div>

    {{-- <div class="box-footer">

    </div> --}}
    </div>
@endsection

@section('script')
    <script type="text/javascript"></script>
@endsection
