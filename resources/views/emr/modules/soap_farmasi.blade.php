@extends('master')

@section('header')
    <h1>
        SOAP FARMASI</h1>
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
                @include('emr.modules.addons.tabs')
                <div class="col-md-12">
                    @if (!$emr)
                        <form method="POST" action="{{ url('save-emr-farmasi') }}" class="form-horizontal">
                        @else
                            <form method="POST" action="{{ url('update-soap-farmasi') }}" class="form-horizontal">
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
                                                {{ baca_poli(@$val_a->registrasi->poli_id) }}
                                            </th>
                                        </tr>
                                        <tr style="background-color:#9ad0ef">
                                            <th>{{ @date('d-m-Y, H:i', strtotime($val_a->created_at)) }}</th>
                                            <th>
                                                {{ @$val_a->user->name }}
                                            </th>
                                        </tr>

                                        <tr>
                                            <td colspan="2"><b>S:</b> {!! $val_a->subjective !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>O:</b> {!! $val_a->objective !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>A:</b> {!! $val_a->asesmen !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>P:</b> {!! $val_a->planning !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>E:</b> {!! $val_a->edukasi !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="" style="font-size:15px;">
                                                <p>
                                                    @if (Auth::user()->id == $val_a->user_id)
                                                        <span class="pull-right">
                                                            <a href="{{ url('/emr/duplicate-soap-farmasi/' . $val_a->id . '/' . @$reg->id) }}"
                                                                onclick="return confirm('Yakin akan menduplikat data?')"
                                                                data-toggle="tooltip" title="Duplikat"><i
                                                                    class="fa fa-copy"></i></a>&nbsp;&nbsp;
                                                            <a href="{{ url('/emr/soap-farmasi/' . $unit . '/' . @$reg->id . '/' . $val_a->id . '/edit?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                                                                data-toggle="tooltip" title="Edit"><i
                                                                    class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                                            <a href="{{ url('/emr/soap-farmasi-delete/' . $val_a->id . '/delete') }}"
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
                                    <td><b>SUBJECTIVE</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="subjective">{{ $emr ? $emr->subjective : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50px;"><b>OBJECTIVE</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="objective">{{ $emr ? $emr->objective : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>ASESMEN</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="asesmen">{{ $emr ? $emr->asesmen : '' }}</textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>PLANNING</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="planning">{{ $emr ? $emr->planning : '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>EDUKASI</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="edukasi">{{ $emr ? $emr->edukasi : '' }}</textarea>
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
                                    <td><b>SUBJECTIVE</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" rows="5" class="form-control" name="subjective"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50px;"><b>OBJECTIVE</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="objective"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>ASESMEN</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="5" name="asesmen"></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>PLANNING</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="planning"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>EDUKASI</b></td>
                                    <td style="padding: 5px;">
                                        <textarea style="resize: vertical;" class="form-control" rows="3" name="edukasi"></textarea>
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
                    {{-- <hr />
                    <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}"
                        class="form-horizontal">
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', @$reg->id) !!}
                        {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                        {!! Form::hidden('cara_bayar', @$reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                    </form> --}}
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
