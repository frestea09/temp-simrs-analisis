@extends('master')
@section('header')
  <h1>Pembuatan Rujuk Balik (PRB)</h1>
@endsection

@section('content')
<div class="box box-primary">
  @php
      $coder = !empty(Auth::user()->coder_nik) ? Auth::user()->coder_nik : '085227745567';
  @endphp

  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'bridgingsep/rujuk-balik', 'class'=>'form-hosizontal']) !!}
    <div class="row">

      <div class="col-sm-6">
        <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
            <span class="input-group-btn">
              <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">No. RM</button>
            </span>
            {{-- {!! Form::text('no_rm', null, ['class' => 'form-control']) !!} --}}
            <select name="no_rm" class="form-control" id="selectRM" onchange="this.form.submit()">
            </select>
            <small class="text-danger">{{ $errors->first('no_rm') }}</small>
        </div>
      </div>

      </div>
    {!! Form::close() !!}
    <hr>
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
          <tr>
            <th>No. RM</th>
            <th>Nama Pasien</th>
            <th>Poli</th>
            <th>DPJP</th>
            <th>No. SEP</th>
            <th>Tgl Reg</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($reg as $key => $d)
            <tr>
              <td>{{ $d->no_rm }}</td>
              <td>{{ $d->nama }}</td>
              <td>{{ !empty($d->poli_id) ? strtoupper($d->poli->nama) : '' }}</td>
              <td>{{ baca_dokter($d->dokter_id) }}</td>
              <td>
                <a href="#" class="btn btn-default btn-sm btn-flat"><b>{{ $d->no_sep }}</b></a>
                {{-- @if ($d->no_sep <> '')
                  @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                    <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id.'/?edit=1') }}" class="btn btn-default btn-sm btn-flat" title="EDIT KLAIM"><b>{{ $d->no_sep }}</b></a>
                  @else
                    <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id) }}" class="btn btn-default btn-sm btn-flat"><b>{{ $d->no_sep }}</b></a>
                  @endif
                @else
                  @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                    <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id.'/?edit=1') }}" class="btn btn-default btn-sm btn-flat" title="EDIT KLAIM"><b>EDIT KLAIM</b></a>
                  @else
                    <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id) }}" class="btn btn-default btn-sm btn-flat"><b>PROSES</b></a>
                  @endif
                @endif --}}
              </td>
              <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
              <td>
                <a href="{{ url('bridgingsep/rujuk-balik/'.$d->id) }}" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-upload"></i></a>
              </td>
            </tr>
          @endforeach
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
   
    $('#selectRM').select2({
      placeholder: "Pilih No Rm...",
      ajax: {
          url: '/pasien/master-pasien/',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })

  </script>
@endsection
