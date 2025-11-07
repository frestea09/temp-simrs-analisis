<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layar Antrian</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">

  </head>
  <body>
    <div class='well fluid-container'>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-success">
            <div class="panel-body btn btn-block btn-success">
              <div class="row">
                <div class="col-md-12">
                  <h2>Antrian Pasien Rawat Jalan {{ configrs()->nama }}</h2>
                </div>
                {{-- <div class="col-md-6">
                  <div class="pull-right">
                    <script type="text/javascript" src="{{ asset('js/tanggal.js') }}"></script>
                    <h3>
                      <script type="text/javascript">
                        show_hari();
                      </script>
                    </h3>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- =============================================================================================== --}}
      <div class="row">
        <div class="col-md-12">
          <div id="layarlcd">

          </div>
        </div>
      </div>

      {{-- =============================================================================================== --}}
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-succes ">
            <div class="panel-body btn btn-block btn-success">
              <div class="row">
                <div class="col-md-12 text-center">
                  <marquee><h2>{{ configrs()->antrianfooter }}</h2></marquee>
                </div>
                {{-- <div class="col-md-6">
                  <div class="pull-right">
                    <script type="text/javascript" src="{{ asset('js/tanggal.js') }}"></script>
                    <h3>
                      <script type="text/javascript">
                        show_hari();
                      </script>
                    </h3>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title text-center">{{ config('app.developer') }}</h3>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function () {
          $('#layarlcd').load("{{ route('antrian.datalayarlcd') }}");
        },13000);
      });

    </script>



  </body>
</html>
