@extends('master')

@section('header')
  <h1>
    Verifikasi Rawat Inap | Total Tagihan: Rp. {{ number_format($tagihan) }}
    </h1>
@endsection

@section('content')
    <div class="box box-primary">

      <div class="box-body">
        <div class="box">

          @php
            $ri = App\Rawatinap::where('registrasi_id', $reg->id)->first();
            $inacbg = \App\Inacbg::where('registrasi_id', $reg->id)->first();
            $hi = App\HistoriRawatInap::where('registrasi_id', $reg->id)->get();
            $no_kamar = 1;
          @endphp

          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <tbody>

                <tr>
                  <th>Nama Pasien</th> <td>{{ strtoupper($reg->pasien->nama) }}</td>
                  @if ($hi->count() == 1)
                    @foreach ($hi as $r)
                      <th>Kelas / Kamar</th> <td>{{ baca_kelompok($r->kelompokkelas_id) }} / {{ baca_kamar($r->kamar_id) }}</td>
                    @endforeach
                  @else
                    <th></th><td></td>
                  @endif
                </tr>
                <tr>
                  <th>No. RM</th> <td>{{ strtoupper($reg->pasien->no_rm) }}</td>
                  <th>Kelas Perawatan </th> <td>{{ !empty($reg->kelas_id) ? baca_kelas($reg->kelas_id) : '' }}</td>
                </tr>
                <tr>
                  <th>Alamat</th> <td>{{ strtoupper($reg->pasien->alamat) }}</td>
                  <th>No. SEP</th> <td>{{ $reg->no_sep }}</td>
                </tr>
                <tr>
                    <th>DPJP </th> <td>{{ baca_dokter($ri->dokter_id) }}</td>
                    <th>Hak Kelas JKN </th> <td>{{ $reg->hak_kelas_inap }}</td>
                </tr>
                <tr>
                  <th>Cara Bayar</th> <td>{{ baca_carabayar($reg->bayar) }}
                    @if (!empty($reg->tipe_jkn))
                      - {{ $reg->tipe_jkn }}
                    @endif
                    @if (!empty($reg->perusahaan_id))
                      - {{ $reg->perusahaan->nama }}
                    @endif
                  </td>
                  <th>Kode Grouper </th> <td>{{ !empty($inacbg) ? $inacbg->kode : '' }}</td>
                </tr>
                  
                  @php
                    session( ['kelas_id'=>$reg->kelas_id]);
                  @endphp

                @if ($reg->bayar == '1')
                  <tr>
                    <th>Ubah Tipe JKN</th> 
                    <td>
                      <form action="{{ url('kasir/ubah-tipe-jkn') }}" method="post">
                        {{ csrf_field() }}
                          {!! Form::hidden('registrasi_id', $reg->id) !!}
                          {!! Form::hidden('tipe', 'irna') !!}
                          {!! Form::select('tipe_jkn', ['PBI'=>'PBI', 'NON PBI'=>'NON PBI'], $reg->tipe_jkn, ['class' => 'form-control', 'style'=>'width: 50%', 'onchange'=>'this.form.submit()']) !!}
                      </form>
                    </td>
                    <th>Dijamin INACBG</th> <td>{{ !empty($inacbg) ? number_format($inacbg->dijamin) : '' }}</td>
                  </tr>
                @endif
                <tr>
                  <th>Tanggal Masuk</th><td>{{ tanggal($ri->tgl_masuk) }}</td>
                  <th>Tanggal Keluar</th><td>{{ tanggal($ri->tgl_keluar) }}</td> 
                </tr>
                
              </tbody>
            </table>
          </div>

          @if ($hi->count() > 1)
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Kelas</th>
                    <th>Kamar</th>
                    <th>Bed</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($hi as $d)
                  <tr>
                    <td>{{ $no_kamar++ }}</td>
                    <td>{{ baca_kelompok($d->kelompokkelas_id) }}</td>
                    <td>{{ baca_kamar($d->kamar_id) }} </td>
                    <td>{{ baca_bed($d->bed_id) }}</td>
                    <td>{{ $d->created_at->format('d-m-Y') }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          @endif

        </div>
        {{-- ======================================================================================================================= --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' >
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th colspan="2">Tindakan</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total</th>
                <th class="text-center">Verifikasi</th>
                {{-- <th>Hapus</th> --}}
              </tr>
            </thead>
            <tbody>
              {!! Form::open(['method' => 'POST', 'url' => '/kasir/verifikasi-kasir-irna/', 'class' => 'form-horizontal']) !!}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              @foreach ($folio as $key => $d)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td onclick="detailVerif({{ $reg->id }}, '{{ $d->poli_tipe }}')" colspan="2">{{ ($d->poli_tipe == '') ? 'Rawat Inap' : baca_politipe($d->poli_tipe) }}</td>
                  <td onclick="detailVerif({{ $reg->id }}, '{{ $d->poli_tipe }}')" class="text-center">{{ $d->qty }}</td>
                  <td class="text-right">{{ number_format($d->total) }}</td>
                  <td class="text-center">
                    @if ($d->qty == cekVerifJalan($reg->id, $d->poli_tipe))
                      <i class="fa fa-check"></i>
                    @else
                      <input type="checkbox" name="verif_kasa{{ $i_verif++ }}" value="{{ $d->poli_tipe }}">
                    @endif
                  </td>
                  
                </tr>
              @endforeach
              <tr>
                <th colspan="5" class="text-right">Pilih Semua</th>
                <th class="text-center"><input type="checkbox" id="selectAll"/></th>
              </tr>
              <tr>
                <td colspan="9">
                  <input type="hidden" name="jmlbaris" value="{{ $i_verif }}">
                  <div class="btn-group pull-right">
                    <a href="#" id="tambahTindakan" class="btn btn-primary btn-flat"> <i class="fa fa-plus"> </i> TAMBAH TINDAKAN</a>
                    <button type="submit" name="submit" onclick="return confirm('Yakin data yang di Verifikasi sudah benar?')" class="btn btn-success btn-flat pull-right"><i class="fa fa-save"> </i> SIMPAN</button>
                  </div>
                </td>
              </tr>

              {!! Form::close() !!}
            </tbody>
          </table>
        </div>

        {{-- CETAK RINCIAN --}}
        @if ( Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg->id)->where('verif_kasa', 'Y')->sum('total') > 0)
          <a href="{{ url('kasir/cetak-verifikasi/'.$reg->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat pull-right"><i class="fa fa-print"></i> CETAK</a>
        @endif
        <br>
        <hr>
        

        <div class="box-body hidden" id="formTambahan" >
          {!! Form::open(['method' => 'POST', 'url' => 'kasir/save-tindakan', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('jenis', $reg->bayar) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                  {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('dokter_id', $dokter, null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                  {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('pelaksana', $dokter, null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                  {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('perawat', $perawat, null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('perawat') }}</small>
                  </div>
              </div>

            </div>

            <div class="col-md-6">
              <div class="form-group{{ $errors->has('kategoritarif_id') ? ' has-error' : '' }}">
                  {!! Form::label('kategoritarif_id', 'Kategori', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('kategoritarif_id', $kat_tarif, null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                  {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('tarif_id', $tarif, null, ['class' => 'form-control']) !!}
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
              <div class="btn-group pull-right">
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
              </div>

              {!! Form::close() !!}
            </div>
          </div>


        </div>


        <div class="pull-right">
          {{-- <a href="{{ url('kasir/rawatinap/bayar/'.$reg->id.'/'.$reg->pasien_id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-step-backward"></i> TUTUP TRANSAKSI </a> --}}
          <a href="{{ url('kasir/verifikasi') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-step-backward"></i> SELESAI </a>
        </div>

      </div>
    </div>


    <div class="modal fade" id="FormTindakan" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content ">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Tambah Tindakan</h4>
          </div>
          <div class="modal-body">
            {!! Form::open(['method' => 'POST', 'url' => 'kasir/save-tindakan', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('jenis', $reg->bayar) !!}
            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
            <div class="row">
              <div class="col-md-7">
                <div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
                    {!! Form::label('dpjp', 'DPJP IRNA', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('dpjp', $dokter, null, ['class' => 'form-control select2', 'style' => 'width: 100%']) !!}
                        <small class="text-danger">{{ $errors->first('dpjp') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('pelaksana', $perawat, null, ['class' => 'form-control select2', 'style' => 'width: 100%']) !!}
                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control select2" name="tarif_id" style="width:100%">
                          {{-- @foreach(Modules\Tarif\Entities\Tarif::where('jenis', 'TA')->get() as $d) --}}
                          <option value=""></option>
                          @foreach(Modules\Tarif\Entities\Tarif::all() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }} | {{ number_format($d->total) }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    </div>
                </div>

              </div>

              <div class="col-md-5">

                <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                    {!! Form::label('perawat', 'Kepala Unit', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('perawat', $perawat, null, ['class' => 'form-control select2', 'style' => 'width: 100%']) !!}
                        <small class="text-danger">{{ $errors->first('perawat') }}</small>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('tanggal', null, ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                    </div>
                </div>

                <script type="text/javascript">
                  $('.select2').select2();
                </script>

          </div>
          <div class="modal-footer">
            {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
            <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Close</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>

@endsection


@section('script')
{{-- MODAL DETAIL TARIF VERIFIKASI --}}
  <div class="modal fade" id="detailVerifikasiModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          {!! Form::open(['method' => 'POST', 'url' => '/kasir/verifikasi-detail-kasir-irna/', 'class' => 'form-horizontal', 'id'=>'formDetailTindakan']) !!}
            <div id="dataTindakanDetail"></div>
          {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat pull-right', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
          <br>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
{{-- END MODAL DETAIL TARIF VERIFIKASI --}}

  <script type="text/javascript">
      $('#selectAll').change(function(){
        if(this.checked){
          console.log('checked');
          for(var i = 0; i <= {{ $i_verif }}; i++) {
            var ksa = 'verif_kasa'+i;
            $('input[name="'+ksa+'"').prop('checked', true);
          }
        }else{
          console.log('unchecked');
          for(var i = 0; i <= {{ $i_verif }}; i++) {
            var ksa = 'verif_kasa'+i;
            $('input[name="'+ksa+'"').prop('checked', false);
          }
        }
      })
    $(document).ready(function() {
      $('#tambahTindakan').on('click', function () {
        $('#FormTindakan').modal('show');
        $('.select2').select2();
      });

      $('select[id="kategoritarif_id"]').on('change', function () {
        var kat_id = $(this).val();
        if(kat_id) {
            $.ajax({
                url: '/kasir/gettarif/'+kat_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[id="tarif_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[id="tarif_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[id="tarif_id"]').hide();
        }
      });

      $('select[id="KategoriTarif"]').on('change', function () {
        var kat_id = $(this).val();
        if(kat_id) {
            $.ajax({
                url: '/operasi/get-tarif/'+kat_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[id="tarif_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[id="tarif_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[id="tarif_id"]').hide();
        }
      });
    });

    function detailVerif(registrasi_id, tarif_id){
      $('#detailVerifikasiModal').modal('show');
      $('.modal-title').text('Detail Tindakan');
      $('#dataTindakanDetail').load('/kasir/detail-tindakan-verifikasi/'+registrasi_id+'/'+tarif_id)
    }


  </script>
@endsection
