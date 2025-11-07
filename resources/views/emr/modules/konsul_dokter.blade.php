@extends('master')

@section('header')
    <h1>KONSUL DOKTER</h1>
@endsection
<style>
    .new {
        background-color: #e4ffe4;
    }
</style>
@section('content')
    @php
        
        $poli = request()->get('poli');
        $dpjp = request()->get('dpjp');
    @endphp
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
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                    </div>
                @if (!$emr)
                    <form method="POST" action="{{ url('emr-konsuldokter') }}" class="form-horizontal">
                @else
                    <form method="POST" action="{{ url('emr-update-konsuldokter') }}" class="form-horizontal">
                        {!! Form::hidden('emr_id', $emr->id) !!}
                @endif
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            <br>
                    {{-- List soap --}}

                    @php
                        @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
                        if (!@$dataPegawai) {
                            @$dataPegawai = 1;
                        }
                    @endphp
                    
                    {{-- Soap Input --}}
                    @if (@$dataPegawai == 1 || substr(@$reg->status_reg, 0,1) == 'G')
                    <div class="col-md-8">
                            
                        
                        <table style="width: 100%" style="font-size:12px;">
                            <tr>
                                <td><b>Tanggal dan Jam</b></td>
                                <td style="padding: 5px;">
                                    <div class="row">
                                        <div class="col-md-6"><input type="date" name="tanggal" class="form-control"
                                                value="{{ @$emr->tanggal ? @$emr->tanggal : date('Y-m-d') }}"></div>
                                        <div class="col-md-6"><input type="hidden" name="waktu" class="form-control"
                                                value="{{ @$emr->waktu ? @$emr->waktu : date('H:i') }}"></div>
                                    </div>


                                </td>
                            </tr>
                            <tr>
                                <td style="width:200px;"><b>Poli Asal</b></td>
                                <td style="padding: 5px;">
                                    <select name="poli_asal_id" id="poli_asal_id" class="select2" style="width: 100%;" required>
                                        <option value="all"></option>
                                        @foreach ($polis as $key => $poli)
                                            <option value="{{$key}}">{{$poli}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:200px;"><b>Dokter Pengirim Konsul</b></td>
                                <td style="padding: 5px;">
                                    {!! Form::select('dokter_pengirim', $dokter, @$emr->dokter_pengirim ? @$emr->dokter_pengirim : @$reg->dokter_id, [
                                        'class' => 'select2',
                                        'placeholder' => '',
                                        'style' => 'width: 100%',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:200px;"><b>Poli Tujuan</b></td>
                                <td style="padding: 5px;">
                                    {{-- {!! Form::select('poli_id', $polis, @$reg->poli_id ? @$reg->poli_id : '', [
                                        'class' => 'select2',
                                        'style' => 'width: 100%',
                                        'placeholder' => '',
                                        'required' => true,
                                        'id' => 'poli_id',
                                    ]) !!} --}}
                                    <select name="poli_id" id="poli_id" class="select2" style="width: 100%;" required>
                                        <option value="all"></option>
                                        @foreach ($polis as $key => $poli)
                                            <option value="{{$key}}">{{$poli}}</option>
                                        @endforeach
                                    </select>
                                    {{-- baca_dokter($reg->dokter_id) --}}
                                </td>
                            </tr>
                            {{-- <input type="hidden" id="poli_id" value="all"> --}}
                            <tr>
                                <td style="width:200px;"><b>Dokter Tujuan</b></td>
                                <td style="padding: 5px;">
                                    {{-- {!! Form::select('dokter_penjawab', $dokter, @$emr->dokter_penjawab ? @$emr->dokter_penjawab : '', [
                                        'class' => 'select2',
                                        'style' => 'width: 100%',
                                        'placeholder' => '',
                                        'required' => true,
                                    ]) !!} --}}
                                    <select class="form-control select2" style="width:100%" id="dokter_penjawab" name="dokter_penjawab" disabled>
                                        <option value="">Wajib pilih poli sebelum pilih dokter</option>
                                    </select>
                                    {{-- baca_dokter($reg->dokter_id) --}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Diagnosa</b></td>
                                <td style="padding: 5px;">
                                    <textarea rows="5" class="form-control ckeditor" name="alasan_konsul" required>{{ $emr ? $emr->alasan_konsul : 'Yth. TS. ' }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{-- <div class="form-group text-center"> --}}
                                    @if (@$emr)
                                        <button type="submit" class="btn btn-warning btn-flat">UPDATE</button>
                                        <a href="{{ url()->current() . '?poli=' . $poli . '&dpjp=' . $dpjp }}" class="btn btn-primary btn-flat">BATAL</a>
                                    @else
                                        <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                                    @endif
                                    {{--
                    </div> --}}
                                </td>
                            </tr>
                        </table>
                    </div>
                    @endif


                    <div class="col-md-4 " style="margin-top: 10px">
                        <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                            <table class="table-bordered table" id="data"
                                style="font-size: 12px;margin-top:0px !important">

                                <tbody style="font-size:11px;">
                                    @if (count($all_resume) == 0)
                                        <tr>
                                            <td>Tidak ada record</td>
                                        </tr>
                                    @endif
                                    @foreach ($all_resume as $key_a => $val_a)
                                        <tr class="bg-primary" style="font-size:11px;">
                                            <th>Dokter Pengirim</th>
                                            <th>{{ baca_dokter($val_a->dokter_pengirim) }}</th>
                                        </tr>
                                        <tr class="bg-primary" style="font-size:11px;">
                                            <th>Dokter Tujuan</th>
                                            <th>{{ baca_dokter($val_a->dokter_penjawab) ?? 'Semua Dokter Poli ' . @baca_poli(@$val_a->poli_id) }}</th>
                                        </tr>
                                        <tr class="{{ @$emr->id == $val_a->id ? 'bg-success' : ''}}">
                                            <td colspan="2">
                                                @if (@$emr->id == $val_a->id)
                                                    <span class="text-danger"><i>Sedang diedit</i></span> <br>
                                                @endif
                                                <b>Diagnosa:</b> {!! $val_a->alasan_konsul !!}
                                            </td>
                                        </tr>
                                        {{-- <tr>
                      <td colspan="2"><b>Anjuran:</b> {!! $val_a->anjuran !!}</td>
                    </tr> --}}
                                        <tr class="{{ @$emr->id == $val_a->id ? 'bg-success' : ''}}">
                                            <td colspan="2" class="text-right">
                                                {{-- <span class="text-right"> --}}
                                                <div class="text-left" style="float: left;display:inline-block">
                                                    {{ valid_date($val_a->tanggal) }}
                                                    {{ $val_a->waktu }}
                                                </div>
                                                <div class="text-right">
                                                    @if (count($val_a->data_jawab_konsul) > 0)
                                                        <button type="button" data-toggle="tooltip"
                                                            data-id="{{ $val_a->id }}"
                                                            class="btn btn-success btn-xs btn-lihat-jawab">Lihat</button>&nbsp;&nbsp;
                                                    @endif
                                                    @if (@$dataPegawai == 1)
                                                        <button type="button" data-toggle="tooltip"
                                                        data-id="{{ $val_a->id }}"
                                                        class="btn btn-info btn-xs btn-jawab">Jawab
                                                        Konsul</button>&nbsp;&nbsp;
                                                        <a href="{{ url()->current() . '?poli=' . $poli . '&dpjp=' . $dpjp . '&konsul_dokter=' . $val_a->id }}"
                                                            data-toggle="tooltip" title="Edit"><i
                                                            class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                                    @endif
                                                    <a href="{{ url()->current() . '?poli=' . $poli . '&dpjp=' . $dpjp . '&konsul_dokter=' . $val_a->id }}"
                                                        onclick="hapusJawaban({{$val_a->id}}, this)" data-refresh="true"
                                                            data-toggle="tooltip" title="Hapus"><i
                                                            class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                                                </div>
                                                {{-- <a onclick="return confirm('Yakin akan menghapus data?')"
                            href="{{url('/emr/delete-soap/'.$val_a->id)}}" data-toggle="tooltip" title="Hapus"><i
                              class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp; --}}
                                                {{-- <a href="{{url('/emr/duplicate-soap/'.$val_a->id)}}"
                            onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip"
                            title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp; --}}
                                                {{--
                        </span> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <br /><br />
                    </form>
                    <hr />
                    <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}"
                        class="form-horizontal">
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                    </form>
                </div>
            </div>
        </div>

        <div id="modals" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        {{-- <h4 class="modal-title">Jawab Konsul</h4> --}}
                    </div>
                    <div class="modal-body" id="dataModals">

                    </div>
                    <div class="modal-footer">
                        <a href="#" target="_blank" id="btnPdf" class="btn btn-danger">PDF</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var id_konsul_dipilih = "";
        function hapusJawaban(id, button) {
            $.ajax({
                type: 'POST',
                url: "/emr-delete-jawabkonsul",
                data: {
                    "id": id,
                    "_token" : $('input[name="_token"]').val(),
                },
                success: function (data) {
                    if (data.status) {
                        alert(data.message);
                        $('#dataModals').html('');
                        $('#dataModals').load('/emr-datajawabankonsul/' + id_konsul_dipilih);
                        $('#modals').modal('show');

                        if (button && button.getAttribute("data-refresh") === "true") {
                            location.reload();
                        }
                    } else {
                        alert('Gagal menghapus jawaban konsul');
                    }
                }
            });
        }

        function toggleReadonly(element, id) {
            const inputElement = $(`.jawaban_${id}`);
            
            if (inputElement.attr('readonly')) {
                inputElement.removeAttr('readonly');
                $(element).text('Selesai');
            } else {
                inputElement.attr('readonly', 'readonly');
                $(element).text('Edit');
                let jawaban = $(`textarea[name="jawaban_${id}"]`).val();
                let anjuran = $(`textarea[name="anjuran_${id}"]`).val();
                $.ajax({
                    type: 'POST',
                    url: "/emr-update-jawabkonsul-ajax",
                    data: {
                        "id": id,
                        "_token" : $('input[name="_token"]').val(),
                        "jawab_konsul": jawaban,
                        "anjuran": anjuran
                    },
                    success: function (data) {
                        if (data.status) {
                            alert(data.message);
                            $('#dataModals').html('');
                            $('#dataModals').load('/emr-datajawabankonsul/' + id_konsul_dipilih);
                            $('#modals').modal('show');
                        } else {
                            alert('Gagal memperbarui jawaban konsul');
                        }
                    }
                });
            }
        }

    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Get Dokter Sesuai Poli Registrasi
            let poliId = $('#poli_id').val();

            $.ajax({
                url: '/emr-konsul/getDokterPoli/'+poliId,
                type: 'get',
                dataType: 'json',
            })
            .done(function(res) {
                // console.log(res)
                $("select[name='dokter_penjawab']").empty()
                data = res
                if (data[0].metadata.code == 200) {
                    // $('select[name="dokter_penjawab"]').append('<option value="">-- Pilih Dokter --</option>')
                    $('select[name="dokter_penjawab"]').prop("disabled", false);
                    $.each(data[1], function(index, val) {
                        $('select[name="dokter_penjawab"]').append('<option value="'+ val.id +'">'+ val.namadokter +'</option>');
                    });
                }else{
                    $('#dokter_not_found').removeClass('d-none')
                    $('select[name="dokter_penjawab"]').prop("disabled", true);
                }
            })
            //End Get Dokter

        })
        CKEDITOR.replaceAll('ckeditor', {
            height: 200,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        })
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
        $("#date_dengan_tanggal").attr('required', true);
        $(document).on('click', '.btn-jawab', function() {
            let id = $(this).attr('data-id');
            $('#dataModals').html('');
            $('#dataModals').load('/emr-datakonsul/' + id);
            $('#modals').modal('show');
        })

        $(document).on('click', '.btn-lihat-jawab', function() {
            let id = $(this).attr('data-id');
            id_konsul_dipilih = id;
            $('#dataModals').html('');
            $('#dataModals').load('/emr-datajawabankonsul/' + id);
            $('#modals').modal('show');
            $('#btnPdf').attr('href', '/emr-datajawabankonsul/' + id);
        })

        $('#poli_id').change(function(){
            var id = $(this).val();

            $.ajax({
                url: '/emr-konsul/getDokterPoli/'+id,
                type: 'get',
                dataType: 'json',
            })
            .done(function(res) {
                // console.log(res)
                $("select[name='dokter_penjawab']").empty()
                data = res
                if (data[0].metadata.code == 200) {
                    // $('select[name="dokter_penjawab"]').append('<option value="">-- Pilih Dokter --</option>')
                    $('select[name="dokter_penjawab"]').prop("disabled", false);
                    $('select[name="dokter_penjawab"]').append(`<option value="">Semua Dokter Poli ${data[0].poli}</option>`)
                    $.each(data[1], function(index, val) {
                        $('select[name="dokter_penjawab"]').append('<option value="'+ val.id +'">'+ val.namadokter +'</option>');
                    });
                }else{
                    $('#dokter_not_found').removeClass('d-none')
                    $('select[name="dokter_penjawab"]').prop("disabled", true);
                }
            })
        })

        $('#poli_asal_id').change(function(){
            var id = $(this).val();

            $.ajax({
                url: '/emr-konsul/getDokterPoli/'+id,
                type: 'get',
                dataType: 'json',
            })
            .done(function(res) {
                // console.log(res)
                $("select[name='dokter_pengirim']").empty()
                data = res
                if (data[0].metadata.code == 200) {
                    // $('select[name="dokter_pengirim"]').append('<option value="">-- Pilih Dokter --</option>')
                    $('select[name="dokter_pengirim"]').prop("disabled", false);
                    $.each(data[1], function(index, val) {
                        $('select[name="dokter_pengirim"]').append('<option value="'+ val.id +'">'+ val.namadokter +'</option>');
                    });
                }else{
                    $('#dokter_not_found').removeClass('d-none')
                    $('select[name="dokter_pengirim"]').prop("disabled", true);
                }
            })
        })
    </script>
@endsection
