@extends('master')
@section('header')
  <h1>Form Update SEP<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- CEK SEP --}}
      <div class="row">
        <div class="col-md-12">
          <form action="{{ url('updatesep') }}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
            <label for="nosep" class="col-md-2 control-label">No. SEP</label>
            <div class="col-sm-4">
              <input type="text" name="nosep" value="" class="form-control">
            </div>
            <div class="col-sm-4">
              {!! Form::submit("Lanjut", ['class' => 'btn btn-success btn-flat']) !!}
            </div>
          </form>
        </div>
      </div>
      <hr>
  @isset ($reg)
      {!! Form::open(['method' => 'POST', 'class' => 'form-horizontal', 'id'=>'formSEP']) !!}
          {{-- <input type="hidden" name="no_rm" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->no_rm }}"> --}}
          <input type="hidden" name="nama_ppk_perujuk" value="">
          <input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="no_rm" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->no_rm }}" readonly="true" class="form-control">
                      <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('nama', 'Nama', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="nama" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->nama }}" readonly="true" class="form-control">
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('no_bpjs', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_bpjs', $reg->no_jkn, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
                  {!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_tlp', !empty($reg->pasien->nohp) ? $reg->pasien->nohp : '', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_tlp') }}</small>
                  </div>
              </div>
              <input type="hidden" name="nik" value="{{ !empty($reg->pasien->nik) ? $reg->pasien->nik : NULL }}">
              <div class="form-group{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_rujukan', $reg->tgl_rujukan, ['class' => 'form-control tanggalSEP']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_rujukan', $reg->no_rujukan, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
                  </div>
              </div>
              @php
                $ppk = explode('|', $reg->ppk_rujukan);
              @endphp
              <div class="form-group{{ $errors->has('ppk_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-3">
                      {!! Form::text('ppk_rujukan', $ppk[0], ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('ppk_rujukan') }}</small>
                  </div>
                  {{-- <div class="col-sm-5">
                    <input type="text" name="nama_perujuk" value="{{ $ppk[1] }}" class="form-control">
                  </div> --}}
              </div>
              <div class="form-group{{ $errors->has('catatan_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('catatan_bpjs', 'Catatan BPJS', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('catatan_bpjs', $reg->catatan, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('catatan_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
                  {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('diagnosa_awal', $reg->diagnosa_awal, ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
                      <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
                  {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('jenis_layanan', ['2'=>'Rawat Jalan', '1'=>'Rawat Inap'], NULL, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('jenis_layanan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
                  {!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('asalRujukan', ['1'=>'PPK 1', '2'=>'RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('hak_kelas_inap') ? ' has-error' : '' }}">
                  {!! Form::label('hak_kelas_inap', 'Hak Kelas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('hak_kelas_inap', $reg->hakkelas, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('hak_kelas_inap') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('cob') ? ' has-error' : '' }}">
                  {!! Form::label('cob', 'COB', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('cob') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('katarak') ? ' has-error' : '' }}">
                  {!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('katarak', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('katarak') }}</small>
                  </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Tgl SEP</label>
                <div class="col-sm-8">
                  <input type="text" name="tglSep" class="form-control tanggalSEP" value="{{ date('Y-m-d') }}">
                </div>
              </div>

            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipejkn" class="col-sm-4 control-label">Tipe JKN</label>
                <div class="col-sm-8">
                  <input type="text" name="tipe_jkn" value="{{ $reg->tipe_jkn }}" readonly="true" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Klinik Tujuan </label>
                <div class="col-sm-8">
                  <select name="poli_bpjs" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $d)
                      @if ($d->bpjs == $poli_bpjs)
                         <option value="{{ $d->bpjs }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->bpjs }}">{{ $d->nama }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">No. SKDP</label>
                <div class="col-sm-8">
                  <input type="text" name="noSurat" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Kode DPJP </label>
                <div class="col-sm-8">
                  <select name="kodeDPJP" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                      @if ($d->kode_bpjs == $dokter_bpjs)
                        <option value="{{ $d->kode_bpjs }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                      @endif

                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group{{ $errors->has('laka_lantas') ? ' has-error' : '' }}">
                  {!! Form::label('laka_lantas', 'Laka Lantas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('laka_lantas', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('laka_lantas') }}</small>
                  </div>
              </div>
              <div class="laka hidden">
                  <div class="form-group{{ $errors->has('penjamin') ? ' has-error' : '' }}">
                      {!! Form::label('penjamin', 'Penjamin', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('penjamin', ['1'=>'Jasa Raharja', '2'=>'BPJS Ketenagakerjaan', '3'=>'TASPEN', '4'=>'ASABRI'], null, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ $errors->first('penjamin') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('no_lp') ? ' has-error' : '' }}">
                      {!! Form::label('no_lp', 'No. LP', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('no_lp', null, ['class' => 'form-control']) !!}
                          <small class="text-danger">{{ $errors->first('no_lp') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('tglKejadian') ? ' has-error' : '' }}">
                      {!! Form::label('tglKejadian', 'Tanggal Kejadian Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('tglKejadian', null, ['class' => 'form-control datepicker', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('tglKejadian') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kll') ? ' has-error' : '' }}">
                      {!! Form::label('kll', 'Ket Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('kll', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('kll') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('suplesi') ? ' has-error' : '' }}">
                      {!! Form::label('suplesi', 'Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('suplesi', ['0'=>'Tidak', '1'=>'Ya'], 0, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ $errors->first('suplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('noSepSuplesi') ? ' has-error' : '' }}">
                      {!! Form::label('noSepSuplesi', 'No. SEP Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('noSepSuplesi', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('noSepSuplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kdPropinsi') ? ' has-error' : '' }}">
                      {!! Form::label('kdPropinsi', 'Propinsi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdPropinsi" id="regency_id" style="width:100%">
                            <option value=""></option>
                            @foreach ($bpjsprov as $i)
                            <option value="{{ $i->kode }}"> {{ $i->propinsi }}</option>
                                
                            @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('kdPropinsi') }}</small>
                      </div>
                  </div>
                  
                  <div class="form-group{{ $errors->has('kdKabupaten') ? ' has-error' : '' }}">
                      {!! Form::label('kdKabupaten', 'Kabupaten', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKabupaten" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ $errors->first('kdKabupaten') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kdKecamatan') ? ' has-error' : '' }}">
                      {!! Form::label('kdKecamatan', 'Kecamatan', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKecamatan" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ $errors->first('kdKecamatan') }}</small>
                      </div>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('no_sep') ? ' has-error' : '' }}">
                  {!! Form::label('sep', 'No SEP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8" id="fieldSEP">
                      {!! Form::text('no_sep', $reg->no_sep, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                      <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                  </div>
              </div>
              <div class="btn-group pull-right">
                  <button type="button" class="btn btn-primary btn-flat" onclick="saveUpdate()">UPDATE SEP</button>
              </div>

            </div>
          </div>


      {!! Form::close() !!}
            {{-- State loading --}}
            <div class="overlay hidden">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="modal fade" id="ICD10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Add</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endisset
      

  
@endsection

@section('script')
  <script type="text/javascript">
    $('.datepicker').datepicker({ endDate: new Date(), autoclose: true, format: "yyyy-mm-dd" });

    $( function() {
      $( ".tanggalSEP" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });

    });

    function saveUpdate(){
      $('.overlay').removeClass('hidden')
      var data = $('#formSEP').serialize();
      $.post('/simpan-update-SEP', data, function(resp){
        $('.overlay').addClass('hidden')
        if (resp.sukses) {
          alert('Update SEP '+resp.sukses+' Sukses')
        } else{
          alert(resp.msg)
        }
      })
    }

// ======================================================================================================================

    //Laka lantas
    $('select[name="laka_lantas"]').change(function(e) {
      if($(this).val() == 1){
        $('.laka').removeClass('hidden')
      } else {
        $('.laka').addClass('hidden')
      }
    });

    $('.select2').select2()


    $(document).ready(function() {
      //SET LAKA LANTAS
      if ($('select[name="laka_lantas"]').val() == 1) {
        $('.laka').removeClass('hidden')
      } else {
        $('.laka').addClass('hidden')
      }

      //ICD 10
      $("input[name='diagnosa_awal']").on('focus', function () {
        $("#dataICD10").DataTable().destroy()
        $("#ICD10").modal('show');
        $('#dataICD10').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/geticd10',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
      });

      $(document).on('click', '.addICD', function (e) {
        document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
        $('#ICD10').modal('hide');
      });

    });


  </script>
@endsection
