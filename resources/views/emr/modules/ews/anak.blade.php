@extends('master')

@section('header')
    <h1>EWS ANAK / EWS MODIFIKASI</h1>
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

                    <div class="col-md-12" style="margin: 2rem 0;">
                        <h5 class="text-bold">INFORMASI SKOR</h5>
                        <table class="table-bordered table" id="data"style="font-size: 12px;margin-top:0px !important">
                            <tbody style="font-size:11px;">
                                <tr style="font-size:11px; background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor 0 (Sangat Rendah)</td>
                                    <td>Monitoring pershift oleh perawat pelaksana dan didokumentasikan.</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(196, 193, 0); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor 1-4 (Rendah)</td>
                                    <td>Monitoring per 4 jam untuk NEWS dan MEOWS per 2 jam untuk PEWS. Pengkajian ulang dilakukan oleh PJ sift</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(255, 128, 0); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor 5-6 (Sedang)</td>
                                    <td>Monitoring per 1 jam. Pengkajian ulang dilakukan oleh PJ shift dan diketahui oleh dokter jaga, dokter jaga ruangan visit. Pasien dan melaporkan ke DPJP untuk tatalaksana selanjutnya. pasien diputuskan untuk pindah Hcu atau rencana</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(179, 29, 29); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor >= 7 (Tinggi)</td>
                                    <td>Aktifkan kode blue dan pasien dipindahkan ke HCU jika fasilitas memadai. Jika HCU penuh tatalaksana dilakukan di ruang perawatan dengan monitor bed side. Jika pasien sudah stabil</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                {{-- @if (!$emr) --}}
                    <form method="POST" action="{{ url('emr-ews-anak') }}" class="form-horizontal">
                {{-- @else
                    <form method="POST" action="{{ url('emr-update-konsuldokter') }}" class="form-horizontal">
                        {!! Form::hidden('emr_id', $emr->id) !!}
                @endif --}}
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('emr_id', @$emr->id) !!}
                            {{-- {{dd($emr->id)}} --}}
                            <br>
                    {{-- List soap --}}
                    
                    {{-- Soap Input --}}
                    <div class="col-md-8">
                        <table style="width: 100%" style="font-size:12px;">
                            <tr>
                                <td>Kategori Usia</td>
                                <td style="padding: 5px;">
                                    <select name="formulir[kategori_usia]" class="form-control select2">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        <option {{@$ewss['kategori_usia'] == "ANAK USIA 0-3 BULAN" ? 'selected' : ''}} value="ANAK USIA 0-3 BULAN">ANAK USIA 0-3 BULAN</option>
                                        <option {{@$ewss['kategori_usia'] == "ANAK USIA 4-11 BULAN" ? 'selected' : ''}} value="ANAK USIA 4-11 BULAN">ANAK USIA 4-11 BULAN</option>
                                        <option {{@$ewss['kategori_usia'] == "EWS ANAK USIA 1 – 16 TAHUN" ? 'selected' : ''}} value="EWS ANAK USIA 1 – 16 TAHUN">EWS ANAK USIA 1 – 16 TAHUN</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td style="padding: 5px;">
                                    <div class="row">
                                        <div class="col-md-6"><input type="date" name="tanggal" class="form-control"
                                                value="{{ @$emr->tanggal ? @$emr->tanggal : date('Y-m-d') }}"></div>
                                        {{-- <div class="col-md-6"><input type="time" name="waktu" class="form-control"
                                                value="{{ @$emr->waktu ? @$emr->waktu : date('H:i') }}"></div> --}}
                                    </div>


                                </td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td style="padding: 5px;">
                                    <div class="row">
                                        <div class="col-md-6"><input type="time" name="waktu" class="form-control"
                                                value="{{ @$emr->waktu ? @$emr->waktu : date('H:i') }}"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Perilaku</td>
                                <td style="padding: 5px;">
                                    @foreach (perilaku_ews_anak() as $item)
                                        <input type="radio" class="input_skor" name="formulir[perilaku]" {{@ews(@$ewss['perilaku'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>RT/Warna Kulit</td>
                                <td style="padding: 5px;">
                                    @foreach (kulit_ews_anak() as $item)
                                        <input type="radio" class="input_skor" name="formulir[kulit]" {{@ews(@$ewss['kulit'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Pernafasan</td>
                                <td style="padding: 5px;">
                                    @foreach (pernafasan_ews_anak() as $item)
                                        <input type="radio" class="input_skor" name="formulir[pernafasan]" {{@ews(@$ewss['pernafasan'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Skor Lain</td>
                                <td style="padding: 5px;">
                                    @foreach (skorlain_ews_anak() as $item)
                                        <input type="radio" class="input_skor" name="formulir[skor_lain]" {{@ews(@$ewss['skor_lain'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <br/>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
                                <td>Total Skor</td>
                                <td style="padding: 5px;" id="total_skor">
                                    @php
                                        $perilaku = @explode(',', @$ewss['perilaku'])[1];
                                        $kulit = @explode(',', @$ewss['kulit'])[1];
                                        $pernafasan = @explode(',', @$ewss['pernafasan'])[1];
                                        $skor_lain = @explode(',', @$ewss['skor_lain'])[1];

                                        $total_skor = $perilaku + $kulit + $pernafasan + $skor_lain;
                                    @endphp
                                    {{$total_skor}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    {{-- <b>Urine (+)</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;  --}}
                                    <b><span style="color:red">HR</span></b> : <input class="" value="{{@$ewss['hr']}}" name="formulir[hr]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                    <b><span style="color:green">RR</span></b> : <input class="" value="{{@$ewss['rr']}}" name="formulir[rr]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                    <b><span>T</span></b> : <input class="" value="{{@$ewss['t']}}" name="formulir[t]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                    <b><span>TD</span></b> : <input class="" value="{{@$ewss['td']}}" name="formulir[td]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Skor Nyeri</b> : <input class="" value="{{@$ewss['skor_nyeri']}}" name="formulir[skor_nyeri]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Skor Resiko Jatuh</b> : <input class="" value="{{@$ewss['skor_resiko_jatuh']}}" name="formulir[skor_resiko_jatuh]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Berat Badan</b> : <input class="" value="{{@$ewss['bb']}}" name="formulir[bb]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Lingkar Lengan Atas</b> : <input class="" value="{{@$ewss['lla']}}" name="formulir[lla]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Lingkar Lengan Bawah</b> : <input class="" value="{{@$ewss['llb']}}" name="formulir[llb]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Lingkar Perut</b> : <input class="" value="{{@$ewss['lp']}}" name="formulir[lp]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Masuk</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Peroral / NGT : <input class="qty1" value="{{@$ewss['masuk']['peroral']}}" name="formulir[masuk][peroral]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    Parenteral : <input class="qty1" value="{{@$ewss['masuk']['Parenteral']}}" name="formulir[masuk][Parenteral]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    Tranfusi : <input class="qty1" value="{{@$ewss['masuk']['Tranfusi']}}" name="formulir[masuk][Tranfusi]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    Jumlah : <input class="total" value="{{@$ewss['masuk']['Jumlah']}}" name="formulir[masuk][Jumlah]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Keluar</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Feses : <input class="qty2" value="{{@$ewss['keluar']['Feses']}}" name="formulir[keluar][Feses]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    Urine : <input class="qty2" value="{{@$ewss['keluar']['Urine']}}" name="formulir[keluar][Urine]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    Muntah / NGT : <input class="qty2" value="{{@$ewss['keluar']['Muntah']}}" name="formulir[keluar][Muntah]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    Drain / Darah : <input class="qty2" value="{{@$ewss['keluar']['Drain']}}" name="formulir[keluar][Drain]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    IWL : <input class="qty2" value="{{@$ewss['keluar']['IWL']}}" name="formulir[keluar][IWL]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                    Jumlah : <input class="total2" value="{{@$ewss['keluar']['Jumlah']}}" name="formulir[keluar][Jumlah]" type="text" style="width: 60px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Balance Cairan</b> : <input class="" value="{{@$ewss['blc_cairan']}}" name="formulir[blc_cairan]" type="text" style="width: 100px;">&nbsp;&nbsp;
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
                                            <td colspan="2"><b>Perilaku:</b> {{@$ews->perilaku ? @explode(',', @$ews->perilaku)[0] . '(' . @explode(',', @$ews->perilaku)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>RT/Warna Kulit:</b> {{@$ews->kulit ? @explode(',', @$ews->kulit)[0] . '(' . @explode(',', @$ews->kulit)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Pernapasan:</b> {{@$ews->pernafasan ? @explode(',', @$ews->pernafasan)[0] . '(' . @explode(',', @$ews->pernafasan)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Skor Lain:</b> {{@$ews->skor_lain ? @explode(',', @$ews->skor_lain)[0] . '(' . @explode(',', @$ews->skor_lain)[1] . ')' : '-'}}</td>
                                        </tr>
                                        @php
                                            $perilaku = @explode(',', @$ews->perilaku)[1];
                                            $kulit = @explode(',', @$ews->kulit)[1];
                                            $pernafasan = @explode(',', @$ews->pernafasan)[1];
                                            $skor_lain = @explode(',', @$ews->skor_lain)[1];
                                            $total_skor = $perilaku + $kulit + $pernafasan + $skor_lain;

                                            if ($total_skor == 0) {
                                                $style = 'background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring pershift oleh perawat pelaksana dan didokumentasikan.';
                                            } elseif ($total_skor <= 4) {
                                                $style = 'background-color: rgb(196, 193, 0); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring per 4 jam untuk NEWS dan MEOWS per 2 jam untuk PEWS. Pengkajian ulang dilakukan oleh PJ sift';
                                            } elseif ($total_skor <= 6) {
                                                $style = 'background-color: rgb(255, 128, 0); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring per 1 jam. Pengkajian ulang dilakukan oleh PJ shift dan diketahui oleh dokter jaga, dokter jaga ruangan visit. Pasien dan melaporkan ke DPJP untuk tatalaksana selanjutnya. pasien diputuskan untuk pindah Hcu atau rencana';
                                            } elseif ($total_skor >= 7) {
                                                $style = 'background-color: rgb(179, 29, 29); color: white; font-weight: bold;';
                                                $kesimpulan = 'Aktifkan kode blue dan pasien dipindahkan ke HCU jika fasilitas memadai. Jika HCU penuh tatalaksana dilakukan di ruang perawatan dengan monitor bed side. Jika pasien sudah stabil';
                                            }else{
                                                $style = '';
                                                $kesimpulan = '';
                                            }
                                        @endphp
                                        <tr style="{{$style}}">
                                            <td colspan="2"><b>Total Skor:</b> {{$total_skor}}</td>
                                        </tr>
                                        <tr style="{{$style}}">
                                            <td colspan="2"><b>Kesimpulan:</b> {{$kesimpulan}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="pull-right">
                                                    <a class="btn btn-xs btn-primary" href="{{ url('/emr-ews-anak/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/edit?poli='.$poli.'&dpjp='.$dpjp) }}"
                                                        data-toggle="tooltip" title="Lihat"><i
                                                            class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                                    <a class="btn btn-xs btn-success" href="{{ url('cetak-ews-anak/pdf/'. $reg->id . '/' . $val_a->id) }}"
                                                        data-toggle="tooltip" title="Cetak" target="_blank"><i
                                                            class="fa fa-print"></i></a>&nbsp;&nbsp;    
                                                    <a onclick="return confirm('Yakin akan menghapus data? jika ingin mengembalikan data mohon hubungi admin SIMRS')" class="btn btn-xs btn-danger" href="{{ url('/emr-ews-anak/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/delete?poli='.$poli.'&dpjp='.$dpjp) }}""
                                                        data-toggle="tooltip" title="Hapus"><i
                                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;    
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="2" class="text-right">
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
                                                    <button type="button" data-toggle="tooltip"
                                                        data-id="{{ $val_a->id }}"
                                                        class="btn btn-info btn-xs btn-jawab">Jawab
                                                        Konsul</button>&nbsp;&nbsp;
                                                    <a href="{{ url('/emr-konsuldokter-rawatinap/' . $reg->id . '/' . $val_a->id . '/edit') }}"
                                                        data-toggle="tooltip" title="Cetak"><i
                                                            class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                                </div>
                                            </td>
                                        </tr> --}}
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
