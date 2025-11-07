@extends('master')

@section('css')
<style>
    .blink_me {
        animation: blinker 4s linear infinite;
        color: red;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>
@endsection

@section('header')
    <h1>
        Sistem Rawat Inap
    </h1>
@endsection

@section('content')
    @php
        $biaya_diagnosa_awal = @\App\PaguPerawatan::find($rawatinap->pagu_diagnosa_awal)->biaya ?? 0;
    @endphp
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title pull-left">
                Total Tagihan Sementara Rp. {{ number_format($tagihan) }}
            </h3>
            <h3 class="box-title pull-right">Deposit : Rp.
                {{ number_format(App\Deposit::where('registrasi_id', $reg->id)->sum('nominal')) }}</h3>
        </div>
        <div class="box-header with-border">
            <h3 class="box-title pull-left">
                Biaya Diagnosa Awal {{"Rp. " . number_format($biaya_diagnosa_awal)}}
            </h3>
        </div>
        @if ($biaya_diagnosa_awal > 0)
            <div class="box-header with-border">
                    @php
                        $sisa_biaya  = $biaya_diagnosa_awal - $tagihan;
                        $sisa_persen = sprintf("%.2f", ($sisa_biaya / $biaya_diagnosa_awal) * 100);
                    @endphp
                    @if ($sisa_persen <= 0)
                        <h5 class="pull-left blink_me">
                            Melebihi Biaya Diagnosa Awal {{"Rp. " . number_format($tagihan - $biaya_diagnosa_awal)}}
                        </h5>
                    @else
                        <h5 class="pull-left {{$sisa_persen <= 20 ? 'blink_me' : ''}}">
                            Biaya Diagnosa Awal Tersisa {{"Rp. " . number_format($biaya_diagnosa_awal - $tagihan)}} ({{$sisa_persen . '%'}})
                        </h5>
                    @endif
            </div>
        @endif
        <div class="box-body">
            <div class="box box-info">
                <div class="box-body">
                    {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/entry-tindakan/save', 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('jenis', $reg->bayar) !!}
                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                    {!! Form::hidden('dokter_id', @$rawatinap->dokter_id ? @$rawatinap->dokter_id : $reg->dokter_id) !!}
                    <div class="row">
                        <div class="col-md-7">
                            {{-- <div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
                    {!! Form::label('dpjp', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                    <select class="form-control select2" style="width: 100%" name="tarif_id">
                            <option value="{{ $rawatinap->dokter_id }}">{{ baca_dokter($rawatinap->dokter_id) }}</option>
                        </select>
                      <small class="text-danger">{{ $errors->first('dpjp') }}</small>
                    </div>
                </div> --}}
                            {{-- <div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
                    {!! Form::label('dpjp', 'DPJP', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9"> 
                        <select name="dpjp" class="form-control select2" style="width: 100%">
                          @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                      <small class="text-danger">{{ $errors->first('dpjp') }}</small>
                    </div>
                </div> --}}

                            <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {{-- {!! Form::select('pelaksana', $dokter, session('pelaksana') ? session('pelaksana') : null, ['class' => 'select2', 'style'=>'width:100%']) !!} --}}
                                    <select name="pelaksana" class="select2 form-control" style="width: 100%">
                                        <option value="" selected>Pilih Pelaksana</option>
                                        @foreach ($dokter as $d)
                                            <option value="{{ $d->id }}"
                                                {{ @$rawatinap->dokter_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                </div>
                            </div>

                            {{-- <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                    {!! Form::label('perawat', 'Kepala Unit', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('perawat', $perawat, session('perawat') ? session('perawat') : null, ['class' => 'select2', 'style'=>'width:100%']) !!}
                        <small class="text-danger">{{ $errors->first('perawat') }}</small>
                    </div>
                </div> --}}

                            <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-2 control-label']) !!}
                                {{-- @foreach (Modules\Tarif\Entities\Tarif::where('jenis', 'TA')->get() as $d) --}}
                                {{-- {{ $d->namatarif }} |  --}}
                                <div class="col-sm-10">
                                    {{-- <select class="form-control chosen-select" name="tarif_id[]" multiple required>
                          <option value="" selecter>Pilih Tindakan</option>
                         @foreach ($tarif as $d)
                          <option  value="{{ $d->id }}">{{ $d->nama }} | {{$d->kode}} | {{ $d->total }} 
                            
                          </option>
                          @endforeach              
                      </select> --}}
                                    <select name="tarif_id[]" id="select2Multiple" class="form-control" required
                                        multiple></select>
                                    <small class="text-info">Pilihan Tarif mengikuti kolom pilihan <b>Kelas</b>, tanpa harus
                                        mutasi</small>
                                    <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                    <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                </div>
                                {!! Form::label('bayar', 'Bayar', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    <select name="cara_bayar_id" class="chosen-select">
                                        @foreach ($carabayar as $key => $item)
                                            @if ($key == $reg->bayar)
                                                <option value="{{ $key }}" selected>{{ $item }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
                                {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    <select name="kelas_id" class="select2 form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($kelas as $key => $item)
                                            <option value="{{ $key }}"
                                                {{ $key == @$rawatinap->kelas->id ? 'selected' : '' }}>{{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- {!! Form::select('kelas_id', $kelas, @$rawatinap->kelas->id, ['class' => 'select2 form-control',
                    'style'=>'width:100%', 'required' => 'required']) !!} --}}
                                    <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('waktu_visit_dokter') ? ' has-error' : '' }}">
                                {!! Form::label('waktu_visit_dokter', 'Waktu Visit Dokter', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" name="waktu_visit_dokter">
                                    <small class="text-danger">{{ $errors->first('waktu_visit_dokter') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                                {!! Form::label('cyto', 'Cito', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    <select name="cyto" id="cyto" class="form-control">
                                        <option value="" selected>Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('cyto') }}</small>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('eksekutif') ? ' has-error' : '' }}">
                                {!! Form::label('eksekutif', 'Eksekutif', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    <select name="eksekutif" id="eksekutif" class="form-control">
                                        <option value="" selected>Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('eksekutif') }}</small>
                                </div>
                            </div>
                            <input type="hidden" name="total_diskon" id="total_diskon" value="0">
                            {{-- <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                  {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    
                    <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                  </div>
                </div> --}}

                            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                </div>
                                <input type="hidden" name="dijamin" value="0">
                                <div class="col-sm-4">
                                    <div class="btn-group pull-left">
                                        {!! Form::submit('Simpan', [
                                            'class' => 'btn btn-success btn-flat',
                                            'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group{{ $errors->has('dijamin') ? ' has-error' : '' }}">
                    {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('dijamin') }}</small>
                    </div>
                </div> --}}



                            {!! Form::close() !!}

                        </div>

                        <div class="col-md-5">
                            <div class='table-responsive' style="overflow: hidden;">
                                <table class='table-striped table-bordered table-hover table-condensed table'>
                                    <tbody>
                                        <tr>
                                            <th>Nama Pasien</th>
                                            <td>{{ $reg->pasien->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. RM</th>
                                            <td>{{ $reg->pasien->no_rm }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $reg->pasien->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cara Bayar</th>
                                            <td>{{ baca_carabayar($reg->bayar) }}
                                                @if ($reg->bayar == '1')
                                                    @if (!empty($reg->tipe_jkn))
                                                        - {{ $reg->tipe_jkn }}
                                                    @endif
                                                @endif
                                                {{--  @if (!empty($reg->perusahaan_id))
                            - {{ $reg->perusahaan->nama }}
                          @endif  --}}
                                            </td>
                                        </tr>
                                        @if ($reg->bayar == '1')
                                            <tr>
                                                <th>No. SEP</th>
                                                <td>{{ $reg->no_sep ? $reg->no_sep : @\App\HistoriSep::where('registrasi_id', $reg->id)->first()->no_sep }}
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Hak Kelas JKN </th>
                                                <td>{{ $reg->hak_kelas_inap }}</td>
                                            </tr> --}}
                                        @endif
                                        <tr>
                                            {{-- <th>Kelas Perawatan </th> <td>{{ baca_kelas($reg->kelas_id) }}</td> --}}
                                            <th>Kelas Perawatan </th>
                                            <td>{{ baca_kelas(@$rawatinap->kelas_id) }}</td>
                                            @php
                                                session(['kelas_id' => @$reg->kelas_id]);
                                            @endphp
                                        </tr>
                                        {{-- <tr>
                                            <th>DPJP IGD</th>
                                            <td>{{ baca_dokter($reg->dokter_id) }}</td>
                                        </tr> --}}
                                        <tr>
                                            <th>DPJP UTAMA</th>
                                            <td> <b> {{ baca_dokter(@$rawatinap->dokter_id) }} </b></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Masuk</th>
                                            <td> {{ tanggal_eklaim(@$rawatinap->tgl_masuk) }} </td>
                                        </tr>
                                        <tr>
                                            <th>Kamar </th>
                                            <td>{{ baca_kamar(@$rawatinap->kamar_id) }}</td>
                                        </tr>
                                        <tr>
                                            <th>ICD 9</th>
                                            <td>
                                               @if (!empty($icd9))
                                                   {{ implode(',', $icd9) }}
                                               @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ICD 10</th>
                                            <td> 
                                                @if (!empty($icd10))
                                                    {{ implode(',', $icd10) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Diagnosa Awal</th>
                                            <th>
                                                <div class="form-group">
                                                    <div style="margin-left: 18px; width: 90%">
                                                        {{-- <input type="number" class="form-control" name="biaya_diagnosa_awal" value="{{$rawatinap->total_biaya_diagnosa_awal}}"> --}}
                                                        <select name="biaya_diagnosa_awal" class="form-control select2" id="" style="width: 100%;">
                                                            <option value="">-- Pilih --</option>
                                                            @foreach ($pagu as $p)
                                                                <option value="{{ $p->id }}" {{$p->id == @$rawatinap->pagu_perawatan_id ? 'selected' : ''}}>{{ $p->diagnosa_awal .' - '.$p->biaya }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <button class="btn btn-success" type="button" id="update_diagnosa_awal"><i class="fa fa-save"></i></button>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            {{-- ======================================================================================================================= --}}
            <div class="dataTindakanIrna">
                {{-- progress bar --}}
                <div class="progress progress-sm active">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">97% Complete</span>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <a href="{{ url('rawat-inap/billing') }}" class="btn btn-primary btn-sm btn-flat"><i
                        class="fa fa-step-backward"></i> SELESAI</a>
            </div>

        </div>
    </div>

    <div class="modal fade" id="editTindakanModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'class' => 'form-horizontal', 'id' => 'editTindakanForm']) !!}
                    <input type="hidden" name="folio_id" value="">
                    <input type="hidden" name="registrasi_id" value="">
                    <input type="hidden" name="id_tarif" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
                                {!! Form::label('dpjp', 'DPJP IRNA', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="dpjp" class="select2form-control" style="width: 100%">
                                        @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('dpjp') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="pelaksana" class="form-control" style="width: 100%">
                                        @foreach ($dokter as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                                {!! Form::label('perawat', 'Kepala Unit', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="perawat" class="form-control select2" style="width: 100%">
                                        @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('perawat') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="tarif_id" style="width: 100%">
                                        @foreach (Modules\Tarif\Entities\Tarif::whereIn('jenis', ['TI'])->get() as $d)
                                            <option value="{{ $d->id }}">{{ $d->kode }} |
                                                {{ $d->nama }} | {{ number_format($d->total) }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                    <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                                {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <select name="cara_bayar_id" class="select2 form-control" style="width: 100%">
                                        @foreach ($carabayar as $key => $item)
                                            @if ($key == $reg->bayar)
                                                <option value="{{ $key }}" selected>{{ $item }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('dijamin') ? ' has-error' : '' }}">
                                {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                                    <small class="text-danger">{{ $errors->first('dijamin') }}</small>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-flat"
                            onclick="saveEditTindakan()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    @stop


    @section('script')
        <script type="text/javascript">
            $(".skin-blue").addClass("sidebar-collapse");
            $(function() {
                //LOAD TINDAKAN IRNA
                var registrasi_id = $('input[name="registrasi_id"]').val()
                var loadData = $('.dataTindakanIrna').load('/rawat-inap/data-tindakan/' + registrasi_id);
                if (loadData == true) {
                    $('.progress').addClass('hidden')
                }
            });
            // status_reg = "<?= substr($reg->status_reg, 0, 1) ?>"
            status_reg = "I"
            var settings = {
                kelas_id: "<?= @$rawatinap->kelas_id ? $rawatinap->kelas_id : 8 ?>"
            };
            // $('select[name="kelas_id"]').change(function(){
            //   settings.kelas_id = $('select[name="kelas_id"]').val()
            // });
            // function getURL() {
            //     $('select[name="kelas_id"]').change(function(){
            //       settings.kelas_id = $('select[name="kelas_id"]').val()
            //     });
            //     let kelas_id = $('select[name="kelas_id"]').val()
            //     return '/tindakan/ajax-tindakan/'+status_reg+'/'+kelas_id;
            // }


            // console.log(settings.kelas_id)
            $('.select2').select2();

            let kelas_id = $('select[name="kelas_id"]').val()

            $('#select2Multiple').select2({
                placeholder: "Klik untuk isi nama tindakan",
                width: '100%',
                ajax: {
                    url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            j: 1,
                            q: $.trim(params.term)
                        };
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            })

            $('#update_diagnosa_awal').click(function (e) {
                e.preventDefault();
                if (confirm('Apakah anda yakin ingin mengganti Biaya Diagnosa awal?')) {
                    var registrasi_id = $('input[name="registrasi_id"]').val()
                    let biaya = $('select[name="biaya_diagnosa_awal"]').val()
                    $.ajax({
                        url: '/rawat-inap/entry-tindakan/update/pagu/' + registrasi_id,
                        type: 'POST',
                        data: {
                            "biaya_diagnosa_awal": biaya,
                            "_token": "{{ csrf_token() }}",
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data == "ok") {
                                location.reload();
                            }
                        }
                    });
                }
            })

            // on kelas change
            $('select[name="kelas_id"]').on('change', function() {
                kelas_id = $(this).val();
                console.log(kelas_id);
                $('#select2Multiple').select2({
                    placeholder: "Klik untuk isi nama tindakan",
                    width: '100%',
                    ajax: {
                        url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
                        dataType: 'json',
                        data: function(params) {
                            return {
                                j: 1,
                                q: $.trim(params.term)
                            };
                        },
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                })
            });

            function editTindakan(folio_id, tarif_id) {
                $('#editTindakanModal').modal('show');
                $('.modal-title').text('Edit Tindakan');
                $('.select2').select2();
                $.ajax({
                    url: '/rawat-inap/edit-tindakan/' + folio_id + '/' + tarif_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (tarif_id != 10000) {
                            $('input[name="folio_id"]').val(data.folio.id);
                            $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                            $('input[name="id_tarif"]').val(data.folio.tarif_id);

                            $('select[name="dpjp"]').val(data.dokter.dokter_id).trigger('change');
                            $('select[name="pelaksana"]').val(data.folio.dokter_pelaksana).trigger('change');
                            $('select[name="perawat"]').val(data.folio.perawat).trigger('change');
                            $('select[name="cara_bayar_id"]').val(data.folio.cara_bayar_id).trigger('change');
                            $('select[name="tarif_id"]').val(data.folio.tarif_id).trigger('change');
                            $('input[name="dijamin"]').val(data.folio.dijamin);
                        } else {
                            $('input[name="folio_id"]').val(data.folio.id);
                            $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                            $('input[name="id_tarif"]').val(data.folio.tarif_id);
                        }
                    }
                });
            }

            function saveEditTindakan() {
                var data = $('#editTindakanForm').serialize();
                $.ajax({
                    url: '/rawat-inap/save-edit-tindakan',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                        if (data.sukses == true) {
                            $('#editTindakanModal').modal('hide');
                            location.reload();
                        }
                    }
                });
            }

            function ribuan(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            $('select[name="kategoritarif_id"]').on('change', function() {
                var tarif_id = $(this).val();
                var reg_id = {{ $reg_id }}
                if (tarif_id) {
                    $.ajax({
                        url: '/rawat-inap/getKategoriTarifID/' + tarif_id + '/' + reg_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            //$('select[name="tarif_id"]').append('<option value=""></option>');
                            $('select[name="tarif_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="tarif_id"]').append('<option value="' + value.id +
                                    '">' + value.nama + ' | ' + ribuan(value.total) +
                                    '</option>');
                            });

                        }
                    });
                } else {
                    $('select[name="tarif_id"]').empty();
                }
            });

            // tindakan inhealth
            $(document).on('click', '.inhealth-tindakan', function() {
                let id = $(this).attr('data-id');
                let body = {
                    _token: "{{ csrf_token() }}",
                    poli: $('input[name="poli_inhealth"]').val(),
                    kodedokter: $('input[name="dokter_pelaksana_inhealth"]').val(),
                    nosjp: $('input[name="no_sjp_inhealth"]').val(),
                    jenispelayanan: $('input[name="jenis_pelayanan_inhealth"]').val(),
                    kodetindakan: $('input[name="kode_tindakan_inhealth"]').val(),
                    tglmasukrawat: $('input[name="tglmasukrawat"]').val()
                };
                if (confirm('Yakin akan di Sinkron Inhealth?')) {
                    $.ajax({
                        url: '/tindakan/inhealth/' + id,
                        type: "POST",
                        data: body,
                        dataType: "json",
                        beforeSend: function() {
                            $('button#btn-' + id).prop("disabled", true);
                        },
                        success: function(res) {
                            $('button#btn-' + id).prop("disabled", false);
                            if (res.status == true) {
                                $('button#btn-' + id).prop("disabled", true);
                                alert(res.msg);
                            } else {
                                alert(res.msg);
                            }
                        }
                    });
                }
            })
            $('select[name="bayar"]').on('change', function() {
                $.get('/tindakan/updateCaraBayar/' + $(this).attr('id') + '/' + $(this).val(), function() {
                    location.reload();
                });
            })
        </script>
    @endsection
