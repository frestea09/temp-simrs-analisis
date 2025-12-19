@extends('master')
@section('header')
  <h1>Registrasi Pasien Langsung</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Hasil Pencarian Pasien
      </h3>
    </div>
    <div class="box-body">
      @if (isset($data))
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>RM</th>
                {{-- <th>Ibu Kandung</th> --}}
                <th>Alamat</th>
                <th>-</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $d)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $d->nama }}</td>
                      <td>{{ $d->no_rm }}</td>
                      {{-- <td>{{ $d->no_rm_lama }}</td> --}}
                      {{-- <td>{{ $d->ibu_kandung }}</td> --}}
                      <td>{{ $d->alamat }}</td>
                      <td>
                        {!! Form::open(['method' => 'POST', 'url' => 'radiologi/saveRadiologiLangsung/'.$d->id, 'class' => 'form-search']) !!}
                        
                        <div class="input-group input-group-md {{ $errors->has('keyword') ? ' has-error' : '' }}">
                            <input type="text" name="pemeriksaan" id="pemeriksaan" class="typeahead form-control" placeholder="Pemeriksaan">
                            <small class="text-danger">{{ $errors->first('keyword') }}</small>
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-arrow-right"></i> Lanjut</button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                      </td>
                    </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
      @endif

    </div>
  </div>
@endsection
