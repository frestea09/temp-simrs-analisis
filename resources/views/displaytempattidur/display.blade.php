<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="65" />
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
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#258dc8+0,258dc8+100;Blue+Flat+%231 */
          background: #258dc8; /* Old browsers */
          background: -moz-linear-gradient(top, #258dc8 0%, #258dc8 100%); /* FF3.6-15 */
          background: -webkit-linear-gradient(top, #258dc8 0%,#258dc8 100%); /* Chrome10-25,Safari5.1-6 */
          background: linear-gradient(to bottom, #258dc8 0%,#258dc8 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
          filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#258dc8', endColorstr='#258dc8',GradientType=0 ); /* IE6-9 */
        }
      #header{
        background-color: white;
        width: auto;
        height: 130px;
        border-top: 1px solid grey;
        border-bottom: 6px solid #ff220a;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e1ffff+0,e1ffff+7,e1ffff+12,e6f8fd+18,bee4f8+75,b1d8f5+100 */
        background: #e1ffff; /* Old browsers */
        background: -moz-linear-gradient(top, #e1ffff 0%, #e1ffff 7%, #e1ffff 12%, #e6f8fd 18%, #bee4f8 75%, #b1d8f5 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #e1ffff 0%,#e1ffff 7%,#e1ffff 12%,#e6f8fd 18%,#bee4f8 75%,#b1d8f5 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #e1ffff 0%,#e1ffff 7%,#e1ffff 12%,#e6f8fd 18%,#bee4f8 75%,#b1d8f5 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e1ffff', endColorstr='#b1d8f5',GradientType=0 ); /* IE6-9 */


      }
      #displayArea{
        height: auto;
        width: 100%;
        padding:10px;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
      }
       #displayArea1{
        height: auto;
        width: 100%;
        padding-top:10px;
        padding-left:10px;
        padding-right:10px;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
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
        background-color: #365BED;
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
        color: #365BED;
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
        color: #365BED;
        padding-top: 35px;
        text-shadow: 1px 1px 0px #000000;
      }
      .jumlah{
        text-align: center;
      }
    </style>
  <body>

    

<div class="container">
  <div class="row">
    {{-- <div class="col-md-10 col-md-offset-1">
      <div id="judul" class="text-center">Informasi Ketersediaan Tempat Tidur</div>
    </div> --}}
  </div>
    <div class="row">
      <div class="navbar-fixed-top col-md-12" style="padding-left:120px; padding-right:120px">
        <div id="displayArea1">
          <h4 class="text-center text-primary" style="font-weight: bold;">
            INFORMASI KETERSEDIAAN TEMPAT TIDUR <br>{{ config('app.nama') }} <br> {{ config('app.alamat') }}<br>
            <script>show_hari()</script>
          </h4>
          <h4>
          <div class=''>
            <table class='table table-bordered table-condensed'>
              <thead>
                <tr class="bg-primary">
                  <th class="text-center"  width="7%">No</th>
                  <th  width="28%">Kelas</th>
                  <th class="text-center">Total kamar</th>
                  <th  width="20%">Kamar</th>
                  <th class="text-center">Kapasitas</th>
                  <th class="text-center">Terisi</th>
                  <th class="text-center">Kosong</th>
                </tr>
              </thead>
            </table>
          </div>
          </h4>

        </div>
      </div>
      <div id="displayArea" style="padding-top:100px;">
        <div id="displayBed"></div>
      </div>
    </div>
</div>
<style>
   .container{
            height: 255px; 
            width: 100%;
            overflow: auto;
          }
</style>


    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#displayBed').load("{{ url('/bed/display-bed') }}");
        },1000); //defaul: 10000
      });


      // var scroll = setInterval(function(){ window.scrollBy(0,1000); }, 2000)

    </script>
    <script type="text/javascript">
    $("html, body").animate({ scrollTop: $(document).height() }, 40000);
    setTimeout(function() {
      $('html, body').animate({scrollTop:0}, 40000); 
    },40000);
    setInterval(function(){
        // 40000 - it will take 4 secound in total from the top of the page to the bottom
    $("html, body").animate({ scrollTop: $(document).height() }, 40000);
    setTimeout(function() {
      $('html, body').animate({scrollTop:0}, 40000); 
    },40000);
        
    },8000);
    </script>

    </body>
</html>
