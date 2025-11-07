@extends('master')
@section('header')
  <h1>Penjualan Bebas</h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualanbebas']) !!}
        {!! Form::hidden('pasien_id', 'P-01') !!}
        {!! Form::hidden('idreg', null) !!}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <tbody>
              <tr>
                <th style="width: 30%">Nama Pasienaa</th>
                <td class="{{ $errors->has('nama') ? ' has-error' : '' }}">
                    {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('nama') }}</small>
                </td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td class="{{ $errors->has('alamat') ? ' has-error' : '' }}">
                  <input type="text" name="alamat" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('alamat') }}</small>
                </td>
              </tr>
              <tr>
                <th>Dokter</th>
                <td>
                  <input type="text" name="dokter" value="" class="form-control">
                </td>
              </tr>
              <tr>
                <th>
                  Pembuat Resep
                </th>
                <td>
                  @if (! session('idpenjualan'))
                    <div class="form-group{{ $errors->has('pembuat_resep') ? ' has-error' : '' }} col-md-6">
                        {!! Form::select('pembuat_resep', $apoteker, null, ['class' => 'form-control select2']) !!}
                        <small class="text-danger">{{ $errors->first('pembuat_resep') }}</small>

                    </div>
                      <div class="col-md-6">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin Apoteker sdh benar?")']) !!}
                      </div>
                  @else
                    <b class="text-primary">{{ baca_apoteker($penjualan->pembuat_resep) }}</b>
                  @endif
                </td>
              </tr>
              @if (session('idpenjualan'))
                <tr>
                  <td>No. Faktur</td>
                  <td>{{ $penjualan->no_resep }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
{!! Form::close() !!}
<hr>
{!! Form::open(['method' => 'POST', 'url' => 'penjualanbebas', 'class'=>'form-hosizontal']) !!}
  <div class="row">
    <div class="col-md-6">
      <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
        <span class="input-group-btn">
        <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
        </span>
        {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()','autocomplete'=>'off']) !!}
      </div>
    </div>
  </div>
{!! Form::close() !!}
        <hr>
        <h4>Penjualan Sebelumnya</h4>
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Dokter</th>
                <th>Faktur</th>
                <th>Edit</th>
                {{-- <th>Hapus</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($today as $d)
                  @php
                    $penjualan_id = App\Penjualan::where('registrasi_id', $d->registrasi_id)->first()->id;
                    $reg =  \Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien_id;
                  @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->alamat }}</td>
                  <td>{{ $d->dokter }}</td>
                  <td>
                    <a href="{{ url('farmasi/cetak-detail-bebas/'.$penjualan_id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print"></i></a>
                  </td>
                  <td>
                    <a href="{{ url('penjualan/edit-penjualan-bebas/'.$d->registrasi_id.'/'.$penjualan_id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-pencil"></i></a>
                  </td>
                  {{-- <td>
                    @if ($d->lunas == 'N')
                      <a href="{{ url('hapus-penjualanbebas/'.$d->registrasi_id) }}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-remove"></i></a>
                    @endif
                  </td> --}}
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
    $('.select2').select2();
  </script>
@endsection