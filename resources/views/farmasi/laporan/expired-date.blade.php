@extends('master')
@section('header')
  <h1>Laporan - Expired Date<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    {!! Form::open(['method' => 'POST', 'url' => '/farmasi/laporan-expired-date', 'class'=>'form-horizontal']) !!}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="tahun_expired" class="col-md-3 control-label">Tahun Expired</label>
						<div class="col-md-4">
              {!! Form::text('tahun_expired', @$tahun_expired, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tahun_expired') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-6">
          <div class="form-group">
            <label for="gudang" class="col-sm-3 control-label">Gudang</label>
            <div class="col-sm-9">
              <select name="gudang_id" class="form-control select2" id="">
                <option value="">--Semua--</option>
                @foreach ($gudang as $key=>$item)
                    <option value="{{$key}}" {{@$sel_gud==$key ? 'selected' :''}}>{{$item}}</option>
                @endforeach
              </select>
            </div>
          </div>
					<div class="form-group">
            <label for="gudang" class="col-md-3 control-label"></label>
            <div class="col-md-9">
              <input type="submit" name="view" class="btn btn-success btn-flat" value="TAMPILKAN"/>
              <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL"/>
              {{-- <input type="submit" name="cetak" class="btn btn-warning btn-flat" value="CETAK"/> --}}
            </div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
    {{-- <form method="POST" action="">
      {{ csrf_field() }}
    <div class="box-header with-border">
        <input type="submit" name="excel" class="btn btn-success btn-flat" value="Excel">
    </div>
    </form> --}}
    <div class="box-body">

      <table class="table table-hover table-bordered table-condensed" id="data" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Nomor Batch</th>
            <th>Nama Obat</th>
            <th>Gudang</th>
            <th>Stok Saat Ini</th>
            <th>Expired Date</th>
            <th>Keterangan</th>
            <th>Distributor</th>
          </tr>
        </thead>
        <tbody>
          @forelse( $obat as $key => $item)
          @php

            $keterangan = '-';
            $alert = false;

            if( isset($item->expireddate) ){

              $date   = \Carbon\Carbon::parse($item->expireddate);
              $now    = \Carbon\Carbon::now();
              $day    = $date->diffInDays($now);
             
              $dueDate = \Carbon\Carbon::parse($item->expireddate);
              //$dueSoon = $dueDate->diffInDays(now()) <= 40 && $dueDate->diffInDays(now()) > 0;
              $day = @$dueDate->diffInDays(now());
              //$isPast  = $dueDate->isPast();
              if ($dueDate->isPast()) {
                $keterangan = '<label class="text-danger">Kadaluarsa '.$day.' hari yang lalu</label>'; 
                $alert = true;
              } else {
                if( $day < 40 ) {
                  $keterangan = '<label class="text-danger">Kadaluarsa '.$day.' hari lagi</label>'; 
                  $alert = true;
                }else{
                  $keterangan = 'Kadaluarsa '.$day.' hari lagi';
                  $alert = false;
                }
              }

            } 
          @endphp
          <tr style="{{ ($alert) ? 'background-color: #ff9393;' : '' }}">
            <td>{{ $key+1 }}</td>
            <td>{{ isset($item->nomorbatch) ? $item->nomorbatch : '-' }}</td>
            <td>{{ $item->nama_obat }}</td>
            <td>{{ baca_gudang_logistik($item->gudang_id) }}</td>
            <td>{{ @$item->stok }}</td>
            <td>{{ isset($item->expireddate) ?  date('d/m/Y', strtotime($item->expireddate)) : '-' }}</td>
            <td>
              {!! $keterangan !!}
            </td>
            <td>
              {{@App\Logistik\LogistikSupplier::where('id', $item->supplier_id)->first()->nama}}
            </td>
          </tr>
          @empty
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
  $('.select2').select2();
  $(".skin-blue").addClass( "sidebar-collapse" );
</script>
@endsection