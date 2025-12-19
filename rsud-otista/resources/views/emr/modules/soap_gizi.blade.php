@extends('master')

@section('header')
    <h1>
        SOAP GIZI</h1>
@endsection

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>








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
                @include('emr.modules.addons.tab-gizi')
                <div class="col-md-12">
                    @if (!$emr)
                        <form method="POST" action="{{ url('save-emr-gizi') }}" class="form-horizontal">
                        @else
                            <form method="POST" action="{{ url('update-soap-gizi') }}" class="form-horizontal">
                                {!! Form::hidden('emr_id', $emr->id) !!}
                    @endif
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', @$reg->id) !!}
                    {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                    {!! Form::hidden('kamar_id', @$reg->rawat_inap->kamar_id) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    <br>
                    {{-- List soap --}}
                    <div class="col-md-6">
                        <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                            <table class="table table-bordered" id="data" style="font-size: 12px;">

                                <tbody>
                                    @if (count($all_resume) == 0)
                                        <tr>
                                            <td>Tidak ada record</td>
                                        </tr>
                                    @endif
                                    @foreach ($all_resume as $key_a => $val_a)
                                        <tr style="background-color:#9ad0ef">
                                            <th>{{ @$val_a->registrasi->reg_id }}</th>
                                            <th>
                                                {{ @$val_a->kamar->nama }}
                                            </th>
                                        </tr>
                                        <tr style="background-color:#9ad0ef">
                                            <th>{{ @date('d-m-Y, H:i', strtotime($val_a->created_at)) }}</th>
                                            <th>
                                                {{ @$val_a->user->name }}
                                            </th>
                                        </tr>

                                        <tr>
                                            <td colspan="2"><b>A:</b> {!! $val_a->assesment !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>D:</b> {!! $val_a->diagnosis !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>I:</b> {!! $val_a->intervensi !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>M:</b> {!! $val_a->monitoring !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>E:</b> {!! $val_a->evaluasi !!}</td>
                                        </tr>
                                        {{-- <tr>
                                  <td colspan="2"><b>Kondisi Akhir Pasien:</b> {!! @$val_a->keterangan !!}</td>
                              </tr> --}}
                                        {{-- <tr>
                                <td colspan="2"><b>Dianosa:</b> {!! @$val_a->diagnosis !!}</td>
                               </tr> --}}
                                        {{-- <tr>
                                <td colspan="2"><b>Dianosa Tambahan:</b> {!! @$val_a->diagnosistambahan !!}</td>
                               </tr> --}}
                                        <tr>
                                            <td colspan="2" class="" style="font-size:15px;">
                                                <p>
                                                    @if (Auth::user()->id == $val_a->user_id)
                                                        <span class="pull-right">
                                                            <a href="{{ url('/emr/duplicate-soap-gizi/' . $val_a->id . '/' . @$reg->id) }}"
                                                                onclick="return confirm('Yakin akan menduplikat data?')"
                                                                data-toggle="tooltip" title="Duplikat"><i
                                                                    class="fa fa-copy"></i></a>&nbsp;&nbsp;
                                                            <a href="{{ url('/emr/soap-gizi/' . $unit . '/' . @$reg->id . '/' . $val_a->id . '/edit?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                                                                data-toggle="tooltip" title="Edit"><i
                                                                    class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                                            <a href="{{ url('/emr/soap-gizi-delete/' . $val_a->id . '/delete') }}"
                                                                data-toggle="tooltip" title="Hapus"><i
                                                                    class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                                                        </span>
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Soap Input --}}
                    <div class="col-md-6">
                        <table style="width: 100%" style="font-size:12px;">
                            @if ($emr)
                                <tr>
                                    <td><b>Assesment(A)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="assesment">{{ $emr ? $emr->assesment : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50px;"><b>Diagnosis(D)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="diagnosis">{{ $emr ? $emr->diagnosis : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Intervensi(I)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="intervensi">{{ $emr ? $emr->intervensi : '' }}</textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Monitoring(M)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="monitoring">{{ $emr ? $emr->monitoring : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Evaluasi(E)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="evaluasi">{{ $emr ? $emr->evaluasi : '' }}</textarea>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td><b>Tanggal</b></td>
                                    <td style="padding: 5px;">
                                        <input type="date" value="{{date('Y-m-d')}}" class="form-control" name="tanggal"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Assesment(A)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" rows="5" class="form-control" name="assesment">
{{ 'BB: ' . (@$fisikGizi['pengkajian']['antropometri']['dewasa']['bb_saat_ini'] ?? @$fisikGizi['pengkajian']['antropometri']['anak']['bb_saat_ini']) }}
{{ 'TB: ' . (@$fisikGizi['pengkajian']['antropometri']['dewasa']['tinggi_badan'] ?? @$fisikGizi['pengkajian']['antropometri']['anak']['tinggi_badan']) }}
Standar Deviasi:
{{ 'BB / U: ' . (@$fisikGizi['pengkajian']['antropometri']['anak']['standar_deviasi']['1']) }} - {{ 'Status Gizi: ' . (@$fisikGizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_1']) }}
{{ 'PB, TB / U: ' . (@$fisikGizi['pengkajian']['antropometri']['anak']['standar_deviasi']['2']) }} - {{ 'Status Gizi: ' . (@$fisikGizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_2']) }}
{{ 'BB / PB , TB: ' . (@$fisikGizi['pengkajian']['antropometri']['anak']['standar_deviasi']['3']) }} - {{ 'Status Gizi: ' . (@$fisikGizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_3']) }}
{{ 'Status Gizi: ' . (@$fisikGizi['pengkajian']['antropometri']['dewasa']['status_gizi'] ?? @$fisikGizi['pengkajian']['antropometri']['anak']['status_gizi']) }}
{{ 'Asupan Nutrisi RS: ' . @$fisikGizi['pengkajian']['riwayat_diet']['asupan_nutrisi_rs'] }}
{{ 'Asupan Nutrisi SMRS: ' . @$fisikGizi['pengkajian']['riwayat_diet']['asupan_nutrisi_smrs'] }}
{{ 'Diet: ' . @$cppt->diet }}
{{ 'Bio Kimia: ' . @$fisikGizi['pengkajian']['biokimia'] }}
{{ 'Riwayat Konseling Gizi: ' . @$fisikGizi['pengkajian']['riwayat_diet']['riwayat_konseling'] }}
Fisik Klinis Gizi:
@php
  $fisik = @$fisikGizi['pengkajian']['fisik_klinis_gizi'] ?? [];
@endphp
@if (!empty($fisik['gangguan_nafsu_makan']) && $fisik['gangguan_nafsu_makan'] == 'Ya')
- Nafsu Makan: Ya
@endif
@if (!empty($fisik['kembung']) && $fisik['kembung'] == 'Ya')
- Kembung: Ya
@endif
@if (!empty($fisik['mual']) && $fisik['mual'] == 'Ya')
- Mual: Ya
@endif
@if (!empty($fisik['konstipasi']) && $fisik['konstipasi'] == 'Ya')
- Konstipasi: Ya
@endif
@if (!empty($fisik['kepala_dan_mata']) && $fisik['kepala_dan_mata'] == 'Ya')
- Kepala dan Mata: Ya
@endif
@if (!empty($fisik['antropi_otot_lengan']) && $fisik['antropi_otot_lengan'] == 'Ya')
- Atropi Otot Lengan: Ya
@endif
@if (!empty($fisik['gigi_geligi']) && $fisik['gigi_geligi'] == 'Ya')
- Gigi Geligi: Ya
@endif
@if (!empty($fisik['hilang_lemak_subkutan']) && $fisik['hilang_lemak_subkutan'] == 'Ya')
- Hilang Lemak Subkutan: Ya
@endif
@if (!empty($fisik['gangguan_menelan']) && $fisik['gangguan_menelan'] == 'Ya')
- Gangguan Menelan: Ya
@endif
@if (!empty($fisik['gangguan_mengunyah']) && $fisik['gangguan_mengunyah'] == 'Ya')
- Gangguan Mengunyah: Ya
@endif
@if (!empty($fisik['gangguan_menghisap']) && $fisik['gangguan_menghisap'] == 'Ya')
- Gangguan Menghisap: Ya
@endif
@if (!empty($fisik['sesak']) && $fisik['sesak'] == 'Ya')
- Gangguan Sesak: Ya
@endif
@if (!empty($fisik['stomatitis']) && $fisik['stomatitis'] == 'Ya')
- Gangguan Stomatitis: Ya
@endif
@if (!empty($fisik['lainnya']))
- Lainnya: {{$fisik['lainnya']}}
@endif
- Tanda Vital:
{{ 'Tekanan Darah: '.@$fisikGizi['pengkajian']['fisik_klinis_gizi']['tanda_vital']['tekanan_darah']}}
{{ 'Suhu: '.@$fisikGizi['pengkajian']['fisik_klinis_gizi']['tanda_vital']['suhu']}}
{{ 'Nadi: '.@$fisikGizi['pengkajian']['fisik_klinis_gizi']['tanda_vital']['nadi']}}
{{ 'Respirasi: '.@$fisikGizi['pengkajian']['fisik_klinis_gizi']['tanda_vital']['respirasi']}}
{{ 'Saturasi: '.@$fisikGizi['pengkajian']['fisik_klinis_gizi']['tanda_vital']['saturasi']}}
                                        </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50px;"><b>Diagnosis(D)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="diagnosis">{{ @$fisikGizi['diagnosa_gizi'] }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Intervensi(I)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="intervensi">
Tujuan: {{ @$fisikGizi['intervensi_gizi']['tujuan'] }}
@if (!empty($fisikGizi['intervensi_gizi']['preskripsi_diet']['bentuk_makanan']))
@php
$bentuk = $fisikGizi['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'];
$bentukText = is_array($bentuk) ? implode(', ', $bentuk) : $bentuk;
@endphp
Bentuk Makanan: {{ $bentukText }}
@if (in_array('Lainnya', (array)$bentuk)), {{ @$fisikGizi['intervensi_gizi']['preskripsi_diet']['bentuk_makanan_lain'] }}@endif
@endif
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['jenis_diet'])
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Lainnya')
Jenis Diet : {{@$fisikGizi['intervensi_gizi']['preskripsi_diet']['jenis_diet']}}, {{@$fisikGizi['intervensi_gizi']['preskripsi_diet']['jenis_diet_lainnya']}}
@else
Jenis Diet : {{@$fisikGizi['intervensi_gizi']['preskripsi_diet']['jenis_diet']}}
@endif
@endif
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['frekuensi'])
Frekuensi: {{ @$fisikGizi['intervensi_gizi']['preskripsi_diet']['frekuensi'] }}
@endif
@if (!empty($fisikGizi['intervensi_gizi']['preskripsi_diet']['rute']))
Rute: {{ implode(', ', $fisikGizi['intervensi_gizi']['preskripsi_diet']['rute']) }}
@endif
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['energi'])
Energi: {{ @$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['energi'] }}
@endif
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['protein'])
Protein: {{ @$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['protein'] }}
@endif
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['lemak'])
Lemak: {{ @$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['lemak'] }}
@endif
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['karbohidrat'])
Karbohidrat: {{ @$fisikGizi['intervensi_gizi']['preskripsi_diet']['kebutuhan']['karbohidrat'] }}
@endif
@if (@$fisikGizi['intervensi_gizi']['preskripsi_diet']['edukasi'])
Edukasi: {{ @$fisikGizi['intervensi_gizi']['preskripsi_diet']['edukasi'] }}
@endif</textarea>
                                        </textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Monitoring(M)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="monitoring">{{ @$fisikGizi['monitoring'] }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Evaluasi(E)</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="evaluasi">{{ @$fisikGizi['evaluasi'] }}</textarea>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td style="text-align: right;">
                                    <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                                </td>
                            </tr>
                            </tr>
                        </table>
                    </div>


                    <br /><br />
                    </form>
                    <hr />
                    <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}"
                        class="form-horizontal">
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', @$reg->id) !!}
                        {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                        {!! Form::hidden('cara_bayar', @$reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(".skin-blue").addClass("sidebar-collapse");
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
    </script>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var dataImage = document.getElementById("dataImage");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = dataImage.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
@endsection
