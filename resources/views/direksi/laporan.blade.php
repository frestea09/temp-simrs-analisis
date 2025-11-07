@extends('master')
@section('header')
  <h1>Direksi - Laporan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('menu/finance-book.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Tagihan</h5>
          </div> --}}
          <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/fixed/pendapatan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
            </a>
            <h5>Pendapatan</h5>
          </div>
          <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/display') }}" target="_blank" ><img src="{{ asset('menu/fixed/displaybed.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
            </a>
            <h5>Display Bed</h5>
          </div>
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-penerimaan') }}" ><img src="{{ asset('menu/cabinet.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Penerimaan </h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-pem-uang-muka') }}" ><img src="{{ asset('menu/dollar-symbol-1.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Pembayaran Uang Muka</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('frontoffice/laporan/pengunjung') }}" ><img src="{{ asset('menu/report.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Pengunjung</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('frontoffice/laporan/kunjungan') }}" ><img src="{{ asset('menu/report-1.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Kunjungan</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-pasien') }}" ><img src="{{ asset('menu/pasien.ico') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Pasien</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/informasi-rawat-inap') }}" ><img src="{{ asset('menu/hospital-bed.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Informasi <br>Rawat Inap</h5>
          </div> --}}
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('frontoffice/laporan/diagnosa-irj') }}" ><img src="{{ asset('menu/10.jpg') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>10 Besar <br>Diagnosa IRJ</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('frontoffice/laporan/diagnosa-irna') }}" ><img src="{{ asset('menu/10.jpg') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>10 Besar <br> Diagnosa IRNA</h5>
          </div> --}}
         
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-selisih-negatif') }}" ><img src="{{ asset('menu/calculating-2.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Selisih Negative JKN</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-naik-kelas') }}" ><img src="{{ asset('menu/hierarchical-structure.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Naik Kelas</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-kinerja') }}" ><img src="{{ asset('menu/bars-chart.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Kinerja</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/kinerja-rawat-jalan') }}" ><img src="{{ asset('menu/line-chart.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Kinerja Rawat Jalan</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/kinerja-rawat-darurat') }}" ><img src="{{ asset('menu/line-graph.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Kinerja Rawat Darurat</h5>
          </div> --}}
          {{-- <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/kinerja-rawat-inap') }}" ><img src="{{ asset('menu/line-graphic.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Kinerja Rawat Inap</h5>
          </div> --}}
        </div>
      </div>
      {{-- Remunerasi --}}
      {{-- <div class="row">
        <div class="col-md-12">
         
          <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('/direksi/laporan-bridging-jkn') }}" ><img src="{{ asset('menu/ecologism.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Bridging JKN</h5>
          </div>
          <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('direksi/laporan/pengunjung/igd') }}" ><img src="{{ asset('menu/report-1.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Pengunjung IGD</h5>
          </div>
          <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('direksi/laporan/pengunjung/inap') }}" ><img src="{{ asset('menu/report-1.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Pengunjung Rawat Inap</h5>
          </div>
          <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="{{ url('direksi/laporan/pengunjung/jalan') }}" ><img src="{{ asset('menu/report-1.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Pengunjung Rawat Jalan</h5>
          </div>
        </div>
      </div> --}}


    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
