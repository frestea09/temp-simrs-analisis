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
    /* Warna merah untuk tanggal merah yang di-disable */
.libur-merah.disabled,
.libur-merah span,
.libur-merah {
    color: red !important;
    font-weight: bold;
    opacity: 1 !important; /* supaya tidak pudar */
}

/* Jika ingin background juga agak beda */
.libur-merah.disabled.active,
.libur-merah:hover {
    background-color: #ffe6e6 !important;
}
</style>
@section('header')
    <h1>SURKON</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


            @include('emr.modules.addons.profile')

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                    </div>
                    {{-- Anamnesis --}}
                    <div class="col-md-12">
                        <h5><b>Surat Kontrol</b></h5><br />
                        <form method="POST" action="{{ url('save-resume-medis') }}" id="formSK" class="form-horizontal">
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('diagnosa_awal', null) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('proses_tte', false, ['id' => 'proses-tte']) !!}
                            {!! Form::hidden('nik', false, ['id' => 'nik']) !!}
                            {!! Form::hidden('passphrase', false, ['id' => 'passphrase']) !!}
                            <div class="form-group">
                                <label for="no_sep" class="col-md-2 control-label">NO.SEP</label>
                                <div class="col-md-10">
                                    <input type="text" name="no_sep" value="{{ $reg->no_sep }}" class="form-control"
                                        autocomplete="off" required readonly>
                                    <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">
                                {!! Form::label('rencana_kontrol', 'Tgl.Rencana Kontrol', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('rencana_kontrol', date('d-m-Y'), [
                                        'class' => 'form-control date_tanpa_tanggal',
                                        'id' => 'rencana_kontrol',
                                        'autocomplete' => 'off',
                                    ]) !!}
                                    <small class="text-danger">{{ $errors->first('rencana_kontrol') }}</small>

                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">
                                {!! Form::label('rencana_kontrol', 'Poli', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    <select name="poli_id" class="form-control select2" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($poli as $d)
                                            <option value="{{ $d->bpjs }}"
                                                {{ $d->id == $reg->poli_id ? 'selected' : '' }}>{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">
                                {!! Form::label('kode_dokter', 'DPJP', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    <select name="kode_dokter" class="form-control select2" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($dokter as $d)
                                            <option value="{{ $d->kode_bpjs }}"
                                                {{ $d->id == $reg->dokter_id ? 'selected' : '' }}>{{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no_sep" class="col-md-2 control-label">Catatan</label>
                                <div class="col-md-10">
                                    <textarea name="" id=""  rows="10" style="width: 100%" name="catatan" class="form-control"></textarea>
                                    <small class="text-danger">{{ $errors->first('catatan') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">
                                {!! Form::label('No. Kontrol', 'No. Kontrol', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8" id="fieldSEP">
                                    {!! Form::text('no_surat_kontrol', null, ['readonly' => true, 'class' => 'form-control', 'id' => 'noSk']) !!}
                                    <small class="text-danger">{{ $errors->first('no_surat_kontrol') }}</small>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="createSK" class="btn btn-primary btn-flat" style="width:100%">BUAT
                                        NO.KNTRL</button>
                                </div>
                            </div>

                            <br>

                            <div class="form-group text-right">
                                {{-- <button type="submit" class="btn btn-warning btn-flat">CETAK</button> --}}
                                <button type="submit" class="btn btn-success btn-flat">SIMPAN</button>
                            </div>
                    </div>


                    <br /><br />
                </div>


            </div>

            {{-- <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div> --}}
            </form>
            <br />
            <br />
            <div class="col-md-12 text-right">
                <table class="table-striped table-bordered table-hover table-condensed form-box table"
                    style="font-size:12px;" id="data">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Kontrol</th>
                            <th>No. SEP</th>
                            <th>Poli</th>
                            <th>DPJP</th>
                            <th>Catatan</th>
                            <th>Tgl.Rencana Kontrol</th>
                            <th>TTE</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rencana_kontrol as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->no_surat_kontrol }}</td>
                                <td>{{ $item->no_sep }}</td>
                                <td>{{ @baca_poli($item->poli_id) }}</td>
                                <td>{{ @baca_dokter($item->dokter_id) }}</td>
                                <td>-</td>
                                <td>{{ date('d-m-Y', strtotime($item->tgl_rencana_kontrol)) }}</td>
                                <td>
                                    @if (!empty(json_decode(@$item->tte)->base64_signed_file))
                                        <button class="btn btn-sm btn-danger proses-tte-surat-kontrol" data-surkon-id="{{$item->id}}">Tanda Tangan Elektronik Ulang</button>
                                    @else
                                        <button class="btn btn-sm btn-success proses-tte-surat-kontrol" data-surkon-id="{{$item->id}}">Tanda Tangan Elektronik</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('cetak-rencana-kontrol/' . $item->id)}}" class="btn btn-sm btn-warning">Cetak</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Modal TTE Surat Kontrol-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-surat-kontrol" action="{{ url('tte-surkon') }}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE Surat Kontrol</h4>
            </div>
            <div class="modal-body row" style="display: grid;">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}">
                <input type="hidden" class="form-control" name="surkon_id">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Nama:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">NIK:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
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
            <button type="submit" class="btn btn-primary" id="button-proses-tte-surat-kontrol">Proses TTE</button>
            </div>
        </div>
        </form>
    
        </div>
    </div>
    @endsection

    @section('script')
        <script type="text/javascript">
            $('.select2').select2();
           $.getJSON("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json", function (data) {
                const tanggalMerah = Object.keys(data)
                    .filter(key => data[key].holiday === true)
                    .map(key => {
                        const [y, m, d] = key.split("-");
                        return `${d}-${m}-${y}`;
                    });

                $(".date_tanpa_tanggal").datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    beforeShowDay: function (date) {
                        const d = ("0" + date.getDate()).slice(-2);
                        const m = ("0" + (date.getMonth() + 1)).slice(-2);
                        const y = date.getFullYear();
                        const dateStr = `${d}-${m}-${y}`;
                        const day = date.getDay(); // 0 = Minggu

                        // Hari Minggu
                        if (day === 0) {
                            return {
                                enabled: false,
                                classes: "libur-merah",
                                tooltip: "Hari Minggu"
                            };
                        }

                        // Tanggal merah nasional
                        if (tanggalMerah.includes(dateStr)) {
                            return {
                                enabled: false,
                                classes: "libur-merah",
                                tooltip: data[`${y}-${m}-${d}`]?.description || "Tanggal Merah"
                            };
                        }

                        return true;
                    }
                });
            });
            $("#date_dengan_tanggal").attr('required', true);

            $('#createSK').on('click', function() {
                $("input[name='no_surat_kontrol']").val(' ');
                $.ajax({
                        url: '{{ url('/bridgingsep/buat-surat-kontrol') }}',
                        type: 'POST',
                        data: $("#formSK").serialize(),
                        processing: true,
                    })
                    .done(function(res) {
                        data = JSON.parse(res)
                        if (data[0].metaData.code !== "200") {
                            return alert(data[0].metaData.message)
                        }
                        $("input[name='no_surat_kontrol']").val(data[1].noSuratKontrol);
                        $("input[name='diagnosa_awal']").val(data[1].namaDiagnosa);
                    });
            });

            $('.proses-tte-surat-kontrol').click(function (e) {
                e.preventDefault();
                $('#myModal').modal('show');
                $("input[name='surkon_id']").val($(this).data("surkon-id"));
            })
        </script>
    @endsection
