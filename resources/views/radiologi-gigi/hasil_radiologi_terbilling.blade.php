@extends('master')
@section('header')
  <h1>Radiologi - Hasil Radiologi Gigi<small></small></h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		{{-- {!! Form::open(['method' => 'POST', 'url' => 'radiologi-gigi/hasil-radiologi', 'class'=>'form-hosizontal']) !!}
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
    {!! Form::open(['method' => 'POST', 'url' => 'radiologi-gigi/terbilling', 'class'=>'form-horizontal']) !!}
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
              <th>No RM</th>
              <th>Cara Bayar</th>
              <th>Klinik / Ruangan</th>
              <th>Layanan</th>
              <th>Registrasi</th>
              <th>Cetak</th>
              <th>Edit</th>
              <th class="text-center" scope="col">Billing</th>
              <th class="text-center" scope="col">Ekspertise</th>
              <th>Note</th>
              <th>SEP</th>
            </tr>
          </thead>
          <tbody>
            @isset($radiologi)
              @foreach ($radiologi as $d)
                  @php
                      // $reg = \Modules\Registrasi\Entities\Registrasi::find($d->id);
                      $reg = $d->registrasi
                      // @$klinis = @\App\RadiologiEkspertise::where('registrasi_id',$reg->id)->first()->klinis;
                  @endphp
                  <tr>
                    <td>{{ $no++  }}</td>
                    @if (\App\RadiologiEkspertise::where('registrasi_id', $d->id)->first() == null)
                    <td class="blink_me"> <b>Baru</b> </td>
                    @else
                      <td><b style="color:red">Selesai</b></td>
                    @endif
                    <td>{{ baca_pasien($reg->pasien_id) }}</td>
                    <td>{{ baca_norm($reg->pasien_id) }}</td>
                    <td>{{ baca_carabayar($reg->bayar) }}</td>
                    <td>{{ baca_poli($reg->poli_id) }}</td>
                    <td>{{ cek_jenis_reg($reg->status_reg) }}</td>
                    {{-- <td>{!! @$klinis !!}</td> --}}
                    {{-- <td>{{ $d->no_dokument }}</td>
                    <td>{!! substr($d->ekspertise,0,50) !!}</td> --}}
                    <td>{{ $reg->created_at->format('d-m-Y H:i:s') }}</td>
                    <td> 
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                          <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach (\App\RadiologiEkspertise::where('registrasi_id', $d->id)->get() as $p)
                              <li>
                                <a href="{{ url("radiologi-gigi/cetak-ekpertise/".$p->id."/".$d->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
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
                          @foreach (\App\RadiologiEkspertise::where('registrasi_id', $d->id)->get() as $p)
                            <li>
                              <a href="{{ url("radiologi-gigi/edit-ekpertise/".$p->id."/".$d->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-edit"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                  </td>
                  <td>
                    <a class="btn  btn-flat btn-warning btn-xs" href="{{url('/radiologi-gigi/view-rad/'.$d->id)}}">Lihat</a>
                    @if (cek_jenis_reg($reg->status_reg) == 'Rawat Inap')
                      <a href="{{ url('radiologi-gigi/entry-tindakan-irna/'. @$d->id.'/'.@$reg->pasien_id) }}" class="btn btn-primary btn-sm btn-flat">Tambah</a>
                      @elseif(cek_jenis_reg($reg->status_reg) == 'Rawat Jalan')  
                      <a href="{{ url('radiologi-gigi/entry-tindakan-irj/'. @$d->id.'/'.@$reg->pasien_id) }}" class="btn btn-primary btn-sm btn-flat">Tambah</a>
                      @else
                      <a href="{{ url('radiologi-gigi/insert-kunjungan/'. @$d->id.'/'.@$reg->pasien_id) }}" class="btn btn-primary btn-sm btn-flat">Tambah</a>
                    @endif
                    {{-- <a class="btn btn-primary btn-xs" href="{{url('/radiologi-gigi/view-rad/'.$d->id)}}">Tambah</a> --}}
                  </td>
                  <td>
                    <a class="btn btn-success btn-xs" target="_blank" href="{{url('/radiologi-gigi/create-ekspertise/'.$d->id)}}">Proses</a>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ $reg->id }}" onclick="showNote({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                  <td>
                    @if (!empty($reg->no_sep))
                      <a href="{{ url('cetak-sep/'.$reg->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                    @endif
                  </td>
                  </tr>
              @endforeach
            @endisset
          </tbody>
        </table>
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

    
    function showNote(id) {

      $('#pemeriksaanModel').modal()
      $('.modal-title').text('Catataan Order Radiologi')
      $("#form")[0].reset()
      $.ajax({
        url: '/radiologi-gigi/showNote/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="id_reg"]').val(data.id)
        $('input[name="tgl_order"]').val(data.tgl_order)
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
          url: '/radiologi-gigi/updateNote/'+id_reg,
          type: 'POST',
          dataType: 'json',
          data: {
            catatan: $('input[name="catatan"]').val(),
            tgl_order: $('input[name="tgl_order"]').val()
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
@endsection