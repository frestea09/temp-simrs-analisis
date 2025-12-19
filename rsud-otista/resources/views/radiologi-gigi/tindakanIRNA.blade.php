@extends('master')

@section('header')
<h1>Billing System Radiologi - Rawat Inap</h1>
@endsection

@section('content')
<link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">

<div class="box box-primary">
  <div class="box-header with-border">
    <h4 class="box-title">
      Periode Tanggal &nbsp;
    </h4>
  </div>
  <div class="box-body">

    {!! Form::open(['method' => 'POST', 'url' => 'radiologi-gigi/tindakan-irna', 'class'=>'form-hosizontal']) !!}
    <div class="row">
      <div class="col-md-6">
        <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
          <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
          </span>
          {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' =>
          'required']) !!}
          <small class="text-danger">{{ $errors->first('tga') }}</small>
        </div>
      </div>

      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Sampai Tanggal</button>
          </span>
          {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' =>
          'required', 'onchange'=>'this.form.submit()']) !!}
        </div>
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
            <th rowspan="2">Nama Pasien</th>
            <th rowspan="2">No. RM</th>
            <th rowspan="2">Dokter</th>
            <th rowspan="2">Cara Bayar</th>
            <th rowspan="2">Proses</th>
            <th rowspan="2">Ekpertise</th>
            <th rowspan="2">Billing</th>
            <th colspan="2" class="text-center">Cetak</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Note</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Catatan</th>
          </tr>
          <tr>
            <th>Bill.</th>
            <th>Eksp.</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($registrasi as $key => $d)
          @if (Auth::user()->role()->first()->name == 'radiologi')
          @if ( cek_tindakan($d->id, 18) > 0 )
          <tr class="success">
            @else
          <tr>
            @endif
            @endif

            <td class="text-center">{{ $no++ }}</td>
             {{-- <td id="notiforder"></td> --}}
              @if (!count($d->ekspertise_gigi))
                <td class="blink_me"> <b>Baru</b> </td>
              @else
                <td><b style="color:red">Selesai</b></td>
              @endif
            <td>{{ @$d->pasien->nama }}</td>
            <td>{{ @$d->pasien->no_rm }}</td>
            <td>{{ baca_dokter($d->dokter_id) }}</td>
            <td>{{ baca_carabayar($d->bayar) }}
              @if (!empty($d->tipe_jkn))
              - {{ $d->tipe_jkn }}
              @endif
            </td>
            <td class="text-center">
              <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="new_ekspertise({{ $d->id }})"><i class="fa fa-plus"></i></button>
            </td>
            <td class="text-center">
              {{-- <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="ekspertise({{ $d->id }})"><i
                class="fa fa-edit"></i></button> --}}
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-danger">Edit</button>
                <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                  @forelse($d->ekspertise_gigi as $val)
                  <li>
                    <a href="javascript:void(0)" onclick="ekspertise({{ $d->id }},{{ $val->id }})"class="btn btn-flat btn-sm">{{ $val->uuid }} ({{ $val->no_dokument }})</a>
                  </li>
                  @empty
                  <li>
                    <a href="javascript:void(0)">Belum Ada</a>
                  </li>
                  @endforelse
                </ul>
              </div>
            </td>
            <td class="text-center">
                    <a href="{{ url('radiologi-gigi/entry-tindakan-irna/'. $d->id.'/'.$d->pasien_id) }}" target="_blank"
            class="btn btn-danger btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
            </td>
            {{-- <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="pemeriksaan_tindakan({{ $d->id }})"><i
              class="fa fa-edit"></i></button>
            </td> --}}
            <td class="text-center">
              @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->count() >
              0)
              <a href="{{ url('radiologi-gigi/cetakRincianRad/irna/'.$d->id) }}" target="_blank"
                class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
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
                      $fol = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->first();
                  @endphp
                  @forelse($d->ekspertise_gigi as $val)
                  <li>
                    <a target="_blank" href="{{ url("radiologi/cetak-ekpertise/".$val->id."/".$d->id."/".$fol->id) }}" class="btn btn-flat btn-sm">{{ $val->uuid }}</a>
                  </li>
                  @empty
                  <li>
                    <a href="javascript:void(0)">Belum Ada</a>
                  </li>
                  @endforelse
                </ul>
              </div>
              @endif
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$reg->id }}" onclick="showNote({{ @$d->id }})"><i class="fa fa-book"></i></button>
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i
                  class="fa fa-book"></i></button>
            </td>
          </tr>
          @endforeach
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
          <input type="hidden" name="poli_id" value="{{poliRadiologiGigi()}}">
          <input type="hidden" name="ekspertise_id" value="">

          <div class="table-responsive">
            <table class="table table-condensed table-bordered">
              <tbody>
                <tr>
                  <th>Nama Pasien </th>
                  <td class="nama"></td>
                  <th>Jenis Kelamin </th>
                  <td class="jk"></td>
                </tr>
                <tr>
                  <th>Umur </th>
                  <td class="umur"></td>
                  <th>No. RM </th>
                  <td class="no_rm"></td>
                </tr>
                <tr>
                  <th>Pemeriksaan</th>
                  <td>
                    {{-- <ol class="pemeriksaan"></ol> --}}
                    <div id="tindakanPeriksa"></div>
                  </td>
                  <th>Tanggal Pemeriksaan </th>
                  <td>
                    {{-- <ol class="tgl_priksa"></ol> --}}
                    {!! Form::text('tglPeriksa', null, ['class' => 'form-control datepicker ', 'required' => 'required']) !!}
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
                $data['perawats_poli'] = Modules\Poli\Entities\Poli::where('id', 38)->pluck('perawat_id');
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
                  <th></th>
                  {{-- <th>Klinis</th>
                  <td>
                    <input type="text" name="klinis" class="form-control">
                  </td> --}}
                  <th>Tanggal Ekspertise </th>
                  <td colspan="3">
                    {!! Form::text('tanggal_eksp', null, ['class' => 'form-control datepicker ', 'required' => 'required']) !!}
                  </td>
                </tr>
                {{-- <tr>
                  <th>Klinis </th>
                  <td>
                    <input type="text" name="klinis" class="form-control">
                  </td>
                </tr> --}}
                <tr>
                  <th>Ekspertise</th>
                  <td colspan="3">
                    <textarea name="ekspertise" class="form-control wysiwyg"></textarea>
                    <b style="color:red">*</b> Tekan Keyboard <i><b>Shift + Enter</b></i> untuk paragraf baru agar tidak terlalu renggang saat mengetik Ekspertise.
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
<div class="modal fade" id="pemeriksaanModels" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
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
<div class="modal fade" id="pemeriksaanModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="post" id="formTindakan">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div id="detailTindakan">
          </div>
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
  //CKEDITOR
  $('.select2').select2();

  CKEDITOR.replace('pemeriksaan', {
    height: 200,
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
  });

  function coba(registrasi_id) {
    $('#pemeriksaanModel').modal({
      backdrop: 'static',
      keyboard: false,
    })
    $('.modal-title').text('Catataan Order Radiologi')
    $("#form")[0].reset()
    CKEDITOR.instances['pemeriksaan'].setData('')
    $.ajax({
        url: '/radiologi-gigi/catatan-pasien/' + registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function (data) {
        $('input[name="waktu"]').val(data.created_at)
        CKEDITOR.instances['pemeriksaan'].setData(data.pemeriksaan)
      })
      .fail(function () {

      });
  }

  CKEDITOR.replace('ekspertise', {
    height: 200,
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
  });

  function new_ekspertise(id) {
    $('#ekspertiseModal').modal({
      backdrop: 'static',
      keyboard: false,
    })
    $('.modal-title').text('Tambah Ekpertise Irna')
    $("#formEkspertise")[0].reset()
    $('input[name="ekspertise_id"]').val('');
    CKEDITOR.instances['ekspertise'].setData('');
    $('#tglPeriksa').empty();
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
        url: '/radiologi-gigi/irna/'+id,
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
        CKEDITOR.instances['ekspertise'].setData()
        $('input[name="registrasi_id"]').val(data.reg.id)
        $('input[name="tanggal_eksp"]').val(data.ep.tanggal_eksp)
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
      keyboard: false,
    })
    $('.modal-title').text('Input Ekpertise')
    $("#formEkspertise")[0].reset()
    CKEDITOR.instances['ekspertise'].setData('')


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
        url: '/radiologi-gigi/ekspertise/'+reg_id+'/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function (data) {
      $('.nama').text(data.reg.pasien.nama)
      $('.no_rm').text(data.reg.pasien.no_rm)
      $('.umur').text(data.umur)
      $('.jk').text(data.reg.pasien.kelamin)
      $('input[name="tglPeriksa"]').val(data.ep.tglPeriksa)
      $('input[name="registrasi_id"]').val(data.reg.id)
      // $('input[name="klinis"]').val(data.ep.klinis)
      $('input[name="klinis"]').val(data.ep.klinis)
      $('input[name="tanggal_eksp"]').val(data.tanggal)
      $('select[name="dokter_id"]').val(data.ep.dokter_id).trigger('change')
      $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')
      // $('.pemeriksaan').empty()
     
      $('#tglPeriksa').html(tglPeriksa);
      if (data.ep != '') {
        $('input[name="ekspertise_id"]').val(data.ep.id)
        $('input[name="no_dokument"]').val(data.ep.no_dokument)
        CKEDITOR.instances['ekspertise'].setData(data.ep.ekspertise)
      }
    })
      .fail(function () {

      });
  }

  $(document).on('change','select[name="tindakan_id"]',function(){
    let tgl = $(this).find(':selected').attr('data_tgl');
    $('#tglPeriksa').html(tgl);
  })

  function saveEkpertise() {
    var token = $('input[name="_token"]').val();
    var ekspertise = CKEDITOR.instances['ekspertise'].getData();
    var form_data = new FormData($("#formEkspertise")[0])
    form_data.append('ekspertise', ekspertise)

    $.ajax({
        url: '/radiologi-gigi/ekspertise-baru',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function (resp) {
        if (resp.sukses == true) {
          $('input[name="ekspertise_id"]').val(resp.data.id)
          alert('Ekspertise berhasil disimpan.')
          // location.reload();
          window.open('/radiologi-gigi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id)
        }
      });
  }

  function pemeriksaan_tindakan(registrasi_id) {
    $('#pemeriksaanModal').modal('show');
    $('.modal-title').text('Radiologi Tindakan');
    $('#detailTindakan').load('/radiologi-gigi/tambah-ekspertise/' + registrasi_id);
  }
     
function showNote(id) {

$('#pemeriksaanModels').modal()
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