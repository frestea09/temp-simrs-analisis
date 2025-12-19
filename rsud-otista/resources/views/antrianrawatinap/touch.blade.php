<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300"/>
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
        background-color: #dc7103;
      }
      #header{
        background-color: white;
        background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
        width: 100%;
        height: 130px;
        border-top: 1px solid grey;
        border-bottom: 6px solid orange;

      }

      #loket2{
        height: 350px;
        margin:30px auto;
        width: 100%;
        background-color: none;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
        float: left;
        border-radius: 3px;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f8ffe8+0,e3f5ab+0,b7df2d+100 */
        background: #f8ffe8; /* Old browsers */
        background: -moz-linear-gradient(top, #f8ffe8 0%, #e3f5ab 0%, #b7df2d 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #f8ffe8 0%,#e3f5ab 0%,#b7df2d 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #f8ffe8 0%,#e3f5ab 0%,#b7df2d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8ffe8', endColorstr='#b7df2d',GradientType=0 ); /* IE6-9 */
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

      .loketheader{
          width: 100%;
          height: 100px;
          color: white;
          font-weight: bold;
          text-shadow: 1px 1px 1px #000000;
          font-size: 16pt;
          border-bottom: 1px solid white;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,72aa00+38,8eb92a+70,9ecb2d+100 */
          background: #ffaa00;
           /* Old browsers */
           /* background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%); */

      }

      #header .logo{
        height: 80%;
        margin: 5px;
        float: left;
        margin-right: 10px;
      }
      #header .logo img{
        height: 80%;
      }
      .nama{
        font-weight: bold;
        padding-top: 20px;
        font-size: 25pt;
        color: white;
        float: left;
        text-shadow: 3px 3px 5px #000000;

      }

      .alamat{
        font-size: 13pt;
        margin-right: 130px;
      }
      .tanggal{
        font-size: 24px;
        font-weight: bold;
        color: white;
        padding-top: 35px;
        text-shadow: 3px 3px 5px #000000;
        padding-right: 35px;
      }
      .box-loket{
        height: 350px;
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
        background: #ffbf1e; /* Old browsers */
      }
      .btn-area{
          width: 100%;
          padding: 40px 80px;
      }

      .btnTouch{
          width: 100%;
          height: 370px;
          border: none;
          margin-top: 0px;
          border-radius: 3px;
          color: black;
          font-size: 32pt;
          font-weight: 800;
          letter-spacing: 1px;
           text-shadow: 1px 1px 1px #000000;
          -webkit-box-shadow: 0px 2px 20px 0px rgb(255, 255, 255);
          -moz-box-shadow: 0px 2px 20px 0px rgb(255, 255, 255);
          box-shadow: 0px 2px 20px 0px rgb(255, 255, 255);
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,8eb92a+48,9ecb2d+100 */
            background: #0da81d; /* Old browsers */
      }

      .kuotaHabis{
        width: 100%;
        height: 40px;
        border: none;
        margin-top: 00px;
        background-color: red;
        border-bottom: 1px solid #fff;
        border-right: 1px solid #fff;
        border-radius: 3px;
        color: white;
        font-size: 10pt;
        font-weight: bold;
        text-shadow: 1px 1px 0px #000000;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
      }

      .sisaKuota{
        margin: 5px;
        font-size: 13pt;
        font-weight: bold;
        color: white;
        /* text-shadow: 1px 1px 0px #000000; */
      }

      .dataPoli{
        margin-top: 15px;
        margin-left: 20px;
        line-height: 150%;
        font-size: 18pt;
        color: white;
        font-weight: bold;

      }

      .list-loket {
        font-size: 30px;
        font-weight: bold;
        color: white;
        text-shadow: 1px 1px 1px #000000;
      }

      .ul-none{
        list-style: none;
      }

    </style>
  <body>
      <div id="header">
        <div class="logo">
          <img src="{{ asset('/images/'.configrs()->logo) }}" class="img img-responsive"  style="border-radius: 50%; margin-top:15px;  border: 3px solid white;">
        </div>
        <div class="nama">
          {{ config('app.nama') }} <br> 
          <div class="alamat"> 
            {{-- {{ configrs()->pt }} 
            <br> --}}
             {{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}</div>
        </div>
        <div class="tanggal pull-right">
          <script type="text/javascript">
            show_hari();
          </script>
          <p>"Antrian Rawat Inap"</p>
        </div>
      </div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-6">
        <div class="box-loket">
        
              {!! Form::open(['method' => 'POST', 'url' => 'antrianrawatinap/savetouch']) !!}
              {!! Form::hidden('tanggal', date('Y-m-d')) !!}
              {!! Form::hidden('kelompok', 'A') !!}
              <button type="submit" class="btnTouch">A <br>KASIR<br>(SIP dan Pembayaran)</button>
              {{-- {!! Form::submit("A (IGD)", ['class' => 'btnTouch']) !!} --}}
              {!! Form::close() !!}
          
          {{-- <div>
            <ul class="ul-none">
              <li class="list-loket">Umum</li>
            </ul>
          </div> --}}
        </div>
      </div>
      <div class="col-md-6">
        <div class="box-loket">
        
              {!! Form::open(['method' => 'POST', 'url' => 'antrianrawatinap/savetouch']) !!}
              {!! Form::hidden('kelompok', 'B') !!}
              {!! Form::hidden('tanggal', date('Y-m-d')) !!}
              <button type="submit" class="btnTouch">B <br>(INAP)</button>
              {{-- {!! Form::submit("B (RAJAL)", ['class' => 'btnTouch']) !!} --}}
              {!! Form::close() !!}
        </div>
      </div>
    </div>

     <div class="col-md-12">
      <div class="col-md-6">
        <div class="box-loket">
        
              {!! Form::open(['method' => 'POST', 'url' => 'antrianrawatinap/savetouch']) !!}
              {!! Form::hidden('tanggal', date('Y-m-d')) !!}
              {!! Form::hidden('kelompok', 'C') !!}
              <button type="submit" class="btnTouch">C <br>(BPJS / SKTN)</button>
              {{-- {!! Form::submit("", ['class' => 'btnTouch']) !!} --}}
              {!! Form::close() !!}

        </div>
      </div>

      <div class="col-md-6">
        <div class="box-loket">
        
              {!! Form::open(['method' => 'POST', 'url' => 'antrianrawatinap/savetouch']) !!}
              {!! Form::hidden('tanggal', date('Y-m-d')) !!}
              {!! Form::hidden('kelompok', 'D') !!}
              <button type="submit" class="btnTouch">D <br>(RAJAL)</button>
              {{-- {!! Form::submit("", ['class' => 'btnTouch']) !!} --}}
              {!! Form::close() !!}

        </div>
      </div>
      
    </div>
     
    
  </div>

 

  </body>
</html>
