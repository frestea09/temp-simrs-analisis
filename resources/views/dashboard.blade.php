@extends('master')
@section('header')
  <h1><small>Selamat Datang </small> {{ Auth::user()->name }}, <small> Anda Masuk ke sebagai : </small> {{ ucfirst(Auth::user()->role()->first()->display_name)}}</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">


    <div class="row">
    
    <div class="col-lg-2 col-xs-4">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner text-center">
          <div class="operlay4 text-center">
            <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
            <br/>
          </div>
          
          <h3><span class="total"></span></h3>

          <p>Total </p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner text-center">
              <div class="operlay text-center">
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
                <br/>
              </div>
              
              <h3><span class="rajal"></span></h3>
              <p>Rawat Jalan</p>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner text-center">
              <div class="operlay2 text-center">
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
                <br/>
              </div>
              
              <h3><span class="igd"></span></h3>

              <p>IGD</p>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-teal color-palette">
            <div class="inner text-center">
              <div class="operlay3 text-center">
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
                <br/>
              </div>
              
              <h3><span class="irna"></span></h3>

              <p>Rawat Inap</p>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner text-center">
              <div class="operlay5 text-center">
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
                <br/>
              </div>
              
              <h3><span class="l"></span></h3>

              <p>Laki - laki</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner text-center">
              <div class="operlay6 text-center">
                <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
                <br/>
              </div>
              
              <h3><span class="p"></span></h3>

              <p>Perempuan</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
        
        
        

      </div> 

    </div>
  </div>


  {{-- @if (@\App\Satusehat::find(17)->aktif) --}}
  <div class="row">
    <div class="col-md-12">
      {{-- <div class="box box-primary"> --}}
            {{-- <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Grafik Kunjungan Klinik Hari Ini</h3>

            </div> --}}
            {{-- <div class="box-body">
              <div id="bar-chart" style="height: 350px;"></div>
            </div> --}}
            <!-- /.box-body-->
      {{-- </div> --}}
    </div>
  </div>
  
  <div id="kunjunganKlinik">

  </div>
  

@endsection
<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#kunjunganKlinik').load('/data-kunjungan-poli-dashboard')
    // COUNT TOTAL
    $.ajax({
      url: '/data-kunjungan-dashboard/total',
      dataType: 'json',
      beforeSend: function () {
      },
      complete: function () {
        $('.operlay4').addClass('hidden')
      }
    })
    .done(function(res) {
      total = '.total'
      $(total).append('<span>'+res+'</span>')
      
    });

    // COUNT RAJAL
    $.ajax({
      url: '/data-kunjungan-dashboard/rajal',
      dataType: 'json',
      beforeSend: function () {
      },
      complete: function () {
        $('.operlay').addClass('hidden')
      }
    })
    .done(function(res) {
      total = '.rajal'
      $(total).append('<span>'+res+'</span>')
      
    });

    // COUNT RD
    $.ajax({
      url: '/data-kunjungan-dashboard/igd',
      dataType: 'json',
      beforeSend: function () {
      },
      complete: function () {
        $('.operlay2').addClass('hidden')
      }
    })
    .done(function(res) {
      total = '.igd'
      $(total).append('<span>'+res+'</span>')
      
    });
    // COUNT IRNA
    $.ajax({
      url: '/data-kunjungan-dashboard/irna',
      dataType: 'json',
      beforeSend: function () {
      },
      complete: function () {
        $('.operlay3').addClass('hidden')
      }
    })
    .done(function(res) {
      total = '.irna'
      $(total).append('<span>'+res+'</span>')
      
    });
    // COUNT LAKI
    $.ajax({
      url: '/data-kunjungan-dashboard/l',
      dataType: 'json',
      beforeSend: function () {
      },
      complete: function () {
        $('.operlay5').addClass('hidden')
      }
    })
    .done(function(res) {
      total = '.l'
      $(total).append('<span>'+res+'</span>')
      
    });
    // COUNT PEREMPUAN
    $.ajax({
      url: '/data-kunjungan-dashboard/p',
      dataType: 'json',
      beforeSend: function () {
      },
      complete: function () {
        $('.operlay6').addClass('hidden')
      }
    })
    .done(function(res) {
      total = '.p'
      $(total).append('<span>'+res+'</span>')
      
    });
  })

</script>