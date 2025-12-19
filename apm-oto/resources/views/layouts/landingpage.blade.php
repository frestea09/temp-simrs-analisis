 <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PENDAFTARAN ONLINE : {{config('app.nama_rs')}}</title>
        <link rel="icon" href="{{config('app.logo')}}" type="image/x-icon">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        {{-- <link href="{{ asset('bootstrap-4.3.1-dist/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('rsud/style.min.css') }}" rel="stylesheet">
        <link href="{{ asset('rsud/keyboard/jqbtk.min.css') }}" rel="stylesheet">
        <link href="{{ asset('bootstrap-4.3.1-dist/css/bootstrap-grid.min.css') }}" rel="stylesheet">
        <link href="{{ asset('swal/dist/sweetalert2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('style/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('style/bower_components/select2/dist/css/select2.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
        <link href="{{ asset('custom/css/custom.css') }}" rel="stylesheet">

        <!-- Styles -->
        @yield('style')
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                height: 100vh;
            }
            .wrapper {
                min-height: 80%;
            }
            .loading {
                background-color: rgb(143 143 143 / 25%) !important;
                position: fixed;
                z-index: 1;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 50 50'%3E%3Cpath d='M28.43 6.378C18.27 4.586 8.58 11.37 6.788 21.533c-1.791 10.161 4.994 19.851 15.155 21.643l.707-4.006C14.7 37.768 9.392 30.189 10.794 22.24c1.401-7.95 8.981-13.258 16.93-11.856l.707-4.006z'%3E%3CanimateTransform attributeType='xml' attributeName='transform' type='rotate' from='0 25 25' to='360 25 25' dur='0.6s' repeatCount='indefinite'/%3E%3C/path%3E%3C/svg%3E") center / 50px no-repeat;
            }
            .swal2-html-container {
                font-size: 0.8em !important;
            }
            .swal2-title{
                font-size: 1.3em !important;
            }

            .datepicker table tr td.new{
                color: #ffaa3a !important;
            }
            
        </style>
    </head>
    <body class="antialiased">
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container">
                <a class="navbar-brand" style="font-size:15px;" href="{{route('home')}}">
                    <img src="{{config('app.logo')}}" style="width:30px;" alt="">
                    {{config('app.nama_rs')}}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                  <div class="navbar-nav">
                    {{-- <a class="nav-item nav-link" href="#">Syarat & Ketentuan</a> --}}
                  </div>
                </div>
            </div>
        </nav>
        <br/>
        <div class="wrapper">
            @yield('content')
        </div>
        <footer class="mt-4 bg-light p-2 text-center">
            SIMRS &copy; {{date('Y')}}
        </footer>
    </body>
    <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
    <script src="{{ asset('/rsud/jquery.min.js') }}"></script>
    <script src="{{ asset('rsud/popper.min.js')}}"></script>
    <script src="{{ asset('/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('rsud/jqbtk.js')}}"></script>
    <script src="{{ asset('/style/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/style/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/demografi.js') }}" charset="utf-8"></script>
    <script src="{{ asset('/swal/dist/sweetalert2.all.min.js') }}" charset="utf-8"></script>
    
    <script>
        $('#default').keyboard();
        $('#number').keyboard({type:'numpad'});;
        $('.select2').select2({
            placeholder: '-- Pilih --',
            allowClear: true   // Shows an X to allow the user to clear the value.
        });
        var date = new Date();
        date.setDate(date.getDate());
        $( function() {
            $( ".datepicker" ).datepicker({
            format: "dd-mm-yyyy",
            todayHighlight: true,
            autoclose: true,
            startDate: date
            });
        });
    </script>
    @yield('script')
</html>
