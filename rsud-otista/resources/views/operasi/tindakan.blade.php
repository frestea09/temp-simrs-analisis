@extends('master')

@section('header')
<h1>
  Operasi
</h1>
@endsection

@section('content')
<div class="box box-primary">

  <div class="box-body">
    <div class="box box-info">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No. RM</th>
              <th>Nama </th>
              <th>Kelas</th>
              <th>Kamar</th>
              <th>Bed</th>
              <th>Cara Bayar</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ @$reg->pasien->no_rm }}</td>
              <td>{{ @$reg->pasien->nama }}</td>
              <td>{{ !empty($irna) ? @$irna->kelas->nama : NULL }}</td>
              <td>{{ !empty($irna) ? @$irna->kamar->nama : NULL }}</td>
              <td>{{ !empty($irna) ? @$irna->bed->nama : NULL }}</td>
              <td>{{ baca_carabayar($reg->bayar) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'operasi/simpantindakan', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('registrasi_id', $reg->id) !!}
        {!! Form::hidden('jenis', $reg->bayar) !!}
        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
        {!! Form::hidden('unit', $unit) !!}
        {!! Form::hidden('dpjp', $reg->dokter_id) !!}
        @if ($irna)
          {!! Form::hidden('rawatinap_id', @$irna->id) !!}
            
        @endif
        <div class="row">
          <div class="col-md-6">
            {{--<div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
              {!! Form::label('dpjp', 'Dokter Pelaksana', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="dpjp" class="form-control select2">
                  <option value=""></option>
                  @foreach ($dokter as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <input class="form-control" type="text"
                  value="{{ \Modules\Pegawai\Entities\Pegawai::where('id', $reg->dokter_id)->first()->nama }}" readonly>
              </div>
            </div>--}}
            {{--<div class="form-group{{ $errors->has('penanggung_jawab') ? ' has-error' : '' }}">
              {!! Form::label('penanggung_jawab', 'Penanggung jawab ruangan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="penanggung_jawab" class="form-control select2">
                  @foreach ($pj as $d)
                  <option value="{{ $d->id }}" {{ ($d->id == 80) ? 'selected' : '' }}>{{ @$d->nama }}</option>
                  @endforeach
                </select>
                {!! Form::select('penanggung_jawab', $dokter, 'null', ['class' => 'form-control select2', 'required' =>
                'required']) !!}
                <small class="text-danger">{{ $errors->first('penanggung_jawab') }}</small>
              </div>
            </div>--}}
            {{--<div class="form-group{{ $errors->has('dokter_anestesi') ? ' has-error' : '' }}">
              {!! Form::label('dokter_anestesi', 'Dokter Anestesi', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="dokter_anestesi" class="form-control select2">
                  <option value=""></option>
                  @foreach ($anestesi as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                {!! Form::select('dokter_anestesi', $dokter, 'null', ['class' => 'form-control select2'
                ]) !!}
                <small class="text-danger">{{ $errors->first('dokter_anestesi') }}</small>
              </div>
            </div>--}}
            @php
            $dokter_id = @$irna ? @$irna->dokter_id : $reg->dokter_id;
            @endphp
            <div class="form-group{{ $errors->has('dokter_bedah') ? ' has-error' : '' }}">
              {!! Form::label('dokter_bedah', 'Dokter Bedah', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="dokter_bedah" class="form-control select2">
                  <option value="" selected>-- Pilih --</option>
                  @foreach ($dokter as $d)
                  <option value="{{ $d->id }}" {{$d->id == @$irna->dokter_id ? 'selected' : ''}}>{{ $d->nama }}</option>
                  @endforeach
                </select>
                {{--{!! Form::select('dokter_bedah', $dokter, 'null', ['class' => 'form-control select2', 'required' =>
                'required']) !!}--}}
                <small class="text-danger">{{ $errors->first('dokter_bedah') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('dokter_bedah') ? ' has-error' : '' }}">
              {!! Form::label('dokter_anestesi', 'Dokter Anestesi', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="dokter_anestesi" class="form-control select2" {{$unit !== 'odc' ? :''}} >
                  <option value="">-- Pilih --</option>
                  @foreach ($dokter as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('dokter_anestesi') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('dokter_anak') ? ' has-error' : '' }}">
              {!! Form::label('dokter_anak', 'Dokter Anak', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="dokter_anak" class="form-control select2" {{$unit !== 'odc' ? :''}} >
                  <option value="">-- Pilih --</option>
                  @foreach ($dokter_anak as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('dokter_anak') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
              {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="perawat" class="form-control select2" {{ $unit !== 'odc' ? '' : '' }} required>
                  <option value="">-- Pilih --</option>
                  @foreach ($perawat as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('perawat') }}</small>
              </div>
            </div>

            {{-- <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
              {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="perawat" class="form-control select2">
                  <option value="">-- Pilih --</option>
                  <option value="1">Perawat Bedah</option>
                  <option value="2">Perawat Anestesi</option>
                </select>
                <small class="text-danger">{{ $errors->first('perawat') }}</small>
              </div>
            </div> --}}

            {{-- <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
              {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select class="form-control chosen-select" name="tarif_id">
                  @foreach(Modules\Tarif\Entities\Tarif::where('jenis', 'TA')->get() as $d)
                  <option value=""></option>
                  @foreach($tarif as $d)
                  <option value="{{ $d->id }}">{{ $d->namatarif }} | {{ $d->nama }} | {{ number_format($d->total) }}
                    @if($d->carabayar == 1)
                    <b class="pull-right text-green">&nbsp&nbsp&nbsp&nbsp [ JKN ]</b>
                    @elseif($d->carabayar == 2)
                    <b class="pull-right text-blue">&nbsp&nbsp&nbsp&nbsp [ Umum ]</b>
                    @endif
                  </option>
                  @endforeach
                </select>
                <select class="form-control tarif" name="tarif_id" id="tarif_id"></select>
                {!! Form::select('tarif_id', $tarif, 'null', ['class' => 'form-control select2', 'required' =>
                'required']) !!}
                <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
              </div>
            </div> --}}


            {{-- <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
              {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                 
                <select name="tarif_id[]" id="select2Multiple" class="form-control" required
                  multiple="multiple"></select>
                <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
              </div>
            </div> --}}


            <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
              {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('jumlah') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
              {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {!! Form::select('cara_bayar_id', $carabayar, $reg->bayar, ['class' => 'select2 form-control',
                'style'=>'width:100%', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
              </div>
            </div>
            @if ($reg->bayar == 1)
              <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                {!! Form::label('no_jkn', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                  <input type="number" name="no_jkn" class="form-control" id="" value="{{$reg->pasien->no_jkn}}">
                  <small class="text-danger">No.Kartu wajib sesuai karena akan dikirim ke WS BPJS</small>
                </div>
              </div>
              <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                {!! Form::label('poli_id', 'Poli Tujuan', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                  <select name="poli_id" class="form-control select2" style="width: 100%" required>
                    <option value="{{$reg->poli_id}}">{{baca_poli($reg->poli_id)}}</option>
                    @foreach ($polis as $d)
                      <option value="{{ $d->id }}" {{session('poli_operasi') == $d->id ? 'selected' : @$reg->poli_id}}>{{ $d->nama }}</option>
                    @endforeach
                  </select>
                  <small class="text-danger">Poli tujuan operasi (hanya diisi sekali saja)</small>
                </div>
              </div>
            @endif


          </div>
          <div class="col-md-6">
            {{-- <div class="form-group{{ $errors->has('perawat_bedah1') ? ' has-error' : '' }}">
              {!! Form::label('perawat_bedah1', 'Perawat', ['class' => 'col-sm-4 control-label', 'placeholder'=>'']) !!}
              <div class="col-sm-8">
                <select name="perawat_bedah1" class="form-control select2">
                  <option value=""></option>
                  @foreach ($pj as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('perawat_bedah1') }}</small>
              </div>
            </div> --}}
            {{--<div class="form-group{{ $errors->has('perawat_bedah2') ? ' has-error' : '' }}">
              {!! Form::label('perawat_bedah2', 'Perawat 2', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="perawat_bedah2" class="form-control select2">
                  @foreach ($pj as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                {!! Form::select('perawat_bedah2', $dokter, 'null', ['class' => 'form-control select2', 'required' =>
                'required']) !!}
                <small class="text-danger">{{ $errors->first('perawat_bedah2') }}</small>
              </div>
            </div>--}}
            {{-- <div class="form-group{{ $errors->has('ass_anestesi') ? ' has-error' : '' }}">
              {!! Form::label('perawat', 'Penata Anestesi', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="ass_anestesi" class="form-control select2">
                  <option value=""></option>
                  @foreach ($pj as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('ass_anestesi') }}</small>
              </div>
            </div> --}}
            {{-- <div class="form-group{{ $errors->has('ass_operator') ? ' has-error' : '' }}">
              {!! Form::label('ass_operator', 'Ass Operator', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="ass_operator" class="form-control select2">
                  <option value=""></option>
                  @foreach ($pj as $d)
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('ass_operator') }}</small>
              </div>
            </div> --}}
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
              {!! Form::label('rencana_operasi', 'Rencana Operasi', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {!! Form::text('rencana_operasi', date('d-m-Y'), ['class' => 'form-control datepicker','placeholder'=>'Jika
                kosong,otomatis terisi tgl sekarang']) !!}
                <small class="text-danger">{{ $errors->first('tanggal') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
              {!! Form::label('catatan', 'Catatan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <input type="text" style="width:100%;" class="form-control" value="{{session('catatan')}}" name="catatan" placeholder="Isikan Suspect/Catatan Lain Disini">
                <small class="text-danger">{{ $errors->first('catatan') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
              {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="kelas_id" class="select2 form-control" id="kelas_id">
                  <option value="">-- Pilih --</option>
                  @foreach ($kelas as $key=>$item)
                    <option value="{{$key}}" {{$key == @$irna->kelas->id ? 'selected' :'' }}>{{$item}}</option>
                  @endforeach
                </select>
                {{-- {!! Form::select('kelas_id', $kelas, @$irna->kelas->id, ['class' => 'select2 form-control',
                'style'=>'width:100%', 'required' => 'required']) !!} --}}
                <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
              {!! Form::label('kamar_id', 'Kamar', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                <select name="kamar_id" class="select2 form-control">
                  <option value="">-- Pilih --</option>
                  @foreach ($kamar as $key=>$item)
                    <option value="{{$key}}" {{$key == @$irna->kamar->id ? 'selected' :'' }}>{{$item}}</option>
                  @endforeach
                </select>
                {{-- {!! Form::select('kamar_id', $kamar, @$irna->kamar->id, ['class' => 'select2 form-control',
                'style'=>'width:100%', 'required' => 'required']) !!} --}}
                <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
              {!! Form::label('tanggal', 'Tanggal Input', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker','placeholder'=>'Jika
                kosong,otomatis terisi tgl sekarang']) !!}
                <small class="text-danger">{{ $errors->first('tanggal') }}</small>
              </div>
            </div>
            

            {{-- <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
              {!! Form::label('cyto', 'Cito', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-7">
                <select name="cyto" class="form-control">
                  <option value="" selected>Tidak</option>
                  <option value="1">Ya</option>
                </select>
                <input type="hidden" name="cyto" value="">
                <input type="checkbox" name="cyto" value="1"> <i>&nbsp;&nbsp;&nbsp;Centang Jika cito</i>
                <small class="text-danger">{{ $errors->first('cyto') }}</small>
              </div>
            </div> --}}

            <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
              {!! Form::label('cyto', 'Cito', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  <select name="cyto" id="cyto" class="form-control">
                      <option value="" selected>Tidak</option>
                      <option value="1">Ya</option>
                  </select>
                  <small class="text-danger">{{ $errors->first('cyto') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('eksekutif') ? ' has-error' : '' }}">
              {!! Form::label('eksekutif', 'Eksekutif', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  <select name="eksekutif" id="eksekutif" class="form-control">
                      <option value="" selected>Tidak</option>
                      <option value="1">Ya</option>
                  </select>
                  <small class="text-danger">{{ $errors->first('eksekutif') }}</small>
              </div>
          </div>
          <input type="hidden" name="total_diskon" id="total_diskon" value="0">
   
          </div>
          <div class="col-md-12">
            <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
              {!! Form::label('tarif_id', 'Tindakan Operasi', ['class' => 'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <select name="tarif_id[]" id="select2Multiple" class="form-control" required
                  multiple="multiple"></select>
                <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
              </div>
            </div>
            <br/>
            {{-- <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
              {!! Form::label('tarif_id', 'Tindakan Lain', ['class' => 'col-sm-2 control-label']) !!}
              
              <div class="col-sm-10">
                <select name="tarif_id[]" id="select2Multiple2" class="form-control" required
                  multiple="multiple"></select>
               <small><i><b><span class="text-red">*</span>Cari disini jika data tindakan operasi tidak lengkap</b></i></small>
              </div>
            </div> --}}
            <div class="form-group">
              {!! Form::label('&nbsp;', '', ['class' => 'col-sm-8 control-label']) !!}
              <div class="col-sm-4">
                {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return
                confirm("Yakin Data Ini Sudah Benar")']) !!}
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
    {{--
    =======================================================================================================================
    --}}
    <div class='table-responsive'>
      @php
          $url = '"'.url('/operasi/cetak-tindakan-oka/'.$reg->id).'"';
      @endphp
      <table class='table table-striped table-bordered table-hover table-condensed' id="rincian"
        style="font-size:12px;">
        <thead class="bg-primary">
          <tr style="background: rgb(25, 90, 14)">
            <th colspan="4" class="text-right">Total</th>
            <th colspan="12">{{number_format($total)}}</th>
            <th class="text-right">
              <a target="popup" class="btn btn-sm btn-default" onClick='window.open({{$url}},"Cetak Tindakan Operasi" ,"width=700","height=400")'><i class="fa fa-print"></i> Cetak</a>
            </th>
          </tr>
          <tr>
            <th class="text-center" style="vertical-align: middle;">No</th>
            <th class="text-center" style="vertical-align: middle;">Tindakan</th>
            {{-- <th class="text-center" style="vertical-align: middle;">Jenis Pelayanan</th> --}}
            <th class="text-center" style="vertical-align: middle;">Biaya</th>
            <th class="text-center" style="vertical-align: middle;">Jml</th>
            {{-- <th class="text-center" style="vertical-align: middle;">Total + Cito</th> --}}
            <th class="text-center" style="vertical-align: middle;">Total</th>
            <th class="text-center" style="vertical-align: middle;">Cito</th>
            <th class="text-center" style="vertical-align: middle;">Kamar</th>
            <th class="text-center" style="vertical-align: middle;">Kelas</th>
            <th class="text-center" style="vertical-align: middle;">Dokter Bedah</th>
            <th class="text-center" style="vertical-align: middle;">Dokter Anestesi</th>
            <th class="text-center" style="vertical-align: middle;">Dokter Anak</th>
            <th class="text-center" style="vertical-align: middle;">Perawat</th>
            {{-- <th class="text-center" style="vertical-align: middle;">Pelaksana</th> --}}
            <th class="text-center" style="vertical-align: middle;">Petugas Entry</th>
            <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
            <th class="text-center" style="vertical-align: middle;">Waktu</th>
            <th class="text-center" style="vertical-align: middle;">Bayar</th>
            <th class="text-center" style="vertical-align: middle;">Hapus</th>
            
            {{-- @role(['supervisor', 'administrator'])
            <th>Hapus</th>
            @endrole --}}
          </tr>
        </thead>
        <tbody>
        </tbody>
        {{-- <tfoot> --}}
          <tr style="background: rgb(25, 90, 14);color:white">
            <th colspan="4" class="text-right">Total</th>
            <th colspan="12">{{number_format($total)}}</th>
            <th class="text-right"><a target="popup" class="btn btn-sm btn-default" onClick='window.open({{$url}},"Cetak Tindakan Operasi" ,"width=700","height=400")'><i class="fa fa-print"></i> Cetak</a></th>
          </tr>
        {{-- </tfoot> --}}
      </table>
    </div>
    <div class="pull-right">
      <a href="{{ url('operasi/'.$unit) }}" class="btn btn-primary btn-sm btn-flat">SELESAI</a>
    </div>
  </div>
</div>
@stop

@section('script')
<script type="text/javascript">
  $(".skin-blue").addClass( "sidebar-collapse" );
    $('.select2').select2();
    status_reg = "<?= substr($reg->status_reg,0,1) ?>"
    // kelas_id = "<?= @$irna->kelas_id ? $irna->kelas_id : 8 ?>"
    kelas_id = $('#kelas_id').val();
    // $('.select2').select2();
    $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama tindakan operasi",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan-operasi/'+kelas_id,
          dataType: 'json',
          data: function (params) {
            console.log(params)
              return {
                  j: 1,
                  q: $.trim(params.term)
              };
          },
          escapeMarkup: function(markup) {
              return markup;
            }, 
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })
    $('#select2Multiple2').select2({
      placeholder: "Klik untuk isi nama tindakan lain",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan/'+status_reg,
          dataType: 'json',
          data: function (params) {
            console.log(params)
              return {
                  j: 1,
                  q: $.trim(params.term)
              };
          },
          escapeMarkup: function(markup) {
              return markup;
            }, 
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })
  //SHOW DATA
  $('#rincian').DataTable({
    "language": {
        "url": "/json/pasien.datatable-language.json",
      },
    autoWidth: false,
    destroy: true,
    processing: true,
    serverSide: true,
    ordering: false,
    pageLength: 100,
    searching: true,
    info: false,
    ajax: "{{ url('operasi/get-data-folio/'.$reg->id) }}",
    columns: [
      {data: 'DT_RowIndex', sClass: 'text-center'},
      {data: 'namatarif'},
      // {data: 'jenisPelayanan'},
      {data: 'biaya'},
      {data: 'jumlah'},
      // {data: 'jmlTotalcito'},
      {data: 'jmlTotal'},
      {data: 'cyto'},
      {data: 'kamar_id'},
      {data: 'kelas_id'},
      {data: 'dpjp'},
      {data: 'dokter_anestesi'},
      {data: 'dokter_anak'},
      {data: 'perawat'},
      {data: 'user'},
      {data: 'carabayar'},
      {data: 'create'},
      {data: 'lunas', sClass: 'text-center'},
      {data: 'hapus'}
    ]
  });


  $('.dokter').select2({
    ajax: {
      url: '/operasi/get-dokter',
      dataType: 'json',
      data: function (params) {
        return {
          q: $.trim(params.term)
        };
      },
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  })

  // $('.tarif').select2({
  //   ajax: {
  //     url: '/operasi/get-tarif-tindakan',
  //     dataType: 'json',
  //     data: function (params) {
  //       return {
  //         q: $.trim(params.term)
  //       };
  //     },
  //     processResults: function (data) {
  //       return {
  //         results: data
  //       };
  //     },
  //     cache: true
  //   }
  // })
  $('select[name="bayar"]').on('change', function(){
    $.get('/tindakan/updateCaraBayar/'+$(this).attr('id')+'/'+$(this).val(), function(){
      location.reload();
    });
  })

  // $(document).on('click','.btn-history-resep',function(){
  //       let id = $(this).attr('data-id');
  //       $.ajax({
  //           url: '/tindakan/e-resep/history/'+id,
  //           type: 'GET',
  //           dataType: 'json',
  //           beforeSend: function () {
  //           $('#listHistoryResep').html('');
  //           },
  //           success: function (res){
  //           $('#listHistoryResep').html(res.html);
  //           $('#myModalHistoryResep').modal('show');
  //           }
  //       });
  //       })
 

</script>
@stop