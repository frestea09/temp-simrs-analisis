@extends('master')

@section('header')
  <h1><small>Logistik Medik</small> PERMINTAAN</h1>
  <a href="{{ url('logistikmedik/permintaan/create') }}" class="btn btn-success"> <i class="fa fa-icon fa-plus"></i>BUAT PERMINTAAN</a>
@endsection
@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h4><b>Periode Tanggal :</b></h4>
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/permintaan-filter', 'class'=>'form-horizontal']) !!}
    <input type="hidden" name="jenis_reg" value="I3">
    <div class="row mt-5">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
          </div>
        </div> 
    </div>
    {!! Form::close() !!}
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>No</th>
              <th>Nomor</th>
              <th>Gudang Asal</th>
              <th>Gudang Tujuan</th>
              <th>Tanggal</th>
              <th>Cetak</th>
              <th>Edit</th>
              <th>Hapus</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $item)
              @php
                  $d = \App\Logistik\LogistikPermintaan::where('gudang_asal', Auth::user()->gudang_id)->where('nomor', $item->nomor)->first();
              @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nomor }}</td>
                <td>{{ \App\Logistik\LogistikGudang::find($d->gudang_asal)->nama }}</td>
                <td>{{ \App\Logistik\LogistikGudang::find($d->gudang_tujuan)->nama }}</td>
                <td>{{ tgl_indo($d->tanggal_permintaan) }}</td>
                {{--  <td><button type="button" class="btn btn-primary btn-sm btn-flat" ><i class="fa fa-folder-o"></i></button></td>  --}}
                <td><a href="{{ url('logistikmedik/cetak-permintaan/'.$d->nomor) }}" target="_blank" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-print"></i></a></td>
                {{-- @if ($d->terkirim) --}}
                  <td>
                    <a href="{{ url('logistikmedik/permintaan-edit/'.$d->nomor) }}" target="_blank" class="btn btn-info btn-flat btn-sm"><i class="fa fa-pencil"></i></a>
                  </td>
                  <td><a href="{{ url('logistikmedik/permintaan-hapus/'.$d->nomor) }}" onclick="return confirm('Yakin transaksi ini akan dihapus ?')" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-remove"></i></a></td>
                {{-- @else
                  <td>
                    <button class="btn btn-default btn-sm btn-flat" disabled><i class="fa fa-pencil"></i></button>
                  </td>
                  <td>
                    <button class="btn btn-default btn-sm btn-flat" disabled><i class="fa fa-trash"></i></button>
                  </td>
                @endif --}}
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()

  $('table').DataTable();

</script>
@endsection
