<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.merek') }} | {{ config('app.nama') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('style') }}/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <style media="screen">
    .bg-image{
      background-image: url("/images/bg-rsu.png");
      background-color: white;
    }

    header{
			text-align: center;
			margin: 20px auto;
			margin-left: -20px;
		}
  </style>
</head>
<body class="hold-transition login-page bg-image">
<div class="login-box">
  <div class="login-logo">
    {{-- <img src="{{ asset('images') }}/logorsud.png" alt="" width="100px" height="100px"> --}}
    <h3 class="text-center" style="color: black; font-weight: bold;">SIMRS TERINTEGRASI <br>
      {{ config('app.nama') }}
    </h3>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="background:;">
    <p class="login-box-msg" style="color: black;">Masuk dengan akun dan kata sandi Anda!</p>

    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-md-12">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
              <div class="col-md-12">
                <input id="password" type="password" class="form-control" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        {{-- <div class="form-group">
            <div class="col-md-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>
        </div> --}}

        <div class="form-group">
            <div class="col-md-4 col-md-offset-8">
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    Masuk
                </button>
            </div>
        </div>
      </form>

  </div>
  <!-- /.login-box-body -->
</div>

</body>
</html>
