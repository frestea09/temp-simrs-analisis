<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Nomor Antrian</title>
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
      #loket1{
        height: 400px;
        width: 100%;
        margin:20px auto;
        background-color:none;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
        float: left;
        border-radius: 3px;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f0f9ff+0,a1dbff+100 */
        background: #f0f9ff; /* Old browsers */
        background: -moz-linear-gradient(top, #f0f9ff 0%, #a1dbff 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #f0f9ff 0%,#a1dbff 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #f0f9ff 0%,#a1dbff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f0f9ff', endColorstr='#a1dbff',GradientType=0 ); /* IE6-9 */
      }

      #loket2{
        height: 400px;
        margin:20px auto;
        width: 100%;
        background-color: none;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
        float: left;
        border-radius: 3px;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f0f9ff+0,a1dbff+100 */
        background: #f0f9ff; /* Old browsers */
        background: -moz-linear-gradient(top, #f0f9ff 0%, #a1dbff 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #f0f9ff 0%,#a1dbff 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #f0f9ff 0%,#a1dbff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f0f9ff', endColorstr='#a1dbff',GradientType=0 ); /* IE6-9 */
      }

      #judul{
        height: 70px;
        width: 100%;
        font-size: 24pt;
        font-weight: bold;
        color: white;
        margin-top: 3px;
        background-color: #365BED;
        border-top: 0;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding: 10px 20px;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        text-shadow: 2px 2px 4px #000000;
      }


      .loketheader{
          width: 100%;
          height: 65px;
          padding: 10px 20px;
          color: white;
          font-weight: bold;
          text-shadow: 2px 2px 4px #000000;
          font-size: 25pt;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#1e5799+0,2989d8+50,7db9e8+100 */
        background: #1e5799; /* Old browsers */
        background: -moz-linear-gradient(top, #1e5799 0%, #2989d8 50%, #7db9e8 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #1e5799 0%,#2989d8 50%,#7db9e8 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #1e5799 0%,#2989d8 50%,#7db9e8 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */
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
      }
      .btn-area{
          width: 100%;
          padding: 50px 100px;
      }

      .btnTouch{
          width: 100%;
          height: 125px;
          border: none;
          margin-top: 20px;
          border-bottom: 1px solid #fff;
          border-right: 1px solid #fff;
          border-radius: 3px;
          color: white;
          font-size: 15pt;
          font-weight: bold;
          text-shadow: 1px 1px 0px #000000;
          -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
          -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
          box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#3b679e+0,2b88d9+50,7db9e8+100 */
         background: #3b679e; /* Old browsers */
         background: -moz-linear-gradient(top, #3b679e 0%, #2b88d9 50%, #7db9e8 100%); /* FF3.6-15 */
         background: -webkit-linear-gradient(top, #3b679e 0%,#2b88d9 50%,#7db9e8 100%); /* Chrome10-25,Safari5.1-6 */
         background: linear-gradient(to bottom, #3b679e 0%,#2b88d9 50%,#7db9e8 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
         filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3b679e', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */
      }

    </style>
  <body>
      <div id="header">
        <div class="logo">
         <img src="{{ asset('/images/'.configrs()->logo) }}" style="height: 120px;" class="img img-responsive">
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
      <div id="judul" class="text-center">Loket Cetak Nomor Antrian</div>
    </div>
  </div>
    <div class="row">
      <div class="col-md-6">
          <div id="loket1">
              <div class="loketheader text-center">
                  LOKET 1A
              </div>
              <div class="btn-area">
                  @include('antrian::_touchUmum')
              </div>
          </div>
      </div>

      <div class="col-md-6">
          <div id="loket2">
              <div class="loketheader text-center">
                  LOKET 1B
              </div>
              <div class="btn-area">
                  @include('antrian::_touchBpjs')
              </div>
          </div>
      </div>

    </div>
</div>



  </body>
</html>
