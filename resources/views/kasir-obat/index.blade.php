@extends('master')
@section('header')
    <h1>Kasir Obat Rawat Jalan</h1>

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">
        Kasir &nbsp;
      </h3> --}}
    </div>
    <div class="box-body">

      {{-- <div id="kasirRJ"> </div> --}}
      @include('kasir-obat.rawat_jalan')

    </div>
  </div>

  <!-- jQuery 3 -->
  {{-- <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      setInterval(function () {
        $('#kasirRJ').load("{{ route('kasir.rawatjalan-ajax') }}");
      },5000);
    });

  </script> --}}
@endsection
