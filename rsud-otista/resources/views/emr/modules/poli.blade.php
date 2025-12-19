@extends('master')
@section('header')
  <h1>Rawat {{$unit}} - Order Poli <small></small></h1>
@endsection

@section('content')
@include('emr.modules.addons.profile')
  <div class="box box-primary">
    {{-- <div class="box-header with-border">
      <h3 class="box-title">Data Tindakan Laboratorium Rawat Jalan</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div> --}}
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
        </div>
      </div>
      <br/>
      {!! Form::open(['method' => 'POST', 'url' => url('emr/save-tindakan'), 'class' => 'form-horizontal']) !!}
      {!! Form::hidden('registrasi_id', $reg->id) !!}
      {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
      {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
      {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
      {!! Form::hidden('page', 'labJalan') !!}
      <div class="row">
        <div class="col-md-7">
          <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
            {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                <select class="form-control chosen-select" name="tarif_id">
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
            {!! Form::label('perawat', 'Laboran', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('perawat', $perawat, session('perawat'), ['class' => 'chosen-select', 'placeholder'=>'']) !!}
                <small class="text-danger">{{ $errors->first('perawat') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
            {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('cara_bayar_id', $carabayar, $reg->bayar, ['class' => 'chosen-select', 'placeholder'=>'']) !!}
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
              <div class="col-sm-9">
                  <a href="{{ url('tindakan') }}" class="btn btn-warning btn-flat">Kembali</a>
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat pull-right', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
              </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
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
              <th>Pelaksana</th>
              <th>Perawat</th>
              <th>Cara Bayar</th>
              <th>Admin</th>
              <th>Waktu</th>
              @role(['rawatjalan','supervisor', 'rawatdarurat','administrator'])
              <th>Hapus</th>
              @endrole
            </tr>
          </thead>
          <tbody>
            @foreach ($folio as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ ($d->tarif_id <> 10000 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                @if (@$d->verif_kasa_user = 'tarif_new')
                <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                @else
                <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif->total) : '' }}</td>
                @endif
                {{-- <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                <td class="text-center">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif->total) : '' }}</td> --}}
                <td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
                <td>{{ baca_dokter($d->dokter_pelaksana) }}</td>
                <td>{{ baca_dokter($d->perawat) }}</td>
                <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                <td>{{ $d->user->name }}</td>
                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                @role(['rawatjalan','kasir', 'supervisor', 'rawatdarurat','administrator'])
                <td>
                  @if ($d->lunas == 'Y')
                    <i class="fa fa-check"></i>
                  @else
                    <a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
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
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4>Pemeriksaan Laboratorium</h4>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      @include('tinymce')
      {!! Form::open(['method' => 'POST', 'url' => 'tindakan/simpanLabJalan', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('registrasi_id', $reg->id) !!}
        {!! Form::hidden('dokter', $reg->dokter_id) !!}
        <textarea id="editor1" name="pemeriksaan" rows="10" cols="80"></textarea>
        <br/>
        <div class="row">
          <div class="col-sm-12">
            <div class="btn-group pull-right">
                <a href="{{ url('tindakan') }}" class="btn btn-warning btn-flat">Batal</a>
                {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
            </div>
          </div>
        </div>
      {!! Form::close() !!}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr><th colspan='4'>Pemeriksaan Laboratorium Sebelumnya</th></tr>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Pemeriksaan</th>
              <th class="text-center">Oleh</th>
              <th class="text-center">Tgl Order</th>
            </tr>
          </thead>
          <tbody>
            @php $no = 1; @endphp
            @foreach ($order as $d)
              <tr>
                <th class="text-center" width="50px">{{ $no++ }}</td>
                <td>{!! $d->pemeriksaan !!}</td>
                <td>{{ App\User::find($d->user_id)->name }}</td>
                <td width="200px">{{ $d->created_at->format('d - m - Y / H:i:s') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    $('.select2').select2();
  </script>
@endsection