@extends('master')

@section('header')
  <h1 style="font-size: 20pt;color:black;font-weight: bold;">Front Office - Daftar Antrian Loket JKN Bawah</h1>
@endsection

@section('content')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Data Antrian Hari Ini &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-5">
              <div id="daftarantrian"></div>
            </div>
            {{-- ============================ --}}
            <div class="col-md-7">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Sudah di panggil</h3>
                </div>
                <div class="panel-body">
                  <div class='table-responsive'>
                    <table class='table table-striped table-bordered table-hover table-condensed' >
                      <thead>
                        <tr>
                          <th class="text-center">Antrian</th>
                          <th>Waktu Antri</th>
                          {{-- <th>Pasien</th> --}}
                         
                          {{-- <th class="text-center">ID Satu Sehat</th> --}}
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($terpanggil as $key => $d)
                          <tr>
                            <td class="text-center"><b>{{$d->kelompok}}{{ $d->nomor }}</b></td>
                            <td>{{ $d->created_at }}</td> 
                            {{-- @php
                                 $ss    = \Modules\Registrasi\Entities\Registrasi::where('antrian_id', @$d->id)->first();
                            @endphp
                            @if (satusehat())
                            <td>{{ @$ss->id_encounter_ss }}</td> --}}
                            {{-- @else
                            <td>-</td> --}}
                            {{-- @endif --}}
                            <td>
                              @if (cek_registrasi(@$d->id, 2) < 1)
                                @if ($d->status <= 2)
                                <div class="btn-group" style="min-width:0px !important">
                                  <a href="{{ route('antrian2.panggilkembali',@$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
                                    {{-- <a href="{{ route('antrian.panggilkembali',$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a> --}}
                                    {{-- <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                      <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                      @for ($i = 1; $i <= 6; $i++)
                                        <li><a href="{{ route('antrian.panggilkembali-beda',[$d->id,$i]) }}">Loket {{$i}}</a></li>
                                      @endfor
                                    </ul> --}}
                                  </div>
                                @endif

                                <button type="button" class="btn btn-success btn-flat btn-sm" onclick="searchPasien({{ @$d->id }})"><i class="fa fa-registered"></i> Proses</button>
                              @else
                                @php
                                  $reg = Modules\Registrasi\Entities\Registrasi::where('antrian_id', @$d->id)->first();
                                @endphp

                                <a href="{{ url('/frontoffice/cetak-tracer/'.@$reg->id) }}" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-print"></i> CETAK</a>
                              @endif

                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <div style="width: 100%; display:flex; justify-content:center;align-items:center">
                        {{$terpanggil->links()}}
                    </div>
                  </div>
                </div>
                <div class="panel-footer">

                </div>
              </div>
            </div>
          </div>

          @if (!empty(session('no_sep')))
            <script type="text/javascript">
              window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=600,height=300)
            </script>
          @endif



        </div>
      </div>
      {{-- Modal pencarian --}}
      <div class="modal fade" id="pasien">
        <div class="modal-dialog" style="width: max-content;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <div class="container">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="box box-primary" style="border: 1.5px solid #0275d8 !important;">
                      <div class="box-header with-border">
                      <h3 class="box-title">Data Pasien Baru</h3>
                      </div>
                      <div class="box-body">
                        <b>Pasien Baru: </b>
                        <a href="{{ url('/registrasi/create') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
                        <a href="{{ url('/registrasi/create_umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a>
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
                        <a href="{{ url('/antrian/reg_blmterdata/1/jkn') }}" class="btn btn-default btn-flat btn-sm">JKN</a>
                        <a href="{{ url('/antrian/reg_blmterdata/1/umum') }}" class="btn btn-default btn-flat btn-sm">NON JKN</a>
                        <p style="margin-top:15px"><small class="text-danger">*Pasien Belum Terdata adalah Pasien yang secara berkas sudah pernah tercatat di Rekam Medis namun belum terinput di Database SIMRS.</small></p>
                      </div>
                    </div>
                  </div>
                </div>
                <br/><br/>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive" style="margin-top: -30px;">
                      <div class="controls">
                        <div class="col-md-2">
                          <input type="text" name="no_rm" id="no_rm_s" class="form-control" placeholder="No.RM">
                        </div>
                        <div class="col-md-2">
                          <input type="text" name="namas" id="namas" class="form-control" placeholder="Nama">
                        </div>
                        <div class="col-md-2">
                          <input type="text" name="tgllahir" id="tgllahirs" class="form-control" placeholder="TglLahir : 06101993">
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="alamats" id="alamats" class="form-control" placeholder="Alamat">
                        </div>
                        <div class="col-md-3">
                          <button type="text" id="btnFiterSubmitSearch" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
                          <button style="margin-left:80px;" type="text" id="btnFiterSubmitRefresh" class="btn btn-danger"><i class="fa fa-refresh"></i> Refresh</button>
                        </div>
                        </div>
                        &nbsp;
                      {{-- <input type="text" name="email" class="form-control searchEmail" placeholder="Search for Email Only..."/> --}}
                      <table class="table table-hover table-condensed table-bordered" id="tablePasien">
                        <thead>
                          <tr>
                            <th style="vertical-align: middle;">Nama</th>
                            <th style="vertical-align: middle;">No. RM</th>
                            <th class="text-center" style="vertical-align: middle;">No. RM Lama</th>
                            <th style="vertical-align: middle;">Ibu Kandung</th>
                            <th style="vertical-align: middle;">Alamat</th>
                            <th class="text-center" style="vertical-align: middle;">Tgl.Lahir</th>
                            <th style="vertical-align: middle;">NIK</th>
                            <th style="vertical-align: middle;">No. JKN</th>
                            <th class="text-center" style="vertical-align: middle;">JKN</th>
                            <th class="text-center" style="vertical-align: middle;">Non JKN</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
                {{-- <b>Pasien Baru: </b>
                <a href="{{ url('/registrasi/create') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
                <a href="{{ url('/registrasi/create_umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a> --}}
              
              {{-- <b>PASIEN BLM TERDATA: </b>
              <a href="{{ url('/antrian/reg_blmterdata/1/jkn') }}" class="btn btn-default btn-flat btn-sm">JKN</a>
              <a href="{{ url('/antrian/reg_blmterdata/1/umum') }}" class="btn btn-default btn-flat btn-sm">NON JKN</a> --}}
              <div class="modal-footer">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>



<!-- jQuery 3 -->
<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('#dataAntrian').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false
    });
  });

  $(document).ready(function() {
    $('#daftarantrian').load("{{ route('antrian2.daftarpanggil') }}");
    setInterval(function () {
      $('#daftarantrian').load("{{ route('antrian2.daftarpanggil') }}");
    },9000);
  });

  function searchPasien(antrian_id){
    //alert(antrian_id)
    $('#pasien').modal({backdrop: 'static', keybord: false});
    $('.modal-title').text('Pendaftaran Pasien')
    var table;
    table = $('#tablePasien').DataTable({
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
      ajax: {
          url: '/pasien/search-pasien/'+antrian_id+'/'+2,
          data: function (d) {
            d.no_rm = $('#no_rm_s').val();
            d.alamat = $('#alamats').val();
            d.tgllahir = $('#tgllahirs').val();
            d.nama = $('#namas').val();
            }
        },
      // ajax: ,
      columns: [
          {data: 'nama'},
          {data: 'no_rm'},
          {data: 'no_rm_lama'},
          {data: 'ibu_kandung'},
          {data: 'alamat'},
          {data: 'tgllahir'},
          {data: 'nik'},
          {data: 'no_jkn'},
          {data: 'jkn', searchable: false, sClass: 'text-center'},
          {data: 'non-jkn', searchable: false, sClass: 'text-center'}
      ]
    });
    // $(".searchEmail").keyup(function(){
    //       table.draw();
    //   });
    $('#btnFiterSubmitSearch').click(function(){
      table.draw();
    }); 
    $('#btnFiterSubmitRefresh').click(function(){
      $('#no_rm_s').val('');
      $('#alamats').val('');
      $('#tgllahirs').val('');
      $('#namas').val('');
      table.draw();
    }); 
  }


</script>

@stop
