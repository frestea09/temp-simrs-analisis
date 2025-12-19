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

    <script type="text/javascript">
    var d,h,m,s,animate;

function init(){
  d=new Date();
  h=d.getHours();
  m=d.getMinutes();
  s=d.getSeconds();
  clock();
};

function clock(){
  s++;
  if(s==60){
      s=0;
      m++;
      if(m==60){
          m=0;
          h++;
          if(h==24){
              h=0;
          }
      }
  }
  $('sec',s);
  $('min',m);
  $('hr',h);
  animate=setTimeout(clock,1000);
};

function $(id,val){
  if(val<10){
      val='0'+val;
  }
  document.getElementById(id).innerHTML=val;
};

window.onload=init;
    </script>

    <style type="text/css" media="screen">
      body{
        background-color: #dc7103;
      }
      #header{
        background-color: white;
        background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
        width: 100%;
        /* height: 130px; */
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
          padding: 10px 20px;
          color: white;
          font-weight: bold;
          text-shadow: 1px 1px 1px #000000;
          font-size: 16pt;
          border-bottom: 1px solid green;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,72aa00+38,8eb92a+70,9ecb2d+100 */
          background: #ffaa00;
           /* Old browsers */
           /* background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%); */

      }

      #header .logo{
        height: 100%;
        margin: 5px;
        float: left;
        margin-right: 20px;
      }
      #header .logo img{
        height: 70px;
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
        color: green;
        /* text-shadow: 1px 1px 0px #000000; */
      }

      .dataPoli{
        margin-top: 15px;
        margin-left: 20px;
        line-height: 150%;
        font-size: 18pt;
        color: green;
        font-weight: bold;

      }


      .btn-huge{
            padding-top:7px;
            padding-bottom:7px;
            font-size:20pt;
            border-radius: 50px;
            border: 2px solid white;
        }
      .clock{
          text-align:center;
          width:auto;
          height:auto;
        }

        .btn-circle {
          width: 30px;
          height: 30px;
          text-align: center;
          padding: 6px 0;
          font-size: 12px;
          line-height: 1.42;
          border-radius: 15px;
        }
        .fa-remove{
          color:red;
        }
        .fa-check{
          color:green;
        }
    </style>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
     <div class="container">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
           <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         {{-- <img src="{{ asset('/images/'.configrs()->logo) }}" width="90" alt="" style="border-radius: 50%;  border: 3px solid white;"> --}}
         <img class="navbar-brand" src="{{ asset('/images/'.configrs()->logo) }}" alt="" style="border-radius: 50%;">
         <a class="navbar-brand" href="#" style="color:white;"><b>{{ config('app.nama') }}</b> |</a>
         <a class="navbar-brand" href="#" style="color:white;"><b>{{ configrs()->alamat }}</b> |</a>
         <a class="navbar-brand" href="#" style="color:white;"><b>Telp. {{ configrs()->tlp }}</b></a>
          <b><a class="navbar-brand" style="color:green;">

           <script type="text/javascript">
             show_hari();
           </script>,
           Jam
           <span id="hr">00</span>
           <span> : </span>
           <span id="min">00</span>
           <span> : </span>
           <span id="sec">00</span>
           WITA
         </a></b>
       </div>
     </div>
   </nav>
<div class="container-fluid" style="margin-top: 57px;">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-6">

        <a href="#" class="btn btn-huge btn-warning btn-lg btn-block disabled">
          <i class="fa fa-remove"></i> <b>Gigi Umum ( dr. Andrianto )</b>
        </a>
        <a href="#" class="btn btn-huge btn-warning btn-lg btn-block">
          <i class="fa fa-check"></i> <b>Gigi Umum ( dr. Andrianto )</b>
        </a>

        {{--
        <div class="box-loket">
          <div class="loketheader text-center">
            @if ($loket1->count()> 0)
              {!! Form::open(['method' => 'POST', 'url' => 'antrian/savetouch']) !!}
              {!! Form::hidden('tanggal', date('Y-m-d')) !!}
              {!! Form::hidden('kelompok', 'A') !!}
              {!! Form::submit("LOKET 1", ['class' => 'btnTouch']) !!}
              {!! Form::close() !!}
            @else
              <div style="color: white;">LOKET 1</div>
            @endif
          </div>
          <ol class="dataPoli">
            @foreach ($loket1 as $ls)
              @if ($ls->praktik == 'Y')
                <li style="color:green;">{{ strtoupper($ls->nama) }} | <i class="fa fa-check"></i> Praktik</li>
              @else
                <li style="color:red;">{{ strtoupper($ls->nama) }} | <i class="fa fa-remove"></i> Tidak Praktik</li>
              @endif
            @endforeach
          </ol>
        </div> --}}
      </div>
      <div class="col-md-6">

        <a href="#" class="btn btn-huge btn-warning btn-lg btn-block">
          <i class="fa fa-check"></i> <b>Gigi Umum ( dr. Andrianto )</b>
        </a>

        <a href="#" class="btn btn-huge btn-warning btn-lg btn-block disabled">
          <i class="fa fa-remove"></i> <b>Gigi Umum ( dr. Andrianto )</b>
        </a>
        {{--
        <div class="box-loket">
          <div class="loketheader text-center">
            @if ($loket1->count()> 0)
              {!! Form::open(['method' => 'POST', 'url' => 'antrian/savetouch']) !!}
              {!! Form::hidden('tanggal', date('Y-m-d')) !!}
              {!! Form::hidden('kelompok', 'A') !!}
              {!! Form::submit("LOKET 1", ['class' => 'btnTouch']) !!}
              {!! Form::close() !!}
            @else
              <div style="color: white;">LOKET 1</div>
            @endif
          </div>
          <ol class="dataPoli">
            @foreach ($loket1 as $ls)
              @if ($ls->praktik == 'Y')
                <li style="color:green;">{{ strtoupper($ls->nama) }} | <i class="fa fa-check"></i> Praktik</li>
              @else
                <li style="color:red;">{{ strtoupper($ls->nama) }} | <i class="fa fa-remove"></i> Tidak Praktik</li>
              @endif
            @endforeach
          </ol>
        </div> --}}
      </div>
      </div>
    </div>
    </div>
  </body>
</html>
