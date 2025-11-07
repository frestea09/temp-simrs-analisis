@extends('master')
@section('header')
    <h1>Riwayat Status Registrasi Pasien</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">

            <div class="row">
                <div class="col-md-4">
                    {!! Form::open(['method' => 'GET', 'url' => 'pasien/riwayat-status-pasien', 'class' => 'form-horizontal']) !!}
                    <div class="col-md-8">
                        <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}"
                                    type="button">NO
                                    RM</button>
                            </span>
                            {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-xl btn-success">CARI</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table-condensed table-bordered table-hover table">
                            <tbody>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ !empty($pasien) ? $pasien->nama : null }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor RM Baru</th>
                                    <td><b>{{ !empty($pasien) ? $pasien->no_rm : null }}</b></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ !empty($pasien) ? $pasien->alamat : null }} rt:
                                        {{ !empty($pasien) ? $pasien->rt : null }} rw:
                                        {{ !empty($pasien) ? $pasien->rw : null }}</td>
                                </tr>
                                <tr>
                                    <th>Ibu Kandung</th>
                                    <td>{{ !empty($pasien) ? $pasien->ibu_kandung : null }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id='data' style="font-size:12px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Cara Bayar</th>
                            <th>Poli</th>
                            <th>BED</th>
                            <th>Cara pulang</th>
                            <th>Mutasi</th>
                            <th>User Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history->groupBy('registrasi_id') as $regs)
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($regs as $status)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($status->created_at)) }}</td>
                                    <td>
                                        @switch($status->status)
                                            @case('J1')
                                                {{ 'Antrian Rawat Jalan - J1' }}
                                            @break

                                            @case('J2')
                                                {{ 'Rawat Jalan - J2' }}
                                            @break

                                            @case('J3')
                                                {{ 'Pulang Rawat Jalan - J3' }}
                                            @break

                                            @case('G1')
                                                {{ 'Triage Rawat Darurat - G1' }}
                                            @break

                                            @case('G2')
                                                {{ 'Rawat Darurat - G2' }}
                                            @break

                                            @case('G3')
                                                {{ 'Pulang Rawat Darurat - G3' }}
                                            @break

                                            @case('I1')
                                                {{ 'Antrian Rawat Inap - I1' }}
                                            @break

                                            @case('I2')
                                                {{ 'Rawat Inap - I2' }}
                                            @break

                                            @case('I3')
                                                {{ 'Pulang Rawat Inap - I3' }}
                                            @break

                                            @default
                                                {{ $status->status }}
                                        @endswitch
                                    </td>
                                    <td>{{ baca_carabayar($status->registrasi->bayar) }}</td>
                                    <td>{{ $status->nama_poli }}</td>
                                    <td>{{ $status->nama_bed }}</td>
                                    <td>{{ @baca_carapulang($status->registrasi->kondisi_akhir_pasien) }}</td>
                                    <td>
                                        @if (str_contains($status->status,'I'))
                                            @php
                                                $mutasi = \App\HistoriRawatInap::where('registrasi_id',$status->registrasi_id)->orderBy('id','DESC')->get();
                                            @endphp
                                            @foreach ($mutasi as $item)
                                                - {{baca_bed($item->bed_id)}}<br/>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $status->username }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="9" class="text-center">
                                    <hr />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2()
        $(".skin-blue").addClass("sidebar-collapse");
    </script>
@endsection
