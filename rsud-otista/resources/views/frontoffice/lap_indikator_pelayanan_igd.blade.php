@extends('master')
@section('header')
    <h1>Laporan Indikator Pelayanan IGD </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET', 'url' => 'frontoffice/laporan/indikator-pelayanan-igd', 'class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tga', \Carbon\Carbon::parse($tga)->format('d-m-Y'), [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">s/d Tanggal</button>
                        </span>
                        {!! Form::text('tgb', \Carbon\Carbon::parse($tgb)->format('d-m-Y'), [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="input-group">
                        <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
                        <input type="submit" name="excel" class="btn btn-success btn-flat "
                            value="EXCEL">
                    </div>
                </div>

            </div>
           
            {!! Form::close() !!}
            <hr>
            {{-- ================================================================================================== --}}
            @if (isset($datas))
                <div class='table-responsive'>
                    <table class='table-striped table-bordered table-hover table-condensed table' id="data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>RM</th>
                                <th>Alamat</th>
                                <th>Umur (Tahun)</th>
                                <th>JK</th>
                                <th>HP</th>
                                <th>Diagnosa</th>
                                <th>Cara Bayar</th>
                                <th>DPJP</th>
                                <th>Tgl Pelayanan</th>
                                <th>Triage</th>
                                <th>Kasus</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pelayanan</th>
                                <th>Jam Pulang</th>
                                <th>Respone Time (Menit)</th>
                                <th>Waktu Observasi (Menit)</th>
                                <th>Cara Masuk</th>
                                <th>Cara Pulang</th>
                                <th>Kondisi Pulang</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $key => $data)
                                <tr>
                                    <td >{{ $no++ }}</td>
                                    <td >{{ @$data->pasien->nama }}</td>
                                    <td >{{ @$data->pasien->no_rm }}</td>
                                    <td >{{ @$data->pasien->alamat }}</td>
                                    <td >{{ Carbon\Carbon::parse(@$data->pasien->tgllahir)->diffInYears(Carbon\Carbon::now()) }} </td>
                                    <td >{{ @$data->pasien->kelamin }}</td>
                                    <td >{{ @$data->pasien->nohp }}</td>
                                    <td >{{ @$data->registrasi->icd10s ? implode( '|', @$data->registrasi->icd10s->pluck('icd10')->toArray()) : '' }}</td>
                                    <td >{{ @$data->registrasi->cara_bayar->carabayar }}</td>
                                    <td >{{ baca_dokter(@$data->registrasi->dokter_id) }}</td>
                                    <td >{{ @$data->registrasi->created_at }}</td>
                                    <td style=" text-transform: uppercase;">
                                        {{ @json_decode(@$data->registrasi->status_ugd)->triage }}
                                    </td>
                                    <td style=" text-transform: uppercase;">
                                        {{ @json_decode(@$data->registrasi->status_ugd)->kasus }}
                                    </td>
                                    <td style=" text-transform: uppercase;">
                                        {{ @json_decode(@$data->registrasi->status_ugd)->jam_masuk }}
                                    </td>
                                    <td style=" text-transform: uppercase;">
                                        {{ @json_decode(@$data->registrasi->status_ugd)->jam_penanganan }}
                                    </td>
                                    @php
                                        $waktuPulang =  Carbon\Carbon::parse(@$data->registrasi->tgl_pulang)->format('H:i');
                                    @endphp
                                    <td >{{ @$data->registrasi->tgl_pulang ? $waktuPulang : '' }}</td>
                                    @php
                                        $differenceInMinutes = null;
                                        if(@json_decode(@$data->registrasi->status_ugd)->jam_masuk != null && @json_decode(@$data->registrasi->status_ugd)->jam_penanganan != null){
                                            $today = Carbon\Carbon::today()->toDateString();
                                            $waktuMasuk = Carbon\Carbon::parse("$today " . @json_decode(@$data->registrasi->status_ugd)->jam_masuk . ":00");
                                            $waktuPenanganan = Carbon\Carbon::parse("$today " . @json_decode(@$data->registrasi->status_ugd)->jam_penanganan . ":00");
                                            if ($waktuPenanganan < $waktuMasuk) {
                                                $waktuPenanganan->addDay();
                                            }
                                            $differenceInMinutes = $waktuPenanganan->diffInMinutes($waktuMasuk);
                                        }
                                    @endphp
                                <td >{{ @$differenceInMinutes}}</td>
                                    @php
                                        $differenceInMinutes = null;
                                        if(@$data->registrasi->tgl_pulang != null && @json_decode(@$data->registrasi->status_ugd)->jam_penanganan != null){
                                            $today = Carbon\Carbon::today()->toDateString();
                                            $waktuPulang = Carbon\Carbon::parse("$today " . $waktuPulang . ":00");
                                            $waktuPenanganan = Carbon\Carbon::parse("$today " . @json_decode(@$data->registrasi->status_ugd)->jam_penanganan . ":00");
                                            if ($waktuPenanganan > $waktuPulang) {
                                                $waktuPulang->addDay();
                                            }
                                           
                                            $differenceInMinutes = $waktuPenanganan->diffInMinutes($waktuPulang);
                                        }
                                    @endphp
                                    <td >{{ @$differenceInMinutes}}</td>
                                    <td style=" text-transform: uppercase;">
                                        {{ @json_decode(@$data->registrasi->status_ugd)->caraMasuk }}
                                    </td>
                                    <td >{{ @$data->registrasi->caraPulang->namakondisi}}</td>
                                    <td >{{ @$data->registrasi->kondisiAkhir->namakondisi}}</td>
                                    <td >
                                        {{ @json_decode(@$data->registrasi->status_ugd)->keterangan }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
        <div class="box-footer">
        </div>
    </div>

@endsection



