@extends('master')
@section('header')
  <h1>Rawat Inap - Demografi Pasien<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        {!! Form::open(['method' => 'POST', 'url' => 'rawatinap/demografi-pasien-by', 'class'=>'form-horizontal']) !!}
          <div class="col-md-4">

            <div class="form-group" style="padding-left:20px">
              {{-- <button name="submit" value="tampil" type="submit" class="btn btn-primary">TAMPILKAN</button> --}}
              <button name="submit" value="excel" type="submit" class="btn btn-success">EXCEL</button>
              {{-- <button name="submit" value="pdf" type="submit" class="btn btn-danger">PDF</button> --}}
            </div>
          </div>
          <div class="col-md-4">
          </div>
          <div class="col-md-4">
          </div>
        {!! Form::close() !!}
      </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="sensus">
            <thead>
              <tr>
                <th class="text-center" width="15px">No</th>
                <th class="text-center">Wilayah</th>
                <th class="text-center">Jumlah Pasien</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pasien as $p)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $p['name'] }}</td>
                  <td>{{ $p['jmlpasien'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endsection
{{-- @section('script')
    <script>
      $('#sensus').DataTable();
    </script>
@endsection --}}