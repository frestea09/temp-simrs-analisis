@extends('master')

@section('header')
  <h1>
    @if (substr($jenis->status_reg,0,1) == 'G')
      Entry Tindakan Radiologi - Rawat Darurat
    @else
      Entry Tindakan Radiologi - Rawat Jalan
    @endif
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
          Data Rekam Medis &nbsp;
        </h3> --}}
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active" style="height: 180px;">
              <div class="row">
                <div class="col-md-2">
                  <h4 class="widget-user-username">Nama</h4>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                  <h5 class="widget-user-desc">DPJP</h5>
                  <h5 class="widget-user-desc">Klinik</h5>
                </div>
                <div class="col-md-7">
                  <h4 class="widget-user-username">:{{ @$pasien->nama}}</h4>
                  <h5 class="widget-user-desc">: {{ @$pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ @$pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar($jenis->bayar) }} </h5>
                  <h5 class="widget-user-desc">: {{ baca_dokter($jenis->dokter_id) }}</h5>
                  <h5 class="widget-user-desc">: {{ !empty($jenis->poli_id) ? baca_poli($jenis->poli_id) : NULL }}</h5>
                </div>
                <div class="col-md-3 text-center">
                  <h3>Total Tagihan</h3>
                  <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
                </div>
              </div>


            </div>
            <div class="widget-user-image">

            </div>

          </div>
          <!-- /.widget-user -->
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'radiologi/save-tindakan', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', @$pasien->id) !!}
            {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
            {!! Form::hidden('cara_bayar_id', $jenis->bayar) !!}
            {{-- {!! Form::hidden('poli_id', poliRadiologi()) !!} --}}
            <div class="row">
              <div class="col-md-7">

                @if (substr($jenis->status_reg,0,1) == 'G')
                  <a href="{{ url('emr/ris/igd/' . $reg_id) }}" target="_blank" class="btn btn-flat btn-danger btn-xs">ORDER RIS</a>
                @else
                  <a href="{{ url('emr/ris/jalan/' . $reg_id) }}" target="_blank" class="btn btn-flat btn-danger btn-xs">ORDER RIS</a>
                @endif

               @php
  
                $data['dokters_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck('dokter_id');
                $data['perawats_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck('perawat_id');
                // $dokter_pengirim =   Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get();
                $dokter =  (explode(",", $data['dokters_poli'][0]));
     
               @endphp

                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('dokter_id', 'Dokter Radiologi', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select name="dokter_radiologi" id="" class="form-control select2">
                        @foreach ($dokter as $d)
                        <option value="{{ $d }}">{{ baca_dokter($d) }}</option>
                        @endforeach
                      </select>
                        {{-- {!! Form::select('dokter_radiologi', $radiografer, '', ['class' => 'form-control select2', 'style'=>'width: 100%', 'placeholder'=>'']) !!} --}}
                        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control select2" style="width: 100%" name="tarif_id">
                          @foreach($tindakan as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }} | {{ @$d->kode }} | {{ number_format($d->total) }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('radiografer', $perawat, session('radiografer'), ['class' => 'form-control select2', 'style'=>'width: 100%', 'placeholder'=>'']) !!}
                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('no_foto') ? ' has-error' : '' }}">
                  {!! Form::label('no_foto', 'No Foto', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <input type="text" name="no_foto" class="form-control">
                      <small class="text-danger">{{ $errors->first('no_foto') }}</small>
                  </div>
              </div>
                 <div class="form-group{{ $errors->has('diagnosa') ? ' has-error' : '' }}">
                    {!! Form::label('diagnosa', 'Diagnosa ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <input type="text" name="diagnosa" class="form-control">
                        <small class="text-danger">{{ $errors->first('diagnosa') }}</small>
                    </div>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
                    {!! Form::label('poli_id', 'Pelayanan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select class="chosen-select" name="poli_id">
                        @foreach ($opt_poli as $key => $d)
                            <option value="{{ $d->id }}" {{$d->id == poliRadiologi() ? 'selected' :''}}>{{ @$d->nama }}</option>
                        @endforeach
                      </select>
                        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                  {!! Form::label('Eksekutif', 'Eksekutif', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    <select class="chosen-select" name="cyto">
                      <option value="" selected>Tidak</option>
                      <option value="1">Ya</option>
                    </select>
                      <small class="text-danger">{{ $errors->first('cyto') }}</small>
                  </div>
                <div class="form-group{{ $errors->has('cyto_biasa') ? ' has-error' : '' }}">
                  {!! Form::label('Cyto', 'Cyto', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9" style="padding-left: 2rem !important; padding-top: 1rem;">
                      <input type="checkbox" name="cyto_biasa" class="form-check-input">
                      <small class="text-danger">{{ $errors->first('cyto_biasa') }}</small>
                  </div>
              </div>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                        @if (substr($jenis->status_reg,0,1) == 'G')
                          <a href="{{ url('radiologi/cetakRincianRad/ird/'.$reg_id) }}" class="btn btn-primary btn-flat pull-right">SELESAI</a>
                        @else
                          <a href="{{ url('radiologi/cetakRincianRad/irj/'.$reg_id) }}" class="btn btn-primary btn-flat pull-right">SELESAI</a>
                        @endif
                    </div>
                </div>
              </div>
            </div>

            {!! Form::close() !!}
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Tindakan</th>
                <th>Pelayanan</th>
                <th>Biaya</th>
                <th>Jml</th>
                <th>Total</th>
                <th>Dokter Radiologi</th>
                <th>Pelaksana</th>
                <th>Admin</th>
                <th>Waktu</th>
                <th>Periksa</th>
                <th>Bayar</th>
                {{-- @role(['supervisor', 'rawatdarurat','administrator']) --}}
                <th>Hapus</th>
                {{-- @endrole --}}
                <th>Note</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($folio as $key => $d)
              
              <tr>
                <td>{{ $no++ }}</td>
                @if (@$d->verif_kasa_user = 'tarif_new')
                  <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif_baru->nama : 'Penjualan Obat' }}</td>
                  <td>
                    @if ($d->jenis == 'TA')
                      Radiologi RJ
                    @elseif($d->jenis == 'TG')
                      Radiologi RD
                    @endif
                  </td>
                  {{-- @if($jenis->poli->kelompok == 'ESO') --}}
                    @if(!empty(@$d->cyto))
                      @php
                      // $cyto = ($d->tarif_baru->total * 30) / 100;
                      $cyto = $d->cyto;
                      $hargaSatuan = $d->tarif_baru->total + ($cyto / $d->harus_bayar);
                      $jml = $d->harus_bayar;
                      @endphp
                      <td>{{ ($d->tarif_id <> 0 ) ? number_format($hargaSatuan,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? $jml : '' }}</td>
                    @elseif (!empty(@$d->cyto_biasa))
                      @php
                      $hargaSatuan = $d->tarif_baru->total + ($d->cyto_biasa / $d->harus_bayar);
                      $jml = $d->harus_bayar;
                      @endphp
                      <td>{{ ($d->tarif_id <> 0 ) ? number_format($hargaSatuan ,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? $jml : '' }}</td>
                    @else
                      <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                    @endif
                  {{-- @else --}}
                      {{-- <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                  @endif --}}
                 
                @else
                  <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                  <td>
                    @if ($d->jenis == 'TA')
                      Radiologi RJ
                    @elseif($d->jenis == 'TG')
                      Radiologi RD
                    @endif
                  </td>
                  <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif->total) : '' }}</td>
                @endif
                  <td>{{ number_format($d->total,0,',','.') }}</td>
                  <td>{{ baca_dokter($d->dokter_radiologi) }}</td>
                  <td>{{ baca_dokter($d->radiografer) }}</td>
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at->format('d-m-Y') }}</td>
                  <td>
                    @if(!$d->waktu_periksa)
                      <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->id }}" onclick="periksa({{ $d->id }})"><i class="fa fa-pencil"></i></button>
                    @else
                      {{ @$d->waktu_periksa }}
                    @endif
                  </td>
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  {{-- @role(['supervisor', 'radiologi','administrator']) --}}
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      @if ( json_decode(Auth::user()->is_edit,true)['hapus'] == 1)
                        <a href="{{ url('radiologi/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                      @else
                      @endif
                    @endif

                  </td>
                  {{-- @endrole --}}
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->id }}" onclick="showNote({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      </div>
    </div>


    <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" id="form">
              <table class="table table-condensed table-bordered">
                <tbody>
                    <tr>
                      <th>Tanggal Order :<input class="form-control" type="date" name="tgl_order"> </th>
                      
                    </tr>
                    <tr>
                     
                        <th>Catatan : <input type="text" class="form-control" name="catatan" id="catatan"> </th>
                        <input type="hidden" name="id_reg"> 
                      
                    </tr>
                </tbody>
              </table>
            </form>
          </div>
          {{-- <div class="modal-footer">
            <button type="button" onclick="saveNote()" class="btn btn-default btn-flat">Simpan</button>
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div> --}}
        </div>
      </div>
    </div>



@stop

@section('script')
<script type="text/javascript">
  $('.select2').select2()

  function ribuan(x) {
     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  $(document).ready(function() {
    //TINDAKAN entry
    $('select[name="kategoriTarifID"]').on('change', function() {
        var tarif_id = $(this).val();
        if(tarif_id) {
            $.ajax({
                url: '/tindakan/getTarif/'+tarif_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    //$('select[name="tarif_id"]').append('<option value=""></option>');
                    $('select[name="tarif_id"]').empty();
                    $.each(data, function(id, nama, total) {
                        $('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
                    });

                }
            });
        }else{
            $('select[name="tarif_id"]').empty();
        }
    });
  });





    
  function showNote(id) {

      $('#pemeriksaanModel').modal()
      $('.modal-title').text('Catataan Order Radiologi')
      $("#form")[0].reset()
      $.ajax({
        url: '/radiologi/showNoteEmr/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="id_reg"]').val(data.id)
        $('input[name="tgl_order"]').val(data.embalase)
       $('input[name="catatan"]').val(data.catatan)
      })
      .fail(function() {
        alert(data.error);
      });

    }
  
  function periksa(id) {      
    $.ajax({
      url: '/radiologi/proses-periksa/'+id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(data) {
      if(data.status == '200'){
        alert(data.message);
        window.location.reload();
      }else{
        alert(data.message);
      }

    })
    .fail(function() {
      alert(data.error);
    });

  }


  

</script>
@endsection
