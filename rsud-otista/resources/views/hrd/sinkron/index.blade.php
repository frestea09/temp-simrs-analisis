@extends('master')
@section('header')
  <h1> Data Pegawai Yang Belum Sinkron</h1>
@endsection
@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <form id="formSinkron" method="POST" action="{{ url('pegawai/biodata/sinkron') }}">
          {{ csrf_field() }}
        <button type="button" class="btn btn-primary" id="btn-sinkron">Sinkron</button>
        </form>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>TTL</th>
                <th>Kelamin</th>
                <th>Agama</th>
                <th>Alamat</th>
                <th>SIP</th>
                <th>STR</th>
                <th>Kompetensi</th>
                <th>Tupoksi</th>
                <th>Pendidikan</th>
                <th>Ubah</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pegawai as $key => $d)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->tmplahir }}, {{ $d->tgllahir }}</td>
                  <td>{{ $d->kelamin }}</td>
                  <td>{{ $d->agama }}</td>
                  <td>{{ $d->alamat }}</td>
                  <td>{{ $d->sip }}</td>
                  <td>{{ $d->str }}</td>
                  <td>{{ $d->kompetensi }}</td>
                  <td>{{ $d->tupoksi }}</td>
                  <td>{{ isset($d->pendidikan->pendidikan) ? $d->pendidikan->pendidikan  : '-' }}</td>
                  <td>
                    <a href="{{ route('pegawai.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
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
  $(document).on('click','#btn-sinkron',function(){
    if( confirm("Pegawai Akan Disinkronkan?") ){
      $('#formSinkron').submit();
    }else{
      alert('Proses Dibatalkan')
    }
  })
</script>
@endsection