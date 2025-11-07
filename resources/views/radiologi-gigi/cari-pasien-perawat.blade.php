@extends('master')
@section('header')
  <h1>Radiologi - Cari Pasien Non Terbiling <small></small></h1>
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
    {!! Form::open(['method' => 'POST', 'url' => 'radiologi-gigi/cari-pasien-perawat', 'class'=>'form-horizontal']) !!}
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
	  <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
        <thead>
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Status</th>
            <th rowspan="2">No. RM</th>
            <th rowspan="2">Nama Pasien</th>
            <th rowspan="2">Jenis Pasien</th>
            <th rowspan="2">Tanggal Registrasi</th>
            <th rowspan="2">Dokter</th>
            <th rowspan="2">Poli Tujuan</th>
            <th rowspan="2">Cara Bayar</th>
            <th rowspan="2">Proses</th>
            <th rowspan="2">Ekpertise</th>
            <th rowspan="2">Billing</th>
            <th colspan="2" class="text-center">Cetak</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Note</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Note Poli</th>
          </tr>
          <tr>
            <th>Bill.</th>
            <th>Eksp.</th>
          </tr>
        </thead>
        <tbody>
          @isset($registrasi)
          @foreach ($registrasi as $key => $d)
              @php
                $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
              @endphp
              <td class="text-center">{{ $no++ }}</td>
              @if (!count($d->ekspertise))
                <td class="blink_me"> <b>Baru</b> </td>
              @else
                <td><b style="color:red">Selesai</b></td>
              @endif
              <td>{{ $pasien ? $d->pasien->no_rm : '' }}</td>
              <td>{{ $pasien ? $d->pasien->nama : '' }}</td>
                  <td>{{ cek_jenis_reg(@$d->status_reg) }}</td>
              <td>{{ date('d-m-Y',strtotime(@$d->created_at)) }}</td>
              <td>{{ baca_dokter($d->dokter_id) }}</td>
              <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
              <td>{{ baca_carabayar($d->bayar) }}
                @if (!empty($d->tipe_jkn))
                  - {{ $d->tipe_jkn }}
                @endif
              </td>
              <td class="text-center">
                <a href="{{url('/radiologi-gigi/create-ekspertise/'.$d->id)}}" target="_blank" class="btn btn-primary btn-sm btn-flat" onclick="new_ekspertise({{ $d->id }})"><i class="fa fa-plus"></i></a>
              </td>
              <td class="text-center">
                {{-- <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="ekspertise({{ $d->id }})"><i class="fa fa-pencil"></i></button> --}}
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-danger">Edit</button>
                  <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                    @forelse($d->ekspertise as $val)
                    <li>
                      <a href="javascript:void(0)" onclick="ekspertise({{ $d->id }},{{ $val->id }})"class="btn btn-flat btn-sm">{{ $val->uuid }} ({{ $val->no_dokument }})</a>
                    </li>
                    @empty
                    <li>
                      <a href="javascript:void(0)">Belum Ada.</a>
                    </li>
                    @endforelse
                  </ul>
                </div>
              </td>
               
              <td class="text-center">
                
                @if (cek_jenis_reg(@$d->status_reg) == 'Rawat Inap')
                <a href="{{ url('radiologi-gigi/entry-tindakan-irna/'. @$d->id.'/'.@$d->pasien_id) }}" target="_blank" class="btn btn-danger btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                @elseif(cek_jenis_reg(@$d->status_reg) == 'Rawat Jalan')  
                <a href="{{ url('radiologi-gigi/entry-tindakan-irj/'. @$d->id.'/'.@$d->pasien_id) }}" target="_blank" class="btn btn-danger btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                @else
                <a href="{{ url('radiologi-gigi/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" target="_blank" class="btn btn-danger btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                @endif
            
              </td>
              {{-- <td class="text-center">
              </td> --}}
              <td class="text-center">
                @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->count() > 0)
                 @if (cek_jenis_reg(@$d->status_reg) == 'Rawat Inap')
                  <a href="{{ url('radiologi-gigi/cetakRincianRad/irna/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>   
                  @elseif(cek_jenis_reg(@$d->status_reg) == 'Rawat Jalan')  
                  <a href="{{ url('radiologi-gigi/cetakRincianRad/irj/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                  @else
                  <a href="{{ url('radiologi-gigi/cetakRincianRad/ird/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                  @endif
                  @endif
              </td>
              {{-- cetak ekspertise --}}
              <td class="text-center">
                @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->count() > 0)
                <div class="btn-group" style="min-width:0px !important">
                  {{-- <button type="button" class="btn btn-sm btn-success"><i class="fa fa-print"></i></button> --}}
                  <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-print"></i>&nbsp;
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                    @php
                            $fol = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->first()
                    @endphp
                    @forelse($d->ekspertise as $val)
                        <li>
                          <a target="_blank" href="{{ url("radiologi-gigi/cetak-ekpertise/".$val->id."/".$d->id) }}" class="btn btn-flat btn-sm">{{ $val->uuid }}</a>
                        </li>
                    @empty
                    <li>
                      <a href="javascript:void(0)">Belum Ada..</a>
                    </li>
                    @endforelse
                  </ul>
                </div>
                @endif
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->id }}" onclick="showNote({{ @$d->id }})"><i class="fa fa-book"></i></button>
              </td>
              <td>                   
                <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
              </td>
            </tr>
          @endforeach
          @endisset
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="ekspertiseModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-horizontal" id="formEkspertise">
          {{ csrf_field() }}
          <input type="hidden" name="registrasi_id" value="">
          <input type="hidden" name="ekspertise_id" value="">
          <input type="hidden" name="poli_id" value="{{poliRadiologi()}}">

        <div class="table-responsive">
          <table class="table table-condensed table-bordered">
            <tbody>
              <tr>
                <th>Nama Pasien </th> <td class="nama"></td>
                <th>Jenis Kelamin </th><td class="jk" colspan="3"></td>
              </tr>
              <tr>
                <th>Umur </th><td class="umur"></td>
                <th>No. RM </th><td class="no_rm" colspan="3"></td>
              </tr>
              <tr>
                <th>Pemeriksaan</th>
                <td>
                  {{-- <ol class="pemeriksaan"></ol>   --}}
                  <div id="tindakanPeriksa"></div>
                </td>
                <th>Tanggal Pemeriksaan </th>
                <td>
                  {{-- <div id="tglPeriksa"></div> --}}
                  {!! Form::text('tglPeriksa', null, ['class' => 'form-control datepicker ', 'placeholder'=>'Jika kosong, otomatis tgl hari ini','required' => 'required']) !!}
                </td>
              </tr>



              <tr>
                <th>Diagnosa</th>
                <td>
                  <div id="diagnosa"></div>
                  
                  
                </td>
                <th>No Foto </th>
                <td>
                    <div id="no_foto"></div>
                  
                </td>
              </tr>










                  
          @php

          $data['dokters_poli'] = Modules\Poli\Entities\Poli::where('id', 38)->pluck('dokter_id');
          $data['perawats_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck('perawat_id');
          $dokter_pengirim =   Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get();
          $dokter =  (explode(",", $data['dokters_poli'][0]));

        @endphp



          <tr>
            <th>Dokter</th>
              <td>
                <select name="dokter_id" class="form-control select2" style="width: 100%">
                  @foreach ($dokter as $d)
                      <option value="{{ $d }}">{{ baca_dokter($d) }}</option>
                  @endforeach
                </select>
              </td>
            <th>Dokter Pengirim</th>
            <td>
                <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                  @foreach ($dokter_pengirim as $d)
                      <option value="{{ $d->id }}">{{ baca_dokter($d->id) }}</option>
                  @endforeach
                </select>
               
            </td>
          </tr>
              <tr>
                <th>&nbsp;</th>
                <td>  
                  {{-- <input type="text" name="klinis" class="form-control"> --}}
                </td>
                <th>Tanggal Ekspertise </th>
                <td colspan="">
                  {!! Form::text('tanggal_eksp', null, ['class' => 'form-control datepicker ', 'placeholder'=>'Jika kosong, otomatis tgl hari ini','required' => 'required']) !!}
                </td>
              </tr>
              <tr>
                <th>Ekspertise</th>
                <td colspan="3" rowspan="6">
                  <textarea name="ekspertise"  class="form-control ekspertise" style="height: 500">  </textarea>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
      </div>
    </div>
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
<div class="modal fade" id="pemeriksaanModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
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
                  <th>Tanggal Order :<input class="form-control" name="waktu_order" redonly> </th> 
                </tr>
                <tr>
                  <td>
                    <textarea name="pemeriksaan" id="pemeriksaan" class="form-control wysiwyg"></textarea>
                  </td>
                </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


@stop

@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>


<script type="text/javascript">
$(document).ready(function() {
setInterval(function () {
  $('#notiforder').load("{{ route('radiologi.notif') }}");
},9000); //normal 13000
});
</script>

<script type="text/javascript">
$('.select2').select2();



        function showNote(id) {

    $('#pemeriksaanModel').modal()
    $('.modal-title').text('Catataan Order Radiologi')
    $("#form")[0].reset()
    $.ajax({
      url: '/radiologi/showNoteReg/'+id,
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
      url: '/radiologi/updateNoteReg/'+id_reg,
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

//CKEDITOR
// CKEDITOR.replace( 'ekspertise', {
//   height: 200,
//   filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
//   filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
// });

function new_ekspertise(id) {
  $('#ekspertiseModal').modal({
    backdrop: 'static',
    keyboard: false,
  })
  $('.modal-title').text('Tambah Ekpertise Rajal')
  $("#formEkspertise")[0].reset()
  $('input[name="ekspertise_id"]').val('');
  $('input[name="ekspertise"]').val();
  $('#tglPeriksa').empty();
  $.ajax({
      url: '/radiologi-gigi/dokter/'+id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#dokter').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });
  $.ajax({
      url: '/radiologi-gigi/tindakan/'+id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#tindakanPeriksa').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });
  $.ajax({
      url: '/radiologi-gigi/diagnosa/'+id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#diagnosa').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });
  $.ajax({
      url: '/radiologi-gigi/no_foto/'+id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#no_foto').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });


$.ajax({
    url: '/radiologi-gigi/ekspertise/'+id,
    type: 'GET',
    dataType: 'json',
  })
  .done(function (data) {
    console.log(data)
    $('.nama').text(data.reg.pasien.nama)
    $('.no_rm').text(data.reg.pasien.no_rm)
    $('.umur').text(data.umur)
    $('.jk').text(data.reg.pasien.kelamin)
    $('input[name="tglPeriksa"]').val(data.ep.tglPeriksa)
    $('input[name="klinis"]').val()
    $('input[name="ekspertise"]').val()
    $('input[name="registrasi_id"]').val(data.reg.id)
    $('input[name="tanggal_eksp"]').val(data.tanggal)
    if(data.rad){
      $('select[name="dokter_id"]').val(data.rad.dokter_pelaksana).trigger('change')
    }
    $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')
    // $('#tindakanPeriksa').empty();
    // $('#tglPeriksa').empty();
    // $('.pemeriksaan').empty()
    // $('.tgl_priksa').empty()
  })
  .fail(function () {

  });
}

let optionPeriksa = '';
let tglPeriksa = '';

function ekspertise(reg_id,id) {
  $('#ekspertiseModal').modal({
    backdrop: 'static',
    keyboard : false,
  })
  $('.modal-title').text('Input Ekpertise')
  $("#formEkspertise")[0].reset()
 

  $.ajax({
      url: '/radiologi-gigi/tindakan/'+reg_id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#tindakanPeriksa').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });
  $.ajax({
      url: '/radiologi-gigi/diagnosa/'+reg_id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#diagnosa').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });
  $.ajax({
      url: '/radiologi-gigi/no_foto/'+reg_id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#no_foto').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });


  $.ajax({
      url: '/radiologi-gigi/dokter/'+reg_id,
      type: 'GET',
      dataType: 'html',
    })
    .done(function (res) {
       console.log(res)
      $('#dokter').html(res);
      //$('#registrasi_id').html(res);

    })
    .fail(function () {

  });


  $.ajax({
    url: '/radiologi/ekspertise/'+reg_id+'/'+id,
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    // alert(data)
  $('.nama').text(data.reg.pasien.nama)
  $('.no_rm').text(data.reg.pasien.no_rm)
  $('.umur').text(data.umur)
  $('.jk').text(data.reg.pasien.kelamin)
  $('input[name="tglPeriksa"]').val(data.ep.tglPeriksa)
  $('input[name="registrasi_id"]').val(data.reg.id)
  $('.ekspertise').val(data.ep.ekspertise)
  $('input[name="klinis"]').val(data.ep.klinis)
  $('input[name="tanggal_eksp"]').val(data.tanggal)
  $('select[name="dokter_id"]').val(data.ep.dokter_id).trigger('change')
  $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')
  $('#tglPeriksa').html(tglPeriksa);
  if (data.ep != '') {
    $('input[name="ekspertise_id"]').val(data.ep.id)
    $('input[name="no_dokument"]').val(data.ep.no_dokument)
    $('input[name="ekspertise"]').val()
  }
})
  .fail(function() {

  });
}

$(document).on('change','select[name="tindakan_id"]',function(){
  let tgl = $(this).find(':selected').attr('data_tgl');
  $('#tglPeriksa').html(tgl);
})

function coba(registrasi_id) {
  $('#pemeriksaanModal').modal({
    backdrop: 'static',
    keyboard : false,
  })
  $('.modal-title').text('Catataan Order Radiologi')
  $("#form")[0].reset()

  CKEDITOR.replace( 'pemeriksaan', {
  height: 200,
  filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
  filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
  });

  $.ajax({
    url: '/radiologi-gigi/catatan-pasien/'+registrasi_id,
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    $('input[name="waktu_order"]').val(data.created_at);
    $('#pemeriksaan').val(data.pemeriksaan);
  })
  .fail(function() {
    
  });
}

function saveEkpertise() {
  var token = $('input[name="_token"]').val();
  var ekspertise =  $('input[name="ekspertise"]').val()
  var form_data = new FormData($("#formEkspertise")[0])


  $.ajax({
    url: '/radiologi-gigi/ekspertise-baru',
    type: 'POST',
    dataType: 'json',
    data: form_data,
    async: false,
    processData: false,
    contentType: false,
  })
  .done(function(resp) {
    if (resp.sukses == true) {
      $('input[name="ekspertise_id"]').val(resp.data.id)
      alert('Ekspertise RAJAL berhasil disimpan.')
      // location.reload();
      window.open('/radiologi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id)
    }else{
      return alert(resp.data)
    }

  });
}

function pemeriksaan_tindakan(registrasi_id) {
  $('#pemeriksaanModal').modal('show');
  $('.modal-title').text('Radiologi Tindakan');
  $('#detailTindakan').load('/radiologi/tambah-ekspertise/'+registrasi_id);
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