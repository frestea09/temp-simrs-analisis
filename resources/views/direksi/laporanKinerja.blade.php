@extends('master')

@section('header')
  <h1>Laporan Kinerja</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/direksi/laporan-kinerja', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No. SEP</th>
              <th>Dokter</th>
              <th>Biaya RS</th>
              <th>Tindakan</th>
              <th>Prosedur</th>
              <th>Kode</th>
              <th>Dijamin</th>
              <th>Selisih</th>
              <th>JP</th>
              <th>JS</th>
              <th>RVU JP </th>

            </tr>
          </thead>
          <tbody>
            @if (isset($inacbg))
              @foreach ($inacbg as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien_nama }}</td>
                  <td>{{ $d->no_sep }}</td>
                  <td>{{ $d->dokter }}</td>
                  <td>{{ number_format($d->total_rs) }}</td>
                  <td>{{ $d->icd1 }}</td>
                  <td>{{ $d->prosedur1 }}</td>
                  <td>{{ $d->kode }}</td>
                  <td>{{ number_format($d->dijamin) }}</td>
                  <td class="text-center">
                    @if ($d->dijamin > $d->total_rs)
                      <span class="text-success" style="font-weight: bold;"> + </span>
                    @else
                      <span class="text-danger"style="font-weight: bold;"> - </span>
                    @endif
                  </td>
                  <td>{{ number_format( (40/100 * $d->total_rs) ) }}</td>
                  <td>{{ number_format( (60/100 * $d->total_rs) ) }}</td>
                  <td>{{ ($d->total_rs <> 0) ? number_format( (40/100 * $d->total_rs) / $d->total_rs * $d->dijamin ) : NULL }}</td>
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
    <script type="text/javascript">

    </script>
@endsection
