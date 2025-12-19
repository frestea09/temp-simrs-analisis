@extends('master')
@section('header')
  <h1>Pendaftaran Rawat Inap  <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('frontoffice/rawat-inap') }}" ><img src="{{ asset('menu/fixed/daftarpns.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Registrasi RANAP Langsung</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('admission') }}" ><img src="{{ asset('menu/fixed/regisranap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Registrasi RANAP dari <b>IGD & RAJAL</b></h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('rawatinap/antrian') }}" ><img src="{{ asset('menu/fixed/pilihbed.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Pilih Bed Rawap Inap</h5>
      </div>

      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/frontoffice/supervisor/ubahdpjp') }}" ><img src="{{ asset('menu/fixed/ubahdpjp.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Ubah DPJP</h5>
      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('list-rawat-inap-hari-ini') }}" ><img src="{{ asset('menu/fixed/hapusranap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Hapus Rawat Inap</h5>
      </div>

        @if (!empty(session('no_sep')))
          <script type="text/javascript">
            window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=600,height=300)
          </script>
        @endif

    </div>

  </div>
@endsection
