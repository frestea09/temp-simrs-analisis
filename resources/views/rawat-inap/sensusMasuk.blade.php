@extends('master')
@section('header')
  <h1>Rawat Inap - Sensus Masuk<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Periode Tanggal</h3>
    </div>
    <div class="box-body">
      <div class="row">
        {!! Form::open(['method' => 'POST', 'url' => 'rawatinap/sensus-masuk', 'class'=>'form-horizontal']) !!}
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
              {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <button name="submit" value="tampil" type="submit" class="btn btn-primary">TAMPILKAN</button>
              <button name="submit" value="excel" type="submit" class="btn btn-success">EXCEL</button>
              <button name="submit" value="pdf" type="submit" class="btn btn-danger">PDF</button>
            </div>
          </div>
        {!! Form::close() !!}
      </div>
      <hr>
        <div class="table-responsive">
          <table class="table table-bordered" id="sensus">
            <thead>
              <tr>
                <th class="text-center" width="15px">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">No RM</th>
                <th class="text-center">Umur</th>
                <th class="text-center">Asal Masuk</th>
                <th class="text-center">Kelas</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Jaminan</th>
                <th class="text-center">Diagnosa</th>
                <th class="text-center">Dokter</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pasien as $p)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $p->nama }}</td>
                  <td>{{ $p->no_rm }}</td>
                  <td>{{ hitung_umur($p->tgllahir) }}</td>
                  <td>{{ baca_kamar($p->kamar_id) }}</td>
                  <td>{{ baca_kelas($p->kelas_id) }}</td>
                  <td>{{ date('d M Y H:i:s', strtotime($p->tgl_masuk)) }}</td>
                  <td>{{ baca_carabayar($p->bayar) }}</td>
                  <td>{{ $p->icd10 }}</td>
                  <td>{{ ($p->dokter_id != '') ? baca_dokter($p->dokter_id) : '' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endsection
@section('script')
    <script>
      $('#sensus').DataTable();
    </script>
@endsection