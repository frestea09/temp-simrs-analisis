@extends('master')
@section('header')
  <h1>Detail Hasil Bridging</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <h4>Data Pasien</h4>
            <div class="table-responsive">
              <table class="table table-condensed table-bordered table-hover">
                <tbody>
                  <tr>
                    <th>Nama Pasien</th><td>{{ strtoupper($registrasi->pasien->nama) }}</td> <th>Tanggal Registrasi</th><td>{{ strtoupper($registrasi->created_at) }}</td>
                  </tr>
                  <tr>
                    <th>Nomor RM Baru</th><td>{{ no_rm($registrasi->pasien->no_rm) }}</td> <th>Klinik Tujuan</th><td>{{ strtoupper(baca_poli($registrasi->poli_id)) }}</td>
                  </tr>
                  <tr>
                    <th>Nomor RM Lama</th><td>{{ no_rm($registrasi->pasien->no_rm_lama) }}</td> <th>DPJP</th><td>{{ strtoupper(baca_dokter($registrasi->dokter_id)) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <h4>Hasil Bridging E-Klaim</h4>
        <div class="table-responsive">
          <table class="table table-condensed table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">Nomor Kartu</th>
                <th class="text-center">Nomor SEP</th>
                <th class="text-center">Biaya Perawatan</th>
                <th class="text-center">Dijamin</th>
                <th class="text-center">Kode Grouper</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Cetak</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">{{ $inacbg->no_kartu }}</td>
                <td class="text-center">{{ $inacbg->no_sep }}</td>
                <td class="text-center">{{ number_format($inacbg->total_rs) }}</td>
                <td class="text-center">{{ number_format($inacbg->dijamin) }}</td>
                <td class="text-center">{{ $inacbg->kode }}</td>
                <td class="text-center">{{ $inacbg->deskripsi_grouper }}</td>
                <td class="text-center">
                  {{-- <div class="btn-group"> --}}
                    <a href="{{ url('/eklaim-rincian-biaya-perawatan/'.$registrasi->id) }}" target="_blank" class="btn btn-primary btn-flat"><i class="fa fa-print"></i></a>
                    <a href="{{ url('/cetak-e-claim/'.$inacbg->no_sep) }}" target="_blank" class="btn btn-success btn-flat"><i class="fa fa-print"></i></a>
                    <a href="{{ url('/eklaim-detail-rincian-biaya-eklaim/'.$registrasi->id) }}" target="_blank" class="btn btn-danger btn-flat"><i class="fa fa-print"></i></a>
                  {{-- </div> --}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <br>
        <a href="" class="btn btn-primary btn-flat"><i class="fa fa-print"></i></a> CETAK RINCIAN BIAYA PERAWATAN <br>
        <a href="" class="btn btn-success btn-flat"><i class="fa fa-print"></i></a> CETAK RINCIAN HASIL KLAIM <br>
        <a href="" class="btn btn-danger btn-flat"><i class="fa fa-print"></i></a> CETAK RINCIAN BIAYA EKLAIM

    </div>
    <div class="box-footer">
      <div class="pull-right">
        @if ( substr($registrasi->status_reg, 0, 1) == 'J' || substr($registrasi->status_reg, 0, 1) == 'G')
          <a href="{{ url('frontoffice/e-claim/dataRawatJalan') }}" class="btn btn-default btn-flat">KEMBALI</a>
        @else
          <a href="{{ url('frontoffice/e-claim/dataRawatInap') }}" class="btn btn-default btn-flat">KEMBALI</a>
        @endif

      </div>
    </div>
  </div>
@endsection
