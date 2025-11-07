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
<h1>fisik Fisik</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/mata/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          

          {{-- Anamnesis --}}
          @php
            @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
            if(!@$dataPegawai){
                @$dataPegawai = 1;
            }
          @endphp

          @if (@$dataPegawai == '1')
          <div class="col-md-6">
            <h5><b>Asesmen</b></h5>
            @if (session('error_dp'))
              <div class="alert alert-danger">
                Gagal simpan, 
                  {{ session('error_dp') }}
              </div>
            @endif
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>1. ANAMNESA</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[anamnesa]" required style="display:inline-block; resize: vertical;" placeholder="[Masukkan Anamnesa]" class="form-control" >{{ @$assesment['anamnesa'] ?? @$assesment['keluhan_utama'] }}</textarea>
                    @if($errors->has('fisik.anamnesa'))
                        <div class="error text-danger">{{ $errors->first('fisik.anamnesa') }}</div>
                    @endif
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>2. PEMERIKSAAN FISIK</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Pemeriksaan Fisik]" class="form-control">{{ @$assesment['pemeriksaan_fisik'] ?? "Tekanan darah : " . (@$assesment['tanda_vital']['tekanan_darah'] ?? "") . ", Nadi : " . (@$assesment['tanda_vital']['nadi'] ?? "") . ", RR : " . (@$assesment['tanda_vital']['RR'] ?? "") . ", Suhu : " . (@$assesment['tanda_vital']['temp'] ?? "") . ", Berat Badan : " . (@$assesment['tanda_vital']['BB'] ?? "") . ", Tinggi Badan : " . (@$assesment['tanda_vital']['TB'] ?? "") }}</textarea>
                    @if($errors->has('fisik.pemeriksaan_fisik'))
                        <div class="error text-danger">{{ $errors->first('fisik.pemeriksaan_fisik') }}</div>
                    @endif
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>3. STATUS PEDIATRI (diisi bila perlu)</b></h5>
              <tr>
                <td style="width:20%;">A. Status Gizi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[status_pediatri][status_gizi]" class="form-control" id="" value="{{ @$assesment['status_pediatri']['status_gizi'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">B. Riwayat Imunisasi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[status_pediatri][riwayat_imunisasi]" class="form-control" id="" value="{{ @$assesment['status_pediatri']['riwayat_imunisasi'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">C. Riwayat Tumbuh Kembang</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[status_pediatri][riwayat_tumbuh_kembang]" class="form-control" id="" value="{{ @$assesment['status_pediatri']['riwayat_tumbuh_kembang'] }}">
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>4. STATUS LOKALIS</b></h5>
              <thead>
                <tr>
                  <th style="width: 40%; text-align: center;">Pemeriksaan</th>
                  <th style="width: 30%; text-align: center;">OD</th>
                  <th style="width: 30%; text-align: center;">OS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1. Pemeriksaan Visus</td>
                  <td>
                    <input type="text" name="fisik[pemeriksaanVisus][od]" class="form-control" id="" value="{{ @$assesment['pemeriksaanVisus']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[pemeriksaanVisus][os]" class="form-control" id="" value="{{ @$assesment['pemeriksaanVisus']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td>2. Pemeriksaan keseimbangan posisi bola mata</td>
                  <td>
                    <input type="text" name="fisik[keseimbanganBolaMata][od]" class="form-control" id="" value="{{ @$assesment['keseimbanganBolaMata']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[keseimbanganBolaMata][os]" class="form-control" id="" value="{{ @$assesment['keseimbanganBolaMata']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>3. Pemeriksaan gerak bola mata</span><br>
                  </td>
                  <td>
                    <input type="text" name="fisik[gerakBolaMata][od]" class="form-control" id="" value="{{ @$assesment['gerakBolaMata']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[gerakBolaMata][os]" class="form-control" id="" value="{{ @$assesment['gerakBolaMata']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    <a href="{{url('/emr-soap/penilaian/mata1/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis 1</a>&nbsp;&nbsp;
                    @if (@$gambar1->image != null)                    
                      <br>
                      <br>
                      <img src="/images/{{ @$gambar1['image'] }}" id="dataImage" style="width: 100%; height:100%;">
                    @else
                      <br>
                      <i>Status Lokalis 1 Belum Ada</i>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>4. Pemeriksaan tekanan intraocular</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[tekananIntraocular][od]" class="form-control" id="" value="{{ @$assesment['tekananIntraocular']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[tekananIntraocular][os]" class="form-control" id="" value="{{ @$assesment['tekananIntraocular']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>5. Pemeriksaan segmen anterior</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[segmenAnterior][od]" class="form-control" id="" value="{{ @$assesment['segmenAnterior']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[segmenAnterior][os]" class="form-control" id="" value="{{ @$assesment['segmenAnterior']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 20px;">
                    <span>a. Palpebra</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[palpebra][od]" class="form-control" id="" value="{{ @$assesment['palpebra']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[palpebra][os]" class="form-control" id="" value="{{ @$assesment['palpebra']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 20px;">
                    <span>b. Konjungtiva</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[konjungtiva][od]" class="form-control" id="" value="{{ @$assesment['konjungtiva']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[konjungtiva][os]" class="form-control" id="" value="{{ @$assesment['konjungtiva']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 20px;">
                    <span>c. Kornea</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[kornea][od]" class="form-control" id="" value="{{ @$assesment['kornea']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[kornea][os]" class="form-control" id="" value="{{ @$assesment['kornea']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 20px;">
                    <span>d. Bilik mata depan</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[bilikMataDepan][od]" class="form-control" id="" value="{{ @$assesment['bilikMataDepan']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[bilikMataDepan][os]" class="form-control" id="" value="{{ @$assesment['bilikMataDepan']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 20px;">
                    <span>e. Iris</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[iris][od]" class="form-control" id="" value="{{ @$assesment['iris']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[iris][os]" class="form-control" id="" value="{{ @$assesment['iris']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 20px;">
                    <span>f. Pupil</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[pupil][od]" class="form-control" id="" value="{{ @$assesment['pupil']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[pupil][os]" class="form-control" id="" value="{{ @$assesment['pupil']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding-left: 20px;">
                    <span>g. Lensa</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[lensa][od]" class="form-control" id="" value="{{ @$assesment['lensa']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[lensa][os]" class="form-control" id="" value="{{ @$assesment['lensa']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>6. Pemeriksaan lapang pandang</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[lapangPandang][od]" class="form-control" id="" value="{{ @$assesment['lapangPandang']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[lapangPandang][os]" class="form-control" id="" value="{{ @$assesment['lapangPandang']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>7. Pemeriksaan funduskopi</span>
                  </td>
                  <td>
                    <input type="text" name="fisik[funduskopi][od]" class="form-control" id="" value="{{ @$assesment['funduskopi']['od'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[funduskopi][os]" class="form-control" id="" value="{{ @$assesment['funduskopi']['os'] }}">
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    <a href="{{url('/emr-soap/penilaian/mata2/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis 2</a>&nbsp;&nbsp;
                    @if (@$gambar2->image != null)                    
                      <br>
                      <br>
                      <img src="/images/{{ @$gambar2['image'] }}" id="dataImage" style="width: 100%; height:100%;">
                    @else
                      <br>
                      <i>Status Lokalis 2 Belum Ada</i>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    <input type="text" name="fisik[lokalis2][keterangan]" style="display: inline-block;" class="form-control" id="" value="{{ @$assesment['lokalis2']['keterangan'] }}" placeholder="Keterangan Lokalis 2">
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    <a href="{{url('/emr-soap/penilaian/mata3/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis 3</a>&nbsp;&nbsp;
                    @if (@$gambar3->image != null)                    
                      <br>
                      <br>
                      <img src="/images/{{ @$gambar3['image'] }}" id="dataImage" style="width: 100%; height:100%;">
                    @else
                      <br>
                      <i>Status Lokalis 3 Belum Ada</i>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    <input type="text" name="fisik[lokalis3][keterangan]" style="display: inline-block;" class="form-control" id="" value="{{ @$assesment['lokalis3']['keterangan'] }}" placeholder="Keterangan Lokalis 3">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="col-md-6">
            <h5><b>Asesmen</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>5. DIAGNOSIS</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[diagnosis]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosis]" class="form-control" >{{ @$assesment['diagnosis'] }}</textarea>
                    @if($errors->has('fisik.diagnosis'))
                        <div class="error text-danger">{{ $errors->first('fisik.diagnosis') }}</div>
                    @endif
                  </td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[diagnosistambahan]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosis Tambahan]" class="form-control" >{{ @$assesment['diagnosistambahan'] }}</textarea>
                    <br/>
                  </td>
              </tr>
            </table>

            <table style="width: 100%" required class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>6. PLANNING</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[planning]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Planning]" class="form-control" >{{ @$assesment['planning'] }}</textarea>
                    @if($errors->has('fisik.planning'))
                      <div class="error text-danger">{{ $errors->first('fisik.planning') }}</div>
                    @endif
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td colspan="2" style="font-weight:bold;">RENCANA PEMULANGAN PASIEN (Discharge Planning)</td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesment['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                </td>
                <td>
                  <input type="text" id="waktuKontrol1" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="button" id="listKontrol1" data-dokterID="{{ $reg->dokter_id }}"
                    class="btn btn-info btn-sm btn-flat">
                    <i class="fa fa-th-list"></i> Lihat List Kontrol
                  </button>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB" {{@$assesment['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][kontrolPRB][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrolPRB']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat" {{@$assesment['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][dirawat][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirawat']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirujuk']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesment['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesment['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][pulpak][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['pulpak']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesment['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][meninggal][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['meninggal']['waktu']}}">
                </td>
              </tr>
            </table>

            <button class="btn btn-success">Simpan</button>
            </form>
            <br/>
            <br/>

            <table class='table table-striped table-bordered table-hover table-condensed'>
              <form method="POST" action="{{ url('emr-soap/perencanaan/visum/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
                {{ csrf_field() }}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                {!! Form::hidden('unit', $unit) !!}
                {!! Form::hidden('poli', $poli) !!}
                {!! Form::hidden('dpjp', $dpjp) !!}
                <br>
                <tr>
                  <td style="width:20%;">Visum</td>
                  <td style="padding: 5px;">
                    <textarea name="keterangan[pemeriksaanDokter]" id="" class="form-control" style="resize: vertical; dispay: inline-block;" rows="10">{{ @$visum['pemeriksaanDokter'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: right;">
                    <button class="btn btn-success">Simpan Visum</button>
                  </td>
                </tr>
              </form>
            </table>

            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                
                @if (count($riwayats) == 0)
                    <tr>
                        <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                    </tr>
                @endif
                @foreach ($riwayats as $riwayat)
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ baca_poli($riwayat->registrasi->poli_id) }}
                        </td>
                      
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{-- <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> --}}
                            @if (substr($riwayat->registrasi->status_reg, 0, 1) == 'J')
                              @if (in_array($riwayat->registrasi->poli_id, ['3', '34', '4']))
                                <a href="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                  <i class="fa fa-print"></i>
                                </a>
                              @elseif ($riwayat->registrasi->poli_id == '15')
                                <a href="{{ url("cetak-resume-medis-rencana-kontrol-obgyn/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                  <i class="fa fa-print"></i>
                                </a>
                              @elseif ( $riwayat->registrasi->poli_id == "6")
                                <a href="{{ url("cetak-resume-medis-rencana-kontrol-mata/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm btn-flat">
                                  <i class="fa fa-print"></i>
                                </a>
                              @elseif ($riwayat->registrasi->poli_id == '27')
                                <a href="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                  <i class="fa fa-print"></i>
                                </a>
                              @elseif ($riwayat->registrasi->poli_id == '41')
                                <a href="{{ url("cetak-resume-medis-rencana-kontrol-paru/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                  <i class="fa fa-print"></i>
                                </a>
                              @else
                                <a href="{{ url("cetak-resume-medis-rencana-kontrol/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                  <i class="fa fa-print"></i>
                                </a>
                              @endif
                            @else
                            -
                            @endif
                            <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                              <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                      <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                      </td>
                    </tr>
                @endforeach
              
              </tbody>
            </table>
          </div>
          @else
            <div class="col-md-6">
              <h5><b>Asesmen</b></h5>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                <h5><b>STATUS LOKALIS</b></h5>
                <thead>
                  <tr>
                    <th style="width: 40%; text-align: center;">Pemeriksaan</th>
                    <th style="width: 30%; text-align: center;">OD</th>
                    <th style="width: 30%; text-align: center;">OS</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1. Pemeriksaan Visus</td>
                    <td>
                      <input type="text" name="fisik[pemeriksaanVisus][od]" class="form-control" id="" value="{{ @$assesment['pemeriksaanVisus']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[pemeriksaanVisus][os]" class="form-control" id="" value="{{ @$assesment['pemeriksaanVisus']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>2. Pemeriksaan keseimbangan posisi bola mata</td>
                    <td>
                      <input type="text" name="fisik[keseimbanganBolaMata][od]" class="form-control" id="" value="{{ @$assesment['keseimbanganBolaMata']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[keseimbanganBolaMata][os]" class="form-control" id="" value="{{ @$assesment['keseimbanganBolaMata']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span>3. Pemeriksaan gerak bola mata</span><br>
                    </td>
                    <td>
                      <input type="text" name="fisik[gerakBolaMata][od]" class="form-control" id="" value="{{ @$assesment['gerakBolaMata']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[gerakBolaMata][os]" class="form-control" id="" value="{{ @$assesment['gerakBolaMata']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <a href="{{url('/emr-soap/penilaian/mata1/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat"><i class="fa fa-pencil"> </i> Isi Lokalis 1</a>&nbsp;&nbsp;
                      @if (@$gambar1->image != null)                    
                        <br>
                        <br>
                        <img src="/images/{{ @$gambar1['image'] }}" id="dataImage" style="width: 100%; height:100%;">
                      @else
                        <br>
                        <i>Status Lokalis 1 Belum Ada</i>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span>4. Pemeriksaan tekanan intraocular</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[tekananIntraocular][od]" class="form-control" id="" value="{{ @$assesment['tekananIntraocular']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[tekananIntraocular][os]" class="form-control" id="" value="{{ @$assesment['tekananIntraocular']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span>5. Pemeriksaan segmen anterior</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[segmenAnterior][od]" class="form-control" id="" value="{{ @$assesment['segmenAnterior']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[segmenAnterior][os]" class="form-control" id="" value="{{ @$assesment['segmenAnterior']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-left: 20px;">
                      <span>a. Palpebra</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[palpebra][od]" class="form-control" id="" value="{{ @$assesment['palpebra']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[palpebra][os]" class="form-control" id="" value="{{ @$assesment['palpebra']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-left: 20px;">
                      <span>b. Konjungtiva</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[konjungtiva][od]" class="form-control" id="" value="{{ @$assesment['konjungtiva']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[konjungtiva][os]" class="form-control" id="" value="{{ @$assesment['konjungtiva']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-left: 20px;">
                      <span>c. Kornea</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[kornea][od]" class="form-control" id="" value="{{ @$assesment['kornea']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[kornea][os]" class="form-control" id="" value="{{ @$assesment['kornea']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-left: 20px;">
                      <span>d. Bilik mata depan</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[bilikMataDepan][od]" class="form-control" id="" value="{{ @$assesment['bilikMataDepan']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[bilikMataDepan][os]" class="form-control" id="" value="{{ @$assesment['bilikMataDepan']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-left: 20px;">
                      <span>e. Iris</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[iris][od]" class="form-control" id="" value="{{ @$assesment['iris']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[iris][os]" class="form-control" id="" value="{{ @$assesment['iris']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-left: 20px;">
                      <span>f. Pupil</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[pupil][od]" class="form-control" id="" value="{{ @$assesment['pupil']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[pupil][os]" class="form-control" id="" value="{{ @$assesment['pupil']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-left: 20px;">
                      <span>g. Lensa</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[lensa][od]" class="form-control" id="" value="{{ @$assesment['lensa']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[lensa][os]" class="form-control" id="" value="{{ @$assesment['lensa']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span>6. Pemeriksaan lapang pandang</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[lapangPandang][od]" class="form-control" id="" value="{{ @$assesment['lapangPandang']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[lapangPandang][os]" class="form-control" id="" value="{{ @$assesment['lapangPandang']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span>7. Pemeriksaan funduskopi</span>
                    </td>
                    <td>
                      <input type="text" name="fisik[funduskopi][od]" class="form-control" id="" value="{{ @$assesment['funduskopi']['od'] }}">
                    </td>
                    <td>
                      <input type="text" name="fisik[funduskopi][os]" class="form-control" id="" value="{{ @$assesment['funduskopi']['os'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <a href="{{url('/emr-soap/penilaian/mata2/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat"><i class="fa fa-pencil"> </i> Isi Lokalis 2</a>&nbsp;&nbsp;
                      @if (@$gambar2->image != null)                    
                        <br>
                        <br>
                        <img src="/images/{{ @$gambar2['image'] }}" id="dataImage" style="width: 100%; height:100%;">
                      @else
                        <br>
                        <i>Status Lokalis 2 Belum Ada</i>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <input type="text" name="fisik[lokalis2][keterangan]" style="display: inline-block;" class="form-control" id="" value="{{ @$assesment['lokalis2']['keterangan'] }}" placeholder="Keterangan Lokalis 2">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <a href="{{url('/emr-soap/penilaian/mata3/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat"><i class="fa fa-pencil"> </i> Isi Lokalis 3</a>&nbsp;&nbsp;
                      @if (@$gambar3->image != null)                    
                        <br>
                        <br>
                        <img src="/images/{{ @$gambar3['image'] }}" id="dataImage" style="width: 100%; height:100%;">
                      @else
                        <br>
                        <i>Status Lokalis 3 Belum Ada</i>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <input type="text" name="fisik[lokalis3][keterangan]" style="display: inline-block;" class="form-control" id="" value="{{ @$assesment['lokalis3']['keterangan'] }}" placeholder="Keterangan Lokalis 3">
                    </td>
                  </tr>
                </tbody>
              </table>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                <tr>
                  <td style="width:25%; font-weight:bold;">Riwayat Alergi</td>
                  <td>
                    <input type="radio" id="riwayat_alergi1" name="fisik[riwayat_alergi][pilihan]" value="Tidak" {{@$assesment['riwayat_alergi']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                    <label for="riwayat_alergi1" style="font-weight: normal;">Tidak</label><br>
                    <input type="radio" id="riwayat_alergi2" name="fisik[riwayat_alergi][pilihan]" value="Ya" {{@$assesment['riwayat_alergi']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                    <label for="riwayat_alergi2" style="font-weight: normal;">Ya</label><br>
                    <input type="text" id="riwayat_alergi3" name="fisik[riwayat_alergi][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['riwayat_alergi']['sebutkan']}}">
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">Keluhan Utama</td>
                  <td>
                    <textarea name="fisik[keluhan_utama]" id="" rows="3" style="resize: vertical; display: inline-block;" class="form-control">{{@$assesment['keluhan_utama']}}</textarea>
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">1. Keadaan Umum</td>
                  <td>
                    <input type="checkbox" id="keadaanUmum_1" name="fisik[keadaanUmum][pilihan][tampak_tidak_sakit]" value="Tampak Tidak Sakit" {{ @$assesment['keadaanUmum']['pilihan']['tampak_tidak_sakit'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                    <label for="keadaanUmum_1" style="font-weight: normal; margin-right: 10px;">Tampak Tidak Sakit</label>
                    <input type="checkbox" id="keadaanUmum_2" name="fisik[keadaanUmum][pilihan][sakit_ringan]" value="Sakit Ringan" {{ @$assesment['keadaanUmum']['pilihan']['sakit_ringan'] == 'Sakit Ringan' ? 'checked' : '' }}>
                    <label for="keadaanUmum_2" style="font-weight: normal; margin-right: 10px;">Sakit Ringan</label><br/>
                    <input type="checkbox" id="keadaanUmum_3" name="fisik[keadaanUmum][pilihan][sakit_sedang]" value="Sakit Sedang" {{ @$assesment['keadaanUmum']['pilihan']['sakit_sedang'] == 'Sakit Sedang' ? 'checked' : '' }}>
                    <label for="keadaanUmum_3" style="font-weight: normal; margin-right: 10px;">Sakit Sedang</label>
                    <input type="checkbox" id="keadaanUmum_4" name="fisik[keadaanUmum][pilihan][sakit_berat]" value="Sakit Berat" {{ @$assesment['keadaanUmum']['pilihan']['sakit_berat'] == 'Sakit Berat' ? 'checked' : '' }}>
                    <label for="keadaanUmum_4" style="font-weight: normal; margin-right: 10px;">Sakit Berat</label>
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">2. Kesadaran</td>
                  <td>
                    <input type="checkbox" id="kesadaran_1" name="fisik[kesadaran][pilihan][compos_mentis]" value="Compos Mentis" {{ @$assesment['kesadaran']['pilihan']['compos_mentis'] == 'Compos Mentis' ? 'checked' : '' }}>
                    <label for="kesadaran_1" style="font-weight: normal; margin-right: 10px;">Compos Mentis</label>
                    <input type="checkbox" id="kesadaran_2" name="fisik[kesadaran][pilihan][apatis]" value="Apatis" {{ @$assesment['kesadaran']['pilihan']['apatis'] == 'Apatis' ? 'checked' : '' }}>
                    <label for="kesadaran_2" style="font-weight: normal; margin-right: 10px;">Apatis</label><br/>
                    <input type="checkbox" id="kesadaran_3" name="fisik[kesadaran][pilihan][somnolen]" value="Somnolen" {{ @$assesment['kesadaran']['pilihan']['somnolen'] == 'Somnolen' ? 'checked' : '' }}>
                    <label for="kesadaran_3" style="font-weight: normal; margin-right: 10px;">Somnolen</label>
                    <input type="checkbox" id="kesadaran_4" name="fisik[kesadaran][pilihan][sopor]" value="Sopor" {{ @$assesment['kesadaran']['pilihan']['sopor'] == 'Sopor' ? 'checked' : '' }}>
                    <label for="kesadaran_4" style="font-weight: normal; margin-right: 10px;">Sopor</label><br/>
                    <input type="checkbox" id="kesadaran_5" name="fisik[kesadaran][pilihan][coma]" value="Coma" {{ @$assesment['kesadaran']['pilihan']['coma'] == 'Coma' ? 'checked' : '' }}>
                    <label for="kesadaran_5" style="font-weight: normal; margin-right: 10px;">Coma</label>
                  </td>
                </tr>

                <tr>
                  <td rowspan="4" style="width:25%; font-weight:bold;">3. GCS</td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="margin-right: 20px;">E</label>
                    <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control gcs" id="" value="{{@$assesment['GCS']['E']}}">
                  </td>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label" style="margin-right: 20px;">M</label>
                      <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control gcs" id="" value="{{@$assesment['GCS']['M']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label" style="margin-right: 20px;">V</label>
                        <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control gcs" id="" value="{{@$assesment['GCS']['V']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                        <label class="form-check-label "  style="margin-right: 20px;">Total</label>
                        <input type="text" name="fisik[GCS][total]" style="display:inline-block; width: 100px;" placeholder="Total" class="form-control" id="gcsScore" readonly value="{{ @$assesment['GCS']['total'] }}">
                    </td>
                    </td>
                </tr>
                </tr>
                <script>
                    let gcs = document.getElementsByClassName('gcs');
                    let gcsScore = document.getElementById('gcsScore');
                    gcs = Array.from(gcs);
                    gcs.forEach(el => {
                        el.addEventListener('input', function(){
                            let gcsVal = 0;
                            gcs.forEach(x => {
                                let val = parseInt(x.value)
                                if(isNaN(val)){
                                    val = 0;
                                }
                                gcsVal += val;
                            })
                            gcsScore.value = gcsVal;
                        })
                    });
                </script>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:bold;">4. Tanda Vital</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                    <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['tekanan_darah']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['nadi']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['RR']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                    <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['temp']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                    <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['BB']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                    <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['TB']}}">
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="font-weight:bold;">5. Assesmen Nyeri</td>
                </tr>
                <tr>
                  <td>
                    <input type="radio" id="nyeri_1" name="fisik[nyeri][pilihan]" value="Tidak" {{@$assesment['nyeri']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                    <label for="nyeri_1" style="font-weight: normal;">Tidak</label><br>
                  </td>
                  <td>
                    <input type="radio" id="nyeri_2" name="fisik[nyeri][pilihan]" value="Ada" {{@$assesment['nyeri']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                    <label for="nyeri_2" style="font-weight: normal;">Ada (Lanjut Ke Deskripsi Nyeri)</label><br>
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">- Provokatif</td>
                  <td>
                    <input type="radio" id="provokatif_1" name="fisik[nyeri][provokatif][pilihan]" value="Bantuan" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Bantuan' ? 'checked' : ''}}>
                    <label for="provokatif_1" style="font-weight: normal;">Bantuan</label>
                    <input type="radio" id="provokatif_2" name="fisik[nyeri][provokatif][pilihan]" value="Spontan" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Spontan' ? 'checked' : ''}}>
                    <label for="provokatif_2" style="font-weight: normal;">Spontan</label>
                    <input type="radio" id="provokatif_3" name="fisik[nyeri][provokatif][pilihan]" value="Lain-Lain" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="provokatif_3" style="font-weight: normal;">Lain-Lain</label>
                    <input type="text" id="provokatif_4" name="fisik[nyeri][provokatif][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['nyeri']['provokatif']['sebutkan']}}">
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">- Quality</td>
                  <td>
                    <input type="checkbox" id="quality_1" name="fisik[nyeri][quality][pilihan][tertusuk]" value="Seperti Tertusuk" {{@$assesment['nyeri']['quality']['pilihan']['tertusuk'] == 'Seperti Tertusuk' ? 'checked' : ''}}>
                    <label for="quality_1" style="font-weight: normal;">Seperti Tertusuk Benda Tajam/Tumpul</label><br/>
                    <input type="checkbox" id="quality_2" name="fisik[nyeri][quality][pilihan][berdenyut]" value="Berdenyut" {{@$assesment['nyeri']['quality']['pilihan']['berdenyut'] == 'Berdenyut' ? 'checked' : ''}}>
                    <label for="quality_2" style="font-weight: normal;">Berdenyut</label><br/>
                    <input type="checkbox" id="quality_3" name="fisik[nyeri][quality][pilihan][terbakar]" value="Terbakar" {{@$assesment['nyeri']['quality']['pilihan']['terbakar'] == 'Terbakar' ? 'checked' : ''}}>
                    <label for="quality_3" style="font-weight: normal;">Terbakar</label><br/>
                    <input type="checkbox" id="quality_4" name="fisik[nyeri][quality][pilihan][teriris]" value="Teriris" {{@$assesment['nyeri']['quality']['pilihan']['teriris'] == 'Teriris' ? 'checked' : ''}}>
                    <label for="quality_4" style="font-weight: normal;">Teriris</label><br/>
                    <input type="checkbox" id="quality_5" name="fisik[nyeri][quality][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['nyeri']['quality']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="quality_5" style="font-weight: normal;">Lain-Lain</label><br/>
                    <input type="text" id="quality_6" name="fisik[nyeri][quality][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['nyeri']['quality']['sebutkan']}}">
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">- Region</td>
                  <td>
                    <label class="form-check-label" style="font-weight: normal;">Terlokalisir di</label><br/>
                    <input type="text" name="fisik[nyeri][region][terlokalisir]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['nyeri']['region']['terlokalisir']}}"><br/>
                    <label class="form-check-label" style="font-weight: normal;">Menyebar ke</label><br/>
                    <input type="text" name="fisik[nyeri][region][menyebar]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['nyeri']['region']['menyebar']}}"><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="text-align:center; font-weight:bold;">
                    <p style="text-align: left;">- Severity</p>
                    <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 300px; height: 150px; padding-bottom: 10px;"><br/>
                    <input type="radio" id="severity_1" name="fisik[nyeri][severity][pilihan]" value="0" {{@$assesment['nyeri']['severity']['pilihan'] == '0' ? 'checked' : ''}}>
                    <label for="severity_1" style="font-weight: normal;">0</label>
                    <input type="radio" id="severity_2" name="fisik[nyeri][severity][pilihan]" value="1-3" style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '1-3' ? 'checked' : ''}}>
                    <label for="severity_2" style="font-weight: normal;">1-3</label>
                    <input type="radio" id="severity_3" name="fisik[nyeri][severity][pilihan]" value="4-6"  style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '4-6' ? 'checked' : ''}}>
                    <label for="severity_3" style="font-weight: normal;">4-6</label>
                    <input type="radio" id="severity_4" name="fisik[nyeri][severity][pilihan]" value="7-9"  style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '7-9' ? 'checked' : ''}}>
                    <label for="severity_4" style="font-weight: normal;">7-9</label>
                    <input type="radio" id="severity_5" name="fisik[nyeri][severity][pilihan]" value="10" style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '10' ? 'checked' : ''}}>
                    <label for="severity_5" style="font-weight: normal;">10</label>
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">- Time / Durasi (Menit)</td>
                  <td>
                    <input type="number" name="fisik[nyeri][durasi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['nyeri']['durasi']}}">
                  </td>
                </tr>

                <tr>
                  <td style="width:25%; font-weight:bold;">- Nyeri Hilang Jika</td>
                  <td>
                    <input type="checkbox" id="nyeri_hilang_1" name="fisik[nyeri][nyeri_hilang][pilihan][minum_obat]" value="Minum Obat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['minum_obat'] == 'Minum Obat' ? 'checked' : '' }}>
                    <label for="nyeri_hilang_1" style="font-weight: normal;">Minum Obat</label><br/>
                    <input type="checkbox" id="nyeri_hilang_2" name="fisik[nyeri][nyeri_hilang][pilihan][istirahat]" value="Istirahat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['istirahat'] == 'Istirahat' ? 'checked' : '' }}>
                    <label for="nyeri_hilang_2" style="font-weight: normal;">Istirahat</label><br/>
                    <input type="checkbox" id="nyeri_hilang_3" name="fisik[nyeri][nyeri_hilang][pilihan][berubah_posisi]" value="Berubah Posisi" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['berubah_posisi'] == 'Berubah Posisi' ? 'checked' : '' }}>
                    <label for="nyeri_hilang_3" style="font-weight: normal;">Berubah Posisi</label><br/>
                    <input type="checkbox" id="nyeri_hilang_4" name="fisik[nyeri][nyeri_hilang][pilihan][mendengarkan_musik]" value="Mendengarkan Musik" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['mendengarkan_musik'] == 'Mendengarkan Musik' ? 'checked' : '' }}>
                    <label for="nyeri_hilang_4" style="font-weight: normal;">Mendengarkan Musik</label><br/>
                    <input type="checkbox" id="nyeri_hilang_5" name="fisik[nyeri][nyeri_hilang][pilihan][lain]" value="Lain-Lain" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                    <label for="nyeri_hilang_5" style="font-weight: normal;">Lain-Lain</label><br/>
                    <input type="text" id="nyeri_hilang_6" name="fisik[nyeri][nyeri_hilang][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['nyeri']['nyeri_hilang']['sebutkan'] }}">
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="font-weight:bold;">6. Risiko Jatuh</td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Apakah ada riwayat jatuh dalam waktu 3 bulan sebab apapun</td>
                  <td>
                      <div style="display: flex; gap: 10px; flex-wrap: wrap">
                          <div>
                              <input class="hitungResiko" type="radio" id="riwayatJatuh_1" name="fisik[risikoJatuh][riwayatJatuh][pilihan]" value="25" {{@$assesment['risikoJatuh']['riwayatJatuh']['pilihan'] == '25' ? 'checked' : ''}}>
                              <label for="riwayatJatuh_1" style="font-weight: normal;">Ya <b>(25 Skor)</b></label><br/>
                          </div>
                          <div>
                              <input class="hitungResiko" type="radio" id="riwayatJatuh_2" name="fisik[risikoJatuh][riwayatJatuh][pilihan]" value="0" {{@$assesment['risikoJatuh']['riwayatJatuh']['pilihan'] == '0' ? 'checked' : ''}}>
                              <label for="riwayatJatuh_2" style="font-weight: normal;">Tidak <b>(0 Skor)</b></label><br/>
                          </div>
                      </div>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Diagnosis sekunder : Apakah memiliki lebih dari satu penyakit</td>
                  <td>
                      <div style="display: flex; gap: 10px; flex-wrap: wrap">
                          <div>
                              <input class="hitungResiko" type="radio" id="diagnosisSekunder_1" name="fisik[risikoJatuh][diagnosisSekunder][pilihan]" value="15" {{@$assesment['risikoJatuh']['diagnosisSekunder']['pilihan'] == '15' ? 'checked' : ''}}>
                              <label for="diagnosisSekunder_1" style="font-weight: normal;">Ya <b>(15 Skor)</b></label><br/>
                          </div>
                          <div>
                              <input class="hitungResiko" type="radio" id="diagnosisSekunder_2" name="fisik[risikoJatuh][diagnosisSekunder][pilihan]" value="0" {{@$assesment['risikoJatuh']['diagnosisSekunder']['pilihan'] == '0' ? 'checked' : ''}}>
                              <label for="diagnosisSekunder_2" style="font-weight: normal;">Tidak <b>(0 Skor)</b></label><br/>
                          </div>
                      </div>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Alat bantu berjalan</td>
                  <td>
                    <input class="hitungResiko" type="radio" id="alatBantu_1" name="fisik[risikoJatuh][alatBantu][pilihan]" value="0" {{@$assesment['risikoJatuh']['alatBantu']['pilihan'] == '0' ? 'checked' : ''}}>
                    <label for="alatBantu_1" style="font-weight: normal;">Dibantu perawat/tidak menggunakan alat bantu/bed rest <b>(0 Skor)</b></label><br/>
                    <input class="hitungResiko" type="radio" id="alatBantu_2" name="fisik[risikoJatuh][alatBantu][pilihan]" value="15" {{@$assesment['risikoJatuh']['alatBantu']['pilihan'] == '15' ? 'checked' : ''}}>
                    <label for="alatBantu_2" style="font-weight: normal;">Menggunakan alat bantu : kruk/tongka, kursi roda <b>(15 Skor)</b></label><br/>
                    <input class="hitungResiko" type="radio" id="alatBantu_3" name="fisik[risikoJatuh][alatBantu][pilihan]" value="30" {{@$assesment['risikoJatuh']['alatBantu']['pilihan'] == '30' ? 'checked' : ''}}>
                    <label for="alatBantu_3" style="font-weight: normal;">Merambat dengan berpegangan pada benda di sekitar (meja, kursi, lemari, dll) <b>(30 Skor)</b></label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Apakah terpasang infus/pemberian anti koagulan (heparin)/obat lain yang mempunyai efek samping risiko jatuh</td>
                  <td>
                      <div style="display: flex; gap: 10px; flex-wrap: wrap">
                          <div>
                              <input class="hitungResiko" type="radio" id="efekSamping_1" name="fisik[risikoJatuh][efekSamping][pilihan]" value="20" {{@$assesment['risikoJatuh']['efekSamping']['pilihan'] == '20' ? 'checked' : ''}}>
                              <label for="efekSamping_1" style="font-weight: normal;">Ya <b>(20 Skor)</b></label><br/>
                          </div>
                          <div>
                              <input class="hitungResiko" type="radio" id="efekSamping_2" name="fisik[risikoJatuh][efekSamping][pilihan]" value="0" {{@$assesment['risikoJatuh']['efekSamping']['pilihan'] == '0' ? 'checked' : ''}}>
                              <label for="efekSamping_2" style="font-weight: normal;">Tidak <b>(0 Skor)</b></label><br/>
                          </div>
                      </div>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Kondisi untuk melakukan gerakan berpindah / mobilisasi</td>
                  <td>
                    <input class="hitungResiko" type="radio" id="mobilisasi_1" name="fisik[risikoJatuh][mobilisasi][pilihan]" value="0" {{@$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '0' ? 'checked' : ''}}>
                    <label for="mobilisasi_1" style="font-weight: normal;">Normal/bed rest/Imobilisasi <b>(0 Skor)</b></label><br/>
                    <input class="hitungResiko" type="radio" id="mobilisasi_2" name="fisik[risikoJatuh][mobilisasi][pilihan]" value="15" {{@$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '15' ? 'checked' : ''}}>
                    <label for="mobilisasi_2" style="font-weight: normal;">Lemah (tidak bertenaga) <b>(15 Skor)</b></label><br/>
                    <input class="hitungResiko" type="radio" id="mobilisasi_3" name="fisik[risikoJatuh][mobilisasi][pilihan]" value="30" {{@$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '30' ? 'checked' : ''}}>
                    <label for="mobilisasi_3" style="font-weight: normal;">Ada keterbatasan berjalan (pincang, diseret) <b>(30 Skor)</b></label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Bagaimana Status Mental</td>
                  <td>
                    <input class="hitungResiko" type="radio" id="statusMental_1" name="fisik[risikoJatuh][statusMental][pilihan]" value="0" {{@$assesment['risikoJatuh']['statusMental']['pilihan'] == '0' ? 'checked' : ''}}>
                    <label for="statusMental_1" style="font-weight: normal;">Menyadari kelemahannya <b>(0 Skor)</b></label><br/>
                    <input class="hitungResiko" type="radio" id="statusMental_2" name="fisik[risikoJatuh][statusMental][pilihan]" value="15" {{@$assesment['risikoJatuh']['statusMental']['pilihan'] == '15' ? 'checked' : ''}}>
                    <label for="statusMental_2" style="font-weight: normal;">Tidak menyadari kelemahannya <b>(15 Skor)</b></label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">JUMLAH SKOR</td>
                  <td>
                    <input type="number" name="fisik[risikoJatuh][jumlahSkor][angka]" style="display:inline-block; width: 100%;" class="form-control jumlahSkorResiko" id="" value="{{@$assesment['risikoJatuh']['jumlahSkor']['angka']}}" readonly>
                    <br><br>
                    <input type="text" name="fisik[risikoJatuh][jumlahSkor][hasil]" style="display:inline-block; width: 100%;" class="form-control hasilSkorResiko" id="" value="{{@$assesment['risikoJatuh']['jumlahSkor']['hasil']}}" readonly>
                  </td>
                </tr>
                {{-- <tr>
                  <td colspan="2" style="text-align:center; font-weight:bold;">
                    <input type="radio" id="penilaian_1" name="fisik[risikoJatuh][penilaian][pilihan]" value="Tidak Berisiko" {{@$assesment['risikoJatuh']['penilaian']['pilihan'] == 'Tidak Berisiko' ? 'checked' : ''}}>
                    <label for="penilaian_1" style="font-weight: normal;">0-24 Tidak Berisiko</label>
                    <input type="radio" id="penilaian_2" name="fisik[risikoJatuh][penilaian][pilihan]" value="Risiko Rendah" style="margin-left: 25px;" {{@$assesment['risikoJatuh']['penilaian']['pilihan'] == 'Risiko Rendah' ? 'checked' : ''}}>
                    <label for="penilaian_2" style="font-weight: normal;">25-50 Risiko Rendah</label>
                    <input type="radio" id="penilaian_3" name="fisik[risikoJatuh][penilaian][pilihan]" value="Risiko Tinggi"  style="margin-left: 25px;" {{@$assesment['risikoJatuh']['penilaian']['pilihan'] == 'Risiko Tinggi' ? 'checked' : ''}}>
                    <label for="penilaian_3" style="font-weight: normal;">> 51 Risiko Tinggi</label>
                  </td>
                </tr> --}}

                <tr>
                  <td colspan="2" style="font-weight:bold;">7. Fungsional</td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Alat Bantu</td>
                  <td>
                    <input type="radio" id="alatBantu_1" name="fisik[fungsional][alatBantu][pilihan]" value="Ya" {{@$assesment['fungsional']['alatBantu']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                    <label for="alatBantu_1" style="font-weight: normal;">Ya</label><br/>
                    <input type="radio" id="alatBantu_2" name="fisik[fungsional][alatBantu][pilihan]" value="Tidak" {{@$assesment['fungsional']['alatBantu']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                    <label for="alatBantu_2" style="font-weight: normal;">Tidak</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Protesa</td>
                  <td>
                    <input type="radio" id="protesa_1" name="fisik[fungsional][protesa][pilihan]" value="Ya" {{@$assesment['fungsional']['protesa']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                    <label for="protesa_1" style="font-weight: normal;">Ya</label><br/>
                    <input type="radio" id="protesa_2" name="fisik[fungsional][protesa][pilihan]" value="Tidak" {{@$assesment['fungsional']['protesa']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                    <label for="protesa_2" style="font-weight: normal;">Tidak</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Cacat Tubuh</td>
                  <td>
                    <input type="radio" id="cacatTubuh_1" name="fisik[fungsional][cacatTubuh][pilihan]" value="Ya" {{@$assesment['fungsional']['cacatTubuh']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                    <label for="cacatTubuh_1" style="font-weight: normal;">Ya</label><br/>
                    <input type="radio" id="cacatTubuh_2" name="fisik[fungsional][cacatTubuh][pilihan]" value="Tidak" {{@$assesment['fungsional']['cacatTubuh']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                    <label for="cacatTubuh_2" style="font-weight: normal;">Tidak</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Activity of Daily Living (ADL)</td>
                  <td>
                    <input type="radio" id="adl_1" name="fisik[fungsional][adl][pilihan]" value="Mandiri" {{@$assesment['fungsional']['adl']['pilihan'] == 'Mandiri' ? 'checked' : ''}}>
                    <label for="adl_1" style="font-weight: normal;">Mandiri</label><br/>
                    <input type="radio" id="adl_2" name="fisik[fungsional][adl][pilihan]" value="Dibantu" {{@$assesment['fungsional']['adl']['pilihan'] == 'Dibantu' ? 'checked' : ''}}>
                    <label for="adl_2" style="font-weight: normal;">Dibantu</label><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="font-weight:bold;">PEMERIKSAAN FISIK</td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Pernyarafan</td>
                  <td>
                    <input type="checkbox" id="pernyarafan_1" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][tidak_ada]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['tidak_ada'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="pernyarafan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                    <input type="checkbox" id="pernyarafan_2" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][tremor]" value="Tremor" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['tremor'] == 'Tremor' ? 'checked' : ''}}>
                    <label for="pernyarafan_2" style="font-weight: normal;">Tremor</label><br/>
                    <input type="checkbox" id="pernyarafan_3" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][hemiparase]" value="Hemiparase" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['hemiparase'] == 'Hemiparase' ? 'checked' : ''}}>
                    <label for="pernyarafan_3" style="font-weight: normal;">Hemiparase/Hemiplegia</label><br/>
                    <input type="checkbox" id="pernyarafan_4" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][rom]" value="ROM" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['rom'] == 'ROM' ? 'checked' : ''}}>
                    <label for="pernyarafan_4" style="font-weight: normal;">ROM</label><br/>
                    <input type="checkbox" id="pernyarafan_5" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][paralise]" value="Paralise" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['paralise'] == 'Paralise' ? 'checked' : ''}}>
                    <label for="pernyarafan_5" style="font-weight: normal;">Paralise</label><br/>
                    <input type="checkbox" id="pernyarafan_6" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="pernyarafan_6" style="font-weight: normal;">Lain-Lain</label><br/>
                    <input type="text" id="pernyarafan_7" name="fisik[pemeriksaanFisik][pernyarafan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['pernyarafan']['sebutkan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Pernapasan</td>
                  <td>
                    <input type="checkbox" id="pernapasan_1" name="fisik[pemeriksaanFisik][pernapasan][pilihan][tidak_ada]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['tidak_ada'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="pernapasan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                    <input type="checkbox" id="pernapasan_2" name="fisik[pemeriksaanFisik][pernapasan][pilihan][sekret]" value="Sekret" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['sekret'] == 'Sekret' ? 'checked' : ''}}>
                    <label for="pernapasan_2" style="font-weight: normal;">Sekret (+)</label><br/>
                    <input type="checkbox" id="pernapasan_3" name="fisik[pemeriksaanFisik][pernapasan][pilihan][vesikular]" value="Vesikular" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['vesikular'] == 'Vesikular' ? 'checked' : ''}}>
                    <label for="pernapasan_3" style="font-weight: normal;">Vesikular</label><br/>
                    <input type="checkbox" id="pernapasan_4" name="fisik[pemeriksaanFisik][pernapasan][pilihan][ronchi]" value="Ronchi" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['ronchi'] == 'Ronchi' ? 'checked' : ''}}>
                    <label for="pernapasan_4" style="font-weight: normal;">Ronchi</label><br/>
                    <input type="checkbox" id="pernapasan_5" name="fisik[pemeriksaanFisik][pernapasan][pilihan][wheezing]" value="Wheezing" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['wheezing'] == 'Wheezing' ? 'checked' : ''}}>
                    <label for="pernapasan_5" style="font-weight: normal;">Wheezing</label><br/>
                    <input type="checkbox" id="pernapasan_6" name="fisik[pemeriksaanFisik][pernapasan][pilihan][otot_bantu]" value="Menggunakan Otot Bantu" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['otot_bantu'] == 'Menggunakan Otot Bantu' ? 'checked' : ''}}>
                    <label for="pernapasan_6" style="font-weight: normal;">Menggunakan Otot Bantu</label><br/>
                    <input type="checkbox" id="pernapasan_7" name="fisik[pemeriksaanFisik][pernapasan][pilihan][retraksi_dada]" value="Retraksi Dada" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['retraksi_dada'] == 'Retraksi Dada' ? 'checked' : ''}}>
                    <label for="pernapasan_7" style="font-weight: normal;">Retraksi Dada / Inter Costa</label><br/>
                    <input type="checkbox" id="pernapasan_8" name="fisik[pemeriksaanFisik][pernapasan][pilihan][pernapasan_dada]" value="Pernapasan Dada" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['pernapasan_dada'] == 'Pernapasan Dada' ? 'checked' : ''}}>
                    <label for="pernapasan_8" style="font-weight: normal;">Pernapasan Dada</label><br/>
                    <input type="checkbox" id="pernapasan_9" name="fisik[pemeriksaanFisik][pernapasan][pilihan][pernapasan_perut]" value="Pernapasan Perut" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['pernapasan_perut'] == 'Pernapasan Perut' ? 'checked' : ''}}>
                    <label for="pernapasan_9" style="font-weight: normal;">Pernapasan Perut</label><br/>
                    <input type="checkbox" id="pernapasan_10" name="fisik[pemeriksaanFisik][pernapasan][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="pernapasan_10" style="font-weight: normal;">Lain-Lain</label><br/>
                    <input type="text" id="pernapasan_11" name="fisik[pemeriksaanFisik][pernapasan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['pernapasan']['sebutkan']}}">
                  </td>
                </tr>

              </table>
            </div>

            <div class="col-md-6">
              <h5><b>Asesmen</b></h5>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width:25%; font-weight:500;">Kardiovaskuler</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="kardiovaskuler_1" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][tidak_ada]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['tidak_ada'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="checkbox" id="kardiovaskuler_2" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][oedema]" value="Oedema" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['oedema'] == 'Oedema' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_2" style="font-weight: normal; margin-right: 10px;">Oedema</label>
                    <input type="checkbox" id="kardiovaskuler_3" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][murmur]" value="Murmur" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['murmur'] == 'Murmur' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_3" style="font-weight: normal; margin-right: 10px;">Murmur</label><br/>
                    <input type="checkbox" id="kardiovaskuler_4" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][chest_pain]" value="Chest Pain" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['chest_pain'] == 'Chest Pain' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_4" style="font-weight: normal; margin-right: 10px;">Chest Pain</label>
                    <input type="checkbox" id="kardiovaskuler_5" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][reguler]" value="Reguler" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['reguler'] == 'Reguler' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_5" style="font-weight: normal; margin-right: 10px;">Reguler</label>
                    <input type="checkbox" id="kardiovaskuler_6" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][ireguler]" value="Ireguler" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['ireguler'] == 'Ireguler' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_6" style="font-weight: normal; margin-right: 10px;">Ireguler</label><br/>
                    <input type="checkbox" id="kardiovaskuler_7" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][gallop]" value="Gallop" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['gallop'] == 'Gallop' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_7" style="font-weight: normal; margin-right: 10px;">Gallop</label>
                    <input type="checkbox" id="kardiovaskuler_8" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][crt_more_lower_2]" value="CRT < 2" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['crt_more_lower_2'] == 'CRT < 2' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_8" style="font-weight: normal; margin-right: 10px;">CRT < 2</label>
                    <input type="checkbox" id="kardiovaskuler_9" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][crt_more_higher_2]" value="CRT > 2" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['crt_more_higher_2'] == 'CRT > 2' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_9" style="font-weight: normal; margin-right: 10px;">CRT > 2</label><br/>
                    <input type="checkbox" id="kardiovaskuler_10" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="kardiovaskuler_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="kardiovaskuler_11" name="fisik[pemeriksaanFisik][kardiovaskuler][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['kardiovaskuler']['sebutkan']}}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Pencernaan</td>
                  <td style="text-align: center;">
                      <input type="checkbox" id="pencernaan_1" name="fisik[pemeriksaanFisik][pencernaan][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="pencernaan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="pencernaan_2" name="fisik[pemeriksaanFisik][pencernaan][pilihan][konstipasi]" value="Konstipasi" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['konstipasi'] == 'Konstipasi' ? 'checked' : '' }}>
                      <label for="pencernaan_2" style="font-weight: normal; margin-right: 10px;">Konstipasi</label>
                      <input type="checkbox" id="pencernaan_3" name="fisik[pemeriksaanFisik][pencernaan][pilihan][diare]" value="Diare" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['diare'] == 'Diare' ? 'checked' : '' }}>
                      <label for="pencernaan_3" style="font-weight: normal; margin-right: 10px;">Diare</label><br/>
                      <input type="checkbox" id="pencernaan_4" name="fisik[pemeriksaanFisik][pencernaan][pilihan][mual_muntah]" value="Mual / Muntah" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['mual_muntah'] == 'Mual / Muntah' ? 'checked' : '' }}>
                      <label for="pencernaan_4" style="font-weight: normal; margin-right: 10px;">Mual / Muntah</label>
                      <input type="checkbox" id="pencernaan_5" name="fisik[pemeriksaanFisik][pencernaan][pilihan][anoreksia]" value="Anoreksia" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['anoreksia'] == 'Anoreksia' ? 'checked' : '' }}>
                      <label for="pencernaan_5" style="font-weight: normal; margin-right: 10px;">Anoreksia</label><br/>
                      <input type="checkbox" id="pencernaan_6" name="fisik[pemeriksaanFisik][pencernaan][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="pencernaan_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="pencernaan_7" name="fisik[pemeriksaanFisik][pencernaan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['pencernaan']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Endokrin</td>
                  <td style="text-align: center;">
                      <input type="checkbox" id="endokrin_1" name="fisik[pemeriksaanFisik][endokrin][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="endokrin_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="endokrin_2" name="fisik[pemeriksaanFisik][endokrin][pilihan][pembesaran_kelenjar]" value="Pembesaran Kelenjar" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['pembesaran_kelenjar'] == 'Pembesaran Kelenjar' ? 'checked' : '' }}>
                      <label for="endokrin_2" style="font-weight: normal; margin-right: 10px;">Pembesaran Kelenjar</label><br/>
                      <input type="checkbox" id="endokrin_3" name="fisik[pemeriksaanFisik][endokrin][pilihan][tiroid]" value="Tiroid" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['tiroid'] == 'Tiroid' ? 'checked' : '' }}>
                      <label for="endokrin_3" style="font-weight: normal; margin-right: 10px;">Tiroid</label>
                      <input type="checkbox" id="endokrin_4" name="fisik[pemeriksaanFisik][endokrin][pilihan][keringat_banyak]" value="Keringat Banyak" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['keringat_banyak'] == 'Keringat Banyak' ? 'checked' : '' }}>
                      <label for="endokrin_4" style="font-weight: normal; margin-right: 10px;">Keringat Banyak</label><br/>
                      <input type="checkbox" id="endokrin_5" name="fisik[pemeriksaanFisik][endokrin][pilihan][napas_bau]" value="Napas Bau" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['napas_bau'] == 'Napas Bau' ? 'checked' : '' }}>
                      <label for="endokrin_5" style="font-weight: normal; margin-right: 10px;">Napas Bau</label>
                      <input type="checkbox" id="endokrin_6" name="fisik[pemeriksaanFisik][endokrin][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="endokrin_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="endokrin_7" name="fisik[pemeriksaanFisik][endokrin][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['endokrin']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Reproduksi</td>
                  <td style="text-align: center;">
                      <input type="checkbox" id="reproduksi_1" name="fisik[pemeriksaanFisik][reproduksi][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="reproduksi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="reproduksi_2" name="fisik[pemeriksaanFisik][reproduksi][pilihan][keputihan]" value="Keputihan" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['keputihan'] == 'Keputihan' ? 'checked' : '' }}>
                      <label for="reproduksi_2" style="font-weight: normal; margin-right: 10px;">Keputihan</label><br/>
                      <input type="checkbox" id="reproduksi_3" name="fisik[pemeriksaanFisik][reproduksi][pilihan][haid_tidak_teratur]" value="Haid Tidak Teratur" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['haid_tidak_teratur'] == 'Haid Tidak Teratur' ? 'checked' : '' }}>
                      <label for="reproduksi_3" style="font-weight: normal; margin-right: 10px;">Haid Tidak Teratur</label>
                      <input type="checkbox" id="reproduksi_4" name="fisik[pemeriksaanFisik][reproduksi][pilihan][tidak_haid]" value="Tidak Haid" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['tidak_haid'] == 'Tidak Haid' ? 'checked' : '' }}>
                      <label for="reproduksi_4" style="font-weight: normal; margin-right: 10px;">Tidak Haid</label><br/>
                      <input type="checkbox" id="reproduksi_5" name="fisik[pemeriksaanFisik][reproduksi][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="reproduksi_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="reproduksi_6" name="fisik[pemeriksaanFisik][reproduksi][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['reproduksi']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Abdomen</td>
                  <td style="text-align: center;">
                      <input type="checkbox" id="abdomen_1" name="fisik[pemeriksaanFisik][abdomen][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="abdomen_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="abdomen_2" name="fisik[pemeriksaanFisik][abdomen][pilihan][membesar]" value="Membesar" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['membesar'] == 'Membesar' ? 'checked' : '' }}>
                      <label for="abdomen_2" style="font-weight: normal; margin-right: 10px;">Membesar</label>
                      <input type="checkbox" id="abdomen_3" name="fisik[pemeriksaanFisik][abdomen][pilihan][distensi]" value="Distensi" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['distensi'] == 'Distensi' ? 'checked' : '' }}>
                      <label for="abdomen_3" style="font-weight: normal; margin-right: 10px;">Distensi</label><br/>
                      <input type="checkbox" id="abdomen_4" name="fisik[pemeriksaanFisik][abdomen][pilihan][nyeri_tekan]" value="Nyeri Tekan" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['nyeri_tekan'] == 'Nyeri Tekan' ? 'checked' : '' }}>
                      <label for="abdomen_4" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                      <input type="checkbox" id="abdomen_5" name="fisik[pemeriksaanFisik][abdomen][pilihan][luka]" value="Luka" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['luka'] == 'Luka' ? 'checked' : '' }}>
                      <label for="abdomen_5" style="font-weight: normal; margin-right: 10px;">Luka</label>
                      <input type="checkbox" id="abdomen_6" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_i]" value="L I" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_i'] == 'L I' ? 'checked' : '' }}>
                      <label for="abdomen_6" style="font-weight: normal; margin-right: 10px;">L I</label><br/>
                      <input type="checkbox" id="abdomen_7" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_ii]" value="L II" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_ii'] == 'L II' ? 'checked' : '' }}>
                      <label for="abdomen_7" style="font-weight: normal; margin-right: 10px;">L II</label>
                      <input type="checkbox" id="abdomen_8" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_iii]" value="L III" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_iii'] == 'L III' ? 'checked' : '' }}>
                      <label for="abdomen_8" style="font-weight: normal; margin-right: 10px;">L III</label>
                      <input type="checkbox" id="abdomen_9" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_iv]" value="L IV" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_iv'] == 'L IV' ? 'checked' : '' }}>
                      <label for="abdomen_9" style="font-weight: normal; margin-right: 10px;">L IV</label><br/>
                      <input type="checkbox" id="abdomen_10" name="fisik[pemeriksaanFisik][abdomen][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="abdomen_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="abdomen_11" name="fisik[pemeriksaanFisik][abdomen][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['abdomen']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Kulit</td>
                  <td style="text-align: center;">
                      <input type="checkbox" id="kulit_1" name="fisik[pemeriksaanFisik][kulit][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="kulit_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="kulit_2" name="fisik[pemeriksaanFisik][kulit][pilihan][turgor_tidak_baik]" value="Turgor" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['turgor_tidak_baik'] == 'Turgor' ? 'checked' : '' }}>
                      <label for="kulit_2" style="font-weight: normal; margin-right: 10px;">Turgor Tidak Baik</label><br/>
                      <input type="checkbox" id="kulit_3" name="fisik[pemeriksaanFisik][kulit][pilihan][perubahan_warna]" value="Perubahan Warna" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['perubahan_warna'] == 'Perubahan Warna' ? 'checked' : '' }}>
                      <label for="kulit_3" style="font-weight: normal; margin-right: 10px;">Perubahan Warna</label>
                      <input type="checkbox" id="kulit_4" name="fisik[pemeriksaanFisik][kulit][pilihan][terdapat_lecet]" value="Terdapat Lecet" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['terdapat_lecet'] == 'Terdapat Lecet' ? 'checked' : '' }}>
                      <label for="kulit_4" style="font-weight: normal; margin-right: 10px;">Terdapat Lecet</label><br/>
                      <input type="checkbox" id="kulit_5" name="fisik[pemeriksaanFisik][kulit][pilihan][terdapat_luka]" value="Terdapat Luka" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['terdapat_luka'] == 'Terdapat Luka' ? 'checked' : '' }}>
                      <label for="kulit_5" style="font-weight: normal; margin-right: 10px;">Terdapat Luka</label><br/>
                      <input type="checkbox" id="kulit_6" name="fisik[pemeriksaanFisik][kulit][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="kulit_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="kulit_7" name="fisik[pemeriksaanFisik][kulit][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['kulit']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Mata</td>
                  <td style="text-align: center;">
                      <input type="checkbox" id="mata_1" name="fisik[pemeriksaanFisik][mata][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="mata_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="mata_2" name="fisik[pemeriksaanFisik][mata][pilihan][kuning]" value="Kuning" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['kuning'] == 'Kuning' ? 'checked' : '' }}>
                      <label for="mata_2" style="font-weight: normal; margin-right: 10px;">Kuning</label>
                      <input type="checkbox" id="mata_3" name="fisik[pemeriksaanFisik][mata][pilihan][pucat]" value="Pucat" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['pucat'] == 'Pucat' ? 'checked' : '' }}>
                      <label for="mata_3" style="font-weight: normal; margin-right: 10px;">Pucat</label><br/>
                      <input type="checkbox" id="mata_4" name="fisik[pemeriksaanFisik][mata][pilihan][vod]" value="VOD" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['vod'] == 'VOD' ? 'checked' : '' }}>
                      <label for="mata_4" style="font-weight: normal; margin-right: 10px;">VOD (Visus Ocula Dektra)</label>
                      <input type="checkbox" id="mata_5" name="fisik[pemeriksaanFisik][mata][pilihan][vos]" value="VOS" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['vos'] == 'VOS' ? 'checked' : '' }}>
                      <label for="mata_5" style="font-weight: normal; margin-right: 10px;">VOS (Visus Okula Sinistra)</label><br/>
                      <input type="checkbox" id="mata_6" name="fisik[pemeriksaanFisik][mata][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="mata_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="mata_7" name="fisik[pemeriksaanFisik][mata][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['mata']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Genetalia</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="genetalia_1" name="fisik[pemeriksaanFisik][genetalia][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                    <label for="genetalia_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="checkbox" id="genetalia_2" name="fisik[pemeriksaanFisik][genetalia][pilihan][nyeri_tekan]" value="Nyeri Tekan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['nyeri_tekan'] == 'Nyeri Tekan' ? 'checked' : '' }}>
                    <label for="genetalia_2" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                    <input type="checkbox" id="genetalia_3" name="fisik[pemeriksaanFisik][genetalia][pilihan][benjolan]" value="Benjolan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['benjolan'] == 'Benjolan' ? 'checked' : '' }}>
                    <label for="genetalia_3" style="font-weight: normal; margin-right: 10px;">Benjolan</label><br/>
                    <input type="checkbox" id="genetalia_4" name="fisik[pemeriksaanFisik][genetalia][pilihan][hipospsdia]" value="Hipospsdia" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['hipospsdia'] == 'Hipospsdia' ? 'checked' : '' }}>
                    <label for="genetalia_4" style="font-weight: normal; margin-right: 10px;">Hipospsdia</label>
                    <input type="checkbox" id="genetalia_5" name="fisik[pemeriksaanFisik][genetalia][pilihan][epispadia]" value="Epispadia" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['epispadia'] == 'Epispadia' ? 'checked' : '' }}>
                    <label for="genetalia_5" style="font-weight: normal; margin-right: 10px;">Epispadia</label><br/>
                    <input type="checkbox" id="genetalia_5" name="fisik[pemeriksaanFisik][genetalia][pilihan][hidrochele]" value="Hidrochele" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['hidrochele'] == 'Hidrochele' ? 'checked' : '' }}>
                    <label for="genetalia_6" style="font-weight: normal; margin-right: 10px;">Hidrochele</label>
                    <input type="checkbox" id="genetalia_7" name="fisik[pemeriksaanFisik][genetalia][pilihan][lesi]" value="Lesi" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['lesi'] == 'Lesi' ? 'checked' : '' }}>
                    <label for="genetalia_7" style="font-weight: normal; margin-right: 10px;">Lesi</label><br/>
                    <input type="checkbox" id="genetalia_8" name="fisik[pemeriksaanFisik][genetalia][pilihan][eritema]" value="Eritema" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['eritema'] == 'Eritema' ? 'checked' : '' }}>
                    <label for="genetalia_8" style="font-weight: normal; margin-right: 10px;">Eritema</label>
                    <input type="checkbox" id="genetalia_9" name="fisik[pemeriksaanFisik][genetalia][pilihan][peradangan]" value="Peradangan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['peradangan'] == 'Peradangan' ? 'checked' : '' }}>
                    <label for="genetalia_9" style="font-weight: normal; margin-right: 10px;">Peradangan</label><br/>
                    <input type="checkbox" id="genetalia_10" name="fisik[pemeriksaanFisik][genetalia][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                    <label for="genetalia_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="genetalia_11" name="fisik[pemeriksaanFisik][genetalia][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['genetalia']['sebutkan'] }}">
                  </td>
                
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Urinaria</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="urinaria_1" name="fisik[pemeriksaanFisik][urinaria][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                    <label for="urinaria_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="checkbox" id="urinaria_2" name="fisik[pemeriksaanFisik][urinaria][pilihan][warna]" value="Warna" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['warna'] == 'Warna' ? 'checked' : '' }}>
                    <label for="urinaria_2" style="font-weight: normal; margin-right: 10px;">Warna</label><br/>
                    <input type="checkbox" id="urinaria_3" name="fisik[pemeriksaanFisik][urinaria][pilihan][produksi]" value="Produksi" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['produksi'] == 'Produksi' ? 'checked' : '' }}>
                    <label for="urinaria_3" style="font-weight: normal; margin-right: 10px;">Produksi</label><br/>
                    <input type="checkbox" id="urinaria_4" name="fisik[pemeriksaanFisik][urinaria][pilihan][lainnya]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : '' }}>
                    <label for="urinaria_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="urinaria_5" name="fisik[pemeriksaanFisik][urinaria][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['urinaria']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Gigi</td>
                  <td style="text-align: center">
                    <input type="radio" id="gigi_1" name="fisik[pemeriksaanFisik][gigi][pilihan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['gigi']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="gigi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label><br>
                    <input type="radio" id="gigi_4" name="fisik[pemeriksaanFisik][gigi][pilihan]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['gigi']['pilihan'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="gigi_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="gigi_5" name="fisik[pemeriksaanFisik][gigi][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['gigi']['sebutkan']}}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Ektremitas Atas</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="ektremitasAtas_1" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                    <label for="ektremitasAtas_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="checkbox" id="ektremitasAtas_2" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][gerakan_terbatas]" value="Gerakan Terbatas" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['gerakan_terbatas'] == 'Gerakan Terbatas' ? 'checked' : '' }}>
                    <label for="ektremitasAtas_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                    <input type="checkbox" id="ektremitasAtas_3" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][nyeri]" value="Nyeri" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['nyeri'] == 'Nyeri' ? 'checked' : '' }}>
                    <label for="ektremitasAtas_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                    <input type="checkbox" id="ektremitasAtas_4" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                    <label for="ektremitasAtas_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="ektremitasAtas_5" name="fisik[pemeriksaanFisik][ektremitasAtas][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Ektremitas Bawah</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="ektremitasBawah_1" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                    <label for="ektremitasBawah_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                
                    <input type="checkbox" id="ektremitasBawah_2" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][gerakan_terbatas]" value="Gerakan Terbatas" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['gerakan_terbatas'] == 'Gerakan Terbatas' ? 'checked' : '' }}>
                    <label for="ektremitasBawah_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                
                    <input type="checkbox" id="ektremitasBawah_3" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][nyeri]" value="Nyeri" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['nyeri'] == 'Nyeri' ? 'checked' : '' }}>
                    <label for="ektremitasBawah_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                
                    <input type="checkbox" id="ektremitasBawah_4" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                    <label for="ektremitasBawah_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                
                    <input type="text" id="ektremitasBawah_5" name="fisik[pemeriksaanFisik][ektremitasBawah][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['sebutkan'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Muka / Wajah</td>
                  <td style="text-align: center;">
                    <input type="radio" id="muka_1" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['muka']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="muka_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="radio" id="muka_2" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['muka']['pilihan'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="muka_2" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="muka_3" name="fisik[pemeriksaanFisik][muka][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['muka']['sebutkan']}}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Telinga</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="telinga_1" name="fisik[pemeriksaanFisik][telinga][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="telinga_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="checkbox" id="telinga_2" name="fisik[pemeriksaanFisik][telinga][pilihan][tidak_simetris]" value="Tidak Simetris" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['tidak_simetris'] == 'Tidak Simetris' ? 'checked' : ''}}>
                    <label for="telinga_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                    <input type="checkbox" id="telinga_3" name="fisik[pemeriksaanFisik][telinga][pilihan][cerumen]" value="Cerumen" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['cerumen'] == 'Cerumen' ? 'checked' : ''}}>
                    <label for="telinga_3" style="font-weight: normal; margin-right: 10px;">Cerumen</label><br/>
                    <input type="checkbox" id="telinga_4" name="fisik[pemeriksaanFisik][telinga][pilihan][lain_lain]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="telinga_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="telinga_5" name="fisik[pemeriksaanFisik][telinga][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['telinga']['sebutkan']}}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Hidung</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="hidung_1" name="fisik[pemeriksaanFisik][hidung][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="hidung_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="checkbox" id="hidung_2" name="fisik[pemeriksaanFisik][hidung][pilihan][tidak_simetris]" value="Tidak Simetris" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['tidak_simetris'] == 'Tidak Simetris' ? 'checked' : ''}}>
                    <label for="hidung_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                    <input type="checkbox" id="hidung_3" name="fisik[pemeriksaanFisik][hidung][pilihan][sekret]" value="Sekret" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['sekret'] == 'Sekret' ? 'checked' : ''}}>
                    <label for="hidung_3" style="font-weight: normal; margin-right: 10px;">Sekfret</label>
                    <input type="checkbox" id="hidung_4" name="fisik[pemeriksaanFisik][hidung][pilihan][cuping]" value="Cuping" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['cuping'] == 'Cuping' ? 'checked' : ''}}>
                    <label for="hidung_4" style="font-weight: normal; margin-right: 10px;">Pernafasan Cuping Hidung</label><br/>
                    <input type="checkbox" id="hidung_5" name="fisik[pemeriksaanFisik][hidung][pilihan][lain_lain]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="hidung_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="hidung_6" name="fisik[pemeriksaanFisik][hidung][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['hidung']['sebutkan']}}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Tenggorokan</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="tenggorokan_1" name="fisik[pemeriksaanFisik][tenggorokan][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['tenggorokan']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                    <label for="tenggorokan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                    <input type="checkbox" id="tenggorokan_2" name="fisik[pemeriksaanFisik][tenggorokan][pilihan][tonsil_ada_keluhan]" value="Tonsil Ada Keluhan" {{@$assesment['pemeriksaanFisik']['tenggorokan']['pilihan']['tonsil_ada_keluhan'] == 'Tonsil Ada Keluhan' ? 'checked' : ''}}>
                    <label for="tenggorokan_2" style="font-weight: normal; margin-right: 10px;">Tonsil Ada Keluhan</label><br/>
                    <input type="checkbox" id="tenggorokan_3" name="fisik[pemeriksaanFisik][tenggorokan][pilihan][lain_lain]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['tenggorokan']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : ''}}>
                    <label for="tenggorokan_3" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                    <input type="text" id="tenggorokan_4" name="fisik[pemeriksaanFisik][tenggorokan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['tenggorokan']['sebutkan']}}">
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Keadaan Emosional</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="keadaanEmosional_1" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Kooperatif" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'kooperatif' ? 'checked' : ''}}>
                    <label for="keadaanEmosional_1" style="font-weight: normal; margin-right: 10px;">Kooperatif</label>
                    <input type="checkbox" id="keadaanEmosional_2" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Butuh Pertolongan" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Butuh Pertolongan' ? 'checked' : ''}}>
                    <label for="keadaanEmosional_2" style="font-weight: normal; margin-right: 10px;">Butuh Pertolongan</label>
                    <input type="checkbox" id="keadaanEmosional_3" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Ingin Tahu" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Ingin Tahu' ? 'checked' : ''}}>
                    <label for="keadaanEmosional_3" style="font-weight: normal; margin-right: 10px;">Ingin Tahu</label>
                    <input type="checkbox" id="keadaanEmosional_4" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Bingung" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Bingung' ? 'checked' : ''}}>
                    <label for="keadaanEmosional_4" style="font-weight: normal; margin-right: 10px;">Bingung</label>
                  </td>
                </tr>
                
                <tr>
                  <td style="width:25%; font-weight:500;">Kebutuhan Edukasi dan Pengajaran</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="kebutuhanEdukasi_1" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][pasien]" value="Pasien" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['pasien'] == 'Pasien' ? 'checked' : ''}}>
                    <label for="kebutuhanEdukasi_1" style="font-weight: normal; margin-right: 10px;">Pasien</label>
                    <input type="checkbox" id="kebutuhanEdukasi_2" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][orang_tua]" value="Orang Tua" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['orang_tua'] == 'Orang Tua' ? 'checked' : ''}}>
                    <label for="kebutuhanEdukasi_2" style="font-weight: normal; margin-right: 10px;">Orang Tua</label>
                    <input type="checkbox" id="kebutuhanEdukasi_3" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][anak]" value="Anak" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['anak'] == 'Anak' ? 'checked' : ''}}>
                    <label for="kebutuhanEdukasi_3" style="font-weight: normal; margin-right: 10px;">Anak</label><br/>
                    <input type="checkbox" id="kebutuhanEdukasi_4" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][suami]" value="Suami" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['suami'] == 'Suami' ? 'checked' : ''}}>
                    <label for="kebutuhanEdukasi_4" style="font-weight: normal; margin-right: 10px;">Suami</label>
                    <input type="checkbox" id="kebutuhanEdukasi_5" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][istri]" value="Istri" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['istri'] == 'Istri' ? 'checked' : ''}}>
                    <label for="kebutuhanEdukasi_5" style="font-weight: normal; margin-right: 10px;">Istri</label>
                    <input type="checkbox" id="kebutuhanEdukasi_6" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][keluarga_lainnya]" value="Keluarga Lainnya" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['keluarga_lainnya'] == 'Keluarga Lainnya' ? 'checked' : ''}}>
                    <label for="kebutuhanEdukasi_6" style="font-weight: normal; margin-right: 10px;">Keluarga Lainnya</label>
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Bicara</td>
                  <td style="text-align: center;">
                    <input type="radio" id="bicara_1" name="fisik[pemeriksaanFisik][bicara][pilihan]" value="Normal" {{@$assesment['pemeriksaanFisik']['bicara']['pilihan'] == 'Normal' ? 'checked' : ''}}>
                    <label for="bicara_1" style="font-weight: normal; margin-right: 10px;">Normal</label>
                    <input type="radio" id="bicara_2" name="fisik[pemeriksaanFisik][bicara][pilihan]" value="Gangguan Bicara" {{@$assesment['pemeriksaanFisik']['bicara']['pilihan'] == 'Gangguan Bicara' ? 'checked' : ''}}>
                    <label for="bicara_2" style="font-weight: normal; margin-right: 10px;">Gangguan Bicara</label>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Bahasa Sehari-Hari</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="bahasa_1" name="fisik[pemeriksaanFisik][bahasa][pilihan][indonesia]" value="Indonesia" {{@$assesment['pemeriksaanFisik']['bahasa']['pilihan']['indonesia'] == 'Indonesia' ? 'checked' : ''}}>
                    <label for="bahasa_1" style="font-weight: normal; margin-right: 10px;">Indonesia</label>
                    <input type="checkbox" id="bahasa_2" name="fisik[pemeriksaanFisik][bahasa][pilihan][daerah]" value="Daerah" {{@$assesment['pemeriksaanFisik']['bahasa']['pilihan']['daerah'] == 'Daerah' ? 'checked' : ''}}>
                    <label for="bahasa_2" style="font-weight: normal; margin-right: 10px;">Daerah</label>
                    <input type="checkbox" id="bahasa_3" name="fisik[pemeriksaanFisik][bahasa][pilihan][inggris]" value="Inggris dan Lainnya" {{@$assesment['pemeriksaanFisik']['bahasa']['pilihan']['inggris'] == 'Inggris dan Lainnya' ? 'checked' : ''}}>
                    <label for="bahasa_3" style="font-weight: normal; margin-right: 10px;">Inggris dan Lainnya</label><br/>
                  </td>
                </tr>     
                
                <tr>
                  <td style="width:25%; font-weight:500;">Perlu Penerjemah</td>
                  <td style="text-align: center;">
                    <input type="radio" id="penerjemah_1" name="fisik[pemeriksaanFisik][penerjemah][pilihan]" value="Perlu Penerjemah" {{@$assesment['pemeriksaanFisik']['penerjemah']['pilihan'] == 'Perlu Penerjemah' ? 'checked' : ''}}>
                    <label for="penerjemah_1" style="font-weight: normal; margin-right: 10px;">Perlu Penerjemah</label>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Hambatan Edukasi</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="hambatanEdukasi_1" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][bahasa]" value="Bahasa" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['bahasa'] == 'Bahasa' ? 'checked' : ''}}>
                    <label for="hambatanEdukasi_1" style="font-weight: normal; margin-right: 10px;">Bahasa</label>
                    <input type="checkbox" id="hambatanEdukasi_2" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][pendengaran]" value="Pendengaran" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['pendengaran'] == 'Pendengaran' ? 'checked' : ''}}>
                    <label for="hambatanEdukasi_2" style="font-weight: normal; margin-right: 10px;">Pendengaran</label>
                    <input type="checkbox" id="hambatanEdukasi_3" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][hilang_memori]" value="Hilang Memori" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['hilang_memori'] == 'Hilang Memori' ? 'checked' : ''}}>
                    <label for="hambatanEdukasi_3" style="font-weight: normal; margin-right: 10px;">Hilang Memori</label><br/>
                    <input type="checkbox" id="hambatanEdukasi_4" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][motivasi_buruk]" value="Motivasi Buruk" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['motivasi_buruk'] == 'Motivasi Buruk' ? 'checked' : ''}}>
                    <label for="hambatanEdukasi_4" style="font-weight: normal; margin-right: 10px;">Motivasi Buruk</label>
                    <input type="checkbox" id="hambatanEdukasi_5" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][cemas]" value="Cemas" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['cemas'] == 'Cemas' ? 'checked' : ''}}>
                    <label for="hambatanEdukasi_5" style="font-weight: normal; margin-right: 10px;">Cemas</label><br/>
                    <input type="checkbox" id="hambatanEdukasi_6" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][masalah_penglihatan]" value="Masalah Penglihatan" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['masalah_penglihatan'] == 'Masalah Penglihatan' ? 'checked' : ''}}>
                    <label for="hambatanEdukasi_6" style="font-weight: normal; margin-right: 10px;">Masalah Penglihatan</label>
                    <input type="checkbox" id="hambatanEdukasi_7" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][tidak_ditemukan_hambatan]" value="Tidak ditemukan Hambatan" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['tidak_ditemukan_hambatan'] == 'Tidak ditemukan Hambatan' ? 'checked' : ''}}>
                    <label for="hambatanEdukasi_7" style="font-weight: normal; margin-right: 10px;">Tidak ditemukan Hambatan</label>
                  </td>
                </tr>
  
                <tr>
                  <td style="width:25%; font-weight:500;">Edukasi yang diberikan</td>
                  <td style="text-align: center;">
                    <input type="checkbox" id="edukasi_1" name="fisik[pemeriksaanFisik][edukasi][pilihan][proses_penyakit]" value="Proses Penyakit" {{@$assesment['pemeriksaanFisik']['edukasi']['pilihan']['proses_penyakit'] == 'Proses Penyakit' ? 'checked' : ''}}>
                    <label for="edukasi_1" style="font-weight: normal; margin-right: 10px;">Proses Penyakit</label>
                    <input type="checkbox" id="edukasi_2" name="fisik[pemeriksaanFisik][edukasi][pilihan][pengobatan]" value="Pengobatan" {{@$assesment['pemeriksaanFisik']['edukasi']['pilihan']['pengobatan'] == 'Pengobatan' ? 'checked' : ''}}>
                    <label for="edukasi_2" style="font-weight: normal; margin-right: 10px;">Pengobatan</label>
                    <input type="checkbox" id="edukasi_3" name="fisik[pemeriksaanFisik][edukasi][pilihan][nutrisi]" value="Nutrisi" {{@$assesment['pemeriksaanFisik']['edukasi']['pilihan']['nutrisi'] == 'Nutrisi' ? 'checked' : ''}}>
                    <label for="edukasi_3" style="font-weight: normal; margin-right: 10px;">Nutrisi</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Status Gizi</td>
                  <td>
                    <input type="text" id="statusGizi" name="fisik[pemeriksaanFisik][statusGizi]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['statusGizi']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Status Pediatrik</td>
                  <td>
                    <input type="text" id="statusPediatrik" name="fisik[pemeriksaanFisik][statusPediatrik]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['statusPediatrik']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Riwayat Imunisasi</td>
                  <td>
                    <input type="text" id="riwayatImunisasi" name="fisik[pemeriksaanFisik][riwayatImunisasi]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['riwayatImunisasi']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">Riwayat Tumbuh Kembang</td>
                  <td>
                    <input type="text" id="riwayatTumbuh" name="fisik[pemeriksaanFisik][riwayatTumbuh]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['riwayatTumbuh']}}">
                  </td>
                </tr>
              </table>
  
               
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                <tr>
                  <td colspan="2" style="font-weight:bold;">RENCANA PEMULANGAN PASIEN (Discharge Planning)</td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">
                    <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesment['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                    <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                  </td>
                  <td>
                    <input type="text" id="waktuKontrol2" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button type="button" id="listKontrol2" data-dokterID="{{ $reg->dokter_id }}"
                      class="btn btn-info btn-sm btn-flat">
                      <i class="fa fa-th-list"></i> Lihat List Kontrol
                    </button>
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">
                    <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB" {{@$assesment['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                    <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                  </td>
                  <td>
                    <input type="text" name="fisik[dischargePlanning][kontrolPRB][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrolPRB']['waktu']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">
                    <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat" {{@$assesment['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                    <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                  </td>
                  <td>
                    <input type="text" name="fisik[dischargePlanning][dirawat][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirawat']['waktu']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">
                    <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                    <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                  </td>
                  <td>
                    <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirujuk']['waktu']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">
                    <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesment['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                    <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                  </td>
                  <td>
                    <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">
                    <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesment['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                    <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                  </td>
                  <td>
                    <input type="text" name="fisik[dischargePlanning][pulpak][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['pulpak']['waktu']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; font-weight:500;">
                    <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesment['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                    <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                  </td>
                  <td>
                    <input type="text" name="fisik[dischargePlanning][meninggal][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['meninggal']['waktu']}}">
                  </td>
                </tr>
              </table>

              <div style="text-align: right;">
                <input class="btn btn-warning" type="reset" value="Reset">&nbsp;&nbsp;
                <button class="btn btn-success pull-right">Simpan</button>
              </div>
              
              </form>
  
              @if (substr($reg->status_reg, 0, 1) == 'J')
                <form method="POST" action="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', $reg->id) !!}
                  {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                  {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                  {!! Form::hidden('unit', $unit) !!}
                  <br>
                  <h4 style="text-align: center"><b>Asuhan Keperawatan</b></h4>
                  
                  @include('emr.modules.pemeriksaan.select-askep')

                  <div style="text-align: right;">
                    <button class="btn btn-success">Simpan Askep</button>
                  </div>
                </form>
                @include('emr.modules.pemeriksaan.modal-tte-askep')

              @elseif(substr($reg->status_reg, 0, 1) == 'I')
                <h5><b>Diagnosa Keperawatan</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  
                  <tr>
                    <td>
                      @if (@$diagnosis != null)
                        @foreach (@$diagnosis as $diagnosa)
                        - {{ $diagnosa }} <br>
                        @endforeach
                      @else
                        <i>Belum Ada Yang Dipilih</i>
                      @endif
                    </td>
                  </tr>
                </table>
    
                <h5><b>Intervensi</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td>
                      @if (@$siki != null)
                        @foreach (@$siki as $siki)
                        * {{ $siki }} <br>
                        @endforeach
                      @else
                        <i>Belum Ada Yang Dipilih</i>
                      @endif
                    </td>
                  </tr>
                </table>
    
                <h5><b>Implementasi</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                  style="font-size:12px;">
                  <tr>
                    <td>
                      @if (@$implementasi != null)
                        @foreach (@$implementasi as $i)
                        * {{ $i }} <br>
                        @endforeach
                      @else
                        <i>Belum Ada Yang Dipilih</i>
                      @endif
                    </td>
                  </tr>
                </table>
              @else
              
              @endif
            </div>
            <div class="col-md-12">
              <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                  </tr>
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                    <th class="text-center" style="vertical-align: middle;">Poli</th>
                    <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @if (count($riwayats) == 0)
                      <tr>
                          <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                      </tr>
                  @endif
                  @foreach ($riwayats as $riwayat)
                      <tr>
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{ baca_poli($riwayat->registrasi->poli_id) }}
                          </td>
                        
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{-- <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> --}}
                              @if (substr($riwayat->registrasi->status_reg, 0, 1) == 'J')
                                @if (in_array($riwayat->registrasi->poli_id, ['3', '34', '4']))
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @elseif ($riwayat->registrasi->poli_id == '15')
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-obgyn/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @elseif ( $riwayat->registrasi->poli_id == "6")
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-mata/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm btn-flat">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @elseif ($riwayat->registrasi->poli_id == '27')
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @elseif ($riwayat->registrasi->poli_id == '41')
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-paru/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @else
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @endif
                              @else
                              -
                              @endif
                              <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                <i class="fa fa-trash"></i>
                              </a>
                          </td>
                      </tr>
                      <tr>
                        <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                        </td>
                      </tr>
                  @endforeach
                
                </tbody>
              </table>
            </div>
          @endif
          
          {{-- <div class="col-md-6">
            <h5><b>Asesmen</b></h5>


            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
            style="font-size:12px;"> 
            <tr>
              <td style="width:20%;">Keluhan Utama</td>
              <td style="padding: 5px;">
                
                <input type="text" name="fisik[keluhan_utama]" class="form-control" id="" >
         
                
              </td>
            </tr>
            </tr>
                  <td style="width:20%;">Riwayat Penyakit Sekarang :</td>
                  <td style="padding: 5px;">
                   
                    <textarea rows="15" name="fisik[riwayat_penyakit_sekarang]" style="display:inline-block" placeholder="" class="form-control"></textarea></td>
                 
              </tr>
          </table>


            
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td rowspan="4" style="width:20%;">Keadaan Umum</td>
                <td colspan="2" style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[keadaan_umum][tampak_tidak_sakit]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[keadaan_umum][tampak_tidak_sakit]" type="checkbox" value="Ya" id="flexCheckDefault">
                   
                   
                  
                    Tampak Tidak Sakit
                  </label>
                  <tr>
                    <td colspan="2">
                      <label class="form-check-label" for="flexCheckDefault">
                       <input class="form-check-input"  name="fisik[keadaan_umum][sakit_ringan]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[keadaan_umum][sakit_ringan]" type="checkbox" value="Ya" id="flexCheckDefault">
                  
                   
                  
                        Sakit Ringan
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[keadaan_umum][sakit_sedang]" type="hidden" value="Tidak" id="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[keadaan_umum][sakit_sedang]" type="checkbox" value="Ya" id="flexCheckDefault">
                     
                      
                       
                        Sakit Sedang
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[keadaan_umum][sakit_berat]" type="hidden" value="Tidak" id="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[keadaan_umum][sakit_berat]" type="checkbox" value="Ya" id="flexCheckDefault">
                        Sakit Berat
                      </label>
                    </td>
                  </tr>
                </td>
              
              </tr>
              <tr>
                <td rowspan="5" style="width:2Tidak%;">Kesadaran</td>
                <td colspan="2" style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[kesadaran][compos_mentis]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[kesadaran][compos_mentis]" type="checkbox" value="Ya" id="flexCheckDefault">
                    Compos Mentis
                  </label>
                  <tr>
                    <td colspan="2">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][apatis]" type="hidden" value="Tidak" id="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][apatis]" type="checkbox" value="Ya" id="flexCheckDefault">
                        Apatis
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][somnolen]" type="hidden" value="Tidak" id="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][somnolen]" type="checkbox" value="Ya" id="flexCheckDefault">
                        Somnolen
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][sopor]" type="hidden" value="Tidak" id="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][sopor]" type="checkbox" value="Ya" id="flexCheckDefault">
                        Sopor
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][coma]" type="hidden" value="Tidak" id="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[kesadaran][coma]" type="checkbox" value="Ya" id="flexCheckDefault">
                         Coma
                      </label>
                    </td>
                  </tr>
                </td>
              
              </tr>
              <tr>
                <td rowspan="9" style="width:20%;">GCS</td>
                <td style="padding: 5px;">
                  <label class="form-check-label">
                    E
                  </label>
                 <td>
                    <input type="text" name="fisik[GCS][E]" style="display:inline-block" class="form-control" id="">
                 </td>
                 <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label">M</label>
                 <td>
                    <input type="text" name="fisik[GCS][M]" style="display:inline-block" class="form-control" id="">
                 </td>
                 </tr>
                 <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label">V</label>
                  <td>
                      <input type="text" name="fisik[GCS][V]" style="display:inline-block" class="form-control" id="">
                  </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label">Tekanan Darah (mmHG)</label>
                    <td>
                        <input type="text" name="fisik[GCS][tekanan_darah]" style="display:inline-block" class="form-control" id="">
                    </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;">
                      <label class="form-check-label">Nadi (x/menit)</label>
                      <td>
                          <input type="text" name="fisik[GCS][nadi]" style="display:inline-block" class="form-control" id="">
                      </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px;">
                        <label class="form-check-label">Frekuensi Nafas (x/menit)</label>
                        <td>
                            <input type="text" name="fisik[GCS][frekuensi_nafas]" style="display:inline-block" class="form-control" id="">
                        </td>
                        </tr>
                        <tr>
                          <td style="padding: 5px;">
                          <label class="form-check-label"> Suhu (°C)</label>
                          <td>
                              <input type="text" name="fisik[GCS][suhu]" style="display:inline-block" class="form-control" id="">
                          </td>
                    </tr>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label">BB (kg)</label>
                    <td>
                      <input type="number" name="fisik[GCS][BB]" style="display:inline-block" class="form-control" id="">
                    </td>
                    </tr>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label">TB (cm)</label>
                    <td>
                      <input type="number" name="fisik[GCS][TB]" style="display:inline-block" class="form-control" id="">
                    </td>
                    </tr>
                </td>
              </tr>
              <tr>
                <td rowspan="6" style="width:20%;">Asesmen Nyeri</td>
                <td style="padding: 5px;">
                  <label class="form-check-label">
                    Provokatif
                  </label>
                 <td>
                    <input type="text" name="fisik[asesmen_nyeri][provokatif]" style="display:inline-block" class="form-control" id="">
                 </td>
                 <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label">Quality</label>
                 <td>
                    <input type="text" name="fisik[asesmen_nyeri][quality]" style="display:inline-block" class="form-control" id="">
                 </td>
                 </tr>
                 <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label">Region</label>
                  <td>
                      <input type="text" name="fisik[asesmen_nyeri][region]" style="display:inline-block" class="form-control" id="">
                  </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label">Severity</label>
                    <td>
                        <input type="text" name="fisik[asesmen_nyeri][severty]" style="display:inline-block" class="form-control" id="">
                    </td>
                    </tr>
                  <tr>
                      <td style="padding: 5px;">
                      <label class="form-check-label">Time (Durasi)</label>
                      <td>
                          <input type="text" name="fisik[asesmen_nyeri][time]" style="display:inline-block" class="form-control" id="">
                      </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label">Nyeri Hilang Jika</label>
                    <td>
                        <input type="text" name="fisik[asesmen_nyeri][nyeri_hilang_jika]" style="display:inline-block" class="form-control" id="">
                    </td>
                  </tr>
                </td>
              </tr>
            </table>

              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                     style="font-size:12px;">
                    
                     <td rowspan="6"  style="width:20%;">Persarafan</td>
                     <td  style="padding: 5px;" class="fisik">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[persarafan][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[persarafan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                   
                         Tidak ada keluhan
                       </label>
                     </td>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[persarafan][tremor]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[persarafan][tremor]" type="checkbox" value="Tremor" id="flexCheckDefault">
                         
                             Tremor
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[persarafan][kejang]" type="hidden" value="" id="flexCheckDefault">
                        
                            <input class="form-check-input"  name="fisik[persarafan][kejang]" type="checkbox" value="Kejang" id="flexCheckDefault">
                         
                             Kejang
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[persarafan][paralise]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[persarafan][paralise]" type="checkbox" value="Paralise" id="flexCheckDefault">
                         
                             Paralise
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[persarafan][hemiparese]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[persarafan][hemiparese]" type="checkbox" value="Hemiparese/Hemiplegia" id="flexCheckDefault">
                        
                             Hemiparese/Hemiplegia
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                         
                           <input name="fisik[persarafan][text]" type="text" class="form-control" id="" value="" >
                      
                          </td>
                       </tr>
                     </td>
                               
     
     
                     <td rowspan="4"  style="width:20%;">Pernapasan</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[pernapasan][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[pernapasan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                   
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[pernapasan][sekret]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[pernapasan][sekret]" type="checkbox" value="Sekret" id="flexCheckDefault">
                       
                             Sekret
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[pernapasan][sesak_napas]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[pernapasan][sesak_napas]" type="checkbox" value="Sesak Napas" id="flexCheckDefault">
                        
                             Sesak Napas
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                        
                           <input name="fisik[pernapasan][text]" type="text" class="form-control" id="" value="" >
                   
                         </td>
                       </tr>
                     </td>
                     
                     
     
     
     
     
     
                     <td rowspan="5"  style="width:20%;">Pencernaan</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[pencernaan][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[pencernaan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                   
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[pencernaan][konstipasi]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[pencernaan][konstipasi]" type="checkbox" value="konstipasi" id="flexCheckDefault">
                           
                             Konstipasi
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[pencernaan][mual]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[pencernaan][mual]" type="checkbox" value="Mual" id="flexCheckDefault">
                         
                             Mual/Muntah
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[pencernaan][diare]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[pencernaan][diare]" type="checkbox" value="Diare" id="flexCheckDefault">
                          
                             Diare
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                        
                          <input name="fisik[pencernaan][text]" type="text" class="form-control" id="" value="" >
                   
                         </td>
                       </tr>                  
                     </td> --}}
     
                     {{-- @php
                         dd($riwayat);
                     @endphp --}}
     
                     {{-- <td rowspan="6"  style="width:20%;">Endokrin</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[endokrin][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                    
                        <input class="form-check-input"  name="fisik[endokrin][tidak_ada_keluhan]" type="checkbox" value="Keringat Banyak" id="flexCheckDefault">
                       
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[endokrin][keringat_banyak]" type="hidden" value="" id="flexCheckDefault">
                         
                            <input class="form-check-input"  name="fisik[endokrin][keringat_banyak]" type="checkbox" value="Keringat Banyak" id="flexCheckDefault">
                            

                            Keringat Banyak

                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[endokrin][pembesaran_kelenjar_tiroid]" type="hidden" value="" id="flexCheckDefault">
                      
                            <input class="form-check-input"  name="fisik[endokrin][pembesaran_kelenjar_tiroid]" type="checkbox" value="Pembesaran Kelenjar Tiroid" id="flexCheckDefault">
                          
                             Pembesaran Kelenjar Tiroid
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[endokrin][diare]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[endokrin][diare]" type="checkbox" value="Diare" id="flexCheckDefault">
                         
                             Diare
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[endokrin][napas_baus]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[endokrin][napas_baus]" type="checkbox" value="Napas Bau" id="flexCheckDefault">
                          
                             Napas Bau
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                       
                          <input name="fisik[endokrin][text]" type="text" class="form-control" id="" value="" >
                  
                         </td>
                       </tr>
                       
                     </td>
     
     
     
     
     
                     <td rowspan="4"  style="width:20%;">Kardiovaskuler</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[kardiovaskuler][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[kardiovaskuler][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                       
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[kardiovaskuler][oedema]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[kardiovaskuler][oedema]" type="checkbox" value="Oedema" id="flexCheckDefault">
                         
                             Oedema
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[kardiovaskuler][chest_pain]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[kardiovaskuler][chest_pain]" type="checkbox" value="chest pain" id="flexCheckDefault">
                          
                             Chest Pain
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                        
                          <input name="fisik[kardiovaskuler][text]" type="text" class="form-control" id="" value="" >
                     
                         </td>
                       </tr>
                       
                     </td>
                     <td rowspan="10"  style="width:20%;">Abdomen</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[abdomen][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[abdomen][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                     
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][membesar]" type="hidden" value="" id="flexCheckDefault">
                  
                            <input class="form-check-input"  name="fisik[abdomen][membesar]" type="checkbox" value="Membesar" id="flexCheckDefault">
                          
                             Membesar
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][nyeri_tekan]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[abdomen][nyeri_tekan]" type="checkbox" value="Nyeri Tekan" id="flexCheckDefault">
                           
                             Nyeri Tekan
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][luka]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[abdomen][luka]" type="checkbox" value="Luka" id="flexCheckDefault">
                        
                             Luka
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][distensi]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[abdomen][distensi]" type="checkbox" value="Distensi" id="flexCheckDefault">
                           
                             Distensi
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][L_I]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[abdomen][L_I]" type="checkbox" value="L_I" id="flexCheckDefault">
                        
                             L I
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][L_II]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[abdomen][L_II]" type="checkbox" value="L_II" id="flexCheckDefault">
                          
                             L II
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][L_III]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[abdomen][L_III]" type="checkbox" value="L_III" id="flexCheckDefault">
                         
                             L III
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[abdomen][L_IV]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[abdomen][L_IV]" type="checkbox" value="L_IV" id="flexCheckDefault">
                         
                             L IV
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                         
                          <input name="fisik[abdomen][text]" type="text" class="form-control" id="" value="" >
                     
                         </td>
                       </tr>
                       
                     </td>
     
     
     
                     <td rowspan="9"  style="width:20%;">Reproduksi</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[reproduksi][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[reproduksi][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                     
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[reproduksi][keputihan]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[reproduksi][keputihan]" type="checkbox" value="Kpeutihan" id="flexCheckDefault">
                        
                            Keputihan
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[reproduksi][haid_teratur]" type="hidden" value="" id="flexCheckDefault">
                         
                            <input class="form-check-input"  name="fisik[reproduksi][haid_teratur]" type="checkbox" value="Haid Teratur" id="flexCheckDefault">
                         
                             Haid Teratur
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[reproduksi][kb]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[reproduksi][kb]" type="checkbox" value="KB" id="flexCheckDefault">
                         
                             KB
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[reproduksi][hpht]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[reproduksi][hpht]" type="checkbox" value="HPHT" id="flexCheckDefault">
                         
                               HPHT
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[reproduksi][tp]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[reproduksi][tp]" type="checkbox" value="TP" id="flexCheckDefault">
                         
                             TP
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[reproduksi][uk]" type="hidden" value="" id="flexCheckDefault">
                          
                          <input class="form-check-input"  name="fisik[reproduksi][uk]" type="checkbox" value="UK" id="flexCheckDefault">
                        
                             UK
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[reproduksi][dd]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[reproduksi][dd]" type="checkbox" value="DD" id="flexCheckDefault">
                          
                            DD
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                         
                          <input name="fisik[reproduksi][text]" type="text" class="form-control" id="" value="" >
                      
                         </td>
                       </tr>
                       
                     </td>
     
     
     
     
                     <td rowspan="6"  style="width:20%;">Kulit</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[kulit][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[kulit][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                     
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[kulit][luka]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[kulit][luka]" type="checkbox" value="Luka" id="flexCheckDefault">
                        
                            Luka
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[kulit][warna]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[kulit][warna]" type="checkbox" value="Warna" id="flexCheckDefault">
                         
                             Warna
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[kulit][lecet]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[kulit][lecet]" type="checkbox" value="Lecet" id="flexCheckDefault">
                         
                            Lecet
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[kulit][turgor]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[kulit][turgor]" type="checkbox" value="Turgor" id="flexCheckDefault">
                         
                             Turgor
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                        
                          <input name="fisik[kulit][text]" type="text" class="form-control" id="" value="" >
                      
                         </td>
                       </tr>
                       
                     </td>
     
     
     
     
     
     
                     <td rowspan="4"  style="width:20%;">Urinaria</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[urinaria][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[urinaria][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                     
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[urinaria][warna]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[urinaria][warna]" type="checkbox" value="Warna" id="flexCheckDefault">
                         
                            Warna
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[urinaria][produksi]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[urinaria][produksi]" type="checkbox" value="Produksi" id="flexCheckDefault">
                          
                             Produksi
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                        
                          <input name="fisik[urinaria][text]" type="text" class="form-control" id="" value="" >
                    
                         </td>
                       </tr>
                     </td>
     
     
                     
                     <td rowspan="5"  style="width:20%;">Mata</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[mata][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                        
                        <input class="form-check-input"  name="fisik[mata][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                       
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[mata][normal]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[mata][normal]" type="checkbox" value="Normal" id="flexCheckDefault">
                          
                            Normal
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[mata][kuning]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[mata][kuning]" type="checkbox" value="Kuning" id="flexCheckDefault">
                           
                            Kuning
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[mata][pucat]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[mata][pucat]" type="checkbox" value="Pucat" id="flexCheckDefault">
                           
                            Pucat
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                         
                          <input name="fisik[mata][text]" type="text" class="form-control" id="" value="" >
                      
                         </td>
                       </tr>
                       
                     </td>
                     






                     <td rowspan="15"  style="width:20%;">Visus (OD)</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[od][6/6]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[od][6/6]" type="checkbox" value="6/6" id="flexCheckDefault">
                      
                         6/6
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[od][6/7,5]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[od][6/7,5]" type="checkbox" value="6/7,5" id="flexCheckDefault">
                         
                           6/7,5
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[od][6/9]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[od][6/9]" type="checkbox" value="6/9" id="flexCheckDefault">
                         
                           6/9
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[od][6/12]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[od][6/12]" type="checkbox" value="6/12" id="flexCheckDefault">
                           
                          6/12
                           </label>
                         </td>
                       </tr>
                       <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][6/15]" type="hidden" value="" id="flexCheckDefault">
                         
                          
                           <input class="form-check-input"  name="fisik[od][6/15]" type="checkbox" value="6/15" id="flexCheckDefault">
                        
                         6/15
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][6/20]" type="hidden" value="" id="flexCheckDefault">
                         
                           <input class="form-check-input"  name="fisik[od][6/20]" type="checkbox" value="6/20" id="flexCheckDefault">
                        
                         6/20
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][6/30]" type="hidden" value="" id="flexCheckDefault">
                         
                           <input class="form-check-input"  name="fisik[od][6/30]" type="checkbox" value="6/30" id="flexCheckDefault">
                          
                         6/30
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][6/60]" type="hidden" value="" id="flexCheckDefault">
                         
                           <input class="form-check-input"  name="fisik[od][6/60]" type="checkbox" value="6/60" id="flexCheckDefault">
                         
                         6/60
                          </label>
                        </td>
                      </tr>
                     
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][5/60]" type="hidden" value="" id="flexCheckDefault">
                         
                           <input class="form-check-input"  name="fisik[od][5/60]" type="checkbox" value="5/60" id="flexCheckDefault">
                         
                         5/60
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][4/60]" type="hidden" value="" id="flexCheckDefault">
                         
                           <input class="form-check-input"  name="fisik[od][4/60]" type="checkbox" value="4/60" id="flexCheckDefault">
                         
                         4/60
                          </label>
                        </td>
                      </tr>
                     
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][3/60]" type="hidden" value="" id="flexCheckDefault">
                         
                           <input class="form-check-input"  name="fisik[od][3/60]" type="checkbox" value="3/60" id="flexCheckDefault">
                          
                         3/60
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][2/60]" type="hidden" value="" id="flexCheckDefault">
                          
                           <input class="form-check-input"  name="fisik[od][2/60]" type="checkbox" value="2/60" id="flexCheckDefault">
                        
                         2/60
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][1/60]" type="hidden" value="" id="flexCheckDefault">
                         
                           <input class="form-check-input"  name="fisik[od][1/60]" type="checkbox" value="1/60" id="flexCheckDefault">
                        
                         1/60
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][1/300]" type="hidden" value="" id="flexCheckDefault">
                          
                           <input class="form-check-input"  name="fisik[od][1/300]" type="checkbox" value="1/300" id="flexCheckDefault">
                         
                         1/300
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="form-check-label" for="flexCheckDefault">
                           <input class="form-check-input"   name="fisik[od][1/oo]" type="hidden" value="" id="flexCheckDefault">
                          
                           <input class="form-check-input"  name="fisik[od][1/oo]" type="checkbox" value="1/oo" id="flexCheckDefault">
                          
                         1/oo
                          </label>
                        </td>
                      </tr>






                      <td rowspan="15"  style="width:20%;">Visus (os)</td>
                      <td  style="padding: 5px;">
                        <label class="form-check-label" for="flexCheckDefault">
                         <input class="form-check-input"   name="fisik[os][6/6]" type="hidden" value="" id="flexCheckDefault">
                        
                         <input class="form-check-input"  name="fisik[os][6/6]" type="checkbox" value="6/6" id="flexCheckDefault">
                       
                          6/6
                        </label>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[os][6/7,5]" type="hidden" value="" id="flexCheckDefault">
                            
                             <input class="form-check-input"  name="fisik[os][6/7,5]" type="checkbox" value="6/7,5" id="flexCheckDefault">
                          
                            6/7,5
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[os][6/9]" type="hidden" value="" id="flexCheckDefault">
                            
                             <input class="form-check-input"  name="fisik[os][6/9]" type="checkbox" value="6/9" id="flexCheckDefault">
                          
                            6/9
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[os][6/12]" type="hidden" value="" id="flexCheckDefault">
                            
                             <input class="form-check-input"  name="fisik[os][6/12]" type="checkbox" value="6/12" id="flexCheckDefault">
                            
                           6/12
                            </label>
                          </td>
                        </tr>
                        <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][6/15]" type="hidden" value="" id="flexCheckDefault">
                          
                           
                            <input class="form-check-input"  name="fisik[os][6/15]" type="checkbox" value="6/15" id="flexCheckDefault">
                         
                          6/15
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][6/20]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[os][6/20]" type="checkbox" value="6/20" id="flexCheckDefault">
                         
                          6/20
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][6/30]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[os][6/30]" type="checkbox" value="6/30" id="flexCheckDefault">
                           
                          6/30
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][6/60]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[os][6/60]" type="checkbox" value="6/60" id="flexCheckDefault">
                          
                          6/60
                           </label>
                         </td>
                       </tr>
                      
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][5/60]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[os][5/60]" type="checkbox" value="5/60" id="flexCheckDefault">
                          
                          5/60
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][4/60]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[os][4/60]" type="checkbox" value="4/60" id="flexCheckDefault">
                          
                          4/60
                           </label>
                         </td>
                       </tr>
                      
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][3/60]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[os][3/60]" type="checkbox" value="3/60" id="flexCheckDefault">
                           
                          3/60
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][2/60]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[os][2/60]" type="checkbox" value="2/60" id="flexCheckDefault">
                         
                          2/60
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][1/60]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[os][1/60]" type="checkbox" value="1/60" id="flexCheckDefault">
                         
                          1/60
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][1/300]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[os][1/300]" type="checkbox" value="1/300" id="flexCheckDefault">
                          
                          1/300
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[os][1/oo]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[os][1/oo]" type="checkbox" value="1/oo" id="flexCheckDefault">
                           
                          1/oo
                           </label>
                         </td>
                       </tr>










                       <td rowspan="15"  style="width:20%;">Visus (idem)</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="fisik[idem][6/6]" type="hidden" value="" id="flexCheckDefault">
                         
                          <input class="form-check-input"  name="fisik[idem][6/6]" type="checkbox" value="6/6" id="flexCheckDefault">
                        
                           6/6
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="fisik[idem][6/7,5]" type="hidden" value="" id="flexCheckDefault">
                             
                              <input class="form-check-input"  name="fisik[idem][6/7,5]" type="checkbox" value="6/7,5" id="flexCheckDefault">
                           
                             6/7,5
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="fisik[idem][6/9]" type="hidden" value="" id="flexCheckDefault">
                             
                              <input class="form-check-input"  name="fisik[idem][6/9]" type="checkbox" value="6/9" id="flexCheckDefault">
                           
                             6/9
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="fisik[idem][6/12]" type="hidden" value="" id="flexCheckDefault">
                             
                              <input class="form-check-input"  name="fisik[idem][6/12]" type="checkbox" value="6/12" id="flexCheckDefault">
                             
                            6/12
                             </label>
                           </td>
                         </tr>
                         <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][6/15]" type="hidden" value="" id="flexCheckDefault">
                           
                            
                             <input class="form-check-input"  name="fisik[idem][6/15]" type="checkbox" value="6/15" id="flexCheckDefault">
                          
                           6/15
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][6/20]" type="hidden" value="" id="flexCheckDefault">
                           
                             <input class="form-check-input"  name="fisik[idem][6/20]" type="checkbox" value="6/20" id="flexCheckDefault">
                          
                           6/20
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][6/30]" type="hidden" value="" id="flexCheckDefault">
                           
                             <input class="form-check-input"  name="fisik[idem][6/30]" type="checkbox" value="6/30" id="flexCheckDefault">
                            
                           6/30
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][6/60]" type="hidden" value="" id="flexCheckDefault">
                           
                             <input class="form-check-input"  name="fisik[idem][6/60]" type="checkbox" value="6/60" id="flexCheckDefault">
                           
                           6/60
                            </label>
                          </td>
                        </tr>
                       
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][5/60]" type="hidden" value="" id="flexCheckDefault">
                           
                             <input class="form-check-input"  name="fisik[idem][5/60]" type="checkbox" value="5/60" id="flexCheckDefault">
                           
                           5/60
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][4/60]" type="hidden" value="" id="flexCheckDefault">
                           
                             <input class="form-check-input"  name="fisik[idem][4/60]" type="checkbox" value="4/60" id="flexCheckDefault">
                           
                           4/60
                            </label>
                          </td>
                        </tr>
                       
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][3/60]" type="hidden" value="" id="flexCheckDefault">
                           
                             <input class="form-check-input"  name="fisik[idem][3/60]" type="checkbox" value="3/60" id="flexCheckDefault">
                            
                           3/60
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][2/60]" type="hidden" value="" id="flexCheckDefault">
                            
                             <input class="form-check-input"  name="fisik[idem][2/60]" type="checkbox" value="2/60" id="flexCheckDefault">
                          
                           2/60
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][1/60]" type="hidden" value="" id="flexCheckDefault">
                           
                             <input class="form-check-input"  name="fisik[idem][1/60]" type="checkbox" value="1/60" id="flexCheckDefault">
                          
                           1/60
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][1/300]" type="hidden" value="" id="flexCheckDefault">
                            
                             <input class="form-check-input"  name="fisik[idem][1/300]" type="checkbox" value="1/300" id="flexCheckDefault">
                           
                           1/300
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="form-check-label" for="flexCheckDefault">
                             <input class="form-check-input"   name="fisik[idem][1/oo]" type="hidden" value="" id="flexCheckDefault">
                            
                             <input class="form-check-input"  name="fisik[idem][1/oo]" type="checkbox" value="1/oo" id="flexCheckDefault">
                            
                           1/oo
                            </label>
                          </td>
                        </tr>


 --}}



                        {{-- <td rowspan="2"  style="width:20%;">Tonometri</td>
                        <td  style="padding: 5px;">
                          <label class="form-check-label" for="flexCheckDefault">
                           
                            OD
                          </label>
                          <input name="fisik[od][text]" type="text" class="form-control" id="" value="" >
                          <tr>
                            <td style="padding: 5px;">
                              <label class="form-check-label" for="flexCheckDefault">
                           
                                OS
                              </label>
                             <input name="fisik[os][text]" type="text" class="form-control" id="" value="" >
                         
                            </td>
                          </tr>
                        </td>








     
                     <td rowspan="4"  style="width:20%;">Otot,Sendi, dan Tulang</td>
                     <td  style="padding: 5px;">
                       <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[ost][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[ost][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                     
                         Tidak ada keluhan
                       </label>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[ost][gerakan_terbatas]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[ost][gerakan_terbatas]" type="checkbox" value="Gerakan Terbatas" id="flexCheckDefault">
                           
                            Gerakan Terbatas
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[ost][nyeri]" type="hidden" value="" id="flexCheckDefault">
                          
                            <input class="form-check-input"  name="fisik[ost][nyeri]" type="checkbox" value="Nyeri" id="flexCheckDefault">
                           
                            Nyeri
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                         
                          <input name="fisik[ost][text]" type="text" class="form-control" id="" value="" >
                      
                         </td>
                       </tr>
                     </td>
     
     
                    
                     <td rowspan="5"  style="width:20%;">Keadaan Emosional</td>
                     <td  style="padding: 5px;">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"   name="fisik[keadaan_emosional][kooperatif]" type="hidden" value="" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="fisik[keadaan_emosional][kooperatif]" type="checkbox" value="Kooperatif" id="flexCheckDefault">
                       
                        Koperatif
                       </label> 
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[keadaan_emosional][butuh_pertolongan]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[keadaan_emosional][butuh_pertolongan]" type="checkbox" value="Butuh Pertolongan" id="flexCheckDefault">
                           
                           Butuh Pertolongan
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[keadaan_emosional][ingin_tahu]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[keadaan_emosional][ingin_tahu]" type="checkbox" value="Ingin Tahu" id="flexCheckDefault">
                            Ingin Tahu
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"   name="fisik[keadaan_emosional][bingung]" type="hidden" value="" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="fisik[keadaan_emosional][bingung]" type="checkbox" value="Bingung" id="flexCheckDefault">
                           
                            Bingung
                           </label>
                         </td>
                       </tr>
                       <tr>
                         <td style="padding: 5px;">
                         
                          <input name="fisik[keadaan_emosional][text]" type="text" class="form-control" id="" value="" >
                      
                         </td>
                       </tr>
                     </td> 
     
     
     
     
                     
                     <tr>
                      <td rowspan="2"  style="width:20%;">Gigi</td>
                      <td>
                       <input class="form-check-input"  name="fisik[gigi_check]" type="hidden" value="" id="flexCheckDefault">
                      
                       <input class="form-check-input"  name="fisik[gigi_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    
                       Tidak Ada Keluhan
                     </td>
                      <tr>
                      
                       <td  style="padding: 5px;">
                      
                        <input name="fisik[gigi]" type="text" class="form-control" id="" value="" >
                    
                       </td>
                      </tr>
                 </tr>   
                     
                     
                   <tr>
                         <td rowspan="2"  style="width:20%;">Telinga</td>
                         <td>
                          <input class="form-check-input"  name="fisik[telinga_check]" type="hidden" value="" id="flexCheckDefault">
                         
                          <input class="form-check-input"  name="fisik[telinga_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                       
                          Tidak Ada Keluhan
                        </td>
                         <tr>
                         
                          <td  style="padding: 5px;">
                           
                        <input name="fisik[telinga]" type="text" class="form-control" id="" value="" >
                    
                          </td>
                         </tr>
                    </tr>  
     
     
                    <tr>
                      <td rowspan="2"  style="width:20%;">Tenggorokan</td>
                      <td>
                       <input class="form-check-input"  name="fisik[tenggorokan_check]" type="hidden" value="" id="flexCheckDefault">
                     
                       <input class="form-check-input"  name="fisik[tenggorokan_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                   
                       Tidak Ada Keluhan
                     </td>
                      <tr>
                      
                       <td  style="padding: 5px;">
                       
                        <input name="fisik[tenggorokan]" type="text" class="form-control" id="" value="" >
                     
                       </td>
                      </tr>
                 </tr>  
     
                    <tr>
                         <td rowspan="2"  style="width:20%;">Hidung / Muka</td>
                         <td>
                          <input class="form-check-input"  name="fisik[hidung_muka_check]" type="hidden" value="" id="flexCheckDefault">
                        
                          <input class="form-check-input"  name="fisik[hidung_muka_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                        
                          Tidak Ada Keluhan
                        </td>
                         <tr> --}}
                         
                          {{-- @php
                              dd(json_decode(@$riwayat[0]->fisik,true)['hidung_muka_check']);
                          @endphp --}}

                          {{-- <td  style="padding: 5px;">
                           
                            <input name="fisik[hidung_muka]" type="text" class="form-control" id="" value="" >
                         
                          </td>
                         </tr>
                    </tr>   --}}
                     
     
     
     
     
     
     
     
     
     
                         {{-- </tr> 
                       </table> --}}
                     

          


          













              






                     



          {{-- </div> --}}
          {{-- <div class="col-md-6">
            <h5><b>Edukasi Pasien & Keluarga</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:50%;">Kebutuhan Dan Pengajaran (Orang Tua : Ayah / Ibu / Keluarga / lainnya)</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[kebutuhan_dan_pengajaran]" id="" cols="30" rows="10" ></textarea>
                </td>
              </tr>
              <tr>
                <td rowspan="3" style="width:50%;">Edukasi Di Berikan Kepada</td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[edukasi_diberikan]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[edukasi_diberikan]" type="checkbox" value="Ada" id="flexCheckDefault">
                      Orang Tua
                    </label>
                  </td>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="fisik[edukasi_diberikan_keluarga]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[edukasi_diberikan_keluarga]" type="checkbox" value="Keluarga" id="edukasiDiberikan" onclick="diberikan()">
                      Keluarga
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="fisik[hubungan]" placeholder="Hubungan Dengan Pasien" class="form-control" id="edukasiDiberikanText">
                    </td>
                  </tr>
               
              </tr>




              <tr>
                <td rowspan="3" style="width:50%;">Bicara </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[normal]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[normal]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Normal 
                    </label>
                  </td>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="fisik[gangguan_bicara]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[gangguan_bicara]" type="checkbox" value="Ya" id="bicaraId" onclick="bicara()">
                      Serangan Awal Gangguan Bicara
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="fisik[kapan_gangguan]" placeholder="Kapan" class="form-control" id="bicaraText">
                    </td>
                  </tr>
               
              </tr>








              <tr>
                <td rowspan="4" style="width:50%;">Bicara Sehari-hari</td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[indonesia]" type="hidden" value="pasif" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[indonesia]" type="checkbox" value="aktif" id="flexCheckDefault">
                      Indonesia (aktif / pasif)
                    </label>
                  </td>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[inggris]" type="hidden" value="pasif" id="flexCheckDefault">
                        <input class="form-check-input"  name="fisik[inggris]" type="checkbox" value="aktif" id="flexCheckDefault">
                        Inggris (aktif / pasif)
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="fisik[daerah]" type="hidden" value="pasif" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[daerah]" type="checkbox" value="aktif" id="bicaraSeharihariId" onclick="bicaraSeharihari()">
                      Daerah
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="fisik[jelaskan]" placeholder="Jelaskan" class="form-control" id="bicaraSeharihariText">
                    </td>
                  </tr>
               
              </tr>




              <tr>
                <td  style="width:50%;">Perlu Penerjemah </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[perlu_penerjemah]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[perlu_penerjemah]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Perlu Penerjemah
                    </label>
                  </td>
               
              </tr>




              <tr>
                <td rowspan="7" style="width:50%;">Hambatan Edukasi </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[bahasa]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[bahasa]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Bahasa
                    </label>
                  </td>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[pendengaran]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[pendengaran]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Pendengaran
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[hilang_memori]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[hilang_memori]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Hilang Memori
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[motivasi_buruk]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[motivasi_buruk]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Motivasi Buruk
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[masalah_penglihatan]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[masalah_penglihatan]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Masalah Penglihatan
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[cemas]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[cemas]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Cemas
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[hambatan_belajar]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[hambatan_belajar]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Tidak Ditemukan Hambatan Belajar
                    </label>
                  </td>
                 </tr>
               
              </tr> --}}






              {{-- <tr>
                <td rowspan="7" style="width:50%;">Cara Edukasi Yang Disukai </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[menulis]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[menulis]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Menulis
                    </label>
                  </td>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[audio_visual]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[audio_visual]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Audio Visual / Gambar
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[diskusi]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[diskusi]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Diskusi
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[membaca]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[membaca]" type="checkbox" value="Ya" id="flexCheckDefault">
                     Membaca
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[mendengar]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[mendengar]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Mendengar
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[demonstrasi]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[demonstrasi]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Demonstrasi
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <input type="text" class="form-control" name="fisik[lainnya_disukai]" placeholder="Lainnya">
                  </td>
                 </tr>
               
              </tr> --}}






              {{-- <tr>
                <td rowspan="4" style="width:50%;">Kebutuhan Edukasi</td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[proses_penyakit]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[proses_penyakit]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Proses Penyakit
                    </label>
                  </td>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[pengobatan]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[pengobatan]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Pengobatan
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[nutrisi]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[nutrisi]" type="checkbox" value="Ya" id="flexCheckDefault">
                    Nutrisi
                    </label>
                  </td>
                 </tr>   
                 <tr>
                  <td>
                    <input type="text" class="form-control" name="fisik[lainnya_kebutuhan]" placeholder="Lainnya">
                  </td>
                 </tr>
               
              </tr>








              <tr>
                <td rowspan="3" style="width:50%;">Alergi </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[tidak_alergi]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[tidak_alergi]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Tidak
                    </label>
                  </td>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="fisik[ya_alergi]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"  name="fisik[ya_alergi]" type="checkbox" value="Ya" id="alergiId" onclick="alergi()">
                     Ya
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="fisik[jelaskan_alergi]" placeholder="jelaskan" class="form-control" id="alergiText">
                    </td>
                  </tr>
               
              </tr> --}}



        {{-- <div class="col-md-6">
           
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>Status Pediatri</b></h5>
              <tr> --}}
                {{-- <td style="width:20%;">Alat Bantu</td> --}}
                  {{-- <td style="padding: 5px;">
                    <textarea rows="5" name="fisik[padiatric]" style="display:inline-block" placeholder="[masukkan padiatric]" class="form-control" ></textarea>
                  </td>
              </tr>
            </table>
            <h5><b>Status Gizi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="padding:5px;">
                <textarea rows="5" name="fisik[gizi]" style="display:inline-block" placeholder="[masukkan status gizi]" class="form-control" ></textarea>
                </td>
              </tr> 
            </table>
            <h5><b>Riwayat Imunisasi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="padding:5px;">
                <textarea rows="5" name="fisik[imunisasi]" style="display:inline-block" placeholder="[masukkan riwayat imunisasi]" class="form-control" ></textarea>
                </td>
              </tr> 
            </table>
            <h5><b>Riwayat Tumbuh Kembang</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="padding:5px;">
                <textarea rows="5" name="fisik[tumbuh]" style="display:inline-block" placeholder="[masukkan riwayat tumbuh kembang]" class="form-control" ></textarea>
                </td>
              </tr> 
            </table>
          </div> --}}






          {{-- <div class="col-md-6">
           
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>Planning</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="5" name="fisik[planing]" style="display:inline-block" placeholder="[masukkan planing]" class="form-control" ></textarea>
                  </td>
              </tr>
            </table>
            <h5><b>Diagnosa Keperawatan</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="padding:5px;">
                <textarea rows="5" name="fisik[diagnosa_perawat]" style="display:inline-block" placeholder="[masukkan diagnosa perawat]" class="form-control" ></textarea>
                </td>
              </tr> 
            </table>
          </div> --}}














          






            {{-- </table>
          </div> --}}


          
          
          <br /><br />
        </div>
      </div>
      
      {{-- <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div> --}}
    {{-- </form> --}}

    @if (@$dataPegawai == '1')
    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
      <h5><b>7. TINDAKAN</b></h5>
      <tr>
          <td style="padding: 5px;">
            {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('poli_id', $poli) !!}
            {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
            {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
            {!! Form::hidden('pelaksana', $reg->dokter_id) !!}
            {!! Form::hidden('tanggal', Carbon\Carbon::now()->format('d-m-Y')) !!}
            {!! Form::hidden('jumlah', 1) !!}
            <select name="tarif_id[]" id="select2Multiple" class="form-control" multiple="multiple"></select>
            <small class="text-danger">{{ $errors->first('tarif_id') }}</small> 
            <div class="form-group" style="margin-top: 10px;">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::submit("Simpan Tindakan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
              </div>
            </div> 
            {!! Form::close() !!}
          </td>
      </tr>
    </table>
    @endif
  </div>

    {{-- Modal List Kontrol ======================================================================== --}}
    <div class="modal fade" id="showListKontrol" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">List Kontrol</h4>
              </div>
              <div class="modal-body">
                  <div id="dataListKontrol">
                      <div class="spinner-square">
                          <div class="square-1 square"></div>
                          <div class="square-2 square"></div>
                          <div class="square-3 square"></div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
              </div>
          </div>
      </div>
    </div>
    {{-- End Modal List Kontrol ======================================================================== --}}

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
        // $(".date_tanpa_tanggal").datepicker( {
        //     format: "dd/mm/yyyy",
        //     autoclose: true
        // });
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd-mm-yyyy",
            autoclose: true
        });
        $("#date_dengan_tanggal").attr('', true);
    
        $(document).ready(function() {
          // Select2 Multiple
          $('.select2-multiple').select2({
              placeholder: "Pilih Multi Tindakan",
              allowClear: true
          });
  
      });
  
      // MASTER OBAT
   $('#select2Multiple').select2({
        placeholder: "Klik untuk isi nama tindakan",
        width: '100%',
        ajax: {
            url: '/tindakan/ajax-tindakan/'+status_reg,
            dataType: 'json',
            data: function (params) {
                return {
                    j: 1,
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    })
  
    $(document).ready(function() {
      //TINDAKAN entry
      $('select[name="kategoriTarifID"]').on('change', function() {
          var tarif_id = $(this).val();
          if(tarif_id) {
              $.ajax({
                  url: '/tindakan/getTarif/'+tarif_id,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {
                      //$('select[name="tarif_id"]').append('<option value=""></option>');
                      $('select[name="tarif_id"]').empty();
                      $.each(data, function(id, nama, total) {
                          $('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
                      });
  
                  }
              });
          }else{
              $('select[name="tarif_id"]').empty();
          }
      });
    });
    
    $('.hitungResiko').on('change', function (){
    var total = 0 ;
    var hasil = $('.hasilSkorResiko');
    $('.hitungResiko:checked').each(function (){
      total += parseInt($(this).val());
    });

    $('.jumlahSkorResiko').val(total);

    if(total <= 24){
      hasil.val('Tidak Berisiko');
    }else if(total <= 50){
      hasil.val('Risiko Rendah');
    }else if(total >50){
      hasil.val('Risiko Tinggi');
    }
  });
  </script>
   <script>
    function diberikan() {
      var checkBox = document.getElementById("edukasiDiberikan");
      var text = document.getElementById("edukasiDiberikanText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicara() {
      var checkBox = document.getElementById("bicaraId");
      var text = document.getElementById("bicaraText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicaraSeharihari() {
      var checkBox = document.getElementById("bicaraSeharihariId");
      var text = document.getElementById("bicaraSeharihariText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function alergi() {
      var checkBox = document.getElementById("alergiId");
      var text = document.getElementById("alergiText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    </script>
    <script type="text/javascript">
     $('#historiAskep').click( function(e) {
      var id = $(this).attr('data-pasienID');
      $('#showHistoriAskep').modal('show');
      $('#dataHistoriAskep').load("/emr-riwayat-askep/" + id);
  });
  </script>
  <script>
    $('.select2-diagnosis').select2({
          placeholder: "Pilih Diagnosa",
          allowClear: true,
          width: '85%'
      });
      $('.select2-pemeriksaanDalam').select2({
          placeholder: "Pilih Intervensi",
          allowClear: true
      });
      $('.select2-fungsional').select2({
          placeholder: "Pilih Impelemntasi",
          allowClear: true
      });

      $('#select2-diagnosis').change(function(e){
      var intervensi = $('#select2-pemeriksaanDalam');
      var implementasi = $('#select2-fungsional');
      var diagnosa = $(this).val();

      intervensi.empty();
      implementasi.empty();

      $.ajax({
        url: '/emr-get-askep?namaDiagnosa='+diagnosa,
        type: 'get',
        dataType: 'json',
      })
      .done(function(res) {
        if(res[0].metadata.code == 200){
          $.each(res[1], function(index, val){
            intervensi.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
          })
          $.each(res[2], function(index, val){
            implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
          })
        }
      })

    });
    

    $(document).on('click', '#listKontrol1', function(e) {
      var id = $(this).attr('data-dokterID');
      var tgl = $('#waktuKontrol1').val();
      
      if(tgl == null || tgl == ''){
        alert('Harap Isi Tanggal Kontrol');
      }else{
        $('#showListKontrol').modal('show');
        $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
      }
    });

    $(document).on('click', '#listKontrol2', function(e) {
      var id = $(this).attr('data-dokterID');
      var tgl = $('#waktuKontrol2').val();
      
      if(tgl == null || tgl == ''){
        alert('Harap Isi Tanggal Kontrol');
      }else{
        $('#showListKontrol').modal('show');
        $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
      }
    });
  </script>
  @endsection