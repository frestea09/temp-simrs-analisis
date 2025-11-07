@extends('dashboard.template')
@section('header')
  <h1 style="font-size: 16pt;"> Informasi Ketersediaan Tempat Tidur {{ config('app.nama') }} Tanggal {{ tanggalkuitansi(date('d-m-Y')) }}</h1>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
            <div class="box-body">
              <div class='table-responsive'>
                <div id="displayBed" style="height: calc(100% - 230px)"></div>
              </div>
            </div>
            <!-- /.box-body-->
          </div>
     </div>
  </div>
@endsection

@section('script')
<script>
  $(document).ready(function() {
    setInterval(function () {
      $('#displayBed').load("{{ url('/bed/display-bed') }}");
    },1000); //defaul: 10000
  });
</script>
    
@endsection
