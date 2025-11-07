@extends('master')

@section('header')
    <h1>EWS NEONATUS (0 - 28 Hari)</h1>
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

                    <form method="POST" action="{{ url('emr-ews-neonatus') }}" class="form-horizontal">
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('emr_id', @$emr->id) !!}
                            <br>
                    {{-- List soap --}}
                    
                    {{-- Soap Input --}}
                    <div class="col-md-8">
                        <table style="width: 100%" style="font-size:12px;">
                            <tr>
                                <td>Tanggal</td>
                                <td style="padding: 5px;">
                                    <div class="row">
                                        <div class="col-md-6"><input type="date" name="tanggal" class="form-control"
                                                value="{{ @$emr->tanggal ? @$emr->tanggal : date('Y-m-d') }}"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Jam</td>
                                <td style="padding: 5px;">
                                    <div class="row">
                                        <div class="col-md-6"><input type="time" name="waktu" class="form-control"
                                                value="{{ @$emr->waktu ? @$emr->waktu : date('H:i') }}"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Suhu</td>
                                <td style="padding: 5px;">
                                    @foreach (suhu_ews_neonatus() as $item)
                                        <input type="radio" class="input_skor" name="formulir[suhu]" {{@ews(@$ewss['suhu'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_suhu]" value="{{@$ewss['nilai_suhu']}}">
                                    <br/>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Frekuansi Nafas</td>
                                <td style="padding: 5px;">
                                    @foreach (frekuensi_nafas_ews_neonatus() as $item)
                                        <input type="radio" class="input_skor" name="formulir[frekuensi_nafas]" {{@ews(@$ewss['frekuensi_nafas'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_frekuensi_nafas]" value="{{@$ewss['nilai_frekuensi_nafas']}}">
                                    <br/>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Denyut Jantung</td>
                                <td style="padding: 5px;">
                                    @foreach (denyut_jantung_ews_neonatus() as $item)
                                        <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@ews(@$ewss['denyut_jantung'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_denyut_jantung]" value="{{@$ewss['nilai_denyut_jantung']}}">
                                    <br/>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Sat. O2</td>
                                <td style="padding: 5px;">
                                    @foreach (saturasi_ews_neonatus() as $item)
                                        <input type="radio" class="input_skor" name="formulir[saturasi]" {{@ews(@$ewss['saturasi'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_saturasi]" value="{{@$ewss['nilai_saturasi']}}">
                                    <br/>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>CRT</td>
                                <td style="padding: 5px;">
                                    @foreach (crt_ews_neonatus() as $item)
                                        <input type="radio" class="input_skor" name="formulir[crt]" {{@ews(@$ewss['crt'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_crt]" value="{{@$ewss['nilai_crt']}}">
                                    <br/>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Tingkat Kesadaran</td>
                                <td style="padding: 5px;">
                                    @foreach (tingkat_kesadaran_ews_neonatus() as $item)
                                        <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@ews(@$ewss['tingkat_kesadaran'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_tingkat_kesadaran]" value="{{@$ewss['nilai_tingkat_kesadaran']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
                                <td>Total Skor</td>
                                <td style="padding: 5px;" id="total_skor">
                                    @php
                                        $tingkat_kesadaran = @explode(',', @$ewss['tingkat_kesadaran'])[1];
                                        $suhu = @explode(',', @$ewss['suhu'])[1];
                                        $frekuensi_nafas = @explode(',', @$ewss['frekuensi_nafas'])[1];
                                        $denyut_jantung = @explode(',', @$ewss['denyut_jantung'])[1];
                                        $saturasi = @explode(',', @$ewss['saturasi'])[1];
                                        $crt = @explode(',', @$ewss['crt'])[1];

                                        $total_skor =   (is_numeric($tingkat_kesadaran) ? $tingkat_kesadaran : 0) +
                                                        (is_numeric($suhu) ? $suhu : 0) +
                                                        (is_numeric($frekuensi_nafas) ? $frekuensi_nafas : 0) +
                                                        (is_numeric($denyut_jantung) ? $denyut_jantung : 0) +
                                                        (is_numeric($saturasi) ? $saturasi : 0) +
                                                        (is_numeric($crt) ? $crt : 0);
                                    @endphp
                                    {{$total_skor}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Grunting</b> : <input class="" value="{{@$ewss['grunting']}}" name="formulir[grunting]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Kejang</b> : <input class="" value="{{@$ewss['kejang']}}" name="formulir[kejang]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Glukosa</b> : <input class="" value="{{@$ewss['glukosa']}}" name="formulir[glukosa]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="">
                                    <br/>
                                    {{-- <div class="form-group text-center"> --}}
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">SIMPAN</button>
                                    {{--
                    </div> --}}
                                </td>
                            </tr>
                            
                        </table>
                    </div>


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
                                        @php
                                            $ews = json_decode($val_a->diagnosis);
                                        @endphp
                                        <tr class="bg-primary" style="font-size:11px;">
                                            <th>Penginput</th>
                                            <th>{{ baca_user($val_a->user_id) }}</th>
                                        </tr>
                                        <tr class="bg-primary" style="font-size:11px;">
                                            <th>Tanggal Input</th>
                                            <th>{{ date('d/m/Y',strtotime($val_a->tanggal)) . ' ' . date('H:i',strtotime($val_a->waktu)) }}</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Suhu:</b> {{@$ews->suhu ? @$ews->nilai_suhu . '(' . @explode(',', @$ews->suhu)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Frek. Nafas:</b> {{@$ews->frekuensi_nafas ? @$ews->nilai_frekuensi_nafas . '(' . @explode(',', @$ews->frekuensi_nafas)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Denyut Jantung:</b> {{@$ews->denyut_jantung ? @$ews->nilai_denyut_jantung . '(' . @explode(',', @$ews->denyut_jantung)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Sat. O2:</b> {{@$ews->saturasi ? @$ews->nilai_saturasi . '(' . @explode(',', @$ews->saturasi)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>CRT:</b> {{@$ews->crt ? @$ews->nilai_crt . '(' . @explode(',', @$ews->crt)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Tingkat Kesadaran:</b> {{@$ews->tingkat_kesadaran ? @$ews->nilai_tingkat_kesadaran . '(' . @explode(',', @$ews->tingkat_kesadaran)[1] . ')' : '-'}}</td>
                                        </tr>
                                        @php
                                            $tingkat_kesadaran = @explode(',', @$ews->tingkat_kesadaran)[1];
                                            $suhu = @explode(',', @$ews->suhu)[1];
                                            $frekuensi_nafas = @explode(',', @$ews->frekuensi_nafas)[1];
                                            $denyut_jantung = @explode(',', @$ews->denyut_jantung)[1];
                                            $saturasi = @explode(',', @$ews->saturasi)[1];
                                            $crt = @explode(',', @$ews->crt)[1];

                                            $total_skor =   (is_numeric($tingkat_kesadaran) ? $tingkat_kesadaran : 0) +
                                                            (is_numeric($suhu) ? $suhu : 0) +
                                                            (is_numeric($frekuensi_nafas) ? $frekuensi_nafas : 0) +
                                                            (is_numeric($denyut_jantung) ? $denyut_jantung : 0) +
                                                            (is_numeric($saturasi) ? $saturasi : 0) +
                                                            (is_numeric($crt) ? $crt : 0);
                                        @endphp
                                        <tr>
                                            <td colspan="2"><b>Total Skor:</b> {{$total_skor}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="pull-right">
                                                    <a class="btn btn-xs btn-primary" href="{{ url('/emr-ews-neonatus/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/edit?poli='.$poli.'&dpjp='.$dpjp) }}"
                                                        data-toggle="tooltip" title="Lihat"><i
                                                            class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                                    <a class="btn btn-xs btn-success" href="{{ url('cetak-ews-neonatus/pdf/'. $reg->id . '/' . $val_a->id) }}"
                                                        data-toggle="tooltip" title="Cetak" target="_blank"><i
                                                            class="fa fa-print"></i></a>&nbsp;&nbsp;    
                                                    <a onclick="return confirm('Yakin akan menghapus data? jika ingin mengembalikan data mohon hubungi admin SIMRS')" class="btn btn-xs btn-danger" href="{{ url('/emr-ews-neonatus/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/delete?poli='.$poli.'&dpjp='.$dpjp) }}""
                                                        data-toggle="tooltip" title="Hapus"><i
                                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;    
                                                </div>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.input_skor').change(function () {
            var total_skor = 0;
            $('.input_skor').each(function () {
                if ($(this).is(':checked')) {
                    total_skor += +$(this).val().split(',')[1];
                }
            });
            $('#total_skor').html(total_skor);
        })

        $(document).on("change", ".qty1", function() {
            var sum = 0;
            $(".qty1").each(function(){
                sum += +$(this).val();
            });
            $(".total").val(sum);
        });
        $(document).on("change", ".qty2", function() {
            var sum = 0;
            $(".qty2").each(function(){
                sum += +$(this).val();
            });
            $(".total2").val(sum);
        });

        $(".skin-green").addClass("sidebar-collapse");
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
            $('#dataModals').html('');
            $('#dataModals').load('/emr-datajawabankonsul/' + id);
            $('#modals').modal('show');
        })
    </script>
@endsection
