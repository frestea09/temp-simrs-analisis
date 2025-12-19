@extends('master')
@section('header')
  <h1>Radiologi - Cari Pasien <small></small></h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		{{-- {!! Form::open(['method' => 'POST', 'url' => 'radiologi/hasil-radiologi', 'class'=>'form-hosizontal']) !!}
		<div class="row">
			<div class="col-md-6">
			<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
				<span class="input-group-btn">
				<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal Periode</button>
				</span>
				{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
			</div>
			</div>
		</div>
		{!! Form::close() !!} --}}
    {!! Form::open(['method' => 'POST', 'url' => 'radiologi/cari-pasien', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-4">
        <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
          <span class="input-group-btn">
          <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
          </span>
          @if (session('no_rm'))
              
          {!! Form::text('no_rm', '', ['class' => 'form-control', 'required' => 'required']) !!}
          @else
          {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!}
              
          @endif
        </div>
        </div>
        <div class="col-md-4">
          <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
        </div>
      </div>
        {!! Form::close() !!}
		<hr>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed" id="data">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Status</th>
              
                <th>Nama</th>
                <th>Nama Pemeriksaan</th>
                <th>No RM</th>
                <th>Cara Bayar</th>
                <th>Asal Poli / Ruangan</th>
                <th>Layanan</th>
                <th>Dokter</th>
                <th>Waktu Entry</th>
                <th>Waktu Entry Ekspertise</th>
                <th>Cetak</th>
               
                <th>Edit</th>
                <th>Hapus</th>
                <th class="text-center" scope="col">Billing</th>
                <th class="text-center" scope="col">Ekspertise</th>
                <th class="text-center" scope="col">Note</th>
                <th class="text-center" scope="col">SEP</th>
                <th class="text-center" scope="col">Order RIS</th>
              </tr>
            </thead>
            <tbody>
              @isset($radiologi)
                @foreach ($radiologi as $d)
                    @php
                        $reg = \Modules\Registrasi\Entities\Registrasi::find(@$d->id);
                        @$klinis = @\App\RadiologiEkspertise::where('folio_id', @$d->folios_id)->first()->klinis;
                        $eksp = @\App\RadiologiEkspertise::where('folio_id', @$d->folios_id)->orderBy('created_at', 'desc')->first();
                        $folio = Modules\Registrasi\Entities\Folio::find($d->folios_id);
                        $ruangan = App\Rawatinap::where('registrasi_id', $reg->id)->first();
                    @endphp
                    <tr>
                      <td>{{ $no++  }}</td>
                      @if (\App\RadiologiEkspertise::where('folio_id', $d->folios_id)->first() == null)
                      <td class="blink_me"> <b>Baru</b> </td>
                      @else
                        <td><b style="color:red">Selesai</b></td>
                      @endif
                      <td>{{ baca_pasien(@$reg->pasien_id) }}</td>
                     
                      <td>{{ $d->namatarif }}</td>
                      <td>{{ baca_norm(@$reg->pasien_id) }}</td>
                      <td>{{ baca_carabayar(@$reg->bayar) }}</td>
                      <td>{{ baca_poli(@$reg->poli_id) }} / {{ baca_kelompok(@$ruangan->kelompokkelas_id) }}</td>
                      <td>{{ cek_jenis_reg(@$reg->status_reg) }}</td>
                      {{-- <td>{!! @$klinis !!}</td> --}}
                      {{-- <td>{{ $d->no_dokument }}</td>
                      <td>{!! substr($d->ekspertise,0,50) !!}</td> --}}
                      <td>{{ baca_dokter(@$folio->dokter_radiologi) }}</td>
                      {{-- <td>
                        @if (@$folio->created_at->format('H:i:s') == '00:00:00')
                        {{ @$folio->updated_at->format('d-m-Y H:i:s')}}
                        @else
                        {{  @$folio->created_at->format('d-m-Y H:i:s') }}
                        @endif
                      </td> --}}
  
                      <td>{{  @$folio->created_at->format('d-m-Y H:i:s') }}</td>
                      
                      @if ($eksp != null)
                       <td>{{ @$eksp->created_at->format('d-m-Y H:i:s')}}</td>
                      @else
                        <td><i>Belum Ter Ekspertise</i></td>
                      @endif
                       <td> 
                          <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-success">Cetak</button>
                            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                              @foreach (\App\RadiologiEkspertise::where('folio_id', $d->folios_id)->get() as $p)
                                <li>
                                  <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$d->id."/".$folio->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                                </li>
                              @endforeach
                            </ul>
                          </div>
                      </td>
                      <td> 
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-info">Edit</button>
                          <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach (\App\RadiologiEkspertise::where('folio_id', $d->folios_id)->get() as $p)
                              <li>
                                <a href="{{ url("radiologi/edit-ekpertise/".$p->id."/".$d->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-edit"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                      </td>
                      <td> 
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                          <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach (\App\RadiologiEkspertise::where('folio_id', $d->folios_id)->get() as $p)
                              <li>
                                <a onclick="hapusEkspertise({{ $p->id }})" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                      </td>
                    <td>
                      <a class="btn  btn-flat btn-warning btn-xs" href="{{url('/radiologi/view-rad/'.@$d->id)}}">Lihat</a>
                      @if (cek_jenis_reg(@$reg->status_reg) == 'Rawat Inap')
                        <a href="{{ url('radiologi/entry-tindakan-irna/'. @$d->id.'/'.
                        @$reg->pasien_id) }}" class="btn btn-primary btn-sm btn-flat">Tambah</a>
                        @elseif(cek_jenis_reg(@$reg->status_reg) == 'Rawat Jalan')  
                        <a href="{{ url('radiologi/entry-tindakan-irj/'. @$d->id.'/'.@$reg->pasien_id) }}" class="btn btn-primary btn-sm btn-flat">Tambah</a>
                        @else
                        <a href="{{ url('radiologi/insert-kunjungan/'. @$d->id.'/'.@$reg->pasien_id) }}" class="btn btn-primary btn-sm btn-flat">Tambah</a>
                      @endif
                    </td>
                    <td>
                      <a class="btn btn-success btn-xs" target="_blank" href="{{url('/radiologi/create-ekspertise/'.$d->id.'/'.$d->folios_id)}}">Proses</a>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$folio->id }}" onclick="showNote({{ $folio->id }})"><i class="fa fa-book"></i></button>
                    </td>
                    <td>
                      @if (!empty(@$reg->no_sep))
                        <a href="{{ url('cetak-sep_rad/'.@$reg->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                        @endif
                      </td>
                    <td>
                      @if (cek_status_reg($reg->status_reg) == "I")
                        <a href="{{ url('emr/ris/inap/' . $reg->id) }}" target="_blank" class="btn btn-flat btn-danger btn-xs">ORDER RIS</a>
                      @elseif (cek_status_reg($reg->status_reg) == "J")
                        <a href="{{ url('emr/ris/jalan/' . $reg->id) }}" target="_blank" class="btn btn-flat btn-danger btn-xs">ORDER RIS</a>
                      @elseif (cek_status_reg($reg->status_reg) == "G")
                        <a href="{{ url('emr/ris/igd/' . $reg->id) }}" target="_blank" class="btn btn-flat btn-danger btn-xs">ORDER RIS</a>
                      @endif
                    </td>
                    </tr>
                @endforeach
              @endisset
            </tbody>
      </table>
    </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
  <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="form">
            <table class="table table-condensed table-bordered">
              <tbody>
                  <tr>
                    <th>Tanggal Order :<input class="form-control" type="date" name="tgl_order"> </th>
                    
                  </tr>
                  <tr>
                   
                      <th>Catatan : <input type="text" class="form-control" name="catatan" id="catatan"> </th>
                      <input type="hidden" name="id_reg"> 
                    
                  </tr>
              </tbody>
            </table>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="saveNote()" class="btn btn-default btn-flat">Simpan</button>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
@parent
  <script type="text/javascript">
    //CKEDITOR
    $(".skin-blue").addClass( "sidebar-collapse" );

    CKEDITOR.replace( 'pemeriksaan', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });
    // function coba(registrasi_id) {
    //   $('#pemeriksaanModel').modal({
    //     backdrop: 'static',
    //     keyboard : false,
    //   })
    //   $('.modal-title').text('Catataan Order Radiologi')
    //   $("#form")[0].reset()
    //   CKEDITOR.instances['pemeriksaan'].setData('')
    //   $.ajax({
    //     url: '/radiologi/catatan-pasien/'+registrasi_id,
    //     type: 'GET',
    //     dataType: 'json',
    //   })
    //   .done(function(data) {
    //     $('input[name="waktu"]').val(data.created_at)
    //     CKEDITOR.instances['pemeriksaan'].setData(data.pemeriksaan)
    //   })
    //   .fail(function() {

    //   });
    // }
    
    // CKEDITOR.replace( 'ekspertise', {
    //   height: 200,
    //   filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    //   filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    // });

  

    function hapusEkspertise(id) {
      
        confirm('yakin hapus ekspertise?')
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/radiologi/hapus-ekpertise/'+id,
          type: 'POST',
          dataType: 'json',
        })
        .done(function(data) {
          alert('berhasil hapus ekspertise');
          location.reload();
        })
        .fail(function() {
          alert('gagal hapus ekspertise');
          location.reload();
        });

        }






    function showNote(id) {

      $('#pemeriksaanModel').modal()
      $('.modal-title').text('Catataan Pengambilan Hasil')
      $("#form")[0].reset()
      $.ajax({
        url: '/radiologi/showNote/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="id_reg"]').val(data.id)
        $('input[name="tgl_order"]').val(data.embalase)
        $('input[name="catatan"]').val(data.catatan)
      })
      .fail(function() {
        alert(data.error);
      });
      
    }

    function saveNote() {
      var id_reg =  $('input[name="id_reg"]').val();
    
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/radiologi/updateNote/'+id_reg,
        type: 'POST',
        dataType: 'json',
        data: {
          note: $('input[name="catatan"]').val(),
          tgl_note: $('input[name="tgl_order"]').val()
        }
      })
      .done(function(data) {
        alert('berhasil simpan catatan')
       
      })
      .fail(function() {
        alert('gagal input');
      });

      }







  





  </script>
  <style>

    .blink_me {
            animation: blinker 2s linear infinite;
            color: orange;
          }
    
          @keyframes blinker {
            50% {
              opacity: 0;
            }
          }
    
    
      </style>
@endsection