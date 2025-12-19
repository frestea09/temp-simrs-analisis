@extends('master')
@section('header')
  <h1>Laporan 10 Besar Diagnosa IGD </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/diagnosa-igd', 'class'=>'form-horizontal']) !!}
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
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default openICD10" id="" type="button">Pilih Diagnosa</button>
            </span>
              {!! Form::text('diagnosa', null, ['class' => 'form-control openICD10','placeholder'=>'Pilih Diagnosa', 'id'=>'diagnosa_awal']) !!}
          </div>
        </div>
        
        <div class="col-md-4">
          <br/>
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default openICD10" id="" type="button">Poli</button>
            </span>
              {!! Form::select('poli', $poli,null, ['class' => 'form-control select2','placeholder'=>'Semua']) !!}
          </div>
        </div>

        <div class="col-md-3">
          <br/>
          {{-- <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
        
      </div>
      <br/>
      {{-- <div class="row">
        
      </div> --}}
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      @if ( isset($ok) )
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
                </tr>
              {{-- <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>RM</th>
                <th>NIK</th>
                <th>Dokter</th>
                <th>Tgl. Masuk</th>
                <th>Tgl. Keluar</th>
                <th>Kasus 1</th>
                <th>Kasus 2</th>
                <th>Rujuk Ke</th>
                <th>Poli</th>
                <th>Diagnosa Awal</th>
                <th>Diagnosa Akhir</th>
                <th>ICD 9</th>
                <th>ICD 10</th>
                <th>Keterangan</th>
                <th>Asuransi</th>
                <th>Alamat</th>
                <th>Provinsi</th>
                <th>Kabupaten</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
              </tr> --}}
            </thead>
            <tbody>

              @foreach ($ok as $key => $d)


              @php
              $reg = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
              $icd9 = App\PerawatanIcd9::where('registrasi_id', $reg->id)->first();
              $pasien = Modules\Registrasi\Entities\Registrasi::where('pasien_id',$reg->pasien_id)->count();
              @endphp

                {{-- <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->icd10 }}</td>
                  <td>{{ baca_icd10($d->icd10) }}</td>
                  <td>{{ $d->total }}</td>
                  <td>
                    <ul>
                      @foreach ($d->jk as $jenis_kelamin)
                      <li>{{ $jenis_kelamin->kelamin }} : {{ $jenis_kelamin->total }} </li>
                      @endforeach
                    </ul>
                  </td>
                </tr> --}}

                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ baca_pasien($reg->pasien_id) }}</td>
                  <td>{{ $reg->pasien->no_rm}}</td>
                  <td>{{ $reg->pasien->nik}}</td>
                  <td>{{ baca_dokter($reg->dokter_id) }}</td>
                  <td>{{ date('d/m/Y H:i', strtotime($reg->created_at)) }}</td>
                  <td>
                    @if ($reg->lunas == 'Y')
                      {{ date('d/m/Y H:i', strtotime($reg->updated_at)) }}
                    @endif
                  </td>
                  <td>{{ @$reg->status }}</td>
                  <td>

                    @if ($pasien > 1)
                        <p>Lama</p>
                    @else
                        <p>Baru</p>    
                    @endif

                </td>
                  <td>{{ baca_rujukan(@$reg->rujukkan) }}</td>
                  <td>{{ baca_poli($reg->poli_id) }}</td>
                  <td>{{ @baca_diagnosa(@$reg->diagnosa_awal) }}</td>
                  <td>{{ @baca_diagnosa(@$reg->diagnosa_akhir) }}</td>
                  <td>{{ baca_icd9(@$icd9->icd9) }}</td>
                  <td>{{ baca_icd10(@$d->icd10) }}</td>
                  <td>{{ @$reg->keterangan }}</td>
                  <td>{{ baca_jkn(@$reg->id) }}</td>
                  <td>{{ @$reg->pasien->alamat }}</td>
                  <td>{{ baca_propinsi(@$reg->pasien->province_id) }}</td>
                  <td>{{ baca_kabupaten(@$reg->pasien->regency_id) }}</td>
                  <td>{{ baca_kecamatan(@$reg->pasien->district_id) }}</td>
                  <td>{{ baca_kelurahan(@$reg->pasien->village_id) }}</td>
                </tr>

              @endforeach
            </tbody>
          </table>
        </div>
      @endif


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
          <table id="icd10VIEW" class='table table-striped table-bordered table-hover table-condensed'>
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

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/frontoffice/e-claim/get-icd10-data',
        columns: [
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'input', searchable: false}
        ]
    });
  });
  $(document).on('click', '.insert-diagnosa', function (e) {
    var diagnosa = $('input[name="diagnosa"]').val();
    var input = $(this).attr('data-nomor');

    if( diagnosa != '' ) {
      $('input[name="diagnosa"]').val(diagnosa+'#'+input);
    } else {
      $('input[name="diagnosa"]').val(input);
    }
    $('#icd10DATA').modal('hide');
  });

         
  </script>
  @endsection