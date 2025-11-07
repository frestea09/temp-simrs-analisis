@extends('master')

<style>
  .form-box td,
  select,
  input,
  textarea {
    font-size: 12px !important;
  }

  .history-family input[type=text] {
    height: 20px !important;
    padding: 0px !important;
  }

  .history-family-2 td {
    padding: 1px !important;
  }
</style>
@section('header')
<h1>Lembar Rawat Gabung</h1>
@endsection

@section('content')
@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/lembar-rawat-gabung/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('poli', $poli) !!}
          {!! Form::hidden('dpjp', $dpjp) !!}
          <br>
          
          <div class="col-md-6">
            <h5><b>Lembar rawat gabung Bayi dengan Ibu</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
             <tr>
                <td style="width:20%;">Nama Ibu / Ayah Bayi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[nama_orang_tua]" value="{{@$asessment['nama_orang_tua']}}" class="form-control"/>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">No Rekam Medik Bayi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[no_rm_bayi]" value="{{@$asessment['no_rm_bayi']}}" class="form-control"/>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Tanggal lahir bayi Bayi / jam</td>
                <td style="padding: 5px;">
                  <input type="datetime-local" name="fisik[tgl_lahir_bayi]" value="{{@$asessment['tgl_lahir_bayi']}}" class="form-control"/>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">BB / PB</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[bb_pb]" value="{{@$asessment['bb_pb']}}" class="form-control"/>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Jenis Kelamin</td>
                <td style="padding: 5px;">
                    <select name="fisik[jenis_kelamin_bayi]" class="select2" style="width: 100%;">
                        <option value="" selected disabled>-- Pilih salah satu --</option>
                        <option value="Perempuan" {{@$asessment['jenis_kelamin_bayi'] == "Perempuan" ? 'selected' : ''}}>Perempuan</option>
                        <option value="Laki-laki" {{@$asessment['jenis_kelamin_bayi'] == "Laki-laki" ? 'selected' : ''}}>Laki-laki</option>
                    </select>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Alamat tempat tinggal</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[alamat]" value="{{@$asessment['alamat']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Hasil Pemeriksaan pada Bayi</td>
                <td style="padding: 5px;">
                    a. Suhu
                  <input type="text" name="fisik[pemeriksaan_bayi][suhu]" value="{{@$asessment['pemeriksaan_bayi']['suhu']}}" class="form-control"/>
                    b. Respirasi
                  <input type="text" name="fisik[pemeriksaan_bayi][respirasi]" value="{{@$asessment['pemeriksaan_bayi']['respirasi']}}" class="form-control"/>
                    c. HR
                  <input type="text" name="fisik[pemeriksaan_bayi][hr]" value="{{@$asessment['pemeriksaan_bayi']['hr']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Tanggal / Jam rawat gabung</td>
                <td style="padding: 5px;">
                  <input type="datetime-local" name="fisik[tgl_rawat_gabung]" value="{{@$asessment['tgl_rawat_gabung']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;"><b>Serah terima keruang RG (Rawat Gabung)</b></td>
                <td style="padding: 5px;">
                    Petugas Perinatologi
                  <input type="text" name="fisik[serah_terima_ruang_rg][petugas_perinatologi]" value="{{@$asessment['serah_terima_ruang_rg']['petugas_perinatologi']}}" class="form-control"/>
                    Petugas Ruang RG
                  <input type="text" name="fisik[serah_terima_ruang_rg][perugas_ruang_rg]" value="{{@$asessment['serah_terima_ruang_rg']['perugas_ruang_rg']}}" class="form-control"/>
                    Keluarga Bayi
                  <input type="text" name="fisik[serah_terima_ruang_rg][keluarga_bayi]" value="{{@$asessment['serah_terima_ruang_rg']['keluarga_bayi']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;"><b>Serah terima kembali keruang Perinatalogi</b></td>
                <td style="padding: 5px;">
                    Petugas Perinatologi
                  <input type="text" name="fisik[serah_terima_ruang_perinatologi][petugas_perinatologi]" value="{{@$asessment['serah_terima_ruang_perinatologi']['petugas_perinatologi']}}" class="form-control"/>
                    Petugas Ruang RG
                  <input type="text" name="fisik[serah_terima_ruang_perinatologi][perugas_ruang_rg]" value="{{@$asessment['serah_terima_ruang_perinatologi']['perugas_ruang_rg']}}" class="form-control"/>
                    Keluarga Bayi
                  <input type="text" name="fisik[serah_terima_ruang_perinatologi][keluarga_bayi]" value="{{@$asessment['serah_terima_ruang_perinatologi']['keluarga_bayi']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Alasan dikembalikan keruang Perinatologi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[alasan_kembali_ke_perinatologi]" value="{{@$asessment['alasan_kembali_ke_perinatologi']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;"><b>Bila bayi dari ruang rawat gabung</b></td>
                <td style="padding: 5px;">
                    <select name="fisik[dari_ruang_rawat-gabung_pilihan]" class="select2" style="width: 100%;">
                        <option value="" selected disabled>-- Pilih salah satu --</option>
                        <option value="Boleh Pulang" {{@$asessment['dari_ruang_rawat-gabung_pilihan'] == "Boleh Pulang" ? 'selected' : ''}}>Boleh Pulang</option>
                        <option value="Pulang atas permintaan keluarga" {{@$asessment['dari_ruang_rawat-gabung_pilihan'] == "Pulang atas permintaan keluarga" ? 'selected' : ''}}>Pulang atas permintaan keluarga</option>
                    </select>
                    Petugas Ruang RG
                  <input type="text" name="fisik[dari_ruang_rawat_gabung][perugas_ruang_rg]" value="{{@$asessment['dari_ruang_rawat_gabung']['perugas_ruang_rg']}}" class="form-control"/>
                    Keluarga Bayi
                  <input type="text" name="fisik[dari_ruang_rawat_gabung][keluarga_bayi]" value="{{@$asessment['dari_ruang_rawat_gabung']['keluarga_bayi']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;"><b>Alasan Bayi tidak di Rawat Gabung dengan Ibunya</b></td>
                <td style="padding: 5px;">
                    Petugas Perinatologi
                  <input type="text" name="fisik[alasan_tidak_dirawat_gabung][petugas_perinatologi]" value="{{@$asessment['alasan_tidak_dirawat_gabung']['petugas_perinatologi']}}" class="form-control"/>
                    Petugas Ruang RG
                  <input type="text" name="fisik[alasan_tidak_dirawat_gabung][perugas_ruang_rg]" value="{{@$asessment['alasan_tidak_dirawat_gabung']['perugas_ruang_rg']}}" class="form-control"/>
                    Keluarga Bayi
                  <input type="text" name="fisik[alasan_tidak_dirawat_gabung][keluarga_bayi]" value="{{@$asessment['alasan_tidak_dirawat_gabung']['keluarga_bayi']}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Alasan Bayi tidak di Rawat Gabung dengan Ibunya</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[alasan_tidak_dirawat_gabung][detail]" value="{{@$asessment['alasan_tidak_dirawat_gabung']['detail']}}" class="form-control"/>
                </td>
              </tr>
            </table>
          </div>
          
          <br /><br />
        </div>

        
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
    <br/>
    <br/>
    
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>
  @endsection