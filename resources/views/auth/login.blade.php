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
	<!-- Custom Styling -->
	<link rel="stylesheet" href="{{ asset('style') }}/dist/css/loginptsss.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Google Font -->
	<style media="screen">
		.my-container {
			position: fixed;
			background: #5C97FF;
			overflow: hidden;
		}
		.bg-image:after {
		  content: '';
			display: block;
			position: absolute;
			z-index: 0;
			left: 25%;
			top: 0;
			width: 50%;
			height: 100%;
			z-index: 1;
			margin: 0 auto;
			opacity: 0.2;
			background-repeat: no-repeat;
			-ms-background-size: contain;
			-o-background-size: contain;
			-moz-background-size: contain;
			-webkit-background-size: contain;
			background-size: contain;
			background-position: center center;
		}
		.login-box-msg, .register-box-msg{
			margin: 0px !important;
		}
		.login-box{
			z-index: 999;
			position: relative;
		}
		header{
			text-align: center;
			/* margin: 20px auto; */
			margin-left: -20px;
		}
		.header{
			display:-webkit-inline-box;
		}
		.rsuds{
			text-align: left;
			margin-left: 10px;
		}
		h2,h3,h4,h5{
			margin: 0;
			color: #000;
			font-weight: 600;
		}
		h3{
			font-size: 22px;
		}
		h2{
			font-size: 36px;
		}
		.info-simrs{
			position: absolute;
	    left: -103%;
	    top: 5%;
	    background: #f3f3f3;
	    padding: 15px;
	    border-radius: 5px;
	    color: #636363;
		}
		.info-simrs h4{
			text-align: center;
			margin-bottom: 10px;
	    padding-bottom: 10px;
	    color: #636363;
	    border-bottom: 1px solid #c3c3c3;
		}

		.info-simrs .info {
			background: #fff;
	    padding: 5px;
	    margin: 10px 0;
		}
	</style>
  
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  
</head>
<body class="hold-transition login-page bg-image">
	{{-- <header>
		<div class="header">

	  </div>
	</header> --}}
	<br/>
		<div class="login-box" style="margin-top:0%;">
    <div class="text-center" style="display: block;margin-bottom:20px;">
		<h4>{{ config('app.merek') }}</h4>
		<h3>{{ config('app.nama') }}</h3>

	</div>
      <div class="row loginWrapper">
        <div class="col-md-6">
          <!-- /.login-logo -->
          <div class="login-box-body align-top">
            
            <div class="text-center" style="display: block;">
				<img src="/images/{{ configrs()->logo }}" class="logoutama">
			</div>
            <div class="rsuds">
            {{-- <h3>{{ config('app.merek') }}</h3> --}}
            {{-- <h2>{{ config('app.nama') }}</h2> --}}
            {{-- <h5>{{ config('app.alamat') }}</h5> --}}
            </div>            
              
            <p class="login-box-msg"><strong>Selamat datang kembali!</strong><br/>Masuk dengan akun dan kata sandi anda</p>
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
              <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                  <div class="col-md-12 position-relative">
                      <label class="form-label" for="email">Email</label>
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
                    <div class="col-md-12 position-relative">
                      <label class="form-label" for="email">Password</label>
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
                  <div class="col-md-12">
                      <button type="submit" class="btn btn-primary btn-block btn-flat loginButton">
                          Masuk
                      </button>
                  </div>
              </div>
            </form>
            
            
            
          </div>  
          

          
        </div>  
        
        <div class="col-md-6" style="padding:0;"> 
          <div id="loginImg"></div>  
        </div>  
        
      </div> <!-- row -->
    </div> <!-- login box -->
      
      
      
	</footer>
</body>
</html>
