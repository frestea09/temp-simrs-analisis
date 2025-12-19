@extends('master')

@section('header')
  <h1>Keuangan - Tarif Rawat Inap </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Tarif &nbsp;
          <a href="{{ url('tarif/create/TI') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
          {!! Form::open(['method' => 'POST', 'route' => 'tarif.irna-by-request', 'class' => 'form-horizontal']) !!}

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('tahuntarif') ? ' has-error' : '' }}">
                      {!! Form::label('tahuntarif', 'Tahun Tarif', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('tahuntarif', $thn_tarif, Request::segment(3) ? Request::segment(3) : configrs()->tahuntarif, ['class' => 'chosen-select']) !!}
                          <small class="text-danger">{{ $errors->first('tahuntarif') }}</small>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('kategoritarif_id') ? ' has-error' : '' }}">
                      {!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('kategoritarif_id', $kh, Request::segment(4), ['class' => 'chosen-select', 'onchange'=>'this.form.submit()']) !!}
                          <small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
                      </div>
                  </div>


                </div>
                <div class="col-md-6">

                </div>
              </div>

          {!! Form::close() !!}
          <hr>

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tahun Tarif</th>
                  <th>Kategori Tarif / Split</th>
                  <th>Total Tarif</th>
                  <th>Edit</th>
                </tr>
              </thead>
            <tbody>
              @foreach ($tarif as $key => $d)
                  @php
                    $split = App\Split::where('tarif_id', $d->id)->get();
                  @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->tahuntarif->tahun }}</td>
                  <td>{{ $d->kategoritarif->namatarif }}
                      @if ($split->count() > 0)
                        <table class="table table-condensed">
                          @foreach ($split as $key => $r)
                            <tr>
                              <td style="width: 5%;"></td><td>{{ $r->nama }}</td> <td class="text-right">{{ number_format($r->nominal) }}</td>
                            </tr>
                          @endforeach
                        </table>
                      @endif
                  </td>
                  <td>{{ number_format($d->total) }}</td>
                  <td>
                    <a href="{{ url('tarif/'.$d->id.'/edit/TI') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
