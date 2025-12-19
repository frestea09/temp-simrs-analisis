@extends('master')
@section('header')
  <h1>Kasir - Verifikasi Rawat Inap<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form method="POST" action="{{ url('kasir/verifikasi') }}" class="form-horizontal" role="form">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="form-group">
          <label for="no_rm" class="col-md-3 control-label">Nomor RM</label>
          <div class="col-lg-3">
            <input type="text" name="no_rm" class="form-control" required="true" maxlength="8">
          </div>
        </div>
      </form>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="dataVerif">
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle;">NO.</th>
              <th class="text-center" style="vertical-align: middle;">NOMOR RM</th>
              <th class="text-center" style="vertical-align: middle;">NAMA</th>
              <th class="text-center" style="vertical-align: middle;">BAYAR</th>
              {{-- <th class="text-center" style="vertical-align: middle;">KELOMPOK</th> --}}
              <th class="text-center" style="vertical-align: middle;">KELAS</th>
              <th class="text-center" style="vertical-align: middle;">KAMAR</th>
              {{-- <th class="text-center" style="vertical-align: middle;">BED</th> --}}
              <th class="text-center" style="vertical-align: middle;">TGL MASUK</th>
              <th class="text-center" style="vertical-align: middle;">TGL KELUAR</th>
              <th class="text-center" style="vertical-align: middle;">VERIFIKASI</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($verif))
              @foreach ($verif as $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->pasien->nama}}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  {{-- <td>{{ baca_kelompok($d->kelompokkelas_id) }}</td> --}}
                  <td>{{ baca_kelas($d->kelas_id) }}</td>
                  <td>{{ baca_kamar($d->kamar_id) }}</td>
                  {{-- <td>{{ baca_bed($d->bed_id) }}</td> --}}
                  <td>{{ tanggal($d->tgl_masuk) }}</td>
                  <td>{{ tanggal($d->tgl_keluar) }}</td>
                  <td>
                    <a href="{{ url('kasir/detail-verifikasi/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check"></i></a>
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('verif_kasa', 'Y')->sum('total') > 0)
                      <a href="{{ url('kasir/cetak-verifikasi/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection

@section('script')
  
  <script>
//     $(function() {
//     $('#dataVerif').DataTable({
//         "language": {
//             "url": "/json/pasien.datatable-language.json",
//         },
//         pageLength: 10,
//         autoWidth: false,
//         processing: true,
//         serverSide: true,
//         ordering: false,
//         ajax: '/kasir/verifikasi-get-data',
//         columns: [
//             {data: 'no_rm'},
//             {data: 'nama'},
//             {data: 'carabayar'},
//             {data: 'kelompok'},
//             {data: 'kelas'},
//             {data: 'kamar'},
//             {data: 'bed'},
//             {data: 'tgl_masuk'},
//             {data: 'tgl_keluar'},
//             {data: 'verifikasi', orderable: false, searchable: false},
//         ]
//     });
// });

  </script>
@endsection
