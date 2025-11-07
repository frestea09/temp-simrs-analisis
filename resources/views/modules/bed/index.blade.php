@extends('master')

@section('header')
  <h1>Master Bed Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Bed &nbsp;
          <a href="{{ route('bed.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
          <a href="{{ route('bed') }}" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
        </h3>
      </div>
      <div class="box-body">
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Kelompok</th>
              <th>Kelas</th>
              <th>Kamar</th>
              {{-- <th>Kamar Bed</th>
              <th>ID Bed Satu Sehat</th> --}}
              <th>Status</th>
              {{-- @role('administrator') --}}
                <th>Edit</th>
              {{-- @endrole --}}
              <th>Nonaktifkan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($bed as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ @$d->nama }}
                    @if ($d->reserved == 'N')
                    <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="">Kosong</span>
                    @else
                    <span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="">Terisi</span>
                    @endif
                </td>
                <td>{{ @App\Kelompokkelas::find($d->kelompokkelas_id)->kelompok }}</td>
                <td>{{ @Modules\Kelas\Entities\Kelas::find($d->kelas_id)->nama }}</td>
                <td>{{ @$d->kamar->nama }}</td>
                {{-- <td>{{ $d->nama_bed }}</td>
                <td>{{ $d->id_ss_bed }}</td> --}}
                <td>
                  @if ($d->reserved == 'N')
                    <a href="{{ asset('bed/kosongkanbatal/'.$d->id) }}" onclick="return confirm('Yakin batal kosongkan Bed {{ strtoupper(@$d->nama) }}?')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-check"></i> Isi </a>
                  @else
                    <a href="{{ url('bed/kosongkan/'.$d->id) }}" onclick="return confirm('Yakin Bed {{ strtoupper(@$d->nama) }} akan dikosongkan?')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-remove"></i> Kosongkan </a>
                  @endif

                  @if (Auth::user()->id == 1221 || Auth::user()->id == 789 || Auth::user()->id == 566)
                  @if ($d->reserved == 'Y')
                    <a href="{{ url('rawat-inap/lihat-pasien-bed/'.$d->id) }}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-user"></i> Lihat Pasien</a>
                  @endif
                  @endif
                </td>
                {{-- @role('administrator') --}}
                <td>
                  <a href="{{ route('bed.edit', $d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a>
                </td>
                <td>
                  <a onclick="return confirm('Yakin akan menghapus bed?')" href="{{ route('bed.destroy', $d->id) }}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i></a>
                </td>
              {{-- @endrole --}}
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
@stop
