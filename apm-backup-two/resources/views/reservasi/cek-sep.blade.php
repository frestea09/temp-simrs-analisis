@extends('layouts.landingpage')
@section('style')
<style>
  .select2-results__option,
  .select2-search__field,
  .select2-selection__rendered,
  .form-control,
  .col-form-label {
    font-size: 12px;
  }

  .table-pasien tr td {
    padding: 5px !important;
    font-size: 12px;
  }

  #dataPasien td,
  #dataPasien th {
    padding: 0.25rem !important;
  }

  select[readonly] {
    background: #eee;
    /*Simular campo inativo - Sugestão @GabrielRodrigues*/
    pointer-events: none;
    touch-action: none;
  }
</style>
@endsection
@section('content')
<div class="container">
  <h4 class="text-dark text-center">Cek SEP Pasien</h4>
  {{-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Library</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data</li>
    </ol>
  </nav> --}}
  <hr />
  <div class="row">
    <div class="col-lg-12">

    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card border-info">
        <div class="card-header bg-info">
          <span style="color:white">Form Cek SEP - <b><a style="color:white;" target="__blank" href="{{url('reservasi/response-kunjungan/'.$data->id.'/'.$data->no_rm)}}">{{$data->no_rm}}</a></b></span>
        </div>
        <div class="card-body">
          <form class="form-horizontal" id="form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  {!! Form::label('nama', 'Nama', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    <input type="text" name="nama" value="{{$data->nama}}"
                      readonly="true" class="form-control">
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('no_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('no_bpjs', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('no_bpjs', $data->nomorkartu, ['class' => 'form-control','readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('no_bpjs') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
                  {!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('no_tlp', $pasien->nohp, ['class' =>
                    'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('no_tlp') }}</small>
                  </div>
                </div>
                <input type="hidden" name="nik" value="{{ !empty($reg->pasien->nik) ? $reg->pasien->nik : NULL }}">
                <div class="form-group row{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('tgl_rujukan', @$rujukan['rujukan']['tglKunjungan'], ['class' => 'form-control tanggalSEP','readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('no_rujukan', @$rujukan['rujukan']['noKunjungan'], ['class' => 'form-control','readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('catatan_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('catatan_bpjs', 'Catatan BPJS', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('catatan_bpjs', $rujukan['rujukan']['keluhan'], ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('catatan_bpjs') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
                  {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('diagnosa_awal', $rujukan['rujukan']['diagnosa']['kode'], ['class' => 'form-control', 'id'=>'diagnosa_awal','readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
                  {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::select('jenis_layanan', ['2'=>'Rawat Jalan','1'=>'Rawat Inap'], $rujukan['rujukan']['pelayanan']['kode'], ['class' =>
                    'form-control select2', 'style'=>'width:100%','readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('jenis_layanan') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
                  {!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::select('asalRujukan', ['1'=>'PPK 1'], null, ['class' => 'form-control select2',
                    'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
                  </div>
                </div>

                <div class="form-group row{{ $errors->has('hak_kelas_inap') ? ' has-error' : '' }}">
                  {!! Form::label('hak_kelas_inap', 'Hak Kelas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('hak_kelas_inap', !empty($hak_kelas) ? $hak_kelas :  $rujukan['rujukan']['peserta']['hakKelas']['kode'], ['class' =>
                    'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('hak_kelas_inap') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('hak_kelas_inap_naik') ? ' has-error' : '' }}">
                  {!! Form::label('hak_kelas_inap_naik', 'Hak Kelas Naik', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::text('hak_kelas_inap_naik', !empty($hak_kelas_inap_naik) ? $hak_kelas_inap_naik : '',
                    ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('hak_kelas_inap_naik') }}</small>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="poliTujuan" class="col-sm-4 control-label">Tgl SEP</label>
                  <div class="col-sm-8">
                    <input type="text" name="tglSep" class="form-control tanggalSEP" value="{{ date('Y-m-d') }}">
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group row{{ $errors->has('pembiayaan') ? ' has-error' : '' }}">
                  {!! Form::label('pembiayaan', 'Pembiayaan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::select('pembiayaan', [''=>'','1'=>'Pribadi', '2'=>'Pemberi Kerja','3'=>'Asuransi Kesehatan
                    Tambahan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('pembiayaan') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('cob') ? ' has-error' : '' }}">
                  {!! Form::label('cob', 'COB', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2',
                    'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('cob') }}</small>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('katarak') ? ' has-error' : '' }}">
                  {!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    {!! Form::select('katarak', ['1'=>'Tidak', '0'=>'Ya'], null, ['class' => 'form-control select2',
                    'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('katarak') }}</small>
                  </div>
                </div>
              {{-- <div class="form-group row">
                <label for="tipejkn" class="col-sm-4 control-label">Tipe JKN</label>
                <div class="col-sm-8">
                  <input type="text" name="tipe_jkn" value="{{ !empty($reg->tipe_jkn) ? $reg->tipe_jkn : NULL }}" readonly="true" class="form-control">
                </div>
              </div> --}}
              <div class="form-group row{{ $errors->has('tujuanKunj') ? ' has-error' : '' }}">
                {!! Form::label('tujuanKunj', 'Tujuan Kunjungan', ['class' => 'col-sm-4 control-label']) !!}
                {{-- <label class="col-sm-4 control-label">Tujuan Kunjungan</label> --}}
                <div class="col-sm-8">
                    {!! Form::select('tujuanKunj', ['0'=>'Normal','1'=>'Prosedur', '2'=>'Konsul Dokter'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
                </div>
              </div>
              <div class="form-group row{{ $errors->has('flagProcedure') ? ' has-error' : '' }}">
                {!! Form::label('flagProcedure', 'Flag Procedure', ['class' => 'col-sm-4 control-label']) !!}
                {{-- <label class="col-sm-4 control-label"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Diisi jika tujuan Kunjungan = Normal"></i>  Flag Procedure</label> --}}
                
                <div class="col-sm-8">
                    {!! Form::select('flagProcedure', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','0'=>'Prosedur Tidak Berkelanjutan','1'=>'Prosedur dan Terapi Berkelanjutan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('flagProcedure') }}</small>
                </div>
              </div>
              <div class="form-group row{{ $errors->has('kdPenunjang') ? ' has-error' : '' }}">
                {!! Form::label('kdPenunjang', 'Penunjang', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('kdPenunjang', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','1'=>'Radioterapi','2'=>'Kemoterapi','3'=>'Rehabilitasi Medik','4'=>'Rehabilitasi Psikososial','5'=>'Transfusi Darah','6'=>'Pelayanan Gigi'
                    ,'7'=>'Laboratorium','8'=>'USG','9'=>'Farmasi','10'=>'Lain-Lain','11'=>'MRI','12'=>'Hemodialisa' ], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('kdPenunjang') }}</small>
                </div>
              </div>
              <div class="form-group row{{ $errors->has('assesmentPel') ? ' has-error' : '' }}">
                {!! Form::label('assesmentPel', 'Assesment Pel.', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('assesmentPel', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"-- ','1'=>'Poli spesialis tidak tersedia pada hari sebelumnya','2'=>'Jam Poli telah berakhir pada hari sebelumnya', '3'=>'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya','4'=>'Atas Instruksi RS','5'=>'Tujuan Kontrol'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="poliTujuan" class="col-sm-4 control-label">Klinik Tujuan </label>
                <div class="col-sm-8">
                  {!! Form::text('poli_bpjs', $rujukan['rujukan']['poliRujukan']['nama'],
                    ['class' => 'form-control','readonly'=>true]) !!}
                  {{-- <select name="poli_bpjs" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $d)
                       
                    @endforeach
                  </select> --}}
                </div>
              </div>
              <div class="form-group row">
                <label for="poliTujuan" class="col-sm-4 control-label">No. SKDP</label>
                <div class="col-sm-8">
                  <input type="text" name="noSurat" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <label for="dpjpLayanan" class="col-sm-4 control-label">Dokter Konsul</label>
                <div class="col-sm-8">
                  <select name="dpjpLayan" class="form-control" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="poliTujuan" class="col-sm-4 control-label">Kode DPJP </label>
                <div class="col-sm-8">
                  <select name="kodeDPJP" class="form-control" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                @php
                    $url = '"'.url('/bridgingsep/jadwal-dokter-hfis').'"';
                @endphp
                {{-- <label for="poliTujuan" class="col-sm-4 control-label">Jam Praktek<br><a style="cursor: pointer" onclick='javascript:wincal=window.open({{$url}}, width=790,height=400,scrollbars=2)'><i>Lihat jam praktek</i></a></label>
                <div class="col-sm-3">
                  {!! Form::text('jam_start', null, ['class' => 'form-control timepicker']) !!}
                </div>
                <label for="jam" class="col-sm-1 control-label">S/D</label>
                <div class="col-sm-3">
                  {!! Form::text('jam_end', null, ['class' => 'form-control timepicker']) !!}
                </div> --}}
              </div>

              <div class="form-group row{{ $errors->has('no_sep') ? ' has-error' : '' }}">
                  <div class="col-sm-4 control-label">
                    <button type="button" id="createSEP" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SEP</button>
                  </div>
                  <div class="col-sm-8" id="fieldSEP">
                      {!! Form::text('no_sep', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                      <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                  </div>
              </div>
              {{-- <div class="form-group row{{ $errors->has('nomorantrian') ? ' has-error' : '' }}">
                <div class="col-sm-4 control-label">
                    <button type="button" id="createAntrian" class="btn btn-info btn-flat"><i class="fa fa-recycle"></i> ANTRIAN BPJS</button>
                
                </div>
                <div class="col-sm-8" id="fieldAntrian">
                    {!! Form::text('nomorantrian',  !empty($reg->nomorantrian) ? $reg->nomorantrian : '', ['class' => 'form-control readonly','required'=>true,'id'=>'noAntrian','placeholder'=>'Wajib diisi, dengan klik tombol antrian']) !!}
                    <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                </div>
            </div> --}}
              <div class="btn-group pull-right">
                  {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
              </div>

            </div>
            </div>
          </form>

        </div>
      </div>
      <br />
      <a href="{{url('/')}}" class="btn btn-danger btn-sm col-md-2 col-lg-2 float-right"><i
          class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
    </div>
  </div>

</div>
@endsection

@section('script')
<script type="text/javascript">
  // jQuery(document).ready(function($){
  function cekin(id,rm){
    $.ajax({
    url: '/reservasi/cekin-ajax/'+id+'/'+rm,
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {
      $('tbody').find('.btnCek').addClass('disabled')
      $('tbody').find('.spinner-cek').removeClass('d-none')
    },
    complete: function () {
      $('tbody').find('.btnCek').removeClass('disabled')
      $('tbody').find('.spinner-cek').addClass('d-none')
    }
  })
  .done(function(data) {
    if (data.status == 200) {
      // Swal.fire({
      //   icon: 'error',
      //   title: 'Maaf...',
      //   text: data.result
      // })
      // return
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Maaf...',
        text: data.result
      })
    }
  });
  }


  function tampil() {
  $('.dataKunjungan').addClass('d-none')
  $('.respon').html('');
  $.ajax({
    url: '/reservasi/cek',
    type: 'POST',
    dataType: 'json',
    data: $('#form').serialize(), 
    beforeSend: function () {
      $('.btnCari').addClass('disabled')
      $('.spinner-border').removeClass('d-none')
    },
    complete: function () {
       $('.btnCari').removeClass('disabled')
       $('.spinner-border').addClass('d-none')
    }
  })
  .done(function(data) {
    // console.log(data)
    // var decompressData = LZString.decompressFromBase64(res);  
    // data = JSON.parse(res) 
    if (data.status == 200) {
      $('.dataKunjungan').removeClass('d-none')
      $('tbody').empty() 
      $('.poli').removeClass('d-none')
      $('.kelasRawat').addClass('d-none')

      if(data.result.status == 'pending' && data.result.fingerprint.kode == '1'){
        cetak = '<a style="background-color:green;border:1px solid green;" class="btn btn-success btn-sm" href="/reservasi/cek-sep/'+data.result.id+'/'+data.result.no_rm+'">LANJUTKAN <span class="fa fa-arrow-right"></span></a>';
        // cetak = '<button type="button" onclick="cekin('+data.result.id+','+data.result.no_rm+')" class="btn btn-info btn-sm btnCek" ><span class="fa fa-print"></span>&nbsp;CHECK IN<span class="spinner-border spinner-border-sm d-none spinner-cek" style="margin-left:5px;" role="status" aria-hidden="true"></span>&nbsp;</button>';
        
      }else if(data.result.status == 'checkin'){
        cetak = '<a class="btn btn-primary btn-sm" href="/reservasi/cetak/'+data.result.id+'"><span class="fa fa-print"></span>&nbsp;CETAK TIKET</a>';
      }else{
        cetak = '<a style="background-color:green;border:1px solid green;" class="btn btn-success btn-sm disabled" href=""><span class="fa fa-print"></span>&nbsp;Lanjutkan</a>';
      }
      // $.each(data.result, function(index, val) {
        
        $('tbody').append('<tr><td class="text-center">'+data.result.nomorantrian+'</td><td class="text-center">'+data.result.poli+'</td><td class="text-left">'+data.result.nama+'</td> <td>'+data.result.no_rujukan+
          '</td><td class="text-center">'+data.result.tglperiksa+'</td><td class="text-center" style="max-width:600px !important;">'+cetak+'</td></tr>')
      // }); 
      if(data.result.fingerprint.kode == '1'){
        $('.status_finger').html('<b style="color:green;font-weight:700;font-size:14px;">'+data.result.fingerprint.status+'</b>');
      }else{
        $('.status_finger').html('<b style="color:red;font-weight:700;font-size:14px;">'+data.result.fingerprint.status+'</b><br><span style="color:blue;font-weight:700;font-size:14px;">Silahkan melakukan fingerprint terlebih dahulu, Jika sudah melakukan fingerprint,Silahkan "Cek Reservasi" ulang untuk kemudian Checkin</span>');
      }
      // return
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Maaf...',
        text: data.result
      })
    }
  });
}
// })



</script>
@endsection