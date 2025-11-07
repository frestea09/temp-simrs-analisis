@extends('master')
@section('header')
<h1>Laporan Imodialisasi</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
{!! Form::open(['method' => 'POST', 'id' => 'formFilter', 'class'=>'form-horizontal']) !!}
{!! csrf_field() !!}
<div class="row">
    <div class="col-md-3">
        <br />
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Tahun</button>
            </span>
            {!! Form::selectRange('tahun', 2000, now()->year, $tahun, ['class' => 'form-control select2', 'placeholder' => 'Pilih Tahun']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <br />
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default" id="" type="button">Kategori Diagnosa</button>
            </span>
            {!! Form::select('kategori', [
                'penyakit_jantung' => 'Penyakit Jantung',
                'stroke' => 'Stroke',
                'hipertensi' => 'Hipertensi',
                'diabetes' => 'Diabetes',
                'kanker' => 'Kanker',
                'tuberkulosis' => 'Tuberkulosis',
                'hiv' => 'HIV',
            ], null, ['class' => 'form-control select2', 'id' => 'kategori', 'placeholder' => 'Pilih Kategori']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <br />
        <input type="button" id="viewButton" class="btn btn-primary btn-flat" value="TAMPILKAN">
        <input type="button" id="excelButton" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
    </div>
</div>
{!! Form::close() !!}

    <hr>
    {{-- ================================================================================================== --}}
    <div class="table-responsive">
  <table id="dataTable" class="table table-striped table-bordered table-hover table-condensed">
    <thead>
        <tr>
            <th rowspan="3" class="text-center">No</th>
            <th rowspan="3" class="text-center">Kode ICD 10</th>
            <th rowspan="3" class="text-center">Golongan Sebab Penyakit</th>
            <th colspan="48" class="text-center">JUMLAH PASIEN</th>
        </tr>
        <tr>
            @foreach(range(1, 12) as $bulan)
                <th colspan="4" class="text-center">{{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach(range(1, 12) as $bulan)
                <th class="text-center">Rawat Inap</th>
                <th class="text-center">IGD</th>
                <th class="text-center">Rawat Jalan</th>
                <th class="text-center">Total</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse($irj as $key => $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data['kode_icd10'] }}</td>
                <td>{{ $data['golongan_penyakit'] }}</td>
                @foreach(range(1, 12) as $bulan)
                    <td class="text-center">{{ $data['data_bulan'][$bulan]['rawat_inap'] }}</td>
                    <td class="text-center">{{ $data['data_bulan'][$bulan]['igd'] }}</td>
                    <td class="text-center">{{ $data['data_bulan'][$bulan]['rawat_jalan'] }}</td>
                    <td class="text-center">{{ $data['data_bulan'][$bulan]['total'] }}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="49" class="text-center">Data tidak tersedia.</td>
            </tr>
        @endforelse
    </tbody>
</table>

        
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $('#viewButton').on('click', function () {
      $('#formFilter').attr('method', 'POST');
      $('#formFilter').attr('action', '{{ route('filter.filterKeKhususan') }}'); // Menggunakan route name
      $('#formFilter').submit();
  });

  $('#excelButton').on('click', function () {
      $('#formFilter').attr('method', 'GET');
      $('#formFilter').attr('action', '{{ route('filter.filterKeKhususan') }}'); // Menggunakan route name
    
    // Tambahkan input tersembunyi untuk parameter excel
    $('<input>').attr({
        type: 'hidden',
        name: 'excel',
        value: 'true' // Atur nilai sesuai kebutuhan
    }).appendTo('#formFilter');

      $('#formFilter').submit();
  });

  $('.select2').select2();

  $(document).ready(function() {
    $('#dataTable').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      lengthChange: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json"
      },
      lengthMenu: [5, 10, 25, 50, 100],
      pageLength: 5, // Jumlah baris per halaman
    });
  });
</script>
@endsection
