@extends('master')
@section('header')
  <h1>Data Piutang</h1>

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
       {{--  Periode Tanggal &nbsp; --}}
      </h4>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-10">

          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pasien</th>
                  <th>No. RM</th>
                  <th>Pelayanan</th>
                  <th>Cara Bayar</th>
                  <th>Total Tagihan</th>
                  <th>Bayar</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($piutang as $key => $d)
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->no_rm }}</td>
                    <td>
                      @if (substr($d->status_reg,0,1) == 'I')
                        Rawat Inap
                      @elseif(substr($d->status_reg,0,1) == 'J')
                        Rawat Jalan
                      @else
                        Rawat Darurat
                      @endif
                    </td>
                    <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                    <td class="text-right">{{ number_format(total_tagihan($d->id)) }}</td>
                    <td>
                      @if (total_tagihan($d->id) > 0)
                        @if (substr($d->status_reg,0,1) == 'I')
                          <a href="{{ url('kasir/rawatinap/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                        @else
                          <a href="{{ url('kasir/rawatjalan/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                        @endif
                      @else
                        <i class="fa fa-check text-success"></i> <span class="text-success"> LUNAS </span>
                      @endif
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
