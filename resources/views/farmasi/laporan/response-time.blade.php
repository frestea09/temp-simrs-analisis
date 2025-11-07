@extends('master')
@section('header')
    <h1>Farmasi - Response Time Rawat Jalan</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">

            <form method="POST" action="{{ url('farmasi/laporan-response-time') }}" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div clas="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-4">
                                    {!! Form::text('tga', $tga, ['class' => 'form-control datepicker']) !!}
                                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker']) !!}
                                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    <select name="poli_id" class="form-control select2">
                                        <option value="" selected>[Semua Poli]</option>
                                        @foreach ($poli as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" name="tampil" class="btn btn-primary btn-flat fa-file-pdf"
                                        value="TAMPILKAN">
                                    <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                                        value="EXCEL">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr />

            @if (isset($respon) && !empty($respon))
                <b>Periode : Tgl {{ $tga }} s/d {{ $tgb }}</b>
            @endif
            <br /><br />
            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id='data'>
                    <thead>
                        <tr>
                            <th width="40px" class="text-center">No</th>
                            <th class="text-center">No.RM</th>
                            <th class="text-center">Nama Pasien</th>
                            <th class="text-center">Poli</th>
                            {{-- <th class="text-center">No Resep</th> --}}
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Waktu Antri</th>
                            <th class="text-center">Waktu Masuk Resep</th>
                            <th class="text-center">Waktu Serah Obat</th>
                            <th class="text-center">Response Time</th>
                            <th class="text-center">Lama Pelayanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($respon) && !empty($respon))
                            @foreach ($respon as $no => $d)
                            @php
                                $waktu_antri = Carbon\Carbon::parse($d->created_at);
                                $waktu_masuk_resep = $d->penjualans ? Carbon\Carbon::parse($d->penjualans->created_at) : null;
                                $waktu_serah_obat = $d->antrian_dipanggil ? Carbon\Carbon::parse($d->antrian_dipanggil) : null;


                                // kolom antrian_dipanggil adalah kolom baru, jadi data sebelumnya dipastikan kolom antrian_dipanggil tidak memiliki nilai
                                if(empty($waktu_serah_obat)) {
                                    if (@$d->penjualans->created_at) {
                                        $waktu_serah_obat = (@Carbon\Carbon::parse(@$d->penjualans->created_at)->diffInSeconds(@Carbon\Carbon::parse(@$d->updated_at)) > 3) ? @Carbon\Carbon::parse(@$d->updated_at) : null;
                                    }
                                }

                                $lamaProsesObat = $waktu_masuk_resep && $waktu_serah_obat ? $waktu_masuk_resep->diffInMinutes($waktu_serah_obat) : null;
                                $lamaPelayanan = $waktu_antri && $waktu_serah_obat ? $waktu_antri->diffInMinutes($waktu_serah_obat) : null;
                            @endphp
                                <tr>
                                    <td class="text-center">{{ ++$no }}</td>
                                    <td>{{ @$d->no_rm_pasien }}</td>
                                    <td>{{ @$d->nama_pasien}}</td>
                                    <td>{{ @baca_poli($d->poli_id) }}</td>
                                    {{-- <td>-</td> --}}
                                    <td style="text-align: center">{{ $waktu_antri->format('d-m-Y') }}</td>
                                    <td style="text-align: center">{{ $waktu_antri->format('H:i') }}</td>
                                    <td style="text-align: center">{{ $waktu_masuk_resep ? $waktu_masuk_resep->format('H:i') : '-' }}</td>
                                    <td style="text-align: center">{{ $waktu_serah_obat ? $waktu_serah_obat->format('H:i') : '-' }}</td>
                                    <td style="text-align: center">{{$lamaProsesObat !== null ? $lamaProsesObat : '-'}}</td>
                                    <td style="text-align: center">{{$lamaPelayanan !== null ? $lamaPelayanan : '-'}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <ul>
                <li><strong>Waktu Antri:</strong> adalah waktu ketika dapat nomor antrian obat dari poli</li>
                <li><strong>Waktu Masuk Resep: </strong> adalah waktu ketika resep selesai di proses</li>
                <li><strong>Waktu Serah Obat: </strong> adalah ketika pasien dipanggil </li>
                <li><strong>Response Time : </strong> Durasi dari waktu masuk resep hingga waktu serah obat</li>
                <li><strong>Lama Pelayanan : </strong> Durasi dari waktu antri hingga waktu serah obat</li>
            </ul>
        </div>
        {{--  @include('frontoffice.ajax_lap_pengunjung')  --}}
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2()
    </script>
@endsection
