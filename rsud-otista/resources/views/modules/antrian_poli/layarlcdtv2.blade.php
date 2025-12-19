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
      body{
        background-color:#3F51B5;
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
        font-size: 20pt;
        font-weight: bold;
        color: white;
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
        background-image: linear-gradient(120deg, #3F51B5 0%, #673AB7 100%);
      }

      .header_antrian{

        font-size: 70pt;
        margin-right: 20px;
        font-weight: bold;
        color: rgb(243, 10, 10);
        margin-top: 3px;
        font-family:Arial;
        box-shadow: 0px 1px 5px 0px orange;
        text-shadow: 2px 2px 3px #000000;
        /*background-color: orange;*/
        }

        .header_antrian_on{
          animation: blinker 13s linear infinite;
          color: rgb(31, 20, 143);
          font-size: 70pt;
          margin-right: 20px;
          font-weight: bold;
          /*color: orange;*/
          margin-top: 3px;
          box-shadow: 0px 1px 5px 0px orange;
          font-family:Arial;
          /*background-color: orange;*/
        }

        .nama_antrian{
        width: 100% !important;
        height: 85px;
        padding: 8px 14px;
        color: rgb(22 28 22 / 58%);
        font-family:Arial;
        /* font-weight: bold; */
        text-shadow: 3px 3px 5px green;
        font-size: 32pt;
        /* font-weight: bold; */

        }

        .nama_marquee{
        color: green;
        font-family:Arial;
        font-size: 17pt;
        font-weight: bold;
        }

        .nama_antrian_on{
       
       width: 100% !important;
       height: 85px;
       padding: 8px 14px;
       color: rgb(22 28 22 / 58%);
       font-family:Arial;
       /* font-weight: bold; */
       text-shadow: 3px 3px 5px green;
       font-size: 32pt;
       /* font-weight: bold; */

       }

      .blockloket{
        /* height: 350px; */
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
        background: #c9d0f7; /* Old browsers */
        height: 295px !important;
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
          background-color: orange;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,72aa00+38,8eb92a+70,9ecb2d+100 */
         
      }

  
      .logo{
        width: 150px;
        float: left;
        margin-right: 20px;
        padding: 10px;
        position: relative;
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
      .alamat{
        font-size: 13pt;
        margin-right: 130px;
      }
      .tanggal{
        font-size: 24px;
        font-weight: bold;
        color: white;
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

      .headerku {
        background-image: linear-gradient(120deg, #3F51B5 0%, #673AB7 100%);
    -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
    -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
    box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
      }

      .antrianku{
        font-size: 24px;
        color: white;
        padding: 10px;
        border: none;
        color: white;
        text-shadow: 1px 1px 1px #000000;
        background: #c9d0f7;
        position: relative;
        font-weight: bold;
      }

      .no_antrian {
        margin-top: 20px;
        position: relative;
        font-size: 30px;
        font-weight: 700;
        color: #000f63;
      }
      .panggil_antrianku{
        position: relative;
    font-size: 100px;
    font-weight: 700;
    color: #000f63;
      }
      .panah{
        position: relative;
    font-size: 50px;
    font-weight: 900;
    height: 100px;
    line-height: 200px;
    text-align: center;
    color: #000f63;
    /* border: 2px dashed #f69c55; */
      }

      .footer {
   /* position: fixed; */
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: red;
   color: white;
   text-align: center;
   padding: 10px;
    }

   .infoku{
    position: absolute;
    padding: 12.5px;
    /* left: 10px; */
    z-index: 100;
    margin-left: -10px;
    margin bottom: 1;
    top: auto;
    background-color: darkblue;
    margin-top: -10px;
    letter-spacing: 2px;
   }

   .textku{
    font-size: 17px;
    font-weight: 800;
    color: #000f63;
   }


      .blink_me {
        animation: blinker 1s linear infinite;
        color: #d0ae06;
      }

      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }


    </style>
  <body>
    <div class="row">
      <div class="col-md-12 headerku">
        <div class="logo">
          <img src="{{ asset('/images/'.configrs()->logo) }}" class="img img-responsive">
        </div>
        <div class="nama">
          <br>{{ configrs()->nama }}<br> <div class="alamat"> {{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}</div>
          </div>
          <div class="tanggal">
            {{-- <div style="font-size: small;
            float: right;
            letter-spacing: 1px;
            top: -20px;
            position: relative;
            padding: 10px;">
              https://stmadyang.com
            </div> --}}
            <div style="    float: right;
            font-size: 24px;
            font-weight: bold;
            color: white;
            padding: 20px;
            border: none;
            /* margin-top: 20px; */
            color: #3f51b5;
            /* letter-spacing: 1px; */
            text-shadow: 1px 1px 1px #000000;
            background: #c9d0f7;
            /* left: 240px; */
            position: relative;">
            <script type="text/javascript">
              show_hari();
            </script>
            </div>
          </div>
      </div>
      <div class="col-md-12">
        <div class="antrianku">
          <marquee class="nama_marquee">ANTRIAN RAWAT JALAN / POLI KLINIK</marquee>
        </div>
      </div>
    </div>


<div class="container-fluid">

    <div class="contents">
        {{-- <div class="row">
          <div class="col-md-12">
            <div class="text-center">
              <h1 style="color:white"><b>ANTRIAN POLI<b></h1></div>
          </div>
        </div> --}}
          <div class="row">

            <div class="col-md-12">
              <div class="col-md-4">
                  <div class="blockloket">
                      <div class="loketheader text-center">
                          BEDAH
                      </div>
                      <div class="btn-area text-center">
                        <table class="col-md-5 text-center" style="width:100%">
                            @foreach($data['grid']['grid1'] as $key => $item)
                            @if($item['id'] == 12)
                            <tr>
                                <td class="textkutv1 text-center" id="layarlcd{{ $item['id'] }}">  </td>
                              {{-- <td class="textku" style="font-size: 40pt">{{ $item['nama'] }}</td> --}}
                            </tr>
                            @endif
                            @endforeach
                          </table>
                      </div>
                  </div>
              </div>
      
              <div class="col-md-4">
                <div class="blockloket">
                    <div class="loketheader text-center">
                        KEBIDANAN
                    </div>
                    <div class="btn-area text-center">
                        <table class="col-md-5 text-center" style="width:100%">
                            @foreach($data['grid']['grid1'] as $key => $item)
                            @if($item['id'] == 11)
                            <tr>
                                <td class="textkutv1 text-center" id="layarlcd{{ $item['id'] }}"> </td>
                              {{-- <td class="textku" style="font-size: 40pt">{{ $item['nama'] }}</td> --}}
                            </tr>
                            @endif
                            @endforeach
                          </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="blockloket">
                    <div class="loketheader text-center">
                        GIGI
                    </div>
                    <div class="btn-area text-center">
                        <table class="col-md-5 text-center" style="width:100%">
                            @foreach($data['grid']['grid1'] as $key => $item)
                            @if($item['id'] == 8)
                            <tr>
                                <td class="textkutv1 text-center" id="layarlcd{{ $item['id'] }}"> </td>
                              {{-- <td class="textku" style="font-size: 40pt">{{ $item['nama'] }}</td> --}}
                            </tr>
                            @endif
                            @endforeach
                          </table>
                    </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-4">
                  <div class="blockloket">
                      <div class="loketheader text-center">
                          MCU/KARYAWAN
                      </div>
                      <div class="btn-area text-center">
                        <table class="col-md-5 text-center" style="width:100%">
                            @foreach($data['grid']['grid1'] as $key => $item)
                            @if($item['id'] == 20)
                          
                            <tr>
                                <td class="textkutv1 text-center" id="layarlcd{{ $item['id'] }}"> </td>
                              {{-- <td class="textku" style="font-size: 40pt">{{ $item['nama'] }}</td> --}}
                            </tr>
                            @endif
                            @endforeach
                          </table>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="blockloket">
                      <div class="loketheader text-center">
                          UMUM
                      </div>
                      <div class="btn-area text-center">
                        <table class="col-md-5 text-center" style="width:100%">
                            @foreach($data['grid']['grid1'] as $key => $item)
                            @if($item['id'] == 17)
                            <tr>
                              <td class="textkutv1 text-center" id="layarlcd{{ $item['id'] }}"> </td>
                              {{-- <td class="textku" style="font-size: 40pt">{{ $item['nama'] }}</td> --}}
                            </tr>
                            @endif
                            @endforeach
                          </table>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                <div class="blockloket">
                    <div class="loketheader text-center">
                        THT
                    </div>
                    <div class="btn-area text-center">
                        <table class="col-md-5 text-center" style="width:100%">
                            @foreach($data['grid']['grid1'] as $key => $item)
                            @if($item['id'] == 7)
                            <tr>
                                <td class="textkutv1 text-center"  id="layarlcd{{ $item['id'] }}">  </td>
                              {{-- <td class="textku" style="font-size: 40pt">{{ $item['nama'] }}</td> --}}
                            </tr>
                            @endif
                            @endforeach
                          </table>
                    </div>
                </div>
              </div>
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
      </div>
      
</div>

{{-- <div class="footer">
  <div class="infoku">Informasi</div>
  <div><marquee>{{ configrs()->antrianfooter }}</marquee></div>
</div> --}}

    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <script>
      let data_poli = '{!! $poli !!}';

      var poli_arr = [];
      // JSON.parse(data_poli).forEach(function(item) {
      //   poli_arr.push(item.id);
      // });
    
      console.log(poli_arr,'panggilan ini')
      setInterval(function () {
        getAntrianTerakhir();
        getDisplay();
        JSON.parse(data_poli).forEach(function(item) {
          poli_arr.push(item.id);
        });
      }, 9000);

      function getDisplay(){
        $.ajax({
          url: "{{ url('antrian_poli/getdisplay') }}",
          type: "POST",
          data: { "poli" : poli_arr, "_token": "{{ csrf_token() }}", },
          cache: false,
          dataType: "json",
          success: function(res){
            $.each(res.data, function (key, val) {
              $('table').find('#layarlcd'+key).html(val); 
              // $('table').find('#layarlcdumum'+key).html(val); 
              // $('table').find('#layarlcdtht'+key).html(val);
              // $('table').find('#layarlcdbedah'+key).html(val); 
              // $('table').find('#layarlcdbidan'+key).html(val);
              // $('table').find('#layarlcdgigi'+key).html(val);
            });
          }
        });
      }

      function getAntrianTerakhir(){
         console.log('ini antrian akhir')
        // $('#panggilan_terakhir').load("{{ url('antrian_poli/antrian_terakhir') }}");
        $.ajax({
          url: "{{ url('antrian_poli/antrian_terakhir') }}",
          type: "GET",
          cache: false,
          dataType: "json",
          success: function(res){
            $('#panggilan_terakhir').html(res.antrian);
            $('#nama_poli').html(res.poli);
          }
        });
      }
    </script> 

  </body>
</html>

<style>

.textkutv1 {
    font-size: 17px;
    font-weight: 800;
    color: #000f63;
    /* text-align: center; */
    padding-left: 12px !important;
}
</style>