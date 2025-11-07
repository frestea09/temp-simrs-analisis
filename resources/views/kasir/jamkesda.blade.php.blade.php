@extends('master')
@section('header')
  <h1>Perawat Ambulance <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{--  <h4>Data Pasien Ambulance</h4>  --}}
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/rawat-inap/ambulance', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
            <span class="input-group-btn">
              <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">NOMOR RM</button>
            </span>
            {{-- {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!} --}}
            <select name="no_rm" class="form-control" id="selectRM" onchange="this.form.submit()">
            </select>
            <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama </th>
              <th>Bangsal</th>
              <th>Kelas</th>
              <th>DPJP Rawat Inap</th>
              <th>No. SEP</th>
              <th>Tgl Pulang</th>
              <th>Input</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->no_rm }}</td>
              <td>{{ strtoupper($d->nama) }}</td>
              <td>{{ baca_kelompok($d->kelompokkelas_id) }}</td>
              <td>{{ strtoupper(baca_kelas($d->kelas_id)) }}</td>
              <td>{{ baca_dokter($d->dokter_id) }}</td>
              <td></td>
              <td></td>
              <td>
                <button type="button" onclick="addForm({{ $d->registrasi_id }})" class="btn btn-flat btn-primary"><i class="fa fa-ambulance"></i></button>
              </td>

            @endforeach

          </tbody>
        </table>
      </div>

    </div>
  </div>

  <div class="modal fade" id="ambulanModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          {!! Form::open(['method' => 'POST', 'id' => 'formAmbulance', 'class'=>'form-horizontal']) !!}
              <input type="hidden" name="registrasi_id" value="">
              <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                <label for="tarif_id" class="col-sm-3 control-label">Tarif Ambulan</label>
                <div class="col-sm-9">
                  <select name="tarif_id" class="form-control select2" style="width: 100%">
                    @foreach (\Modules\Tarif\Entities\Tarif::where('jenis', 'TI')->get() as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }} | {{ number_format($d->total) }}</option>
                    @endforeach
                  </select>
                </div>
                <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
              </div>
              <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                <label for="tanggal" class="col-sm-3 control-label">Tanggal</label>
                <div class="col-sm-4">
                  <input type="text" name="tanggal" class="form-control datepicker">
                </div>
                <small class="text-danger">{{ $errors->first('tanggal') }}</small>
              </div>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="save()">Simpan</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
  <script type="text/javascript">

    $('#selectRM').select2({
      placeholder: "Pilih No Rm...",
      ajax: {
          url: '/pasien/master-pasien/',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })


function addForm(registrasi_id){
  $('#ambulanModal').modal({
    backdrop: 'static',
    keyboard: false
  })
  $('.modal-title').text('Input Perawat Ambulance')
  $('.select2').select2()
  $('input[name="registrasi_id"]').val(registrasi_id)
}

function save(){
  var data = $('#formAmbulance').serialize()
  $.post('/rawat-inap/save-ambulance', data, function(resp){
    if(resp.sukses == true){
      $('#formAmbulance')[0].reset()
      $('#ambulanModal').modal('hide')
      alert('Perawat Ambulance berhasil diinput')
    }
  })
}


  </script>

@endsection
