<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Display Tempat Tidur</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{ asset('Nivo-Slider/style/style.css') }}" type="text/css" />
    
    <script src="{{ asset('/js/tanggal.js') }}" charset="utf-8"></script>

    <style type="text/css" media="screen">
      body{
        background-color: green;
      }
      #header{
        background-color: white;
        width: auto;
        height: 130px;
        border-top: 1px solid grey;
        border-bottom: 6px solid orange;

      }
      #displayArea{
        height: 350px;
        margin:30px auto;
        padding:10px;
        background-color:none;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
        float: left;
      }
      #slideshow{
        float: right;
      }
      #judul{
        height: 70px;
        width: 100%;
        font-size: 19pt;
        font-weight: bold;
        color: white;
        margin-top: 10px;
        background-color: orange;
        border-top: 0;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding: 15px 20px;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        text-shadow: 2px 2px 4px #000000;
      }
      .logo{
        width: 200px;
        float: left;
        margin-right: 20px;
      }
      .nama{
        font-weight: bold;
        padding-top: 10px;
        font-size: 25pt;
        color: green;
        float: left;
        text-shadow: 1px 1px 0px #000000;

      }
      .alamat{
        font-size: 13pt;
        margin-right: 130px;
      }
      .tanggal{
        font-size: 24px;
        font-weight: bold;
        color: green;
        padding-top: 35px;
        text-shadow: 1px 1px 0px #000000;
      }
    </style>
  <body>
      <div id="header">
        <div class="logo">
          <img src="{{ asset('/images/logo.jpg') }}" class="img img-responsive">
        </div>
        <div class="nama">
          {{ config('app.name') }} <br> <div class="alamat"> {{ configrs()->pt }} <br> {{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}</div>
        </div>
        <div class="tanggal">
          <script type="text/javascript">
            show_hari();
          </script>
        </div>
      </div>

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div id="judul" class="text-center">Informasi Ketersediaan Tempat Tidur</div>
    </div>
  </div>
    <div class="row">
      <div class="col-md-5">
        <div id="displayArea">
          <div id="displayBed"></div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="slideshow">
          <div id="slider-wrapper">
              <div id="slider" class="nivoSlider">
                @foreach ($data as $key => $d)
                  <a href="#"><img src="{{ asset('/images/slideshow/'.$d->image) }}" class="img img-responsive" /></a>
                @endforeach
            </div>
          </div>
        </div>
      </div>

    </div>
</div>



    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#displayBed').load("{{ url('/bed/display-bed') }}");
        },10000);
      });

    </script>

    <script type="text/javascript" src="{{ asset('Nivo-Slider/scripts/jquery-1.6.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Nivo-Slider/scripts/jquery.nivo.slider.js') }}"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider({
  			directionNav: false,
  			directionNavHide: false,
  			controlNav: false
		});
    });
    </script>


  </body>
</html>
