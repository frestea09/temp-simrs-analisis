@extends('master')
@section('header')
  <h1>Laporan RL 3.13b Penulisan dan Pelayanan Resep Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'pelayanan-resep', 'class'=>'form-hosizontal']) !!}
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
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
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
          <h5>B. Penulisan dan Pelayanan Resep</h5>
          <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
                <th class="text-left" valign="top">No</th>
                <th class="text-left" valign="top">GOLONGAN OBAT</th>
                <th class="text-left">RAWAT JALAN</th>
                <th class="text-left" valign="top">IGD</th>
                <th class="text-left">RAWAT INAP</th>
            </tr>
          </thead>
          <tbody>
                <tr>
                  <td>1</td>
                  <td class="text-left">Obat Generik (Formularium+Non Formularium)</td>
                  <td class="text-left">{{ number_format($data['rawat_jalan_formalium_non']) }}</td>
                  <td class="text-left">{{ number_format($data['rawat_igd_formalium_non']) }}</td>
                  <td class="text-left">{{ number_format($data['rawat_irna_formalium_non']) }}</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td class="text-left">Obat Non Generik Formularium</td>
                  <td class="text-left">{{ number_format($data['rawat_jalan_formalium']) }}</td>
                  <td class="text-left">{{ number_format($data['rawat_igd_formalium']) }}</td>
                  <td class="text-left">{{ number_format($data['rawat_irna_formalium']) }}</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td class="text-left">Obat Non Generik Non Formularium</td>
                  <td class="text-left">{{ number_format($data['rawat_jalan_formalium_non_genrik']) }}</td>
                  <td class="text-left">{{ number_format($data['rawat_igd_formalium_non_generik']) }}</td>
                  <td class="text-left">{{ number_format($data['rawat_irna_formalium_non_generik']) }}</td>
                </tr>
                <tr>
                  <th>#</th>
                  <th class="text-left">Total</th>
                  <th class="text-left">{{ number_format($data['rawat_jalan_formalium_non'] + $data['rawat_jalan_formalium'] + $data['rawat_jalan_formalium_non_genrik']) }}</th>
                  <th class="text-left">{{ number_format($data['rawat_igd_formalium_non'] + $data['rawat_igd_formalium'] + $data['rawat_igd_formalium_non_generik']) }}</th>
                  <th class="text-left">{{ number_format($data['rawat_irna_formalium_non'] + $data['rawat_irna_formalium'] + $data['rawat_irna_formalium_non_generik']) }}</th>
                </tr>
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