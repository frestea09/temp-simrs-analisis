@extends('master')

@section('header')
  <h1>Keuangan - Tarif Rawat Inap </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master  &nbsp;
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
                          <select class="chosen-select" name="kategoriheader_id" onchange="this.form.submit();">
                            <option></option>
                            @foreach ($kh as $key => $d)
                              @if (!empty(Request::segment(4)) && Request::segment(4) == $d->id)
                                <option value="{{ $d->id }}" selected>{{ $d->namatarif }}</option>
                              @else
                                <option value="{{ $d->id }}" >{{ $d->namatarif }}</option>
                              @endif
                            @endforeach
                          </select>
                          {{-- {!! Form::select('kategoritarif_id', $kh, Request::segment(4), ['class' => 'chosen-select', 'onchange'=>'this.form.submit()']) !!} --}}
                          <small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('jenis_akreditasi') ? ' has-error' : '' }}">
                    {!! Form::label('jenis_akreditasi', 'Jenis Akreditasi', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                         {!! Form::select('jenis_akreditasi', [''=>'','A'=>'Akreditasi A','B'=>'Akreditasi B','C'=>'Akreditasi C'], '', ['class' => 'form-control', 'onchange' => 'this.form.submit();']) !!}
                        <small class="text-danger">{{ $errors->first('jenis_akreditasi') }}</small>
                    </div>
                  </div>


                </div>
                <div class="col-md-6">

                </div>
              </div>

          {!! Form::close() !!}
          <hr>

       <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Nama</th>
                  <th class="text-center" style="vertical-align: middle;">Jenis Akreditasi </th>
                  <th class="text-center" style="vertical-align: middle;">Tahun Tarif</th>
                  <th class="text-center" style="vertical-align: middle;">Total Tarif </th>
                  @foreach (App\Mastersplit::where('kategoriheader_id', 2)->get() as $key => $d)
                    <th class="text-center" style="vertical-align: middle;">{{ $d->nama }}</th>
                  @endforeach
                  <th class="text-center" style="vertical-align: middle;">Edit</th>
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
                  <td>{{ @$d->jenis_akreditasi }}</td>
                  <td>{{ $d->tahuntarif->tahun }}</td>
                  <td>{{ number_format($d->total) }}</td>
                  @if ($split->count() > 0)
                      @foreach ($split as $key => $r)
                          <td class="text-right">{{ number_format($r->nominal) }}</td>
                      @endforeach
                  @else
                    @for ($i=0; $i < 7; $i++)
                      <td class="text-right">0</td>
                    @endfor
                  @endif
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
