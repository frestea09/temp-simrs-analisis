@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 80px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }

    .scroll-umum {
        width: 100%;
        overflow-y: scroll;
        height: 40%;
        display: block;
    }
</style>
@section('header')
    <h1>Anamnesis - Umum</h1>
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
            <form method="POST" action="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        <br>
                        <div class="col-md-12">
                            {{-- Anamnesis --}}
                            <div class="col-md-6">
                                <h5><b>Umum</b></h5>
    
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td style="width:20%;">Keluhan Utama</td>
                                        <td style="padding: 5px;">
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['keadaan_umum']))
                                                <input type="text" name="pemeriksaan[keadaan_umum]" class="form-control"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['keadaan_umum'] }}"
                                                    id="" required>
                                            @else
                                                <input type="text" name="pemeriksaan[keadaan_umum]" class="form-control"
                                                    id="" required>
                                            @endif
    
                                        </td>
                                    </tr>
                                    </tr>
                                    <td style="width:20%;">Riwayat Penyakit Sekarang :</td>
                                    <td style="padding: 5px;">
                                        @if (isset($riwayat[0]->keterangan2))
                                            <textarea rows="15" name="keterangan2" style="display:inline-block" placeholder="" class="form-control">{{ $riwayat[0]->keterangan2 }}</textarea>
                                    </td>
                                @else
                                    <textarea rows="15" name="keterangan2" style="display:inline-block" placeholder="" class="form-control"></textarea>
                                    </td>
                                    @endif
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Kesadaran</td>
                                        <td style="padding: 5px;">
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['kesadaran']))
                                                <input type="text" name="pemeriksaan[kesadaran]" class="form-control"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['kesadaran'] }}"
                                                    id="" required>
                                            @else
                                                <input type="text" name="pemeriksaan[kesadaran]" class="form-control"
                                                    id="" required>
                                            @endif
    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Tekanan Darah (Sistolik/Distolik) mmHg :</td>
                                        <td style="padding: 5px;">
    
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['tekanan_darah']))
                                                <input style="width:30%;display:inline-block" type="number"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['tekanan_darah'][0] }}"
                                                    name="pemeriksaan[tekanan_darah][]" class="form-control" required /> /
                                                <input style="width:30%;display:inline-block" type="number"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['tekanan_darah'][1] }}"
                                                    name="pemeriksaan[tekanan_darah][]" class="form-control" />
                                        </td>
                                    @else
                                        <input style="width:30%;display:inline-block" type="number" value="0"
                                            name="pemeriksaan[tekanan_darah][]" class="form-control" required /> /
                                        <input style="width:30%;display:inline-block" type="number" value="0"
                                            name="pemeriksaan[tekanan_darah][]" class="form-control" /></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Suhu(OC)</td>
                                        <td style="padding: 5px;">
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['suhu']))
                                                <input type="text" name="pemeriksaan[suhu]" class="form-control"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['suhu'] }}"
                                                    id="" required>
                                            @else
                                                <input type="text" name="pemeriksaan[suhu]" class="form-control"
                                                    id="" required>
                                            @endif
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Saturasi O2</td>
                                        <td style="padding: 5px;">
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['saturasi']))
                                                <input type="text" name="pemeriksaan[saturasi]" class="form-control"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['saturasi'] }}"
                                                    id="" required>
                                            @else
                                                <input type="text" name="pemeriksaan[saturasi]" class="form-control"
                                                    id="" required>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Frekuensi Nadi (X/Menit)</td>
                                        <td style="padding: 5px;">
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['nadi']))
                                                <input type="text" name="pemeriksaan[nadi]" class="form-control"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['nadi'] }}"
                                                    id="" required>
                                            @else
                                                <input type="text" name="pemeriksaan[nadi]" class="form-control"
                                                    id="" required>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Frekuensi Nafas (X/Menit)</td>
                                        <td style="padding: 5px;">
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['nafas']))
                                                <input type="text" name="pemeriksaan[nafas]" class="form-control"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['nafas'] }}"
                                                    id="" required>
                                            @else
                                                <input type="text" name="pemeriksaan[nafas]" class="form-control"
                                                    id="" required>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Waktu Pemeriksaan</td>
                                        <td style="padding: 5px;">
                                            @if (isset(json_decode(@$riwayat[0]->tanda_vital, true)['waktu']))
                                                <input type="text" name="pemeriksaan[waktu]" class="form-control"
                                                    value="{{ json_decode(@$riwayat[0]->tanda_vital, true)['waktu'] }}"
                                                    id="" required>
                                            @else
                                                <input type="text" name="pemeriksaan[waktu]" class="form-control"
                                                    id="" required>
                                            @endif
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
                                        <table style="width: 100%"
                                            class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                            style="font-size:12px;">
                                            @if (count($riwayat) == 0)
                                                <tr>
                                                    <td><i>Belum ada catatan</i></td>
                                                </tr>
                                            @endif
    
    
    
                                            @foreach ($riwayat as $item)
                                                <tr>
                                                    <td>
                                                        <b>Keluhan Utama</b> :
                                                        {{ json_decode($item->tanda_vital, true)['keadaan_umum'] }}<br />
                                                        <b>Riwayat Sekarang :
                                                        </b>{{ json_decode($item->keterangan2, true) }}<br />
                                                        <b>Kesadaran</b> :
                                                        {{ json_decode($item->tanda_vital, true)['kesadaran'] }}<br />
                                                        <b>Tekanan Darah</b> :
                                                        {{ json_decode($item->tanda_vital, true)['tekanan_darah'][0] }}
                                                        /{{ json_decode($item->tanda_vital, true)['tekanan_darah'][1] }}<br />
                                                        <b>Frekuensi Nadi</b> :
                                                        {{ json_decode($item->tanda_vital, true)['nadi'] }}<br />
                                                        <b>Frekuensi Nafas</b> :
                                                        {{ json_decode($item->tanda_vital, true)['nafas'] }}<br />
                                                        <b>Suhu(OC)</b> :
                                                        {{ json_decode($item->tanda_vital, true)['suhu'] }}<br />
                                                        <b>Saturasi O2</b> :
                                                        {{ json_decode($item->tanda_vital, true)['saturasi'] }}<br />
                                                        <br /> {{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }}
                                                        <span class="pull-right">
                                                            <a onclick="return confirm('Yakin akan menghapus data?')"
                                                                href="{{ url('emr-soap/anamnesis/umum/' . $unit . '/' . $reg->id . '/' . $item->id . '/delete') }}"
                                                                data-toggle="tooltip" title="Hapus Data" style="color:red"><i
                                                                    class="fa fa-trash"></i></a>
                                                        </span>
    
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                {{-- <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div> --}}
            </form>
        </div>
    @endsection

    @section('script')
        <script type="text/javascript">
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
        </script>
    @endsection
