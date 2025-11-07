@extends('master')
@section('header')
  <h1>Pendaftaran - Rawat Inap Langsung </h1>
@endsection

@php
    Session::forget('blm_terdata');
@endphp

@section('content')
  <div class="row">
    <div class="col-xs-6">
      <div class="box box-primary" style="border: 1.5px solid #0275d8 !important;">
        <div class="box-header with-border">
        <h3 class="box-title">Data Pasien Baru</h3>
        </div>
        <div class="box-body">
          <b>Pasien Baru: </b>
          <a href="{{ url('/registrasi/ranap/jkn') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
          <a href="{{ url('/registrasi/ranap/umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a>
          <p style="margin-top:15px"><small class="text-primary">*Pasien Baru adalah Pasien yang belum pernah berobat dan baru mengunjungi RS pertama kali.</small></p>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="box box-primary" style="border: 1.5px solid #D9534F !important;">
        <div class="box-header with-border">
          <h3 class="box-title">Data Pasien Belum Terdata</h3>
        </div>
        <div class="box-body">
          <b>PASIEN BLM TERDATA: </b>
          <a href="{{ url('/registrasi/ranap/jkn-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">JKN</a>
          <a href="{{ url('/registrasi/ranap/jkn-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">NON JKN</a>
          <p style="margin-top:15px"><small class="text-danger">*Pasien Belum Terdata adalah Pasien yang secara berkas sudah pernah tercatat di Rekam Medis namun belum terinput di Database SIMRS.</small></p>
        </div>
      </div>
    </div>
  </div>
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
    
    {{-- <b>Pasien Baru: </b>
    <a href="{{ url('/registrasi/igd/jkn') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
    <a href="{{ url('/registrasi/igd/umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a> --}}

    <div class="table-responsive" style="margin-top: -30px;">
      <b><u>Mohon Diperhatikan</u></b><br/>
      <span style="color:red">*</span> Menu ini hanya digunakan jika pasien <b>belum diregistrasi</b> di IGD atau RAJAL (Langsung Inap)</a><br/>
      <span style="color:red">*</span> Jika pasien <b>sudah diregistrasi</b> di IGD atau RAJAL, gunakan menu <a href="{{url('/admission')}}">Registrasi RANAP dari IGD & RAJAL</a> 
      <table class="table table-hover table-condensed table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>No. RM Baru</th>
            {{-- <th>No. RM Lama</th> --}}
            <th>Ibu Kandung</th>
            <th>Alamat</th>
            <th>Tgl.Lahir</th>
            <th>NIK</th>
            <th>No. JKN</th>
            <th>JKN</th>
            <th>NON JKN</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    {{--<b>PASIEN BLM TERDATA: </b>
    <a href="{{ url('/registrasi/igd/jkn-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">JKN</a>
    <a href="{{ url('/registrasi/igd/umum-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">NON JKN</a>--}}
        @if (!empty(session('no_sep')))
          <script type="text/javascript">
            window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=600,height=300)
          </script>
        @endif

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection

@section('script')

<script type="text/javascript">
console.log(window.location.origin)
    $('.table').DataTable({
      'language': {
          "url": "/json/pasien.datatable-language.json",
      },
      pageLength  : 5,
      paging      : true,
      lengthChange: false,
      searching   : true,
      ordering    : false,
      info        : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax:{
        'url' : window.location.origin+'/pasien/search-pasien-ranap/',
        'beforeSend': function (request) {
             request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
        }
      },
      columns: [
          {data: 'nama'},
          {data: 'no_rm'},
          // {data: 'no_rm_lama'},
          {data: 'ibu_kandung'},
          {data: 'alamat'},
          {data: 'tgllahir'},
          {data: 'nik'},
          {data: 'no_jkn'},
          {data: 'jkn', searchable: false, sClass: 'text-center'},
          {data: 'non-jkn', searchable: false, sClass: 'text-center'}
      ]
    });

</script>
@endsection
