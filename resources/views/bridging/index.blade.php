<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h2>Test Bridging</h2>
          {!! Form::open(['method' => 'POST', 'url' => '#', 'class' => 'form-horizontal']) !!}

              <div class="form-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
                  {!! Form::label('no_jkn', 'No. <JKN>/ KIS</JKN>', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('no_jkn', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
                  </div>
              </div>
              

              <div class="btn-group pull-right">
                  {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                  {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
              </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div>

  </body>
</html>
