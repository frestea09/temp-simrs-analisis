@extends('master')
@section('header')
  <h1>Kasir - Verifikasi <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>NOMOR RM</th>
              <th>NAMA</th>
              <th>CARA BAYAR</th>
              <th>KELOMPOK</th>
              <th>KELAS</th>
              <th>KAMAR</th>
              <th>BED</th>
              <th>TGL MASUK</th>
              <th>TGL KELUAR</th>
              <th>VERIFIKASI</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($registrasi as $key => $d)
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $d->pasien->no_rm }}</td>
                <td>{{ strtoupper($d->pasien->nama) }}</td>
                <td>{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                <td>{{ strtoupper(baca_kelompok($d->kelompokkelas_id)) }}</td>
                <td>{{ strtoupper(baca_kelas($d->kelas_id)) }}</td>
                <td>{{ strtoupper(baca_kamar($d->kamar_id)) }}</td>
                <td>{{ strtoupper(baca_bed($d->bed_id)) }}</td>
                <td>{{ $d->tgl_masuk }}</td>
                <td>{{ $d->tgl_keluar }}</td>
                <td>
                  <a href="{{ url('kasir/detail-verifikasi/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check"></i></a>
                  @if ( Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('verif_kasa', 'Y')->sum('total') > 0)
                    <a href="{{ url('kasir/cetak-verifikasi/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                  @endif
                </td>
                
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
