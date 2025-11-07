@extends('master')

@section('header')
<h1>Laporan Registrasi Rawat Darurat</h1>
@endsection

@section('css')
    <style>
        .mb-4{
            margin-bottom: 16px;
        }
        .w-full{
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/registrasi-igd', 'class'=>'form-horizontal'])
		!!}
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-12 mb-4">
                <div class="col-md-6">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tga', $tga, [
                            'class' => 'form-control datepicker',
                            // 'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                                type="button">s/d</button>
                        </span>
                        {!! Form::text('tgb', $tgb, [
                            'class' => 'form-control datepicker',
                            // 'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="col-md-6">
                    <div class="input-group{{ $errors->has('blp') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('blp') ? ' has-error' : '' }}"
                                type="button">Bulan Pulang</button>
                        </span>
                        {!! Form::text('blp', $blp, [
                            'class' => 'form-control monthpicker',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('blp') }}</small>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                                type="button">Kasus</button>
                        </span>
                        <select name="kasus_id" class="form-control select2 " style="width: 100% ">
                            <option value="">-- SEMUA --</option>
                            <option value="anak" {{ @$kasus_id == 'anak' ? 'selected' : '' }}>Anak</option>
                            <option value="ponek" {{ @$kasus_id == 'ponek' ? 'selected' : '' }}>Ponek</option>
                            <option value="bedah" {{ @$kasus_id == 'bedah' ? 'selected' : '' }}>Bedah</option>
                            <option value="non-bedah" {{ @$kasus_id == 'non-bedah' ? 'selected' : '' }}>Non Bedah</option>
                            <option value="infeksius" {{ @$kasus_id == 'infeksius' ? 'selected' : '' }}>Infeksius</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                                type="button">Cara Masuk</button>
                        </span>
                        <select name="cara_masuk_id" class="form-control select2" style="width: 100%" >
                             <option value="">-- SEMUA --</option>
                             <option value="Datang Sendiri" {{@$cara_masuk_id == 'Datang Sendiri' ? 'selected' : ''}}>Datang Sendiri</option>
                             <option value="Rujukan Luar" {{@$cara_masuk_id == 'Rujukan Luar' ? 'selected' : ''}}>Rujukan Luar</option>
                             <option value="Petugas Kesehatan" {{@$cara_masuk_id == 'Petugas Kesehatan' ? 'selected' : ''}}>Petugas Kesehatan Lain</option>
                             <option value="KLL / Kasus Polisi" {{@$cara_masuk_id == 'KLL / Kasus Polisi' ? 'selected' : ''}}>KLL / Kasus Polisi</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                                type="button">Cara Pulang</button>
                        </span>
                        <select name="cara_pulang_id" class="form-control select2" style="width: 100%" >
                            <option value="">-- SEMUA --</option>
                            @foreach ($caraPulang as $c)
                                <option value="{{ $c->id }}" {{ ($cara_pulang_id == $c->id) ? 'selected' : '' }}>{{ $c->namakondisi }}
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
            </div>
           
            <div class="col-md-12 mb-4">
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                                type="button">Kondisi Pulang</button>
                        </span>
                        <select name="kondisi_pulang_id" class="form-control select2" style="width: 100%" >
                            <option value="">-- SEMUA --</option>
                            @foreach ($kondisiPulang as $c)
                                <option value="{{ $c->id }}" {{ ($kondisi_pulang_id == $c->id) ? 'selected' : '' }}>{{ $c->namakondisi }}
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                                type="button">Status Pasien</button>
                        </span>
                        <select name="status_pasien" class="form-control select2" style="width: 100%" >
                            <option value="">-- SEMUA --</option>
                            <option value="bpjs" {{@$status_pasien == 'bpjs' ? 'selected' : ''}}>BPJS</option>
                            <option value="non-bpjs" {{@$status_pasien == 'non-bpjs' ? 'selected' : ''}}>NON BPJS</option>
                       </select>
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}"
                                type="button">Kelompok BPJS</button>
                        </span>
                        <select name="kelompok_bpjs_id" class="form-control select2" style="width: 100%" >
                            <option value="">-- Semua --</option>
                            @foreach ($kelompok_bpjs as $c)
                                <option value="{{ $c }}" {{ ($kelompok_bpjs_id == $c) ? 'selected' : '' }}>{{ $c }}
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
               <div class="col-md-4" style="display: flex">
                    <input type="text" name="keyword"  class="form-control" placeholder="Nama/NO RM">
                    <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI">
               </div>
                <div class="col-md-4 pull-right">
                    <div class="form-group pull-right">
                        {{-- <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
                        <input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                        {{-- <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" formtarget="_blank"
                            value="CETAK"> --}}
                    </div>
                </div>
			</div>
			
		</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover' style="font-size:12px;" id="data">
				<thead>
                    <tr>
                        <td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
                    </tr>
					{{-- <tr>
						<th class="v-middle text-center" rowspan="2">No</th>
						<th class="v-middle text-center" rowspan="2" style="min-width:90px">Tanggal</th>
						<th class="v-middle text-center" rowspan="2">No. RM</th>
						<th class="v-middle text-center" rowspan="2">Nama</th>
						<th class="v-middle text-center" rowspan="2">DPJP</th>
						<th class="v-middle text-center" rowspan="2">Status Periksa</th>
						<th class="v-middle text-center" rowspan="2">Kasus</th>
						<th class="v-middle text-center" rowspan="2">Status Billing</th>
						<th class="v-middle text-center" rowspan="2">Metode Bayar</th>
						<th class="v-middle text-center" rowspan="2">Alamat</th>
						<th class="v-middle text-center" rowspan="2">Umur</th>
						<th class="v-middle text-center" rowspan="2">Jenis Kelamin</th>
						<th class="v-middle text-center" rowspan="2">No. HP</th>
						<th class="v-middle text-center" rowspan="2">Penjamin</th>
						<th class="v-middle text-center" rowspan="2">Cara Masuk</th>
						<th class="v-middle text-center" rowspan="2">Cara Pulang</th>
						<th class="v-middle text-center" rowspan="2">Kondisi Pulang</th>
						<th class="v-middle text-center" rowspan="2" style="min-width:90px">User</th>
						<th class="v-middle text-center" rowspan="2" style="min-width:90px">Keterangan</th>
					</tr> --}}
				</thead>
				<tbody>
					@foreach ($darurat as $d)
					<tr>
						<td class="text-center">{{ $no++ }}</td>
						<td class="text-center">{{ (new DateTime($d->created_at))->format('d-m-Y') }}</td>
						<td class="text-center">{{ $d->no_rm }}</td>
						<td>{{ $d->nama }}</td>
						<td>{{ baca_dokter($d->dokter_id) }}</td>
						<td>
                            {!! @json_decode(@$d->status_ugd, true)['jam_masuk'] != null ? '<span class="text-success">Sudah Diproses</span>' : '<span class="text-danger">Belum Diproses</span>' !!}
                        </td>
						<td style="text-transform: uppercase">{{ @json_decode(@$d->status_ugd, true)['kasus'] }}</td>
                        @php
                            $isNotLunas = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('lunas', 'N')->exists();
                        @endphp
						<td>{!! $isNotLunas ? '<span class="text-danger">Belum Lunas</span>' : '<span class="text-success">Sudah Lunas</span>' !!}</td>
                        @php
                            $pembayaran = App\Pembayaran::where('registrasi_id', $d->registrasi_id)->first();
                            $metode_bayar = @App\MetodeBayar::find(@$pembayaran->metode_bayar_id)->name;
                        @endphp
						<td>{{ @$metode_bayar }}</td>
						<td>{{ $d->alamat }}</td>
						<td>{{ hitung_umur($d->tgllahir) }}</td>
						<td>{{ $d->kelamin }}</td>
						<td>{{ $d->nohp }}</td>
						<td>{{ baca_carabayar($d->bayar) }}
                        @if ($d->bayar ==1)
                            ({{$d->tipe_jkn}})
                        @endif</td>
                        <td>{{  @json_decode(@$d->status_ugd, true)['caraMasuk']  }}</td>
						<td>{{ baca_carapulang($d->pulang) }}</td>
						<td>{{ baca_carapulang($d->kondisi_akhir_pasien) }}</td>
						<td class="text-center">{{ baca_user($d->user_id) }}</td>
						<td class="text-center">{{ @json_decode(@$d->status_ugd, true)['keterangan'] }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@endsection

	@section('script')

	<script type="text/javascript">
		$(document).ready(function() {
        $('.datepicker').datepicker();
        $('.select2').select2();
    });

        $('.monthpicker').datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });
	</script>
	@endsection