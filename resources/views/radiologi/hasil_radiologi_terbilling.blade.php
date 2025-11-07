@extends('master')
@section('header')
  <h1>Radiologi - Hasil Radiologi <small></small></h1>
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
    {!! Form::open(['method' => 'POST', 'url' => 'radiologi/terbilling', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
            </div>
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
                <th>Asal Poli</th>
                <th>Layanan</th>
               
                {{-- <th>Ekspertise</th> --}}
                <th>Dokter</th>
                <th>No Foto</th>
                <th>Waktu Order</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Waktu Hasil Ekspertise</th>
                <th>Cetak</th>
                <th>Edit</th>
                <th>TTE</th>
                <th>Hapus</th>
                <th class="text-center" scope="col">Billing</th>
                <th class="text-center" scope="col">Ekspertise</th>
                <th class="text-center" scope="col">Note</th>
                <th class="text-center" scope="col">SEP</th>
              </tr>
            </thead>
            <tbody>
              @isset($radiologi)
                @foreach ($radiologi as $d)
                    @php
                        // $reg = \Modules\Registrasi\Entities\Registrasi::find(@$d->id);
                        // @$klinis = @\App\RadiologiEkspertise::where('folio_id', @$d->folios_id)->first()->klinis;
                        $eksp =  @\App\RadiologiEkspertise::where('folio_id', @$d->folios_id)->orderBy('id', 'desc')->select('id', 'created_at', 'updated_at')->first();
                        // $folio = Modules\Registrasi\Entities\Folio::select('id', 'dokter_radiologi', 'no_foto', 'created_at', 'updated_at')->find($d->folios_id);
                        $eksps = @\App\RadiologiEkspertise::where('folio_id', $d->folios_id)->select('id', 'no_dokument', 'created_at', 'tte')->get();
  
                    @endphp
                    <tr>
                      <td>{{ $no++  }}</td>
                      @if ($eksp == null)
                      <td class="blink_me"> <b>Baru</b> </td>
                      @else
                        <td><b style="color:red">Selesai</b></td>
                      @endif
                      <td>{{ @$d->namaPasien }}</td>
                      <td>{{ $d->namatarif }}</td>
                      <td>{{ @$d->noRM }}</td>
                      <td>{{ @$d->registrasi->bayars->carabayar }}</td>
                      <td>{{ @$d->registrasi->poli->nama }}</td>
                      <td>{{ cek_jenis_reg(@$d->registrasi->status_reg) }}</td>
                      {{-- <td>{!! @$klinis !!}</td> --}}
                      {{-- <td>{{ $d->no_dokument }}</td>
                      <td>{!! substr($d->ekspertise,0,50) !!}</td> --}}
                      <td>{{ @$d->dokterRadiologi->nama }}</td>
                      <td>{{ @$d->no_foto}}</td>
                      {{-- @if (@$d->user->pegawai->id == @$d->dokter_id) --}}
                      <td>
                        @php
                            @$orderradiologi = \App\Orderradiologi::where('registrasi_id',$d->id)->first();
                        @endphp
                        @if (@$orderradiologi)
                          {{@$orderradiologi->created_at->format('d-m-Y H:i:s')}}
                        @else
                          {{ @$d->created_at->format('d-m-Y H:i:s') }}
                        @endif
                      </td>
                      {{-- @else
                        <td class="text-center">-</td>
                      @endif --}}

                      <td>{{ @$d->waktu_periksa ? date('d-m-Y H:i:s', strtotime(@$d->waktu_periksa)) : '-' }}</td>
                    
                      @if ($eksp != null)
                       <td>{{ @$eksp->updated_at->format('d-m-Y H:i:s')}}</td>
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
                              @foreach (@$eksps as $p)
                                <li>
                                  <div style="display: flex;">
                                    <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$d->id."/".$d->folios_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                                    @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                      <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$d->id."/".$d->folios_id)}}" target="_blank" class="btn btn-success btn-sm btn-flat"> Dokumen TTE </a>
                                    @elseif (!empty(@$p->tte))
                                      <a href="{{ url("/dokumen_tte/".@$p->tte)}}" target="_blank" class="btn btn-success btn-sm btn-flat"> Dokumen TTE </a>
                                    @endif
                                  </div>
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
                            @foreach (@$eksps as $p)
                              <li>
                                <a href="{{ url("radiologi/edit-ekpertise/".$p->id."/".$d->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-edit"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                      </td>
                      <td> 
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning">TTE</button>
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach (@$eksps as $p)
                              <li>
                                @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                    {{-- <a href="{{ url('/radiologi/ekspertis-pdf-tte/'. @$p->id) }}"
                                        target="_blank" class="btn btn-success btn-sm btn-flat">{{$p->no_dokument ?? $p->created_at}}</a> --}}
                                  <button class="btn btn-danger btn-sm btn-flat" onclick="showTTEModal({{$p->id}})">{{$p->no_dokument ?? $p->created_at}}</button>
                                @else
                                  <button class="btn btn-warning btn-sm btn-flat" onclick="showTTEModal({{$p->id}})">{{$p->no_dokument ?? $p->created_at}}</button>
                                @endif
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
                            @foreach (@$eksps as $p)
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
                      {{-- <a class="btn btn-primary btn-xs" href="{{url('/radiologi/view-rad/'.$d->id)}}">Tambah</a> --}}
                    </td>
                    <td>
                      <a class="btn btn-success btn-xs" target="_blank" href="{{url('/radiologi/create-ekspertise/'.$d->id.'/'.$d->folios_id)}}">Proses</a>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->folios_id }}" onclick="showNote({{ $d->folios_id }})"><i class="fa fa-book"></i></button>
                    </td>
                    <td>
                      @if (!empty(@$reg->no_sep))
                        <a href="{{ url('cetak-sep_rad/'.@$reg->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
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

  {{-- Modal TTE Ekspertise--}}
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-tte-ekspertise" action="" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE Hasil Ekspertise</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="button-proses-tte-ekspertise" onclick="prosesTTE()">Proses TTE</button>
        </div>
      </div>
      </form>
  
    </div>
  </div>

  <div id="modalPassphrase" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form id="formPassphrase" action="" method="POST">
        <input type="hidden" name="id">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Masukkan Passphrase TTE</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <div class="col-md-12" style="margin-bottom: 1rem;">
                <span style="color: red;"><i>Agar ketika melakukan TTE Dokumen tidak perlu passphrase lagi</i></span>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase_session" id="passphrase">
            </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="handleUserRefuse()" data-dismiss="modal">Abaikan</button>
            <button type="button" class="btn btn-primary" onclick="handleUserSave()" >Simpan</button>
        </div>
        </div>
        </form>
    
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

    function showTTEModal(ekspertise_id) {
      $('#form-tte-ekspertise').attr('action', '/radiologi/tte-ekspertise/'+ekspertise_id)
      $('#myModal').modal('show');
    }

    function prosesTTE() {
      $('input').prop('disabled', false)
      $('#form-tte-ekspertise').submit();
    }

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
      {{-- Passphrase Session --}}
      <script>
        let passphrase = {!! json_encode(session('passphrase')) !!};
        console.log(passphrase);
        if (!passphrase) {
            showModalPassphrase();
        }

        function showModalPassphrase() {
            $('#modalPassphrase').modal('show');
        }

        function closeModalPassphrase() {
            $('#modalPassphrase').modal('hide');
        }

        function handleUserRefuse() {
            $.ajax({
                url: '{{ url('/save_passphrase') }}',
                type: 'POST',
                data: {
                    save_passphrase : false,
                    _token : $('input[name="_token"]').val(),
                    _method : 'POST'
                },
                processing: true,
                success: function(data) {
                    if (data) {
                        closeModalPassphrase()
                    }
                }
            });
        }

        function handleUserSave() {
            $.ajax({
                url: '{{ url('/save_passphrase') }}',
                type: 'POST',
                data: {
                    save_passphrase : true,
                    passphrase : $('input[name="passphrase_session"]').val(),
                    _token : $('input[name="_token"]').val(),
                    _method : 'POST'
                },
                processing: true,
                success: function(data) {
                    if (data) {
                        closeModalPassphrase();
                        window.location.reload();
                    }
                }
            });
        }
    </script>
    {{-- End Passphrase Session --}}
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