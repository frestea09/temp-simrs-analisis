@extends('master')

@section('header')
  <h1>Pemeriksaan Laboratorium</h1>
@endsection

@section('content')
@php
    $jambuka = jamLaporan('tte_lab');
@endphp
<div class="box box-primary">
    <div class="overlay hidden">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
    <div class="box-header with-border">
      <h4 class="box-title">
        Periode Tanggal &nbsp;
      </h4>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlab', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Dari</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Dokter</button>
            </span>
            <select name="dokter_id" class="select2" style="width: 100%" onchange="this.form.submit()">
              <option value="">Semua</option>
              @foreach ($dokter as $d)
                <option value="{{$d->id}}" {{$dokter_id == $d->id ? "selected" : ""}}>{{$d->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">TTE</button>
            </span>
            <select name="tte" class="select2" style="width: 100%" onchange="this.form.submit()">
              <option value="">Semua</option>
              <option value="Y">Sudah</option>
              <option value="N">Belum</option>
              
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group">
              <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Dokter Lab</button>
              </span>
              <select name="dokterlab_id" class="form-control select2" style="width: 100%;" onchange="this.form.submit()">
                  <option value="">Semua</option>
                  @foreach ($dokter as $dokter)
                      @if (in_array($dokter->id, [868, 851, 17]))
                          <option value="{{ $dokter->id }}" {{ isset($dokterlab_id) && $dokterlab_id == $dokter->id ? 'selected' : '' }}>
                              {{ $dokter->nama }}
                          </option>
                      @endif
                  @endforeach
              </select>
          </div>
        </div>      

        </div>
      {!! Form::close() !!}
      <hr>
      {{-- =================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>No. Reg</th>
              <th>Dokter</th>
              <th>Dokter Lab</th>
              <th>Poli</th>
              <th>Tanggal Registrasi</th>
              <th>Pemeriksaan</th>
              <th>Cara Bayar</th>
              @if ($jambuka)
              <th>LIS</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach ($today as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ !empty($d->hasillab->pasien) ? @$d->hasillab->pasien->nama : '' }}</td>
                <td>{{ !empty($d->hasillab->pasien) ? @$d->hasillab->pasien->no_rm : '' }}</td>
                <td>{{ !empty($d->registrasi) ? @$d->registrasi->reg_id : '' }}</td>
                <td>{{ !empty($d->registrasi) ? baca_dokter(@$d->registrasi->dokter_id) : '' }}</td>
                {{-- <td>{{ !empty($d->registrasi) ? baca_dokter(@$d->folio->dokter_lab) : '' }}</td> --}}
                <td>
                  @if ($d->folios->isNotEmpty())
                      {{ baca_dokter($d->folios->first()->dokter_pelaksana) }}
                  @else
                      <span>-</span>
                  @endif
                </td>              
                <td>{{ !empty($d->registrasi) ? baca_poli(@$d->registrasi->poli_id) : '' }}</td>
                <td>{{ date('d-m-Y',  strtotime(@$d->registrasi->created_at))}}</td>
                <td>
                  <ul style="padding-left: 1.5rem;">
                    @foreach ($d->folios as $fol)
                      <li>{{$fol->namatarif}}</li>
                    @endforeach
                  </ul>
                </td>
                <td>{{ !empty($d->registrasi) ? baca_carabayar(@$d->registrasi->bayar) : '' }}</td>

                @if ($jambuka)
                  <td style="width: 200px">
                    @if (!empty($d->hasillab))
                      @if (!empty(json_decode($d->hasillab->tte)->base64_signed_file))
                        <div class="btn-group">
                          <a target="_blank" href="{{url('cetak-lis-pdf/'.$d->hasillab->no_lab.'/'.$d->hasillab->registrasi_id)}}" class="btn btn-sm btn-primary">{{$d->hasillab->no_lab}}</a>
                          <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-pencil" role="menu" style="">
                              <button data-url="{{url('cetak-lis-pdf/'.$d->hasillab->no_lab.'/'.$d->hasillab->registrasi_id)}}" class="btn btn-warning btn-flat btn-xs tte-button"><i class="fa fa-pencil"></i> Tanda tangan elektronik ulang</button>
                          </ul>
                        </div>
                      @else
                        <div class="btn-group">
                          <a target="_blank" href="{{url('cetak-lis-pdf/'.$d->hasillab->no_lab.'/'.$d->hasillab->registrasi_id)}}" class="btn btn-sm btn-success">{{$d->hasillab->no_lab}}</a>
                          <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-pencil" role="menu" style="">
                              <button data-url="{{url('cetak-lis-pdf/'.$d->hasillab->no_lab.'/'.$d->hasillab->registrasi_id)}}" class="btn btn-primary btn-flat btn-xs tte-button"><i class="fa fa-pencil"></i> Tanda tangan elektronik</button>
                          </ul>
                        </div>
                      @endif
                    @endif
                  </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

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
                <input type="password" class="form-control" name="passphrase" id="passphrase">
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

{{-- Modal TTE --}}
@php
  $dokter = Auth::user()->pegawai;
@endphp
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
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="nik_hidden" id="nik_hidden" value="{{$dokter->nik}}">
        <input type="hidden" name="url" id="url">
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Dokter:</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" name="dokter" id="dokter" value="{{$dokter->nama}}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">NIK:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="nik" id="nik" value="{{substr($dokter->nik, 0, -5) . '*****'}}" disabled>
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
        <button type="button" class="btn btn-primary" id="button-proses-tte" onclick="prosesTTE()">Proses TTE</button>
      </div>
    </div>
    </form>

  </div>
</div>
@endsection

@section('script')
    {{-- Passphrase Session --}}
    <script>
      let passphrase = {!! json_encode(session('passphrase')) !!};
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
                  passphrase : $('input[name="passphrase"]').val(),
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
  </script>
  {{-- End Passphrase Session --}}
  <script type="text/javascript">

    function prosesTTE() {
      if (confirm('Apakah anda yakin akan melakukan proses TTE pada dokumen ini?')) {
        $('#myModal').modal('hide');
        let nik = $('#nik_hidden').val();
        let reg_id = $('#registrasi_id').val();
        let passphrase = $('#passphrase_modal').val();
        let data = {
          "nik": nik,
          "passphrase": passphrase,
          "proses_tte": true,
          "_token": $('input[name="_token"]').val(),
        };

        $.ajax({
          url: $('#url').val(),
          type: 'POST',
          dataType: 'json',
          data: data,
          beforeSend: function () {
            $('.overlay').removeClass('hidden')
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          }
        })
        .done(function(resp) {
          if (resp.sukses == true) {
            alert('Dokumen berhasil ditandatangan')
            const button_tte = $(`[data-url="${$('#url').val()}"]`);
            button_tte.html("Tanda tangan elektronik ulang");
            button_tte.removeClass('btn-primary')
            button_tte.addClass('btn-warning')

            const button_cetak = $(`a[href="${$('#url').val()}"]`);
            button_cetak.removeClass('btn-success')
            button_cetak.addClass('btn-primary')
            button_cetak.next().removeClass('btn-success')
            button_cetak.next().addClass('btn-primary')
          } else {
            alert(resp.message);
          }
        });
      }
    }

    $('.tte-button').click(function() {
        $('#myModal').modal('show');
        $('#url').val($(this).data("url"));
    })

    $('.select2').select2();
  </script>
@endsection