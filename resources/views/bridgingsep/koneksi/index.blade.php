@extends('master')
@section('header')
<h1>Dashboard Koneksi BPJS</h1>
<style>
  .judul {
    height: 100px !important;
  }

  .panel-default {
    box-shadow: 0px 10px 8px #c1c1c1;
  }
</style>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    <div class="row">

      {{-- FINGER --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">
            <div class="">
              <div class="operlay">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping"></span>
                </b></span>
            </div>
            {{-- <div id="aplikasiFinger"></div> --}}
          </div>
          <div class="panel-footer">
            <b>Aplikasi Finger</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>

      {{-- SURKON --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay2">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status2"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping2"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Cari Nomor Surkon</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- NOKA --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay3">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status3"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping3"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Get Data By No.Kartu</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- PENCARIAN SEP --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay4">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status4"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping4"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Pencarian SEP</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- HISTORI KUNJUNGAN --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay5">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status5"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping5"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Histori Kunjungan Peserta</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- JADWAL DOKTER --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay6">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status6"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping6"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Jadwal Dokter Vclaim</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- REF POLI --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay7">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status7"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping7"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Ref Poli</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- INSERT SEP --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay8">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status8"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping8"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Insert SEP</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- HAPUS SURKON --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay9">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status9"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping9"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Hapus Surkon</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- HAPUS SEP --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay10">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status10"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping10"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Hapus SEP</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- BUAT SURKON --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay11">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status11"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping11"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Buat Surkon</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- BUAT SPRI --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay12">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status12"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping12"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Buat SPRI</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- TTE --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay13">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status13"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping13"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>TTE</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>
      {{-- CLIENT BROWSER TO SERVER (SIMRS) --}}
      <div class="col-md-3">
        <div class="panel panel-default" id="">
          <div class="panel-body judul text-center">

            <div class="">
              <div class="operlay14">
                &nbsp;<br />
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
              </div>
              <b><span class="status14"></span></b><br />
              <span class="text-primary" style="font-size:16px;">
                <br /><b>
                  <span class="ping14"></span>
                </b></span>
            </div>
          </div>
          <div class="panel-footer">
            <b>Client ke Server</b><br />
            <span style="font-size:12px;">Last Update : {{date('d/m/Y H:i')}}</span>
          </div>
        </div>
      </div>


    </div>
    <div class="box-footer">

    </div>
  </div>

  @include('bridgingsep.form')

  @endsection

  @section('script')
  <script type="text/javascript">
    $(document).ready(function() {
    // FINGER
    $.ajax({
        url: '/data-koneksi-vclaim/aplikasiFinger',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping'
        status = '.status'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // SURKON
    $.ajax({
        url: '/data-koneksi-vclaim/surkon',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay2').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping2'
        status = '.status2'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // NOKA
    $.ajax({
        url: '/data-koneksi-vclaim/noka',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay3').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping3'
        status = '.status3'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // SEARCH SEP
    $.ajax({
        url: '/data-koneksi-vclaim/sep',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay4').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping4'
        status = '.status4'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // HISTORI KUNJUNGAN
    $.ajax({
        url: '/data-koneksi-vclaim/histori_kunjungan',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay5').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping5'
        status = '.status5'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // JADWAL DOKTER
    $.ajax({
        url: '/data-koneksi-vclaim/jadwaldokter',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay6').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping6'
        status = '.status6'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // REF POLi
    $.ajax({
        url: '/data-koneksi-vclaim/poli',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay7').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping7'
        status = '.status7'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // INSERT SEP
    $.ajax({
        url: '/data-koneksi-vclaim/insert_sep',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay8').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping8'
        status = '.status8'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // HAPUS SURKON
    $.ajax({
        url: '/data-koneksi-vclaim/hapus_surkon',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay9').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping9'
        status = '.status9'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // HAPUS SURKON
    $.ajax({
        url: '/data-koneksi-vclaim/hapus_sep',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay10').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping10'
        status = '.status10'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // BUAT SURKON
    $.ajax({
        url: '/data-koneksi-vclaim/buat_surkon',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay11').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping11'
        status = '.status11'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // BUAT SPRI
    $.ajax({
        url: '/data-koneksi-vclaim/spri',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay12').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping12'
        status = '.status12'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // TTE
    $.ajax({
        url: '/data-koneksi-vclaim/tte',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay13').addClass('hidden')
        }
      })
      .done(function(res) {
        ping = '.ping13'
        status = '.status13'
        if(res.status == 'Terputus'){
          $(ping).append('<span style="color:red">'+res.ping+'ms</span>')
          $(status).append('<span style="color:red">'+res.status+'</span>')
        }else if(res.ping > '100'){
          $(ping).append('<span style="color:orange">'+res.ping+'ms</span>')
          $(status).append('<span style="color:orange">'+res.status+'</span>')
        }else{
          $(ping).append('<span style="color:green">'+res.ping+'ms</span>')
          $(status).append(res.status)

        }
      });
    // CLIENT TO SERVER
    var startTime = Date.now();
    $.ajax({
        url: "{{url('')}}",
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay14').addClass('hidden')
        },
        success: function(response) {
            var endTime = Date.now();
            var pingTime = endTime - startTime;

            ping = '.ping14'
            status = '.status14'

            if(pingTime > '100'){
              $(ping).append('<span style="color:orange">'+pingTime+'ms</span>')
              $(status).append('<span style="color:orange">Terhubung</span>')
            }else{
              $(ping).append('<span style="color:green">'+pingTime+'ms</span>')
              $(status).append('Terhubung')
            }
        },
        error: function(xhr, status, error) {
            ping = '.ping14'
            status = '.status14'

            $(ping).append('<span style="color:red">0ms</span>')
            $(status).append('<span style="color:red">Terputus</span>')
        }
      })
  });

  </script>

  <script type="text/javascript">
    $('.select2').select2();
    $(".skin-blue").addClass( "sidebar-collapse" );
    
     


  </script>
  @endsection