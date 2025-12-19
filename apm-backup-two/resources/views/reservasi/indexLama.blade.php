@extends('layouts.landingpage')
@section('style')
<style>
  .select2-results__option,
  .select2-search__field,
  .select2-selection__rendered,
  .form-control,
  .col-form-label
  {
    font-size:12px;
  }
  .table-pasien tr td{
    padding:5px !important;
    font-size:12px;
  }

  #dataPasien td,  #dataPasien th{
    padding: 0.25rem !important;
  }
  select[readonly] {
  background: #eee; /*Simular campo inativo - Sugestão @GabrielRodrigues*/
  pointer-events: none;
  touch-action: none;
}
</style>
@endsection
@section('content')
<div class="container">
  <div class="loading d-none"></div>
  <div class="card border-warning" style="box-shadow: 0 0 15px 1px rgb(0 0 0 / 40%);">
    <div class="card-header bg-warning" style="background-color: #E5D9B6 !important;border-color:#E5D9B6;color:#285430;">
      Form Reservasi Pasien Lama
    </div>
    <div class="card-body">
      @include('reservasi.section.cariLama')
      
      <hr/>
      {{-- data pasien--}}
        {{-- @include('reservasi.section.pasien') --}}
      {{-- Data Form Registrasi --}}
      
        
        @include('reservasi.section.registrasi')
      
        {{-- <div class="row">
          <div class="col-md-12">
          <br/>
            <ul>
              <li><b>Pendaftaran Pasien Baru</b> : Silahkan mengisi biodata pada form bagian pendaftaran pasien baru, kemudian melakukan registrasi ulang di bagian pendaftaran {{config('app.nama_rs')}} untuk memperoleh no rekam medis.</li>
              <li><b>Pendaftaran Pasien Lama</b> : Silahkan masukkan no rekam medis (RM) serta tanggal lahir pasien pada form pasien umum / pasien BPJS yang terdapat pada menu Pendaftaran pasien lama,apabila muncul data tidak ditemukan, silahkan menghubungi bagian pendaftaran  {{config('app.nama_rs')}} untuk dilakukan update biodata pasien.</li>
            </ul>
          </div>
        </div> --}}
    </div>
  </div>
  <br/>
  <a href="{{url('/')}}" class="btn btn-info btn-sm col-md-2 col-lg-2 float-left"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
</div>
@endsection

@section('script')
  
  <script type="text/javascript">
  $(document).ready(function () {

  });
  </script>
  @parent
@endsection