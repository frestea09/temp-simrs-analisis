@extends('master')
@section('header')
  <h1>Registrasi Perjanjian</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Rawat Jalan
      </h3>
      <div class="pull-right">
        <button type="button" class="btn btn-default btn-sm btn-flat" onclick="viewFormRM()">BLM TERDATA</button>
        <a href="{{ url('regperjanjian') }}" class="btn btn-default btn-sm btn-flat">FORM BARU</a>
      </div>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'regperjanjian/searchpasien', 'class' => 'form-search']) !!}
      <label for="keyword" class="text text-primary">Cari Pasien: {{ session('idlama') }} </label> <small>Isi salah satu kolom atau diisi semua</small>
      
      
      <div class="input-group input-group-md {{ $errors->has('keyword') ? ' has-error' : '' }}">
            {{-- <input type="text" name="keyword" id="keyword" class="typeahead form-control" placeholder="Ketik nama, alamat, atau Nomor RM"> --}}
            <div class="col-md-3">
              <input type="text" name="no_rm_s" id="no_rm_s" class="form-control" placeholder="No.RM">
            </div>
            <div class="col-md-3">
              <input type="text" name="namas" id="namas" class="form-control" placeholder="Nama">
            </div>
            <div class="col-md-3">
              <input type="text" name="tgllahirs" id="tgllahirs" class="form-control" placeholder="TglLahir : 06101993">
            </div>
            <div class="col-md-3">
              <input type="text" name="alamats" id="alamats" class="form-control" placeholder="Alamat">
            </div>
            <small class="text-danger">{{ $errors->first('keyword') }}</small>
            <span class="input-group-btn">
              <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> CARI</button>
            </span>
      </div>
      {!! Form::close() !!}
      <hr>

      @if ($pasien)
        {!! Form::model($pasien, ['url' => ['save-reg-perjanjian', $pasien->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
      @else
        {!! Form::open(['method' => 'POST', 'url' => 'save-reg-perjanjian', 'class' => 'form-horizontal']) !!}
      @endif

          @include('pasien::_formperjanjian')
            <hr>
          @include('registrasi::_form')

      {!! Form::close() !!}

    </div>
  </div>
  
  @include('igd.reg.umum.modal')

@endsection

@section('script')
  <script type="text/javascript">
    $('select[name="bayar"]').on('change', function(e) {
      e.preventDefault();
      if ($(this).val() != 1) {
        $('#tipeJKN').addClass('hidden')
        $('select[name="jkn"]').val('').trigger('change')
      } else {
        $('#tipeJKN').removeClass('hidden')
      }
    });

    
  </script>
@endsection

@push('js')
<script src="{{ url('/') }}/js/registrasi.js"></script>
@endpush