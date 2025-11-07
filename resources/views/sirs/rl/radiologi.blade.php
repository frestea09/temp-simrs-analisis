@extends('master')
@section('header')
  <h1>Laporan RL 3.7 Kegiatan Radiologi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kegiatan-radiologi', 'class'=>'form-hosizontal']) !!}
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
              <th>JENIS KEGIATAN</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @if ( isset($kegiatan_radiologi) )
            @php
              $conf = App\Conf_rl\M_config37::all();
              $total = 0;
            @endphp
            <tr>
              <th colspan="3">RADIODIAGNOSTIK</th>
            </tr>
            @foreach( $conf->whereIn('id_conf_rl37',[1,2,3,4,5,6,7,8,9]) as $k => $v )
            <tr>
              <td>{{ $k+1 }}</td>
              <td>{{ str_replace('RADIODIAGNOSTIK','',$v->kegiatan) }}</td>
              <td>
                @foreach ($kegiatan_radiologi as $key => $d)
                    @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
                      {{ $d->count }}
                      @php $total += $d->count @endphp
                    @endif
                @endforeach
              </td>
            </tr>
            @endforeach
            <tr>
              <th colspan="3">RADIOTHERAPI</th>
            </tr>
            @foreach( $conf->whereIn('id_conf_rl37',[10,11]) as $k => $v )
            <tr>
              <td>{{ $k+1 }}</td>
              <td>{{ str_replace('RADIOTHERAPI','',$v->kegiatan) }}</td>
              <td>
                @foreach ($kegiatan_radiologi as $key => $d)
                    @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
                      {{ $d->count }}
                      @php $total += $d->count @endphp
                    @endif
                @endforeach
              </td>
            </tr>
            @endforeach
            <tr>
              <th colspan="3">KEDOKTERAN NUKLIR</th>
            </tr>
            @foreach( $conf->whereIn('id_conf_rl37',[12,13,14]) as $k => $v )
            <tr>
              <td>{{ $k+1 }}</td>
              <td>{{ str_replace('KEDOKTERAN NUKLIR','',$v->kegiatan) }}</td>
              <td>
                @foreach ($kegiatan_radiologi as $key => $d)
                    @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
                      {{ $d->count }}
                      @php $total += $d->count @endphp
                    @endif
                @endforeach
              </td>
            </tr>
            @endforeach
            <tr>
              <th colspan="3">IMAGING/PENCITRAAN</th>
            </tr>
            @foreach( $conf->whereIn('id_conf_rl37',[15,16,17]) as $k => $v )
            <tr>
              <td>{{ $k+1 }}</td>
              <td>{{ str_replace('IMAGING/PENCITRAAN','',$v->kegiatan) }}</td>
              <td>
                @foreach ($kegiatan_radiologi as $key => $d)
                    @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
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