@extends('master')

@section('header')
  <h1>Front Office - Daftar Antrian Loket 1</h1>
@endsection

@section('content')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Data Antrian Hari Ini &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-5">
              <div id="daftarantrian"></div>
            </div>
            {{-- ============================ --}}
            <div class="col-md-7">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Sudah di panggil</h3>
                </div>
                <div class="panel-body">
                  <div class='table-responsive'>
                    <table class='table table-striped table-bordered table-hover table-condensed'>
                      <thead>
                        <tr>
                          <th class="text-center">Antrian</th>
                          <th>Waktu Antri</th>
                          <th>Panggil Ulang</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($terpanggil as $key => $d)
                          <tr>
                            <td class="text-center">{{ $d->nomor }}</td>
                            <td>{{ $d->created_at }}</td>
                            <td>
                              @if ($d->status <= 2)
                                <a href="{{ route('antrian.panggilkembali',$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
                              @endif
                              <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm btn-flat dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  JKN <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a href="{{ url('antrian/registrasi/'.$d->id.'/jkn') }}"><i class="fa fa-tags"></i> Pasien Baru</a></li>
                                  <li><a href="{{ url('antrian/reg_pasienlama/'.$d->id.'/jkn') }}"><i class="fa fa-registered"></i>Pasien Lama</a></li>
                                </ul>
                              </div>
                              <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm btn-flat dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  UMUM / IKS <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a href="{{ url('antrian/registrasi/'.$d->id.'/jkn') }}"><i class="fa fa-tags"></i> Pasien Baru</a></li>
                                  <li><a href="{{ url('antrian/reg_pasienlama/'.$d->id.'/jkn') }}"><i class="fa fa-registered"></i>Pasien Lama</a></li>
                                </ul>
                              </div>

                            </td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="panel-footer">

                </div>
              </div>
            </div>
          </div>



        </div>
      </div>


<!-- jQuery 3 -->
<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    setInterval(function () {
      $('#daftarantrian').load("{{ route('antrian.daftarpanggil') }}");
    },2000);
  });

</script>

@stop
