
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ @config('app.merek') }} | {{ @config('app.nama') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
  <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Lambang_Kabupaten_Bandung%2C_Jawa_Barat%2C_Indonesia.svg/1229px-Lambang_Kabupaten_Bandung%2C_Jawa_Barat%2C_Indonesia.svg.png" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/select2/dist/css/select2.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
  {{-- default <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css"> --}}
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-yellow.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.min.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/timepicker/bootstrap-timepicker.min.css">
  {{-- <link rel="stylesheet" href="{{ asset('src/sweetalert/sweet-alert.css') }}"> --}}
  <script src="{{ asset('src/sweetalert/sweet-alert.min.js') }}"></script>
  {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

  <meta name="csrf-token" content="{{ csrf_token() }}">

   @yield('css')

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
  <style type="text/css" media="screen">
    .content-wrapper{
      min-height:100% !important;
    }
    table{font-size: 99%}
    .form-group{
      margin-bottom: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered{
      padding: 5px;
    }
    .datepicker{
      {{-- z-index:999999 !important; --}}
    }
    .no-wrap{white-space: nowrap}
    .form-radio{
         -webkit-appearance: none;
         -moz-appearance: none;
         appearance: none;
         display: inline-block;
         position: relative;
         background-color: #f1f1f1;
         color: #666;
         top: 2px;
         height: 16px;
         width: 16px;
         cursor: pointer;
         border: 1px solid #d0d8e5;
    }
    .v-middle{vertical-align: middle !important;}
    .form-radio:checked::before{
         position: absolute;
         left: 4px;
         content: '\02143';
         transform: rotate(35deg);
    }
    .form-radio:hover{
         background-color: #f7f7f7;
    }
    .form-radio:checked{
         background-color: #f1f1f1;
    }
    .main-sidebar{ 
      position: fixed; 
      bottom: 0; 
      z-index: 1000;
      display: block;
      width: 250px;
      margin: 10p; 
      overflow-x: hidden;
      overflow-y: auto; 
    }
  </style>
  {{-- <script>
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
    window.onhashchange=function(){window.location.hash="no-back-button";}
  </script>  --}}
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">   
    
</head>
<body>


  <header class="main-header">
    <a href="{{ url('/') }}" class="logo">
        <span class="logo-mini"><b></b>S</span>
        <span class="logo-lg"><img src="images/{{ config('app.logo') }}" alt="">SIMRS Terintegrasi</span>
      </a>
      <nav class="navbar navbar-static-top">
        <div style="font-size: 15pt; float: left; margin-left: 20px; letter-spacing: 1;line-height:70px;">
             {{-- {{ config('app.logo') }}  --}}
        </div>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li>SIPEKA</li>
          </ul>
        </div>
      </nav>
      
  </header>
  {{-- <aside class="main-sidebar">
    <section class="sidebar">
      @include('sidebar')
    </section>
  </aside> --}}

    <section class="content-header">
      @yield('header') 
      {{-- header --}}
    </section>
    <section class="content">
      
<div id="myCarousel" class="carousel slide" data-ride="carousel">
          
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active ">
        <img src="/images/{{ configrs()->logo }}"  style="width: 100%;height: 750px">
        
        {{-- <div class="align-items-center text-light card-img-overlay d-flex" style="background-color: rgb(0, 0, 0, 0.5);">
            <div class="container px-1  mt-3">
                <h3 class="display-5 fw-bolder text-center text-white mb-5" style=" font-size: 4vw">Keluhan Pasien KUDUS</h3>
                <div class="text-center"><img style="width: 250px" src="img/logo-smk.png" alt="" ></div>
            </div>
        </div> --}}

      </div>
  
      <div class="item">
        <img src="/images/{{ configrs()->logo }}"  style="width: 100%;height: 750px">
   
       </div>
  
      <div class="item">
        <img src="/images/{{ configrs()->logo }}" style="width: 100%;height: 750px">
      </div>
    </div>
  
    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
<!-- Services-->
<!-- JQUERY STEP -->
<br>
<br>

<form action="sipeka/store">

    <div class="form-group">
        <label for="nik">NIK</label>
        <input required type="text" id="nik" name="nik" class="form-control"  placeholder="Masukan NIK">
    </div>
    <div class="form-group">
        <label for="no_hp">Nomor HP</label>
        <input required type="text" id="no_hp" name="no_hp" class="form-control"  placeholder="Masukan Nomor HP">
    </div>
    <div class="form-group">
      <label for="perihal">Perihal</label>
      <input required type="text" id="perihal" name="perihal" class="form-control"  placeholder="Masukan Perihal">
    </div>
    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input required type="date" id="tanggal" name="tanggal" class="form-control"  placeholder="Masukan Tanggal">
    </div>
    <div class="form-group">
        <label for="judul_pesan">Judul Pesan</label>
        <input required type="text" id="judul_pesan" name="judul_pesan" class="form-control"  placeholder="Masukan Judul Pesan">
    </div>
    <div class="form-group">
        <label for="pesan">Pesan</label>
        <input required type="text" id="pesan" name="pesan" class="form-control"  placeholder="Masukan Pesan">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="item active ">
    <img style="" src="/images/logo-sipeka.jpeg" class="img-fluid" alt="Responsive image"  style="width: 100%;height: 750px">
      </div>
    </div>
</div>
    </section>



<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="{{ asset('style') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="{{ asset('style') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ asset('style') }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="{{ asset('style') }}/bower_components/moment/min/moment.min.js"></script>
<script src="{{ asset('style') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('style') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('style') }}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{ asset('style') }}/dist/js/adminlte.min.js"></script>
<script src="{{ asset('style') }}/dist/js/demo.js"></script>

<!-- DataTables -->
<script src="{{ asset('style') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('style') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="{{ asset('style') }}/bower_components/Flot/jquery.flot.js"></script>
<script src="{{ asset('style') }}/bower_components/Flot/jquery.flot.resize.js"></script>
<script src="{{ asset('style') }}/bower_components/Flot/jquery.flot.categories.js"></script>
<script src="{{ asset('style') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script>
  $(function () {

    $('#data').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });

</script>



{{-- flashy --}}
@include('flashy::message')

<script src="{{ asset('js/demografi.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/simrs.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/aplikasi.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/rekammedis.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/chosen.js') }}"></script>
<script src="{{ asset('js/jquery.timepicker.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/datatable.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/jquery.masknumber.js') }}"></script>
{{-- <script src="{{ asset('js/jquery-ui.js') }}"></script> --}}

<script>
  let base_url = "{{ url('/') }}";
  $(function() {
    $('.chosen-select').chosen();
  });
  $( function() {
    $( "#tgllahir" ).datepicker({
      format: "dd-mm-yyyy",
      autoclose: true
    });
  } );
  $( function() {
    $( "#regperjanjian" ).datepicker({
      format: "dd-mm-yyyy",
      autoclose: true
    });
  });
  $( function() {
    $( ".datepicker" ).datepicker({
      format: "dd-mm-yyyy",
      todayHighlight: true,
      autoclose: true
    });
  });
    $('.timepicker').timepicker({
      timeFormat: 'H:mm',
      interval: 30,
      minTime: '06',
      maxTime: '9:00pm',
      defaultTime: '09',
      startTime: '06:00',
      dynamic: false,
      dropdown: true,
      scrollbar: true
    });
</script>

@if (Request::is('/') || Request::is('/home'))
  @php
    $poli = App\HistorikunjunganIRJ::leftJoin('polis', 'histori_kunjungan_irj.poli_id', '=', 'polis.id')->select('histori_kunjungan_irj.poli_id')->orderBy('polis.urutan','ASC')->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d').'%')->where('histori_kunjungan_irj.poli_id', '<>', '')->distinct()->get();
  @endphp
  <script type="text/javascript">
  $( function() {
    var bar_data = {
        //data : [['January', 10], ['February', 8], ['March', 4], ['April', 13], ['May', 17], ['June', 9]],
        data : [
          @foreach ($poli as $r)
            ['{{ baca_poli($r->poli_id) }}', {{ pasien_perpoli(date('Y-m-d'), $r->poli_id) }}],
          @endforeach
        ],
        color: '#3c8dbc'
      }
      $.plot('#bar-chart', [bar_data], {
        grid  : {
          borderWidth: 1,
          borderColor: '#f3f3f3',
          tickColor  : '#f3f3f3'
        },
        series: {
          bars: {
            show    : true,
            barWidth: 0.9,
            align   : 'center',
          // showInputs: false
          }
        },
        xaxis: {
        mode: "categories"
    },
      })
    })
  </script>
@endif
@stack('js')
@yield('script')
</body>
</html>





























