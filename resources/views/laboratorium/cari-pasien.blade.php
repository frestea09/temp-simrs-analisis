@extends('master')

@section('header')
    <h1>Laboratorium - Cari Pasien </h1>
    <h6 class="text-right">
        - <span class="color:red !important">*</span> Menu ini hanya digunakan untuk mencari pasien yang sudah
        <b>Teregistrasi</b><br />
        - Jika pasien belum diregistrasi terbaru, <b>harus diregistrasi</b> terlebih dahulu, jangan <b>dibilling</b> di
        registrasi yang tanggal terdahulu</h6>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                Filter Pencarian &nbsp;
            </h4>
        </div>
        <div class="box-body">

            {!! Form::open(['method' => 'POST', 'url' => 'laboratorium/cari-pasien', 'class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}"
                                type="button">Nomor RM</button>
                        </span>
                        {!! Form::text('no_rm', session('no_rm'), ['class' => 'form-control']) !!}

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('nama') ? ' has-error' : '' }}"
                                type="button">Nama</button>
                        </span>
                        {!! Form::text('nama',session('nama'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgl_lahir') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgl_lahir') ? ' has-error' : '' }}"
                                type="button">Tgl Lahir</button>
                        </span>
                        <input type="date" name="tgl_lahir" class="form-control" >
                    </div>
                </div>
                <div class="col-md-4" style="margin-top: 10px">
                    <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
                </div>
            </div>
            {!! Form::close() !!}
            <hr>

            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id='data'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>No. RM</th>
                            <th>Jenis Pasien</th>
                            <th>Tgl Registrasi</th>
                            <th>Dokter</th>
                            <th>Bangsal</th>
                            <th>Cara Bayar</th>
                            <th>Proses</th>
                            {{-- <th>LIS</th> --}}
                            <th>Cetak</th>
                            <th>Cetak Per.Jam</th>
                            <th class="text-center" style="vertical-align: middle;">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($registrasi))
                            @foreach ($registrasi as $key => $d)
                                @if ($roleUser == 'laboratorium')
                                    @if (cek_tindakan($d->id, 19) > 0)
                                        <tr class="danger">
                                        @else
                                        <tr>
                                    @endif
                                @endif

                                <td>{{ $no++ }}</td>
                                <td>{{ @$d->pasien->nama }}</td>
                                <td>{{ @$d->pasien->no_rm }}</td>
                                <td>{{ cek_jenis_reg(@$d->status_reg) }}</td>
                                <td>{{ @$d->created_at->format('d-m-Y') }}</td>
                                <td>{{ @$d->dokter_umum->nama }}</td>
                                <td>{{ @$d->rawat_inap->kamar->nama }}</td>
                                <td>{{ @$d->bayars->carabayar }}
                                    @if (!empty($d->tipe_jkn))
                                        - {{ $d->tipe_jkn }}
                                    @endif
                                </td>
                                <td>
                                    @if (cek_jenis_reg(@$d->status_reg) == 'Rawat Inap')
                                        <a href="{{ url('laboratorium/insert-kunjungan/' . $d->id . '/' . $d->pasien_id) }}"
                                            onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN LAB? KARENA AKAN MENAMBAH KUNJUNGAN LAB.')"
                                            class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                                    @elseif(cek_jenis_reg(@$d->status_reg) == 'Rawat Jalan')
                                        <a href="{{ url('/laboratorium/entry-tindakan-irj-new/' . $d->id . '/' . $d->pasien_id) }}"
                                            onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN LAB? KARENA AKAN MENAMBAH KUNJUNGAN LAB.')"
                                            class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                                    @else
                                        <a href="{{ url('laboratorium/insert-kunjungan/' . $d->id . '/' . $d->pasien_id) }}"
                                            onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN LAB? KARENA AKAN MENAMBAH KUNJUNGAN LAB.')"
                                            class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                                    @endif
                                </td>
                                {{-- <td>
                    <a href="{{ url('/emr/lab/inap/'. $d->id.'?poli='.$d->poli_id.'&dpjp='.$d->dokter_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN ORDER LIS? ')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-edit"></i></a>
                  </td> --}}

                                <td>
                                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->count() > 0)
                                        @if (cek_jenis_reg(@$d->status_reg) == 'Rawat Inap')
                                            <a href="{{ url('laboratorium/cetakRincianLab/irna/' . $d->id) }}"
                                                target="_blank" class="btn btn-danger btn-sm btn-flat"><i
                                                    class="fa fa-print"></i></a>
                                        @elseif(cek_jenis_reg(@$d->status_reg) == 'Rawat Jalan')
                                            <a href="{{ url('laboratorium/cetakRincianLab/irj/' . $d->id) }}" target="_blank"
                                                class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                                        @else
                                            <a href="{{ url('laboratorium/cetakRincianLab/ird/' . $d->id) }}" target="_blank"
                                                class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->count() > 0)
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-sm"><i
                                                    class="fa fa-print"></i></button>
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                {{-- @php
                            $folios = ;
                        @endphp --}}
                                                {{-- @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->select('created_at')->select(DB::raw('DATE(created_at) as date'))->get() as $p) --}}
                                                @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->select('created_at')->groupBy(DB::raw('hour(created_at),day(created_at)'))->orderBy('id', 'DESC')->get() as $p)
                                                    @php
                                                        $datetime = str_replace(' ', '_', date('Y-m-d H:i', strtotime($p->created_at)));
                                                    @endphp
                                                    <li>

                                                        @if (cek_jenis_reg(@$d->status_reg) == 'Rawat Inap')
                                                            <a href="{{ url('laboratorium/cetakRincianLab-pertgl/irna/' . $d->id . '/' . $datetime) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                                    class="fa fa-print"></i>
                                                                {{ date('d-m-Y H:i', strtotime($p->created_at)) }} </a>
                                                        @elseif(cek_jenis_reg(@$d->status_reg) == 'Rawat Jalan')
                                                            <a href="{{ url('laboratorium/cetakRincianLab-pertgl/irj/' . $d->id . '/' . $datetime) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                                    class="fa fa-print"></i>
                                                                {{ date('d-m-Y H:i', strtotime($p->created_at)) }} </a>
                                                        @else
                                                            <a href="{{ url('laboratorium/cetakRincianLab-pertgl/ird/' . $d->id . '/' . $datetime) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                                    class="fa fa-print"></i> {{ $p->date }} </a>
                                                        @endif


                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-flat"
                                        onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
                                </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="form">
                        <table class="table-condensed table-bordered table">
                            <tbody>
                                <tr>
                                    <th>Tanggal Order :<input class="form-control" name="waktu" redonly> </th>
                                </tr>
                                <tr>
                                    <td>
                                        <textarea name="pemeriksaan" class="form-control wysiwyg"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script type="text/javascript">
        //CKEDITOR
        $('.select2').select2();

        CKEDITOR.replace('pemeriksaan', {
            height: 200,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        });

        function coba(registrasi_id) {
            $('#pemeriksaanModel').modal({
                backdrop: 'static',
                keyboard: false,
            })
            $('.modal-title').text('Catataan Order Laboratorium')
            $("#form")[0].reset()
            CKEDITOR.instances['pemeriksaan'].setData('')
            $.ajax({
                    url: '/laboratorium/catatan-pasien/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('input[name="waktu"]').val(data.created_at)
                    CKEDITOR.instances['pemeriksaan'].setData(data.pemeriksaan)
                })
                .fail(function() {

                });
        }
    </script>
@endsection
