@extends('master')
@section('header')
  <h1>Laporan Verifikasi Berkas<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kasir/laporan-verifikasi-berkas', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-sm-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => true]) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => 'required']) !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Status Pelayanan</button>
            </span>
              <select name="status_pelayanan" class="form-control select2" style="width: 100%">
                  <option value="J">Rawat Jalan</option>
                  <option value="G">Rawat Darurat</option>
                  <option value="I">Rawat Inap</option>
              </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Cara Bayar</button>
            </span>
              <select name="cara_bayar" class="form-control select2" style="width: 100%">
                @foreach(\Modules\Registrasi\Entities\Carabayar::all() as $d )
                    <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                @endforeach
              </select>
          </div>
          <br/>
          <div class="pull-right">
            {{-- <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW"> --}}
            <input type="submit" name="tampil" class="btn btn-primary btn-flat" value="TAMPILKAN">
            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel" value="EXCEL">
          </div>
        </div>

      </div>
      {!! Form::close() !!}
      <hr>
      @isset($tga)
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' style="font-size: 12px;">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama</th>
              <th>No RM</th>
              <th class="text-center">Bayar</th>
              <th>Dokter</th>
              <th class="text-center">Klinik / Ruangan</th>
              <th class="text-center">Tarif Rs</th>
              <th class="text-center">Petugas Verifkasi</th>
              <th class="text-center">Tanggal Pendaftaran</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            @if (isset ($reg) )
              @foreach ($reg as $key => $d)
              @php
                  if (substr($d->status_reg, 0, 1) == 'J' OR substr($d->status_reg, 0, 1) == 'G') {
                    $poli = baca_poli($d->poli_id);
                  } elseif (substr($d->status_reg, 0, 1) == 'I') {
                    $irna = \App\Rawatinap::where('registrasi_id', $d->id)->first();
                    $poli = $irna ? baca_kamar($irna->kamar_id) : null;
                  } else {
                    $poli = baca_poli($d->poli_id);
                  }
                  $folio = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('verif_kasa', 'Y')->first();
                  $total = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->sum('total');
                  $count = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('verif_kasa', 'Y')->count();
              @endphp 
                <tr>
                  <td>{{ $no++  }}</td>
                  <td>{{@$d->pasien->nama}}</td>
                  <td>{{@$d->pasien->no_rm}}</td>
                  <td class="text-center">{{@baca_carabayar($d->bayar)}}</td>
                  <td>{{@baca_dokter($d->dokter_id)}}</td>
                  <td class="text-center">{{$poli}}</td>
                  <td class="text-right">{{number_format($total)}}</td> 
                  <td class="text-right">{{$folio ? $folio->verif_kasa_user : null}}</td> 
                  <td class="text-center">{{$d->created_at->format('d-m-Y H:i')}}</td> 
                  <td class="text-right">{{($count >= 1) ? 'Sudah Terverif' : 'Belum'}}</td> 
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
      @endisset
      {{-- <div class="pull-right">
        @if (isset($reg))
          {!! $reg->render() !!}
        @endif
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>

@endsection
@section('script')
  <script>
    $('.select2').select2();
  </script>
@endsection