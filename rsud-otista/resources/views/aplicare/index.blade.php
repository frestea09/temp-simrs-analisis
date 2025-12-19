@extends('master')
@section('header')
  <h1>Data Kamar</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data Kamar Aplicares &nbsp;
        {{-- <a href="{{ url('tahuntarif/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a> --}}
      </h3>
    </div>
    <div class="box-body">
      <div class="col-sm-6">
        <a href="{{ url('aplicare-bpjs/create') }}" target="_blank" class="btn btn-md btn-info">
          <span class="fa fa-plus"></span> Tambah Kamar Aplicares
        </a>
      </div>

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              {{-- <tr>
                <th>No</th>
                <th>ID</th>
                <th>Kelas</th>
                <th>Kamar</th>
                <th>Jumlah BED</th>
                <th>Update</th>
              </tr> --}}
              <tr>
                <th>No</th>
                <th>Nama Kamar</th>
                <th>Kode Kamar</th>
                <th>Nama Kelas</th>
                <th>Kode Kelas</th>
                <th>Kapasitas</th>
                <th>Tersedia</th>
                <th>Update Terakhir</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>
              {{-- @foreach ($kamar as $e)
              <tr>
                <td>{{ @$no++ }}</td>
                <td>{{ @$e->id }}</td>
                <td>{{ @kode_kelas($e->kelas_id) }}</td>
                <td>{{ @$e->nama }}</td>
                <td> 
                  @if(@\Modules\Bed\Entities\Bed::where('kamar_id',$e->id)->first())
                    {{ @\Modules\Bed\Entities\Bed::where('kamar_id',$e->id)->count() }}
                  @else
                  -
                  @endif
                </td>

                <td><a href="{{ url('aplicare-bpjs/update/'.@$e->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a></td>
              </tr>
            @endforeach --}}
              @foreach ($data as $e)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $e['namaruang'] }}</td>
                  <td class="text-center">{{ $e['koderuang'] }}</td>
                  <td>{{ $e['namakelas'] }}</td>
                  <td class="text-center">{{ $e['kodekelas'] }}</td>
                  <td class="text-center">{{ $e['kapasitas'] }}</td>
                  <td class="text-center">{{ $e['tersedia'] }}</td>
                  <td>{{ $e['lastupdate'] }}</td>
                  <td><a href="{{ url('aplicare-bpjs/delete-bed/'.$e['kodekelas'].'/'.$e['koderuang']) }}" onclick="return confirm('Apakah Yakin Ingin Dihapus ?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
