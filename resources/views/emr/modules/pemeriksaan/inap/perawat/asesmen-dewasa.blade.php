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
<h1>Asesmen</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen-inap-perawat-dewasa/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
        
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <h4 style="text-align: center; padding: 10px"><b>Pengkajian Awal Keperawatan Dewasa</b></h4>
          <br>

          <div class="col-md-12">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">User</th>
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
                            {{ @$riwayat->user->name }}
                        </td>
                        <td style="text-align: center;">
                          <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
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

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>KEADAAN UMUM</b></h5>

              <tr>
                <td colspan="3" style="width:50%; font-weight:bold;">1. Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Tekanan Darah (mmHG)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['tekanan_darah']}}">
                </td>
                <td colspan="2" style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['nadi']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Pernapasan (x/menit)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][RR]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['RR']}}">
                </td>
                <td colspan="2" style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Suhu (°C)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][temp]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['temp']}}">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">2. Kesadaran</td>
                <td colspan="2">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap">
                        <div>
                            <input type="radio" id="kesadaran1" name="fisik[keadaan_umum][kesadaran]" value="Composmentis" {{@$assesment['keadaan_umum']['kesadaran'] == 'Composmentis' ? 'checked' : ''}}>
                            <label for="kesadaran1" style="font-weight: normal;">Composmentis</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran2" name="fisik[keadaan_umum][kesadaran]" value="Lethargi" {{@$assesment['keadaan_umum']['kesadaran'] == 'Lethargi' ? 'checked' : ''}}>
                            <label for="kesadaran2" style="font-weight: normal;">Lethargi</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran3" name="fisik[keadaan_umum][kesadaran]" value="Koma" {{@$assesment['keadaan_umum']['kesadaran'] == 'Koma' ? 'checked' : ''}}>
                            <label for="kesadaran3" style="font-weight: normal;">Koma</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran4" name="fisik[keadaan_umum][kesadaran]" value="Apatis" {{@$assesment['keadaan_umum']['kesadaran'] == 'Apatis' ? 'checked' : ''}}>
                            <label for="kesadaran4" style="font-weight: normal;">Apatis</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran5" name="fisik[keadaan_umum][kesadaran]" value="Sopor" {{@$assesment['keadaan_umum']['kesadaran'] == 'Sopor' ? 'checked' : ''}}>
                            <label for="kesadaran5" style="font-weight: normal;">Sopor</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran6" name="fisik[keadaan_umum][kesadaran]" value="Dellrium" {{@$assesment['keadaan_umum']['kesadaran'] == 'Dellrium' ? 'checked' : ''}}>
                            <label for="kesadaran6" style="font-weight: normal;">Dellrium</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran7" name="fisik[keadaan_umum][kesadaran]" value="Somnolen" {{@$assesment['keadaan_umum']['kesadaran'] == 'Somnolen' ? 'checked' : ''}}>
                            <label for="kesadaran7" style="font-weight: normal;">Somnolen</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran8" name="fisik[keadaan_umum][kesadaran]" value="Semi Koma" {{@$assesment['keadaan_umum']['kesadaran'] == 'Semi Koma' ? 'checked' : ''}}>
                            <label for="kesadaran8" style="font-weight: normal;">Semi Koma</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran9" name="fisik[keadaan_umum][kesadaran]" value="GCS" {{@$assesment['keadaan_umum']['kesadaran'] == 'GCS' ? 'checked' : ''}}>
                            <label for="kesadaran9" style="font-weight: normal;">GCS :</label><br>
                                <label class="form-check-label" style="margin-right: 20px;">E</label>
                                <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 50px;" placeholder="E" class="form-control gcs" id="" value="{{@$assesment['GCS']['E']}}">
                                <label class="form-check-label" style="margin-right: 20px;">M</label>
                                <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 50px;" placeholder="M" class="form-control gcs" id="" value="{{@$assesment['GCS']['M']}}">
                                <label class="form-check-label" style="margin-right: 20px;">V</label>
                                <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 50px;" placeholder="V" class="form-control gcs" id="" value="{{@$assesment['GCS']['V']}}">
                        </div>
                    </div>
                </td>
              </tr>

              <tr>
                <td  style="width:20%; font-weight:bold;">
                    3. Asesmen Nyeri
                </td>
                <td colspan="2" style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][pilihan]"
                            {{ @$assesment['asesmenNyeri']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak Ada</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][pilihan]"
                            {{ @$assesment['asesmenNyeri']['pilihan'] == 'Ada' ? 'checked' : '' }}
                            type="radio" value="Ada">
                        <label class="form-check-label">Ada (Lanjut ke deskripsi nyeri)</label>
                    </div>
                </td>
              </tr>
              <tr>
                  <td  style="">
                      Provokatif
                  </td>
                  <td colspan="2" style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Bantuan' ? 'checked' : '' }}
                              type="radio" value="Bantuan" id="crMasuk.1">
                          <label class="form-check-label">Bantuan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Spontan' ? 'checked' : '' }}
                              type="radio" value="Spontan" id="crMasuk.2">
                          <label class="form-check-label">Spontan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Aktivitas' ? 'checked' : '' }}
                              type="radio" value="Aktivitas" id="crMasuk.3">
                          <label class="form-check-label">Aktivitas</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Lain - lain' ? 'checked' : '' }}
                              type="radio" value="Lain - lain" id="crMasuk.4">
                          <label class="form-check-label">Lain - lain</label>
                          <input name="fisik[keadaan_umum][asesmenNyeri][provokatif_lain]" type="text" class="form-control" placeholder="Isi jika lain-lain" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif_lain']}}">
                      </div>
                  </td>
              </tr>
              <tr>
                  <td  style="">
                      Quality
                  </td>
                  <td style="padding: 5px;">
                      <div style="width: 150px;">
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Seperti tertusuk benda tajam/tumpul' ? 'checked' : '' }}
                              type="radio" value="Seperti tertusuk benda tajam/tumpul" id="crMasuk.1">
                          <label class="form-check-label">Seperti tertusuk benda tajam/tumpul</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Berdenyut' ? 'checked' : '' }}
                              type="radio" value="Berdenyut" id="crMasuk.2">
                          <label class="form-check-label">Berdenyut</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Terpelintir' ? 'checked' : '' }}
                              type="radio" value="Terpelintir" id="crMasuk.2">
                          <label class="form-check-label">Terpelintir</label>
                      </div>
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Terbakar' ? 'checked' : '' }}
                              type="radio" value="Terbakar" id="crMasuk.3">
                          <label class="form-check-label">Terbakar</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Tertindih' ? 'checked' : '' }}
                              type="radio" value="Tertindih" id="crMasuk.3">
                          <label class="form-check-label">Tertindih</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Lain - lain' ? 'checked' : '' }}
                              type="radio" value="Lain - lain" id="crMasuk.4">
                          <label class="form-check-label">Lain - lain</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td style="">
                      Region
                  </td>
                  <td colspan="2" style="padding: 5px;">
                      <div>
                          <label class="form-check-label">Lokasi</label>
                          <input type="text" class="form-control" placeholder="Isi Lokasi" name="fisik[keadaan_umum][asesmenNyeri][region][lokasi]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['lokasi'] }}">
                      </div>
                      <div>
                          <label class="form-check-label">Menyebar</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][region][menyebar][pilihan]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['menyebar']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label">Tidak</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][region][menyebar][pilihan]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['menyebar']['pilihan'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label">Ya</label>
                          <input type="text" class="form-control" placeholder="Isi jika Ya" name="fisik[keadaan_umum][asesmenNyeri][region][menyebar][detail_ya]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['menyebar']['detail_ya'] }}">
                      </div>
                  </td>
              </tr>
              <tr>
                  <td  style="">
                      Severity
                  </td>
                  <td colspan="2" style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'NFS, Score' ? 'checked' : '' }}
                              type="radio" value="NFS, Score">
                          <label class="form-check-label">NFS, Score</label>
                          <input type="text" class="form-control" placeholder="NFS, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][nfs_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['nfs_score'] }}">
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'Wong Baker Face, Score' ? 'checked' : '' }}
                              type="radio" value="Wong Baker Face, Score">
                          <label class="form-check-label">Wong Baker Face, Score</label>
                          <input type="text" class="form-control" placeholder="Wong Baker Face, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][wong_baker_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['wong_baker_score'] }}">
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'NIPS, Score' ? 'checked' : '' }}
                              type="radio" value="NIPS, Score">
                          <label class="form-check-label">NIPS, Score</label>
                          <input type="text" class="form-control" placeholder="NIPS, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][nips_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['nips_score'] }}">
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'FLACCS, Score' ? 'checked' : '' }}
                              type="radio" value="FLACCS, Score">
                          <label class="form-check-label">FLACCS, Score</label>
                          <input type="text" class="form-control" placeholder="FLACCS, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][flaccs_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['flaccs_score'] }}">
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'CPOT, Score' ? 'checked' : '' }}
                              type="radio" value="CPOT, Score">
                          <label class="form-check-label">CPOT, Score</label>
                          <input type="text" class="form-control" placeholder="CPOT, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][cpot_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['cpot_score'] }}">
                      </div>
                  </td>
              </tr>
              <tr>
                  <td style="">
                      Time (Durasi Nyeri)
                  </td>
                  <td style="padding: 5px;" colspan="2">
                      <div>
                          <input type="text" class="form-control" placeholder="Durasi Nyeri" name="fisik[keadaan_umum][asesmenNyeri][durasi_nyeri]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['durasi_nyeri'] }}">
                      </div>
                  </td>
              </tr>
              <tr>
                <td>Nyeri hilang jika</td>
                <td colspan="2" style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[keadaan_umum][asesmenNyeri][nyeriHilangJika][pilihan]"
                          {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilangJika']['pilhan'] == 'Bantuan' ? 'checked' : '' }}
                          type="radio" value="Bantuan">
                      <label class="form-check-label">Bantuan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[keadaan_umum][asesmenNyeri][nyeriHilangJika][pilihan]"
                          {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilangJika']['pilhan'] == 'Spontan' ? 'checked' : '' }}
                          type="radio" value="Spontan">
                      <label class="form-check-label">Spontan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[keadaan_umum][asesmenNyeri][nyeriHilangJika][pilihan]"
                          {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilangJika']['pilhan'] == 'Aktivitas' ? 'checked' : '' }}
                          type="radio" value="Aktivitas">
                      <label class="form-check-label">Aktivitas</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[keadaan_umum][asesmenNyeri][nyeriHilangJika][pilihan]"
                          {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilangJika']['pilhan'] == 'Lain - lain' ? 'checked' : '' }}
                          type="radio" value="Lain - lain">
                      <label class="form-check-label">Lain - lain</label>
                      <input name="fisik[keadaan_umum][asesmenNyeri][nyeriHilangJika][penjelasan]" type="text" class="form-control" placeholder="Isi jika lain-lain" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilangJika']['penjelasan']}}">
                  </div>
              </td>
              </tr>

              
            </table>
          </div>
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>KEADAAN KESEHATAN</b></h5>
              <tr>
                <td style="font-weight: bold;">1. Keluhan Utama</td>
                <td>
                  <textarea name="fisik[keadaanKesehatan][keluhanUtama]" class="form-control" style="resize: vertical;" rows="5">{{ @$assesment['keadaanKesehatan']['keluhanUtama'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">2. Riwayat Penyakit Sekarang</td>
                <td>
                  <textarea name="fisik[keadaanKesehatan][riwayatPenyakitSekarang]" class="form-control" style="resize: vertical;" rows="5">{{ @$assesment['keadaanKesehatan']['riwayatPenyakitSekarang'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="font-weight: bold;">3. Riwayat Penyakit Dahulu</td>
              </tr>
              <tr>
                <td>Pernah Dirawat</td>
                <td>
                  <label for="pernahDirawat_1" style="margin-right: 10px;">
                    <input id="pernahDirawat_1" type="radio" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][pernahDirawat][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['pernahDirawat']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="pernahDirawat_2" style="margin-right: 10px;">
                    <input id="pernahDirawat_2" type="radio" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][pernahDirawat][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['pernahDirawat']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <input type="text" class="form-control" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][pernahDirawat][penjelasan]" value="{{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['pernahDirawat']['penjelasan'] }}">
                </td>
              </tr>
              <tr>
                <td>Riwayat Alergi</td>
                <td>
                  <label for="riwayatAlergi_1" style="margin-right: 10px;">
                    <input id="riwayatAlergi_1" type="radio" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][riwayatAlergi][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['riwayatAlergi']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="riwayatAlergi_2" style="margin-right: 10px;">
                    <input id="riwayatAlergi_2" type="radio" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][riwayatAlergi][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['riwayatAlergi']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <input type="text" class="form-control" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][riwayatAlergi][penjelasan]" value="{{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['riwayatAlergi']['penjelasan'] }}">
                </td>
              </tr>
              <tr>
                <td>Rwayat Pemakaian Obat</td>
                <td>
                  <label for="riwayatPemakaianObat_1" style="margin-right: 10px;">
                    <input id="riwayatPemakaianObat_1" type="radio" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][riwayatPemakaianObat][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['riwayatPemakaianObat']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="riwayatPemakaianObat_2" style="margin-right: 10px;">
                    <input id="riwayatPemakaianObat_2" type="radio" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][riwayatPemakaianObat][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['riwayatPemakaianObat']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <input type="text" class="form-control" name="fisik[keadaanKesehatan][riwayatPenyakitDahulu][riwayatPemakaianObat][penjelasan]" value="{{ @$assesment['keadaanKesehatan']['riwayatPenyakitDahulu']['riwayatPemakaianObat']['penjelasan'] }}">
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold;">4. Riwayat Penyakit Penyerta</td>
                <td>
                  <label for="riwayatPenyakitPenyerta_1" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_1" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan1]" class="form-check-input" value="DM" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan1'] == 'DM' ? 'checked' : '' }}>
                    DM
                  </label>
                  <label for="riwayatPenyakitPenyerta_2" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_2" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan2]" class="form-check-input" value="Hipertensi" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan2'] == 'Hipertensi' ? 'checked' : '' }}>
                    Hipertensi
                  </label>
                  <label for="riwayatPenyakitPenyerta_3" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_3" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan3]" class="form-check-input" value="Kolestrol" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan3'] == 'Kolestrol' ? 'checked' : '' }}>
                    Kolestrol
                  </label>
                  <label for="riwayatPenyakitPenyerta_4" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_4" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan4]" class="form-check-input" value="Hepatitis" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan4'] == 'Hepatitis' ? 'checked' : '' }}>
                    Hepatitis
                  </label>
                  <label for="riwayatPenyakitPenyerta_5" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_5" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan5]" class="form-check-input" value="Jantung" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan5'] == 'Jantung' ? 'checked' : '' }}>
                    Jantung
                  </label>
                  <label for="riwayatPenyakitPenyerta_6" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_6" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan6]" class="form-check-input" value="Kanker" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan6'] == 'Kanker' ? 'checked' : '' }}>
                    Kanker
                  </label>
                  <label for="riwayatPenyakitPenyerta_7" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_7" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan7]" class="form-check-input" value="Genetik" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan7'] == 'Genetik' ? 'checked' : '' }}>
                    Genetik
                  </label>
                  <label for="riwayatPenyakitPenyerta_8" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_8" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan8]" class="form-check-input" value="TBC" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan8'] == 'TBC' ? 'checked' : '' }}>
                    TBC
                  </label>
                  <label for="riwayatPenyakitPenyerta_9" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_9" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan9]" class="form-check-input" value="Tidak Ada" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan9'] == 'Tidak Ada' ? 'checked' : '' }}>
                    Tidak Ada
                  </label>
                  <label for="riwayatPenyakitPenyerta_9" style="margin-right: 10px;">
                    <input id="riwayatPenyakitPenyerta_9" type="checkbox" name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][pilihan10]" class="form-check-input" value="Lainnya" {{ @$assesment['keadaanKesehatan']['riwayatPenyakitPenyerta']['pilihan10'] == 'Lainnya' ? 'checked' : '' }}>
                    Lainnya
                  </label>
                  <textarea name="fisik[keadaanKesehatan][riwayatPenyakitPenyerta][lainnya]" placeholder="lainnya" class="form-control" style="resize: vertical;" rows="1">{{ @$assesment['riwayatPenyakitPenyerta']['riwayatPenyakitPenyerta']['lainnya'] }}</textarea>
                </td>
              </tr>

              <tr>
                <td colspan="2">
                  <a href="{{url('/emr-soap/penilaian/fisik/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                </td>
              </tr>
              <tr>
                <td colspan="2"><b>Status Lokalis :</b> 
                  
                   @if (@$gambar->image != null)
                    
                   {{-- <a id="myImg"><i class="fa fa-eye text-primary"></i></a> --}}
                    <br>
                    <img src="/images/{{ @$gambar['image'] }}" id="dataImage" style="width: 400px; height:300px;">
                    <br>
                    <label for="">Keterangan Lokalis</label>
                    <br>
                    <ol>
                      <li>{{ @$ketGambar['keterangan'][0][1] ? @$ketGambar['keterangan'][0][1] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][1][2] ? @$ketGambar['keterangan'][1][2] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][2][3] ? @$ketGambar['keterangan'][2][3] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][3][4] ? @$ketGambar['keterangan'][3][4] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][4][5] ? @$ketGambar['keterangan'][4][5] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][5][6] ? @$ketGambar['keterangan'][5][6] : '-' }} </li>
                    </ol>
                      
                  @else

                    -

                   @endif
                
                </td>
               </tr>
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                    
                    <tr>
                        <td style="font-weight: bold" colspan="2">Riwayat Psikologis</td>
                    </tr>

                    <tr>
                        <td>
                            <div style="display: flex; gap: 10px">
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][takut_terapi]"
                                    {{ @$assesment['riwayat_psikologis']['takut_terapi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Takut terhadap terapi / pembedahan / lingkungan RS</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][marah]"
                                    {{ @$assesment['riwayat_psikologis']['marah'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Marah / Tegang</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][sedih]"
                                    {{ @$assesment['riwayat_psikologis']['sedih'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Sedih</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][kecenderungan_bunuh_diri]"
                                    {{ @$assesment['riwayat_psikologis']['kecenderungan_bunuh_diri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Kecenderungan Bunuh Diri</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][lain_lain]"
                                    {{ @$assesment['riwayat_psikologis']['lain_lain'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Lain-lain, sebutkan</label>
                                    <input type="text" class="form-control" placeholder="Sebutkan" name="fisik[riwayat_psikologis][lain_detail]" value="{{@$assesment['riwayat_psikologis']['lain_detail']}}" style="width: 100%">
                                </div>
                            </div>
                        </td>
                    </tr>
               </table>
            
          </div>

          <div class="col-md-12">
            <h5><b>PEMERIKSAAN FISIK</b></h5>
          </div>
          
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2" style="font-weight: bold;">SISTEM RESPIRASI DAN OKSIGENASI</td>
              </tr>
              <tr>
                <td>Obstruksi saluran napas atas</td>
                <td>
                  <label for="obstruksiSaluranNapas_1" style="margin-right: 10px;">
                    <input id="obstruksiSaluranNapas_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][obstruksiSaluranNapas][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['obstruksiSaluranNapas']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                  <label for="obstruksiSaluranNapas_2" style="margin-right: 10px;">
                    <input id="obstruksiSaluranNapas_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][obstruksiSaluranNapas][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['obstruksiSaluranNapas']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>Sesak Nafas (Dyspnea)</td>
                <td>
                  <label for="sesakNafas_1" style="margin-right: 10px;">
                    <input id="sesakNafas_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][sesakNafas][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['sesakNafas']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                  <label for="sesakNafas_2" style="margin-right: 10px;">
                    <input id="sesakNafas_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][sesakNafas][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['sesakNafas']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>Batuk</td>
                <td>
                  <label for="batuk_1" style="margin-right: 10px;">
                    <input id="batuk_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][batuk][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['batuk']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                  <label for="batuk_2" style="margin-right: 10px;">
                    <input id="batuk_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][batuk][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['batuk']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>Bunyi Nafas</td>
                <td>
                  <label for="bunyiNafas_1" style="margin-right: 10px;">
                    <input id="bunyiNafas_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][bunyiNafas][pilihan]" class="form-check-input" value="Normal" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['bunyiNafas']['pilihan'] == 'Normal' ? 'checked' : '' }}>
                    Normal
                  </label>
                  <label for="bunyiNafas_2" style="margin-right: 10px;">
                    <input id="bunyiNafas_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][bunyiNafas][pilihan]" class="form-check-input" value="Abnormal" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['bunyiNafas']['pilihan'] == 'Abnormal' ? 'checked' : '' }}>
                    Abnormal
                  </label>
                  <br>
                  <small><i>Jika Abnormal</i></small>
                  <br>
                  <label for="bunyiNafas_3" style="margin-right: 10px;">
                    <input id="bunyiNafas_3" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][bunyiNafas][detail]" class="form-check-input" value="Wheezing" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['bunyiNafas']['detail'] == 'Wheezing' ? 'checked' : '' }}>
                    Wheezing
                  </label>
                  <label for="bunyiNafas_4" style="margin-right: 10px;">
                    <input id="bunyiNafas_4" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][bunyiNafas][detail]" class="form-check-input" value="Rales" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['bunyiNafas']['detail'] == 'Rales' ? 'checked' : '' }}>
                    Rales
                  </label>
                  <label for="bunyiNafas_5" style="margin-right: 10px;">
                    <input id="bunyiNafas_5" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][bunyiNafas][detail]" class="form-check-input" value="Ronchl" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['bunyiNafas']['detail'] == 'Ronchl' ? 'checked' : '' }}>
                    Ronchl
                  </label>
                </td>
              </tr>
              <tr>
                <td>Thorax</td>
                <td>
                  <label for="thorax_1" style="margin-right: 10px;">
                    <input id="thorax_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][thorax][pilihan]" class="form-check-input" value="Simetris" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['thorax']['pilihan'] == 'Simetris' ? 'checked' : '' }}>
                    Simetris
                  </label>
                  <label for="thorax_2" style="margin-right: 10px;">
                    <input id="thorax_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][thorax][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['thorax']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>CTT</td>
                <td>
                  <label for="ctt_1" style="margin-right: 10px;">
                    <input id="ctt_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][ctt][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['ctt']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="ctt_2" style="margin-right: 10px;">
                    <input id="ctt_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][ctt][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['ctt']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                </td>
              </tr>
              <tr>
                <td>Sputum</td>
                <td>
                  <label for="sputum_1" style="margin-right: 10px;">
                    <input id="sputum_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][sputum][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['sputum']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="sputum_2" style="margin-right: 10px;">
                    <input id="sputum_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][sputum][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['sputum']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                  <br>
                  <input type="text" class="form-control" placeholder="Warna" name="fisik[pemeriksaanFisik][sistemRespirasi][sputum][warna]" value="{{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['sputum']['warna'] }}">
                </td>
              </tr>
              <tr>
                <td>Krepitasi</td>
                <td>
                  <label for="krepitasi_1" style="margin-right: 10px;">
                    <input id="krepitasi_1" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][krepitasi][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['krepitasi']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="krepitasi_2" style="margin-right: 10px;">
                    <input id="krepitasi_2" type="radio" name="fisik[pemeriksaanFisik][sistemRespirasi][krepitasi][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['krepitasi']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <br>
                  <input type="text" class="form-control" placeholder="Area" name="fisik[pemeriksaanFisik][sistemRespirasi][sputum][area]" value="{{ @$assesment['pemeriksaanFisik']['sistemRespirasi']['sputum']['area'] }}">
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2" style="font-weight: bold;">SISTEM KARDIOVASKULER</td>
              </tr>
              <tr>
                <td>Nadi</td>
                <td>
                  <input type="number" class="form-control" placeholder="x/menit" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][nadi][detail]" value="{{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['nadi']['detail'] }}">
                  <br>
                  <label for="nadi_1" style="margin-right: 10px;">
                    <input id="nadi_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][nadi][pilihan]" class="form-check-input" value="Reguler" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['nadi']['pilihan'] == 'Reguler' ? 'checked' : '' }}>
                    Reguler
                  </label>
                  <label for="nadi_2" style="margin-right: 10px;">
                    <input id="nadi_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][nadi][pilihan]" class="form-check-input" value="Irreguler" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['nadi']['pilihan'] == 'Irreguler' ? 'checked' : '' }}>
                    Irreguler
                  </label>
                  
                </td>
              </tr>
              <tr>
                <td>Konjungtiva</td>
                <td>
                  <label for="konjungtiva_1" style="margin-right: 10px;">
                    <input id="konjungtiva_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][konjungtiva][pilihan]" class="form-check-input" value="Pucat" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['konjungtiva']['pilihan'] == 'Pucat' ? 'checked' : '' }}>
                    Pucat
                  </label>
                  <label for="konjungtiva_2" style="margin-right: 10px;">
                    <input id="konjungtiva_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][konjungtiva][pilihan]" class="form-check-input" value="Merah Muda" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['konjungtiva']['pilihan'] == 'Merah Muda' ? 'checked' : '' }}>
                    Merah Muda
                  </label>
                </td>
              </tr>
              <tr>
                <td>Riwayat Pemasangan Alat</td>
                <td>
                  <label for="riwayatPemasanganAlat_1" style="margin-right: 10px;">
                    <input id="riwayatPemasanganAlat_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][riwayatPemasanganAlat][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['riwayatPemasanganAlat']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="riwayatPemasanganAlat_2" style="margin-right: 10px;">
                    <input id="riwayatPemasanganAlat_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][riwayatPemasanganAlat][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['riwayatPemasanganAlat']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                  <br>
                  <small><i>Jika Ada</i></small>
                  <br>
                  <label for="riwayatPemasanganAlat_3" style="margin-right: 10px;">
                    <input id="riwayatPemasanganAlat_3" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][riwayatPemasanganAlat][detail]" class="form-check-input" value="Pace Maker" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['riwayatPemasanganAlat']['detail'] == 'Pace Maker' ? 'checked' : '' }}>
                    Pace Maker
                  </label>
                  <label for="riwayatPemasanganAlat_4" style="margin-right: 10px;">
                    <input id="riwayatPemasanganAlat_4" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][riwayatPemasanganAlat][detail]" class="form-check-input" value="Ring" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['riwayatPemasanganAlat']['detail'] == 'Ring' ? 'checked' : '' }}>
                    Ring
                  </label>
                </td>
              </tr>
              <tr>
                <td>Kulit</td>
                <td>
                  <label for="kulit_1" style="margin-right: 10px;">
                    <input id="kulit_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][kulit][pilihan]" class="form-check-input" value="Normal" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['kulit']['pilihan'] == 'Normal' ? 'checked' : '' }}>
                    Normal
                  </label>
                  <label for="kulit_2" style="margin-right: 10px;">
                    <input id="kulit_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][kulit][pilihan]" class="form-check-input" value="Pucat" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['kulit']['pilihan'] == 'Pucat' ? 'checked' : '' }}>
                    Pucat
                  </label>
                  <label for="kulit_3" style="margin-right: 10px;">
                    <input id="kulit_3" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][kulit][pilihan]" class="form-check-input" value="Cyanosis" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['kulit']['pilihan'] == 'Cyanosis' ? 'checked' : '' }}>
                    Cyanosis
                  </label>
                  <label for="kulit_4" style="margin-right: 10px;">
                    <input id="kulit_4" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][kulit][pilihan]" class="form-check-input" value="Hiperemis Ekimosis" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['kulit']['pilihan'] == 'Hiperemis Ekimosis' ? 'checked' : '' }}>
                    Hiperemis Ekimosis
                  </label>
                </td>
              </tr>
              <tr>
                <td>Tempratur</td>
                <td>
                  <label for="tempratur_1" style="margin-right: 10px;">
                    <input id="tempratur_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][tempratur][pilihan]" class="form-check-input" value="Hangat" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['tempratur']['pilihan'] == 'Hangat' ? 'checked' : '' }}>
                    Hangat
                  </label>
                  <label for="tempratur_2" style="margin-right: 10px;">
                    <input id="tempratur_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][tempratur][pilihan]" class="form-check-input" value="Dingin" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['tempratur']['pilihan'] == 'Dingin' ? 'checked' : '' }}>
                    Dingin
                  </label>
                  <label for="tempratur_3" style="margin-right: 10px;">
                    <input id="tempratur_3" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][tempratur][pilihan]" class="form-check-input" value="Diaphoresis (Berkeringat)" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['tempratur']['pilihan'] == 'Diaphoresis (Berkeringat)' ? 'checked' : '' }}>
                    Diaphoresis (Berkeringat)
                  </label>
                </td>
              </tr>
              <tr>
                <td>Bunyi Jantung</td>
                <td>
                  <label for="bunyiJantung_1" style="margin-right: 10px;">
                    <input id="bunyiJantung_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][bunyiJantung][pilihan]" class="form-check-input" value="Normal" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['bunyiJantung']['pilihan'] == 'Normal' ? 'checked' : '' }}>
                    Normal
                  </label>
                  <label for="bunyiJantung_2" style="margin-right: 10px;">
                    <input id="bunyiJantung_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][bunyiJantung][pilihan]" class="form-check-input" value="Abnormal" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['bunyiJantung']['pilihan'] == 'Abnormal' ? 'checked' : '' }}>
                    Abnormal
                  </label>
                  <br>
                  <small><i>Jika Abnormal</i></small>
                  <br>
                  <input type="text" class="form-control" placeholder="" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][bunyiJantung][detail]" value="{{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['bunyiJantung']['detail'] }}">
                </td>
              </tr>
              <tr>
                <td>Ekstremitas</td>
                <td>
                  <span style="margin-right: 10px;">CRT</span>
                  <input type="text" class="form-control" style="display: inline-block; width: 200px;" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][bunyiJantung][detail]" value="{{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['bunyiJantung']['detail'] }}">
                  <small>detik</small>
                </td>
              </tr>
              <tr>
                <td>Terpasang Nichlban / TR Band</td>
                <td>
                  <label for="nichblan_1" style="margin-right: 10px;">
                    <input id="nichblan_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][nichblan][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['nichblan']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="nichblan_2" style="margin-right: 10px;">
                    <input id="nichblan_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][nichblan][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['nichblan']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <br>
                  <input type="text" class="form-control" placeholder="Area" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][nichblan][area]" value="{{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['nichblan']['area'] }}">
                </td>
              </tr>
              
              <tr>
                <td>Edema</td>
                <td>
                  <label for="edema_1" style="margin-right: 10px;">
                    <input id="edema_1" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][edema][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['edema']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="edema_2" style="margin-right: 10px;">
                    <input id="edema_2" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][edema][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['edema']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                  <br>
                  <small><i>Jika Ada</i></small>
                  <br>
                  <input type="text" class="form-control" placeholder="Area" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][edema][area]" value="{{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['edema']['area'] }}">
                  <br>
                  <span>Derajat</span>
                  <br>
                  <label for="edema_3" style="margin-right: 10px;">
                    <input id="edema_3" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][edema][derajat]" class="form-check-input" value="1" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['edema']['derajat'] == '1' ? 'checked' : '' }}>
                    1
                  </label>
                  <label for="edema_4" style="margin-right: 10px;">
                    <input id="edema_4" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][edema][derajat]" class="form-check-input" value="2" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['edema']['derajat'] == '2' ? 'checked' : '' }}>
                    2
                  </label>
                  <label for="edema_5" style="margin-right: 10px;">
                    <input id="edema_5" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][edema][derajat]" class="form-check-input" value="3" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['edema']['derajat'] == '3' ? 'checked' : '' }}>
                    3
                  </label>
                  <label for="edema_6" style="margin-right: 10px;">
                    <input id="edema_6" type="radio" name="fisik[pemeriksaanFisik][sistemKardiovaskuler][edema][derajat]" class="form-check-input" value="4" {{ @$assesment['pemeriksaanFisik']['sistemKardiovaskuler']['edema']['derajat'] == '4' ? 'checked' : '' }}>
                    4
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2" style="font-weight: bold;">SISTEM GASTROINTESTIAL</td>
              </tr>
              <tr>
                <td>Makan</td>
                <td>
                  <input type="number" class="form-control" style="display: inline-block;" placeholder="x/hari" name="fisik[pemeriksaanFisik][sistemGastrointestial][makan][frekuensi]" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['frekuensi'] }}">
                </td>
              </tr>
              <tr>
                <td>Porsi</td>
                <td>
                  <select name="fisik[pemeriksaanFisik][sistemGastrointestial][makan][porsi]" class="chosen-select" style="width: 100%;">
                    <option value="" selected>Pilih salah satu</option>
                    <option {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['porsi'] == "1/4 Porsi" ? 'selected' : '' }} value="1/4 Porsi" >1/4 Porsi</option>
                    <option {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['porsi'] == "1/2 Porsi" ? 'selected' : '' }} value="1/2 Porsi" >1/2 Porsi</option>
                    <option {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['porsi'] == "3/4 Porsi" ? 'selected' : '' }} value="3/4 Porsi" >3/4 Porsi</option>
                    <option {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['porsi'] == "1 Porsi" ? 'selected' : '' }} value="1 Porsi" >1 Porsi</option>
                    <option {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['porsi'] == "Puasa" ? 'selected' : '' }} value="Puasa" >Puasa</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Mual</td>
                <td>
                  <label for="mual_1" style="margin-right: 10px;">
                    <input id="mual_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][mual][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['mual']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="mual_2" style="margin-right: 10px;">
                    <input id="mual_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][mual][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['mual']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                </td>
              </tr>
              <tr>
                <td>Muntah</td>
                <td>
                  <label for="muntah_1" style="margin-right: 10px;">
                    <input id="muntah_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][muntah][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['muntah']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="muntah_2" style="margin-right: 10px;">
                    <input id="muntah_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][muntah][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['muntah']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <input type="text" placeholder="Warna" style="display: inline-block; width: 150px;" name="fisik[pemeriksaanFisik][sistemGastrointestial][muntah][warna]" class="form-control" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['muntah']['warna'] }}">
                </td>
              </tr>
              <tr>
                <td>BAB</td>
                <td>
                  <input type="number" class="form-control" style="display: inline-block; width: 100px;" placeholder="x/hari" name="fisik[pemeriksaanFisik][sistemGastrointestial][bab][frekuensi]" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['bab']['frekuensi'] }}">
                  <span>Warna</span>
                  <input type="text" class="form-control" style="display: inline-block; width: 150px;" placeholder="" name="fisik[pemeriksaanFisik][sistemGastrointestial][bab][warna]" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['bab']['warna'] }}">
                  <br><br>
                  <span>Konsistensi</span>
                  <input type="text" class="form-control" style="display: inline-block; width: 150px;" placeholder="" name="fisik[pemeriksaanFisik][sistemGastrointestial][bab][konsistensi]" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['bab']['konsistensi'] }}">
                </td>
              </tr>
              <tr>
                <td>Sidera</td>
                <td>
                  <label for="sidera_1" style="margin-right: 10px;">
                    <input id="sidera_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][sidera][pilihan]" class="form-check-input" value="Ikterik" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['sidera']['pilihan'] == 'Ikterik' ? 'checked' : '' }}>
                    Ikterik
                  </label>
                  <label for="sidera_2" style="margin-right: 10px;">
                    <input id="sidera_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][sidera][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['sidera']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>Mulut & Pharyng</td>
                <td>
                  <input type="text" name="fisik[pemeriksaanFisik][sistemGastrointestial][mulut][detail]" class="form-control" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['mulut']['detail'] }}">
                </td>
              </tr>
              <tr>
                <td>Mukosa</td>
                <td>
                  <label for="mukosa_1" style="margin-right: 10px;">
                    <input id="mukosa_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][mukosa][pilihan]" class="form-check-input" value="Lembab" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['mukosa']['pilihan'] == 'Lembab' ? 'checked' : '' }}>
                    Lembab
                  </label>
                  <label for="mukosa_2" style="margin-right: 10px;">
                    <input id="mukosa_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][mukosa][pilihan]" class="form-check-input" value="Kering" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['mukosa']['pilihan'] == 'Kering' ? 'checked' : '' }}>
                    Kering
                  </label>
                  <label for="mukosa_3" style="margin-right: 10px;">
                    <input id="mukosa_3" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][mukosa][pilihan]" class="form-check-input" value="Lesi" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['mukosa']['pilihan'] == 'Lesi' ? 'checked' : '' }}>
                    Lesi
                  </label>
                  <label for="mukosa_4" style="margin-right: 10px;">
                    <input id="mukosa_4" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][mukosa][pilihan]" class="form-check-input" value="Nodul" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['mukosa']['pilihan'] == 'Nodul' ? 'checked' : '' }}>
                    Nodul
                  </label>
                </td>
              </tr>
              <tr>
                <td>Lidah</td>
                <td>
                  <input type="text" name="fisik[pemeriksaanFisik][sistemGastrointestial][lidah][warna]" class="form-control" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['lidah']['warna'] }}">
                  <br>
                  <span>Ulkus</span>
                  <br>
                  <label for="lidah_1" style="margin-right: 10px;">
                    <input id="lidah_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][lidah][ulkus]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['lidah']['ulkus'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                  <label for="lidah_2" style="margin-right: 10px;">
                    <input id="lidah_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][lidah][ulkus]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['lidah']['ulkus'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>Refleks Menelan</td>
                <td>
                  <label for="refleksMenelan_1" style="margin-right: 10px;">
                    <input id="refleksMenelan_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][refleksMenelan][pilihan]" class="form-check-input" value="Dapat" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['refleksMenelan']['pilihan'] == 'Dapat' ? 'checked' : '' }}>
                    Dapat
                  </label>
                  <label for="refleksMenelan_2" style="margin-right: 10px;">
                    <input id="refleksMenelan_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][refleksMenelan][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['refleksMenelan']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>Refleks Mengunyah</td>
                <td>
                  <label for="refleksMengunyah_1" style="margin-right: 10px;">
                    <input id="refleksMengunyah_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][refleksMengunyah][pilihan]" class="form-check-input" value="Dapat" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['refleksMengunyah']['pilihan'] == 'Dapat' ? 'checked' : '' }}>
                    Dapat
                  </label>
                  <label for="refleksMengunyah_2" style="margin-right: 10px;">
                    <input id="refleksMengunyah_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][refleksMengunyah][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['refleksMengunyah']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                </td>
              </tr>
              <tr>
                <td>Alat Bantu</td>
                <td>
                  <label for="alatBantu_1" style="margin-right: 10px;">
                    <input id="alatBantu_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][alatBantu][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['alatBantu']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="alatBantu_2" style="margin-right: 10px;">
                    <input id="alatBantu_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][alatBantu][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['alatBantu']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <br>
                  <small><i>Jika Ya</i></small>
                  <br>
                  <label for="alatBantu_3" style="margin-right: 10px;">
                    <input id="alatBantu_3" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][alatBantu][detail]" class="form-check-input" value="NGT" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['alatBantu']['detail'] == 'NGT' ? 'checked' : '' }}>
                    NGT
                  </label>
                  <label for="alatBantu_4" style="margin-right: 10px;">
                    <input id="alatBantu_4" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][alatBantu][detail]" class="form-check-input" value="OGT" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['alatBantu']['detail'] == 'OGT' ? 'checked' : '' }}>
                    OGT
                  </label>
                </td>
              </tr>
              <tr>
                <td>Abdomen</td>
                <td>
                  <span>Bising Usus</span>
                  <input type="text" placeholder="x/menit" style="display: inline-block; width: 150px;" name="fisik[pemeriksaanFisik][sistemGastrointestial][abdomen][bisingUsus]" class="form-control" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['abdomen']['bisingUsus'] }}">
                  <br>
                  <span>Bentuk</span>
                  <label for="abdomen_1" style="margin-right: 10px;">
                    <input id="abdomen_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][abdomen][bentuk]" class="form-check-input" value="Kembung" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['abdomen']['bentuk'] == 'Kembung' ? 'checked' : '' }}>
                    Kembung
                  </label>
                  <label for="abdomen_2" style="margin-right: 10px;">
                    <input id="abdomen_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][abdomen][bentuk]" class="form-check-input" value="Datar" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['abdomen']['bentuk'] == 'Datar' ? 'checked' : '' }}>
                    Datar
                  </label>
                </td>
              </tr>
              <tr>
                <td>Stoma</td>
                <td>
                  <label for="stoma_1" style="margin-right: 10px;">
                    <input id="stoma_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][stoma][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['stoma']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="stoma_2" style="margin-right: 10px;">
                    <input id="stoma_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][stoma][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['stoma']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                </td>
              </tr>
              <tr>
                <td>Drain</td>
                <td>
                  <label for="drain_1" style="margin-right: 10px;">
                    <input id="drain_1" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][drain][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['drain']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="drain_2" style="margin-right: 10px;">
                    <input id="drain_2" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][drain][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['drain']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <br>
                  <small><i>Jika Ya</i></small>
                  <br>
                  <label for="drain_3" style="margin-right: 10px;">
                    <input id="drain_3" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][drain][detail]" class="form-check-input" value="Silicon" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['drain']['detail'] == 'Silicon' ? 'checked' : '' }}>
                    Silicon
                  </label>
                  <label for="drain_4" style="margin-right: 10px;">
                    <input id="drain_4" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][drain][detail]" class="form-check-input" value="T-Tube" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['drain']['detail'] == 'T-Tube' ? 'checked' : '' }}>
                    T-Tube
                  </label>
                  <label for="drain_5" style="margin-right: 10px;">
                    <input id="drain_5" type="radio" name="fisik[pemeriksaanFisik][sistemGastrointestial][drain][detail]" class="form-check-input" value="Penrose" {{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['drain']['detail'] == 'Penrose' ? 'checked' : '' }}>
                    Penrose
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2" style="font-weight: bold;">MUSKULO SKELETAL</td>
              </tr>
              <tr>
                <td>Faktur</td>
                <td>
                  <label for="faktur_1" style="margin-right: 10px;">
                    <input id="faktur_1" type="radio" name="fisik[pemeriksaanFisik][muskuloSkeletal][faktur][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['muskuloSkeletal']['faktur']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="faktur_2" style="margin-right: 10px;">
                    <input id="faktur_2" type="radio" name="fisik[pemeriksaanFisik][muskuloSkeletal][faktur][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['muskuloSkeletal']['faktur']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                </td>
              </tr>
              <tr>
                <td>Mobilitas</td>
                <td>
                  <label for="mobilitas_1" style="margin-right: 10px;">
                    <input id="mobilitas_1" type="radio" name="fisik[pemeriksaanFisik][muskuloSkeletal][mobilitas][pilihan]" class="form-check-input" value="Mandiri" {{ @$assesment['pemeriksaanFisik']['muskuloSkeletal']['mobilitas']['pilihan'] == 'Mandiri' ? 'checked' : '' }}>
                    Mandiri
                  </label>
                  <label for="mobilitas_2" style="margin-right: 10px;">
                    <input id="mobilitas_2" type="radio" name="fisik[pemeriksaanFisik][muskuloSkeletal][mobilitas][pilihan]" class="form-check-input" value="Dibantu" {{ @$assesment['pemeriksaanFisik']['muskuloSkeletal']['mobilitas']['pilihan'] == 'Dibantu' ? 'checked' : '' }}>
                    Dibantu
                  </label>
                  <br>
                  <input type="text" class="form-control" name="fisik[pemeriksaanFisik][muskuloSkeletal][mobilitas][detail]" value="{{ @$assesment['pemeriksaanFisik']['muskuloSkeletal']['mobilitas']['detail'] }}">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">NEUROLOGI</td>
              </tr>
              <tr>
                <td>Kesulitan Bicara</td>
                <td>
                  <label for="kesulitanBicara_1" style="margin-right: 10px;">
                    <input id="kesulitanBicara_1" type="radio" name="fisik[pemeriksaanFisik][neurologi][kesulitanBicara][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['neurologi']['kesulitanBicara']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="kesulitanBicara_2" style="margin-right: 10px;">
                    <input id="kesulitanBicara_2" type="radio" name="fisik[pemeriksaanFisik][neurologi][kesulitanBicara][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['neurologi']['kesulitanBicara']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                </td>
              </tr>
              <tr>
                <td>Kelemahan Alat Gerak</td>
                <td>
                  <label for="kelemahanAlatGerak_1" style="margin-right: 10px;">
                    <input id="kelemahanAlatGerak_1" type="radio" name="fisik[pemeriksaanFisik][neurologi][kelemahanAlatGerak][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['neurologi']['kelemahanAlatGerak']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="kelemahanAlatGerak_2" style="margin-right: 10px;">
                    <input id="kelemahanAlatGerak_2" type="radio" name="fisik[pemeriksaanFisik][neurologi][kelemahanAlatGerak][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['neurologi']['kelemahanAlatGerak']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                </td>
              </tr>
              <tr>
                <td>Terpasang EVD</td>
                <td>
                  <label for="terpasangEVD_1" style="margin-right: 10px;">
                    <input id="terpasangEVD_1" type="radio" name="fisik[pemeriksaanFisik][neurologi][terpasangEVD][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['neurologi']['terpasangEVD']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="terpasangEVD_2" style="margin-right: 10px;">
                    <input id="terpasangEVD_2" type="radio" name="fisik[pemeriksaanFisik][neurologi][terpasangEVD][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['neurologi']['terpasangEVD']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">SISTEM UROGENITAL</td>
              </tr>
              <tr>
                <td>Perubahan pola BAK</td>
                <td>
                  <input type="text" class="form-control" name="fisik[pemeriksaanFisik][sistemUrogenital][perubahanPolaBAK]" value="{{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['perubahanPolaBAK'] }}">
                </td>
              </tr>
              <tr>
                <td>Frekuensi BAK</td>
                <td>
                  <input type="text" class="form-control" style="display: inline-block; width: 100px" placeholder="x/hari" name="fisik[pemeriksaanFisik][sistemUrogenital][frekuensiBAK]" value="{{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['frekuensiBAK'] }}">
                  <span>Warna Urine</span>
                  <input type="text" class="form-control" style="display: inline-block; width: 100px" placeholder="" name="fisik[pemeriksaanFisik][sistemUrogenital][warnaUrine]" value="{{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['warnaUrine'] }}">
                </td>
              </tr>

              <tr>
                <td>Alat Bantu</td>
                <td>
                  <label for="alat_bantu_1" style="margin-right: 10px;">
                    <input id="alat_bantu_1" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][alatBantu][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['alatBantu']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="alat_bantu_2" style="margin-right: 10px;">
                    <input id="alat_bantu_2" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][alatBantu][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['alatBantu']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <br>
                  <small><i>Jika Ya</i></small>
                  <br>
                  <label for="alat_bantu_3" style="margin-right: 10px;">
                    <input id="alat_bantu_3" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][alatBantu][detail]" class="form-check-input" value="Dower Kateter" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['alatBantu']['detail'] == 'Dower Kateter' ? 'checked' : '' }}>
                    Dower Kateter
                  </label>
                  <label for="alat_bantu_4" style="margin-right: 10px;">
                    <input id="alat_bantu_4" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][alatBantu][detail]" class="form-check-input" value="Kondom Kateter" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['alatBantu']['detail'] == 'Kondom Kateter' ? 'checked' : '' }}>
                    Kondom Kateter
                  </label>
                </td>
              </tr>
              <tr>
                <td>Stoma</td>
                <td>
                  <label for="sto_ma1" style="margin-right: 10px;">
                    <input id="sto_ma1" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][stoma][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['stoma']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="sto_ma2" style="margin-right: 10px;">
                    <input id="sto_ma2" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][stoma][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['stoma']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                  <br>
                  <small><i>Jika Ya</i></small>
                  <br>
                  <label for="sto_ma3" style="margin-right: 10px;">
                    <input id="sto_ma3" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][stoma][detail]" class="form-check-input" value="Urostomy" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['stoma']['detail'] == 'Urostomy' ? 'checked' : '' }}>
                    Urostomy
                  </label>
                  <label for="sto_ma4" style="margin-right: 10px;">
                    <input id="sto_ma4" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][stoma][detail]" class="form-check-input" value="Nefrostomy" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['stoma']['detail'] == 'Nefrostomy' ? 'checked' : '' }}>
                    Nefrostomy
                  </label>
                  <label for="sto_ma5" style="margin-right: 10px;">
                    <input id="sto_ma5" type="radio" name="fisik[pemeriksaanFisik][sistemUrogenital][stoma][detail]" class="form-check-input" value="Cystostomy" {{ @$assesment['pemeriksaanFisik']['sistemUrogenital']['stoma']['detail'] == 'Cystostomy' ? 'checked' : '' }}>
                    Cystostomy
                  </label>
                </td>
              </tr>
              
              <tr>
                <td colspan="2" style="font-weight: bold;">SISTEM INTEGUMEN</td>
              </tr>
              <tr>
                <td>Luka</td>
                <td>
                  <label for="luka_1" style="margin-right: 10px;">
                    <input id="luka_1" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][luka][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['luka']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="luka_2" style="margin-right: 10px;">
                    <input id="luka_2" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][luka][pilihan]" class="form-check-input" value="Ada" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['luka']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    Ada
                  </label>
                </td>
              </tr>
              <tr>
                <td>Benjolan</td>
                <td>
                  <label for="benjolan_1" style="margin-right: 10px;">
                    <input id="benjolan_1" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][benjolan][pilihan]" class="form-check-input" value="Tidak" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['benjolan']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak
                  </label>
                  <label for="benjolan_2" style="margin-right: 10px;">
                    <input id="benjolan_2" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][benjolan][pilihan]" class="form-check-input" value="Ya" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['benjolan']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    Ya
                  </label>
                </td>
              </tr>
              <tr>
                <td>Sensasi</td>
                <td>
                  <label for="sensasi_1" style="margin-right: 10px;">
                    <input id="sensasi_1" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][sensasi][pilihan]" class="form-check-input" value="Dingin" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['sensasi']['pilihan'] == 'Dingin' ? 'checked' : '' }}>
                    Dingin
                  </label>
                  <label for="sensasi_2" style="margin-right: 10px;">
                    <input id="sensasi_2" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][sensasi][pilihan]" class="form-check-input" value="Panas" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['sensasi']['pilihan'] == 'Panas' ? 'checked' : '' }}>
                    Panas
                  </label>
                  <label for="sensasi_3" style="margin-right: 10px;">
                    <input id="sensasi_3" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][sensasi][pilihan]" class="form-check-input" value="Nyeri" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['sensasi']['pilihan'] == 'Nyeri' ? 'checked' : '' }}>
                    Nyeri
                  </label>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">HYGIENE</td>
              </tr>
              <tr>
                <td>Aktifitas sehari-hari</td>
                <td>
                  <label for="aktifitasSehariHari_1" style="margin-right: 10px;">
                    <input id="aktifitasSehariHari_1" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][aktifitasSehariHari][pilihan]" class="form-check-input" value="Mandiri" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['aktifitasSehariHari']['pilihan'] == 'Mandiri' ? 'checked' : '' }}>
                    Mandiri
                  </label>
                  <label for="aktifitasSehariHari_2" style="margin-right: 10px;">
                    <input id="aktifitasSehariHari_2" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][aktifitasSehariHari][pilihan]" class="form-check-input" value="Dibantu" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['aktifitasSehariHari']['pilihan'] == 'Dibantu' ? 'checked' : '' }}>
                    Dibantu
                  </label>
                </td>
              </tr>
              <tr>
                <td>Penampilan</td>
                <td>
                  <label for="penampilan_1" style="margin-right: 10px;">
                    <input id="penampilan_1" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][penampilan][pilihan]" class="form-check-input" value="Bersih" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['penampilan']['pilihan'] == 'Bersih' ? 'checked' : '' }}>
                    Bersih
                  </label>
                  <label for="penampilan_2" style="margin-right: 10px;">
                    <input id="penampilan_2" type="radio" name="fisik[pemeriksaanFisik][sistemIntegumen][penampilan][pilihan]" class="form-check-input" value="Kotor" {{ @$assesment['pemeriksaanFisik']['sistemIntegumen']['penampilan']['pilihan'] == 'Kotor' ? 'checked' : '' }}>
                    Kotor
                  </label>
                </td>
              </tr>

            </table>
          </div>

          <div class="col-md-12">
            
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5><b>SKRINING RISIKO DEKUBITUS</b></h5>
              <tr>
                <td style="width:50%; font-weight:500;">Persepsi Sensori</td>
                <td>
                    <div style="">
                        <div>
                            <input class="hitungResiko" type="radio" id="persepsi_sensori_1" name="fungsional[skriningRisikoDekubitus][persepsi_sensori][pilihan]" value="1" {{@$fungsional['skriningRisikoDekubitus']['persepsi_sensori']['pilihan'] == '1' ? 'checked' : ''}}>
                            <label for="persepsi_sensori_1" style="font-weight: normal;">Keterbatasan penuh<b>(1 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="persepsi_sensori_2" name="fungsional[skriningRisikoDekubitus][persepsi_sensori][pilihan]" value="2" {{@$fungsional['skriningRisikoDekubitus']['persepsi_sensori']['pilihan'] == '2' ? 'checked' : ''}}>
                            <label for="persepsi_sensori_2" style="font-weight: normal;">Sangat terbatas <b>(2 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="persepsi_sensori_3" name="fungsional[skriningRisikoDekubitus][persepsi_sensori][pilihan]" value="3" {{@$fungsional['skriningRisikoDekubitus']['persepsi_sensori']['pilihan'] == '3' ? 'checked' : ''}}>
                            <label for="persepsi_sensori_3" style="font-weight: normal;">Keterbatasan ringan<b>(3 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="persepsi_sensori_4" name="fungsional[skriningRisikoDekubitus][persepsi_sensori][pilihan]" value="4" {{@$fungsional['skriningRisikoDekubitus']['persepsi_sensori']['pilihan'] == '4' ? 'checked' : ''}}>
                            <label for="persepsi_sensori_4" style="font-weight: normal;">Tidak ada keterbatasan <b>(4 Skor)</b></label><br/>
                        </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:500;">Kelembaban</td>
                <td>
                    <div style="">
                        <div>
                            <input class="hitungResiko" type="radio" id="kelembaban_1" name="fungsional[skriningRisikoDekubitus][kelembaban][pilihan]" value="1" {{@$fungsional['skriningRisikoDekubitus']['kelembaban']['pilihan'] == '1' ? 'checked' : ''}}>
                            <label for="kelembaban_1" style="font-weight: normal;">Lembab terus menerus <b>(1 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="kelembaban_2" name="fungsional[skriningRisikoDekubitus][kelembaban][pilihan]" value="2" {{@$fungsional['skriningRisikoDekubitus']['kelembaban']['pilihan'] == '2' ? 'checked' : ''}}>
                            <label for="kelembaban_2" style="font-weight: normal;">Sangat lembab <b>(2 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="kelembaban_3" name="fungsional[skriningRisikoDekubitus][kelembaban][pilihan]" value="3" {{@$fungsional['skriningRisikoDekubitus']['kelembaban']['pilihan'] == '3' ? 'checked' : ''}}>
                            <label for="kelembaban_3" style="font-weight: normal;">Kadang-kadang lembab<b>(3 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="kelembaban_4" name="fungsional[skriningRisikoDekubitus][kelembaban][pilihan]" value="4" {{@$fungsional['skriningRisikoDekubitus']['kelembaban']['pilihan'] == '4' ? 'checked' : ''}}>
                            <label for="kelembaban_4" style="font-weight: normal;">Tidak ada lembab <b>(4 Skor)</b></label><br/>
                        </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:500;">Aktivitas</td>
                <td>
                    <div style="">
                        <div>
                            <input class="hitungResiko" type="radio" id="aktivitas_1" name="fungsional[skriningRisikoDekubitus][aktivitas][pilihan]" value="1" {{@$fungsional['skriningRisikoDekubitus']['aktivitas']['pilihan'] == '1' ? 'checked' : ''}}>
                            <label for="aktivitas_1" style="font-weight: normal;">Di tempat tidur <b>(1 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="aktivitas_2" name="fungsional[skriningRisikoDekubitus][aktivitas][pilihan]" value="2" {{@$fungsional['skriningRisikoDekubitus']['aktivitas']['pilihan'] == '2' ? 'checked' : ''}}>
                            <label for="aktivitas_2" style="font-weight: normal;">Diatas kursi <b>(2 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="aktivitas_3" name="fungsional[skriningRisikoDekubitus][aktivitas][pilihan]" value="3" {{@$fungsional['skriningRisikoDekubitus']['aktivitas']['pilihan'] == '3' ? 'checked' : ''}}>
                            <label for="aktivitas_3" style="font-weight: normal;">Kadang-kadang berjalan <b>(3 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="aktivitas_4" name="fungsional[skriningRisikoDekubitus][aktivitas][pilihan]" value="4" {{@$fungsional['skriningRisikoDekubitus']['aktivitas']['pilihan'] == '4' ? 'checked' : ''}}>
                            <label for="aktivitas_4" style="font-weight: normal;">Sering berjalan <b>(4 Skor)</b></label><br/>
                        </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:500;">Mobilisasi</td>
                <td>
                    <div style="">
                        <div>
                            <input class="hitungResiko" type="radio" id="mobilisasi_1" name="fungsional[skriningRisikoDekubitus][mobilisasi][pilihan]" value="1" {{@$fungsional['skriningRisikoDekubitus']['mobilisasi']['pilihan'] == '1' ? 'checked' : ''}}>
                            <label for="mobilisasi_1" style="font-weight: normal;">Tidak dapat bergerak <b>(1 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="mobilisasi_2" name="fungsional[skriningRisikoDekubitus][mobilisasi][pilihan]" value="2" {{@$fungsional['skriningRisikoDekubitus']['mobilisasi']['pilihan'] == '2' ? 'checked' : ''}}>
                            <label for="mobilisasi_2" style="font-weight: normal;">Pergerakan sangat terbatas <b>(2 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="mobilisasi_3" name="fungsional[skriningRisikoDekubitus][mobilisasi][pilihan]" value="3" {{@$fungsional['skriningRisikoDekubitus']['mobilisasi']['pilihan'] == '3' ? 'checked' : ''}}>
                            <label for="mobilisasi_3" style="font-weight: normal;">Keterbatasan ringan <b>(3 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="mobilisasi_4" name="fungsional[skriningRisikoDekubitus][mobilisasi][pilihan]" value="4" {{@$fungsional['skriningRisikoDekubitus']['mobilisasi']['pilihan'] == '4' ? 'checked' : ''}}>
                            <label for="mobilisasi_4" style="font-weight: normal;">Tidak ada keterbatasan <b>(4 Skor)</b></label><br/>
                        </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:500;">Status Nutrisi</td>
                <td>
                    <div style="">
                        <div>
                            <input class="hitungResiko" type="radio" id="status_nutrisi_1" name="fungsional[skriningRisikoDekubitus][status_nutrisi][pilihan]" value="1" {{@$fungsional['skriningRisikoDekubitus']['status_nutrisi']['pilihan'] == '1' ? 'checked' : ''}}>
                            <label for="status_nutrisi_1" style="font-weight: normal;">Sangat buruk <b>(1 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="status_nutrisi_2" name="fungsional[skriningRisikoDekubitus][status_nutrisi][pilihan]" value="2" {{@$fungsional['skriningRisikoDekubitus']['status_nutrisi']['pilihan'] == '2' ? 'checked' : ''}}>
                            <label for="status_nutrisi_2" style="font-weight: normal;">Tidak adekuat <b>(2 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="status_nutrisi_3" name="fungsional[skriningRisikoDekubitus][status_nutrisi][pilihan]" value="3" {{@$fungsional['skriningRisikoDekubitus']['status_nutrisi']['pilihan'] == '3' ? 'checked' : ''}}>
                            <label for="status_nutrisi_3" style="font-weight: normal;">Adekuat <b>(3 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="status_nutrisi_4" name="fungsional[skriningRisikoDekubitus][status_nutrisi][pilihan]" value="4" {{@$fungsional['skriningRisikoDekubitus']['status_nutrisi']['pilihan'] == '4' ? 'checked' : ''}}>
                            <label for="status_nutrisi_4" style="font-weight: normal;">Baik sekali <b>(4 Skor)</b></label><br/>
                        </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:500;">Friksi / Gesekan</td>
                <td>
                    <div style="">
                        <div>
                            <input class="hitungResiko" type="radio" id="friksi_gesekan_1" name="fungsional[skriningRisikoDekubitus][friksi_gesekan][pilihan]" value="1" {{@$fungsional['skriningRisikoDekubitus']['friksi_gesekan']['pilihan'] == '1' ? 'checked' : ''}}>
                            <label for="friksi_gesekan_1" style="font-weight: normal;">Bermasalah <b>(1 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="friksi_gesekan_2" name="fungsional[skriningRisikoDekubitus][friksi_gesekan][pilihan]" value="2" {{@$fungsional['skriningRisikoDekubitus']['friksi_gesekan']['pilihan'] == '2' ? 'checked' : ''}}>
                            <label for="friksi_gesekan_2" style="font-weight: normal;">Potensi bermasalah <b>(2 Skor)</b></label><br/>
                        </div>
                        <div>
                            <input class="hitungResiko" type="radio" id="friksi_gesekan_3" name="fungsional[skriningRisikoDekubitus][friksi_gesekan][pilihan]" value="3" {{@$fungsional['skriningRisikoDekubitus']['friksi_gesekan']['pilihan'] == '3' ? 'checked' : ''}}>
                            <label for="friksi_gesekan_3" style="font-weight: normal;">Tidak ada masalah <b>(3 Skor)</b></label><br/>
                        </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">JUMLAH SKOR</td>
                <td>
                  <input type="number" name="fungsional[skriningRisikoDekubitus][jumlahSkor][angka]" style="display:inline-block; width: 100%;" class="form-control jumlahSkorResiko" id="" value="{{@$fungsional['skriningRisikoDekubitus']['jumlahSkor']['angka']}}" readonly>
                  <br><br>
                  <input type="text" name="fungsional[skriningRisikoDekubitus][jumlahSkor][hasil]" style="display:inline-block; width: 100%;" class="form-control hasilSkorResiko" id="" value="{{@$fungsional['skriningRisikoDekubitus']['jumlahSkor']['hasil']}}" readonly>
                </td>
              </tr>
            </table>
          </div>
          
          <div class="col-md-6">
            <h5><b>SKRINING FUNGSIONAL</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <thead>
                <tr>
                  <th style="width: 10%;">Aktivitas</th>
                  <th style="width: 45%;">Mandiri (1 Poin)</th>
                  <th style="width: 45%;">Keterangan (0 Poin)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mandi</td>
                  <td>
                    <label for="mandi_1" style="margin-right: 10px;">
                      <input id="mandi_1" type="checkbox" name="fungsional[skriningFungsional][mandi][mandiri1]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['mandi']['mandiri1'] == '1' ? 'checked' : '' }}>
                      Mandi secara penuh
                    </label>
                    <br>
                    <label for="mandi_2" style="margin-right: 10px;">
                      <input id="mandi_2" type="checkbox" name="fungsional[skriningFungsional][mandi][mandiri2]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['mandi']['mandiri2'] == '1' ? 'checked' : '' }}>
                      Memerlukan bantuan hanya pada satu bagian tubuh misal: punggung, area genital, atau ekstremitas yang terkena
                    </label>
                  </td>
                  <td>
                    <label for="mandi_3" style="margin-right: 10px;">
                      <input id="mandi_3" type="checkbox" name="fungsional[skriningFungsional][mandi][ket1]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['mandi']['ket1'] == '0' ? 'checked' : '' }}>
                      Perlu bantuan mandi pada lebih dari 1 bagian tubuh
                    </label>
                    <br>
                    <label for="mandi_4" style="margin-right: 10px;">
                      <input id="mandi_4" type="checkbox" name="fungsional[skriningFungsional][mandi][ket2]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['mandi']['ket2'] == '0' ? 'checked' : '' }}>
                      Bantuan saat masuk dan keluar kamar mandi atau shower
                    </label>
                    <br>
                    <label for="mandi_5" style="margin-right: 10px;">
                      <input id="mandi_5" type="checkbox" name="fungsional[skriningFungsional][mandi][ket3]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['mandi']['ket3'] == '0' ? 'checked' : '' }}>
                      Mandi dilakukan oleh orang lain
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>Memakai Baju</td>
                  <td>
                    <label for="memakaiBaju_1" style="margin-right: 10px;">
                      <input id="memakaiBaju_1" type="checkbox" name="fungsional[skriningFungsional][memakaiBaju][mandiri1]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['memakaiBaju']['mandiri1'] == '1' ? 'checked' : '' }}>
                      Dapat mengambil pakaian dari lemari baju dan laci
                    </label>
                    <br>
                    <label for="memakaiBaju_2" style="margin-right: 10px;">
                      <input id="memakaiBaju_2" type="checkbox" name="fungsional[skriningFungsional][memakaiBaju][mandiri2]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['memakaiBaju']['mandiri2'] == '1' ? 'checked' : '' }}>
                      Memakai baju dan pakaian lain secara lengkap
                    </label>
                    <label for="memakaiBaju_3" style="margin-right: 10px;">
                      <input id="memakaiBaju_3" type="checkbox" name="fungsional[skriningFungsional][memakaiBaju][mandiri3]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['memakaiBaju']['mandiri3'] == '1' ? 'checked' : '' }}>
                      Memerlukan bantuan mengikatkan sepatu
                    </label>
                  </td>
                  <td>
                    <label for="memakaiBaju_4" style="margin-right: 10px;">
                      <input id="memakaiBaju_4" type="checkbox" name="fungsional[skriningFungsional][memakaiBaju][ket1]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['memakaiBaju']['ket1'] == '0' ? 'checked' : '' }}>
                      Perlu bantuan memakai baju sendiri
                    </label>
                    <br>
                    <label for="memakaiBaju_5" style="margin-right: 10px;">
                      <input id="memakaiBaju_5" type="checkbox" name="fungsional[skriningFungsional][memakaiBaju][ket2]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['memakaiBaju']['ket2'] == '0' ? 'checked' : '' }}>
                      Perlu bantuan dipakaikan baju secara komplit
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>Toileting</td>
                  <td>
                    <label for="toileting_1" style="margin-right: 10px;">
                      <input id="toileting_1" type="checkbox" name="fungsional[skriningFungsional][toileting][mandiri1]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['toileting']['mandiri1'] == '1' ? 'checked' : '' }}>
                      Dapat pergi ke kamar kecil
                    </label>
                    <br>
                    <label for="toileting_2" style="margin-right: 10px;">
                      <input id="toileting_2" type="checkbox" name="fungsional[skriningFungsional][toileting][mandiri2]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['toileting']['mandiri2'] == '1' ? 'checked' : '' }}>
                      Dapat naik dan turun dari toilet
                    </label>
                    <label for="toileting_3" style="margin-right: 10px;">
                      <input id="toileting_3" type="checkbox" name="fungsional[skriningFungsional][toileting][mandiri3]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['toileting']['mandiri3'] == '1' ? 'checked' : '' }}>
                      Dapat merapikan baju
                    </label>
                    <label for="toileting_4" style="margin-right: 10px;">
                      <input id="toileting_4" type="checkbox" name="fungsional[skriningFungsional][toileting][mandiri4]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['toileting']['mandiri4'] == '1' ? 'checked' : '' }}>
                      Dapat membersihkan area genital tanpa dibantu
                    </label>
                  </td>
                  <td>
                    <label for="toileting_5" style="margin-right: 10px;">
                      <input id="toileting_5" type="checkbox" name="fungsional[skriningFungsional][toileting][ket1]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['toileting']['ket1'] == '0' ? 'checked' : '' }}>
                      Perlu bantuan untuk berpindah ke toilet
                    </label>
                    <br>
                    <label for="toileting_6" style="margin-right: 10px;">
                      <input id="toileting_6" type="checkbox" name="fungsional[skriningFungsional][toileting][ket2]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['toileting']['ket2'] == '0' ? 'checked' : '' }}>
                      Dapat membersihkan diri
                    </label>
                    <label for="toileting_7" style="margin-right: 10px;">
                      <input id="toileting_7" type="checkbox" name="fungsional[skriningFungsional][toileting][ket3]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['toileting']['ket3'] == '0' ? 'checked' : '' }}>
                      Memerlukan pispot atau popok
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>Berpindah Tempat</td>
                  <td>
                    <label for="berpindahTempat_1" style="margin-right: 10px;">
                      <input id="berpindahTempat_1" type="checkbox" name="fungsional[skriningFungsional][berpindahTempat][mandiri1]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['berpindahTempat']['mandiri1'] == '1' ? 'checked' : '' }}>
                      Dapat pergi ke kamar kecil
                    </label>
                  </td>
                  <td>
                    <label for="berpindahTempat_2" style="margin-right: 10px;">
                      <input id="berpindahTempat_2" type="checkbox" name="fungsional[skriningFungsional][berpindahTempat][ket1]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['berpindahTempat']['ket1'] == '0' ? 'checked' : '' }}>
                      Memerlukan bantuan berpindah dari tempat tidur atau kursi
                    </label>
                    <label for="berpindahTempat_3" style="margin-right: 10px;">
                      <input id="berpindahTempat_3" type="checkbox" name="fungsional[skriningFungsional][berpindahTempat][ket2]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['berpindahTempat']['ket2'] == '0' ? 'checked' : '' }}>
                      Memerlukan bantuan berpindah secara penuh
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>Kontinensial</td>
                  <td>
                    <label for="kontinensial_1" style="margin-right: 10px;">
                      <input id="kontinensial_1" type="checkbox" name="fungsional[skriningFungsional][kontinensial][mandiri1]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['kontinensial']['mandiri1'] == '1' ? 'checked' : '' }}>
                      Dapat mengambil makanan dan menahan rasa ingin BAK dan BAB
                    </label>
                  </td>
                  <td>
                    <label for="kontinensial_2" style="margin-right: 10px;">
                      <input id="kontinensial_2" type="checkbox" name="fungsional[skriningFungsional][kontinensial][ket1]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['kontinensial']['ket1'] == '0' ? 'checked' : '' }}>
                      Inkontensial BAK atau BAK sebagian atau total
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>Makan</td>
                  <td>
                    <label for="makan_1" style="margin-right: 10px;">
                      <input id="makan_1" type="checkbox" name="fungsional[skriningFungsional][makan][mandiri1]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['makan']['mandiri1'] == '1' ? 'checked' : '' }}>
                      Dapat mengambil makanan dari piring ke mulut tanpa bantuan
                    </label>
                    <label for="makan_2" style="margin-right: 10px;">
                      <input id="makan_2" type="checkbox" name="fungsional[skriningFungsional][makan][mandiri2]" class="form-check-input fungsional-input" value="1" {{ @$fungsional['skriningFungsional']['makan']['mandiri2'] == '1' ? 'checked' : '' }}>
                      Persiapan makan dapat dilakukan oleh orang lain
                    </label>
                  </td>
                  <td>
                    <label for="makan_3" style="margin-right: 10px;">
                      <input id="makan_3" type="checkbox" name="fungsional[skriningFungsional][makan][ket1]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['makan']['ket1'] == '0' ? 'checked' : '' }}>
                      Memerlukan bantuan sebagian atau total saat proses makan
                    </label>
                    <label for="makan_4" style="margin-right: 10px;">
                      <input id="makan_4" type="checkbox" name="fungsional[skriningFungsional][makan][ket2]" class="form-check-input fungsional-input" value="0" {{ @$fungsional['skriningFungsional']['makan']['ket2'] == '0' ? 'checked' : '' }}>
                      Memerlukan maloda orienteral
                    </label>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td style="font-weight: bold;">Total Skor</td>
                  <td colspan="2">
                    <input type="number" name="fungsional[skriningFungsional][jumlahSkor][angka]" style="display:inline-block; width: 100%;" class="form-control jumlahSkorFungsional" id="" value="{{@$fungsional['skriningFungsional']['jumlahSkor']['angka']}}" readonly>
                    <br><br>
                    <input type="text" name="fungsional[skriningFungsional][jumlahSkor][hasil]" style="display:inline-block; width: 100%;" class="form-control hasilSkorFungsional" id="" value="{{@$fungsional['skriningFungsional']['jumlahSkor']['hasil']}}" readonly>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="col-md-12" style="width: 100%; overflow: auto">
            <h4 class="text-center"><b>PENILAIAN RISIKO JATUH DEWASA DAN LANSIA</b></h4>
            <h5 class="text-center"><b>SKALA MORSE <i>(MORSE FALLS SCALE / MFS)</i></b></h5>
            <table class="table table-striped table-bordered table-hover table-condensed form-box" style=""> 
              <thead>
                <tr>
                  <th class="text-center" style="width: 350px;">Parameter</th>
                  <th class="text-center" style="width: 80px;">Kriteria</th>
                  <th class="text-center" style="width: 40px;">Nilai</th>
                  <th class="text-center" style="width: 50px;">Skor 1</th>
                  <th class="text-center" style="width: 50px;">Skor 2</th>
                  <th class="text-center" style="width: 50px;">Skor 3</th>
                  <th class="text-center" style="width: 50px;">Skor 4</th>
                  <th class="text-center" style="width: 50px;">Skor 5</th>
                  <th class="text-center" style="width: 50px;">Skor 6</th>
                  <th class="text-center" style="width: 50px;">Skor 7</th>
                  <th class="text-center" style="width: 50px;">Skor 8</th>
                  <th class="text-center" style="width: 50px;">Skor 9</th>
                  <th class="text-center" style="width: 50px;">Skor 10</th>
                  <th class="text-center" style="width: 50px;">Skor 11</th>
                  <th class="text-center" style="width: 50px;">Skor 12</th>
                  <th class="text-center" style="width: 50px;">Skor 13</th>
                  <th class="text-center" style="width: 50px;">Skor 14</th>
                  <th class="text-center" style="width: 50px;">Skor 15</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowspan="2" style="width: 350px;">Riwayat jatuh, yang baru atau dalam bulan terakhir</td>
                  <td>Tidak</td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skala][riwayatJatuh][1]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['1'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skala][riwayatJatuh][2]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['2'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skala][riwayatJatuh][3]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['3'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skala][riwayatJatuh][4]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['4'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa4()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa5" name="pemeriksaandalam[skala][riwayatJatuh][5]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['5'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa5()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa6" name="pemeriksaandalam[skala][riwayatJatuh][6]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['6'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa6()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa7" name="pemeriksaandalam[skala][riwayatJatuh][7]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['7'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa7()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa8" name="pemeriksaandalam[skala][riwayatJatuh][8]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['8'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa8()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa9" name="pemeriksaandalam[skala][riwayatJatuh][9]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['9'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa9()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa10" name="pemeriksaandalam[skala][riwayatJatuh][10]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['10'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa10()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa11" name="pemeriksaandalam[skala][riwayatJatuh][11]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['11'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa11()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa12" name="pemeriksaandalam[skala][riwayatJatuh][12]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['12'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa12()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa13" name="pemeriksaandalam[skala][riwayatJatuh][13]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['13'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa13()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa14" name="pemeriksaandalam[skala][riwayatJatuh][14]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['14'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa14()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa15" name="pemeriksaandalam[skala][riwayatJatuh][15]" value="{{ @$pemeriksaandalam['skala']['riwayatJatuh']['15'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa15()">
                  </td>
                </tr>
                <tr>
                  <td>Ya</td>
                  <td class="text-center">25</td>
                </tr>

                <tr>
                  <td rowspan="2" style="width: 350px;">Diagnosis Medis Sekunder > 1</td>
                  <td>Tidak</td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skala][diagnosisMedisSekunder][1]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['1'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skala][diagnosisMedisSekunder][2]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['2'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skala][diagnosisMedisSekunder][3]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['3'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skala][diagnosisMedisSekunder][4]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['4'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa4()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa5" name="pemeriksaandalam[skala][diagnosisMedisSekunder][5]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['5'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa5()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa6" name="pemeriksaandalam[skala][diagnosisMedisSekunder][6]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['6'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa6()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa7" name="pemeriksaandalam[skala][diagnosisMedisSekunder][7]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['7'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa7()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa8" name="pemeriksaandalam[skala][diagnosisMedisSekunder][8]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['8'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa8()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa9" name="pemeriksaandalam[skala][diagnosisMedisSekunder][9]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['9'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa9()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa10" name="pemeriksaandalam[skala][diagnosisMedisSekunder][10]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['10'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa10()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa11" name="pemeriksaandalam[skala][diagnosisMedisSekunder][11]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['11'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa11()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa12" name="pemeriksaandalam[skala][diagnosisMedisSekunder][12]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['12'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa12()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa13" name="pemeriksaandalam[skala][diagnosisMedisSekunder][13]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['13'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa13()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa14" name="pemeriksaandalam[skala][diagnosisMedisSekunder][14]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['14'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa14()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa15" name="pemeriksaandalam[skala][diagnosisMedisSekunder][15]" value="{{ @$pemeriksaandalam['skala']['diagnosisMedisSekunder']['15'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa15()">
                  </td>
                </tr>
                <tr>
                  <td>Ya</td>
                  <td class="text-center">15</td>
                </tr>

                <tr>
                  <td rowspan="3" style="width: 350px;">Alat Bantu Jalan</td>
                  <td>Bed rest / dibantu perawat</td>
                  <td class="text-center">0</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skala][alatBantuJalan][1]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['1'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skala][alatBantuJalan][2]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['2'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skala][alatBantuJalan][3]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['3'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skala][alatBantuJalan][4]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['4'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa4()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa5" name="pemeriksaandalam[skala][alatBantuJalan][5]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['5'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa5()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa6" name="pemeriksaandalam[skala][alatBantuJalan][6]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['6'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa6()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa7" name="pemeriksaandalam[skala][alatBantuJalan][7]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['7'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa7()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa8" name="pemeriksaandalam[skala][alatBantuJalan][8]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['8'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa8()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa9" name="pemeriksaandalam[skala][alatBantuJalan][9]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['9'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa9()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa10" name="pemeriksaandalam[skala][alatBantuJalan][10]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['10'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa10()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa11" name="pemeriksaandalam[skala][alatBantuJalan][11]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['11'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa11()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa12" name="pemeriksaandalam[skala][alatBantuJalan][12]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['12'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa12()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa13" name="pemeriksaandalam[skala][alatBantuJalan][13]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['13'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa13()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa14" name="pemeriksaandalam[skala][alatBantuJalan][14]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['14'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa14()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa15" name="pemeriksaandalam[skala][alatBantuJalan][15]" value="{{ @$pemeriksaandalam['skala']['alatBantuJalan']['15'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa15()">
                  </td>
                </tr>
                <tr>
                  <td>
                    Penopang, tongkat / walker
                  </td>
                  <td class="text-center">15</td>
                </tr>
                <tr>
                  <td>Furniture</td>
                  <td class="text-center">30</td>
                </tr>

                <tr>
                  <td rowspan="2" style="width: 350px;">Memakai terapi heparin lock /IV</td>
                  <td>Tidak</td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skala][terapiHeparin][1]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['1'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skala][terapiHeparin][2]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['2'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skala][terapiHeparin][3]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['3'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skala][terapiHeparin][4]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['4'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa4()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa5" name="pemeriksaandalam[skala][terapiHeparin][5]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['5'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa5()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa6" name="pemeriksaandalam[skala][terapiHeparin][6]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['6'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa6()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa7" name="pemeriksaandalam[skala][terapiHeparin][7]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['7'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa7()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa8" name="pemeriksaandalam[skala][terapiHeparin][8]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['8'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa8()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa9" name="pemeriksaandalam[skala][terapiHeparin][9]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['9'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa9()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa10" name="pemeriksaandalam[skala][terapiHeparin][10]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['10'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa10()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa11" name="pemeriksaandalam[skala][terapiHeparin][11]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['11'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa11()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa12" name="pemeriksaandalam[skala][terapiHeparin][12]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['12'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa12()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa13" name="pemeriksaandalam[skala][terapiHeparin][13]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['13'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa13()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa14" name="pemeriksaandalam[skala][terapiHeparin][14]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['14'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa14()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa15" name="pemeriksaandalam[skala][terapiHeparin][15]" value="{{ @$pemeriksaandalam['skala']['terapiHeparin']['15'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa15()">
                  </td>
                </tr>
                <tr>
                  <td>
                    Ya
                  </td>
                  <td class="text-center">25</td>
                </tr>

                <tr>
                  <td rowspan="3" style="width: 350px;">Cara berjalan / berpindah</td>
                  <td>Normal / bed rest / imobilisasi</td>
                  <td class="text-center">0</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skala][caraBerjalan][1]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['1'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skala][caraBerjalan][2]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['2'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skala][caraBerjalan][3]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['3'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skala][caraBerjalan][4]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['4'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa4()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa5" name="pemeriksaandalam[skala][caraBerjalan][5]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['5'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa5()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa6" name="pemeriksaandalam[skala][caraBerjalan][6]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['6'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa6()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa7" name="pemeriksaandalam[skala][caraBerjalan][7]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['7'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa7()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa8" name="pemeriksaandalam[skala][caraBerjalan][8]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['8'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa8()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa9" name="pemeriksaandalam[skala][caraBerjalan][9]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['9'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa9()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa10" name="pemeriksaandalam[skala][caraBerjalan][10]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['10'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa10()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa11" name="pemeriksaandalam[skala][caraBerjalan][11]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['11'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa11()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa12" name="pemeriksaandalam[skala][caraBerjalan][12]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['12'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa12()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa13" name="pemeriksaandalam[skala][caraBerjalan][13]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['13'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa13()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa14" name="pemeriksaandalam[skala][caraBerjalan][14]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['14'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa14()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa15" name="pemeriksaandalam[skala][caraBerjalan][15]" value="{{ @$pemeriksaandalam['skala']['caraBerjalan']['15'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa15()">
                  </td>
                </tr>
                <tr>
                  <td>Lemah</td>
                  <td class="text-center">15</td>
                </tr>
                <tr>
                  <td>Terganggu</td>
                  <td class="text-center">30</td>
                </tr>

                <tr>
                  <td rowspan="2" style="width: 350px;">Status Mental</td>
                  <td>
                    Orientasi sesuai kemampuan diri
                  </td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skala][statusMental][1]" value="{{ @$pemeriksaandalam['skala']['statusMental']['1'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skala][statusMental][2]" value="{{ @$pemeriksaandalam['skala']['statusMental']['2'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skala][statusMental][3]" value="{{ @$pemeriksaandalam['skala']['statusMental']['3'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skala][statusMental][4]" value="{{ @$pemeriksaandalam['skala']['statusMental']['4'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa4()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa5" name="pemeriksaandalam[skala][statusMental][5]" value="{{ @$pemeriksaandalam['skala']['statusMental']['5'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa5()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa6" name="pemeriksaandalam[skala][statusMental][6]" value="{{ @$pemeriksaandalam['skala']['statusMental']['6'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa6()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa7" name="pemeriksaandalam[skala][statusMental][7]" value="{{ @$pemeriksaandalam['skala']['statusMental']['7'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa7()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa8" name="pemeriksaandalam[skala][statusMental][8]" value="{{ @$pemeriksaandalam['skala']['statusMental']['8'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa8()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa9" name="pemeriksaandalam[skala][statusMental][9]" value="{{ @$pemeriksaandalam['skala']['statusMental']['9'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa9()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa10" name="pemeriksaandalam[skala][statusMental][10]" value="{{ @$pemeriksaandalam['skala']['statusMental']['10'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa10()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa11" name="pemeriksaandalam[skala][statusMental][11]" value="{{ @$pemeriksaandalam['skala']['statusMental']['11'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa11()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa12" name="pemeriksaandalam[skala][statusMental][12]" value="{{ @$pemeriksaandalam['skala']['statusMental']['12'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa12()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa13" name="pemeriksaandalam[skala][statusMental][13]" value="{{ @$pemeriksaandalam['skala']['statusMental']['13'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa13()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa14" name="pemeriksaandalam[skala][statusMental][14]" value="{{ @$pemeriksaandalam['skala']['statusMental']['14'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa14()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa15" name="pemeriksaandalam[skala][statusMental][15]" value="{{ @$pemeriksaandalam['skala']['statusMental']['15'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa15()">
                  </td>
                </tr>
                <tr>
                  <td>Lupa keterbatasan diri</td>
                  <td class="text-center">15</td>
                </tr>

                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">TOTAL</td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId1" name="pemeriksaandalam[skala][total][skor][1]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['1'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId2" name="pemeriksaandalam[skala][total][skor][2]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['2'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId3" name="pemeriksaandalam[skala][total][skor][3]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['3'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId4" name="pemeriksaandalam[skala][total][skor][4]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['4'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId5" name="pemeriksaandalam[skala][total][skor][5]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['5'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId6" name="pemeriksaandalam[skala][total][skor][6]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['6'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId7" name="pemeriksaandalam[skala][total][skor][7]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['7'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId8" name="pemeriksaandalam[skala][total][skor][8]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['8'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId9" name="pemeriksaandalam[skala][total][skor][9]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['9'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId10" name="pemeriksaandalam[skala][total][skor][10]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['10'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId11" name="pemeriksaandalam[skala][total][skor][11]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['11'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId12" name="pemeriksaandalam[skala][total][skor][12]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['12'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId13" name="pemeriksaandalam[skala][total][skor][13]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['13'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId14" name="pemeriksaandalam[skala][total][skor][14]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['14'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhId15" name="pemeriksaandalam[skala][total][skor][15]" value="{{ @$pemeriksaandalam['skala']['total']['skor']['15'] }}" readonly>
                  </td>
                </tr>

                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Tanggal dan jam</td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId1" name="pemeriksaandalam[skala][total][tanggal][1]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['1'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId2" name="pemeriksaandalam[skala][total][tanggal][2]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['2'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId3" name="pemeriksaandalam[skala][total][tanggal][3]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['3'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId4" name="pemeriksaandalam[skala][total][tanggal][4]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['4'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId5" name="pemeriksaandalam[skala][total][tanggal][5]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['5'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId6" name="pemeriksaandalam[skala][total][tanggal][6]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['6'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId7" name="pemeriksaandalam[skala][total][tanggal][7]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['7'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId8" name="pemeriksaandalam[skala][total][tanggal][8]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['8'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId9" name="pemeriksaandalam[skala][total][tanggal][9]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['9'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId10" name="pemeriksaandalam[skala][total][tanggal][10]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['10'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId11" name="pemeriksaandalam[skala][total][tanggal][11]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['11'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId12" name="pemeriksaandalam[skala][total][tanggal][12]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['12'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId13" name="pemeriksaandalam[skala][total][tanggal][13]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['13'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId14" name="pemeriksaandalam[skala][total][tanggal][14]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['14'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId15" name="pemeriksaandalam[skala][total][tanggal][15]" value="{{ @$pemeriksaandalam['skala']['total']['tanggal']['15'] }}">
                  </td>
                </tr>

                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Nama Penilai</td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId1" name="pemeriksaandalam[skala][total][penilai][1]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['1'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId2" name="pemeriksaandalam[skala][total][penilai][2]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['2'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId3" name="pemeriksaandalam[skala][total][penilai][3]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['3'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId4" name="pemeriksaandalam[skala][total][penilai][4]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['4'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId5" name="pemeriksaandalam[skala][total][penilai][5]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['5'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId6" name="pemeriksaandalam[skala][total][penilai][6]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['6'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId7" name="pemeriksaandalam[skala][total][penilai][7]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['7'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId8" name="pemeriksaandalam[skala][total][penilai][8]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['8'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId9" name="pemeriksaandalam[skala][total][penilai][9]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['9'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId10" name="pemeriksaandalam[skala][total][penilai][10]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['10'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId11" name="pemeriksaandalam[skala][total][penilai][11]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['11'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId12" name="pemeriksaandalam[skala][total][penilai][12]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['12'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId13" name="pemeriksaandalam[skala][total][penilai][13]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['13'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId14" name="pemeriksaandalam[skala][total][penilai][14]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['14'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId15" name="pemeriksaandalam[skala][total][penilai][15]" value="{{ @$pemeriksaandalam['skala']['total']['penilai']['15'] }}">
                  </td>
                </tr>


              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-right">Keterangan</td>
                  <td colspan="4">
                    Skor : <br>
                    0 - 24 = Tidak Berisiko<br>
                    25 - 50 = Risiko Rendah<br>
                    Skor >= 51 = Risiko Tinggi<br>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="col-md-12">
            <h5 class="text-center"><b>SKRINING NUTRISI DEWASA</b></h5>
            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">

              <tr>
                <td style="width: 50%; font-weight:bold">BB</td>
                <td>
                  @if (@$nutrisi)
                    <input type="text" required class="form-control" name="nutrisi[bb][detail]" style="width: 100%" placeholder="BB" value="{{ @$nutrisi['bb']['detail'] }}">
                  @elseif (@$dataAsesmenDokter)
                    <input type="text" required class="form-control" name="nutrisi[bb][detail]" style="width: 100%" placeholder="BB" value="{{ @$dataAsesmenDokter['igdAwal']['tandaVital']['tekananDarah'] }}">
                  @elseif (@$dataAsesmenPonek)
                    <input type="text" required class="form-control" name="nutrisi[bb][detail]" style="width: 100%" placeholder="BB" value="{{ @$dataAsesmenPonek['tanda_vital']['BB'] }}">
                  @else
                    <input type="text" required class="form-control" name="nutrisi[bb][detail]" style="width: 100%" placeholder="BB" value="{{ @$nutrisi['bb']['detail'] }}">
                  @endif
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan ?
                    <ul>
                      <li>Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir) => 0</li>
                      <li>Tidak yakin (Tanyakan apakah baju/celana terasa longgar) => 2</li>
                      <li>
                        Ya, berapa penurunan berat badan tersebut ?
                        <ul>
                          <li>1 - 5 kg => 1</li>
                          <li>6 - 10 kg => 2</li>
                          <li>11 - 15 kg => 3</li>
                          <li>> 15 kg => 4</li>
                          <li>Tidak Yakin => 2</li>
                        </ul>
                      </li>
                    </ul>
                </td>
                <td style="vertical-align: middle;">
                    <input type="text" required class="form-control skorSkrining" name="nutrisi[skor][1]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['1'] }}" onblur="totalSkor()">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    2. Apakah asupan makanan pasien buruk akibat nafsu makan yang menurun **? (Misalnya asupan makan hanya 1/4 dari biasanya)
                    <ul>
                        <li>Tidak => 0</li>
                        <li>Ya => 1</li>
                    </ul>
                </td>
                <td style="vertical-align: middle;">
                    <input type="text" required class="form-control skorSkrining" name="nutrisi[skor][2]" style="width: 100%" placeholder="0" value="{{ @$nutrisi['skor']['2'] }}" onblur="totalSkor()">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    3. Sakit Berat ***)
                    <ul>
                      <li>Tidak => 0</li>
                      <li>Ya => 2</li>
                    </ul>
                </td>
                <td style="vertical-align: middle;">
                    <input type="text" required class="form-control skorSkrining" name="nutrisi[skor][3]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['3'] }}" onblur="totalSkor()">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">Total Skor</td>
                <td>
                  <input type="text" class="form-control" name="nutrisi[skor][total]" id="totalSkorId" value="{{ @$nutrisi['skor']['total'] }}" style="width: 100%" readonly>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:bold;">Kesimpulan dan tindak lanjut</td>
                <td>
                  <input type="text" class="form-control" name="nutrisi[skor][kesimpulan]" id="kesimpulanSkorId" value="{{ @$nutrisi['skor']['kesimpulan'] }}" style="width: 100%" readonly>
                </td>
              </tr>
              <tr>
                <td colspan="2">Keterangan</td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:bold;" colspan="2">
                  <ul style="font-weight: normal">
                      <li>
                        Total skor >= 2 : Risiko malnutrisi.
                      </li>
                      <li>
                        *Malnutrisi yang dimaksud dalam hal ini adalah kurang gizi.
                      </li>
                      <li>
                        ** Asupan makan yang buruk dapat juga terjadi karena gangguan mengunyah atau menelan
                      </li>
                      <li>
                        Penurunan berat badan yang tidak direncanakan pada pasien dengan kelebihan berat atau obes berisiko terjadinya malnutrisi.
                      </li>
                      <li>
                        *** Penyakit yang berisiko terjadi gangguan gizi diantaranya: dirawat di HCU/ICU, penurunan kesadaran, 
                        kegawatan abdomen (pendarahan, ileus, perotonitis, asites massif, tumor intrabdomen besar, post operasi), 
                        gangguan pernapasan berat, keganasan komplikasi, gagal jantung, gagal ginjal kronik, gagal hati, diabetes melitus, 
                        atau kondisi sakit berat lain.
                      </li>
                  </ul>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>Spiritual</b></h5>
              <tr>
                  <td colspan="2" style="width: 50%;">Agama</td>
                  <td> 
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][agama]"
                              {{ @$assesment['spiritual']['agama'] == 'Islam' ? 'checked' : '' }}
                              type="radio" value="Islam">
                          <label class="form-check-label" style="font-weight: 400;">Islam</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][agama]"
                              {{ @$assesment['spiritual']['agama'] == 'Kristen' ? 'checked' : '' }}
                              type="radio" value="Kristen">
                          <label class="form-check-label" style="font-weight: 400;">Kristen</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][agama]"
                              {{ @$assesment['spiritual']['agama'] == 'Hindu' ? 'checked' : '' }}
                              type="radio" value="Hindu">
                          <label class="form-check-label" style="font-weight: 400;">Hindu</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][agama]"
                              {{ @$assesment['spiritual']['agama'] == 'Budha' ? 'checked' : '' }}
                              type="radio" value="Budha">
                          <label class="form-check-label" style="font-weight: 400;">Budha</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][agama]"
                              {{ @$assesment['spiritual']['agama'] == 'Lainnya' ? 'checked' : '' }}
                              type="radio" value="Lainnya">
                          <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                          <input type="text" class="form-control" placeholder="Lain-lain" name="fisik[spiritual][agama_lain]" value="{{ @$assesment['spiritual']['agama_lain'] }}">
                      </div>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="width: 50%;">Perubahan pola ibadah setelah sakit</td>
                  <td> 
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][perubahan_pola_ibadah]"
                              {{ @$assesment['spiritual']['perubahan_pola_ibadah'] == 'Berhenti' ? 'checked' : '' }}
                              type="radio" value="Berhenti">
                          <label class="form-check-label" style="font-weight: 400;">Berhenti</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][perubahan_pola_ibadah]"
                              {{ @$assesment['spiritual']['perubahan_pola_ibadah'] == 'Tidak berubah' ? 'checked' : '' }}
                              type="radio" value="Tidak berubah">
                          <label class="form-check-label" style="font-weight: 400;">Tidak berubah</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][perubahan_pola_ibadah]"
                              {{ @$assesment['spiritual']['perubahan_pola_ibadah'] == 'Bertambah/meningkat' ? 'checked' : '' }}
                              type="radio" value="Bertambah/meningkat">
                          <label class="form-check-label" style="font-weight: 400;">Bertambah/meningkat</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="width: 50%;">Respon setelah sakit</td>
                  <td> 
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][respon_setelah_sakit]"
                              {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Cobaan Hidup' ? 'checked' : '' }}
                              type="radio" value="Cobaan Hidup">
                          <label class="form-check-label" style="font-weight: 400;">Cobaan Hidup</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][respon_setelah_sakit]"
                              {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Menyalahkan Tuhan' ? 'checked' : '' }}
                              type="radio" value="Menyalahkan Tuhan">
                          <label class="form-check-label" style="font-weight: 400;">Menyalahkan Tuhan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][respon_setelah_sakit]"
                              {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Tidak bergairah' ? 'checked' : '' }}
                              type="radio" value="Tidak bergairah">
                          <label class="form-check-label" style="font-weight: 400;">Tidak bergairah</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][respon_setelah_sakit]"
                              {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Merasa putus asa' ? 'checked' : '' }}
                              type="radio" value="Merasa putus asa">
                          <label class="form-check-label" style="font-weight: 400;">Merasa putus asa</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="width: 50%;">Tanggapan terhadap diri setelah sakit</td>
                  <td> 
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][tanggapan_setelah_sakit]"
                              {{ @$assesment['spiritual']['tanggapan_setelah_sakit'] == 'Merasa tidak berguna' ? 'checked' : '' }}
                              type="radio" value="Merasa tidak berguna">
                          <label class="form-check-label" style="font-weight: 400;">Merasa tidak berguna</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][tanggapan_setelah_sakit]"
                              {{ @$assesment['spiritual']['tanggapan_setelah_sakit'] == 'Ketidakberdayaan' ? 'checked' : '' }}
                              type="radio" value="Ketidakberdayaan">
                          <label class="form-check-label" style="font-weight: 400;">Ketidakberdayaan</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="width: 50%;">Dukungan dan lingkungan</td>
                  <td> 
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][dukungan_dan_lingkungan]"
                              {{ @$assesment['spiritual']['dukungan_dan_lingkungan'] == 'Sangat mendukung' ? 'checked' : '' }}
                              type="radio" value="Sangat mendukung">
                          <label class="form-check-label" style="font-weight: 400;">Sangat mendukung</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][dukungan_dan_lingkungan]"
                              {{ @$assesment['spiritual']['dukungan_dan_lingkungan'] == 'Tidak ada dukungan' ? 'checked' : '' }}
                              type="radio" value="Tidak ada dukungan">
                          <label class="form-check-label" style="font-weight: 400;">Tidak ada dukungan</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="width: 50%;">Dirujuk ke rohaniawan</td>
                  <td> 
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][dirujuk_ke_rohaniawan]"
                              {{ @$assesment['spiritual']['dirujuk_ke_rohaniawan'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label" style="font-weight: 400;">Ya</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[spiritual][dirujuk_ke_rohaniawan]"
                              {{ @$assesment['spiritual']['dirujuk_ke_rohaniawan'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                      </div>
                  </td>
              </tr>
            </table>

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>Kebutuhan Edukasi</b></h5>
              <tr>
                  <td>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Hak untuk berpartisipasi dalam proses pelayanan' ? 'checked' : '' }}
                              type="radio" value="Hak untuk berpartisipasi dalam proses pelayanan">
                          <label class="form-check-label" style="font-weight: 400;">Hak untuk berpartisipasi dalam proses pelayanan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Proses pemberian informed consent' ? 'checked' : '' }}
                              type="radio" value="Proses pemberian informed consent">
                          <label class="form-check-label" style="font-weight: 400;">Proses pemberian informed consent</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Penggunaan Alat Medis yang aman' ? 'checked' : '' }}
                              type="radio" value="Penggunaan Alat Medis yang aman">
                          <label class="form-check-label" style="font-weight: 400;">Penggunaan Alat Medis yang aman</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Cuci tangan yang benar' ? 'checked' : '' }}
                              type="radio" value="Cuci tangan yang benar">
                          <label class="form-check-label" style="font-weight: 400;">Cuci tangan yang benar</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Lain-lain' ? 'checked' : '' }}
                              type="radio" value="Lain-lain">
                          <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                      </div>
                  </td>
                  <td>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Kondisi kesehatan diagnosis pasati, dan penatalakanaanya' ? 'checked' : '' }}
                              type="radio" value="Kondisi kesehatan diagnosis pasati, dan penatalakanaanya">
                          <label class="form-check-label" style="font-weight: 400;">Kondisi kesehatan diagnosis pasati, dan penatalakanaanya</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Penggunaan obat secara efektif dan aman, efek samping serta interaksinya' ? 'checked' : '' }}
                              type="radio" value="Penggunaan obat secara efektif dan aman, efek samping serta interaksinya">
                          <label class="form-check-label" style="font-weight: 400;">Penggunaan obat secara efektif dan aman, efek samping serta interaksinya</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Prosedur pemeriksaan penunjangan' ? 'checked' : '' }}
                              type="radio" value="Prosedur pemeriksaan penunjangan">
                          <label class="form-check-label" style="font-weight: 400;">Prosedur pemeriksaan penunjangan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Rujukan Edukasi' ? 'checked' : '' }}
                              type="radio" value="Rujukan Edukasi">
                          <label class="form-check-label" style="font-weight: 400;">Rujukan Edukasi</label>
                      </div>
                  </td>
                  <td> 
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Diet & Nutrisi' ? 'checked' : '' }}
                              type="radio" value="Diet & Nutrisi">
                          <label class="form-check-label" style="font-weight: 400;">Diet & Nutrisi</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Manajemen Nyeri' ? 'checked' : '' }}
                              type="radio" value="Manajemen Nyeri">
                          <label class="form-check-label" style="font-weight: 400;">Manajemen Nyeri</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Bahaya merokok' ? 'checked' : '' }}
                              type="radio" value="Bahaya merokok">
                          <label class="form-check-label" style="font-weight: 400;">Bahaya merokok</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[kebutuhan_edukasi]"
                              {{ @$assesment['kebutuhan_edukasi'] == 'Teknik rehabilitasi' ? 'checked' : '' }}
                              type="radio" value="Teknik rehabilitasi">
                          <label class="form-check-label" style="font-weight: 400;">Teknik rehabilitasi</label>
                      </div>
                  </td>
              </tr>
            </table>

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>Rencana Pemulangan Pasien</b></h5>
              <tr>
                  <td>
                      <div >
                          <input class="form-check-input" name="fisik[discharge_planning][perlu_home_care]"
                          {{ @$assesment['discharge_planning']['perlu_home_care'] == 'true' ? 'checked' : '' }} type="checkbox"
                          value="true">
                          <label class="form-check-label">Perlu pelayanan home care</label>
                      </div>
                      <div >
                          <input class="form-check-input" name="fisik[discharge_planning][perlu_pasang_implant]"
                          {{ @$assesment['discharge_planning']['perlu_pasang_implant'] == 'true' ? 'checked' : '' }} type="checkbox"
                          value="true">
                          <label class="form-check-label">Perlu pemasangan implant</label>
                      </div>
                  </td>
                  <td>
                      <div >
                          <input class="form-check-input" name="fisik[discharge_planning][penggunaan_alat_bantu]"
                          {{ @$assesment['discharge_planning']['penggunaan_alat_bantu'] == 'true' ? 'checked' : '' }} type="checkbox"
                          value="true">
                          <label class="form-check-label">Penggunaan alat bantu</label>
                      </div>
                      <div >
                          <input class="form-check-input" name="fisik[discharge_planning][dirujuk_ke_komunitas]"
                          {{ @$assesment['discharge_planning']['dirujuk_ke_komunitas'] == 'true' ? 'checked' : '' }} type="checkbox"
                          value="true">
                          <label class="form-check-label">Dirujuk ke komunitas tertentu</label>
                      </div>
                  </td>
                  <td> 
                      <div >
                          <input class="form-check-input" name="fisik[discharge_planning][dirujuk_ke_tim]"
                          {{ @$assesment['discharge_planning']['dirujuk_ke_tim'] == 'true' ? 'checked' : '' }} type="checkbox"
                          value="true">
                          <label class="form-check-label">Dirujuk ke tim terapis</label>
                      </div>
                      <div >
                          <input class="form-check-input" name="fisik[discharge_planning][dirujuk_ke_gizi]"
                          {{ @$assesment['discharge_planning']['dirujuk_ke_gizi'] == 'true' ? 'checked' : '' }} type="checkbox"
                          value="true">
                          <label class="form-check-label">Dirujuk ke ahli gizi</label>
                      </div>
                  </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>I. DATA DIAGNOSTIK</b></h5>
              <tr>
                  <td style="width: 25%;">Laboratorium</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[data_diganostik][laboratorium]" id="" cols="30" rows="10" placeholder="Laboratorium">{{ @$assesment['data_diganostik']['laboratorium'] }}</textarea>
                  </td>
              </tr>
              <tr>
                  <td style="width: 25%;">Radiologi</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[data_diganostik][radiologi]" id="" cols="30" rows="10" placeholder="Radiologi">{{ @$assesment['data_diganostik']['radiologi'] }}</textarea>
                  </td>
              </tr>
              <tr>
                  <td style="width: 25%;">Lain-lain</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[data_diganostik][lain_lain]" id="" cols="30" rows="10" placeholder="Lain-lain">{{ @$assesment['data_diganostik']['lain_lain'] }}</textarea>
                  </td>
              </tr>
            </table>

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>II. DIAGNOSA KEPERAWATAN BERDASARKAN SKALA PRIORITAS</b></h5>
              <tr>
                  <td style="width: 25%;">1.</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][1]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['1'] }}</textarea>
                  </td>
              </tr>
              <tr>
                  <td style="width: 25%;">2.</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][2]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['2'] }}</textarea>
                  </td>
              </tr>
              <tr>
                  <td style="width: 25%;">3.</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][3]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['3'] }}</textarea>
                  </td>
              </tr>
              <tr>
                  <td style="width: 25%;">4.</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][4]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['4'] }}</textarea>
                  </td>
              </tr>
              <tr>
                  <td style="width: 25%;">5.</td>
                  <td colspan="2"> 
                      <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][5]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['5'] }}</textarea>
                  </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            
            <input class="btn btn-warning" type="reset" value="Reset">&nbsp;&nbsp;
            <button class="btn btn-success pull-right">Simpan</button>
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
    $('.select2').select2();
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
         
        $('.hitungResiko').on('change', function (){
          var total = 0 ;
          var hasil = $('.hasilSkorResiko');
          $('.hitungResiko:checked').each(function (){
            total += parseInt($(this).val());
          });

          $('.jumlahSkorResiko').val(total);

          if(total < 10){
            hasil.val('Risiko sangat tinggi');
          }else if(total <= 12){
            hasil.val('Risiko tinggi');
          }else if(total <= 14){
            hasil.val('Risiko sedang');
          }else if(total <= 18){
            hasil.val('Berisiko');
          }else if(total > 19){
            hasil.val('Risiko rendah / tidak berisiko');
          }
        });

        $('.fungsional-input').on('change', function (){
          var tot = 0;
          var hasilInput = $('.hasilSkorFungsional');

          $('.fungsional-input:checked').each(function (){
            tot += parseInt($(this).val());
          });

          $('.jumlahSkorFungsional').val(tot);

          if(tot <= 3){
            hasilInput.val('Pasien Sangat Ketergantungan');
          }else if(tot <= 5){
            hasilInput.val('Pasien Ketergantungan Sedang');
          }else if(tot >= 6){
            hasilInput.val('Pasien Mandiri');
          }
        });

    function totalResikoJatuhDewasa1(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa1');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId1').value = tot;
    }
    function totalResikoJatuhDewasa2(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa2');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId2').value = tot;
    }
    function totalResikoJatuhDewasa3(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa3');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId3').value = tot;
    }
    function totalResikoJatuhDewasa4(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa4');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId4').value = tot;
    }
    function totalResikoJatuhDewasa5(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa5');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId5').value = tot;
    }
    function totalResikoJatuhDewasa6(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa6');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId6').value = tot;
    }
    function totalResikoJatuhDewasa7(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa7');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId7').value = tot;
    }
    function totalResikoJatuhDewasa8(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa8');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId8').value = tot;
    }
    function totalResikoJatuhDewasa9(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa9');
      var tot = 0;
      for(var i = 0; i < arr.length; i++){
        if(parseInt(arr[i].value))
          tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId9').value = tot;
    }
    function totalResikoJatuhDewasa10(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa10');
      var tot = 0;
      for(var i = 0; i < arr.length; i++){
        if(parseInt(arr[i].value))
          tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId10').value = tot;
    }
    function totalResikoJatuhDewasa11(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa11');
      var tot = 0;
      for(var i = 0; i < arr.length; i++){
        if(parseInt(arr[i].value))
          tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId11').value = tot;
    }
    function totalResikoJatuhDewasa12(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa12');
      var tot = 0;
      for(var i = 0; i < arr.length; i++){
        if(parseInt(arr[i].value))
          tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId12').value = tot;
    }
    function totalResikoJatuhDewasa13(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa13');
      var tot = 0;
      for(var i = 0; i < arr.length; i++){
        if(parseInt(arr[i].value))
          tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId13').value = tot;
    }
    function totalResikoJatuhDewasa14(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa14');
      var tot = 0;
      for(var i = 0; i < arr.length; i++){
        if(parseInt(arr[i].value))
          tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId14').value = tot;
    }
    function totalResikoJatuhDewasa15(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa15');
      var tot = 0;
      for(var i = 0; i < arr.length; i++){
        if(parseInt(arr[i].value))
          tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId15').value = tot;
    }

    function totalSkor(){
      var arr = document.getElementsByClassName('skorSkrining');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalSkorId').value = tot;
      
      if (tot > 3) {
        document.getElementById('kesimpulanSkorId').value = 'Rujuk ke dokter Spesialis Gizi Klinik';
      } else if (tot < 2) {
        document.getElementById('kesimpulanSkorId').value = 'Skrining ulang 7 hari';
      } else if (tot <= 3) {
        document.getElementById('kesimpulanSkorId').value = 'Rujuk ke dietisien';
      }
    }
  </script>
  @endsection