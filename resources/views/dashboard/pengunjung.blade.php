@extends('dashboard.template')
@section('header')
		<h1 style="font-size: 16pt;"> Dashboard Pelayanan {{ config('app.nama') }} Tanggal {{ tanggalkuitansi(date('d-m-Y')) }}</h1>
@endsection
@section('content')

  <div class="row">
    <div class="col-md-12">
      {!! Form::open(['method' => 'POST', 'url' => 'pengunjung', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker text-center', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-1 text-center">s/d</div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker text-center', 'required' => 'required']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
        </div>
      </div>
      {!! Form::close() !!}
      <p class="small text-info">Data di bawah adalah data terbaru bulan ini. Jika ingin mengganti tanggal silakan ganti tanggal di form di atas!</p>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Pengunjung  &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-hover table-bordered dashboardPengunjung">
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th>Klinik</th>
                      <th class="text-center">Total</th>
                      <th class="text-center">JKN</th>
                      <th class="text-center">NON JKN</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($per_poli as $d)
                      @php
                        $jkn = DB::table('histori_pengunjung')
                                ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
                                ->where('registrasis.poli_id', $d->poli_id)
                                ->where('bayar', 1)
                                ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
                                ->count();
                        $non_jkn = DB::table('histori_pengunjung')
                                ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
                                ->where('registrasis.poli_id', $d->poli_id)
                                ->where('bayar', '<>', 1)
                                ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
                                ->count();
                      @endphp
                      <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ baca_poli($d->poli_id) }}</td>
                        <td class="text-center">{{ $d->total }}</td>
                        <td class="text-center">{{ $jkn }}</td>
                        <td class="text-center">{{ $non_jkn }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-hover table-bordered dashboardPengunjung">
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th>Jenis Layanan</th>
                      <th class="text-center">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($per_layanan as $d)
                      <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td>
                          @if ($d->politipe == 'J')
                            Rawat Jalan
                          @elseif ($d->politipe == 'G')
                            Rawat Darurat
                          @elseif ($d->politipe == 'I')
                            Rawat Inap
                          @endif
                        </td>
                        <td class="text-center">{{ $d->total }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    $(function () {

    $('.dashboardPengunjung').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false
    });
  });
  </script>
@endsection