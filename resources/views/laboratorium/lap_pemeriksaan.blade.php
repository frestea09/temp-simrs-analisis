@extends('master')

@section('header')
  <h1>Laporan Pemeriksaan Laboratorium</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter Laporan</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'GET', 'url' => 'laboratorium/laporan-pemeriksaan', 'class'=>'form-horizontal']) !!}
			<div class="row">
				<div class="col-md-5 col-sm-6">
					<div class="form-group">
						<label for="tga" class="col-md-3 control-label">Periode</label>
						<div class="col-md-4">
							{!! Form::text('tga', date('d-m-Y'), ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tga') }}</small>
						</div>
						<div class="col-md-4">
							{!! Form::text('tgb',date('d-m-Y'), ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tgb') }}</small>
						</div>
					</div>
				</div>
                <div class="col-md-3 col-sm-6">
                    <div class="input-group{{ $errors->has('tindakan') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                          <button class="btn btn-default{{ $errors->has('tindakan') ? ' has-error' : '' }}" type="button">Tindakan</button>
                        </span>
                        <select name="tindakan" class="form-control select2" style="width: 100%">
                            <option value="">SEMUA</option>
                           
                            @foreach ($tindakanLabs as $tindakan)
                                <option value="{{$tindakan->namatarif}}" {{request()->tindakan == $tindakan->namatarif ? 'selected' : ''}}>{{$tindakan->namatarif}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tindakan') }}</small>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="input-group{{ $errors->has('carabayar_id') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                          <button class="btn btn-default{{ $errors->has('carabayar_id') ? ' has-error' : '' }}" type="button">Penjamin</button>
                        </span>
                        <select name="carabayar_id" class="form-control select2" style="width: 100%">
                            <option value="">SEMUA</option>
                            @foreach ($carabayars as $carabayar)
                                <option value="{{$carabayar->id}}" {{request()->carabayar_id == $carabayar->id ? 'selected' : ''}}>{{$carabayar->carabayar}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tindakan') }}</small>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="input-group{{ $errors->has('pelayanan') ? ' has-error' : '' }}">
                      <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('pelayanan') ? ' has-error' : '' }}" type="button">Asal Pasien</button>
                      </span>
                      <select name="pelayanan" class="form-control select2" style="width: 100%">
                        @if (isset($_POST['pelayanan']) && $_POST['pelayanan'] == 'TA')
                          <option value="">Semua</option>
                          <option value="TA" selected="true">Rawat Jalan</option>
                          <option value="TG">Rawat Darurat</option>
                          <option value="TI">Rawat Inap</option>
                        @elseif (isset($_POST['pelayanan']) && $_POST['pelayanan'] == 'TI')
                          <option value="">Semua</option>
                          <option value="TA">Rawat Jalan</option>
                          <option value="TG">Rawat Darurat</option>
                          <option value="TI" selected="true">Rawat Inap</option>
                        @elseif (isset($_POST['pelayanan']) && $_POST['pelayanan'] == 'TG')
                          <option value="">Semua</option>
                          <option value="TA">Rawat Jalan</option>
                          <option value="TG" selected="true">Rawat Darurat</option>
                          <option value="TI">Rawat Inap</option>
                        @else
                          <option value="" selected="true">Semua</option>
                          <option value="TA">Rawat Jalan</option>
                          <option value="TG">Rawat Darurat</option>
                          <option value="TI">Rawat Inap</option>
                        @endif
                      </select>
                      <small class="text-danger">{{ $errors->first('tindakan') }}</small>
                  </div>
              </div>
				<div class="col-md-2 col-sm-6">
					{{-- <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
					<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		
      <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered table-hover table-condensed"  width="100px">
            <thead>
            {{-- <tr>
                <th class="text-center">NO</th>
                <th class="text-center">TGL DAFTAR</th>
                <th class="text-center">NO RM</th>
                <th class="text-center">NAMA PASIEN</th>
                <th class="text-center">ASAL PASIEN</th>
                <th class="text-center">TGL PEMERIKSAAN</th>
                <th class="text-center">DOKTER</th>
                <th class="text-center">PENJAMIN</th>
                <th class="text-center">JUMLAH PEMERIKSAAN LIS</th>
                <th class="text-center">PEMERIKSAAN LIS</th>
            </tr>   --}}
            </thead>
          <tbody>
            <tr>
              <td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
            </tr>
            @if ($kunjungan)
                
              @foreach ($kunjungan as $k)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ Carbon\Carbon::parse($k->registrasi->created_at)->format('d-m-Y') }} </td>
                        <td>{{ @$k->registrasi->pasien->no_rm }}</td>
                        <td>{{ @$k->registrasi->pasien->nama }}</td>
                        <td>
                        @isset($k->jenis)
                            @if($k->jenis == 'TA')
                              <i>Rawat Jalan</i>
                            @elseif($k->jenis == 'TI')
                                <i>Rawat Inap</i>
                            @else
                                <i>Gawat Darurat</i>
                            @endif
                        @endisset
                        </td>
                        {{-- <td> {{@$hasilLab->no_lab}} </td> --}}
                        <td> {{@$k->created_at}} </td>
                        {{-- <td> {{@baca_poli($k->poli_id)}} </td> --}}
                        <td> {{@baca_dokter($k->dokter_id)}} </td>
                        <td> {{baca_carabayar(@$k->registrasi->bayar)}} </td>
                        <td style="text-align: center;"> 
                          @if (is_iterable($k->hasillab))
                            @foreach ($k->hasillab as $hasilLab)
                              @php
                                $tp = 0;
                                $tp += $hasilLab->total_pemeriksaan;
                              @endphp
                              {{$tp}}
                            @endforeach
                          @else
                            0
                          @endif
                        </td>
                        <td> 
                          @if (is_iterable($k->hasillab))
                            @foreach ($k->hasillab as $hlab)
                              Nomor Lab : <b>{{$hlab->no_lab}}</b>
                              <br>
                              <br>
                              @if (is_iterable($hlab->jenis_pemeriksaan))
                                <ul>
                                  @forelse ($hlab->jenis_pemeriksaan as $key => $jenis_pemeriksaan)
                                    <li><b>{{$key}}</b></li>
                                    @if (is_iterable($jenis_pemeriksaan))
                                      @foreach ($jenis_pemeriksaan as $pem)
                                        - {{$pem->test_name}} <br>
                                      @endforeach
                                    @endif
                                  @empty
                                  -
                                  @endforelse
                                </ul>
                              @endif
                              <br>
                              <hr style="color: black;">
                              <br>
                            @endforeach
                          @endif
                        </td>
                        {{-- <td>{{@baca_carabayar(@$k->jenis_pasien)}}</td> --}}
                    </tr>
              @endforeach
            @endif
          </tbody> 
        </table>
        @if ($kunjungan)
          {{$kunjungan->appends(['tga' => request('tga'), 'tgb' => request('tgb'),  'tindakan' => request('tindakan'), 'carabayar_id' => request('carabayar_id'), 'submit' => 'TAMPILKAN'])->links()}}
        @endif
      </div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
		$('#table').DataTable();
      	$('.datepicker').datepicker();
      	$('.select2').select2();
    });
  </script>
@endsection
