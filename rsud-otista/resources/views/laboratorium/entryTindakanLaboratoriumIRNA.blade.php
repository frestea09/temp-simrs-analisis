@extends('master')

@section('header')
  <h1>
    Entry Tindakan Laboratorium - Rawat INAP
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
          <div class="box box-widget widget-user"s>
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active" style="height: 175px">
              <div class="row">
                <div class="col-md-2">
                  <h4 class="widget-user-username">Nama</h4>
                  <h5 class="widget-user-desc">Tgl Lahir / Umur</h5>
                  <h5 class="widget-user-desc">Jenis Kelamin</h5>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                  <h5 class="widget-user-desc">DPJP</h5>
                </div>
                <div class="col-md-7">
                  <h4 class="widget-user-username">:{{ $pasien->nama}}</h4>
                  <h5 class="widget-user-desc">: {{ !empty($pasien->tgllahir) ? date('d M Y', strtotime($pasien->tgllahir)) : null }} / {{ !empty($pasien->tgllahir) ? hitung_umur($pasien->tgllahir) : NULL }}</h5>
                  <h5 class="widget-user-desc">: {{ ($pasien->kelamin == 'L') ? 'Laki-laki' : 'Perempuan'}}</h5>
                  <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar($jenis->bayar) }} </h5>
                  <h5 class="widget-user-desc">: {{ baca_dokter($jenis->dokter_id) }}</h5>
                </div>
                <div class="col-md-3 text-center">
                  <h4 class="widget-user-username">Total Tagihan</h4>
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
            {!! Form::open(['method' => 'POST', 'url' => 'laboratorium/save-tindakan', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                  {!! Form::label('dokter_id', 'Dokter LAB', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control" name="dokter_lab">
                        @foreach($dokter_poli as $d)
                          <option value="{{ $d }}"> {{ baca_dokter($d) }}</option>
                        @endforeach             
                     </select>
  
                     <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                {!! Form::label('tarif_id', 'Tindakan*', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">

                    {{-- <select class="select2-multiple form-control" name="tarif_id[]" multiple="multiple" id="select2Multiple">
                      @foreach($tindakan as $d)
                        <option value="{{ $d->id }}"> {{ $d->nama }} | {{ number_format($d->total) }}
                        @if($d->carabayar == 1)
                          <b class="pull-right text-green">&nbsp;&nbsp;&nbsp;&nbsp; [ JKN ]</b>
                        @elseif($d->carabayar == 2)
                          <b class="pull-right text-blue">&nbsp;&nbsp;&nbsp;&nbsp; [ Umum ]</b>
                        @endif
                        </option>
                      @endforeach             
                   </select> --}}
                   <select name="tarif_id[]" id="select2Multiple" class="form-control" multiple="multiple">
                       
                   </select>
                   <small class="text-danger">* Billing Langsung terkoneksi dengan LIS</small>
                    <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                </div>
            </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                  {!! Form::label('pelaksana', 'Pelaksana LAB', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control" name="analis_lab">
                        @foreach($perawat_poli as $d)
                          <option value="{{ $d }}"> {{ baca_pegawai($d) }}</option>
                        @endforeach             
                     </select>
  
                     <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                  </div>
                </div>
  
                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('cara_bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('cara_bayar_id', $carabayar, $jenis->bayar, ['class' => 'chosen-select', 'style'=>'width: 100%']) !!}
                        <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                @if (substr($jenis->status_reg, 0, 1) == 'G')
                  <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                      {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          {!! Form::select('perawat', $perawat, session('perawat'), ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                          <small class="text-danger">{{ $errors->first('perawat') }}</small>
                      </div>
                  </div>
                @endif

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
                              @if ($d->id == 19)
                                  <option value="19" selected>{{ $d->nama }}</option>
                              @else
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endif
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {{-- {!! Form::text('tanggal', null, ['class' => 'form-control datepicker']) !!} --}}
                        {!! Form::text('tanggal',date("d-m-Y"), ['class' => 'form-control datepicker','autocomplete'=>'off']) !!}
                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                  {!! Form::label('cyto', 'Cyto', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="chosen-select" name="cyto">
                          <option value="" selected>Tidak</option>
                          <option value="1">Ya</option>
                      </select>
                      <small class="text-danger">{{ $errors->first('cyto') }}</small>
                  </div>
                 </div>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                        <a href="{{ url('laboratorium/tindakan-irna') }}" class="btn btn-primary btn-flat">SELESAI</a>
                        <a href="{{ url('laboratorium/cetakRincianLab/irna/'.$reg_id) }}" target="_blank" class="btn btn-warning btn-flat">CETAK</a>
                        <div class="btn-group" style="min-width: 0px !important">
                          <button type="button" class="btn btn-danger btn-md"><i class="fa fa-print"></i></button>
                          <button type="button" class="btn btn-danger btn-md dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            {{-- @php
                                $folios = ;
                            @endphp --}}
                            {{-- @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->select('created_at')->select(DB::raw('DATE(created_at) as date'))->get() as $p) --}}
                            @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg_id)->where('poli_tipe', 'L')->select('created_at')->groupBy(DB::raw('hour(created_at),day(created_at)'))->orderBy('id','DESC')->get() as $p)
                            @php
                                $datetime = str_replace(" ","_",date('Y-m-d H:i',strtotime($p->created_at)))
                            @endphp
                              <li>
                                <a href="{{ url("laboratorium/cetakRincianLab-pertgl/irna/".$reg_id."/".$datetime) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ date('d-m-Y H:i',strtotime($p->created_at)) }} </a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
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
                <th>Poli</th>
                <th>Biaya</th>
                <th>Jml</th>
                <th>Total</th>
                <th>Dokter PK</th>
                <th>Pelaksana LAB</th>
                <th>Admin</th>
                <th>Waktu</th>
                <th>Cara Bayar</th>
                <th>Bayar</th>
                @role(['supervisor', 'laboratorium','administrator'])
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
                  <td>{{ baca_dokter($d->dokter_lab) }}</td>
                  <td>{{ baca_dokter($d->analis_lab) }}</td>
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at }}</td>
                  <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  @role(['supervisor', 'laboratorium','administrator'])
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      @if ( json_decode(Auth::user()->is_edit,true)['hapus'] == 1)
                        <a href="{{ url('laboratorium/hapus-tindakan-irj/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                      @else
                      @endif
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
    $('.select2').select2();
  </script>
    <script>
      $(document).ready(function() {
          // Select2 Multiple
          $('.select2-multiple').select2({
              placeholder: "Pilih Multi Tindakan",
              allowClear: true
          });

      });
</script>

<script type="text/javascript">
    status_reg = "<?= substr($jenis->status_reg,0,1) ?>"
    function ribuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama tindakan",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan-lis/'+status_reg,
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
