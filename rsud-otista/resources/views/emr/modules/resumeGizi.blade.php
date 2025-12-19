@extends('master')
@section('header')
    <h1>{{ baca_unit($unit) }} - Data Resume <small></small></h1>
@endsection

@section('content')
    @include('emr.modules.addons.profile')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Data Resume</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @include('emr.modules.addons.tab-gizi')
                </div>
            </div>
            
            {{-- CPPT --}}
            <div class='table-responsive'>
                <h4>Histori CPPT Gizi</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelCPPTGizi">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Dibuat</th>
                            <th>Pembuat</th>
                            <th>Ruangan</th>
                            <th>Pratinjau</th>
                            <th>TTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomor = 1;
                        @endphp
                        @foreach ($cppt as $key => $p)
                            @php
                                $pegawai = Modules\Pegawai\Entities\Pegawai::where('user_id', $p->user_id)->first();
                            @endphp
                            <tr>
                                <td>{{ $nomor++  }}</td>
                                <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                <td>
                                    {{$pegawai->nama}}
                                </td>
                                <td>
                                    {{baca_kamar($p->kamar_id)}}
                                </td>
                                <td>
                                    <a href="{{ url('cetak-cppt-gizi/pdf/' . @$p->registrasi_id . '/' . @$p->id) }}"
                                        target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                            class="fa fa-print"></i> </a>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm btn-flat proses-tte-cppt" data-id="{{$p->id}}" data-regid="{{$p->registrasi_id}}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    @if (!empty($p->tte))
                                        <a href="{{ url('/dokumen_tte/' . @$p->tte) }}"
                                            target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- SKRINING --}}
            <div class='table-responsive'>
                <h4>Histori Skrining Gizi</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelSkrining">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Dibuat</th>
                            <th>Pembuat</th>
                            <th>Jenis Skrining</th>
                            <th>Pratinjau</th>
                            <th>TTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomor = 1;
                        @endphp
                        @foreach ($skrining as $key => $p)
                            @php
                                $pegawai = Modules\Pegawai\Entities\Pegawai::where('user_id', $p->user_id)->first();
                            @endphp
                            <tr>
                                <td>{{ $nomor++  }}</td>
                                <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                <td>
                                    {{$pegawai->nama}}
                                </td>
                                <td>
                                    {{$p->jenis}}
                                </td>
                                <td>
                                    @if ($p->jenis == "Skrining Gizi Dewasa")
                                        <a href="{{ url('cetak-skrining-gizi-dewasa/pdf/' . @$p->registrasi_id . '/' . @$p->id) }}"
                                            target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @elseif ($p->jenis == "Skrining Gizi Anak")
                                        <a href="{{ url('cetak-skrining-gizi-anak/pdf/' . @$p->registrasi_id . '/' . @$p->id) }}"
                                            target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @elseif ($p->jenis == "Skrining Gizi Maternitas")
                                        <a href="{{ url('cetak-skrining-gizi-maternitas/pdf/' . @$p->registrasi_id . '/' . @$p->id) }}"
                                            target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @elseif ($p->jenis == "Skrining Gizi Perinatologi")
                                        <a href="{{ url('cetak-skrining-gizi-perinatologi/pdf/' . @$p->registrasi_id . '/' . @$p->id) }}"
                                            target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm btn-flat proses-tte-skrining-gizi" data-id="{{$p->id}}" data-jenis="{{$p->jenis}}" data-regid="{{$p->registrasi_id}}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    @if (!empty(@json_decode(@$p->tte, true)['tte_skrining_gizi']))
                                        <a href="{{ url('/dokumen_tte/' . @json_decode(@$p->tte, true)['tte_skrining_gizi']) }}"
                                            target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PENGKAJIAN GIZI --}}
            <div class='table-responsive'>
                <h4>Histori Pengkajian Gizi</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelPengkajian">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Dibuat</th>
                            <th>Pembuat</th>
                            <th>Pratinjau</th>
                            <th>TTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomor = 1;
                        @endphp
                        @foreach ($pengkajian as $key => $p)
                            @php
                                $pegawai = Modules\Pegawai\Entities\Pegawai::where('user_id', $p->user_id)->first();
                            @endphp
                            <tr>
                                <td>{{ $nomor++  }}</td>
                                <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                <td>
                                    {{$pegawai->nama}}
                                </td>
                                <td>
                                    <a href="{{ url('cetak-pengkajian-gizi/pdf/' . @$p->registrasi_id . '/' . @$p->id) }}"
                                        target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                            class="fa fa-print"></i> </a>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm btn-flat proses-tte-pengkajian-gizi" data-id="{{$p->id}}" data-regid="{{$p->registrasi_id}}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    @if (!empty(@$p->tte))
                                        <a href="{{ url('/dokumen_tte/' . @$p->tte) }}"
                                            target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal TTE CPPT-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-cppt" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE CPPT</h4>
            </div>
            <div class="modal-body row" style="display: grid;">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Nama:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">NIK:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
                </div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="button-proses-tte-cppt">Proses TTE</button>
            </div>
        </div>
        </form>
    
        </div>
    </div>

    <!-- Modal TTE Skrining Gizi-->
    <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-skrining-gizi" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE Skrining Gizi</h4>
            </div>
            <div class="modal-body row" style="display: grid;">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Nama:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">NIK:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
                </div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="button-proses-tte-cppt">Proses TTE</button>
            </div>
        </div>
        </form>
    
        </div>
    </div>

    <!-- Modal TTE Pengkajian Gizi-->
    <div id="myModal3" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-pengkajian-gizi" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE Pengkajian Gizi</h4>
            </div>
            <div class="modal-body row" style="display: grid;">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Nama:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">NIK:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
                </div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="button-proses-tte-cppt">Proses TTE</button>
            </div>
        </div>
        </form>
    
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#tabelCPPTGizi').dataTable({
            'language'    : {
                "url": "/json/pasien.datatable-language.json",
            },
            "info": false,
            "bSort": false,
            "lengthChange": false,
            "pageLength": 5,
        });

        $('#tabelPengkajian').dataTable({
            'language'    : {
                "url": "/json/pasien.datatable-language.json",
            },
            "info": false,
            "bSort": false,
            "lengthChange": false,
            "pageLength": 5,
        });

        $('.proses-tte-cppt').click(function () {
            let reg_id = $(this).data("regid");
            let id = $(this).data("id");
            $('#form-tte-cppt').attr('action', '/cetak-cppt-gizi/pdf/' + reg_id  + '/' + id);
            $('#myModal').modal('show');
            
        })

        $('#form-tte-cppt').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-cppt')[0].submit();
        })

        $('.proses-tte-skrining-gizi').click(function () {
            let reg_id = $(this).data("regid");
            let id = $(this).data("id");
            let jenis = $(this).data("jenis");
            if (jenis == "Skrining Gizi Dewasa") {
                $('#form-tte-skrining-gizi').attr('action', '/cetak-skrining-gizi-dewasa/pdf/' + reg_id  + '/' + id);
            } else if (jenis == "Skrining Gizi Anak") {
                $('#form-tte-skrining-gizi').attr('action', '/cetak-skrining-gizi-anak/pdf/' + reg_id  + '/' + id);
            } else if (jenis == "Skrining Gizi Maternitas") {
                $('#form-tte-skrining-gizi').attr('action', '/cetak-skrining-gizi-maternitas/pdf/' + reg_id  + '/' + id);
            } else if (jenis == "Skrining Gizi Perinatologi") {
                $('#form-tte-skrining-gizi').attr('action', '/cetak-skrining-gizi-perinatologi/pdf/' + reg_id  + '/' + id);
            }
            $('#myModal2').modal('show');
            
        })

        $('#form-tte-skrining-gizi').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-skrining-gizi')[0].submit();
        })

        $('.proses-tte-pengkajian-gizi').click(function () {
            let reg_id = $(this).data("regid");
            let id = $(this).data("id");
            $('#form-tte-pengkajian-gizi').attr('action', '/cetak-pengkajian-gizi/pdf/' + reg_id  + '/' + id);
            $('#myModal3').modal('show');
            
        })

        $('#form-tte-pengkajian-gizi').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-pengkajian-gizi')[0].submit();
        })
    </script>
@endsection