<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class='container-fluid'>
      <br>
      <!-- Logo dan nama -->
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-success">
            <div class="panel-body btn btn-block btn-success">
              <div class="row">
                <div class="col-md-12">
                  <h2>Ambil Antrian Rawat Jalan {{ config('app.name') }}</h2>
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
      <!-- Logo dan nama -->
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="panel-title text-center" style="font-size: 15pt;"><b>AMBIL ANTRIAN</b></h2>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-4">
                  &nbsp;
                </div>
                <div class="col-md-4 text-center">
                  @include('antrian::_touchUmum')
                </div>
                <div class="col-md-4">
                  &nbsp;
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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

  </body>
</html>
