@extends('master')

@section('header')
  <h1>Jadwal Dokter</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Jadwal Dokter &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'jadwal-dokter.store', 'class' => 'form-horizontal']) !!}

            @include('jadwaldokter._form')

        {!! Form::close() !!}

        <hr>
        @if (!empty($jadwal))
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Poli</th>
                  <th>Dokter</th>
                  <th>Hari</th>
                  <th>Jam Praktek</th>
                  <th>Hapus</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($jadwal as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->poli }}</td>
                    <td>{{ $d->dokter }}</td>
                    <td>{{ $d->hari }}</td>
                    <td>{{ $d->jam_mulai }} s/d {{ $d->jam_berakhir }} WIB</td>
                    <td>
                      <a href="{{ url('hapus-jadwal/'.$d->id) }}" onclick="return confirm('Yakin jadwal ini akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        @endif


      </div>
    </div>

    <div class="modal fade" id="poliJadwal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Daftar Poli</h4>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Poli</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1;
                  @endphp
                  @foreach (\Modules\Poli\Entities\Poli::select('nama')->get() as $key => $d)
                    <tr class='addPoli' data-poli="{{ $d->nama }}">
                      <td>{{ $no++ }}</td>
                      <td>{{ $d->nama }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-default bt" data-dismiss="modal">Close</button>
          </div> --}}
        </div>
      </div>
    </div>


    <div class="modal fade" id="dokterJadwal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="">Data Dokter</h5>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1;
                  @endphp
                  @foreach (\Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->select('nama')->get() as $key => $d)
                    <tr class="addDokter" data-dokter="{{ $d->nama }}">
                      <td>{{ $no++ }}</td>
                      <td>{{ $d->nama }}</td>
                    </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@stop
