@extends('master')

@section('header')
  <h1>
      Entry Tindakan Laboratorium - Rawat Jalan
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
            {!! Form::open(['method' => 'POST', 'url' => 'laboratoriumCommon/save-tindakan', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            <div class="row">
              <div class="col-md-7">
                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('dokter_id', 'Dokter Lab', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select class="form-control select2" name="dokter_lab">
                        @foreach($dokter_poli as $d)
                          <option value="{{ $d }}"> {{ baca_dokter($d) }}</option>
                        @endforeach             
                     </select>
                        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select class="form-control select2" name="analis_lab">
                        @foreach($perawat_poli as $d)
                          <option value="{{ $d }}"> {{ baca_pegawai($d) }}</option>
                        @endforeach             
                     </select>
                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control select2-multiple" name="tarif_id[]" multiple="multiple">
                          {{-- @foreach(Modules\Tarif\Entities\Tarif::where('jenis', 'TA')->get() as $d) --}}
                          @foreach($tindakan as $d)
                           <option value="{{ $d->id }}">{{ $d->nama }} | Rp. {{ number_format($d->total) }} 
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
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                    </div>
                </div>
                <div class="form-group">
                  <label for="bayar" class="col-sm-3 control-label">Cara Bayar</label>
                  <div class="col-sm-9">
                    <select name="bayar" class="form-control select2" style="width: 100%">
                      @foreach ($cara_bayar as $d)
                        <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                      <a href="{{ url('laboratoriumCommon/entry-tindakan-langsung') }}" class="btn btn-primary btn-flat">SELESAI</a>
                      <a href="{{ url('laboratoriumCommon/tindakan-cetak/'.$reg_id) }}" target="_blank" class="btn btn-warning btn-flat">CETAK</a>
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
                {{--  <th>Dokter Lab</th>
                <th>Analis Lab</th>  --}}
                <th>Admin</th>
                <th>Waktu</th>
                <th>Cara Bayar</th>
                <th>Bayar</th>
                {{-- @role(['supervisor', 'rawatdarurat','administrator']) --}}
                <th>Hapus</th>
                {{-- @endrole --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($folio as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  @if (@$d->verif_kasa_user == 'tarif_new')
                    <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif_baru->nama : 'Penjualan Obat' }}</td>
                    <td>{{ $d->poli->nama }}</td>
                    <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                  @else
                    <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                    <td>{{ $d->poli->nama }}</td>
                    <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                    <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif->total) : '' }}</td>
                  @endif
                  <td>{{ number_format($d->total,0,',','.') }}</td>
                  {{--  <td>{{ baca_dokter($d->dokter_lab) }}</td>
                  <td>{{ baca_dokter($d->analis_lab) }}</td>  --}}
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at->format('Y-m-d H:i:s') }}</td>
                  <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
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
                      <a href="{{ url('laboratoriumCommon/hapus-tindakan-irj/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif
                  </td>
                  {{-- @endrole --}}
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
  $('.select2').select2();
  $(document).ready(function() {
    // Select2 Multiple
    $('.select2-multiple').select2({
        placeholder: "Pilih Multi Tindakan",
        allowClear: true
    });
    status_reg = "<?= substr($jenis->status_reg,0,1) ?>";

    function ribuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama tindakan",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan-lab-common/'+status_reg,
          // url: '/tindakan/ajax-tindakan/'+status_reg,
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
    });
   
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
