@extends('master')

@section('header')
  <h1>Batal Bayar<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => 'kasir/batal-bayar', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()','autocomplete'=>'off']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Pelayanan</th>
              <th>Alamat</th>
              <th>Tgl Registrasi</th>
              <th>Tgl Bayar</th>
              <th class="text-center">Total Bayar</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              @if (!empty($d->pasien_id))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ @$d->poli->nama }}</td>
                  <td>{{ $d->pasien->alamat }}</td>
                  <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                  <td>{{ tanggal($d->updated_at) }}</td>
                  <td class="text-right">{{ number_format(App\Pembayaran::where('registrasi_id', $d->id)->sum('dibayar')) }}</td>
                  <td>
                    <button class="btn btn-primary btn-sm btn-flat" id="showRincian" data-id={{ $d->id }}><i class="fa fa-search-plus"></i></button>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>


  <div class="modal fade" id="rincianBayar" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Rincian Pembayaran</h4>
        </div>
        <div class="modal-body" id="dataRincianBayar">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
