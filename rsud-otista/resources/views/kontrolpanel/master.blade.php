<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.merek') }} | {{ config('app.nama') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.min.css') }}">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
  <style type="text/css" media="screen">
    table{font-size: 99%}
    .form-group{
      margin-bottom: 5px;
    }
  </style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    @include('header')
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      @include('sidebar')
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('header')
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">

    </div>
    <b>Developed By:</b> <a href="http://dmedia.co.id">Digital Media Integra</a> <strong>&copy; 2017 | AdminLTE</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
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
<script>
  $(function () {

    $('#data').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
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

<script>
  $(function() {
    $('.chosen-select').chosen();
  });
</script>

<script>
$( function() {
  $( "#tgllahir" ).datepicker({
    format: "dd-mm-yyyy",
    autoclose: true
  });

} );
</script>

<script>
$( function() {
  $( "#regperjanjian" ).datepicker({
    format: "dd-mm-yyyy",
    autoclose: true
  });
});
</script>

<script>
$( function() {
  $( ".datepicker" ).datepicker({
    format: "dd-mm-yyyy",
    todayHighlight: true,
    autoclose: true
  });
});
</script>

<script type="text/javascript">
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
    $poli = Modules\Registrasi\Entities\Registrasi::select('poli_id')->where('created_at', 'LIKE', date('Y-m-d').'%')->where('poli_id', '<>', '')->distinct()->get();
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
            barWidth: 0.5,
            align   : 'center'
          }
        },
        xaxis : {
          mode      : 'categories',
          tickLength: 0
        }
      })

  });
  </script>
@endif

@yield('script')

</body>
</html>
