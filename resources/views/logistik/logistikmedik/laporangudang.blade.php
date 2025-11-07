@extends('master')
@section('header')
  <h1>Logistik Medik <small>LAPORAN</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {{-- <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/po') }}" ><img src="{{ asset('menu/pegawai.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan PO</h5>
      </div> --}}
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/kartustok') }}" ><img src="{{ asset('menu/fixed/kartustok.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Kartu Stok</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/kartustok/gelobal') }}" ><img src="{{ asset('menu/fixed/kartustokglobal.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Kartu Stok Global</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/penerimaan') }}" ><img src="{{ asset('menu/fixed/laporanpenerimaan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Penerimaan</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/tagihan') }}" ><img src="{{ asset('menu/fixed/laporanpenagihan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Tagihan</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/pembelian-obat') }}" ><img src="{{ asset('menu/fixed/laporanpenagihan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Belanja Obat</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/pengeluaran') }}" ><img src="{{ asset('menu/fixed/laporanpenagihan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pengeluaran</h5>
      </div>
      {{-- <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pemakaian</h5>
      </div> --}}
      {{-- <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Stock Opname</h5>
      </div> --}}
      {{-- <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Stock Depo</h5>
      </div> --}}
      {{-- <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Buffer</h5>
      </div> --}}
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/pendapatan-pasien-perdepo') }}" ><img src="{{ asset('menu/fixed/laporanperdepo.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pendapatan Pasien PerDepo</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/pendapatan-pasien-bpjs') }}" ><img src="{{ asset('menu/fixed/laporanpasienbpjs.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pendapatan Pasien BPJS</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan/pendapatan-pasien-bebas') }}" ><img src="{{ asset('menu/fixed/laporanpasienbebas.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pendapatan Pasien Bebas</h5>
      </div>
      <div class="col-sm-3 iconModule text-center">
        <a href="{{ url('farmasi/laporan-expired-date') }}"><img src="{{ asset('menu/fixed/laporanexpired.png') }}"
                width="50px" heigth="50px" class="img-responsive" alt="" /></a>
        <h5>Laporan Expired Date</h5>
    </div>
      <div class="col-sm-3 iconModule text-center">
        <a href="{{ url('frontoffice/laporan/lap-penunjang') }}"><img src="{{ asset('menu/fixed/laporanexpired.png') }}"
                width="50px" heigth="50px" class="img-responsive" alt="" /></a>
        <h5>Laporan Penunjang</h5>
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
