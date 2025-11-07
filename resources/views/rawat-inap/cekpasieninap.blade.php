@extends('master')
@section('header')
  <h1>Cek Pasien Rawat Inap <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{--  <h4>Periode Tanggal :</h4>  --}}
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle">No</th>
              <th class="text-center" style="vertical-align: middle">Status</th>
              <th class="text-center" style="vertical-align: middle">No. RM</th>
              <th class="text-center" style="vertical-align: middle">Nama</th>
              <th class="text-center" style="vertical-align: middle">Kelas</th>
              <th class="text-center" style="vertical-align: middle">Kamar</th>
              <th class="text-center" style="vertical-align: middle">Bed</th>
              <th class="text-center" style="vertical-align: middle">Rawatinap-ID</th>
              <th class="text-center" style="vertical-align: middle">Hitori-ID</th>
              <th class="text-center" style="vertical-align: middle">Cara Bayar</th>
              <th class="text-center" style="vertical-align: middle">Registrasi</th>
            
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
            @php
                $inap = App\Rawatinap::where('registrasi_id',$d->id)->first();
                $histori = App\HistoriRawatInap::where('registrasi_id',$d->id)->first();
            @endphp
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $d->status_reg }}</td>
                <td class="text-center">{{ baca_norm($d->pasien_id) }}</td>
                <td>{{ baca_pasien($d->pasien_id) }}</td>
                @if (!empty($inap))
                  <td class="text-center">{{ baca_kelas($inap->kelas_id) }}</td>
                  <td class="text-center">{{ baca_kamar($inap->kamar_id) }}</td>
                  <td class="text-center">{{ baca_bed($inap->bed_id) }}</td>
                  <td class="text-center">{{ $inap->id }}</td>
                @else
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                @endif
                 @if (!empty($histori))
                  <td class="text-center">{{ $histori->id }}</td>
                @else
                  <td></td>
                @endif

                <td class="text-center">{{ baca_carabayar($d->bayar) }} {{ !empty($reg->tipe_jkn) ? ' - '.$reg->tipe_jkn : '' }}</td>
                <td class="text-center">{{ $d->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection
