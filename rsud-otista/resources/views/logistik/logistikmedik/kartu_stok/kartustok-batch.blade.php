@extends('master')

@section('header')
  <h1>Logistik <small>Kartu Stok Batch</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/kartustok/batch', 'class'=>'form-horizontal']) !!}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-6">
          <div class="form-group">
            <label for="masterobat_id" class="col-md-3 control-label">Nama Item</label>
            <div class="col-md-9">
              {!! Form::select('masterobat_id', $obat, null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
              <small class="text-danger">{{ $errors->first('suplesi') }}</small>
          </div>
          </div>
					<div class="form-group">
						<label for="tga" class="col-md-3 control-label">Periode</label>
						<div class="col-md-4">
              {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tga') }}</small>
						</div>
            <label for="tga" class="col-md-1 control-label">s/d</label>
						<div class="col-md-4">
							{!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tgb') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-6">
          <div class="form-group">
            <label for="gudang" class="col-sm-3 control-label">Gudang</label>
            <div class="col-sm-9">
              <input name="namagudang" value="{{ $gudang->nama }}" class="form-control" readonly />
              <input type="hidden" name="gudang_id" value="{{ $gudang->id }}" class="form-control" />
            </div>
          </div>
					<div class="form-group">
            <label for="gudang" class="col-md-3 control-label"></label>
            <div class="col-md-9">
              <input type="submit" name="view" class="btn btn-success btn-flat" value="TAMPILKAN"/>
              {{-- <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL"/>
              <input type="submit" name="cetak" class="btn btn-warning btn-flat" value="CETAK"/> --}}
            </div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
        @isset($stok)
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor Batch</th>
                    <th>Expired Date</th>
                    <th class="text-center">Masuk</th>
                    <th class="text-center">Keluar</th>
                    <th class="text-center">Saldo</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($stok as $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->created_at }}</td>
                    <td>{{ isset($d->logistik_batch) ? $d->logistik_batch->nomorbatch : '-' }}</td>
                    <td>{{ isset($d->logistik_batch) ? \Carbon\Carbon::parse($d->logistik_batch->expireddate)->format('d-m-Y') : '-' }}</td>
                    {{-- <td>{{ $d->batch_no }}</td>
                    <td>{{ $d->expired_date }}</td> --}}
                    <td class="text-center">{{ $d->masuk }}</td>
                    <td class="text-center">{{ $d->keluar }}</td>
                    <td class="text-center">{{ $d->total }}</td>
                    <td>{{ $d->keterangan }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
            
        @endisset
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2();

  $('table').DataTable();

</script>
@endsection
