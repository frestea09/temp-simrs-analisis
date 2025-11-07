@extends('master')
@section('header')
  <h1>Laporan RL 3.8 Pemeriksaan Laboratorium</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaan-laboratorium', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        {{-- <div class="col-md-3">
          <div class="input-group{{ $errors->has('batas') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('batas') ? ' has-error' : '' }}" type="button">Batas</button>
              </span>
              {!! Form::number('batas', 10, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('batas') }}</small>
          </div>
        </div> --}}
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Tindakan</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @if ( isset($pemeriksaan_laboratorium) )
              @php
                $conf = App\Conf_rl\M_config38::all();
                $total = 0;
              @endphp
                @foreach ($conf as $k => $v)
                  <tr>
                    <td>{{ $v->nomer }}</td>
                    <td>{{ $v->kegiatan }}</td>
                    <td>
                      @foreach ($pemeriksaan_laboratorium as $key => $d)
                        @if( $d->id_conf_rl38 == $v->id_conf_rl38 )
                          {{ $d->count }}
                          @php $total += $d->count @endphp
                        @endif
                      @endforeach
                    </td>
                  </tr>
                @endforeach
                <tr>
                  <th>###</th>
                  <th>Total</th>
                  <th>{{ $total }}</th>
                </tr>
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
    $('#data-table').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });
  </script>
  @endsection