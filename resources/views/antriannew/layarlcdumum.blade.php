
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>RUMAH SAKIT UMUM DAERAH OTO ISKANDAR DI NATA</title>

  <link rel="shortcut icon" href="{{ asset('style') }}/assets/img/favicon.ico" />
    
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('style') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
  <link href="{{ asset('style') }}/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="{{ asset('style') }}/assets/css/display.css" rel="stylesheet">
  <style>
    .header-bg{
      background: url('../images/header.jpeg')
    }
    /* .loket .my-loket {
      flex: 0 0 17.7% !important;
    } */
  </style>

</head>

<body onload="goforit()">
	<div class="gap">&nbsp;</div>
	
    <div class="header">
        <div class="header-bg"></div>
        <span id="clock" class="clock-right"></span>
    </div>
    
    <div class="sidebar" style="width: 60%; height: 80%; margin-left: 20%;">
        <div class="sidebar-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 my-auto">
                    <div class="sidebar-content">
                        
                        <div class="loketbigtop">
                            <div class="loketbigtop-bg"></div>
                            <div class="row h-100">
                                <div class="my-loketbigtop">
                                    <div>LOKET UMUM</div>
                                </div>
                            </div>
                        </div>

                        <div class="loketbig">
                            <div class="loketbig-bg"></div>
                            <div class="row h-100">
                                <div class="my-loketbig" style="height: 400px;">
                                    <div class="loketbig-content">
                                        <div class="top">ANTRIAN PENDAFTARAN</div>
                                        <div class="content">
                                            <div id="antrian_loket_panggil" style="padding-top: 70px;"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-12" id="suara_antrian_new"></div>
            </div>
        </div>
    </div>

    <div class="side-right">
        <div class="video-player">
            <div class="overlay"></div>
            {{-- <video id="myVideoss" autoplay="autoplay" muted="muted" loop>
                <source class="active" src="{{asset('style') }}/assets/video/video_display_jkn.mp4" type="video/mp4">
            </video> --}}
        </div>
    </div>

    <div class="clear"></div>
    
    <div class="loket">
        <div class="loket-bg"></div>
        <div class="row h-100">
            {{-- <div class="my-loket">
                <div class="loket-content">
                    <div class="top">LOKET UMUM</div>
                    <div class="content">
                        <div id="layarlcd">    </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="my-loket">
                <div class="loket-content">
                    <div class="top">LOKET UMUM</div>
                    <div class="content">
                      <div id="layarlcd">    </div>
                    </div>
                </div>
            </div> --}}
        
        </div>
    </div>
    <br/>
    
    
	<div id="audio_antrian"></div>
	
  <!-- Bootstrap core JavaScript -->
<!--   <script src="assets/vendor/jquery/jquery.min.js"></script> -->
  {{-- <script src="http://172.168.1.5/simrs/resources/jquery/jquery-1.11.1.min.js"></script> --}}
  {{-- <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}

  <!-- Custom scripts for this template -->
  {{-- <script src="assets/js/display.js"></script> --}}
  <script src="{{ asset('style') }}/assets/js/clock.js"></script>

    
    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    {{-- <script type="text/javascript">
      setInterval(function () {
        
      }, 15000);
    </script> --}}
    <!-- LOKET 1 -->
    
    <script type="text/javascript"> 

    $(document).ready(function() {
        // $('#suara_antrian_new').load("{{ route('antrian_new.ajax_suara') }}");
        delay = 9000;
        setInterval(function () {
          $.ajax({
            url: '/antrian-new/cek-umum',
            type: 'GET',  
            success: function (res) {
              if(res.count == 1) {
                delay = 9000
              }else if (res.count == 2) {
                delay = 18000
              } else if (res.count == 3) {
                delay = 27000
              } else if (res.count == 4) {
                delay = 36000
              } else if (res.count == 5) {
                delay = 45000
              } else if (res.count == 6) {
                delay = 54000
              } else {
                delay = 9000
              }
              delay = delay
                $('#suara_antrian_new').load("{{ route('antrian_new.ajax_suara_umum') }}");
            },
        })
      },delay); //normal 13000
      
        
        // setInterval(function () {
        //   $('#layarlcd').load("{{ route('antriannew.datalayarlcdumum') }}");
        // },9000); //normal 13000
      });
    </script>
    <!-- LOKET BARUSAJA DIPANGGIL -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#antrian_loket_panggil').load("{{ route('antriannew.datalayarlcdumum') }}");
        },9000); //normal 13000
      });
    </script>
</body>
</html>

