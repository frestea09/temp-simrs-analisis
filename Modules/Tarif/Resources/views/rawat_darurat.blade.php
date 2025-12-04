@extends('master')

@section('header')
  <h1>Keuangan - Tarif Rawat Darurat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Tarif &nbsp;
          <a href="{{ url('tarif/create/TG') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
          {!! Form::open(['method' => 'POST', 'route' => 'tarif.rawatdarurat-by-kategori-header', 'class' => 'form-horizontal']) !!}

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('tahuntarif') ? ' has-error' : '' }}">
                      {!! Form::label('tahuntarif', 'Tahun Tarif', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('tahuntarif', $thn_tarif, (Request::segment(3)) ? Request::segment(3) : configrs()->tahuntarif, ['class' => 'chosen-select']) !!}
                          <small class="text-danger">{{ $errors->first('tahuntarif') }}</small>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
                      {!! Form::label('kategoriheader_id', 'Kategori Tarif', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          <select class="chosen-select" name="kategoriheader_id" onchange="this.form.submit();">
                            {{-- <option value="" selected disabled>[Semua Tarif]</option> --}}
                            @foreach ($kh as $key => $d)
                              @if (!empty(Request::segment(4)) && Request::segment(4) == $d->id)
                                <option value="{{ $d->id }}" selected>{{ $d->namatarif }}</option>
                              @else
                                <option value="{{ $d->id }}" >{{ $d->namatarif }}</option>
                              @endif
                            @endforeach
                          </select>
                          {{-- {!! Form::select('kategoriheader_id', $kh, (Request::segment(4)) ? Request::segment(4) : '2', ['class' => 'chosen-select', 'onchange'=>'this.form.submit()']) !!} --}}
                          <small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
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
              </div>

          {!! Form::close() !!}
            <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
              <thead>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Thn Tarif</th>
                  <th class="text-center" style="vertical-align: middle;">Nama</th>
                  <th class="text-center" style="vertical-align: middle;">Jenis Akreditasi</th>
                  <th class="text-center" style="vertical-align: middle;">Total</th>
                  <th class="text-center" style="vertical-align: middle;">Akun COA</th>
                  <th class="text-center" style="vertical-align: middle;">Inhealth Jenpel </th>
                  <th class="text-center" style="vertical-align: middle;">kode-loinc </th>
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
                  <td>{{ $d->tahuntarif->tahun }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ @$d->jenis_akreditasi }}
                  <td>{{ number_format($d->total) }}</td>
                  @if (isset($d->akun_coa))
                    <td>{{ implode(' - ', [$d->akun_coa->code, $d->akun_coa->nama]) }}</td>
                  @else
                    <td>-</td>
                  @endif
                  <td>{{ $d->inhealth_jenpel }} </td>
                  <td>{{ $d->kodeloinc }} </td>
                    {{-- @if ($split->count() > 0)
                      @foreach ($split as $key => $r)
                       <td class="text-right">{{ number_format($r->nominal) }} </td>
                      @endforeach
                    @else
                      @for ($i=0; $i < 2; $i++)
                        <td class="text-right">0</td>
                      @endfor
                    @endif --}}
                    @php
                      $split = App\Split::where('tarif_id', $d->id)->get();
                      $jml = $split->count();
                    @endphp
                    @if ($split->count() > 0)
                      @foreach ($split as $key => $r)
                       <td class="text-right">{{ number_format($r->nominal) }} </td>
                      @endforeach
                    @else
                      {{-- @for ($i=0; $i < 2; $i++)
                        <td class="text-right">0</td>
                      @endfor --}}
                    @endif
                  <td>
                    <a href="{{ url('tarif/'.$d->id.'/edit/TA') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <button type="button" data-id="{{ $d->id }}" data-source='[{
                      "nama": "{{ $d->nama }}",
                      "inhealth_jenpel": "{{ $d->inhealth_jenpel }}",
                  }]' class="btn btn-primary btn-sm edit-inhealth">Inhealth</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

        <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form id="form-update" method="POST">
      {!! csrf_field() !!}
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Inhealth Jenpel</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Nama:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="nama">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Inhealth Jenpel:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="inhealth_jenpel">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Simpan</button>
      </div>
    </div>
    </form>

  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    let base_url = "{{ url('/') }}";

    $(document).on('click','.edit-inhealth', function(){
        let id = $(this).attr('data-id');
        let url = base_url+'/tarif/update-inhealth';
        let source = eval($(this).attr('data-source'));
        jQuery('#myModal').modal('show', {
            backdrop: 'static'
        });
        $('input[name="id"]').val(id);
        $('input[name="nama"]').val(source[0].nama);
        $('input[name="inhealth_jenpel"]').val(source[0].inhealth_jenpel);
        $('#form-update').attr('action',url)
    })
  </script>
@endsection