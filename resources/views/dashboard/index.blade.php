@extends('dashboard.template')
@section('header')
	<div class="pull-left">
		<h1 style="font-size: 16pt;"> Dashboard Pelayanan {{ config('app.nama') }} Tanggal {{ tanggalkuitansi(date('d-m-Y')) }}</h1>
	</div>
  
  	<div class="pull-right">
  		<form action="{{ url('/dashboard') }}" method="POST" class="form-horizontal">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="tanggal" class="col-md-5 control-label"><span class="text-primary">Ganti Tanggal</span></label>
						<div class="col-md-7">
							<input type="text" name="tanggal" value="{{ isset($_POST['tanggal']) ? $_POST['tanggal'] : date('d-m-Y') }}" class="form-control datepicker" onchange="this.form.submit()">
						</div>
					</div>
				</div>
			</div>
		</form>
  	</div>
	
@endsection
@section('content')


  <div class="row">
  	<div class="col-md-12">
	    <div class="box box-primary">
	          <div class="box-header with-border">
	            <i class="fa fa-bar-chart-o"></i>

	            <h3 class="box-title">Grafik Kunjungan Klinik Hari Ini</h3>
				
	          </div>
	          <div class="box-body">
	            <div id="bar-chart" style="height: 350px;"></div>
	          </div>
	          <!-- /.box-body-->
	        </div>
     </div>
  </div>

  {{-- Kunjungan Klinik --}}
  <div class="row">
    <div class="col-md-6">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">
            Kunjungan Pasien Per Klinik &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Klinik</th>
                  <th class="text-center">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($poli as $d)
                  @if (!empty($d->poli_id))
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ !empty($d->poli_id) ? baca_poli($d->poli_id)  : '' }}</td>
                      <td class="text-center">{{ pasien_perpoli($tanggal, $d->poli_id) }}</td>
                    </tr>
                  @endif

                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Prosentasi Rawat Jalan, Rawat Darura dan Rawat Inap &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div id="donut-chart" style="height: 300px;"></div>
        </div>
            
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    
  </script>
@endsection