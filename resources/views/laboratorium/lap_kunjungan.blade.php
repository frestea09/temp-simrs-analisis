@extends('master')
@section('header')
    <h1>Laboratorium - Laporan Kunjungan<small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => '/laboratorium/laporan-kunjungan', 'class' => 'form-horizontal']) !!}

            <div class="row">
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tga', null, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Sampai Tanggal</button>
                        </span>
                        {!! Form::text('tgb', null, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                    </div>
                </div>

                <div class="col-md-3" style="padding-right: 50px">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Cara Bayar</button>
                        </span>
                        <select name="cara_bayar" id="" class="select2 form-control">
                            <option value="0" {{ $crb == 0 ? 'selected' : '' }}>Semua</option>
                            @foreach ($cara_bayar as $d)
                                <option value="{{ $d->id }}"{{ $crb == $d->id ? 'selected' : '' }}>
                                    {{ $d->carabayar }}
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('politipe') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('politipe') ? ' has-error' : '' }}"
                                type="button">Layanan</button>
                        </span>
                        {!! Form::select(
                            'pasien_asal',
                            ['TA' => 'Rawat Jalan', 'TG' => 'Rawat Darurat', 'TI' => 'Rawat Inap', '' => 'Semua'],
                            '',
                            ['class' => 'chosen-select datepicker form-control'],
                        ) !!}
                        <small class="text-danger">{{ $errors->first('politipe') }}</small>
                    </div>
                </div>

            </div>
            <br>
            <div class="row">
               
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="btn-group">
                        {{-- <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW"> --}}
                        <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                            value="EXCEL">
                    </div>
                </div>

            </div>

            {!! Form::close() !!}
            <hr>
            @isset($kunjungan)
                <h4 class="text-primary" style="margin-bottom: -10px">Total Pengunjung: {{ $jumlahPengunjung }} | Total Tindakan: {{ $jumlahTindakan }}</h4>
                <div class='table-responsive'>
                    <table id='data' class='table-striped table-bordered table-hover table-condensed table'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No. RM</th>
                                <th>Umur</th>
                                <th>Asal Pasien</th>
                                <th>Alamat</th>
                                <th>Cara Bayar</th>
                                <th>Dokter</th>
                                <th>Pemeriksaan</th>
                                <th>Waktu Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kunjungan as $key => $d)
                                {{-- {{ dd($d) }} --}}
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $d['nama_pasien'] }}</td>
                                    <td>{{ $d['no_rm'] }}</td>
                                    <td>{{ $d['umur'] }}</td>
                                    <td>
                                        @if ($d['jenis'] == 'TI')
                                            <i>Rawat Inap</i>
                                        @elseif ($d['jenis'] == 'TA')
                                            <i>Rawat Jalan</i>
                                        @elseif ($d['jenis'] == 'TG')
                                            <i>Gawat Darurat</i>
                                        @endif
                                    </td>
                                    <td>{{ @$d['alamat'] }}</td>
                                    <td>{{ $d['cara_bayar'] }}</td>
                                    <td>{{ $d['dokter'] }}</td>
                                    <td>
                                        @foreach ($d['nama_tarif'] as $item)
                                            - {{ $item }} <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $d['tanggal_kunjungan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </tbody>
                    </table>
                </div>
            @endisset

        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2()
    </script>
@endsection
