@extends('master')

@section('header')
  <h1>
    @if (substr($jenis->status_reg,0,1) == 'G')
      Sistem Rawat Darurat
    @else
      Sistem Rawat Jalan 
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
            <div class="widget-user-header bg-aqua-active" style="height: auto;">
              <div class="row">
                <div class="col-md-2">
                  <h4 class="widget-user-username">Nama</h4>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Tgl Lahir / Umur</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                @if($jenis->bayar == 1)
                  <h5 class="widget-user-desc">No JKN</h5>
                @endif
                  <h5 class="widget-user-desc">DPJP</h5>
                </div>
                <div class="col-md-7">
                  <h3 class="widget-user-username">:{{ $pasien->nama}}</h3>
                  <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ !empty($pasien->tgllahir) ? $pasien->tgllahir : ''}} / {{ !empty($pasien->tgllahir) ? hitung_umur($pasien->tgllahir) : NULL }}</h5>
                  <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar($jenis->bayar) }} </h5>
                @if($jenis->bayar == 1)
                  <h5 class="widget-user-desc">: {{ $pasien->no_jkn}}</h5>
                @endif
                  <h5 class="widget-user-desc">: {{ baca_dokter($jenis->dokter_id)}}</h5>

                </div>
                <div class="col-md-3 text-center">
                  <h3>Total Tagihan</h3>
                  <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
                </div>
              </div>
            </div>
            <div class="widget-user-image"></div>
          </div>
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'igd/save-entry-transit', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
            <div class="row">
              <div class="col-md-8">
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tarif Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control chosen-select" name="tarif_id">
                          {{-- @foreach(Modules\Tarif\Entities\Tarif::where('jenis', 'TA')->get() as $d) --}}
                          <option value=""></option>
                          @foreach($tindakan as $d)
                            <option value="{{ $d->id }}">{{ $d->namatarif }} | {{ $d->nama }} | {{ number_format($d->total) }} 
                              @if($d->carabayar == 1)
                                <b class="pull-right text-green">&nbsp&nbsp&nbsp&nbsp [ JKN ]</b>
                              @elseif($d->carabayar == 2)
                                <b class="pull-right text-blue">&nbsp&nbsp&nbsp&nbsp [ Umum ]</b>
                              @endif
                            </option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Dokter Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('pelaksana', $pelaksana, session('pelaksana'), ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                    {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('perawat', $perawat, session('perawat'), ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                        <small class="text-danger">{{ $errors->first('perawat') }}</small>
                    </div>
                </div>
                  <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                      {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-3">
                        <select name="cara_bayar_id" class="select2 form-control">
                        @foreach ($carabayar as $key => $item)
                          <option value="{{ $key }}" {{ ($key == $jenis->bayar) ? 'selected=selected' : '' }}>{{ $item }}</option>
                        @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                      </div>
                      {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-2 control-label']) !!}
                      <div class="col-sm-4">
                          {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                      </div>
                  </div>
              </div>

              <div class="col-md-4">
                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('tanggal', null, ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
                    {!! Form::label('poli_id', 'Pelayanan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="chosen-select" name="poli_id">
                          @foreach ($opt_poli as $key => $d)
                            @if ($d->id == $jenis->poli_id)
                              <option value="{{ $d->id }}" selected="true">{{ $d->nama }}</option>
                            @else
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endif

                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9 text-center">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
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
                {{-- <th></th> --}}
                <th>No</th>
                <th>Tindakan</th>
                <th>Pelayanan</th>
                {{-- <th>Biaya</th> --}}
                {{-- <th>Jml</th> --}}
                <th>Total</th>
                <th>Pelaksana</th>
                {{-- <th>Perawat</th> --}}
                <th width="80px">Cara Bayar</th>
                <th>Admin</th>
                <th>Waktu</th>
                <th>Bayar</th>
              @role(['rawatjalan','supervisor', 'rawatdarurat','administrator'])
                <th>Hapus</th>
              @endrole
              </tr>
            </thead>
            <tbody>
              <form id="formLunas">
                {{ csrf_field() }}
              @foreach ($folio as $key => $d)
                <tr>
                  {{-- <td>
                  @if($d->cara_bayar_id != 1)
                    <input type="checkbox" name="lunas[]" value="{{ $d->id }}">
                  @else
                    @role(['administrator'])
                      <input type="checkbox" name="lunas[]" value="{{ $d->id }}">
                    @endrole
                  @endif
                  </td> --}}
                  <td>{{ $no++ }}</td>
                  <td>{{ ($d->tarif_id <> 10000 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  {{-- <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td> --}}
                  {{-- <td class="text-center">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif->total) : '' }}</td> --}}
                  {{-- <td class="text-right">{{ number_format($d->total,0,',','.') }}</td> --}}
                  <td class="text-right">{{ number_format($d->total - $d->dijamin,0,',','.') }}</td>
                  <td>{{ baca_dokter($d->dokter_pelaksana) }}</td>
                  {{-- <td>{{ baca_dokter($d->perawat) }}</td> --}}
                  {{-- <td>{{ baca_carabayar($d->cara_bayar_id) }}</td> --}}
                  <td>
                    <div class="form-group">
                      {!! Form::select('bayar', $carabayar, $d->cara_bayar_id, ['class' => 'form-control select2', 'id' => $d->id]) !!}
                    </div>
                  </td>
                    {{--  @if (!empty($reg->perusahaan_id))
                      - {{ $reg->perusahaan->nama }}
                    @endif  --}}
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at->format('d-m-Y') }}</td>
                  <td class="text-center">
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  @role(['rawatjalan','kasir', 'supervisor', 'rawatdarurat','administrator'])
                  <td class="text-center">
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif
                  </td>
                  @endrole
                </tr>
                @endforeach
                </form>
                {{-- <tr>
                  <td><button onclick="lunas()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                  <td colspan="5">UPDATE TERBAYAR</td>
                @role(['administrator'])
                  <td><button type="button" onclick="belumLunas()" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                  <td colspan="7">UPDATE BELUM TERBAYAR</td>
                @endrole
                </tr> --}}
            </tbody>
          </table>
        </div>

        {{--  KONDISI PASIEN AKHIR  --}}
        {!! Form::open(['method' => 'POST', 'url' => 'igd/save-kondisi-transit', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('status_reg', substr($jenis->status_reg,0,1)) !!}

            <div class="form-group{{ $errors->has('kondisi_akhir_pasien') ? ' has-error' : '' }}">
                {!! Form::label('kondisi_akhir_pasien', 'Kondisi Akhir Pasien', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('kondisi_akhir_pasien', $kondisi, null, ['class' => 'chosen-select']) !!}
                    <small class="text-danger">{{ $errors->first('kondisi_akhir_pasien') }}</small>
                </div>
            </div>
            <div class="btn-group pull-right">
                <a href="{{ url('igd/transit') }}" class="btn btn-success btn-flat" onclick="confirm('Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!')">SELESAI</a>
                {{-- {!! Form::submit("SELESAI & VERIF", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar? Cek sekali lagi kondisi akhir Pasien!")']) !!} --}}
            </div>
        {!! Form::close() !!}
      </div>
    </div>
@stop

@section('script')
<script type="text/javascript">
  $('.select2').select2();
  $('select[name="bayar"]').on('change', function(){
    $.get('/tindakan/updateCaraBayar/'+$(this).attr('id')+'/'+$(this).val(), function(){
      location.reload();
    });
  })

  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function lunas(){
    var data = $('#formLunas').serialize();
    if(confirm('Yakin akan di lunaskan?')){
      $.post('/tindakan/lunas', data, function(resp){
        if(resp.sukses == true){
          location.reload()
        }
      })
    }
  }
  function belumLunas(){
    var data = $('#formLunas').serialize();
    if(confirm('Yakin belum lunas?')){
      $.post('/tindakan/belumLunas', data, function(resp){
        if(resp.sukses == true){
          location.reload()
        }
      })
    }
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

</script>
@endsection
