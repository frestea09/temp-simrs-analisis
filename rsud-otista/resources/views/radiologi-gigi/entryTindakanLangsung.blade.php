
@extends('master')

@section('header')
  <h1>
      Entry Tindakan Radiologi - Rawat Jalan
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Rekam Medis &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="row">
                <div class="col-md-2">
                  <h3 class="widget-user-username">Nama</h3>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                </div>
                <div class="col-md-7">
                  <h3 class="widget-user-username">:{{ $pasien->nama}}</h3>
                  <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar($jenis->bayar) }} </h5>
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
            {!! Form::open(['method' => 'POST', 'url' => 'radiologi-gigi/save-tindakan', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            <div class="row">
              <div class="col-md-7">
                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('dokter_id', 'Dokter Radiologi', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select class="form-control select2" style="width: 100%" name="dokter_radiologi">
                        @foreach($radiografer as $d)
                          <option value="{{ $d->id }}" {{session('dokter_radiologi') == $d->id ? 'selected' : ''}}>{{ $d->nama }}</option>
                        @endforeach
                      </select>
                        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      {!! Form::select('radiografer', $perawat, session('radiografer'), ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                      <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                  </div>
                </div>

                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select name="tarif_id" id="select2Multiple" class="form-control"></select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
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
                    {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="chosen-select" name="poli_id">
                          @foreach ($opt_poli as $key => $d)
                            <option value="{{ $d->id }}" {{$d->id == poliRadiologiGigi() ? 'selected' :''}}>{{ @$d->nama }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                        <a href="{{ url('radiologi-gigi/transaksi-langsung') }}" class="btn btn-primary btn-flat">SELESAI</a>
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
                {{--  <th>Dokter Radiologi</th>
                <th>Pelaksana</th>  --}}
                <th>Admin</th>
                <th>Waktu</th>
                <th>Bayar</th>
                @role(['supervisor', 'rawatdarurat','administrator'])
                <th>Hapus</th>
                @endrole
              </tr>
            </thead>
            <tbody>
              @foreach ($folio as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                  <td>{{ $d->poli->nama }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif->total) : '' }}</td>
                  <td>{{ number_format($d->total,0,',','.') }}</td>
                  {{--  <td>{{ baca_dokter($d->dokter_radiologi) }}</td>
                  <td>{{ baca_dokter($d->radiografer) }}</td>  --}}
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at->format('Y-m-d') }}</td>
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  @role(['supervisor', 'radiologi','administrator'])
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <a href="{{ url('radiologi-gigi/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif

                  </td>
                  @endrole
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop

@section('script')
<script type="text/javascript">
    function ribuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    status_reg = "<?= substr($jenis->status_reg,0,1) ?>"
  $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama tindakan",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan/'+status_reg,
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
