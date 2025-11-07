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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen_anak_perawat/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
        
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <h4 style="text-align: center; padding: 10px"><b>Pengkajian Awal Keperawatan Anak</b></h4>
          <br>


         <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>KEADAAN UMUM</b></h5>

              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">1. Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Tekanan Darah (mmHG)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['tekanan_darah']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['nadi']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][RR]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['RR']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][temp]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['temp']}}">
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
                            <input type="radio" id="kesadaran1" name="fisik[keadaan_umum][kesadaran]" value="Lethargi" {{@$assesment['keadaan_umum']['kesadaran'] == 'Lethargi' ? 'checked' : ''}}>
                            <label for="kesadaran1" style="font-weight: normal;">Lethargi</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran2" name="fisik[keadaan_umum][kesadaran]" value="Koma" {{@$assesment['keadaan_umum']['kesadaran'] == 'Koma' ? 'checked' : ''}}>
                            <label for="kesadaran2" style="font-weight: normal;">Koma</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran3" name="fisik[keadaan_umum][kesadaran]" value="Apatis" {{@$assesment['keadaan_umum']['kesadaran'] == 'Apatis' ? 'checked' : ''}}>
                            <label for="kesadaran3" style="font-weight: normal;">Apatis</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran4" name="fisik[keadaan_umum][kesadaran]" value="Sopor" {{@$assesment['keadaan_umum']['kesadaran'] == 'Sopor' ? 'checked' : ''}}>
                            <label for="kesadaran4" style="font-weight: normal;">Sopor</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran5" name="fisik[keadaan_umum][kesadaran]" value="Dellrium" {{@$assesment['keadaan_umum']['kesadaran'] == 'Dellrium' ? 'checked' : ''}}>
                            <label for="kesadaran5" style="font-weight: normal;">Dellrium</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran5" name="fisik[keadaan_umum][kesadaran]" value="Somnolen" {{@$assesment['keadaan_umum']['kesadaran'] == 'Somnolen' ? 'checked' : ''}}>
                            <label for="kesadaran5" style="font-weight: normal;">Somnolen</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran5" name="fisik[keadaan_umum][kesadaran]" value="Semi Koma" {{@$assesment['keadaan_umum']['kesadaran'] == 'Semi Koma' ? 'checked' : ''}}>
                            <label for="kesadaran5" style="font-weight: normal;">Semi Koma</label><br>
                        </div>
                        <div>
                            <input type="radio" id="kesadaran5" name="fisik[keadaan_umum][kesadaran]" value="GCS" {{@$assesment['keadaan_umum']['kesadaran'] == 'GCS' ? 'checked' : ''}}>
                            <label for="kesadaran5" style="font-weight: normal;">GCS :</label><br>
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
                <td  style="width:20%; font-weight:bold;" colspan="2">
                    3. Asesmen Nyeri
                </td>
                <td style="padding: 5px;">
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
                  <td  style=""  colspan="2">
                      Provokatif
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Bantuan' ? 'checked' : '' }}
                              type="radio" value="Bantuan">
                          <label class="form-check-label">Bantuan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Spontan' ? 'checked' : '' }}
                              type="radio" value="Spontan">
                          <label class="form-check-label">Spontan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Aktivitas' ? 'checked' : '' }}
                              type="radio" value="Aktivitas">
                          <label class="form-check-label">Aktivitas</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Lain - lain' ? 'checked' : '' }}
                              type="radio" value="Lain - lain">
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
                              type="radio" value="Seperti tertusuk benda tajam/tumpul">
                          <label class="form-check-label">Seperti tertusuk benda tajam/tumpul</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Berdenyut' ? 'checked' : '' }}
                              type="radio" value="Berdenyut">
                          <label class="form-check-label">Berdenyut</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Terpelintir' ? 'checked' : '' }}
                              type="radio" value="Terpelintir">
                          <label class="form-check-label">Terpelintir</label>
                      </div>
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Terbakar' ? 'checked' : '' }}
                              type="radio" value="Terbakar">
                          <label class="form-check-label">Terbakar</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Tertindih' ? 'checked' : '' }}
                              type="radio" value="Tertindih">
                          <label class="form-check-label">Tertindih</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[keadaan_umum][asesmenNyeri][quality]"
                              {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Lain - lain' ? 'checked' : '' }}
                              type="radio" value="Lain - lain">
                          <label class="form-check-label">Lain - lain</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td  style=""  colspan="2">
                      Region
                  </td>
                  <td style="padding: 5px;">
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
                  <td  style=""  colspan="2">
                      Severity
                  </td>
                  <td style="padding: 5px;">
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
                  <td  style=""  colspan="2">
                      Time (Durasi Nyeri)
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input type="text" class="form-control" placeholder="Durasi Nyeri" name="fisik[keadaan_umum][asesmenNyeri][durasi_nyeri]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['durasi_nyeri'] }}">
                      </div>
                  </td>
              </tr>
              <tr>

              <tr>
                <td  style="width:20%; font-weight:bold;" colspan="2">
                    4. Berat Badan
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Berat Badan" name="fisik[keadaan_umum][berat_badan]" value="{{ @$assesment['keadaan_umum']['berat_badan'] }}">
                </td>
              </tr>

              <tr>
                <td  style="width:20%; font-weight:bold;" colspan="2">
                    5. Tinggi Badan
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Tinggi Badan" name="fisik[keadaan_umum][tinggi_badan]" value="{{ @$assesment['keadaan_umum']['tinggi_badan'] }}">
                </td>
              </tr>

              <tr>
                <td  style="width:20%; font-weight:bold;" colspan="2">
                    6. Lingkar Kepala
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Lingkar Kepala" name="fisik[keadaan_umum][lingkar_kepala]" value="{{ @$assesment['keadaan_umum']['lingkar_kepala'] }}">
                </td>
              </tr>

              
            </table>
         </div>

         <div class="col-md-6">


          
          <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            <h5 class="text-center"><b>KELUHAN UTAMA</b></h5>
            <tr>
              <td>
                <textarea name="fisik[keluhanUtama]" class="form-control" style="resize: vertical;" rows="5">{{ @$assesment['keluhanUtama'] }}</textarea>
              </td>
            </tr>
          </table>
          <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            <h5 class="text-center"><b>RIWAYAT KEHAMILAN DAN MELAHIRKAN</b></h5>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Prenatal
              </td>
              <td>
                <input name="fisik[riwayat_kehamilan@_dan_melahirkan][prenatal]" type="text" class="form-control" placeholder="Prenatal" value="{{ @$assesment['riwayat_kehamilan_dan_melahirkan']['prenatal']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Natal
              </td>
              <td>
                <input name="fisik[riwayat_kehamilan_dan_melahirkan][natal]" type="text" class="form-control" placeholder="Natal" value="{{ @$assesment['riwayat_kehamilan_dan_melahirkan']['natal']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Post Natal
              </td>
              <td>
                <input name="fisik[riwayat_kehamilan_dan_melahirkan][post_natal]" type="text" class="form-control" placeholder="Post Natal" value="{{ @$assesment['riwayat_kehamilan_dan_melahirkan']['post_natal']}}">
              </td>
            </tr>
          </table>

          <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            <h5 class="text-center"><b>RIWAYAT MASA LALU</b></h5>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Penyakit Waktu Kecil
              </td>
              <td>
                <input name="fisik[riwayat_masa_lalu][penyakit_waktu_kecil]" type="text" class="form-control" placeholder="Penyakit Waktu Kecil" value="{{ @$assesment['riwayat_masa_lalu']['penyakit_waktu_kecil']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Pernah Operasi / Kecelakaan
              </td>
              <td>
                <input name="fisik[riwayat_masa_lalu][pernah_operasi]" type="text" class="form-control" placeholder="Pernah Operasi / Kecelakaan" value="{{ @$assesment['riwayat_masa_lalu']['pernah_operasi']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Obat-obat yang digunakan
              </td>
              <td>
                <input name="fisik[riwayat_masa_lalu][obat_yang_digunakan]" type="text" class="form-control" placeholder="Obat-obat yang digunakan" value="{{ @$assesment['riwayat_masa_lalu']['obat_yang_digunakan']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Alergi
              </td>
              <td>
                <input name="fisik[riwayat_masa_lalu][alergi]" type="text" class="form-control" placeholder="Alergi" value="{{ @$assesment['riwayat_masa_lalu']['alergi']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Imunisasi
              </td>
              <td>
                <input name="fisik[riwayat_masa_lalu][imunisasi]" type="text" class="form-control" placeholder="Imunisasi" value="{{ @$assesment['riwayat_masa_lalu']['imunisasi']}}">
              </td>
            </tr>
          </table>

          <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            <h5 class="text-center"><b>TINGKAT PERKEMBANGAN</b></h5>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Kemandirian dan sosialisas
              </td>
              <td>
                <input name="fisik[tingkat_perkembangan][kemandirian]" type="text" class="form-control" placeholder="Kemandirian dan sosialisas" value="{{ @$assesment['tingkat_perkembangan']['kemandirian']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Motonk halus
              </td>
              <td>
                <input name="fisik[tingkat_perkembangan][motonk_halus]" type="text" class="form-control" placeholder="Motong halus" value="{{ @$assesment['tingkat_perkembangan']['motonk_halus']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Motonk kasar
              </td>
              <td>
                <input name="fisik[tingkat_perkembangan][motonk_kasar]" type="text" class="form-control" placeholder="Motong kasar" value="{{ @$assesment['tingkat_perkembangan']['motonk_kasar']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Kognotif dan bicara
              </td>
              <td>
                <input name="fisik[tingkat_perkembangan][kognotif_dan_bicara]" type="text" class="form-control" placeholder="Kognotif dan bicara" value="{{ @$assesment['tingkat_perkembangan']['kognotif_dan_bicara']}}">
              </td>
            </tr>
          </table>

          <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            <h5 class="text-center"><b>RIWAYAT KELUARGA</b></h5>
            <tr>
                <td>
                    <textarea style="width: 100%;" name="fisik[riwayat_keluarga][detail]" id="" cols="30" rows="10" placeholder="[Riwayat Keluarga]">{{ @$assesment['riwayat_keluarga']['detail'] }}</textarea>
                </td>
            </tr>
          </table>

          <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            <h5 class="text-center"><b>RIWAYAT SOSIAL</b></h5>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Yang mengasuh
              </td>
              <td>
                <input name="fisik[riwayat_sosial][yang_mengasuh]" type="text" class="form-control" placeholder="Yang mengasuh" value="{{ @$assesment['riwayat_sosial']['yang_mengasuh']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Hubungan dengan anggota keluarga
              </td>
              <td>
                <input name="fisik[riwayat_sosial][hubungan_keluarga]" type="text" class="form-control" placeholder="Hubungan dengan anggota keluarga" value="{{ @$assesment['riwayat_sosial']['hubungan_keluarga']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Hubungan dengan teman sebaya
              </td>
              <td>
                <input name="fisik[riwayat_sosial][hubungan_teman]" type="text" class="form-control" placeholder="Hubungan dengan teman sebaya" value="{{ @$assesment['riwayat_sosial']['hubungan_teman']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Pembawaan secara umum
              </td>
              <td>
                <input name="fisik[riwayat_sosial][pembawaan_secara_umum]" type="text" class="form-control" placeholder="Pembawaan secara umum" value="{{ @$assesment['riwayat_sosial']['pembawaan_secara_umum']}}">
              </td>
            </tr>
            <tr>
              <td style="width: 50%; font-weight: bold;">
                Lingkungan rumah
              </td>
              <td>
                <input name="fisik[riwayat_sosial][lingkungan_rumah]" type="text" class="form-control" placeholder="Lingkungan rumah" value="{{ @$assesment['riwayat_sosial']['lingkungan_rumah']}}">
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

        <div class="row">
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2" style="font-weight: bold;">SISTEM GASTROINTESTIAL</td>
              </tr>
              <tr>
                <td>Makan</td>
                <td>
                  <input type="text" class="form-control" style="display: inline-block; width: 150px;" placeholder="x/hari" name="fisik[pemeriksaanFisik][sistemGastrointestial][makan][frekuensi]" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['frekuensi'] }}">
                  <span>, Jumlah</span>
                  <input type="text" class="form-control" style="display: inline-block; width: 150px;" placeholder="porsi" name="fisik[pemeriksaanFisik][sistemGastrointestial][makan][porsi]" value="{{ @$assesment['pemeriksaanFisik']['sistemGastrointestial']['makan']['porsi'] }}">
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
                <td colspan="2" style="font-weight: bold;">Hygiene</td>
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
        </div>

        <div class="row">
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>SKRINING RISIKO DEKUBITUS</b></h5>
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
        </div>

        <div class="row">
          <h5 class="text-center"><b>PEMANTAUAN RESIKO JATUH HARIAN PASIEN ANAK SKALA HUMPTY DUMPTY</b></h5>
          <div class="col-md-12">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style=""> 
              <thead>
                <tr>
                  <th class="text-center" style="width: 25%;">Parameter</th>
                  <th class="text-center" style="width: 30%;">Kriteria</th>
                  <th class="text-center" style="width: 5%;">Nilai</th>
                  <th class="text-center" style="width: 10%;">Skor 1</th>
                  <th class="text-center" style="width: 10%;">Skor 2</th>
                  <th class="text-center" style="width: 10%;">Skor 3</th>
                  <th class="text-center" style="width: 10%;">Skor 4</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowspan="3">Umur</td>
                  <td>Dibawah 3 Tahun</td>
                  <td class="text-center">4</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][Umur][1]" value="{{ @$pemeriksaandalam['skala']['Umur']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][Umur][2]" value="{{ @$pemeriksaandalam['skala']['Umur']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][Umur][3]" value="{{ @$pemeriksaandalam['skala']['Umur']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][Umur][4]" value="{{ @$pemeriksaandalam['skala']['Umur']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>3-7 Tahun</td>
                  <td class="text-center">3</td>
                </tr>
                <tr>
                  <td>7-14 Tahun</td>
                  <td class="text-center">2</td>
                </tr>

                <tr>
                  <td rowspan="2">Jenis Kelamin</td>
                  <td>Laki-Laki</td>
                  <td class="text-center">2</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][jenisKelamin][1]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][jenisKelamin][2]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][jenisKelamin][3]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][jenisKelamin][4]" value="{{ @$pemeriksaandalam['skala']['jenisKelamin']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>Perempuan</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="4">Diagnosa</td>
                  <td>Kelainan Neorologis</td>
                  <td class="text-center">4</td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][diagnosa][1]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][diagnosa][2]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][diagnosa][3]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][diagnosa][4]" value="{{ @$pemeriksaandalam['skala']['diagnosa']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>
                    Perubahan Oksigenasi (Masalah Saluran Nafas, Dehidrasi, Anemia, Anoreksia, Sinkop / Sakit Kepala, dll)
                  </td>
                  <td class="text-center">3</td>
                </tr>
                <tr>
                  <td>Kelainan Psikis Perilaku</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>Diagnosa Lain</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="4">Faktor Lingkungan</td>
                  <td>Riwayat jatuh dari tempat tidur saat bayi anak</td>
                  <td class="text-center">4</td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][faktorLingkungan][1]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][faktorLingkungan][2]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][faktorLingkungan][3]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="4" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][faktorLingkungan][4]" value="{{ @$pemeriksaandalam['skala']['faktorLingkungan']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>
                    Pasien menggunakan alat bantu/box
                  </td>
                  <td class="text-center">3</td>
                </tr>
                <tr>
                  <td>Pasien berada di tempat tidur</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>Diluar ruang rawat</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="3">Respon terhadap operasi/obat penenang/efek anestesi</td>
                  <td>Dalam 0 - 24 jam</td>
                  <td class="text-center">3</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][responOperasi][1]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][responOperasi][2]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][responOperasi][3]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][responOperasi][4]" value="{{ @$pemeriksaandalam['skala']['responOperasi']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>Dalam 25 - 48 jam</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>> 48 jam</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td rowspan="3">Penggunaan obat</td>
                  <td>
                    Bermacam-macam obat digunakan obat sedative, hipnotik, barbiturate, fenotiazin, antidepresan, laksatif/diuretic, narkotik
                  </td>
                  <td class="text-center">3</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak1" name="pemeriksaandalam[skala][penggunaanObat][1]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['1'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak2" name="pemeriksaandalam[skala][penggunaanObat][2]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['2'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak3" name="pemeriksaandalam[skala][penggunaanObat][3]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['3'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhAnak4" name="pemeriksaandalam[skala][penggunaanObat][4]" value="{{ @$pemeriksaandalam['skala']['penggunaanObat']['4'] }}" placeholder="mis: 4" onblur="totalResikoJatuhAnak4()">
                  </td>
                </tr>
                <tr>
                  <td>Salah satu dari pengobatan di atas</td>
                  <td class="text-center">2</td>
                </tr>
                <tr>
                  <td>Pengobatan lain</td>
                  <td class="text-center">1</td>
                </tr>

                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Jumlah skor Humpty dumpty</td>
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
                </tr>


              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-right">Keterangan</td>
                  <td colspan="4">
                    Skor resiko jatuh (skor minimum 7 dan skor maksimum 23)
                    <br>
                    Skor : <br>
                    7-11 = Resiko rendah untuk jatuh<br>
                    >12 = Resiko tinggi untuk jatuh<br>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="row">
          <h4 class="text-center"><b>PENILAIAN RISIKO JATUH DEWASA DAN LANSIA</b></h4>
          <h5 class="text-center"><b>SKALA MORSE <i>(MORSE FALLS SCALE / MFS)</i></b></h5>
          <div class="col-md-12">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style=""> 
              <thead>
                <tr>
                  <th class="text-center" style="width: 25%;">Parameter</th>
                  <th class="text-center" style="width: 30%;">Kriteria</th>
                  <th class="text-center" style="width: 5%;">Nilai</th>
                  <th class="text-center" style="width: 10%;">Skor 1</th>
                  <th class="text-center" style="width: 10%;">Skor 2</th>
                  <th class="text-center" style="width: 10%;">Skor 3</th>
                  <th class="text-center" style="width: 10%;">Skor 4</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowspan="2">Riwayat jatuh, yang baru atau dalam bulan terakhir</td>
                  <td>Tidak</td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skalaDewasa][riwayatJatuh][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['riwayatJatuh']['1'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skalaDewasa][riwayatJatuh][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['riwayatJatuh']['2'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skalaDewasa][riwayatJatuh][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['riwayatJatuh']['3'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skalaDewasa][riwayatJatuh][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['riwayatJatuh']['4'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa4()">
                  </td>
                </tr>
                <tr>
                  <td>Ya</td>
                  <td class="text-center">25</td>
                </tr>
  
                <tr>
                  <td rowspan="2">Diagnosis Medis Sekunder > 1</td>
                  <td>Tidak</td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skalaDewasa][diagnosisMedisSekunder][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['diagnosisMedisSekunder']['1'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skalaDewasa][diagnosisMedisSekunder][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['diagnosisMedisSekunder']['2'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skalaDewasa][diagnosisMedisSekunder][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['diagnosisMedisSekunder']['3'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skalaDewasa][diagnosisMedisSekunder][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['diagnosisMedisSekunder']['4'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa4()">
                  </td>
                </tr>
                <tr>
                  <td>Ya</td>
                  <td class="text-center">15</td>
                </tr>
  
                <tr>
                  <td rowspan="3">Alat Bantu Jalan</td>
                  <td>Bed rest / dibantu perawat</td>
                  <td class="text-center">0</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skalaDewasa][alatBantuJalan][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['alatBantuJalan']['1'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skalaDewasa][alatBantuJalan][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['alatBantuJalan']['2'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skalaDewasa][alatBantuJalan][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['alatBantuJalan']['3'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skalaDewasa][alatBantuJalan][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['alatBantuJalan']['4'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa4()">
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
                  <td rowspan="2">Memakai terapi heparin lock /IV</td>
                  <td>Tidak</td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skalaDewasa][terapiHeparin][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['terapiHeparin']['1'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skalaDewasa][terapiHeparin][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['terapiHeparin']['2'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skalaDewasa][terapiHeparin][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['terapiHeparin']['3'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skalaDewasa][terapiHeparin][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['terapiHeparin']['4'] }}" placeholder="mis: 25" onblur="totalResikoJatuhDewasa4()">
                  </td>
                </tr>
                <tr>
                  <td>
                    Ya
                  </td>
                  <td class="text-center">25</td>
                </tr>
  
                <tr>
                  <td rowspan="3">Cara berjalan / berpindah</td>
                  <td>Normal / bed rest / imobilisasi</td>
                  <td class="text-center">0</td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skalaDewasa][caraBerjalan][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['caraBerjalan']['1'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skalaDewasa][caraBerjalan][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['caraBerjalan']['2'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skalaDewasa][caraBerjalan][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['caraBerjalan']['3'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="3" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skalaDewasa][caraBerjalan][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['caraBerjalan']['4'] }}" placeholder="mis: 30" onblur="totalResikoJatuhDewasa4()">
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
                  <td rowspan="2">Status Mental</td>
                  <td>
                    Orientasi sesuai kemampuan diri
                  </td>
                  <td class="text-center">0</td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa1" name="pemeriksaandalam[skalaDewasa][statusMental][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['statusMental']['1'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa1()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa2" name="pemeriksaandalam[skalaDewasa][statusMental][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['statusMental']['2'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa2()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa3" name="pemeriksaandalam[skalaDewasa][statusMental][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['statusMental']['3'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa3()">
                  </td>
                  <td rowspan="2" style="vertical-align: middle;">
                    <input type="text" class="form-control resikoJatuhDewasa4" name="pemeriksaandalam[skalaDewasa][statusMental][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['statusMental']['4'] }}" placeholder="mis: 15" onblur="totalResikoJatuhDewasa4()">
                  </td>
                </tr>
                <tr>
                  <td>Lupa keterbatasan diri</td>
                  <td class="text-center">15</td>
                </tr>
  
                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">TOTAL</td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhDewasaId1" name="pemeriksaandalam[skalaDewasa][total][skor][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['skor']['1'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhDewasaId2" name="pemeriksaandalam[skalaDewasa][total][skor][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['skor']['2'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhDewasaId3" name="pemeriksaandalam[skalaDewasa][total][skor][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['skor']['3'] }}" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" id="skorResikoJatuhDewasaId4" name="pemeriksaandalam[skalaDewasa][total][skor][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['skor']['4'] }}" readonly>
                  </td>
                </tr>
  
                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Tanggal dan jam</td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId1" name="pemeriksaandalam[skalaDewasa][total][tanggal][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['tanggal']['1'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId2" name="pemeriksaandalam[skalaDewasa][total][tanggal][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['tanggal']['2'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId3" name="pemeriksaandalam[skalaDewasa][total][tanggal][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['tanggal']['3'] }}">
                  </td>
                  <td>
                    <input type="datetime-local" class="form-control" id="tanggalResikoJatuhId4" name="pemeriksaandalam[skalaDewasa][total][tanggal][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['tanggal']['4'] }}">
                  </td>
                </tr>
  
                <tr>
                  <td colspan="3" class="text-right" style="font-weight: bold;">Nama Penilai</td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId1" name="pemeriksaandalam[skalaDewasa][total][penilai][1]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['penilai']['1'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId2" name="pemeriksaandalam[skalaDewasa][total][penilai][2]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['penilai']['2'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId3" name="pemeriksaandalam[skalaDewasa][total][penilai][3]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['penilai']['3'] }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" id="penilaiResikoJatuhId4" name="pemeriksaandalam[skalaDewasa][total][penilai][4]" value="{{ @$pemeriksaandalam['skalaDewasa']['total']['penilai']['4'] }}">
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
        </div>

        <div class="row">
          <div class="col-md-12">
            <h5 class="text-center"><b>SKRINING NUTRISI ANAK</b></h5>
            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
              <tr>
                <td colspan="2">SKRINING GIZI ANAK (USIA 1 BULAN - 14 TAHUN)</td>
              </tr>

              <tr>
                <td style="width: 50%; font-weight:bold">BB</td>
                <td>
                  <input type="text" required class="form-control" name="nutrisi[bb][detail]" style="width: 100%" placeholder="BB" value="{{ @$nutrisi['bb']['detail'] }}">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    1. Apakah pasien tampak kurus ?
                    <ul>
                      <li>Ya => 1</li>
                      <li>Tidak => 0</li>
                    </ul>
                </td>
                <td>
                    <input type="text" required class="form-control skorSkrining" name="nutrisi[skor][1]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['1'] }}" onblur="totalSkor()">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    2. Apakah terdapat penurunan berat badan selama satu bulan terakhir ? <br>
                    {* Untuk bayi < dari 1 tahun, apakah berat badan tidak naik selama 3 bulan terakhir ?
                    <ul>
                        <li>Ya => 1</li>
                        <li>Tidak => 0</li>
                    </ul>
                </td>
                <td>
                    <input type="text" required class="form-control skorSkrining" name="nutrisi[skor][2]" style="width: 100%" placeholder="0" value="{{ @$nutrisi['skor']['2'] }}" onblur="totalSkor()">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    3. Apakah asupan makan berkurang selama 1 minggu terakhir ?
                    <ul>
                        <li>Ya => 1</li>
                        <li>Tidak => 0</li>
                    </ul>
                </td>
                <td>
                    <input type="text" required class="form-control skorSkrining" name="nutrisi[skor][3]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['3'] }}" onblur="totalSkor()">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                  4. Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalami malnutrisi ?
                  <ul>
                      <li>Ya => 2</li>
                      <li>Tidak => 0</li>
                  </ul>
                </td>
                <td>
                  <input type="text" required class="form-control skorSkrining" name="nutrisi[skor][4]" style="width: 100%" placeholder="2" value="{{ @$nutrisi['skor']['4'] }}" onblur="totalSkor()">
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
                        Total skor 2 : Risiko malnutrisi.
                      </li>
                      <li>
                        Malnutrisi yang dimaksud dalam hal ini adalah kurang gizi.
                      </li>
                      <li>
                        Penyakit atau keadaan yang mengakibatkan pasien berisiko mengalami malnutrisi.
                        <ul style="list-style-type: none">
                          <li>- Diare kronik (Lebih dari 2 minggu)</li>
                          <li>- (tersangka) penyakit jantung bawaan</li>
                          <li>- (tersangka) infeksi HIV</li>
                          <li>- (tersangka) kanker</li>
                          <li>- Penyakit hati kronik</li>
                          <li>- Penyakit ginjal kronik</li>
                          <li>- TB Paru</li>
                          <li>- Trauma</li>
                          <li>- Luka Bakar luas</li>
                          <li>- Kelainan anatomi mulut yang mengakibatkan kelainan makan</li>
                          <li>- Retardasi mental</li>
                          <li>- Keterlambatan perkembangan</li>
                          <li>- Demam berdarah pada anak</li>
                          <li>- Lain-lain berdasarkan pertimbangan dokter</li>
                        </ul>
                      </li>
                  </ul>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="row">
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
        </div>

         <button class="btn btn-success pull-right">Simpan</button>
    </form>

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
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
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

    function totalResikoJatuhAnak1(){
      var arr = document.getElementsByClassName('resikoJatuhAnak1');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId1').value = tot;
    }
    function totalResikoJatuhAnak2(){
      var arr = document.getElementsByClassName('resikoJatuhAnak2');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId2').value = tot;
    }
    function totalResikoJatuhAnak3(){
      var arr = document.getElementsByClassName('resikoJatuhAnak3');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId3').value = tot;
    }
    function totalResikoJatuhAnak4(){
      var arr = document.getElementsByClassName('resikoJatuhAnak4');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhId4').value = tot;
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
      document.getElementById('skorResikoJatuhDewasaId1').value = tot;
    }
    function totalResikoJatuhDewasa2(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa2');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhDewasaId2').value = tot;
    }
    function totalResikoJatuhDewasa3(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa3');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhDewasaId3').value = tot;
    }
    function totalResikoJatuhDewasa4(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa4');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('skorResikoJatuhDewasaId4').value = tot;
    }
  </script>
  @endsection