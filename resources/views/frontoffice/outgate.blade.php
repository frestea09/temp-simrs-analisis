@extends('master')
@section('header')
  <h1>Out Guide <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
          {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/outgate', 'class' => 'form-horizontal']) !!}

              <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'Masukkan No. RM', ['class' => 'col-md-4 control-label']) !!}
                  <div class="col-sm-6">
                      {!! Form::text('no_rm', null, ['class' => 'form-control', 'maxlength'=>8]) !!}
                      <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
              </div>
          {!! Form::close() !!}
    @isset($data)
      @if ($data->count() == 0)
        <h3>No.RM tidak ditemukan</h3>
      @else
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>No. RM Baru</th> <td>{{ $data->no_rm }}</td>
                </tr>
                <tr>
                  <th>No. RM Lama</th> <td>{{ $data->no_rm_lama }}</td>
                </tr>
                <tr>
                  <th>Nama Pasien</th> <td>{{ $data->nama }}</td>
                </tr>
                <tr>
                  <th>Poli Tujuan</th> <td>{{ baca_poli($data->poli_id) }}</td>
                </tr>
                <tr>
                  <th>Alamat</th> <td>{{ $data->alamat }}</td>
                </tr>
                <tr>
                  <th>Posisi Tracer</th> 
                  <td>
                    @php
                      $pa = \Modules\Registrasi\Entities\Registrasi::where('pasien_id', $data->id )->OrderBy('id')->first();
                    @endphp
                    @if ($pa->posisi_tracer == 0)
                        Belum diproses
                    @elseif ($pa->posisi_tracer == 1)
                        Berkas Keluar
                    @elseif ($pa->posisi_tracer == -1)
                        Berkas Dikembalikan
                    @elseif ($pa->posisi_tracer == 2)
                        Berkas kembali dari poli
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>


      @endif
    @endisset


    <div class="box-footer">
    </div>
  </div>

@endsection
