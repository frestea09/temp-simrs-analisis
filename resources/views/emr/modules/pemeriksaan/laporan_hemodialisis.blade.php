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

  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }
  
  #myImg:hover {opacity: 0.7;}
  
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }
  
  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }
  
  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }
  
  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }
  
  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }
  
  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }
  
  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }
  
  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }
  
  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
  .select2-selection__rendered{
    padding-left: 20px !important;
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
@section('header')
<h1>Laporan Hemodialisis Unit Hemodialisis</h1>
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
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/laporan-hemodialisis/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <br>


          <h4 class="text-center"><b>Laporan Hemodialisis</b></h4>
          <div class="col-md-12">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">User</th>
                  <th class="text-center" style="vertical-align: middle;">Asal Pasien</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                </tr>
              </thead>
              <tbody>  
                @if (count($riwayats) == 0)
                    <tr>
                        <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                    </tr>
                @else
                  @foreach ($riwayats as $riwayat)
                      <tr>
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{ @$riwayat->user->name }}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              @if (strpos(strtolower($riwayat->registrasi->status_reg), 'i') !== false)
                              {{@baca_kamar($riwayat->registrasi->rawat_inap->kamar)}}
                              @else
                              {{@baca_poli($riwayat->registrasi->poli_id)}}
                              @endif
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                              <a href="{{ url("emr-soap-print/cetak-laporan-hemodialisis/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
                              <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                <i class="fa fa-trash"></i>
                              </a>
                          </td>
                      </tr>
                      <tr>
                        <td colspan="4" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                        </td>
                      </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <div class="col-md-6">

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2">
                  <b>Laporan Tindakan</b>
                </td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>
                  <input type="date" name="fisik[laporanTindakan][tgl]" class="form-control" value="{{ @$assesment['laporanTindakan']['tgl'] }}">
                </td>
              </tr>
              <tr>
                <td>Ruang Rawat</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][ruangRawat]" class="form-control" value="{{ @$assesment['laporanTindakan']['ruangRawat'] }}">
                </td>
              </tr>
              <tr>
                <td>Waktu HD</td>
                <td>
                  <input type="time" name="fisik[laporanTindakan][waktuHD][awal]" class="form-control" value="{{ @$assesment['laporanTindakan']['waktuHD']['awal'] }}">
                  s/d
                  <input type="time" name="fisik[laporanTindakan][waktuHD][akhir]" class="form-control" value="{{ @$assesment['laporanTindakan']['waktuHD']['akhir'] }}">
                </td>
              </tr>
              <tr>
                <td>Dilakukan Program</td>
                <td>
                  <label for="program_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="HD" id="program_1" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'HD' ? 'checked' : '' }}>
                    HD
                  </label>
                  <label for="program_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="SLEED" id="program_2" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'SLEED' ? 'checked' : '' }}>
                    SLEED
                  </label>
                  <label for="program_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="HFR" id="program_3" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'HFR' ? 'checked' : '' }}>
                    HFR
                  </label>
                  <label for="program_4" style="margin-right: 10px;">
                    <input type="radio" name="fisik[laporanTindakan][program][pilihan]" value="HDF" id="program_4" {{ @$assesment['laporanTindakan']['program']['pilihan'] == 'HDF' ? 'checked' : '' }}>
                    HDF
                  </label>
                  <br>
                  <input type="text" placeholder="Lainnya" name="fisik[laporanTindakan][program][lainnya]" class="form-control" value="{{ @$assesment['laporanTindakan']['program']['lainnya'] }}">
                </td>
              </tr>
              <tr>
                <td colspan="2">dengan :</td>
              </tr>
              <tr>
                <td>Time Dialisis (Jam)</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][timeDialisis]" class="form-control" value="{{ @$assesment['laporanTindakan']['timeDialisis'] }}">
                </td>
              </tr>
              <tr>
                <td>Suhu</td>
                <td>
                  <input type="number" name="fisik[laporanTindakan][suhu]" class="form-control" value="{{ @$assesment['laporanTindakan']['suhu'] }}">
                </td>
              </tr>
              <tr>
                <td>UF GOAL (ml)</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][ufGoal]" class="form-control" value="{{ @$assesment['laporanTindakan']['ufGoal'] }}">
                </td>
              </tr>
              <tr>
                <td>Quick Blood (ml / mnt)</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][quickBlood]" class="form-control" value="{{ @$assesment['laporanTindakan']['quickBlood'] }}">
                </td>
              </tr>
              <tr>
                <td>Quick Dialysat (ml / mnt)</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][quickDialysat]" class="form-control" value="{{ @$assesment['laporanTindakan']['quickDialysat'] }}">
                </td>
              </tr>
              <tr>
                <td colspan="2">Profiling</td>
              </tr>
              <tr>
                <td>UF</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][profiling][uf]" class="form-control" value="{{ @$assesment['laporanTindakan']['profiling']['uf'] }}">
                </td>
              </tr>
              <tr>
                <td>Na</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][profiling][na]" class="form-control" value="{{ @$assesment['laporanTindakan']['profiling']['na'] }}">
                </td>
              </tr>
              <tr>
                <td>Lainnya</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][profiling][lainnya]" class="form-control" value="{{ @$assesment['laporanTindakan']['profiling']['lainnya'] }}">
                </td>
              </tr>
              <tr>
                <td>Akses Sirkulasi</td>
                <td>
                  <label for="aksesSirkulasi_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[laporanTindakan][aksesSirkulasi][pilihan]" value="Cimino" id="aksesSirkulasi_1" {{ @$assesment['laporanTindakan']['aksesSirkulasi']['pilihan'] == 'Cimino' ? 'checked' : '' }}>
                    Cimino
                  </label>
                  <label for="aksesSirkulasi_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[laporanTindakan][aksesSirkulasi][pilihan]" value="Femoral" id="aksesSirkulasi_2" {{ @$assesment['laporanTindakan']['aksesSirkulasi']['pilihan'] == 'Femoral' ? 'checked' : '' }}>
                    Femoral
                  </label>
                  <label for="aksesSirkulasi_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[laporanTindakan][aksesSirkulasi][pilihan]" value="Double Lumen Catheter" id="aksesSirkulasi_3" {{ @$assesment['laporanTindakan']['aksesSirkulasi']['pilihan'] == 'Double Lumen Catheter' ? 'checked' : '' }}>
                    Double Lumen Catheter
                  </label>
                  <br>
                  <input type="text" placeholder="Sebutkan" name="fisik[laporanTindakan][aksesSirkulasi][sebutkan]" class="form-control" value="{{ @$assesment['laporanTindakan']['aksesSirkulasi']['sebutkan'] }}">
                </td>
              </tr>
              <tr>
                <td>Tindakan Keperawatan</td>
                <td>
                  <input type="text" name="fisik[laporanTindakan][tindakan_keperawatan]" class="form-control" value="{{ @$assesment['laporanTindakan']['tindakan_keperawatan'] }}">
                </td>
              </tr>
            </table>
          </div>
          
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2">
                  <b>Pre HD</b>
                </td>
              </tr>
              <tr>
                <td>Keluhan Utama</td>
                <td>
                  <input type="text" name="fisik[preHD][keluhanUtama]" class="form-control" value="{{ @$assesment['preHD']['keluhanUtama'] }}">
                </td>
              </tr>
              <tr>
                <td>Keadaan Umum</td>
                <td>
                  <label for="keadaanUmum_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Tampak Tidak Sakit" id="keadaanUmum_1" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                    Tampak Tidak Sakit
                  </label>
                  <label for="keadaanUmum_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Sakit Ringan" id="keadaanUmum_2" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Sakit Ringan' ? 'checked' : '' }}>
                    Sakit Ringan
                  </label>
                  <label for="keadaanUmum_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Sakit Sedang" id="keadaanUmum_3" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Sakit Sedang' ? 'checked' : '' }}>
                    Sakit Sedang
                  </label>
                  <label for="keadaanUmum_4" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][keadaanUmum][pilihan]" value="Sakit Berat" id="keadaanUmum_4" {{ @$assesment['preHD']['keadaanUmum']['pilihan'] == 'Sakit Berat' ? 'checked' : '' }}>
                    Sakit Berat
                  </label>
                </td>
              </tr>
              <tr>
                <td>Kesadaran</td>
                <td>
                  <label for="kesadaran_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Compos Mentis" id="kesadaran_1" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Compos Mentis' ? 'checked' : '' }}>
                    Compos Mentis
                  </label>
                  <label for="kesadaran_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Apatis" id="kesadaran_2" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Apatis' ? 'checked' : '' }}>
                    Apatis
                  </label>
                  <label for="kesadaran_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Somnolen" id="kesadaran_3" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Somnolen' ? 'checked' : '' }}>
                    Somnolen
                  </label>
                  <label for="kesadaran_4" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Sopor" id="kesadaran_4" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Sopor' ? 'checked' : '' }}>
                    Sopor
                  </label>
                  <label for="kesadaran_5" style="margin-right: 10px;">
                    <input type="radio" name="fisik[preHD][kesadaran][pilihan]" value="Coma" id="kesadaran_5" {{ @$assesment['preHD']['kesadaran']['pilihan'] == 'Coma' ? 'checked' : '' }}>
                    Coma
                  </label>
                </td>
              </tr>
              <tr>
                <td colspan="2">Tanda Vital</td>
              </tr>
              <tr>
                <td>TD (mmHg)</td>
                <td>
                  <input type="text" name="fisik[preHD][tanda_vital][tekanan_darah]" class="form-control" value="{{ @$assesment['preHD']['tanda_vital']['tekanan_darah'] }}">
                </td>
              </tr>
              <tr>
                <td>Nadi (x/mnt)</td>
                <td>
                  <input type="text" name="fisik[preHD][tanda_vital][nadi]" class="form-control" value="{{ @$assesment['preHD']['tanda_vital']['nadi'] }}">
                </td>
              </tr>
              <tr>
                <td>Pernapasan (x/mnt)</td>
                <td>
                  <input type="text" name="fisik[preHD][tanda_vital][pernapasan]" class="form-control" value="{{ @$assesment['preHD']['tanda_vital']['pernapasan'] }}">
                </td>
              </tr>
              <tr>
                <td>Suhu (°C)</td>
                <td>
                  <input type="text" name="fisik[preHD][tanda_vital][suhu]" class="form-control" value="{{ @$assesment['preHD']['tanda_vital']['suhu'] }}">
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2">
                  <b>On HD</b>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <textarea name="fisik[onHD]" style="resize: vertical;" class="form-control" rows="5">{{ @$assesment['onHD'] }}</textarea>
                </td>
              </tr>

            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2">
                  <b>Post HD</b>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <input type="text" class="form-control" name="fisik[postHD]" value="{{ @$assesment['postHD'] }}">
                </td>
              </tr>

            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2">
                  <b>Hasil Akhir HD</b>
                </td>
              </tr>
              <tr>
                <td>Time Dialisis (Jam)</td>
                <td>
                  <input type="text" name="fisik[hasilAkhirHD][timeDialisis]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['timeDialisis'] }}">
                </td>
              </tr>
              <tr>
                <td>UF GOAL (ml)</td>
                <td>
                  <input type="text" name="fisik[hasilAkhirHD][ufGoal]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['ufGoal'] }}">
                </td>
              </tr>
              <tr>
                <td>Transfusi (ml)</td>
                <td>
                  <input type="number" name="fisik[hasilAkhirHD][transfusi]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['transfusi'] }}">
                </td>
              </tr>
              <tr>
                <td>Terapi Cairan (ml)</td>
                <td>
                  <input type="number" name="fisik[hasilAkhirHD][terapiCairan]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['terapiCairan'] }}">
                </td>
              </tr>
              <tr>
                <td>Asupan Cairan Oral / NGT (ml)</td>
                <td>
                  <input type="number" name="fisik[hasilAkhirHD][asupanCairanOral]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['asupanCairanOral'] }}">
                </td>
              </tr>
              <tr>
                <td>Jumlah (ml)</td>
                <td>
                  <input type="number" name="fisik[hasilAkhirHD][jumlah]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['jumlah'] }}">
                </td>
              </tr>
              <tr>
                <td>UF Total (ml)</td>
                <td>
                  <input type="text" name="fisik[hasilAkhirHD][ufTotal]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['ufTotal'] }}">
                </td>
              </tr>
              <tr>
                <td>Keterangan Lain</td>
                <td>
                  <input type="text" name="fisik[hasilAkhirHD][keteranganLain]" class="form-control" value="{{ @$assesment['hasilAkhirHD']['keteranganLain'] }}">
                </td>
              </tr>
              <tr>
                <td>Darah Untuk Pemeriksaan Lab</td>
                <td>
                  <label for="darahPemeriksaan_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[hasilAkhirHD][darahPemeriksaan][pilihan]" value="Diambil" id="darahPemeriksaan_1" {{ @$assesment['hasilAkhirHD']['darahPemeriksaan']['pilihan'] == 'Diambil' ? 'checked' : '' }}>
                    Diambil
                  </label>
                  <label for="darahPemeriksaan_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[hasilAkhirHD][darahPemeriksaan][pilihan]" value="Tidak Diambil" id="darahPemeriksaan_2" {{ @$assesment['hasilAkhirHD']['darahPemeriksaan']['pilihan'] == 'Tidak Diambil' ? 'checked' : '' }}>
                    Tidak Diambil
                  </label>
                </td>
              </tr>


            </table>
          </div>

          <div class="col-md-12 text-right">
            <button class="btn btn-success">Simpan</button>
          </div>

        </form>
          
          <br /><br />
        </div>
      </div>
      

  </div>

  

  @endsection

  @section('script')

  <script type="text/javascript">
    status_reg = "<?= substr($reg->status_reg,0,1) ?>"
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
    $("#date_dengan_tanggal").attr('', true);  
         
  </script>

  @endsection