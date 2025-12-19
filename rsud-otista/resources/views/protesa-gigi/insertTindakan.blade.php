@extends('master')

@section('header')
  <h1>
    Entry Tindakan {{ $jenis }} - {{ $unit }}
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-widget widget-user"s>
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
                        <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} </h5>
                        <h5 class="widget-user-desc">: {{ baca_dokter($reg->dokter_id) }}</h5>
                    </div>
                    <div class="col-md-3 text-center">
                        <h4 class="widget-user-username">Total Tagihan</h4>
                        <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
                    </div>
                </div>
                </div>
            </div>
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'protesa-gigi/save-tindakan', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('jenis_pasien', $reg->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            {!! Form::hidden('jenis', $j) !!}
            {!! Form::hidden('poli_tipe', $poli_tipe) !!}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      <select name="tarif_id" class="form-control select2">
                        @foreach ($tarif as $t)
                            <option value="{{ $t->id }}">{{ $t->nama }} | {{ $t->total }}</option>
                        @endforeach
                      </select>
                      {{-- {!! Form::select('tarif_id', $tarif, null, ['class' => 'form-control chosen-select']) !!} --}}
                      <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('pelaksana', $pelaksana, null, ['class' => 'chosen-select', 'style'=>'width: 100%']) !!}
                        <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('cara_bayar') ? ' has-error' : '' }}">
                    {!! Form::label('cara_bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('cara_bayar_id', $carabayar, $reg->bayar, ['class' => 'chosen-select', 'style'=>'width: 100%']) !!}
                        <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                      @if($j == 'TI')
                        <a href="{{ url('protesa-gigi/tindakan-ranap') }}" class="btn btn-primary btn-flat">SELESAI</a>
                      @elseif($j == 'TA')
                        <a href="{{ url('protesa-gigi/tindakan-rajal') }}" class="btn btn-primary btn-flat">SELESAI</a>
                      @else
                        <a href="{{ url('protesa-gigi/tindakan-darurat') }}" class="btn btn-primary btn-flat">SELESAI</a>
                      @endif
                        <a href="{{ url('protesa-gigi/cetak-tindakan/'.$j.'/'.$reg->id) }}" target="_blank" class="btn btn-warning btn-flat">CETAK</a>
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
                <th class="text-center"></th>
                <th class="text-center">No</th>
                <th class="text-center">Tindakan</th>
                <th class="text-center">Biaya</th>
                <th class="text-center">Jml</th>
                <th class="text-center">Total</th>
                <th class="text-center">Pelaksana</th>
                <th class="text-center">Admin</th>
                <th class="text-center">Waktu</th>
                <th class="text-center">Cara Bayar</th>
                <th class="text-center">Bayar</th>
                @role(['supervisor', 'laboratorium','administrator'])
                    <th class="text-center">Hapus</th>
                @endrole
              </tr>
            </thead>
            <tbody>
            <form id="lunaskan">
              {{ csrf_field() }}
              @foreach ($folio as $key => $d)
                <tr>
                  <td>
                    <input type="checkbox" name="lunas[]" value="{{ $d->id }}">
                  </td>
                  <td class="text-center">{{ $no++ }}</td>

                  @if(date('Y-m-d H:i', strtotime($d->created_at)) < config('app.tarif_new') && date('Y-m-d H:i', strtotime($d->updated_at)) < config('app.tarif_new'))
                    <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif_lama->nama : 'Penjualan Obat' }}</td>
                    <td class="text-right">{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif_lama->total,0,',','.') : '' }}</td>
                    <td class="text-center">{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif_lama->total) : '' }}</td>
                  @else
                    <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif_baru->nama : 'Penjualan Obat' }}</td>
                    <td class="text-right">{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    <td class="text-center">{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                  @endif

                  <td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
                  <td>{{ baca_dokter($d->dokter_pelaksana) }}</td>
                  <td>{{ $d->user->name }}</td>
                  <td class="text-center">{{ $d->created_at->format('d-m-Y') }}</td>
                  <td class="text-center">{{ baca_carabayar($d->cara_bayar_id) }}</td>
                  <td class="text-center">
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  <td class="text-center">
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                        <a href="{{ url('protesa-gigi/hapus-tindakan/'.$d->id.'/'.$d->fol_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif
                  </td>
                </tr>
              @endforeach
              <tr>
                <td><button type="button" onclick="lunas()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                <td colspan="6">UPDATE TERBAYAR</td>
                <td><button type="button" onclick="belumLunas()" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
                <td colspan="4">UPDATE BELUM TERBAYAR</td>
              </tr>
            </form>
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
      var data = $('#lunaskan').serialize();
      if(confirm('Yakin akan di lunaskan?')){
        $.post('/protesa-gigi/lunas-tindakan', data, function(resp){
          if(resp.sukses == true){
            location.reload()
          }
        })
      }
    }
    function belumLunas(){
      var data = $('#lunaskan').serialize();
      if(confirm('Yakin belum lunas?')){
        $.post('/protesa-gigi/belum-lunas-tindakan', data, function(resp){
          if(resp.sukses == true){
            location.reload()
          }
        })
      }
    }
    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $(document).ready(function() {
      $('select[name="kategoriTarifID"]').on('change', function() {
        var tarif_id = $(this).val();
        if(tarif_id) {
          $.ajax({
            url: '/tindakan/getTarif/'+tarif_id,
            type: "GET",
            dataType: "json",
            success:function(data) {
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
