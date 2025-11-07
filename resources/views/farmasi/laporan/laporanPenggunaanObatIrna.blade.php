@extends('master')

@section('header')
  <h1>Laporan Pengunaan Obat Rawat Inap</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {{-- {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/laporan-retur-obat', 'class'=>'form-horizontal']) !!}
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-md-3 control-label">Tanggal Mulai</label>
                <div class="input-group col-md-6 date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tgl_awal" class="form-control pull-right datepicker" id="tgl_mulai" value="{{ !empty($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '' }}">
                  <small class="text-danger">{{ $errors->first('tgl_awal') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Tanggal Akhir</label>
                <div class="input-group col-md-6 date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tgl_akhir" class="form-control pull-right datepicker" id="tgl_akhir" value="{{ !empty($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '' }}">
                  <small class="text-danger">{{ $errors->first('tgl_akhir') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                  <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                  <input type="submit" name="type" onclick="$('form').attr('target', '_blank');" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                  <input type="submit" name="pdf" class="btn btn-warning btn-flat fa-file-excel-o" value=" &#xf1c3; PDF"> 
                </div>
              </div>
            </div>
          </div>
        {!! Form::close() !!} --}}
        {!! Form::open(['method' => 'POST', 'url' => 'farmasi/laporan/laporan-penggunaan-obat-irna', 'class'=>'form-horizontal']) !!}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-7">
					<div class="form-group">
						<label for="tga" class="col-md-3 control-label">Periode</label>
						<div class="col-md-4">
							{!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tga') }}</small>
						</div>
						<div class="col-md-4">
							{!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tgb') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
					{{-- <input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL"> --}}
				   <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK"> 
				</div>
			</div>
		{!! Form::close() !!}
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed" id="data">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Obat</th>
                    <th>Nama Obat</th>
                    <th>Total Penggunaan</th>
                    
                  </tr>
                </thead>
                <tbody>
                    @foreach (@$penggunaan as $d)
                      <tr>
                        <td>{{ $no++ }}</td>
                  <td>{{ $d->kode_obat }}</td>
                  <td>{{ baca_obat(@$d->nama_obat) }}</td>
                  <td>{{ $d->radar }}</td>
                        
                        
                        
                       
                       
                      </tr>
                    @endforeach
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

  $('.select2').select2()

</script>
@endsection
