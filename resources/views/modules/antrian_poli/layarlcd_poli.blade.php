<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nomor Antrian Poli</title>
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
        background-color:#3F51B5;
      }
      #header{
        background-color: white;
        width: auto;
        height: 130px;
        border-top: 1px solid grey;
        border-bottom: 6px solid green;

      }

      #judul{
        height: 150px;
        width: 100%;
        font-size: 28pt;
        font-weight: bold;
        color: green;
        margin-top: 3px;
        background-color:#3F51B5;
        border-top: 0;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding: 15px 20px;
      
        /* text-shadow: 1px 1px 2px #000000; */
      }

      .blockloket{
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
        /* background: #EEF1FF;  */
        background: white;
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
          background-color: orange;
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
      .blink_me {
        animation: blinker 4s linear infinite;
        color: #d0ae06;
      }

      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }

      
      .header_antrian{

        font-size: 90pt;
        margin-right: 20px;
        font-weight: bold;
        color: rgb(31, 20, 143);
        margin-top: 3px;
        font-family:Arial;
       
        text-shadow: 2px 2px 3px #000000;
        /*background-color: orange;*/
        }

        .dokter{

          /* font-size: 30pt;
          font-weight: bold;
          color: rgb(243, 10, 10);
          margin-top: 3px;
          font-family:Arial;
          text-shadow: 2px 2px 3px rgb(48, 3, 247); */
          margin-top: 0px;
          color: green;
          font-family:Arial;
          font-size: 28pt;
          /* font-weight: bold; */
         
        }

        .nama_antrian{

          /* width: 100% !important;
          height: 85px;
          padding: 8px 14px;
          color: rgb(22 28 22 / 58%);
          font-family:Arial;
          text-shadow: 3px 3px 5px green;
          font-size: 32pt; */

          /* font-size: 30pt;
          font-weight: bold;
          color: rgb(14, 5, 5);
          margin-top: 3px;
          font-family:Arial;
          text-shadow: 2px 2px 3px rgb(249, 3, 3) */
          margin-top: 5px;
          color: green;
          font-family:Arial;
          font-size: 30pt;
          /* font-weight: bold; */
    
      }

      .header_antrian_on{
          animation: blinker 2s linear infinite;
          color: rgb(243, 10, 10);
          font-size: 90pt;
          margin-right: 20px;
          font-weight: bold;
          margin-top: 3px;
          font-family:Arial;
          text-shadow: 2px 2px 3px #000000;
          /*background-color: orange;*/
      } 
      .nama_antrian_on{
       
        /* width: 100% !important;
        height: 85px;
        padding: 8px 14px;
        color: rgb(22 28 22 / 58%);
        font-family:Arial;
        text-shadow: 3px 3px 5px green;
        font-size: 32pt; */

        /* font-size: 30pt;
        font-weight: bold;
        color: rgb(14, 5, 5);
        margin-top: 3px;
        font-family:Arial;
        text-shadow: 2px 2px 3px rgb(249, 3, 3) */

          margin-top: 5px;
          color: orange;
          font-family:Arial;
          font-size: 30pt;
          /* font-weight: bold; */

       }

      .antrianku{
        font-size: 24px;
        color: white;
        padding: 10px;
        border: none;
        color: white;
        text-shadow: 1px 1px 1px #000000;
        /* background: #c9d0f7; */
        background: white;
        position: relative;
        font-weight: bold;
      }

      .nama{
        font-weight: bold;
        padding-top: 10px;
        font-size: 25pt;
        color: white;
        float: left;
        text-shadow: 1px 1px 0px #000000;
        /* background-image: linear-gradient(120deg, #3F51B5 0%, #673AB7 100%); */
      }
      .tanggal{
        font-size: 24px;
        font-weight: bold;
        color: white;
        padding-top: 35px;
        text-shadow: 1px 1px 0px #000000;
      }
      .nama_marquee{
        color: orange;
        font-family:Arial;
        font-size: 17pt;
        font-weight: bold;
        }
    </style>
  <body>

<div class="container-fluid">
  <div class="contents">
    <div class="row">
      <div class="col-md-12">
        <div id="judul" >
          <table class="col-md-1" style="width:100%">
            <tr>
              <td><img src="{{ asset('/images/'.configrs()->logo) }}" style="height: 90px"></td>
              <td class="nama" style="font-size:20pt">{{ configrs()->nama }}<br>{{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}</td>
              <td class="tanggal">
                {{-- <div style="font-size: small;
                float: right;
                letter-spacing: 1px;
                top: -20px;
                position: relative;
                padding: 10px;">
                  https://stmadyang.com
                </div> --}}
                <div style="float: right;
                font-size: 24px;
                font-weight: bold;
                color: white;
                padding: 20px;
                border: none;
                /* margin-top: 20px; */
                background: #c9d0f7;
                color: #3f51b5;
                /* letter-spacing: 1px; */
                text-shadow: 1px 1px 1px #000000;
             
                /* left: 240px; */
                position: relative;">
                <script type="text/javascript">
                  show_hari();
                </script>
                </td>
            </tr>
          </table>
        </div>
        <div class="col-md-12">
        <table class="col-md-1" style="width:100%">
          <tr>
            <div class="antrianku">
              <marquee class="nama_marquee">ANTRIAN RAWAT JALAN / POLI KLINIK</marquee>
            </div>
          </tr>
        </table>
       </div>
      </div>
      {{-- <div class="col-md-12">
        <div class="antrianku">
          <marquee class="nama_marquee">ANTRIAN RAWAT JALAN / POLI KLINIK</marquee>
        </div>
      </div> --}}
    </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-4">
              <div class="blockloket">
                  <div class="loketheader text-center">
                      ANAK
                  </div>
                  <div class="text-center">
                      <div id="layarlcdanak"> </div>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="blockloket">
                  <div class="loketheader text-center">
                      SYARAF
                  </div>
                  <div class="text-center">
                      <div id="layarlcdneurologi">    </div>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
            <div class="blockloket">
                <div class="loketheader text-center">
                    PENYAKIT DALAM
                </div>
                <div class="text-center">
                    <div id="layarlcdpenyakitdalam">  </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-12">
         
          {{-- <div class="col-md-4">
              <div class="blockloket">
                  <div class="loketheader text-center">
                      LOKET 4
                  </div>
                  <div class="btn-area text-center">
                      <div id="layarlcd4">   </div>
                  </div>
              </div>
          </div>
  
          <div class="col-md-4">
            <div class="blockloket">
                <div class="loketheader text-center">
                    LOKET 5
                </div>
                <div class="btn-area text-center">
                    <div id="layarlcd5">   </div>
                </div>
            </div>
        </div>
  
        <div class="col-md-4">
            <div class="blockloket">
                <div class="loketheader text-center">
                    LOKET 6
                </div>
                <div class="btn-area text-center">
                    <div id="layarlcd6">  </div>
                </div>
            </div>
        </div> --}}
        </div>
      </div>
  
       <div class="row">
        {{-- <div class="col-md-4">
            <div class="blockloket">
                <div class="loketheader text-center">
                    LOKET 4
                </div>
                <div class="btn-area text-center">
                    <div id="layarlcd4">   </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12">
       
        </div>
  
      </div> 
      {{-- <div class="row">
        <div class="col-md-12" style="font-size: 23pt; font-weight: bold; color:white;">
          <marquee>{{ configrs()->antrianfooter }}</marquee>
        </div>
      </div> --}}

      <div class="row">
        <div class="col-md-12" id="suara_antrian_tv1"></div>
      </div>

  </div>
  
</div>


    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- LOKET 1 -->
    <script type="text/javascript">
    $(document).ready(function() {
      $("html, body").animate({ scrollTop: $(document).height() }, 35000);
      setTimeout(function () {
          $('html, body').animate({ scrollTop: 0 }, 35000);
      }, 10);
      var scrolltopbottom = setInterval(function () {

          $("html, body").animate({ scrollTop: $(document).height() }, 35000);
          setTimeout(function () {
              $('html, body').animate({ scrollTop: 0 }, 35000);
          }, 100);
            }, 500);

        setInterval(function () {
          $('#layarlcdanak').load("{{ route('antrian_poli.datalayarlcdanak') }}");
        },9000); //normal 13000
      });
    </script>
     <script type="text/javascript">
      setInterval(function () {
        $('#suara_antrian_tv1').load("{{ route('antrian_poli.ajax_suara') }}");
      }, 25000);
    </script>

    <!-- LOKET 2 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcdneurologi').load("{{ route('antrian_poli.datalayarlcdneurologi') }}");
        },9000); //normal 13000
      });
    </script>

    <!-- LOKET 3 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcdpenyakitdalam').load("{{ route('antrian_poli.datalayarlcdpenyakitdalam') }}");
        },9000); //normal 13000
      });
    </script>

    <!-- LOKET 4 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd4').load("{{ route('antrian4.datalayarlcd') }}");
        },9000); //normal 13000
      });
    </script>

    <!-- LOKET 5 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd5').load("{{ route('antrian5.datalayarlcd') }}");
        },9000); //normal 13000
      });
    </script>

    <!-- LOKET 6 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd6').load("{{ route('antrian6.datalayarlcd') }}");
        },9000); //normal 13000
      });
    </script>
  </body>
</html>