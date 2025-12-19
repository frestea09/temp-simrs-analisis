<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Notifikasi Eresep</title>
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
        background-color: #B1B2FF;
      }
      #header{
        background-color: white;
        width: auto;
        height: 130px;
        border-top: 1px solid grey;
        border-bottom: 6px solid orange;

      }

      #judul{
        height: 150px;
        width: 100%;
        font-size: 28pt;
        font-weight: bold;
        color: green;
        margin-top: 3px;
        background-color: orange;
        border-top: 0;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding: 15px 20px;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        /* text-shadow: 1px 1px 2px #000000; */
      }

      .blockloket{
        height: 550px auto !important;
        width: 100%;
        margin:20px auto;
        background-color:none;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
        float: left;
        border-radius: 3px;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f8ffe8+0,e3f5ab+0,b7df2d+100 */
        background: #EEF1FF; /* Old browsers */
      }

      .loketheader{
          width: 100%;
          height: 85px;
          padding: 10px 20px;
          color: white;
          font-weight: bold;
          text-shadow: 3px 3px 5px #000000;
          font-size: 34pt;
          border-bottom: 1px solid green;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,72aa00+38,8eb92a+70,9ecb2d+100 */
          background: #AAC4FF; /* Old browsers */
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
      .btn-area{
          padding-top: 20px;
          width: 100%;
          font-family: Verdana;
          color: green;
          font-size: 100pt;
          letter-spacing: -5px;
          font-weight: bold;
          text-shadow: 2px 2px 2px #000000;

      }

    </style>
  <body>

<div class="container-fluid">
  {{-- <div class="row">
    <div class="col-md-12">
      <div id="judul" class="text-center">
        Antrian Loket Pendaftaran Rawat Jalan <br>{{ configrs()->nama }}<BR></div>
    </div>
  </div> --}}
    <div class="row">
      <div class="col-md-12">
        {{-- <div class="col-md-6"> --}}
            <div class="blockloket">
                <div class="loketheader text-center" style="font-size: 25pt !important;">
                    Notifikasi E-Resep {{date('d-m-Y')}} {{ucfirst($unit)}}
                </div>
                <div class="text-center" style="z-index: 99">
                  {{-- <button id="startbtn">Start</button> --}}
                    <div class="loading"><i class="fa fa-refresh fa-spin" style="margin-top:35px;"></i> &nbsp;&nbsp;Sedang Memuat</div>
                    <div id="layarlcd">    </div>
                </div>
            </div>
        {{-- </div> --}}
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-12" style="font-size: 23pt; font-weight: bold; color:white;">
        {{-- <marquee>{{ configrs()->antrianfooter }}</marquee> --}}
      </div>
    </div>
</div>
    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- LOKET 1 -->
    <script type="text/javascript">
      $(document).ready(function() {
        $('.loading').css("display","none");
        $('#layarlcd').load("{{ route('farmasi.data_lcd_eresep', $unit) }}");
        setInterval(function () {
          $('.loading').css("display","none");
          $('#layarlcd').load("{{ route('farmasi.data_lcd_eresep', $unit) }}");
        },30000); //normal 13000
      });
    </script> 

  </body>
</html>
