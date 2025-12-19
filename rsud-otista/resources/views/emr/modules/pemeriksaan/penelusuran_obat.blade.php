@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }
</style>
@section('header')
    <h1>Penelusuran Obat</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
            @include('emr.modules.addons.profile')

            <div class="row">
                <div class="col-md-12">
                    @include('emr.modules.addons.tabs')
                </div>
                <br>

                {{-- Rekonsiliasi Obat --}}
                <div class="col-md-12" style="margin-top: 20px">
                    <table class='table table-striped table-bordered table-hover table-condensed' >
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                                <th class="text-center" style="vertical-align: middle;">Tanggal Dibuat</th>
                                <th class="text-center" style="vertical-align: middle;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if (count($riwayats) == 0)
                            <tr>
                                <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                            </tr>
                        @endif
                        @foreach ($riwayats as $riwayat)
                            <tr>
                                <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                    {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                                </td>
                                <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                    {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y')}}
                                </td>
                                <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                    <a href="{{ url("emr-soap-print/cetak-rekonsiliasi-obat/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-warning btn-sm" target="_blank">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                                </td>
                            </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" style="margin-top: 20px">
                    @if (@$current_asessment->id == request()->asessment_id || request()->asessment_id == null)
                        {{-- Muncul hanya jika user membuka asesment hari ini aja/registrasi --}}
                        <div class="box box-info">
                            <div class="box-body">
                                <form method="POST"
                                    action="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/' . $unit . '/' . $reg->id) }}"
                                    class="form-horizontal">
                                    {{ csrf_field() }}
                                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                    {!! Form::hidden('unit', $unit) !!}
                                    {!! Form::hidden('rekonsiliasi_idx', request()->rekonsiliasi_idx) !!}
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[nama_obat]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[nama_obat]', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="text" name="rekonsiliasi[nama_obat]"
                                                        id="rekonsiliasi[nama_obat]" class="form-control" value="{{request()->rekonsiliasi_idx != null ? $rekonsiliasi[request()->rekonsiliasi_idx]['nama_obat']:''}}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[nama_obat]') }}</small>
                                                </div>
                                            </div>

                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[alasan_makan]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[alasan_makan]', 'Alasan Makan Obat', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="text" name="rekonsiliasi[alasan_makan]"
                                                        id="rekonsiliasi[alasan_makan]" class="form-control" value="{{request()->rekonsiliasi_idx != null ? $rekonsiliasi[request()->rekonsiliasi_idx]['alasan_makan']:''}}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[alasan_makan]') }}</small>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[obat_dilanjutkan]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[obat_dilanjutkan]', 'Obat Dilanjutkan', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <select name="rekonsiliasi[obat_dilanjutkan]"
                                                        class="form-control select2" style="width: 100%" value="{{request()->rekonsiliasi_idx != null ? $rekonsiliasi[request()->rekonsiliasi_idx]['obat_dilanjutkan']:''}}">
                                                        <option value="YA">YA</option>
                                                        <option value="TIDAK">TIDAK</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[obat_dilanjutkan]') }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            {{-- <input type="hidden" id="currentDateTime"
                                                name="rekonsiliasi[tanggal]" value="">
                                            <script>
                                                function setCurrentDateTime() {
                                                    const hiddenInput = document.getElementById('currentDateTime');
                                                    const now = new Date();
                                                    const formattedDateTime = now.toLocaleString();
                                                    hiddenInput.value = formattedDateTime;
                                                }
                                                setCurrentDateTime();
                                            </script> --}}
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[dosis]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[dosis]', 'Dosis', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('rekonsiliasi[dosis]', '', ['class' => 'form-control']) !!}
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[dosis]') }}</small>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group{{ $errors->has('rekonsiliasi[frekuensi]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[frekuensi]', 'Frekuensi', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('rekonsiliasi[frekuensi]', '', ['class' => 'form-control']) !!}
                                                    <small
                                                        class="text-danger">{{ $errors->first('rekonsiliasi[][frekuensi]') }}</small>
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('rekonsiliasi[tanggal]') ? ' has-error' : '' }}">
                                                {!! Form::label('rekonsiliasi[tanggal]', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" name="rekonsiliasi[tanggal]" id="rekonsiliasi[tanggal]" class="form-control"
                                                        value="{{ request()->rekonsiliasi_idx != null ? \Carbon\Carbon::parse($rekonsiliasi[request()->rekonsiliasi_idx]['tanggal'])->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i') }}">
                                                    <small class="text-danger">{{ $errors->first('rekonsiliasi[tanggal]') }}</small>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9 text-center">
                                                    {!! Form::submit('Tambah', [
                                                        'class' => 'btn btn-success btn-flat',
                                                        'style' => 'width: 100%',
                                                        'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif


                    <div class='table-responsive'>
                        <table class='table-striped table-bordered table-hover table-condensed table'>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Obat</th>
                                    <th>Dosis</th>
                                    <th>Frekuensi</th>
                                    <th>Alasan Makan Obat</th>
                                    <th>Obat Dilanjutkan</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @if (isset($rekonsiliasi))
                                    @foreach ($rekonsiliasi as $r_obat)
                                        <tr
                                            style="text-align: center; {{ request()->rekonsiliasi_idx != null && @$loop->index == request()->rekonsiliasi_idx ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ @$r_obat['nama_obat'] }}</td>
                                            <td>{{ @$r_obat['dosis'] }}</td>
                                            <td>{{ @$r_obat['frekuensi'] }}</td>
                                            <td>{{ @$r_obat['alasan_makan'] }}</td>
                                            <td>{{ @$r_obat['obat_dilanjutkan'] }}</td>
                                            {{-- <td>{{ $date->format('d-m-Y H:i') }}</td> --}}
                                            {{-- <td>{{$r_obat['tanggal']}}</td> --}}
                                            <td>
                                                @php
                                                    $tanggal = $r_obat['tanggal'];
                                                    $formats = [
                                                        'd/m/Y, H.i.s',    // 18/2/2025, 14.29.36
                                                        'm/d/Y, H:i:s',    // 2/19/2025, 9:59:54
                                                        'd/m/Y H:i:s',     // 18/2/2025 14:29:36
                                                        'm/d/Y H:i:s',     // 2/19/2025 09:59:54
                                                        'm/d/Y, h:i:s A',  // 2/19/2025, 9:59:54 AM
                                                        'm/d/Y h:i:s A',   // 2/19/2025 9:59:54 AM
                                                        'Y-m-d\TH:i',      // 2025-02-14T14:25 (ISO 8601)
                                                        'Y-m-d H:i:s'      // Format umum database (2025-02-14 14:25:00)
                                                    ];

                                                    $parsedDate = '-';

                                                    foreach ($formats as $format) {
                                                        try {
                                                            $parsedDate = \Carbon\Carbon::createFromFormat($format, $tanggal)->format('d/m/Y H:i:s');
                                                            break;
                                                        } catch (\Exception $e) {
                                                            continue;
                                                        }
                                                    }
                                                @endphp

                                                {{ $parsedDate }}
                                            </td>
                                            <td>
                                                <a href="{{ URL::current() . '?rekonsiliasi_idx=' . @$loop->index . '&registrasi_id=' . $reg->id . '#rekonsiliasi' }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-pencil"></i>
                                                </a>                                                             
                                                <a href="{{ route('rekonsiliasi.hapus', ['registrasi_id' => $reg->id, 'index' => $loop->index]) }}"
                                                    onclick="return confirm('Yakin akan di hapus?')"
                                                    class="btn btn-danger btn-sm btn-flat">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align: center">Tidak Ada Data</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px">
                    @if (@$current_asessment->id == request()->asessment_id || request()->asessment_id == null)
                        {{-- Muncul hanya jika user membuka asesment hari ini aja/registrasi --}}
                        <div class="box box-info">
                            <div class="box-body">
                                <form method="POST"
                                    action="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/' . $unit . '/' . $reg->id) }}"
                                    class="form-horizontal">
                                    {{ csrf_field() }}
                                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                    {!! Form::hidden('unit', $unit) !!}
                                    {!! Form::hidden('alergi_idx', request()->alergi_idx) !!}
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div
                                                class="form-group{{ $errors->has('obatAlergi[nama_obat]') ? ' has-error' : '' }}">
                                                {!! Form::label('obatAlergi[nama_obat]', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="text" name="obatAlergi[nama_obat]"
                                                        id="obatAlergi[nama_obat]" class="form-control" value="{{request()->alergi_idx != null ? $obatAlergi[request()->alergi_idx]['nama_obat']:''}}"
                                                        placeholder="Nama Obat Yang Menimbulkan Alergi">
                                                    <small
                                                        class="text-danger">{{ $errors->first('obatAlergi[nama_obat]') }}</small>
                                                </div>
                                            </div>

                                            <div
                                                class="form-group{{ $errors->has('obatAlergi[reaksi_alergi]') ? ' has-error' : '' }}">
                                                {!! Form::label('obatAlergi[reaksi_alergi]', 'Reaksi Alergi', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('obatAlergi[reaksi_alergi]', request()->alergi_idx != null ? $obatAlergi[request()->alergi_idx]['reaksi_alergi']:'', ['class' => 'form-control']) !!}
                                                    <small
                                                        class="text-danger">{{ $errors->first('obatAlergi[reaksi_alergi]') }}</small>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            {{-- <input type="hidden" id="currentDateTime"
                                                name="obatAlergi[tanggal]" value="">
                                            <script>
                                                function setCurrentDateTime() {
                                                    const hiddenInput = document.getElementById('currentDateTime');
                                                    const now = new Date();
                                                    const formattedDateTime = now.toLocaleString();
                                                    hiddenInput.value = formattedDateTime;
                                                }
                                                setCurrentDateTime();
                                            </script> --}}
                                            <div
                                                class="form-group{{ $errors->has('obatAlergi[tingkat_alergi]') ? ' has-error' : '' }}">
                                                {!! Form::label('obatAlergi[tingkat_alergi]', 'Tingkat Alergi', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <select name="obatAlergi[tingkat_alergi]"
                                                        class="form-control select2" style="width: 100%">
                                                        <option value="TIDAK ADA">TIDAK ADA</option>
                                                        <option value="RINGAN">RINGAN</option>
                                                        <option value="SEDANG">SEDANG</option>
                                                        <option value="BERAT">BERAT</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('obatAlergi[tingkat_alergi]') }}</small>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group{{ $errors->has('obatAlergi[tanggal]') ? ' has-error' : '' }}">
                                                {!! Form::label('obatAlergi[tanggal]', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" name="obatAlergi[tanggal]"
                                                        id="obatAlergi[tanggal]" class="form-control" value="{{request()->alergi_idx != null ? $obatAlergi[request()->alergi_idx]['tanggal']:''}}"
                                                        placeholder="Nama Obat Yang Menimbulkan Alergi">
                                                    <small
                                                        class="text-danger">{{ $errors->first('obatAlergi[tanggal]') }}</small>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9 text-center">
                                                    {!! Form::submit('Tambah', [
                                                        'class' => 'btn btn-success btn-flat',
                                                        'style' => 'width: 100%',
                                                        'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    <div class='table-responsive'>
                        <table class='table-striped table-bordered table-hover table-condensed table'>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Obat Yang Menimbulkan Alergi</th>
                                    <th>Tingkat Alergi</th>
                                    <th>Reaksi Alergi</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @if (isset($obatAlergi))
                                    @foreach ($obatAlergi as $a_obat)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ @$a_obat['nama_obat'] }}</td>
                                            <td>{{ @$a_obat['tingkat_alergi'] }}</td>
                                            <td>{{ @$a_obat['reaksi_alergi'] }}</td>
                                            {{-- <td>{{ \Carbon\Carbon::parse(@$a_obat['tanggal'])->format('d-m-Y H:i') }}</td> --}}
                                            <td>
                                                @php
                                                    $tanggal = $a_obat['tanggal'];
                                                    $formats = [
                                                        'd/m/Y, H.i.s',    // 18/2/2025, 14.29.36
                                                        'm/d/Y, H:i:s',    // 2/19/2025, 9:59:54
                                                        'd/m/Y H:i:s',     // 18/2/2025 14:29:36
                                                        'm/d/Y H:i:s',     // 2/19/2025 09:59:54
                                                        'm/d/Y, h:i:s A',  // 2/19/2025, 9:59:54 AM
                                                        'm/d/Y h:i:s A',   // 2/19/2025 9:59:54 AM
                                                        'Y-m-d\TH:i',      // 2025-02-14T14:25 (ISO 8601)
                                                        'Y-m-d H:i:s'      // Format umum database (2025-02-14 14:25:00)
                                                    ];

                                                    $parsedDate = '-';

                                                    foreach ($formats as $format) {
                                                        try {
                                                            $parsedDate = \Carbon\Carbon::createFromFormat($format, $tanggal)->format('d/m/Y H:i:s');
                                                            break;
                                                        } catch (\Exception $e) {
                                                            continue;
                                                        }
                                                    }
                                                @endphp

                                                {{ $parsedDate }}
                                            </td>
                                            <td>
                                                <a href="{{ URL::current() . '?alergi_idx=' . @$loop->index . '&registrasi_id=' . $reg->id . '#rekonsiliasi' }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-pencil"></i>
                                                </a>                                                             
                                                <a href="{{ route('alergi.hapus', ['registrasi_id' => $reg->id, 'index' => $loop->index]) }}"
                                                    onclick="return confirm('Yakin akan di hapus?')"
                                                    class="btn btn-danger btn-sm btn-flat">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" style="text-align: center">Tidak Ada Data</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var url = document.location.toString();
        if (url.match('#')) {
            $('#' + url.split('#')[1]).addClass('in');
        }

        $(".skin-red").addClass("sidebar-collapse");
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href") // activated tab
            // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);
        $('#historiAskep').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriAskep').modal('show');
            $('#dataHistoriAskep').load("/emr-riwayat-askep/" + id);
        });
        $('.select2-diagnosis').select2({
            placeholder: "Pilih Diagnosa",
            width: '85%'
        });
        $('.select2-pemeriksaanDalam').select2({
            placeholder: "Pilih Intervensi",
            allowClear: true
        });
        $('.select2-fungsional').select2({
            placeholder: "Pilih Implementasi",
            allowClear: true
        });
    
        $('#select2-diagnosis').change(function(e){
          var intervensi = $('#select2-pemeriksaanDalam');
          var implementasi = $('#select2-fungsional');
          var diagnosa = $(this).val();
    
          intervensi.empty();
          implementasi.empty();
    
          $.ajax({
            url: '/emr-get-askep?namaDiagnosa='+diagnosa,
            type: 'get',
            dataType: 'json',
          })
          .done(function(res) {
            if(res[0].metadata.code == 200){
              $.each(res[1], function(index, val){
                intervensi.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
              })
              $.each(res[2], function(index, val){
                implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
              })
            }
          })
    
        });

        function hitungIMT() {
            let beratBadan = $('#beratBadan').val();
            let tinggiBadan = $('#tinggiBadan').val();

            // console.log(beratBadan, tinggiBadan);
            let tinggiMeter = tinggiBadan / 100; // konversi ke (cm) => (m)
    
            // Hitung IMT
            let imt = beratBadan / (tinggiMeter * tinggiMeter);
            
            $('#imt').val(imt.toFixed(1));
        }

        $(".date_tanpa_tanggal").datepicker( {
            format: "dd-mm-yyyy",
            autoclose: true
        });
    </script>
    <script>
        $('.select-diagnosa-keperawatan').select2({
            placeholder: "Pilih Diagnosa",
            width: '100%'
        });
        $('.select-intervensi-keperawatan').select2({
            placeholder: "Pilih Intervensi",
            allowClear: true
        });
        $('.select-implementasi-keperawatan').select2({
            placeholder: "Pilih Implementasi",
            allowClear: true
        });

        function getAskep(diagnosa, section) {
            let idnameintervensi = "";
            let idnameimplementasi = "";

            switch (section) {
                case "airway":
                    idnameintervensi = "select-intervensi-airway";
                    idnameimplementasi = "select-implementasi-airway";
                    break;
                case "breathing":
                    idnameintervensi = "select-intervensi-breathing";
                    idnameimplementasi = "select-implementasi-breathing";
                    break;
                case "circulation":
                    idnameintervensi = "select-intervensi-circulation";
                    idnameimplementasi = "select-implementasi-circulation";
                    break;
                case "disability":
                    idnameintervensi = "select-intervensi-disability";
                    idnameimplementasi = "select-implementasi-disability";
                    break;
                case "eksposure":
                    idnameintervensi = "select-intervensi-eksposure";
                    idnameimplementasi = "select-implementasi-eksposure";
                    break;
            
                default:
                    break;
            }

            let intervensi = $(`#${idnameintervensi}`);
            let implementasi = $(`#${idnameimplementasi}`);
            intervensi.empty();
            implementasi.empty();

            $.ajax({
                url: '/emr-get-askep?namaDiagnosa='+diagnosa,
                type: 'get',
                dataType: 'json',
            })
            .done(function(res) {
                if(res[0].metadata.code == 200){
                    $.each(res[1], function(index, val){
                        intervensi.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
                    })
                    $.each(res[2], function(index, val){
                        implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
                    })
                }
            })

        }
    </script>

    {{-- ICD 10 --}}
@endsection
