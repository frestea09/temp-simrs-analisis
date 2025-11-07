@extends('master')

@section('header')
  <h1>
    @if (substr($jenis->status_reg,0,1) == 'G')
      Entry Tindakan Rehabilitasi - Rawat Darurat
    @elseif(substr($jenis->status_reg,0,1) == 'M')
      Entry Tindakan Rehabilitasi - Pasien Langsung
    @else
      Entry Tindakan Rehabilitasi - Rawat Jalan
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
          <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active" style="height: 180px;">
              <div class="row">
                <div class="col-md-2">
                  <h4 class="widget-user-username">Nama</h4>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                  <h5 class="widget-user-desc">DPJP</h5>
                  <h5 class="widget-user-desc">Registrasi</h5>
                </div>
                <div class="col-md-7">
                  <h4 class="widget-user-username">:{{ @$pasien->nama}}</h4>
                  <h5 class="widget-user-desc">: {{ @$pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ @$pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar(@$jenis->bayar) }} </h5>
                  <h5 class="widget-user-desc">: {{ baca_dokter(@$jenis->dokter_id) }}</h5>
                  <h5 class="widget-user-desc">: {{ (@$reg->created_at)->format('d M Y')}}</h5>
                </div>
                <div class="col-md-3 text-center">
                  <h3>Total Tagihan</h3>
                  <h2 style="margin-top: -5px;">Rp. {{ number_format(@$tagihan,0,',','.') }}</h2>
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
            {!! Form::open(['method' => 'POST', 'url' => 'rehabmedik/save-tindakan', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            <div class="row">
              <div class="col-md-7">
                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('dokter_id', 'Dokter Rehabmedik', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {{-- {!! Form::select('dokter_id', $dokter, 56, ['class' => 'chosen-select', 'placeholder'=>'']) !!} --}}
                        <select name="dokter_id" id="" class="form-control select2">
                            <option value="{{ $jenis->dokter_id }}">{{ baca_dokter(@$jenis->dokter_id )}}</option>
                            @foreach ($dokter as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                          <option value=""></option>
                        </select>
                        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select name="tarif_id[]" id="select2Multiple" class="form-control" multiple="multiple"></select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select name="pelaksans" id="" class="form-control select2">
                        @foreach ($perawat as $c)
                            <option value="{{ $c->id }}">{{ $c->nama }}</option>
                        @endforeach
                      <option value=""></option>
                    </select>
                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                    {!! Form::label('cara_bayar_id', 'Cara Bayar ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('cara_bayar_id', $carabayar, $jenis->bayar, ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                        <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
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
                              @if ($d->id == 16)
                                  <option value="{{ $d->id }}" selected>{{ @$d->nama }}</option>
                              @else
                                  <option value="{{ $d->id }}">{{ @$d->nama }}</option>
                              @endif
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                        @if (substr($jenis->status_reg,0,1) == 'G')
                          <a href="{{ url('rehabmedik/tindakan-ird') }}" class="btn btn-primary btn-flat">SELESAI</a>
                        @else
                          <a href="{{ url('rehabmedik/tindakan-irj') }}" class="btn btn-primary btn-flat">SELESAI</a>
                        @endif
                          <a href="{{ url('rehabmedik/rehabIrjCetak/'.$reg->id.'/'.$pasien->id) }}" target="_blank" class="btn btn-warning btn-flat">CETAK</a>
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
                <td></td>
                <th>No</th>
                <th>Tindakan</th>
                <th>Pelayanan</th>
                <th>Biaya</th>
                <th>Jml</th>
                <th>Total</th>
                {{--  <th>Dokter Radiologi</th>
                <th>Pelaksana</th>  --}}
                <th>Admin</th>
                <th>Waktu</th>
                <th>Cara Bayar</th>
                <th>Bayar</th>
                @role(['supervisor', 'rawatdarurat', 'administrator', 'rehabmedik'])
                <th>Hapus</th>
                @endrole
              </tr>
            </thead>
            <tbody>
              <form id="formLunas">
                {{ csrf_field() }}
              @foreach ($folio as $key => $d)
                <tr>
                  <td class="text-center"><input type="checkbox" name="lunas[]" value="{{ $d->id }}"></td>
                  <td>{{ $no++ }}</td>
                  <td>{{ (@$d->tarif_id <> 0 ) ? @$d->tarif->nama : 'Penjualan Obat' }}</td>
                  <td>{{ @$d->poli->nama }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? number_format(@$d->tarif->total,0,',','.') : '' }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? (@$d->total / @$d->tarif->total) : '' }}</td>
                  <td>{{ number_format(@$d->total,0,',','.') }}</td>
                  {{--  <td>{{ baca_dokter(@$d->dokter_id) }}</td>
                  <td>{{ baca_dokter(@$d->radiografer) }}</td>  --}}
                  <td>{{ $d->user->name }}</td>
                  <td>{{ @$d->created_at->format('d-m-Y') }}</td>
                  <td class="text-center">{{ baca_carabayar(@$d->cara_bayar_id) }}</td>
                  <td class="text-center">
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  @role(['supervisor', 'rawatdarurat', 'administrator', 'rehabmedik'])
                  <td>
                    @if (@$d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <a href="{{ url('rehabmedik/hapus-tindakan/'.@$d->id.'/'.@$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif
                  </td>
                  @endrole
                </tr>
              @endforeach
              </form>
              <tr>
                <td><button onclick="lunas()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                <td colspan="6">UPDATE TERBAYAR</td>
              {{-- @role(['administrator'])
                <td><button type="button" onclick="belumLunas()" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                <td colspan="7">UPDATE BELUM TERBAYAR</td>
              @endrole --}}
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop

@section('script')
  <script type="text/javascript">
     $('.select2').select2();
      function lunas(){
        var data = $('#formLunas').serialize();
        if(confirm('Yakin akan di lunaskan?')){
          $.post('/tindakan/lunas', data, function(resp){
            console.log(resp);
            location.reload();
            if(resp.sukses == true){
              location.reload()
            }
          })
        }
      }
      function ribuan(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      //TINDAKAN entry
     
  $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama kode",
      width: '100%',
      ajax: {
          url: '/rehabmedik/tarif/fisio',
          dataType: 'json',
          data: function (params) {
              return {
                  j: 1,
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
  </script>
@endsection
