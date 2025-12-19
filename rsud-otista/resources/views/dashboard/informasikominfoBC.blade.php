<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="65" />
    <title>Grafik Kunjungan</title>
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
        body {
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#258dc8+0,258dc8+100;Blue+Flat+%231 */
            background: #fafbfc;
        
        }

        #header {
            background-color: white;
            width: auto;
            height: 130px;
            border-top: 1px solid grey;
            border-bottom: 6px solid #ff220a;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e1ffff+0,e1ffff+7,e1ffff+12,e6f8fd+18,bee4f8+75,b1d8f5+100 */
            background: #e1ffff;
            /* Old browsers */
            background: -moz-linear-gradient(top, #e1ffff 0%, #e1ffff 7%, #e1ffff 12%, #e6f8fd 18%, #bee4f8 75%, #b1d8f5 100%);
            /* FF3.6-15 */
            background: -webkit-linear-gradient(top, #e1ffff 0%, #e1ffff 7%, #e1ffff 12%, #e6f8fd 18%, #bee4f8 75%, #b1d8f5 100%);
            /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, #e1ffff 0%, #e1ffff 7%, #e1ffff 12%, #e6f8fd 18%, #bee4f8 75%, #b1d8f5 100%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e1ffff', endColorstr='#b1d8f5', GradientType=0);
            /* IE6-9 */


        }

        #displayArea {
            height: auto;
            width: 100%;
            padding: 10px;
            -webkit-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            -moz-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            background-color: white;
        }

        #displayArea1 {
            height: auto;
            width: 100%;
            padding-top: 10px;
            padding-left: 10px;
            padding-right: 10px;
            -webkit-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            -moz-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            background-color: white;
        }

        #slideshow {
            float: right;
        }

        #judul {
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
            -webkit-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            -moz-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            text-shadow: 2px 2px 4px #000000;
        }

        .logo {
            width: 200px;
            float: left;
            margin-right: 20px;
        }

        .nama {
            font-weight: bold;
            padding-top: 10px;
            font-size: 25pt;
            color: #365BED;
            float: left;
            text-shadow: 1px 1px 0px #000000;

        }

        .alamat {
            font-size: 13pt;
            margin-right: 130px;
        }

        .tanggal {
            font-size: 24px;
            font-weight: bold;
            color: #365BED;
            padding-top: 35px;
            text-shadow: 1px 1px 0px #000000;
        }

        .jumlah {
            text-align: center;
        }
    </style>

<body>

<div class="row">

    <div class="col-md-12">
      <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Grafik Kunjungan Tahun 2022/2023</h3>

            </div>
            <div class="box-body">
              <div id="bar-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
      </div>
  </div>



  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Grafik Penyakit Tahun 2022/2023</h3>

            </div>
            <div class="box-body">
              <div id="bar-penyakit" style="height: 250px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
      </div>
  </div>

<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="{{ asset('style') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="{{ asset('style') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ asset('style') }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="{{ asset('style') }}/bower_components/moment/min/moment.min.js"></script>
<script src="{{ asset('style') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('style') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{{ asset('style') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('style') }}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{ asset('style') }}/dist/js/adminlte.min.js"></script>
<script src="{{ asset('style') }}/dist/js/demo.js"></script>

<!-- DataTables -->
<script src="{{ asset('style') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('style') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="{{ asset('style') }}/bower_components/Flot/jquery.flot.js"></script>
<script src="{{ asset('style') }}/bower_components/Flot/jquery.flot.resize.js"></script>
<script src="{{ asset('style') }}/bower_components/Flot/jquery.flot.categories.js"></script>
<script src="{{ asset('style') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script>
  $(function () {

    $('#data').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });

</script>
<script src="{{ asset('js/demografi.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/simrs.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/aplikasi.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/rekammedis.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/chosen.js') }}"></script>
<script src="{{ asset('js/jquery.timepicker.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/datatable.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/jquery.masknumber.js') }}"></script>

  @php
    //$polis = App\HistorikunjunganIRJ::leftJoin('polis', 'histori_kunjungan_irj.poli_id', '=', 'polis.id')->select('histori_kunjungan_irj.poli_id')->orderBy('polis.urutan','ASC')->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d').'%')->where('histori_kunjungan_irj.poli_id', '<>', '')->distinct()->get();
    
    $tga = date('2022').'-'.date('01').'-01';
    $tgb = date('2023').'-'.date('12').'-31';
   
    $poli = DB::table('histori_pengunjung')
            ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
            ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
            ->groupBy('histori_pengunjung.created_at')
            ->select('histori_pengunjung.politipe', 'histori_pengunjung.created_at',DB::raw('count(*) as total'))
            ->get();

    $irj = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'" AND jenis <> "TI" GROUP BY icd10 ORDER BY jumlah DESC limit 5');
  @endphp

  <script type="text/javascript">
  $( function() {
    var bar_data = {
       //data : [['January', 50], ['February', 8], ['March', 4], ['April', 13], ['May', 17], ['June', 9]],
       data : [
          @foreach ($poli as $r)
            ['{{ date('M', strtotime($r->created_at)) }}, Tahun {{ date('Y', strtotime($r->created_at))  }}', {{ $r->total }}],
          @endforeach
        ],

        color: '#3c8dbc'   
      }
      $.plot('#bar-chart', [bar_data], {
        grid  : {
          borderWidth: 1,
          borderColor: '#f3f3f3',
          tickColor  : '#f3f3f3'
        },
        series: {
          bars: {
            show    : true,
            barWidth: 0.9,
            align   : 'center',
          // showInputs: false
          }
        },
        xaxis: {
        mode: "categories"
    },
      })
    })
  </script>

<script type="text/javascript">
    $( function() {
      var bar_datas = {
        //  data : [['Z09.8', 10], ['012', 8], ['u.13', 4], ['o.90', 13], ['h20', 17], ['ppk', 9]],
         data : [
            @foreach ($irj as $r)
              ['{{ $r->diagnosa }}', {{ $r->jumlah }}],
            @endforeach
          ],
  
          color: '#3c8dbc'
          
        }
        $.plot('#bar-penyakit', [bar_datas], {
          grid  : {
            borderWidth: 1,
            borderColor: '#f3f3f3',
            tickColor  : '#f3f3f3'
          },
          series: {
            bars: {
              show    : true,
              barWidth: 0.9,
              align   : 'center',
            // showInputs: false
            }
          },
          xaxis: {
          mode: "categories"
      },
        })
      })
    </script>
  @stack('js')
  @yield('script')
  </body>
  </html>