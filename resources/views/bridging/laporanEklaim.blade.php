@extends('master')
@section('header')
  <h1>Laporan Bridging Eklaim<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6">
          {!! Form::open(['method' => 'POST', 'url' => 'inacbg/laporan-eklaim', 'class'=>'form-horizontal']) !!}
            <div class="form-group">
              <label class="col-sm-3 control-label">Jenis Rawat</label>
              <div class="col-sm-9">
                <select name="jenis_rawat" class="form-control select2" style="width: 100%">
                  @if (isset($_POST['jenis_rawat']) and $_POST['jenis_rawat'] == 'J')
                    <option value="J" selected="true">Rawat Jalan</option>
                    <option value="G">Rawat Darurat</option>
                    <option value="I">Rawat Inap</option>
                  @elseif (isset($_POST['jenis_rawat']) and $_POST['jenis_rawat'] == 'G')
                    <option value="J">Rawat Jalan</option>
                    <option value="G" selected="true">Rawat Darurat</option>
                    <option value="I">Rawat Inap</option>
                  @elseif (isset($_POST['jenis_rawat']) and $_POST['jenis_rawat'] == 'I')
                    <option value="J">Rawat Jalan</option>
                    <option value="G">Rawat Darurat</option>
                    <option value="I" selected="true">Rawat Inap</option>
                  @else
                    <option value="J">Rawat Jalan</option>
                    <option value="G">Rawat Darurat</option>
                    <option value="I">Rawat Inap</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-sm-3 control-label">Tanggal</label>
              <div class="col-md-4">
                <input autocomplete="off" type="text" name="tga" value="{{ !empty($_POST['tga']) ? $_POST['tga'] : '' }}" class="form-control datepicker" >
                <small class="text-danger">{{ $errors->first('tga') }}</small>
              </div>
              <div class="col-md-4">
                <input autocomplete="off" type="text" name="tgb" value="{{ !empty($_POST['tgb']) ? $_POST['tgb'] : '' }}" class="form-control datepicker"  >
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">&nbsp;</label>
              <div class="col-sm-9">
                <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
                <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama Pasien</th>
              <th>Nomer RM</th>
              <th>Poli/Ruangan</th>
              <th>Nomer SEP</th>
              <th class="text-right">Tarif RS</th>
              <th class="text-right">Tarif Grouper</th>
              <th>Grouper</th>
              <th>Verif</th>
            </tr>
          </thead>
          <tbody>
            @if (isset($inacbg))
            @foreach( $inacbg as $d)
            @php
              $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
              $verif = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->count();
            @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $pasien ->nama }}</td>
                <td>{{ $pasien ->no_rm }}</td>
                <td>
                  @if (substr($d->status_reg,0,1) == 'J' OR substr($d->status_reg,0,1) == 'G')
                      {{ @baca_poli($d->poli_id) }}
                  @elseif(substr($d->status_reg,0,1) == 'I')
                      {{ @baca_kamar(\App\Rawatinap::where('registrasi_id', $d->registrasi_id)->first()->kamar_id) }}
                  @endif
                </td>
                <td>{{ $d->no_sep }}</td>
                <td class="text-right">{{ number_format($d->total_rs) }}</td>
                <td class="text-right">{{ number_format($d->dijamin) }}</td>
                <td class="text-center">
                  @if ($d->total_rs == 0 && $d->dijamin == 0)
                    <button class="btn btn-default btn-sm"><i class="fa fa-minus"></i></button>
                  @elseif($d->total_rs > 0 && $d->dijamin == 0)
                    <button class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></button>
                  @elseif($d->total_rs > 0 && $d->dijamin > 0)
                    <button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                  @endif
                </td>
                <td class="text-center">
                  @if ($verif > 0)
                    <button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                  @endif
                 </td>

              </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
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
