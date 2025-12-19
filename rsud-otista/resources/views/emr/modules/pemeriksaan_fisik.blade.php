@extends('master')

<style>
    #canvas_div {
        text-align: center;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    canvas {
        border: 2px solid black;
    }
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
    <h1>Penilaian Status Lokalis</h1>
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            {{-- <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script> --}}

            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/fisikumum/'.$unit.'/'.$reg->id) }}" class="form-horizontal">                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        <br>


                      {{-- @php
                         dd($riwayat[0]);
                      @endphp --}}

                      
                      <form action=""></form>
                        {{-- Anamnesis --}}
                        <div class="col-md-6">


                            <input type="hidden" name="type" value="gigi">




                            <h5><b>Pemeriksaan Fisik</b></h5>
                            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                                   style="font-size:12px;">
                                <tr>
                                    {{-- <td style="width:20%;">Alat Bantu</td> --}}
                                    <td style="padding: 5px;">
                                    
                                        <textarea rows="15" name="fisik[pemeriksaan]" style="display:inline-block" placeholder="[ Masukan Data Pemeriksaan Fisik ]" id="fisik" class="form-control" required></textarea></td>
                                
                                      </td>
                                    
                                </tr>

                            </table>

                            <div class="col-md-12 text-right">
                              <button class="btn btn-success">Simpan Data</button>
                            </div>

                        </div>
                        {{-- Alergi --}}
                        <div class="col-md-6">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h5><b>Catatan Medis</b></h5>
                                </div>
                                <div class="box-body table-responsive" style="max-height: 400px">
                                    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                                           style="font-size:12px;">
                                        @if (count($riwayat) == 0)
                                            <tr>
                                                <td><i>Belum ada catatan</i></td>
                                            </tr>
                                        @endif 
                                        @foreach ($riwayat as $item)
                                            <tr>
                                                <td>
                                                    <b>Keterangan	:</b> {{json_decode($item->fisik,true)['pemeriksaan']}}<br/>
                                                    {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                        <br /><br />


                    </div>
                </div>

            </form>
        </div>

        @endsection