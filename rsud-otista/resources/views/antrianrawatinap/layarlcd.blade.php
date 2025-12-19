<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nomor Antrian</title>
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
    *{
      color:black !important;
    }
      body{
        background-color: #39A7FF;
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
        color: white;
        /* text-shadow: 3px 3px 5px #000000; */
        margin-top: 3px;
        background-color: #87C4FF;
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
        background: #E0F4FF; /* Old browsers */
      }

      .loketheader{
          width: 100%;
          height: 85px;
          padding: 10px 20px;
          color: white;
          font-weight: bold;
          /* text-shadow: 3px 3px 5px #000000; */
          font-size: 34pt;
          border-bottom: 1px solid green;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,72aa00+38,8eb92a+70,9ecb2d+100 */
          background: #87C4FF; /* Old browsers */
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
        color: white;
        float: left;
        /* text-shadow: 1px 1px 0px #000000; */

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
        /* text-shadow: 1px 1px 0px #000000; */
      }
      .btn-area{
          padding-top: 20px;
          width: 100%;
          font-family: Verdana;
          color: white;
          font-size: 100pt;
          letter-spacing: -5px;
          font-weight: bold;
          /* text-shadow: 2px 2px 2px #000000; */

      }

      .font-white {
        color: white;
        font-weight: bold;
        /* text-shadow: 2px 2px 2px #000000; */
          /* letter-spacing: 5px; */
      }

      .font-antrian {
        color: white;
        font-weight: bold;
        /* text-shadow: 2px 2px 2px #000000; */
        letter-spacing: 5px;
        font-size: 30px;
      }

      .next-antrian {
        position: relative;
        left: 15px;
        background-color: #FFEED9;
        height: max-content;
      }

    </style>
  <body>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div id="judul" class="text-center">
        Antrian Loket "Rawat Inap" <br>{{ configrs()->nama }}<BR></div>
    </div>
  </div>
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
            <div class="blockloket">
                <div class="loketheader text-center">
                    LOKET 1
                </div>
                <div class="row">
                  <div class="col-sm-4 next-antrian">
                    <h3 class="font-white">Antrian Selanjutnya</h3>
                    <section id="next_antrian_1"></section>
                  </div>
                  <div class="col-sm-8">
                    <div class="btn-area text-center">
                      <div id="layarlcd">    </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
          <div class="blockloket">
              <div class="loketheader text-center">
                  LOKET 2
              </div>
              <div class="row">
                <div class="col-sm-4 next-antrian">
                  <h3 class="font-white">Antrian Selanjutnya</h3>
                  <section id="next_antrian_2"></section>
                </div>
                <div class="col-sm-8">
                  <div class="btn-area text-center">
                    <div id="layarlcd2">    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
          <div class="blockloket">
              <div class="loketheader text-center">
                  LOKET 3
              </div>
              <div class="row">
                <div class="col-sm-4 next-antrian">
                  <h3 class="font-white">Antrian Selanjutnya</h3>
                  <section id="next_antrian_3"></section>
                </div>
                <div class="col-sm-8">
                  <div class="btn-area text-center">
                    <div id="layarlcd3">    </div>
                  </div>
                </div>
              </div>
          </div>
        </div> 
      <div class="col-md-6">
          <div class="blockloket">
              <div class="loketheader text-center">
                  LOKET 4
              </div>
              <div class="row">
                <div class="col-sm-4 next-antrian">
                  <h3 class="font-white">Antrian Selanjutnya</h3>
                  <section id="next_antrian_4"></section>
                </div>
                <div class="col-sm-8">
                  <div class="btn-area text-center">
                    <div id="layarlcd4">    </div>
                  </div>
                </div>
              </div>
          </div>
        </div> 
      </div>
      
    </div>

    
    <div class="row">
      <div class="col-md-12" style="font-size: 23pt; font-weight: bold; color:white;">
        <marquee>{{ configrs()->antrianfooter }}</marquee>
      </div>
    </div>
</div>



    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- LOKET 1 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          window.location.href = "/display";
        },30000); //normal 13000
      });

      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd').load("{{ route('antrianrawatinap.datalayarlcd1') }}");
        },9000); //normal 13000
      });
    </script>

    <!-- LOKET 2 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd2').load("{{ route('antrianrawatinap.datalayarlcd2') }}");
        },9000); //normal 13000
      });
    </script>

    <!-- LOKET 3 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd3').load("{{ route('antrianrawatinap.datalayarlcd3') }}");
        },9000); //normal 13000
      });
    </script>

    <!-- LOKET 4 -->
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd4').load("{{ route('antrianrawatinap.datalayarlcd4') }}");
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

    <script>
      $(document).ready(function() {

        function myAjax() {
            $.ajax({
              url: '{{ url("/") }}/antrian-rawatinap/layarlcd/nextantrian',
              type: 'get',
              contentType: false,
              processData: false,
              success: function( result ) {
                $('#next_antrian_1').html(result.loket_a);
                $('#next_antrian_2').html(result.loket_b);
                $('#next_antrian_3').html(result.loket_c);
                $('#next_antrian_4').html(result.loket_d);
              },
              error: function(xhr, textStatus, error) {
                console.log(xhr);
                console.log(textStatus);
                console.log(error);
              }
            });
        }

        setInterval(function() {
          myAjax();
        }, 9000);

        setTimeout(function() {
          window.location.href="{{ url("/") }}/display";
        }, 30000);
      })
    </script>

  </body>
</html>
