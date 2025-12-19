@extends('master')
@section('header')
<h1>Laporan DBD </h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => '/sirs/rl/filter-dbd', 'class'=>'form-horizontal']) !!}
    {!! csrf_field() !!}

    <div class="row">
      {{-- <div class="col-md-2">
        <div class="input-group{{ $errors->has('batas') ? ' has-error' : '' }}">
          <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('batas') ? ' has-error' : '' }}" type="button">Batas</button>
          </span>
          {!! Form::number('batas', 10, ['class' => 'form-control', 'required' => 'required','autocomplete'=>'off']) !!}
          <small class="text-danger">{{ $errors->first('batas') }}</small>
        </div>
      </div> --}}
      <div class="col-md-3">
        <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
          <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
          </span>
          {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' =>
          'required','autocomplete'=>'off']) !!}
          <small class="text-danger">{{ $errors->first('tga') }}</small>
        </div>
      </div>

      <div class="col-md-3">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">s/d Tanggal</button>
          </span>
          {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' =>
          'required','autocomplete'=>'off']) !!}
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <br />
        <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
        <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
      </div>

    </div>
    <br />
    {{-- <div class="row">

    </div> --}}
    {!! Form::close() !!}
    <hr>
    {{-- ================================================================================================== --}}


<div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">No CM</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Umur<br>(Tahun)</th>
                <th rowspan="2">Jenis Kelamin<br>(L/P)</th>
                <th rowspan="2">Alamat</th>
                <th rowspan="2">Puskesmas</th>
                <th rowspan="2">Kecamatan</th>
                <th rowspan="2">Desa</th>
                <th rowspan="2">Bulan<br>dirawat</th>
                <th rowspan="2">Diagnosa</th>
                <th rowspan="2">Status<br>(P/M)</th>
                <th colspan="6">HASIL LABORATORIUM</th>
                <th rowspan="2">Hematokrit Terendah</th>
                 <th rowspan="2">Tempat Dirawat</th>
                <th rowspan="2">Tanggal Masuk RS</th>
            </tr>
            <tr>
                <th>IgM</th>
                <th>IgG</th>
                <th>PCV terendah</th>
                <th>Leukosit terendah</th>
                <th>Hemoglobin terendah</th>
                <th>Thrombosit terendah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($irj as $key => $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{$d->umur }}</td>
                <td>{{ $d->kelamin }}</td>
                <td>{{ $d->alamat }}</td>
                <td>{{ $d->puskesmas ?? '-' }}</td>
                <td>{{ $d->kecamatan ?? '-' }}</td>
                <td>{{ $d->desa ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_masuk)->format('F') }}</td>
                <td>{{ $d->nama_icd10 }}</td>
                <td>{{ $d->status_pulang  ?? '-' }}</td>
                <td>{{ $d->igm  ?? '-'  }}</td>
                <td>{{ $d->igg  ?? '-' }}</td>
                <td>{{ $d->pcv_terendah  ?? '-' }}</td>
                <td>{{ $d->leukosit_terendah  ?? '-' }}</td>
                <td>{{ $d->hemoglobin_terendah  ?? '-' }}</td>
                <td>{{ $d->thrombosit_terendah  ?? '-' }}</td>
                <td>{{ $d->hematokrit_tertinggi  ?? '-' }}</td>
                <td>{{ $d->namaKelas }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_masuk)->format('d-m-Y') }}</td>

            </tr>
            @endforeach
        </tbody>
         
    </table>
  {{-- <div class="pagination-wrapper">
    {{ $irj->links() }}
  </div> --}}
    <!-- Tambahkan navigasi pagination -->
</div>

  </div>

  <div class="box-footer">
  </div>
</div>
{{-- modal icd10 --}}
<div class="modal fade" id="icd10DATA" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
        <div class='table-responsive'>
          <table  class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Input</th>
              </tr>
            </thead>

          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection


@section('script')
<script type="text/javascript">
  //ICD 10
  // ICD10
  $('.select2').select2()
  $('.openICD10').on('click', function () {
    $("#icd10VIEW").DataTable().destroy();
    $('#icd10DATA').modal('show');
    $('.modal-title').text('Data Diagnosa');
    $('#icd10VIEW').DataTable({
      "language": {
        "url": "/json/pasien.datatable-language.json",
      },
      paging: false, // Nonaktifkan pagination DataTables
      pageLength: 10,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ordering: false,
      ajax: '/frontoffice/e-claim/get-icd10-data',
      columns: [
        { data: 'nomor' },
        { data: 'nama' },
        { data: 'input', searchable: false }
      ]
    });
  });
  $(document).on('click', '.insert-diagnosa', function (e) {
    var diagnosa = $('input[name="diagnosa"]').val();
    var input = $(this).attr('data-nomor');

    if (diagnosa != '') {
      $('input[name="diagnosa"]').val(diagnosa + '#' + input);
    } else {
      $('input[name="diagnosa"]').val(input);
    }
    $('#icd10DATA').modal('hide');
  });


</script>
@endsection