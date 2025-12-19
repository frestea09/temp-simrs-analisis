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
    <h1>Perencanaan - Laporan Tindakan Rawat Jalan</h1>
@endsection

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
            @include('emr.modules.addons.profile')
            <form id="form-create-laporan-tindakan" method="POST" action="{{ url('emr-soap/perencanaan/tindakan-rj/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-bottom: 20px">
                            @include('emr.modules.addons.tabs')
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('poli', $poli) !!}
                            {!! Form::hidden('dpjp', $dpjp) !!}
                            {!! Form::hidden('proses_tte', false, ['id' => 'proses-tte']) !!}
                            {!! Form::hidden('nik', false, ['id' => 'nik']) !!}
                            {!! Form::hidden('passphrase', false, ['id' => 'passphrase']) !!}
                            {!! Form::hidden('method', @$method) !!}
                        </div>
                        
                        <br>
                        {{-- Anamnesis --}}
                        <div class="col-md-6" >
                            <h5><b>{!!$method? '<span style="color:blue">[Duplikat]</span> ':''!!}Laporan Tindakan Rawat Jalan</b></h5>
                            {!!$method? '<span style="color:green">Jika data sudah sesuai, Klik <b>SIMPAN</b> untuk menduplikat</span> ':''!!}
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:20%;">Tangal Tindakan</td>
                                    <td style="padding: 5px;">
                                        <input type="date" value="{{ date('Y-m-d') }}" name="tgl_tindakan" class="form-control" />
                                        <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan kalender</small>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="width:20%;">Dokter</td>
                                    <td style="padding: 5px;">
                                        <select name="dokter_id" class="form-control select2" style="width: 100%">
                                            @php
                                                if(isset($asessment->dokter)){
                                                    @$dokt = $asessment->dokter;
                                                }else{
                                                    @$dokt = $reg->dokter_id;
                                                }
                                            @endphp
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ $d->id == @$dokt ? 'selected' : '' }}>{{ $d->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Asisten</td>
                                    <td style="padding: 5px;">
                                        <select name="perawat_id" class="form-control select2" style="width: 100%">
                                            <option value="" selected disabled hidden>-- Pilih Perawat -- </option>
                                            @foreach ($perawat as $d)
                                                <option value="{{ $d->id }}" {{@$asessment->asisten == $d->id ?'selected':''}}>{{ $d->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Diagnosa</td>
                                    <td style="padding: 5px;">
                                        <input type="text" class="form-control" name="diagnosa" value="{{@$asessment->diagnosa}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Tindakan</td>
                                    <td style="padding: 5px;">
                                        <input type="text" class="form-control" name="tindakan" value="{{@$asessment->tindakan}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Uraian Tindakan</td>
                                    <td style="padding: 5px;">
                                        <textarea rows="4" name="uraian_tindakan" style="display:inline-block; resize:vertical;"
                                            placeholder="[Isi Uraian]" class="form-control">{{@$asessment->uraian_tindakan}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Instruksi Post Tindakan</td>
                                    <td style="padding: 5px;">
                                        <textarea rows="4" name="instruksi" style="display:inline-block; resize:vertical;"
                                            placeholder="[Isi Instruksi]" class="form-control">{{@$asessment->instruksi}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Jaringan Yang di Eksisi</td>
                                    <td style="padding: 5px;">
                                        <input type="text" class="form-control" name="eksisi" value="{{@$asessment->jaringanEksisi}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Dikirim Ke PA</td>
                                    <td style="padding: 5px;">
                                        <input type="radio" name="pa" value="YA" {{@$asessment->sendToPA == 'YA' ? 'checked' :''}} id="pa.true">
                                        <label for="pa.true">YA</label>
                                        <input type="radio" name="pa" value="TIDAK" {{@$asessment->sendToPA == 'TIDAK' ? 'checked' :''}} id="pa.false">
                                        <label for="pa.false">Tidak</label>
                                    </td>
                                </tr>
                                
                            </table>
                            <div class="col-md-12 text-right">
                                {{-- <button class="btn btn-success" id="proses-tte-laporan-tindakan">Simpan & TTE</button> --}}
                                <button class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h5><b>Riwayat</b></h5>
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
                                            @php
                                                $ket = json_decode($item->keterangan);
                                            @endphp
                                            <tr>
                                                <td>
                                                    @if ($item->diagnosis)
                                                    
                                                    <i class="pull-right">Hasil Duplikat</i>
                                                    @endif
                                                    <b>Tanggal Tindakan :</b> {{ date('d-m-Y', strtotime(@$ket->tgl_tindakan)) }}<br/>
                                                    <b>Dokter :</b> {{ baca_dokter(@$item->dokter_id) }} 
                                                    <br/>
                                                    <b>Asisten :</b> {{ baca_pegawai(@$ket->asisten) }}  <br/>
                                                    <b>Diagnosa :</b> {{ $ket->diagnosa }}
                                                    <br />
                                                    <b>Tindakan :</b> {{ $ket->tindakan }}
                                                    <br />
                                                    <b>Uraian Tindakan :</b> {{ $ket->uraian_tindakan }}
                                                    <br />
                                                    <b>Instruksi Post Tindakan :</b> {{ $ket->instruksi }}
                                                    <br />
                                                    <b>Jaringan Yg di Eksisi :</b> {{ $ket->jaringanEksisi }}
                                                    <br />
                                                    <b>Dikirim ke PA :</b> {{ $ket->sendToPA }}
                                                    <br />
                                                    
                                                    {{-- <b>Dibuat Pada : </b>{{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }} --}}
                                                    
                                                    <br>
                                                    <span class="pull-right">
                                                        {{-- <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-rawatinap/perencanaan/surat/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp; --}}
                                                        <a target="_blank"
                                                            style="font-size: 20px"
                                                            href="{{ url('emr-soap-print-laporan-tindakan-rj/' . $reg->id . '/' . $item->id) }}"
                                                            data-toggle="tooltip" title="Cetak Surat"><i
                                                                class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
                                                        
                                                                <a 
                                                            style="font-size: 20px"
                                                            href="{{ url('/emr-soap/perencanaan/tindakan-rj/'.$unit.'/' . $reg->id . '/' . $item->id.'/duplicate?poli='.$poli.'&dpjp='.$dpjp) }}"
                                                            data-toggle="tooltip" title="Duplikat Laporan"><i
                                                                class="fa fa-copy text-primary"></i></a>&nbsp;&nbsp;
                                                        
                                                        <a 
                                                            style="font-size: 20px"
                                                            href="{{url('/emr-soap-delete/perencanaan/tindakan-rj/'.$unit.'/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                                                            
                                                    </span>
                                                    <a target="_blank"
                                                        href="{{ url('/signaturepad/persetujuan-pasien/' . $item->id) }}"
                                                        class="btn btn-primary btn-sm btn-flat"
                                                        data-toggle="tooltip" title="Inform Consent Pasien">Consent Pasien</a>&nbsp;&nbsp;
                                                </td>
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
            <br />
            <br />

        </div>


        <!-- Modal TTE Laporan Tindakan-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
        <form id="form-tte-laporan-tindakan" action="{{ url('tte-pdf-laporan-tindakan') }}" method="POST">
        <input type="hidden" name="id">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE Laporan Tindakan</h4>
            </div>
            <div class="modal-body row" style="display: grid;">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{@Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Nama:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dokter" id="dokter" value="{{@Auth::user()->pegawai->nama}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">NIK:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" value="{{@substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase_modal" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
                </div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="button-proses-tte-laporan-tindakan">Proses TTE</button>
            </div>
        </div>
        </form>
    
        </div>
    </div>
    @endsection

    @section('script')
        <script type="text/javascript">
            //ICD 10

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

        <script>
            $('#proses-tte-laporan-tindakan').click(function (e) {
                e.preventDefault();
                $('#myModal').modal('show');
            })

            $('#button-proses-tte-laporan-tindakan').click(function (e) {
                e.preventDefault();
                $('#proses-tte').val(true)
                $('#nik').val($('#nik_hidden').val())
                $('#passphrase').val($('#passphrase_modal').val())
                $('#form-create-laporan-tindakan')[0].submit();
            })
        </script>
    @endsection
