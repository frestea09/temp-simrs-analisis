@extends('master')
@section('header')
    <h1>{{ baca_unit($unit) }} - Pemeriksaan Laboratorium <small></small></h1>
@endsection

@section('content')
    @include('emr.modules.addons.profile')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Data Pemeriksaan Laboratorium</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @include('emr.modules.addons.tabs')
                </div>
            </div>
            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id='tableHasillab'>
                    <thead>
                        <tr>
                            <th>No.Lab</th>
                            <th>Daftar Pemeriksaan</th>
                            <th>Waktu Pemeriksaan</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasillab as $p)
                            <tr>
                                <td>{{ $p->no_lab }}</td> 
                                <td>
                                    <button class="btn btn-xs btn-warning lihat-pemeriksaan"
                                        data-id="{{ $p->id }}">
                                        <i class="fa fa-eye"></i> Lihat pemeriksaan</button>
                                    <div id="details-{{ $p->id }}"></div> {{-- Tempat menampilkan data --}}
                                </td>
                                <td>{{ date('Y-m-d', strtotime($p->tgl_pemeriksaan)) }} {{ $p->jam }}</td>
                                <td>
                                    <a href="{{ url('cetak-lis-pdf/' . @$p->no_lab . '/' . @$registrasi_id) }}"
                                        target="_blank" class="btn btn-sm btn-danger btn-flat"> <i class="fa fa-print"></i>
                                        Lihat </a>
                                    {{-- <a href="{{ url('pemeriksaanlab/cetakAll/'.$p->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-print"></i> Lihat </a> --}}
                                    {{-- <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$registrasi_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Lihat </a> --}}
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
    $(document).ready(function () {
        $('.lihat-pemeriksaan').click(function () {
            let id = $(this).data('id');
            let detailsDiv = $('#details-' + id);

            // Tampilkan loader
            detailsDiv.html('<i class="fa fa-spinner fa-spin"></i> Memuat data...');

            // Ambil data dari server
            $.ajax({
                url: "{{ url('pemeriksaanlab/get-pemeriksaan-lab') }}/" + id,
                type: "GET",
                success: function (response) {
                    let html = '';

                    if (response.length > 0) {
                        html += '<ul style="padding: 15px;">';
                        response.forEach(folio => {
                            html += `<li>${folio.namatarif}</li>`;
                        });
                        html += '</ul>';
                    } 
                    // kalau tidak ada data, html tetap kosong (tidak menampilkan apa-apa)

                    // tampilkan hasil
                    detailsDiv.html(html);
                },
                error: function () {
                    detailsDiv.html('<span style="color: red;">Gagal memuat data.</span>');
                }
            });
        });
    });
    var datatable = $('#tableHasillab').DataTable({
        paging: true,
        ordering: false,
        pageLength: 20,
  });
</script>
@endsection