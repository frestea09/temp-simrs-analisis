@extends('master')

@section('header')
  <h1>Laporan Farmasi Rawat Jalan &amp; Rawat Darurat</h1>
@endsection

@section('content')
  @php
    function cekStatusTagihan($no_faktur)
    {
      return \Modules\Registrasi\Entities\Folio::where('namatarif', $no_faktur)->count();
    }
  @endphp
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Periode Tanggal: &nbsp;
      </h4>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'farmasi/laporan/penjualan', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      @if($penjualan && !empty($penjualan))
        @foreach ($penjualan as $key => $d)
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                @php
                  $reg = \Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
                  $pb = \App\Penjualanbebas::where('registrasi_id', $d->registrasi_id)->first();
                @endphp
                Nama: {{ !empty($reg->pasien_id) ? $reg->pasien->nama : '' }} {{ !empty($pb->nama) ? $pb->nama : '' }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                No. RM: {{ !empty($reg->pasien_id) ? $reg->pasien->no_rm : '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No. Faktur: {{ $d->no_resep }}
                <div class="pull-right">
                  @if ( cekStatusTagihan($d->no_resep) >= 1 )
                    @if (!empty($pb->nama))
                      <a href="{{ url('farmasi/laporan/etiketbebas/'.$d->id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-print"></i> </a>
                    @else
                        <a href="{{ url('/farmasi/cetak-detail/'.$d->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i></a>
                      <a href="{{ url('farmasi/laporan/etiket/'.$d->id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-print"></i> </a>
                    @endif
                  @else
                    @if ($d->created_at < Carbon\Carbon::today())
                      <a href="{{ url('farmasi/laporan/hapus/'.$d->no_resep) }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-trash-o"></i> </a>
                    @endif
                  @endif
                </div>
              </h3>
            </div>
            <div class="panel-body">
              @php
                $det = App\Penjualandetail::where('penjualan_id', $d->id)->get();
                $total = $det->sum('hargajual');
                $no = 1;
              @endphp
              {{-- =============================================================================== --}}
              <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Obat</th>
                      <th class="text-center">Harga</th>
                      <th>Etiket</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($det as $key => $d)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->masterobat->nama }}</td>
                        <td class="text-right">
                          @if ($d->masterobat->hargajual == 0)

                          @else
                            {{ number_format($d->masterobat->hargajual) }}
                          @endif
                        </td>
                        <td>{{ $d->etiket }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4">
                        status
                        @if ( cekStatusTagihan($d->no_resep) >= 1 )
                          <a href="#" class="btn btn-success btn-sm btn-flat"> TERTAGIH </a>
                        @else
                          <a href="#" class="btn btn-warning btn-sm btn-flat"> BLM TERTAGIH </a>
                        @endif
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>

            </div>
          </div>
        @endforeach

      @endif

    </div>
  </div>
@endsection
