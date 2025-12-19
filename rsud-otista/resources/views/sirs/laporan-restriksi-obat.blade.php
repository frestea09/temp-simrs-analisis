@extends('master')
@section('header')
  <h1>Laporan Restriksi Obat dan Kendali Biaya </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/laporan-restriksi-obat', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <br/>
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" id="" type="button">Dokter</button>
            </span>
              {!! Form::select('dokter', $dokter,null, ['class' => 'form-control select2','placeholder'=>'Pilih salah satu']) !!}
          </div>
        </div>

        <div class="col-md-4">
          <br/>
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
        </div>
        
      </div>
      <br/>
        
      </div>
      {!! Form::close() !!}
      <hr>
        @if (@$bulan)
          <h5>Grafik untuk bulan : {{ @$bulan }}</h5>
          <canvas id="line-chart" style="width: 100%; height: 300px;"></canvas>
        @endif
    </div>
  </div>

@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script>
    let resep = {!! @$resep !!};
    let hari = {!! @$hari !!}
    let xValues = [];
    let yValues = [];

    for (let index = 1; index <= hari; index++) {
      xValues.push(index);
      yValues.push('0');
    }

    for (var key in resep) {
        if (resep.hasOwnProperty(key)) {
          yValues[key-1] = resep[key];
        }
    }

    let maxHarga = Math.max(...yValues) + 100000;
    let minHarga = 0;
    
    if (xValues.length > 0) {
      new Chart("line-chart", {
        type: "line",
        data: {
          labels: xValues,
          datasets: [{
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
          }]
        },
        options: {
          legend: {display: false},
          scales: {
            yAxes: [{ticks: {min: minHarga, max:maxHarga}}],
          }
        }
      });
      
      $(".container-grafik").show();
    } else {
      $(".container-grafik").hide();
    }
  </script>
  <script>
        $('.select2').select2();
  </script>
@endsection