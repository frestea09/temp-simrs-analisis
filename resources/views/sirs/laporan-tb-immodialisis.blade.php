@extends('master')
@section('header')
<h1>Laporan Morbiditas </h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => '/sirs/rl/filter-morbiditas', 'class'=>'form-horizontal']) !!}
    {!! csrf_field() !!}
    
    <div class="row">
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
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default" id="" type="button">Poli/Kamar</button>
            </span>
            {!! Form::select('poli', $poli, null, ['class' => 'form-control select2', 'id' => 'poli', 'placeholder' => 'Semua']) !!}
        </div>
    </div>
    <div class="col-md-3">
    <br />
    <div class="input-group">
          <span class="input-group-btn">
              <button class="btn btn-default" id="" type="button">Layanan</button>
          </span>
          {!! Form::select('layanan', [
              'TA' => 'Rawat Jalan',
              'TI' => 'Rawat Inap',
              'TG' => 'IGD'
          ], null, ['class' => 'form-control', 'id' => 'layanan', 'placeholder' => 'Pilih Layanan']) !!}
      </div>
  </div>
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
    @if ( isset($ok) )
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>Pasien</th>
            <th>RM</th>
            <th>NIK</th>
            <th>Dokter</th>
            <th>Kasus 1</th>
            <th>Kasus 2</th>
            <th>Rujuk Ke</th>
            <th>Tgl. Registrasi</th>
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
          </tr>
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
            <td>{{ @$reg->status }}</td>
            <td>

              @if ($pasien > 1)
              <p>Lama</p>
              @else
              <p>Baru</p>
              @endif

            </td>
            <td>{{ baca_rujukan(@$reg->rujukan) }}</td>
            <td>{{ Carbon\Carbon::parse(@$reg->created_at)->format('d-m-Y') }}</td>
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

    <div class='table-responsive'>
          <table class='table table-striped table-bordered' id="data">
              <thead>
                  @if(isset($layanan) && $layanan == "TA" || $layanan == "TG")
                  <tr>
                      <th rowspan="2">NO</th>
                      <th rowspan="2">Kode ICD</th>
                      <th rowspan="2">Golongan Sebab Sakit</th>
                      <th colspan="8">KASUS BARU MENURUT GOLONGAN UMUR</th>
                      <th colspan="3">KASUS BARU MENURUT SEX</th>
                      <th rowspan="2">Kasus Lama</th>
                      <th rowspan="2">Total</th>
                  </tr>
                  <tr>
                      <th>0-<28 Hari</th>
                      <th>28Hr-<1Th</th>
                      <th>1-4Th</th>
                      <th>5-14Th</th>
                      <th>15-24Th</th>
                      <th>25-44Th</th>
                      <th>45-64Th</th>
                      <th>65Th</th>
                      <th>Lk</th>
                      <th>Pr</th>
                      <th>Jmlh</th>
                  </tr>
                  @else
                  <tr>
                      <th rowspan="2">NO</th>
                      <th rowspan="2">Kode ICD</th>
                      <th rowspan="2">GOLONGAN SEBAB SEBAB SAKIT</th>
                      <th colspan="8">PASIEN KELUAR (HIDUP & MATI) MENURUT GOLONGAN UMUR</th>
                      <th colspan="2">PASIEN KELUAR HIDUP & MATI MENURUT SEX</th>
                      <th rowspan="2">JUMLAH PASIEN KELUAR</th>
                      <th rowspan="2">JUMLAH PASIEN KELUAR MATI</th>
                  </tr>
                  <tr>
                      <th>0-28 HARI</th>
                      <th>28Hr-1TH</th>
                      <th>1-4 TH</th>
                      <th>5-14 TH</th>
                      <th>15-24 TH</th>
                      <th>25-44 TH</th>
                      <th>45-64 TH</th>
                      <th>65 TH</th>
                      <th>Lk</th>
                      <th>Pr</th>
                  </tr>
                  @endif
              </thead>

              <tbody>
                  @foreach ($irj as $key => $d)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $d->nomor }}</td>
                      <td>{{ $d->penyakit }}</td>
                      <td>{{ $d->{'Usia_0_28_Hari'} }}</td>
                      <td>{{ $d->{'Usia_28Hari_1Tahun'} }}</td>
                      <td>{{ $d->{'Usia_1_4_Tahun'} }}</td>
                      <td>{{ $d->{'Usia_5_14_Tahun'} }}</td>
                      <td>{{ $d->{'Usia_15_24_Tahun'} }}</td>
                      <td>{{ $d->{'Usia_25_44_Tahun'} }}</td>
                      <td>{{ $d->{'Usia_45_64_Tahun'} }}</td>
                      <td>{{ $d->{'Usia_65_Tahun'} }}</td>
                      @if($layanan == "TA" || $layanan == "TG")
                      <td>{{ $d->jumlah_laki_laki }}</td>
                      <td>{{ $d->jumlah_perempuan }}</td>
                      <td>{{ $d->jumlah_perempuan + $d->jumlah_laki_laki  }}</td>
                      <td>{{ $d->kasus_lama }}</td>
                      <td>{{ $d->kasus_total }}</td>
                      @else
                      <td>{{ $d->jumlah_laki_laki }}</td>
                      <td>{{ $d->jumlah_perempuan }}</td>
                      <td>{{ $d->Jumlah_Pulang_Biasa }}</td>
                      <td>{{ $d->Jumlah_Pulang_Meninggal }}</td>
                      @endif
                  </tr>
                  @endforeach
              </tbody>
          </table>
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
  $(document).ready(function() {
        $('#layanan').change(function() {
            var layanan = $(this).val(); // Ambil nilai layanan yang dipilih

            $.ajax({
                url: "{{ route('get.poli.kamar') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    layanan: layanan
                },
                success: function(response) {
                    var $poli = $('#poli');
                    $poli.empty(); // Kosongkan dropdown poli

                    $poli.append('<option value="">Semua</option>'); // Tambahkan opsi default
                    $.each(response, function(key, value) {
                        $poli.append('<option value="' + key + '">' + value + '</option>');
                    });

                    $poli.trigger('change'); // Trigger event untuk select2 (jika digunakan)
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });
    });

</script>
@endsection