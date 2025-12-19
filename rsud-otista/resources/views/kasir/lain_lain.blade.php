@extends('master')
@section('header')
  <h1>Transaksi Lain Lain <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4></h4>
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'kasir/lain-lain', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table id="data" class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No RM</th>
              <th>Alamat</th>
              <th>Waktu</th>
              <th>Admin</th>
              <th>Bayar</th>
              <th>Kuitansi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
              @php
                $bayar = App\Pembayaran::where('registrasi_id', $d['registrasi_id'])->first();

              @endphp
              <tr>
                <td>{{ $d['no'] }}</td>
                <td>{{ $d['nama'] }}</td>
                <td>{{ $d['no_rm'] }}</td>
                <td>{{ $d['alamat'] }} </td>
                <td>{{ $d['created_at'] }} </td>
                <td>{{ baca_user($d['user_create']) }} </td>
                <td>
                @if (cekFolio($d['registrasi_id']))
                  @if (!$bayar)
                    <a href="{{ url('kasir/lain-lain/bayar/'.$d['registrasi_id']) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-dollar"></i></a>
                  @endif
                @else
                  Tidak Ada Tagihan
                @endif
                </td>
                <td>
                  @if ($bayar)
                    <a href="{{ url('kasir/cetakkuitansibebas/'.$bayar->id) }}" title="Cetak Kuitansi" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-print"></i></a>
                  @endif
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
