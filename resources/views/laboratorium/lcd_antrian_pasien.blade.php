<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Antrian Laboratorium</title>
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
          background: orange; /* Old browsers */
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

      .marquee2 {
        position: relative;
        overflow: hidden;
        --offset: 50vw;
        --move-initial: calc(-20% + var(--offset));
        --move-final: calc(-40% + var(--offset));
        }

        .marquee__inner2 {
        width: fit-content;
        display: flex;
        position: relative;
        transform: translate3d(0, 0, 0);
        animation: marquee2 30s linear infinite;
        animation-play-state: play;
        color: rgb(252, 251, 249);
        font-family: 'Noctis Bld';
        }

        .marquee2 span {
        font-size: 5vh;
        padding: 0 5vw;
        }

        .marquee2:hover .marquee__inner2 {
        animation-play-state: paused;
        }

        @keyframes marquee2 {
        0% {
            transform: translate3d(10, 0, 0);
        }
        100% {
            transform: translate3d(-100%, 0, 0);
        }
      }

    
    </style>
  <body>

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
            <div class="blockloket">
                <div class="loketheader text-center" style="font-size: 25pt !important;">
                    <td><img src="{{ asset('/images/'.configrs()->logo) }}" style="height: 70px"></td>
                    <td>Antrian Laboratorium {{date('d-m-Y')}}</td>
                </div>
                <div class="text-center" style="z-index: 99">
                    <div class="loading"><i class="fa fa-refresh fa-spin" style="margin-top:25px;height:20px;font-size: 15pt;"></i> &nbsp;&nbsp;Sedang Memuat Data</div>
                    <div id="layarlcd">    </div>
                </div>
            </div>
      </div>
      
    </div>
    
    {{-- <div class="marquee2" id="showScroll2">
        <div class="marquee__inner2" aria-hidden="true">
          <span>Mohon bersabar dalam pengantrian obat</span>
          <span>Terima kasih sudah bersabar</span>
        </div>
    </div> --}}
</div>
    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- LOKET 1 -->
    <script type="text/javascript">
      $(document).ready(function() {
        $('.loading').css("display","none");
          $('#layarlcd').load("{{ route('laboratorium.data_lcd_antrian_pasien') }}");
        setInterval(function () {
          $('.loading').css("display","none");
          $('#layarlcd').load("{{ route('laboratorium.data_lcd_antrian_pasien') }}");
          clearInterval(scrollInterval);
        },13000); //normal 13000
      });
    </script> 

  </body>
</html>
