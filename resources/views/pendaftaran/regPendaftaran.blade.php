@extends('master')
@section('header')
	<h1>Registrasi Pendaftaran Online</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-body">
            {!! Form::model(@$data['pasien'], ['url' => ['pendaftaran/saveRegOnline', @$data['pasien']['id'], @$data['regist']['id']], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
				<input type="hidden" name="nomorantrian" value="{{@$data['regist']['nomorantrian']}}">
				<input type="hidden" name="nomorkartu" value="{{@$data['regist']['nomorkartu']}}">
				<input type="hidden" name="nohp" value="{{@$data['pasien']['nohp']}}">
				<input type="hidden" name="norm" value="{{@$data['pasien']['no_rm']}}">
				<input type="hidden" name="jeniskunjungan" value="{{@$data['regist']['jeniskunjungan']}}">
				<input type="hidden" name="nomorreferensi" value="{{@$data['regist']['no_rujukan']}}">
				<input type="hidden" name="estimasidilayani" value="{{@$data['regist']['estimasidilayani']}}">
				<input type="hidden" name="keterangan" value="{{@$data['regist']['keterangan']}}">
				<input type="hidden" name="regist_id" value="{{@$data['regist_id']}}">

				<div class="row">
					<div class="col-md-6">
						@if (session('blm_terdata') == true)
							<div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
								{!! Form::label('no_rm', 'Nomor RM', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									{!! Form::text('no_rm', $data['pasien']['no_rm'], ['class' => 'form-control']) !!}
									<small class="text-danger">{{ $errors->first('no_rm') }}</small>
								</div>
							</div>
						@endif
							<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
								{!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									{!! Form::text('nama', $data['pasien']['nama'], ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
									<small class="text-danger">{{ $errors->first('nama') }}</small>
								</div>
							</div>
							<div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">
								{!! Form::label('nik', 'NIK', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									{!! Form::text('nik', $data['pasien']['nik'], ['class' => 'form-control']) !!}
									<small class="text-danger">{{ $errors->first('nik') }}</small>
								</div>
							</div>
							<div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">
								{!! Form::label('tmplahir', 'Tmp, tgl lahir', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									<div class="row">
										<div class="col-md-5">
										{!! Form::text('tmplahir', $data['pasien']['tmplahir'], ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
											<small class="text-danger">{{ $errors->first('tmplahir') }}</small>
										</div>
										<div class="col-md-7">
										{!! Form::text('tgllahir', (!empty($data['pasien']['tgllahir'])) ? tgl_indo($data['pasien']['tgllahir']) : null, ['class' => 'form-control', 'id'=>'tgllahir']) !!}
											<small class="text-danger">{{ $errors->first('tgllahir') }}</small>
										</div>
									</div>
								</div>
							</div>
				
							<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
								{!! Form::label('alamat', 'Dsn, RT, RW', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-5">
									{!! Form::text('alamat', $data['pasien']['alamat'], ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
									<small class="text-danger">{{ $errors->first('alamat') }}</small>
								</div>
								<div class="col-sm-2">
									{!! Form::text('rt', $data['pasien']['rt'], ['class' => 'form-control', 'placeholder'=>'RT']) !!}
									<small class="text-danger">{{ $errors->first('rt') }}</small>
								</div>
								<div class="col-sm-2">
									{!! Form::text('rw', $data['pasien']['rw'], ['class' => 'form-control', 'placeholder'=>'RW']) !!}
									<small class="text-danger">{{ $errors->first('rw') }}</small>
								</div>
							</div>
				
							<div class="form-group{{ $errors->has('province_id') ? ' has-error' : '' }}">
								{!! Form::label('province_id', 'Propinsi', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									{!! Form::select('province_id', $data['provinsi'], $data['pasien']['province_id'],['class' => 'form-control select2', 'style'=>'width:100%', 'placeholder'=>' ']) !!}
									<small class="text-danger">{{ $errors->first('province_id') }}</small>
								</div>
							</div>
							<div class="form-group{{ $errors->has('regency_id') ? ' has-error' : '' }}">
								{!! Form::label('regency_id', 'Kabupaten', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									<select class="form-control select2" name="regency_id" id="regency_id">
									@if (!empty ($data['pasien']['regency_id']))
										<option value="{{ $data['pasien']['regency_id'] }}">{{ baca_kabupaten($data['pasien']['regency_id']) }}</option>
									@endif
									</select>
									<small class="text-danger">{{ $errors->first('regency_id') }}</small>
								</div>
							</div>
							<div class="form-group{{ $errors->has('district_id') ? ' has-error' : '' }}">
								{!! Form::label('district_id', 'Kecamatan', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									<select class="form-control select2" name="district_id" id="district_id">
									@if (!empty ($data['pasien']['district_id']))
										<option value="{{ $data['pasien']['district_id'] }}">{{ baca_kecamatan($data['pasien']['district_id']) }}</option>
									@endif
									</select>
									<small class="text-danger">{{ $errors->first('district_id') }}</small>
								</div>
							</div>
							<div class="form-group{{ $errors->has('village_id') ? ' has-error' : '' }}">
								{!! Form::label('village_id', 'Kelurahan', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									<select class="form-control select2" name="village_id" id="village_id">
									@if (!empty ($data['pasien']['village_id']))
										<option value="{{ $data['pasien']['village_id'] }}">{{ baca_kelurahan($data['pasien']['village_id']) }}</option>
									@endif
									</select>
								<small class="text-danger">{{ $errors->first('village_id') }}</small>
							</div>
                        </div>
                    </div>
					{{-- kolom kanan =================================================================== --}}
					<div class="col-md-6">
						<div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
							{!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::select('kelamin', ['L'=>'Laki-laki', 'P'=>'Perempuan'], $data['pasien']['kelamin'], ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
								<small class="text-danger">{{ $errors->first('kelamin') }}</small>
							</div>
						</div>
				
						<div class="form-group{{ $errors->has('nohp') ? ' has-error' : '' }}">
							{!! Form::label('nohp', 'No. HP / Tlp', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::text('nohp', $data['pasien']['nohp'] ?$data['pasien']['nohp'] :$data['regist']['no_hp'], ['class' => 'form-control']) !!}
								<small class="text-danger">{{ $errors->first('nohp') }}</small>
							</div>
						</div>
						<div class="form-group{{ $errors->has('pekerjaan_id') ? ' has-error' : '' }}">
							{!! Form::label('pekerjaan_id', 'Pekerjaan', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::select('pekerjaan_id', $data['pekerjaan'], $data['pasien']['pekerjaan_id'], ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
								<small class="text-danger">{{ $errors->first('pekerjaan_id') }}</small>
							</div>
						</div>
						<div class="form-group{{ $errors->has('agama_id') ? ' has-error' : '' }}">
							{!! Form::label('agama_id', 'Agama', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::select('agama_id', $data['agama'], $data['pasien']['agama_id'], ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
								<small class="text-danger">{{ $errors->first('agama_id') }}</small>
							</div>
						</div>
						<div class="form-group{{ $errors->has('pendidikan_id') ? ' has-error' : '' }}">
							{!! Form::label('pendidikan_id', 'Pendidikan', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::select('pendidikan_id', $data['pendidikan'], $data['pasien']['pendidikan_id'], ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
								<small class="text-danger">{{ $errors->first('pendidikan_id') }}</small>
							</div>
						</div>
				
						<div class="form-group{{ $errors->has('ibu_kandung') ? ' has-error' : '' }}">
							{!! Form::label('ibu_kandung', 'Ibu Kandung', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::text('ibu_kandung', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
								<small class="text-danger">{{ $errors->first('ibu_kandung') }}</small>
							</div>
						</div>
				
						<div class="form-group{{ $errors->has('status_marital') ? ' has-error' : '' }}">
							{!! Form::label('status_marital', 'Status Marital', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								@if (!empty($pasien->status_marital))
									<select class="form-control select2" style="width:100%" name="status_marital">
									@if ($pasien->status_marital == 'Blm Menikah')
										<option value="Blm Menikah" selected="true">Blm Menikah</option>
										<option value="Menikah">Menikah</option>
										<option value="Janda">Janda</option>
										<option value="Duda">Duda</option>
									@elseif ($pasien->status_marital == 'Menikah')
										<option value="Blm Menikah">Blm Menikah</option>
										<option value="Menikah" selected="true">Menikah</option>
										<option value="Janda">Janda</option>
										<option value="Duda">Duda</option>
									@elseif ($pasien->status_marital == 'Janda')
										<option value="Blm Menikah">Blm Menikah</option>
										<option value="Menikah">Menikah</option>
										<option value="Janda" selected="true">Janda</option>
										<option value="Duda">Duda</option>
									@elseif ($pasien->status_marital == 'Duda')
										<option value="Blm Menikah">Blm Menikah</option>
										<option value="Menikah">Menikah</option>
										<option value="Janda">Janda</option>
										<option value="Duda" selected="true">Duda</option>
									@else
										<option value="Blm Menikah">Blm Menikah</option>
										<option value="Menikah">Menikah</option>
										<option value="Janda">Janda</option>
										<option value="Duda">Duda</option>
									@endif
									</select>
								@else
									<select class="form-control select2" style="width:100%" name="status_marital">
										<option value="Blm Meninkah">Blm Menikah</option>
										<option value="Menikah">Menikah</option>
										<option value="Janda">Janda</option>
										<option value="Duda">Duda</option>
									</select>
								@endif
								<small class="text-danger">{{ $errors->first('status_marital') }}</small>
							</div>
						</div>
						<div class="form-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
							{!! Form::label('no_jkn', 'Nomor JKN', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::text('no_jkn', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
								<small class="text-danger">{{ $errors->first('no_jkn') }}</small>
							</div>
						</div>
					</div>
				</div>
				<hr/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
                            {!! Form::label('poli_id', 'Poli tujuan', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {{-- {!! Form::select('poli_id', $data['poli'], $data['regist']['kode_poli'], ['class' => 'form-control select2', 'style'=>'width:100%']) !!} --}}
								{!! Form::select('poli_id', $data['poli'], baca_id_poli($data['regist']['kode_poli']), ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                                <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                            </div>
                        </div>
						@php
							$select = \Modules\Pegawai\Entities\Pegawai::where('kode_bpjs',$data['regist']['kode_dokter'])->first();
						@endphp
                        <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                            {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
								{{-- <select class="form-control select2" name="dokter_id" id="dokter_id">
									@foreach ($data['dokter'] as $id=>$nama)
										<option {{$select->id == $id ? 'selected' : ''}} value="{{ $id }}">{{$nama}}</option>
									@endforeach
									</select> --}}
                                {!! Form::select('dokter_id', $data['dokter'], $select->id, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                                <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                            </div>
                        </div>
                    
                        <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
                            {!! Form::label('bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-5">
                                {!! Form::select('bayar', $data['carabayar'], $data['regist']['kode_cara_bayar'], ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                                <small class="text-danger">{{ $errors->first('bayar') }}</small>
                            </div>
                            <div class="col-sm-4" id="tipeJKN">
                                {!! Form::select('jkn', ['PBI'=>'PBI', 'NON PBI'=>'NON PBI'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                                <small class="text-danger">{{ $errors->first('bayar') }}</small>
                            </div>
                        </div>
                    </div>
                    {{-- =========================Kolom Kanan=========================== --}}
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('tipe_layanan') ? ' has-error' : '' }}">
                            {!! Form::label('tipe_layanan', 'Tipe Layanan', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::select('tipe_layanan', $data['tipelayanan'], 1, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                                <small class="text-danger">{{ $errors->first('tipe_layanan') }}</small>
                            </div>
                        </div>
                    
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            {!! Form::label('status', 'Status', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::select('status', $data['status'], 2, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                                <small class="text-danger">{{ $errors->first('status') }}</small>
                            </div>
                        </div>
                    
                        <div class="form-group{{ $errors->has('created_at') ? ' has-error' : '' }}">
                            {!! Form::label('created_at', 'Tanggal Periksa', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('created_at', date('d-m-Y', strtotime($data['regist']['tglperiksa'])), ['class' => 'form-control', 'id'=>'regperjanjian', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('created_at') }}</small>
                            </div>
                        </div>
						<div class="form-group{{ $errors->has('jam_praktek') ? ' has-error' : '' }}">
							{!! Form::label('jam_praktek', 'Jam Praktek', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-3">
								{!! Form::time('jam_start', explode('-',@$data['regist']['jampraktek'])[0], ['class' => 'form-control']) !!}
								<small class="text-danger">{{ $errors->first('alamat') }}</small>
							</div>
							<div class="col-sm-2">sampai</div>
							<div class="col-sm-3">
								{!! Form::time('jam_end', explode('-',@$data['regist']['jampraktek'])[1], ['class' => 'form-control']) !!}
								<small class="text-danger">{{ $errors->first('jam_end') }}</small>
							</div>
						</div>
                    
                        <div class="btn-group pull-right">
							<a href="{{ url('pendaftaran/pendaftaran-online') }}" class="btn btn-warning">Batal</a>
                            {!! Form::submit("Lanjut ", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
                        </div>
                    </div>
                </div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$('.select2').select2();
		$('select[name="bayar"]').on('change', function(e) {
			e.preventDefault();
			if ($(this).val() != 1) {
				$('#tipeJKN').addClass('hidden')
			} else {
				$('#tipeJKN').removeClass('hidden')
			}
		});
	</script>
@endsection