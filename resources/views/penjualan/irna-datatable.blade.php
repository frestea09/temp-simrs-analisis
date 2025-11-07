@extends('master')
@section('header')
<h1>Penjualan Rawat Inap  </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

    <b>Pasien Baru: </b>
    <a href="{{ url('/registrasi/igd/jkn') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
    <a href="{{ url('/registrasi/igd/umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a>

    <div class="table-responsive" style="margin-top: -30px;">
      <table class="table table-hover table-condensed table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>No. RM Baru</th>
            <th>No. RM Lama</th>
            <th>Ibu Kandung</th>
            <th>Alamat</th>
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
    <b>PASIEN BLM TERDATA: </b>
    <a href="{{ url('/registrasi/igd/jkn-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">JKN</a>
    <a href="{{ url('/registrasi/igd/umum-blm-terdata') }}" class="btn btn-default btn-flat btn-sm">NON JKN</a>
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
      ajax: '/pasien/search-pasien-igd/',
      columns: [
          {data: 'nama'},
          {data: 'no_rm'},
          {data: 'no_rm_lama'},
          {data: 'ibu_kandung'},
          {data: 'alamat'},
          {data: 'nik'},
          {data: 'no_jkn'},
          {data: 'jkn', searchable: false, sClass: 'text-center'},
          {data: 'non-jkn', searchable: false, sClass: 'text-center'}
      ]
    });

</script>
@endsection
