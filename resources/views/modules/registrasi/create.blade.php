@extends('master')
@section('header')
  <h1>Pendaftaran - Pasien JKN </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data Pasien &nbsp;

      </h3>
    </div>
    <div class="box-body">
      @if ($pasien)
        {!! Form::model($pasien, ['route' => ['registrasi.update', $pasien->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
      @else
        {!! Form::open(['method' => 'POST', 'route' => 'registrasi.store', 'class' => 'form-horizontal']) !!}
      @endif

          @include('pasien::_form')
          <hr>
          @include('registrasi::_form')

      {!! Form::close() !!}
    </div>
  </div>

  <!-- MODAL BRIDGING SEP -->
  <div class="modal fade" id="modalBridging" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <form class="form-horizontal" id="BridgingForm" role="form" method="post">
          {{ csrf_field() }}
        <div class="modal-body">

          <div id="formBridging">
            <div class="form-group">
              <label for="nobpjs" class="col-md-3">Nomor BPJS</label>
              <div class="col-md-9">
                <input type="text" name="no_bpjs" class="form-control" id="no_bpjs" placeholder="">
              </div>
            </div>

            <div class="form-group">
              <label for="nama" class="col-md-3">Nama</label>
              <div class="col-md-9">
                <input type="text" name="nama" class="form-control" id="nik" placeholder="">
              </div>
            </div>
          </div>

          <div id="hasilBridging">

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{-- <input type="submit" name="submit" id="tmbSEP" class="btn btn-primary" value="Cari"> --}}
        </div>
        </form>
      </div>
    </div>
  </div>

  @include('igd.reg.umum.modal')

@endsection

@push('js')
<script src="{{ url('/') }}/js/registrasi.js"></script>
@endpush