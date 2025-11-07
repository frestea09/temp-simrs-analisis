@extends('master')
@section('header')
  <h1>Tools Programmer <small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
       {!! Form::open(['method' => 'POST', 'url' => 'cek-histori-pasien', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Cek Pasien</button>
              </span>
              {!! Form::text('no_rm', NULL, ['class' => 'form-control', 'required' => 'required','placeholder'=>'Input Nomor RM Disini']) !!}
              <small class="text-danger">{{ $errors->first('no_rm') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
        </div>
      </div>
      {!! Form::close() !!}
    </div>

    <div class="box-footer">
    </div>
</div>

  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('farmasi/penjualan') }}" ><img src="{{ asset('menu/hakakses.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Cek Pasien Penjualan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
       <a href="{{ url('pasien/info-pasien') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Histori Pasien</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
       <a href="{{ url('cek-inap') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Cek Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
       <a href="{{ url('tarif/tampil-semua-tarif') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Tampil Semua Tarif</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>


  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('cek-logistik-stock') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
         </a>
         <h5>Cek Logistik Stock</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('logistikmedik/kartustok/edit-logistik-batch-id') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
         </a>
         <h5>Cek Logistik Stock</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
