@extends('master')
@section('header')
<style>
  #ekspertise{
    width: 100%;
  }
</style>
@endsection
@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h4>RADIOLOGI - GIGI<small>&nbsp;<a href="{{url('radiologi-gigi/terbilling')}}" class="btn btn-default" id="tambah">Kembali </a></small>
    </h4>
    <div class="box-body">
      <h4 class="text-center">Input Ekspertise</h4>
      <hr style="border-top: 1px solid red;" />
      {{-- <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <tr>
            <td>Nama</td>
            <td></td>
          </tr>
          <tr>
            <td>RM</td>
            <td>{{@$reg->pasien->no_rm}}</td>
          </tr>
          <tr>
            <td>Dokter</td>
            <td>{{baca_dokter(@$reg->dokter_id)}}</td>
          </tr>
          <tr>
            <td>Poli</td>
            <td>
              @php
              $histori = \App\HistorikunjunganIRJ::where('registrasi_id',@$reg->id)->orderBy('id','DESC')->first();
              @endphp
              @if ($histori)
              {{baca_poli(@$histori->poli_id)}}
              @else
              {{@$reg->poli->nama}}
              @endif
            </td>
          </tr>
        </table>
      </div> --}}
      <div class="row">
        <div class="col-md-12">
          <form method="POST" class="form-horizontal" id="formEkspertise">
            {{ csrf_field() }}
            <input type="hidden" name="registrasi_id" value="{{$reg->id}}">
            <input type="hidden" name="poli_id" value="{{poliRadiologiGigi()}}">
            {{-- <input type="hidden" name="ekspertise_id" value=""> --}}

            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tbody>
                  <tr>
                    <th>Nama Pasien </th>
                    <td class="nama">{{@$reg->pasien->nama}}</td>
                    <th>Jenis Kelamin </th>
                    <td class="jk" colspan="3">{{@$reg->pasien->kelamin}}</td>
                  </tr>
                  <tr>
                    <th>Umur </th>
                    <td class="umur">{{@$umur}}</td>
                    <th>No. RM </th>
                    <td class="no_rm" colspan="3">{{@$reg->pasien->no_rm}}</td>
                  </tr>
                  <tr>
                    <th>Pemeriksaan</th>
                    <td>
                      <ul>
                        @foreach($tindakan as $val)
                        <li>{{$val->namatarif}}</li>
                        @endforeach
                      </ul>
                      {{-- <ol class="pemeriksaan"></ol> --}}
                      {{-- <div id="tindakanPeriksa"> --}}
                        {{-- <select class="form-control" name="tindakan_id">
                          <option>Silahkan Pilih</option>
                        @foreach ($tindakan as $key => $val)
                          @php
                              $selected = $key == '0' ? 'selected' : '';
                          @endphp
                          <option data_tgl="{{$val->created_at}}" value="{{$val->id}}" {{$selected}}>{{$val->namatarif}}</option>    
                        @endforeach --}}

                      </select>
                      </div>
                    </td>
                    <th>Tanggal Pemeriksaan </th>
                    <td>
                      {!! Form::text('tglPeriksa', date('d-m-Y'), ['class' => 'form-control datepicker ', 'required' =>
                      'required']) !!}
                    </td>
                  </tr>
                  <tr>
                    <th>Dokter Radiologi</th>
                    <td>
                      <select name="dokter_id" class="form-control select2" style="width: 100%">
                        <option value="">-- Pilih --</option>
                        @foreach ($radiografer as $d)
                        <option value="{{ @$d->id }}" {{$d->id == $rad->dokter_radiologi ? 'selected' : ''}}>{{ @$d->nama }}</option>
                        @endforeach
                      </select>
                    </td>
                    <th>Dokter Pengirim</th>
                    <td>
                      <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                        <option value="">-- Pilih --</option>
                        @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                        {{-- @foreach (Modules\Pegawai\Entities\Pegawai::all() as $d) --}}
                        <option value="{{ @$d->id }}" {{$d->id == $reg->dokter_id ? 'selected' : ''}}>{{ @$d->nama }}</option>
                        @endforeach
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th>Diagnosa</th>
                    <td>
                      <div id="tindakanPeriksa">
                        <ul>
                          @foreach ($tindakan as $key => $val)
                            <li>{{ @$val->diagnosa }}</li>
                          @endforeach
                        </ul>
                      </div>
                    </td>
                    <th>Tanggal Ekspertise </th>
                    <td colspan="3">
                      {!! Form::text('tanggal_eksp', date('d-m-Y'), ['class' => 'form-control datepicker ', 'required' =>
                      'required']) !!}
                    </td>
                  </tr>
                  {{-- <tr>
                    <th>Klinis<br/>
                    <i style="font-weight: 400 !important"><small>(dari order radiologi)</small></i></th>
                    <td colspan="3">
                      <textarea name="klinis" class="form-control ckeditor">
                        @foreach($order as $o) {!!$o->pemeriksaan!!} @endforeach
                      </textarea>
                    </td>
                  </tr> --}}
                  <tr>
                    <th>Tanda Tangan Elektronik</th>
                    <td>
                        <button class="btn btn-success btn-sm" type="button" id="btn-proses-tte" onclick="btnprosestte()">Proses</button>
                        <button type="button" onclick="showTTEModal()" class="btn btn-success btn-flat" id="btn-tte" style="display: none;"><i class="fa fa-pencil"></i></button>
                        <span class="text-danger" id="info_penandatangan"></span>
                    </td>
                    <th>Keterangan pengambilan hasil</th>
                    <td style="max-width: 300px;">
                      @if ($val->catatan)
                        <li>{{ @$val->catatan }}</li>
                      @endif
                    </td>
                  </tr>
                  <tr>

                    {{-- Input hidden untuk tte --}}
                    <input type="hidden" name="nik_dokter" id="nik_dokter">
                    <input type="hidden" name="passphrase" id="passphrase">
                    <input type="hidden" name="proses_tte" id="input_hidden_proses_tte" value="">
                  <tr>

                    <th>Ekspertise</th>
                    <td colspan="3">
                      {{-- <textarea name="ekspertise" class="form-control wysiwyg"></textarea> --}}
                      <textarea name="ekspertise" id="ekspertise" cols="100" rows="20" class="form-control"></textarea>
                      {{-- <b style="color:red">*</b> Tekan Keyboard <i><b>Shift + Enter</b></i> untuk paragraf baru agar tidak terlalu renggang saat mengetik Ekspertise. --}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <button type="button" class="btn pull-right btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
            <button type="button" onclick="close_window()" class="btn btn-danger">Close/Tutup</button>
            <div class="btn-group">
              <button type="button" class="btn btn-warning">History Ekspertise </button>
              <button type="button" class="btn btn-lg btn-warning dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                @foreach (\App\RadiologiEkspertise::where('registrasi_id', @$reg->id)->get() as $p)
                  <li>
                    <a href="{{ url("radiologi-gigi/cetak-ekpertise/".@$p->id."/".@$reg->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal TTE --}}
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form id="form-update" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informasi Penandatangan</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
        <input type="hidden" name="nik_hidden" id="nik_hidden">
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Dokter:</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" name="dokter" id="dokter" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">NIK:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="nik" id="nik" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="passphrase" id="passphrase_modal" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="button-proses-tte" onclick="confirmTTE()">Selesai</button>
      </div>
    </div>
    </form>

  </div>
</div>

@stop
@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    {{-- @parent --}}
    <script type="text/javascript">
    $('.select2').select2()
      //CKEDITOR
    // CKEDITOR.replace( 'ekspertise', {
    //   height: 200,
    //   filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    //   filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    // });

    function close_window() {
      if (confirm("Yakin Akan Tutup Halaman Ekspertise")) {
        close();
      }
    }

    var response;

    function showTTEModal() {
      var dokter_id = $('select[name="dokter_id"]').val();
      $.ajax({
        url: '/radiologi/dokter/' + dokter_id,
        type: 'GET',
      }).done(function (resp) {
        if (resp != null) {
          if (resp.nik) {
            $('#nik_hidden').val(resp.nik);
            $('#dokter').val(resp.nama);
            $('#nik').val(resp.nik.substring(0, resp.nik.length -5) + "*****");
            $('#myModal').modal('show');
            $('#button-proses-tte').data("res", resp);
            response = resp;
          } else {
            alert('Dokter ' + resp.nama + ' tidak dapat melakukan TTE dikarenakan belum menginput NIK!')
          }
        } else {
          alert('gagal mengambil informasi dokter')
        }
      })
    }

    function confirmTTE() {
      if (confirm('Jika anda menggunakan pasprees orang lain,sepenuhnya menjadi tanggung jawab anda')) {
        $('#passphrase').val($('#passphrase_modal').val());
        $('#nik_dokter').val($('#nik_hidden').val());
        $('#myModal').modal('hide');
        $('#info_penandatangan').html(`${response.nama} (${response.nik.substring(0, response.nik.length - 5)} *****)`)
      }
    }

    function btnprosestte() {
      if (confirm('Yakin akan melakukan TTE?')) {
        $('#btn-proses-tte').hide();
        $('#btn-tte').show();
        $('#input_hidden_proses_tte').val('true');
      }
    }
    
    function saveEkpertise() {
      var token = $('input[name="_token"]').val();
      // var ekspertise = CKEDITOR.instances['ekspertise'].getData();
      var ekspertise = $('#ekspertise').val();
      var form_data = new FormData($("#formEkspertise")[0])
      form_data.append('ekspertise', ekspertise)

      if(ekspertise != ''){
        $.ajax({
          url: '/radiologi-gigi/ekspertise-baru',
          type: 'POST',
          dataType: 'json',
          data: form_data,
          processData: false,
          contentType: false,
          beforeSend: function () {
            $('.overlay').removeClass('hidden')
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          }
        })
        .done(function(resp) {
          if (resp.sukses == true) {
            $('input[name="ekspertise_id"]').val(resp.data.id)
            alert('Ekspertise berhasil disimpan.')
            window.open('/radiologi-gigi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id)
            // window.location.open = '/radiologi-gigi/cetak-ekpertise/'+resp.data.id+'/'+resp.data.registrasi_id
            close();
          } else {
            alert(resp.message);
          }
        });
      }else{
        alert('Ekspertise Tidak Boleh Kosong');
      }
    }
      
    </script>
@endsection