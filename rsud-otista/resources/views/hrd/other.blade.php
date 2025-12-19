@extends('master')
@section('header')
  <h1>HRD - Menu Lain </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/pembinaandisiplin.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Pembinaan Disiplin</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/skjafung.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>SK JAFUNG</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/absensi.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Absensi</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/izinperceraian.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Izin Perceraian</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/penilaianangkakredit.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Penilaian Angka Kredit</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/kenaikangaji.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Kenaikan Gaji Berkala</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/tambahanpenghasilan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Tambahan Penghasilan Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/satyalencana.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Satya Lencana</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/pensiun.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Pensiun</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/dukacita.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Duka Cita</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('hrd/master/pendidikan') }}" ><img src="{{ asset('menu/fixed/pendidikan.png') }}" width="50px" heigth="50px"  class="img-responsive"/>
        <h5>Pendidikan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('hrd/master/struktur') }}" ><img src="{{ asset('menu/fixed/strukturorganisasi.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Struktur Organisasi</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
