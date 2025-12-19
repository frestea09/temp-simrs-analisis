@extends('master')
@section('header')
  <h1>Kontrol Panel - Keuangan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule ">
        <a href="{{ url('tahuntarif') }}" ><img src="{{ asset('menu/fixed/tahuntarif.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Tahun Tarif</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('mastersplit') }}" ><img src="{{ asset('menu/fixed/mastersplit.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Master Split</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kategoriheader') }}" ><img src="{{ asset('menu/fixed/kategoriheader.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Kategori Header</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kategoritarif') }}" ><img src="{{ asset('menu/fixed/kategoritarif.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Kategori Tarif</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule ">
        <a href="{{ url('kelompoktarif') }}" ><img src="{{ asset('menu/fixed/transaksilangsung.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Kelompok Tarif</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('politype') }}" ><img src="{{ asset('menu/fixed/kategoripoli.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Kategori Poli</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('biayaregistrasi') }}" ><img src="{{ asset('menu/fixed/biayapendaftaran.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Biaya Pendaftaran</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('tarif/rawatjalan') }}" ><img src="{{ asset('menu/fixed/tarifrajal.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Tarif Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('tarif/rawatdarurat') }}" ><img src="{{ asset('menu/fixed/tarifigd.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Tarif Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('masterpagu') }}" ><img src="{{ asset('menu/fixed/tarifrajal.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Master Pagu</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('tarif/irna') }}" ><img src="{{ asset('menu/fixed/tarifranap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Tarif Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('biayapemeriksaan') }}" ><img src="{{ asset('menu/fixed/konfigurasibiaya.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Konf Biaya Pemeriksaan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('mastermapping') }}" ><img src="{{ asset('menu/fixed/mappingtarif.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Mapping Tarif INACBG</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('mapping-biaya') }}" ><img src="{{ asset('menu/fixed/mappingrincian.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Mapping Rincian Biaya</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/frontoffice/laporan/pengunjung-tagihan-irj') }}" ><img src="{{ asset('menu/fixed/mappingrincian.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Tagihan Rajal</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('biayapemeriksaanmcu') }}" ><img src="{{ asset('menu/fixed/konfigurasibiaya.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Konf Biaya MCU</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('biayapemeriksaaninfus') }}" ><img src="{{ asset('menu/fixed/konfigurasibiaya.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Konf Biaya Infus</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('biayapemeriksaanfarmasi') }}" ><img src="{{ asset('menu/fixed/konfigurasibiaya.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Konf Biaya Farmasi</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('masteridrg') }}" ><img src="{{ asset('menu/fixed/mappingtarif.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Mapping Tarif IDRG</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
