@extends('master')
@section('header')
  <h1>Biaya Pemeriksaan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Biaya Pemeriksaan &nbsp;
        {{-- <a href="{{ url('biayapemeriksaan/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a> --}}
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Total Tarif</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($biayapemeriksaan as $key=>$e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ baca_tipe_reg($e->tipe) }}</td>
                <td>{{ $e->tarif_id }}</td>
                <td>
                  
                    <a href="{{ url('biayapemeriksaan/'.$e->tipe.'/edit') }}"><i class="fa fa-edit"></i></a>
                      
                  
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
@endsection
