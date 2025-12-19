@extends('master')
@section('header')
  <h1>Laporan RL 3.13a Pengadaan Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'pengadaan-obat', 'class'=>'form-hosizontal']) !!}
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
        {{-- <div class="col-md-3">
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
        </div> --}}
        <div class="col-md-3">
          {{-- <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW"> --}}
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
        <div class='table-responsive'>
          <h5>A. Pengadaan Obat</h5>
          <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
          <tr>
                <th class="text-center" valign="top">No</th>
                <th class="text-center" valign="top">GOLONGAN OBAT</th>
                <th class="text-center" valign="top">JUMLAH ITEM OBAT</th>
                <th class="text-center">JUMLAH ITEM OBAT YANG TERSEDIA DI RUMAH SAKIT</th>
                <th class="text-center">JUMLAH ITEM OBAT FORMULATORIUM TERSEDIA DIRUMAH SAKIT</th>
            </tr>
          </thead>
          <tbody>
                <tr>
                  <td>1</td>
                  <td class="text-left">Obat Generik (Formularium+Non Formularium)</td>
                  <td class="text-left">{{ $data['obat_seluruh_obat'] }}</td>
                  <td class="text-left">{{ $data['obat_seluruh_obat'] }}</td>
                  <td class="text-left">{{ $data['obat_seluruh_formularium_obat'] }}</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td class="text-left">Obat Non Generik Formularium</td>
                  <td class="text-left">{{ $data['stok_obat_generik_formularium'] }}</td>
                  <td class="text-left">{{ $data['stok_obat_generik_formularium'] }}</td>
                  <td class="text-left">{{ $data['obat_seluruh_formularium_obat'] }}</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td class="text-left">Obat Non Generik Non Formularium</td>
                  <td class="text-left">{{ $data['stok_obat_generik_non_formularium'] }}</td>
                  <td class="text-left">{{ $data['stok_obat_generik_non_formularium'] }}</td>
                  <td class="text-left">{{ $data['obat_seluruh_formularium_obat'] }}</td>
                </tr>
                <tr>
                  <th>#</th>
                  <th class="text-left">Total</th>
                  <th class="text-left">{{ $data['obat_seluruh_obat'] + $data['stok_obat_generik_formularium'] + $data['stok_obat_generik_non_formularium'] }}</th>
                  <th class="text-left">{{ $data['obat_seluruh_obat'] + $data['stok_obat_generik_formularium'] + $data['stok_obat_generik_non_formularium'] }}</th>
                  <th class="text-left">{{ $data['obat_seluruh_formularium_obat'] + $data['obat_seluruh_formularium_obat'] + $data['obat_seluruh_formularium_obat'] }}</th>
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