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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/hemodialisis/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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

          {{-- Anamnesis --}}
          @php
            @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
            if(!@$dataPegawai){
                @$dataPegawai = 1;
            }
          @endphp

          @if (@$dataPegawai == '1')
          <div class="col-md-6">
            <input type="hidden" value="dokter" name="asesment_type">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>1. DIAGNOSIS PENYAKIT GINJAL</b></h5>
              <tr>
                <td style="width:20%;">A. ETILOGI</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[diagnosisPenyakitGinjal][etilogi]" class="form-control" id="" value="{{ @$assesment['diagnosisPenyakitGinjal']['etilogi'] }}" >
                </td>
              </tr>
              <tr>
                <td style="width:20%;">B. PENYULIT</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[diagnosisPenyakitGinjal][penyulit]" class="form-control" id="" value="{{ @$assesment['diagnosisPenyakitGinjal']['penyulit'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">C. PENYAKIT PENYERTA</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[diagnosisPenyakitGinjal][penyakit_penyerta]" class="form-control" id="" value="{{ @$assesment['diagnosisPenyakitGinjal']['penyakit_penyerta'] }}">
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>2. ANAMNESIS</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[anamnesis]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Anamnesa]" class="form-control" >{{ @$assesment['anamnesis'] }}</textarea>
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>3. PEMERIKSAAN FISIK</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Pemeriksaan Fisik]" class="form-control" >{{ @$assesment['pemeriksaan_fisik'] }}</textarea>
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>4. DATA PENUNJANG</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    1. HBs-Ag
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][hbs]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['hbs'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    2. Ureum
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][ureum]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['ureum'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    3. Natrium
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][natrium]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['natrium'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    4. Fe Serum
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][feSerum]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['feSerum'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    5. Anti HCV
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][hcv]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['hcv'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    6. Kreatinin
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][kreatinin]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['kreatinin'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    7. Kalsium
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][kalsium]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['kalsium'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    8. TIBC
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][tibc]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['tibc'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    9. Anti HIV
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][hiv]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['hiv'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    10. Asam Urat
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][asamUrat]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['asamUrat'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    11. Phosfor Anorganik
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][phosfor]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['phosfor'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    12. Sat. Transferin
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][transferin]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['transferin'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    13. Hemoglobin
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][hemoglobin]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['hemoglobin'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    14. Kalium
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][kalium]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['kalium'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    15. Gula Darah
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][gulaDarah]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['gulaDarah'] }}">
                  </td>
              </tr>
              <tr>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[dataPenunjang][16][kat]" class="form-control" id="" placeholder="16." value="{{ @$assesment['dataPenunjang']['16']['kat'] }}">
                  </td>
                  <td>
                    <input type="text" name="fisik[dataPenunjang][16][isi]" class="form-control" id="" value="{{ @$assesment['dataPenunjang']['16']['isi'] }}">
                  </td>
              </tr>
            </table>


            {{-- <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
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
                        <tr>
                <td style="width:20%;">Keluhan Utama</td>
                <td style="padding: 5px;">
                  <textarea rows="15" name="keterangan" style="display:inline-block" placeholder="[masukkan catatan medis]" class="form-control" ></textarea></td>
              </tr> 
            </table> --}}




            
            {{-- <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
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
            </table> --}}

            {{-- <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
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
                    </td>
    
                    @php
                        dd($riwayat);
                    @endphp
    
                    <td rowspan="6"  style="width:20%;">Endokrin</td>
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
                        <tr>
                        
                        @php
                            dd(json_decode(@$riwayat[0]->fisik,true)['hidung_muka_check']);
                        @endphp

                        <td  style="padding: 5px;">
                          
                          <input name="fisik[hidung_muka]" type="text" class="form-control" id="" value="" >
                        
                        </td>
                        </tr>
                  </tr>  
                    
    
    
    
    
    
    
    
    
    
                        </tr> 
            </table> --}}
                     
          </div>

          <div class="col-md-6">
            

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>5. TARGET PENGOBATAN</b></h5>
              <tr>
                  <td style="padding: 5px; width: 50%;">
                    <input type="radio" id="targetPengobatan_1" name="fisik[targetPengobatan][pilihan]" value="HD AKUT" {{@$assesment['targetPengobatan']['pilihan'] == 'HD AKUT' ? 'checked' : ''}}>
                    <label for="targetPengobatan_1" style="font-weight: normal; margin-right: 10px;">HD AKUT</label><br>
                    <input type="radio" id="targetPengobatan_2" name="fisik[targetPengobatan][pilihan]" value="HD PRE-OP" {{@$assesment['targetPengobatan']['pilihan'] == 'HD PRE-OP' ? 'checked' : ''}}>
                    <label for="targetPengobatan_2" style="font-weight: normal; margin-right: 10px;">HD PRE-OP</label><br>
                    <input type="radio" id="targetPengobatan_3" name="fisik[targetPengobatan][pilihan]" value="SLEED" {{@$assesment['targetPengobatan']['pilihan'] == 'SLEED' ? 'checked' : ''}}>
                    <label for="targetPengobatan_3" style="font-weight: normal; margin-right: 10px;">SLEED</label><br>
                    <input type="radio" id="targetPengobatan_4" name="fisik[targetPengobatan][pilihan]" value="HD RUTIN" {{@$assesment['targetPengobatan']['pilihan'] == 'HD RUTIN' ? 'checked' : ''}}>
                    <label for="targetPengobatan_4" style="font-weight: normal; margin-right: 10px;">HD RUTIN</label><br>
                  </td>
                  <td>
                    <span>Lainnya</span> <input type="text" name="fisik[targetPengobatan][lainnya]" class="form-control" id="" style="display: inline-block;" placeholder="Lainnya" value="{{ @$assesment['targetPengobatan']['lainnya'] }}">
                    <br><br>
                    <span>Frekuensi HD</span> <input type="text" name="fisik[targetPengobatan][frekuensi]" class="form-control" id="" style="display: inline-block; margin-right: 10px;" placeholder="Frekuensi HD" {{ @$assesment['targetPengobatan']['frekuensi'] }}>
                  </td>
              </tr>
              <tr>
                <td colspan="2" style="padding: 5px;">
                  <span>PENCAPAIAN ADEKUASI DIALISIS</span> <input type="text" name="fisik[targetPengobatan][adekuasi][isi]" class="form-control" id="" style="display: inline-block;" placeholder="Adekuasi" value="{{ @$assesment['targetPengobatan']['adekuasi']['isi'] }}">
                  <br>
                  <span>LAINNYA</span> <input type="text" name="fisik[targetPengobatan][adekuasi][lainnya]" class="form-control" id="" style="display: inline-block;" placeholder="Lainnya" value="{{ @$assesment['targetPengobatan']['adekuasi']['lainnya'] }}">
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>6. RESEP DIALISIS</b></h5>

              <tr>
                <td style="font-weight: bold; width: 50%;">A. JENIS DIALISAT</td>
                <td>
                  <input type="radio" id="jenisDialisat_1" name="fisik[resepDialisis][jenisDialisat][pilihan]" value="Biokarbonat" {{@$assesment['resepDialisis']['jenisDialisat']['pilihan'] == 'Biokarbonat' ? 'checked' : ''}}>
                    <label for="jenisDialisat_1" style="font-weight: normal; margin-right: 10px;">Biokarbonat</label><br>
                    <input type="radio" id="jenisDialisat_2" name="fisik[resepDialisis][jenisDialisat][pilihan]" value="Lainnya" {{@$assesment['resepDialisis']['jenisDialisat']['pilihan'] == 'Lainnya' ? 'checked' : ''}}>
                    <label for="jenisDialisat_2" style="font-weight: normal; margin-right: 10px;">Lainnya</label><br>
                    <input type="text" name="fisik[resepDialisis][jenisDialisat][lainnya]" id="" class="form-control" placeholder="Sebutkan" value="{{@$assesment['resepDialisis']['jenisDialisat']['lainnya']}}">
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold; width: 50%;">B. AKSES SIRKULASI</td>
                <td>
                  <input type="radio" id="aksesSirkulasi_1" name="fisik[resepDialisis][aksesSirkulasi][pilihan]" value="Femoral" {{@$assesment['resepDialisis']['aksesSirkulasi']['pilihan'] == 'Femoral' ? 'checked' : ''}}>
                  <label for="aksesSirkulasi_1" style="font-weight: normal; margin-right: 10px;">Femoral</label><br>
                  <input type="radio" id="aksesSirkulasi_2" name="fisik[resepDialisis][aksesSirkulasi][pilihan]" value="Cimino" {{@$assesment['resepDialisis']['aksesSirkulasi']['pilihan'] == 'Cimino' ? 'checked' : ''}}>
                  <label for="aksesSirkulasi_2" style="font-weight: normal; margin-right: 10px;">Cimino</label><br>
                  <input type="radio" id="aksesSirkulasi_3" name="fisik[resepDialisis][aksesSirkulasi][pilihan]" value="Double Lumen Catheter" {{@$assesment['resepDialisis']['aksesSirkulasi']['pilihan'] == 'Double Lumen Catheter' ? 'checked' : ''}}>
                  <label for="aksesSirkulasi_3" style="font-weight: normal; margin-right: 10px;">Double Lumen Catheter</label><br>
                  <input type="radio" id="aksesSirkulasi_4" name="fisik[resepDialisis][aksesSirkulasi][pilihan]" value="Subclavia" {{@$assesment['resepDialisis']['aksesSirkulasi']['pilihan'] == 'Subclavia' ? 'checked' : ''}}>
                  <label for="aksesSirkulasi_4" style="font-weight: normal; margin-right: 10px;">Subclavia</label><br>
                  <input type="radio" id="aksesSirkulasi_5" name="fisik[resepDialisis][aksesSirkulasi][pilihan]" value="Jugular" {{@$assesment['resepDialisis']['aksesSirkulasi']['pilihan'] == 'Jugular' ? 'checked' : ''}}>
                  <label for="aksesSirkulasi_5" style="font-weight: normal; margin-right: 10px;">Jugular</label><br>
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold; width: 50%;">C. DURASI HD (Td)</td>
                <td>
                  <input type="text" name="fisik[resepDialisis][durasiHD]" id="" class="form-control" placeholder="Jam" value="{{@$assesment['resepDialisis']['durasiHD']}}">
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold; width: 50%;">D. UF GOAL</td>
                <td>
                  <input type="text" name="fisik[resepDialisis][ufGoal]" id="" class="form-control" placeholder="ml" value="{{@$assesment['resepDialisis']['ufGoal']}}">
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold; width: 50%;">E. BB KERING</td>
                <td>
                  <input type="text" name="fisik[resepDialisis][bbKering]" id="" class="form-control" placeholder="Kg" value="{{@$assesment['resepDialisis']['bbKering']}}">
                </td>
              </tr>
              
              <tr>
                <td style="font-weight: bold; width: 50%;">F. KECEPATAN ALIRAN DARAH (Qb)</td>
                <td>
                  <input type="text" name="fisik[resepDialisis][aliranDarah]" id="" class="form-control" placeholder="ml/menit" value="{{@$assesment['resepDialisis']['aliranDarah']}}">
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold; width: 50%;">G. KECEPATAN ALIRAN DIALISAT (Qd)</td>
                <td>
                  <input type="text" name="fisik[resepDialisis][aliranDialisat]" id="" class="form-control" placeholder="ml/menit" value="{{@$assesment['resepDialisis']['aliranDialisat']}}">
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold; width: 50%;">H. HEPARINISASI</td>
                <td>
                  <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 15px;">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][kontinue][pilihan]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][kontinue][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['resepDialisis']['heparinisasi']['kontinue']['pilihan'] == 'true' ? 'checked' : ''}}>
                    Kontinue
                  </label>
                  <input type="text" style="width: 100px; display:inline-block" name="fisik[resepDialisis][heparinisasi][kontinue][sebutkan]" id="" class="form-control" placeholder="U/Jam" value="{{@$assesment['resepDialisis']['heparinisasi']['kontinue']['sebutkan']}}"><br><br>
                  <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 5px;">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][intermiten][pilihan]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][intermiten][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['resepDialisis']['heparinisasi']['intermiten']['pilihan'] == 'true' ? 'checked' : ''}}>
                    Intermiten
                  </label>
                  <input type="text" style="width: 100px; display:inline-block" name="fisik[resepDialisis][heparinisasi][intermiten][sebutkan]" id="" class="form-control" placeholder="U/Jam" value="{{@$assesment['resepDialisis']['heparinisasi']['intermiten']['sebutkan']}}"><br><br>
                  <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 28px;">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][lmwh][pilihan]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][lmwh][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['resepDialisis']['heparinisasi']['lmwh']['pilihan'] == 'true' ? 'checked' : ''}}>
                    LMWH
                  </label>
                  <input type="text" style="width: 100px; display:inline-block" name="fisik[resepDialisis][heparinisasi][lmwh][sebutkan]" id="" class="form-control" placeholder="IU" value="{{@$assesment['resepDialisis']['heparinisasi']['lmwh']['sebutkan']}}"><br>
                  <label class="form-check-label" for="flexCheckDefault" style="font-weight: normal; margin-right: 5px;">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][tanpaHeparin][pilihan]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[resepDialisis][heparinisasi][tanpaHeparin][pilihan]" type="checkbox" value="true" id="flexCheckDefault" {{@$assesment['resepDialisis']['heparinisasi']['tanpaHeparin']['pilihan'] == 'true' ? 'checked' : ''}}>
                    Tanpa Heparin
                  </label>
                </td>
              </tr>

              <tr>
                <td style="font-weight: bold; width: 50%;">I. PROGRAM PROFILING</td>
                <td>
                  <label for="" style="font-weight: normal;">UF</label>
                  <input type="text" style="width: 150px; display: inline-block;" name="fisik[resepDialisis][programProfiling][uf]" id="" class="form-control" placeholder="" value="{{@$assesment['resepDialisis']['programProfiling']['uf']}}"><br><br>
                  <label for="" style="font-weight: normal;">Na</label>
                  <input type="text" style="width: 150px; display: inline-block;" name="fisik[resepDialisis][programProfiling][na]" id="" class="form-control" placeholder="" value="{{@$assesment['resepDialisis']['programProfiling']['na']}}"><br><br>
                  <label for="" style="font-weight: normal;">Biocarbonat</label>
                  <input type="text" style="width: 150px; display: inline-block;" name="fisik[resepDialisis][programProfiling][biocarbonat]" id="" class="form-control" placeholder="" value="{{@$assesment['resepDialisis']['programProfiling']['biocarbonat']}}"><br>
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold; width: 50%;">J. SUHU</td>
                <td>
                  <input type="text" style="display: inline-block;" name="fisik[resepDialisis][suhu][nilai]" id="" class="form-control" placeholder="°C" value="{{@$assesment['resepDialisis']['suhu']['nilai']}}"><br>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>7. TERAPI</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[terapi]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Terapi]" class="form-control" >{{ @$assesment['terapi'] }}</textarea>
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5><b>8. CATATAN PERUBAHAN TERAPI</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[catatanPerubahanTerapi]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Catatan Perubahan Terapi]" class="form-control" >{{ @$assesment['catatanPerubahanTerapi'] }}</textarea>
                  </td>
              </tr>
            </table>
            <button class="btn btn-success">Simpan</button>
          </div>
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
              
              @if (count($riwayats_dokter) == 0)
                  <tr>
                      <td colspan="3" class="text-center">Tidak Ada Riwayat</td>
                  </tr>
              @else
                @foreach ($riwayats_dokter as $riwayat)
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ baca_poli($riwayat->registrasi->poli_id) }}
                        </td>
                      
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
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
              @endif
             
            </tbody>
          </table>
          </div>
        @else
          <div class="col-md-6">
          <form method="POST" action="{{ url('emr-soap/pemeriksaan/hemodialisis/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
            <input type="hidden" value="perawat" name="asesment_type">
            <h5 class="text-center"><b>Asesmen Keperawatan</b></h5>
            {{-- <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td style="width:25%; font-weight:bold;">Riwayat Alergi</td>
                <td>
                  <input type="radio" id="riwayat_alergi1" name="fisik[riwayat_alergi][pilihan]" value="Tidak">
                  <label for="riwayat_alergi1" style="font-weight: normal;">Tidak</label><br>
                  <input type="radio" id="riwayat_alergi2" name="fisik[riwayat_alergi][pilihan]" value="Ya">
                  <label for="riwayat_alergi2" style="font-weight: normal;">Ya</label><br>
                  <input type="text" id="riwayat_alergi3" name="fisik[riwayat_alergi][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">Keluhan Utama</td>
                <td>
                  <textarea name="fisik[keluhan_utama]" id="" rows="3" style="resize: vertical; display: inline-block;" class="form-control"></textarea>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">1. Keadaan Umum</td>
                <td>
                  <input type="radio" id="keadaan_umum1" name="fisik[keadaan_umum]" value="Tampak Tidak Sakit">
                  <label for="keadaan_umum1" style="font-weight: normal;">Tampak Tidak Sakit</label><br>
                  <input type="radio" id="keadaan_umum2" name="fisik[keadaan_umum]" value="Sakit Ringan">
                  <label for="keadaan_umum2" style="font-weight: normal;">Sakit Ringan</label><br>
                  <input type="radio" id="keadaan_umum3" name="fisik[keadaan_umum]" value="Sakit Sedang">
                  <label for="keadaan_umum3" style="font-weight: normal;">Sakit Sedang</label><br>
                  <input type="radio" id="keadaan_umum4" name="fisik[keadaan_umum]" value="Sakit Berat">
                  <label for="keadaan_umum4" style="font-weight: normal;">Sakit Berat</label><br>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">2. Kesadaran</td>
                <td>
                  <input type="radio" id="kesadaran1" name="fisik[kesadaran]" value="Composmentis">
                  <label for="kesadaran1" style="font-weight: normal;">Composmentis</label><br>
                  <input type="radio" id="kesadaran2" name="fisik[kesadaran]" value="Apatis">
                  <label for="kesadaran2" style="font-weight: normal;">Apatis</label><br>
                  <input type="radio" id="kesadaran3" name="fisik[kesadaran]" value="Somnolen">
                  <label for="kesadaran3" style="font-weight: normal;">Somnolen</label><br>
                  <input type="radio" id="kesadaran4" name="fisik[kesadaran]" value="Sopor">
                  <label for="kesadaran4" style="font-weight: normal;">Sopor</label><br>
                  <input type="radio" id="kesadaran5" name="fisik[kesadaran]" value="Coma">
                  <label for="kesadaran5" style="font-weight: normal;">Coma</label><br>
                </td>
              </tr>

              <tr>
                <td rowspan="3" style="width:25%; font-weight:bold;">3. GCS</td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="margin-right: 20px;">E</label>
                  <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control" id="">
                </td>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label" style="margin-right: 20px;">M</label>
                    <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control" id="">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label" style="margin-right: 20px;">V</label>
                      <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control" id="">
                  </td>
                </tr>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">4. Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                  <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                  <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100px;" class="form-control" id="">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                  <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100px;" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                  <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100px;" class="form-control" id="">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                  <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100px;" class="form-control" id="">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight:bold;">5. Assesmen Nyeri</td>
              </tr>
              <tr>
                <td>
                  <input type="radio" id="nyeri_1" name="fisik[nyeri][pilihan]" value="Tidak">
                  <label for="nyeri_1" style="font-weight: normal;">Tidak</label><br>
                </td>
                <td>
                  <input type="radio" id="nyeri_2" name="fisik[nyeri][pilihan]" value="Ada">
                  <label for="nyeri_2" style="font-weight: normal;">Ada (Lanjut Ke Deskripsi Nyeri)</label><br>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Provokatif</td>
                <td>
                  <input type="radio" id="provokatif_1" name="fisik[nyeri][provokatif][pilihan]" value="Bantuan">
                  <label for="provokatif_1" style="font-weight: normal;">Bantuan</label>
                  <input type="radio" id="provokatif_2" name="fisik[nyeri][provokatif][pilihan]" value="Spontan">
                  <label for="provokatif_2" style="font-weight: normal;">Spontan</label>
                  <input type="radio" id="provokatif_3" name="fisik[nyeri][provokatif][pilihan]" value="Lain-Lain">
                  <label for="provokatif_3" style="font-weight: normal;">Lain-Lain</label>
                  <input type="text" id="provokatif_4" name="fisik[nyeri][provokatif][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Quality</td>
                <td>
                  <input type="radio" id="quality_1" name="fisik[nyeri][quality][pilihan]" value="Seperti Tertusuk">
                  <label for="quality_1" style="font-weight: normal;">Seperti Tertusuk Benda Tajam/Tumpul</label><br/>
                  <input type="radio" id="quality_2" name="fisik[nyeri][quality][pilihan]" value="Berdenyut">
                  <label for="quality_2" style="font-weight: normal;">Berdenyut</label><br/>
                  <input type="radio" id="quality_3" name="fisik[nyeri][quality][pilihan]" value="Terbakar">
                  <label for="quality_3" style="font-weight: normal;">Terbakar</label><br/>
                  <input type="radio" id="quality_4" name="fisik[nyeri][quality][pilihan]" value="Teriris">
                  <label for="quality_4" style="font-weight: normal;">Teriris</label><br/>
                  <input type="radio" id="quality_5" name="fisik[nyeri][quality][pilihan]" value="Lain-Lain">
                  <label for="quality_5" style="font-weight: normal;">Lain-Lain</label><br/>
                  <input type="text" id="quality_6" name="fisik[nyeri][quality][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Region</td>
                <td>
                  <label class="form-check-label" style="font-weight: normal;">Terlokalisir di</label><br/>
                  <input type="text" name="fisik[nyeri][region][terlokalisir]" style="display:inline-block; width: 100px;" class="form-control" id=""><br/>
                  <label class="form-check-label" style="font-weight: normal;">Menyebar ke</label><br/>
                  <input type="text" name="fisik[nyeri][region][menyebar]" style="display:inline-block; width: 100px;" class="form-control" id=""><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="text-align:center; font-weight:bold;">
                  <p style="text-align: left;">- Severity</p>
                  <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 300px; height: 150px; padding-bottom: 10px;"><br/>
                  <input type="radio" id="severity_1" name="fisik[nyeri][severity][pilihan]" value="0">
                  <label for="severity_1" style="font-weight: normal;">0</label>
                  <input type="radio" id="severity_2" name="fisik[nyeri][severity][pilihan]" value="1-3" style="margin-left: 25px;">
                  <label for="severity_2" style="font-weight: normal;">1-3</label>
                  <input type="radio" id="severity_3" name="fisik[nyeri][severity][pilihan]" value="4-6"  style="margin-left: 25px;">
                  <label for="severity_3" style="font-weight: normal;">4-6</label>
                  <input type="radio" id="severity_4" name="fisik[nyeri][severity][pilihan]" value="7-9"  style="margin-left: 25px;">
                  <label for="severity_4" style="font-weight: normal;">7-9</label>
                  <input type="radio" id="severity_5" name="fisik[nyeri][severity][pilihan]" value="10" style="margin-left: 25px;">
                  <label for="severity_5" style="font-weight: normal;">10</label>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Time / Durasi (Menit)</td>
                <td>
                  <input type="number" name="fisik[nyeri][durasi]" style="display:inline-block; width: 100px;" class="form-control" id="">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Nyeri Hilang Jika</td>
                <td>
                  <input type="radio" id="nyeri_hilang_1" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Minum Obat">
                  <label for="nyeri_hilang_1" style="font-weight: normal;">Minum Obat</label><br/>
                  <input type="radio" id="nyeri_hilang_2" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Istirahat">
                  <label for="nyeri_hilang_2" style="font-weight: normal;">Istirahat</label><br/>
                  <input type="radio" id="nyeri_hilang_3" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Berubah Posisi">
                  <label for="nyeri_hilang_3" style="font-weight: normal;">Berubah Posisi</label><br/>
                  <input type="radio" id="nyeri_hilang_4" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Mendengarkan Musik">
                  <label for="nyeri_hilang_4" style="font-weight: normal;">Mendengarkan Musik</label><br/>
                  <input type="radio" id="nyeri_hilang_5" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Lain-Lain">
                  <label for="nyeri_hilang_5" style="font-weight: normal;">Lain-Lain</label><br/>
                  <input type="text" id="nyeri_hilang_6" name="fisik[nyeri][nyeri_hilang][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
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
                  <input type="number" name="fisik[risikoJatuh][jumlahSkor][angka]" style="display:inline-block; width: 100%;" class="form-control jumlahSkorResiko" id="" value="{{@$assesment['risikoJatuh']['jumlahSkor']['angka']}}" disabled>
                  <br><br>
                  <input type="text" name="fisik[risikoJatuh][jumlahSkor][hasil]" style="display:inline-block; width: 100%;" class="form-control hasilSkorResiko" id="" value="{{@$assesment['risikoJatuh']['jumlahSkor']['hasil']}}" disabled>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight:bold;">7. Fungsional</td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Alat Bantu</td>
                <td>
                  <input type="radio" id="alatBantu_1" name="fisik[fungsional][alatBantu][pilihan]" value="Ya">
                  <label for="alatBantu_1" style="font-weight: normal;">Ya</label><br/>
                  <input type="radio" id="alatBantu_2" name="fisik[fungsional][alatBantu][pilihan]" value="Tidak">
                  <label for="alatBantu_2" style="font-weight: normal;">Tidak</label><br/>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Protesa</td>
                <td>
                  <input type="radio" id="protesa_1" name="fisik[fungsional][protesa][pilihan]" value="Ya">
                  <label for="protesa_1" style="font-weight: normal;">Ya</label><br/>
                  <input type="radio" id="protesa_2" name="fisik[fungsional][protesa][pilihan]" value="Tidak">
                  <label for="protesa_2" style="font-weight: normal;">Tidak</label><br/>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Cacat Tubuh</td>
                <td>
                  <input type="radio" id="cacatTubuh_1" name="fisik[fungsional][cacatTubuh][pilihan]" value="Ya">
                  <label for="cacatTubuh_1" style="font-weight: normal;">Ya</label><br/>
                  <input type="radio" id="cacatTubuh_2" name="fisik[fungsional][cacatTubuh][pilihan]" value="Tidak">
                  <label for="cacatTubuh_2" style="font-weight: normal;">Tidak</label><br/>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Activity of Daily Living (ADL)</td>
                <td>
                  <input type="radio" id="adl_1" name="fisik[fungsional][adl][pilihan]" value="Mandiri">
                  <label for="adl_1" style="font-weight: normal;">Mandiri</label><br/>
                  <input type="radio" id="adl_2" name="fisik[fungsional][adl][pilihan]" value="Dibantu">
                  <label for="adl_2" style="font-weight: normal;">Dibantu</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight:bold;">PEMERIKSAAN FISIK</td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Pernyarafan</td>
                <td>
                  <input type="radio" id="pernyarafan_1" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Tidak ada keluhan">
                  <label for="pernyarafan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                  <input type="radio" id="pernyarafan_2" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Tremor">
                  <label for="pernyarafan_2" style="font-weight: normal;">Tremor</label><br/>
                  <input type="radio" id="pernyarafan_3" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Hemiparase">
                  <label for="pernyarafan_3" style="font-weight: normal;">Hemiparase/Hemiplegia</label><br/>
                  <input type="radio" id="pernyarafan_4" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="ROM">
                  <label for="pernyarafan_4" style="font-weight: normal;">ROM</label><br/>
                  <input type="radio" id="pernyarafan_5" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Paralise">
                  <label for="pernyarafan_5" style="font-weight: normal;">Paralise</label><br/>
                  <input type="radio" id="pernyarafan_6" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Lain-Lain">
                  <label for="pernyarafan_6" style="font-weight: normal;">Lain-Lain</label><br/>
                  <input type="text" id="pernyarafan_7" name="fisik[pemeriksaanFisik][pernyarafan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Pernapasan</td>
                <td>
                  <input type="radio" id="pernapasan_1" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Tidak ada keluhan">
                  <label for="pernapasan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                  <input type="radio" id="pernapasan_2" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Sekret">
                  <label for="pernapasan_2" style="font-weight: normal;">Sekret (+)</label><br/>
                  <input type="radio" id="pernapasan_3" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Vesikular">
                  <label for="pernapasan_3" style="font-weight: normal;">Vesikular</label><br/>
                  <input type="radio" id="pernapasan_4" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Ronchi">
                  <label for="pernapasan_4" style="font-weight: normal;">Ronchi</label><br/>
                  <input type="radio" id="pernapasan_5" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Wheezing">
                  <label for="pernapasan_5" style="font-weight: normal;">Wheezing</label><br/>
                  <input type="radio" id="pernapasan_6" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Menggunakan Otot Bantu">
                  <label for="pernapasan_6" style="font-weight: normal;">Menggunakan Otot Bantu</label><br/>
                  <input type="radio" id="pernapasan_7" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Retraksi Dada">
                  <label for="pernapasan_7" style="font-weight: normal;">Retraksi Dada / Inter Costa</label><br/>
                  <input type="radio" id="pernapasan_8" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Pernapasan Dada">
                  <label for="pernapasan_8" style="font-weight: normal;">Pernapasan Dada</label><br/>
                  <input type="radio" id="pernapasan_9" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Pernapasan Perut">
                  <label for="pernapasan_9" style="font-weight: normal;">Pernapasan Perut</label><br/>
                  <input type="radio" id="pernapasan_10" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Lain-Lain">
                  <label for="pernapasan_10" style="font-weight: normal;">Lain-Lain</label><br/>
                  <input type="text" id="pernapasan_11" name="fisik[pemeriksaanFisik][pernapasan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

            </table> --}}
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2">
                  <a href="{{url('/emr-soap/penilaian/hemodialisis/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                </td>
              </tr>
              @if (@$gambar->image != null)
              <tr>
                <td colspan="2"><b>Status Lokalis :</b> 
                  
                   
                    
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
                </td>
              </tr>
              @endif
              <tr>
                <td  style="font-weight: bold; width: 50%;">
                    1. Keluhan Utama
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keluhan_utama][pilihan][sesak_napas]"
                            {{ @$assesment['keluhan_utama']['pilihan']['sesak_napas'] == 'Sesak Napas' ? 'checked' : '' }}
                            type="checkbox" value="Sesak Napas">
                        <label class="form-check-label">Sesak Napas</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keluhan_utama][pilihan][mual_muntah]"
                            {{ @$assesment['keluhan_utama']['pilihan']['mual_muntah'] == 'Mual / Muntah' ? 'checked' : '' }}
                            type="checkbox" value="Mual / Muntah">
                        <label class="form-check-label">Mual / Muntah</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keluhan_utama][pilihan][gatal]"
                            {{ @$assesment['keluhan_utama']['pilihan']['gatal'] == 'Gatal' ? 'checked' : '' }}
                            type="checkbox" value="Gatal">
                        <label class="form-check-label">Gatal</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keluhan_utama][pilihan][lainnya]"
                            {{ @$assesment['keluhan_utama']['pilihan']['lainnya'] == 'Lainnya' ? 'checked' : '' }}
                            type="checkbox" value="Lainnya">
                        <label class="form-check-label" aria-placeholder="">Lainnya</label>
                        <input type="text" class="form-control" placeholder="Lainnya...." name="fisik[keluhan_utama][pilihan_lain]" value="{{ @$assesment['keluhan_utama']['pilihan_lain'] }}">
                    </div>
                </td>
              </tr>
              <tr>
                <td  style="">
                  Nyeri (NRS)
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keluhan_utama][nyeri][pilihan]"
                            {{ @$assesment['keluhan_utama']['nyeri']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keluhan_utama][nyeri][pilihan]"
                            {{ @$assesment['keluhan_utama']['nyeri']['pilihan'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <img src="{{ asset('Skala-nyeri-wajah.png') }}" style="width: 100%">
                        <input name="fisik[keluhan_utama][skalaNyeri]" type="range" min="0" max="10" value="{{ @$assesment['keluhan_utama']['skalaNyeri']}}" oninput="this.nextElementSibling.value = this.value">
                        <output style="text-align: center; font-weight: bold">{{ @$assesment['keluhan_utama']['skalaNyeri']}}</output>
                 </tr>
                </td>
              </tr>

              <tr>
                <td  style="font-weight: bold; width: 50%;">
                  2. Pemeriksaan Fisik
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Keadaan Umum
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][keadaan_umum][pilihan][baik]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan']['baik'] == 'Baik' ? 'checked' : '' }}
                            type="checkbox" value="Baik">
                        <label class="form-check-label">Baik</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][keadaan_umum][pilihan][sedang]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan']['sedang'] == 'Sedang' ? 'checked' : '' }}
                            type="checkbox" value="Sedang">
                        <label class="form-check-label">Sedang</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][keadaan_umum][pilihan][buruk]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan']['buruk'] == 'Buruk' ? 'checked' : '' }}
                            type="checkbox" value="Buruk">
                        <label class="form-check-label">Buruk</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][keadaan_umum][pilihan][lainnya]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan']['lainnya'] == 'Lainnya' ? 'checked' : '' }}
                            type="checkbox" value="Lainnya">
                        <label class="form-check-label" aria-placeholder="">Lainnya</label>
                        <input type="text" class="form-control" placeholder="Lainnya...." name="fisik[perawat_pemeriksaan_fisik][keadaan_umum][pilihan_lain]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan_lain'] }}">
                    </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Kesadaran
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan][compos_mentis]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan']['compos_mentis'] == 'Compos Mentis' ? 'checked' : '' }}
                            type="checkbox" value="Compos Mentis">
                        <label class="form-check-label">Compos Mentis</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan][apatis]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan']['apatis'] == 'Apatis' ? 'checked' : '' }}
                            type="checkbox" value="Apatis">
                        <label class="form-check-label">Apatis</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan][delirium]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan']['delirium'] == 'Delirium' ? 'checked' : '' }}
                            type="checkbox" value="Delirium">
                        <label class="form-check-label">Delirium</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan][somnolen]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan']['somnolen'] == 'Somnolen' ? 'checked' : '' }}
                            type="checkbox" value="Somnolen">
                        <label class="form-check-label">Somnolen</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan][sopor]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan']['sopor'] == 'Sopor' ? 'checked' : '' }}
                            type="checkbox" value="Sopor">
                        <label class="form-check-label">Sopor</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan][coma]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan']['coma'] == 'Coma' ? 'checked' : '' }}
                            type="checkbox" value="Coma">
                        <label class="form-check-label">Coma</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan][lainnya]"
                            {{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan']['lainnya'] == 'Lainnya' ? 'checked' : '' }}
                            type="checkbox" value="Lainnya">
                        <label class="form-check-label" aria-placeholder="">Lainnya</label>
                        <input type="text" class="form-control" placeholder="Lainnya...." name="fisik[perawat_pemeriksaan_fisik][kesadaran][pilihan_lain]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['kesadaran']['pilihan_lain'] }}">
                    </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Tekanan Darah
                </td>
                <td style="padding: 5px;">
                    <div style="display: flex; align-items:center; justify-content: space-between;">
                      <input style="width: 30%;" type="text" class="form-control" placeholder="...." name="fisik[perawat_pemeriksaan_fisik][tekanan_darah][sistole]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['tekanan_darah']['sistole'] }}">
                      /
                      <input style="width: 30%;" type="text" class="form-control" placeholder="...." name="fisik[perawat_pemeriksaan_fisik][tekanan_darah][diastole]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['tekanan_darah']['diastole'] }}">
                      mmHg
                    </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Suhu
                </td>
                <td style="padding: 5px;">
                    <div style="display: flex; align-items:center; justify-content: space-between;">
                      <input style="width: 80%;" type="text" class="form-control" placeholder="Suhu" name="fisik[perawat_pemeriksaan_fisik][suhu]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['suhu'] }}">
                      °C
                    </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Nadi
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][nadi][pilihan][reguler]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['nadi']['pilihan']['reguler'] == 'Reguler' ? 'checked' : '' }}
                          type="checkbox" value="Reguler">
                      <label class="form-check-label">Reguler</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][nadi][pilihan][ireguler]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['nadi']['pilihan']['ireguler'] == 'Ireguler' ? 'checked' : '' }}
                          type="checkbox" value="Ireguler">
                      <label class="form-check-label">Ireguler</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][nadi][pilihan][frek]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['nadi']['pilihan']['frek'] == 'Frek' ? 'checked' : '' }}
                          type="checkbox" value="Frek">
                      <label class="form-check-label">Frek</label>
                      <div style="display: flex; justify-content: space-between; align-items: center;">
                        <input style="width: 80%;" type="text" class="form-control" placeholder="x/mnt...." name="fisik[perawat_pemeriksaan_fisik][nadi][frek_pilihan_lain]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['nadi']['frek_pilihan_lain'] }}"> x/mnt
                      </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Respirasi
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][respirasi][pilihan][normal]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['respirasi']['pilihan']['normal'] == 'Normal' ? 'checked' : '' }}
                          type="checkbox" value="Normal">
                      <label class="form-check-label">Normal</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][respirasi][pilihan][kusmaul]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['respirasi']['pilihan']['kusmaul'] == 'Kusmul' ? 'checked' : '' }}
                          type="checkbox" value="Kusmul">
                      <label class="form-check-label">Kusmaul</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][respirasi][pilihan][dispnea]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['respirasi']['pilihan']['dispnea'] == 'Dispnea' ? 'checked' : '' }}
                          type="checkbox" value="Dispnea">
                      <label class="form-check-label">Dispnea</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][respirasi][pilihan][edema]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['respirasi']['pilihan']['edema'] == 'Edema' ? 'checked' : '' }}
                          type="checkbox" value="Edema">
                      <label class="form-check-label">Edema paru/ronchi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][respirasi][frek]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['respirasi']['frek'] == 'Frek' ? 'checked' : '' }}
                          type="checkbox" value="Frek">
                      <label class="form-check-label">Frek</label>
                      <div style="display: flex; justify-content: space-between; align-items: center;">
                        <input style="width: 80%;" type="text" class="form-control" placeholder="x/mnt...." name="fisik[perawat_pemeriksaan_fisik][respirasi][frek_detail]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['respirasi']['frek_detail'] }}"> x/mnt
                      </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Konjungtiva
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][konjungtiva][pilihan][tidak_anemis]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['konjungtiva']['pilihan']['tidak_anemis'] == 'Tidak Anemis' ? 'checked' : '' }}
                          type="checkbox" value="Tidak Anemis">
                      <label class="form-check-label">Tidak Anemis</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][konjungtiva][pilihan][anemis]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['konjungtiva']['pilihan']['anemis'] == 'Anemis' ? 'checked' : '' }}
                          type="checkbox" value="Anemis">
                      <label class="form-check-label">Anemis</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][konjungtiva][pilihan][lainnya]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['konjungtiva']['pilihan']['lainnya'] == 'Lain-lain' ? 'checked' : '' }}
                          type="checkbox" value="Lain-lain">
                      <label class="form-check-label">Lain-lain</label>
                      <div style="display: flex; justify-content: space-between; align-items: center;">
                        <input style="width: 80%;" type="text" class="form-control" placeholder="Lain-lain" name="fisik[perawat_pemeriksaan_fisik][konjungtiva][pilihan_lain]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['konjungtiva']['pilihan_lain'] }}">
                      </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Ekstremitas
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][ekstremitas][pilihan][tidak]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['ekstremitas']['pilihan']['tidak'] == 'Tidak Edema / Tidak dehidrasi' ? 'checked' : '' }}
                          type="checkbox" value="Tidak Edema / Tidak dehidrasi">
                      <label class="form-check-label">Tidak Edema / Tidak dehidrasi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][ekstremitas][pilihan][dehidrasi]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['ekstremitas']['pilihan']['dehidrasi'] == 'Dehidrasi' ? 'checked' : '' }}
                          type="checkbox" value="Dehidrasi">
                      <label class="form-check-label">Dehidrasi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][ekstremitas][pilihan][edema]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['ekstremitas']['pilihan']['edema'] == 'Edema' ? 'checked' : '' }}
                          type="checkbox" value="Edema">
                      <label class="form-check-label">Edema</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][ekstremitas][pilihan][edema_anasarka]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['ekstremitas']['pilihan']['edema_anasarka'] == 'Edema anasarka' ? 'checked' : '' }}
                          type="checkbox" value="Edema anasarka">
                      <label class="form-check-label">Edema anasarka</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][ekstremitas][pilihan][pucat]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['ekstremitas']['pilihan']['pucat'] == 'Pucat & Dingin' ? 'checked' : '' }}
                          type="checkbox" value="Pucat & Dingin">
                      <label class="form-check-label">Pucat & Dingin</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Berat Badan
                </td>
                <td style="padding: 5px;">
                  <div>
                      <label class="form-check-label">Pre HD (Kg)</label>
                      <input type="text" class="form-control" placeholder="Pre HD .... Kg" name="fisik[perawat_pemeriksaan_fisik][berat_badan][preHd]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['berat_badan']['preHd'] }}">
                  </div>
                  <div>
                      <label class="form-check-label">BB Kering (Kg)</label>
                      <input type="text" class="form-control" placeholder="BB Kering .... Kg" name="fisik[perawat_pemeriksaan_fisik][berat_badan][bb_kering]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['berat_badan']['bb_kering'] }}">
                  </div>
                  <div>
                      <label class="form-check-label">BB Post HD yang lalu (Kg)</label>
                      <input type="text" class="form-control" placeholder="BB Post HD yang lalu .... Kg" name="fisik[perawat_pemeriksaan_fisik][berat_badan][bb_post_hd_lalu]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['berat_badan']['bb_post_hd_lalu'] }}">
                  </div>
                  <div>
                      <label class="form-check-label">BB Post HD (Kg)</label>
                      <input type="text" class="form-control" placeholder="BB Post HD .... Kg" name="fisik[perawat_pemeriksaan_fisik][berat_badan][bb_post_hd]" value="{{ @$assesment['perawat_pemeriksaan_fisik']['berat_badan']['bb_post_hd'] }}">
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%;">
                  Akses Vaskular
                </td>
                <td style="padding: 5px;">
                  <div>
                    <input class="form-check-input"
                        name="fisik[perawat_pemeriksaan_fisik][akses_vaskular][pilihan][av_fistula]"
                        {{ @$assesment['perawat_pemeriksaan_fisik']['akses_vaskular']['pilihan']['av_fistula'] == 'AV-Fistula' ? 'checked' : '' }}
                        type="checkbox" value="AV-Fistula">
                      <label class="form-check-label">AV-Fistula</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][akses_vaskular][pilihan][femoral]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['akses_vaskular']['pilihan']['femoral'] == 'Femoral' ? 'checked' : '' }}
                          type="checkbox" value="Femoral">
                      <label class="form-check-label">Femoral</label>
                  </div>
                  {{-- <span>Lokasi</span>
                  <div>
                    <input class="form-check-input"
                        name="fisik[perawat_pemeriksaan_fisik][akses_vaskular][lokasi][kanan]"
                        {{ @$assesment['perawat_pemeriksaan_fisik']['akses_vaskular']['lokasi']['kanan'] == 'Kanan' ? 'checked' : '' }}
                        type="checkbox" value="Kanan">
                      <label class="form-check-label" style="font-weight: normal;">Kanan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][akses_vaskular][lokasi][kiri]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['akses_vaskular']['lokasi']['kiri'] == 'Kiri' ? 'checked' : '' }}
                          type="checkbox" value="Kiri">
                      <label class="form-check-label" style="font-weight: normal;">Kiri</label>
                  </div> --}}
                  <div>
                    <input class="form-check-input"
                        name="fisik[perawat_pemeriksaan_fisik][akses_vaskular][pilihan][hd_kateter]"
                        {{ @$assesment['perawat_pemeriksaan_fisik']['akses_vaskular']['pilihan']['hd_kateter'] == 'HD Kateter' ? 'checked' : '' }}
                        type="checkbox" value="HD Kateter">
                    <label class="form-check-label">HD Kateter</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[perawat_pemeriksaan_fisik][hd_kateter][pilihan][subcalvia]"
                        {{ @$assesment['perawat_pemeriksaan_fisik']['hd_kateter']['pilihan']['subcalvia'] == 'Subcalvia' ? 'checked' : '' }}
                        type="checkbox" value="Subcalvia">
                      <label class="form-check-label" style="font-weight: normal;">Subcalvia</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][hd_kateter][pilihan][jugular]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['hd_kateter']['pilihan']['jugular'] == 'Jugular' ? 'checked' : '' }}
                          type="checkbox" value="Jugular">
                      <label class="form-check-label" style="font-weight: normal;">Jugular</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[perawat_pemeriksaan_fisik][hd_kateter][pilihan][femoral]"
                        {{ @$assesment['perawat_pemeriksaan_fisik']['hd_kateter']['pilihan']['femoral'] == 'Femoral' ? 'checked' : '' }}
                        type="checkbox" value="Femoral">
                      <label class="form-check-label" style="font-weight: normal;">Femoral</label>
                  </div>
                  <span>Lokasi</span>
                  <div>
                    <input class="form-check-input"
                        name="fisik[perawat_pemeriksaan_fisik][hd_kateter][lokasi]"
                        {{ @$assesment['perawat_pemeriksaan_fisik']['hd_kateter']['lokasi'] == 'Kanan' ? 'checked' : '' }}
                        type="radio" value="Kanan">
                      <label class="form-check-label">Kanan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][hd_kateter][lokasi]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['hd_kateter']['lokasi'] == 'Kiri' ? 'checked' : '' }}
                          type="radio" value="Kiri">
                      <label class="form-check-label">Kiri</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="width: 50%;">
                  Risiko Jatuh Pre HD
                </td>
                <td style="padding: 5px; font-weight: bold;">
                  Kesimpulan
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][risiko_jatuh_pre_hd][pilihan]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['risiko_jatuh_pre_hd']['pilihan'] == '0-24 (tidak berisiko)' ? 'checked' : '' }}
                          type="radio" value="0-24 (tidak berisiko)">
                      <label class="form-check-label">0-24 (tidak berisiko)</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][risiko_jatuh_pre_hd][pilihan]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['risiko_jatuh_pre_hd']['pilihan'] == '> 24-45 (risiko sedang)' ? 'checked' : '' }}
                          type="radio" value="> 24-45 (risiko sedang)">
                      <label class="form-check-label">> 24-45 (risiko sedang)</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][risiko_jatuh_pre_hd][pilihan]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['risiko_jatuh_pre_hd']['pilihan'] == '>45 (risiko tinggi)' ? 'checked' : '' }}
                          type="radio" value=">45 (risiko tinggi)">
                      <label class="form-check-label">>45 (risiko tinggi)</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="width: 50%;">
                  Risiko Jatuh Post HD
                </td>
                <td style="padding: 5px; font-weight: bold;">
                  Kesimpulan
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][risiko_jatuh_post_hd][pilihan]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['risiko_jatuh_post_hd']['pilihan'] == '0-24 (tidak berisiko)' ? 'checked' : '' }}
                          type="radio" value="0-24 (tidak berisiko)">
                      <label class="form-check-label">0-24 (tidak berisiko)</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][risiko_jatuh_post_hd][pilihan]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['risiko_jatuh_post_hd']['pilihan'] == '> 24-45 (risiko sedang)' ? 'checked' : '' }}
                          type="radio" value="> 24-45 (risiko sedang)">
                      <label class="form-check-label">> 24-45 (risiko sedang)</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perawat_pemeriksaan_fisik][risiko_jatuh_post_hd][pilihan]"
                          {{ @$assesment['perawat_pemeriksaan_fisik']['risiko_jatuh_post_hd']['pilihan'] == '>45 (risiko tinggi)' ? 'checked' : '' }}
                          type="radio" value=">45 (risiko tinggi)">
                      <label class="form-check-label">>45 (risiko tinggi)</label>
                  </div>
                </td>
              </tr>

              <tr>
                <td  style="font-weight: bold; width: 50%;">
                  3. Pemeriksaan Penunjang (Lab, Rx, lain-lain)
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="3">
                  <textarea rows="5" name="fisik[pemeriksaan_penunjang][detail]" style="display:inline-block" placeholder="[masukkan pemeriksaan penunjang]" class="form-control" >{{ @$assesment['pemeriksaan_penunjang']['detail'] }}</textarea>
                </td>
              </tr>
            </table>
          </div>

          {{-- <div class="col-md-6">
            <h5><b>Asesmen</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td style="width:25%; font-weight:500;">Kardiovaskuler</td>
                <td style="text-align: center;">
                  <input type="radio" id="kardiovaskuler_1" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Tidak ada keluhan">
                  <label for="kardiovaskuler_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="kardiovaskuler_2" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Oedema">
                  <label for="kardiovaskuler_2" style="font-weight: normal; margin-right: 10px;">Oedema</label>
                  <input type="radio" id="kardiovaskuler_3" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Murmur">
                  <label for="kardiovaskuler_3" style="font-weight: normal; margin-right: 10px;">Murmur</label><br/>
                  <input type="radio" id="kardiovaskuler_4" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Chest Pain">
                  <label for="kardiovaskuler_4" style="font-weight: normal; margin-right: 10px;">Chest Pain</label>
                  <input type="radio" id="kardiovaskuler_5" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Reguler">
                  <label for="kardiovaskuler_5" style="font-weight: normal; margin-right: 10px;">Reguler</label>
                  <input type="radio" id="kardiovaskuler_6" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Ireguler">
                  <label for="kardiovaskuler_6" style="font-weight: normal; margin-right: 10px;">Ireguler</label><br/>
                  <input type="radio" id="kardiovaskuler_7" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Gallop">
                  <label for="kardiovaskuler_7" style="font-weight: normal; margin-right: 10px;">Gallop</label>
                  <input type="radio" id="kardiovaskuler_8" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="CRT < 2">
                  <label for="kardiovaskuler_8" style="font-weight: normal; margin-right: 10px;">CRT < 2</label>
                  <input type="radio" id="kardiovaskuler_9" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="CRT > 2">
                  <label for="kardiovaskuler_9" style="font-weight: normal; margin-right: 10px;">CRT > 2</label><br/>
                  <input type="radio" id="kardiovaskuler_10" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Lain-Lain">
                  <label for="kardiovaskuler_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="kardiovaskuler_11" name="fisik[pemeriksaanFisik][kardiovaskuler][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Pencernaan</td>
                <td style="text-align: center;">
                  <input type="radio" id="pencernaan_1" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Tidak ada keluhan">
                  <label for="pencernaan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="pencernaan_2" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="konstipasi">
                  <label for="pencernaan_2" style="font-weight: normal; margin-right: 10px;">konstipasi</label>
                  <input type="radio" id="pencernaan_3" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Diare">
                  <label for="pencernaan_3" style="font-weight: normal; margin-right: 10px;">Diare</label><br/>
                  <input type="radio" id="pencernaan_4" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Mual">
                  <label for="pencernaan_4" style="font-weight: normal; margin-right: 10px;">Mual / Muntah</label>
                  <input type="radio" id="pencernaan_5" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Anoreksia">
                  <label for="pencernaan_5" style="font-weight: normal; margin-right: 10px;">Anoreksia</label><br/>
                  <input type="radio" id="pencernaan_6" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Lain-Lain">
                  <label for="pencernaan_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="pencernaan_7" name="fisik[pemeriksaanFisik][pencernaan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Endokrin</td>
                <td style="text-align: center;">
                  <input type="radio" id="endokrin_1" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Tidak ada keluhan">
                  <label for="endokrin_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="endokrin_2" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Pembesaran Kelenjar">
                  <label for="endokrin_2" style="font-weight: normal; margin-right: 10px;">Pembesaran Kelenjar</label><br/>
                  <input type="radio" id="endokrin_3" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Tiroid">
                  <label for="endokrin_3" style="font-weight: normal; margin-right: 10px;">Tiroid</label>
                  <input type="radio" id="endokrin_4" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Keringat">
                  <label for="endokrin_4" style="font-weight: normal; margin-right: 10px;">Keringat Banyak</label>
                  <input type="radio" id="endokrin_5" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Napas Bau">
                  <label for="endokrin_5" style="font-weight: normal; margin-right: 10px;">Napas Bau</label><br/>
                  <input type="radio" id="endokrin_6" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Lain-Lain">
                  <label for="endokrin_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="endokrin_7" name="fisik[pemeriksaanFisik][endokrin][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Reproduksi</td>
                <td style="text-align: center;">
                  <input type="radio" id="reproduksi_1" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Tidak ada keluhan">
                  <label for="reproduksi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="reproduksi_2" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Keputihan">
                  <label for="reproduksi_2" style="font-weight: normal; margin-right: 10px;">Keputihan</label><br/>
                  <input type="radio" id="reproduksi_3" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Haid Tidak Teratur">
                  <label for="reproduksi_3" style="font-weight: normal; margin-right: 10px;">Haid Tidak Teratur</label>
                  <input type="radio" id="reproduksi_4" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Tidak Haid">
                  <label for="reproduksi_4" style="font-weight: normal; margin-right: 10px;">Tidak Haid</label><br/>
                  <input type="radio" id="reproduksi_5" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Lain-Lain">
                  <label for="reproduksi_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="reproduksi_6" name="fisik[pemeriksaanFisik][reproduksi][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Abdomen</td>
                <td style="text-align: center;">
                  <input type="radio" id="abdomen_1" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Tidak ada keluhan">
                  <label for="abdomen_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="abdomen_2" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Membesar">
                  <label for="abdomen_2" style="font-weight: normal; margin-right: 10px;">Membesar</label>
                  <input type="radio" id="abdomen_3" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Distensi">
                  <label for="abdomen_3" style="font-weight: normal; margin-right: 10px;">Distensi</label><br/>
                  <input type="radio" id="abdomen_4" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Nyeri Tekan">
                  <label for="abdomen_4" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                  <input type="radio" id="abdomen_5" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Luka">
                  <label for="abdomen_5" style="font-weight: normal; margin-right: 10px;">Luka</label>
                  <input type="radio" id="abdomen_6" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L I">
                  <label for="abdomen_6" style="font-weight: normal; margin-right: 10px;">L I</label>
                  <input type="radio" id="abdomen_7" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L II">
                  <label for="abdomen_7" style="font-weight: normal; margin-right: 10px;">L II</label><br/>
                  <input type="radio" id="abdomen_8" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L III">
                  <label for="abdomen_8" style="font-weight: normal; margin-right: 10px;">L III</label>
                  <input type="radio" id="abdomen_9" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L IV">
                  <label for="abdomen_9" style="font-weight: normal; margin-right: 10px;">L IV</label><br/>
                  <input type="radio" id="abdomen_10" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Lain-Lain">
                  <label for="abdomen_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="abdomen_11" name="fisik[pemeriksaanFisik][abdomen][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Kulit</td>
                <td style="text-align: center;">
                  <input type="radio" id="kulit_1" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Tidak ada keluhan">
                  <label for="kulit_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="kulit_2" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Turgor">
                  <label for="kulit_2" style="font-weight: normal; margin-right: 10px;">Turgor Tidak Baik</label><br/>
                  <input type="radio" id="kulit_3" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Perubahan Warna">
                  <label for="kulit_3" style="font-weight: normal; margin-right: 10px;">Perubahan Warna</label>
                  <input type="radio" id="kulit_4" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Terdapat Lecet">
                  <label for="kulit_4" style="font-weight: normal; margin-right: 10px;">Terdapat Lecet</label><br/>
                  <input type="radio" id="kulit_5" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Terdapat Luka">
                  <label for="kulit_5" style="font-weight: normal; margin-right: 10px;">Terdapat Luka</label><br/>
                  <input type="radio" id="kulit_6" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Lain-Lain">
                  <label for="kulit_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="kulit_7" name="fisik[pemeriksaanFisik][kulit][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Mata</td>
                <td style="text-align: center;">
                  <input type="radio" id="mata_1" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Tidak ada keluhan">
                  <label for="mata_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="mata_2" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Kuning">
                  <label for="mata_2" style="font-weight: normal; margin-right: 10px;">Kuning</label>
                  <input type="radio" id="mata_3" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Pucat">
                  <label for="mata_3" style="font-weight: normal; margin-right: 10px;">Pucat</label><br/>
                  <input type="radio" id="mata_4" name="fisik[pemeriksaanFisik][mata][pilihan]" value="VOD">
                  <label for="mata_4" style="font-weight: normal; margin-right: 10px;">VOD (Visus Ocula Dektra)</label>
                  <input type="radio" id="mata_5" name="fisik[pemeriksaanFisik][mata][pilihan]" value="VOS">
                  <label for="mata_5" style="font-weight: normal; margin-right: 10px;">VOS (Visus Okula Sinistra)</label><br/>
                  <input type="radio" id="mata_6" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Lain-Lain">
                  <label for="mata_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="mata_7" name="fisik[pemeriksaanFisik][mata][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Genetalia</td>
                <td style="text-align: center;">
                  <input type="radio" id="genetalia_1" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Tidak ada keluhan">
                  <label for="genetalia_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="genetalia_2" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Nyeri Tekan">
                  <label for="genetalia_2" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                  <input type="radio" id="genetalia_3" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Benjolan">
                  <label for="genetalia_3" style="font-weight: normal; margin-right: 10px;">Benjolan</label><br/>
                  <input type="radio" id="genetalia_4" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Hipospsdia">
                  <label for="genetalia_4" style="font-weight: normal; margin-right: 10px;">Hipospsdia</label>
                  <input type="radio" id="genetalia_5" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Epispadia">
                  <label for="genetalia_5" style="font-weight: normal; margin-right: 10px;">Epispadia</label>
                  <input type="radio" id="genetalia_6" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Hidrochele">
                  <label for="genetalia_6" style="font-weight: normal; margin-right: 10px;">Hidrochele</label>
                  <input type="radio" id="genetalia_7" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Lesi">
                  <label for="genetalia_7" style="font-weight: normal; margin-right: 10px;">Lesi</label><br/>
                  <input type="radio" id="genetalia_8" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Eritema">
                  <label for="genetalia_8" style="font-weight: normal; margin-right: 10px;">Eritema</label>
                  <input type="radio" id="genetalia_9" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Peradangan">
                  <label for="genetalia_9" style="font-weight: normal; margin-right: 10px;">Peradangan</label><br/>
                  <input type="radio" id="genetalia_10" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Lain-Lain">
                  <label for="genetalia_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="genetalia_11" name="fisik[pemeriksaanFisik][genetalia][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Ektremitas Atas</td>
                <td style="text-align: center;">
                  <input type="radio" id="ektremitasAtas_1" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Tidak ada keluhan">
                  <label for="ektremitasAtas_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="ektremitasAtas_2" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Gerakan Terbatas">
                  <label for="ektremitasAtas_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                  <input type="radio" id="ektremitasAtas_3" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Nyeri">
                  <label for="ektremitasAtas_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                  <input type="radio" id="ektremitasAtas_4" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Lain-Lain">
                  <label for="ektremitasAtas_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="ektremitasAtas_5" name="fisik[pemeriksaanFisik][ektremitasAtas][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Ektremitas Bawah</td>
                <td style="text-align: center;">
                  <input type="radio" id="ektremitasBawah_1" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Tidak ada keluhan">
                  <label for="ektremitasBawah_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="ektremitasBawah_2" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Gerakan Terbatas">
                  <label for="ektremitasBawah_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                  <input type="radio" id="ektremitasBawah_3" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Nyeri">
                  <label for="ektremitasBawah_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                  <input type="radio" id="ektremitasBawah_4" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Lain-Lain">
                  <label for="ektremitasBawah_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="ektremitasBawah_5" name="fisik[pemeriksaanFisik][ektremitasBawah][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Muka / Wajah</td>
                <td style="text-align: center;">
                  <input type="radio" id="muka_1" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Tidak ada keluhan">
                  <label for="muka_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="muka_2" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Lain-Lain">
                  <label for="muka_2" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="muka_3" name="fisik[pemeriksaanFisik][muka][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Telinga</td>
                <td style="text-align: center;">
                  <input type="radio" id="telinga_1" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Tidak ada keluhan">
                  <label for="telinga_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="telinga_2" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Tidak Simetris">
                  <label for="telinga_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                  <input type="radio" id="telinga_3" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Cerumen">
                  <label for="telinga_3" style="font-weight: normal; margin-right: 10px;">Cerumen</label><br/>
                  <input type="radio" id="telinga_4" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Lain-Lain">
                  <label for="telinga_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="telinga_5" name="fisik[pemeriksaanFisik][telinga][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Hidung</td>
                <td style="text-align: center;">
                  <input type="radio" id="hidung_1" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Tidak ada keluhan">
                  <label for="hidung_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="hidung_2" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Tidak Simetris">
                  <label for="hidung_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                  <input type="radio" id="hidung_3" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Sekret">
                  <label for="hidung_3" style="font-weight: normal; margin-right: 10px;">Sekret</label>
                  <input type="radio" id="hidung_4" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Cuping">
                  <label for="hidung_4" style="font-weight: normal; margin-right: 10px;">Pernafasan Cuping Hidung</label><br/>
                  <input type="radio" id="hidung_5" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Lain-Lain">
                  <label for="hidung_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="hidung_6" name="fisik[pemeriksaanFisik][hidung][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Tenggorokan</td>
                <td style="text-align: center;">
                  <input type="radio" id="tenggorokan_1" name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Tidak ada keluhan">
                  <label for="tenggorokan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  <input type="radio" id="tenggorokan_2" name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Tonsil Ada Keluhan">
                  <label for="tenggorokan_2" style="font-weight: normal; margin-right: 10px;">Tonsil Ada Keluhan</label><br/>
                  <input type="radio" id="tenggorokan_3" name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Lain-Lain">
                  <label for="tenggorokan_3" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  <input type="text" id="tenggorokan_4" name="fisik[pemeriksaanFisik][tenggorokan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Keadaan Emosional</td>
                <td style="text-align: center;">
                  <input type="radio" id="keadaanEmosional_1" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Kooperatif">
                  <label for="keadaanEmosional_1" style="font-weight: normal; margin-right: 10px;">Kooperatif</label>
                  <input type="radio" id="keadaanEmosional_2" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Butuh Pertolongan">
                  <label for="keadaanEmosional_2" style="font-weight: normal; margin-right: 10px;">Butuh Pertolongan</label>
                  <input type="radio" id="keadaanEmosional_3" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Ingin Tahu">
                  <label for="keadaanEmosional_3" style="font-weight: normal; margin-right: 10px;">Ingin Tahu</label>
                  <input type="radio" id="keadaanEmosional_4" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Bingung">
                  <label for="keadaanEmosional_4" style="font-weight: normal; margin-right: 10px;">Bingung</label>
                </td>
              </tr>
              
              <tr>
                <td style="width:25%; font-weight:500;">Kebutuhan Edukasi dan Pengajaran</td>
                <td style="text-align: center;">
                  <input type="radio" id="keadaanEmosional_1" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Pasien">
                  <label for="keadaanEmosional_1" style="font-weight: normal; margin-right: 10px;">Pasien</label>
                  <input type="radio" id="keadaanEmosional_2" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Orang Tua">
                  <label for="keadaanEmosional_2" style="font-weight: normal; margin-right: 10px;">Orang Tua</label>
                  <input type="radio" id="keadaanEmosional_3" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Anak">
                  <label for="keadaanEmosional_3" style="font-weight: normal; margin-right: 10px;">Anak</label><br/>
                  <input type="radio" id="keadaanEmosional_4" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Suami">
                  <label for="keadaanEmosional_4" style="font-weight: normal; margin-right: 10px;">Suami</label>
                  <input type="radio" id="keadaanEmosional_5" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Istri">
                  <label for="keadaanEmosional_5" style="font-weight: normal; margin-right: 10px;">Istri</label>
                  <input type="radio" id="keadaanEmosional_6" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Keluarga Lainnya">
                  <label for="keadaanEmosional_6" style="font-weight: normal; margin-right: 10px;">Keluarga Lainnya</label>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Bicara</td>
                <td style="text-align: center;">
                  <input type="radio" id="bicara_1" name="fisik[pemeriksaanFisik][bicara][pilihan]" value="Normal">
                  <label for="bicara_1" style="font-weight: normal; margin-right: 10px;">Normal</label>
                  <input type="radio" id="bicara_2" name="fisik[pemeriksaanFisik][bicara][pilihan]" value="Gangguan Bicara">
                  <label for="bicara_2" style="font-weight: normal; margin-right: 10px;">Gangguan Bicara</label>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Bahasa Sehari-Hari</td>
                <td style="text-align: center;">
                  <input type="radio" id="bahasa_1" name="fisik[pemeriksaanFisik][bahasa][pilihan]" value="Indonesia">
                  <label for="bahasa_1" style="font-weight: normal; margin-right: 10px;">Indonesia</label>
                  <input type="radio" id="bahasa_2" name="fisik[pemeriksaanFisik][bahasa][pilihan]" value="Daerah">
                  <label for="bahasa_2" style="font-weight: normal; margin-right: 10px;">Daerah</label>
                  <input type="radio" id="bahasa_3" name="fisik[pemeriksaanFisik][bahasa][pilihan]" value="Inggris dan Lainnya">
                  <label for="bahasa_3" style="font-weight: normal; margin-right: 10px;">Inggris dan Lainnya</label><br/>
                </td>
              </tr>     
              
              <tr>
                <td style="width:25%; font-weight:500;">Perlu Penerjemah</td>
                <td style="text-align: center;">
                  <input type="radio" id="penerjemah_1" name="fisik[pemeriksaanFisik][penerjemah][pilihan]" value="Perlu Penerjemah">
                  <label for="penerjemah_1" style="font-weight: normal; margin-right: 10px;">Perlu Penerjemah</label>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Hambatan Edukasi</td>
                <td style="text-align: center;">
                  <input type="radio" id="hambatanEdukasi_1" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Bahasa">
                  <label for="hambatanEdukasi_1" style="font-weight: normal; margin-right: 10px;">Bahasa</label>
                  <input type="radio" id="hambatanEdukasi_2" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Pendengaran">
                  <label for="hambatanEdukasi_2" style="font-weight: normal; margin-right: 10px;">Pendengaran</label>
                  <input type="radio" id="hambatanEdukasi_3" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Hilang Memori">
                  <label for="hambatanEdukasi_3" style="font-weight: normal; margin-right: 10px;">Hilang Memori</label><br/>
                  <input type="radio" id="hambatanEdukasi_4" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Motivasi Buruk">
                  <label for="hambatanEdukasi_4" style="font-weight: normal; margin-right: 10px;">Motivasi Buruk</label>
                  <input type="radio" id="hambatanEdukasi_5" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Cemas">
                  <label for="hambatanEdukasi_5" style="font-weight: normal; margin-right: 10px;">Cemas</label><br/>
                  <input type="radio" id="hambatanEdukasi_6" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Masalah Penglihatan">
                  <label for="hambatanEdukasi_6" style="font-weight: normal; margin-right: 10px;">Masalah Penglihatan</label>
                  <input type="radio" id="hambatanEdukasi_7" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Tidak ditemukan Hambatan">
                  <label for="hambatanEdukasi_7" style="font-weight: normal; margin-right: 10px;">Tidak ditemukan Hambatan</label>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:500;">Edukasi yang diberikan</td>
                <td style="text-align: center;">
                  <input type="radio" id="edukasi_1" name="fisik[pemeriksaanFisik][edukasi][pilihan]" value="Proses Penyakit">
                  <label for="edukasi_1" style="font-weight: normal; margin-right: 10px;">Proses Penyakit</label>
                  <input type="radio" id="edukasi_2" name="fisik[pemeriksaanFisik][edukasi][pilihan]" value="Pengobatan">
                  <label for="edukasi_2" style="font-weight: normal; margin-right: 10px;">Pengobatan</label>
                  <input type="radio" id="edukasi_3" name="fisik[pemeriksaanFisik][edukasi][pilihan]" value="Nutrisi">
                  <label for="edukasi_3" style="font-weight: normal; margin-right: 10px;">Nutrisi</label><br/>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Status Gizi</td>
                <td><input type="text" id="statusGizi" name="fisik[pemeriksaanFisik][statusGizi]" style="display:inline-block;" class="form-control" placeholder=""></td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Status Pediatrik</td>
                <td><input type="text" id="statusPediatrik" name="fisik[pemeriksaanFisik][statusPediatrik]" style="display:inline-block;" class="form-control" placeholder=""></td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Riwayat Imunisasi</td>
                <td><input type="text" id="riwayatImunisasi" name="fisik[pemeriksaanFisik][riwayatImunisasi]" style="display:inline-block;" class="form-control" placeholder=""></td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">Riwayat Tumbuh Kembang</td>
                <td><input type="text" id="riwayatTumbuh" name="fisik[pemeriksaanFisik][riwayatTumbuh]" style="display:inline-block;" class="form-control" placeholder=""></td>
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
                  <input type="text" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
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
            </table>

            <div style="text-align: right;">
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
          </div> --}}
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              
              <tr>
                <td  style="font-weight: bold; width: 50%;">
                  4. GIZI (Dikaji tiap 3 bulan sekali atau diulangi jika dianggap terjadi perburukan asupan gizi)
                </td>
              </tr>
              <tr>
                <td style="width: 50%;">
                  Tanggal
                </td>
                <td>
                  <input type="date" class="form-control" placeholder="Tanggal" name="fisik[gizi][tanggal]" value="{{ @$assesment['gizi']['tanggal'] }}">
                </td>
              </tr>
              <tr>
                <td style="width: 50%;">
                  MIS, Score total
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Score total" name="fisik[gizi][mis_score]" value="{{ @$assesment['gizi']['mis_score'] }}">
                </td>
              </tr>
              <tr>
                <td style="width: 50%;">
                  Kesimpulan
                </td>
                <td style="padding: 5px; font-weight: bold;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[gizi][kesimpulan][pilihan]"
                          {{ @$assesment['gizi']['kesimpulan']['pilihan'] == 'Tanpa malnutrisi (<6)' ? 'checked' : '' }}
                          type="radio" value="Tanpa malnutrisi (<6)">
                      <label class="form-check-label">Tanpa malnutrisi (<6)</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[gizi][kesimpulan][pilihan]"
                          {{ @$assesment['gizi']['kesimpulan']['pilihan'] == 'Malnutrisi (>6)' ? 'checked' : '' }}
                          type="radio" value="Malnutrisi (>6)">
                      <label class="form-check-label">Malnutrisi (>6)</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="width: 50%;">
                  Rekomendasi
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Rekomendasi" name="fisik[gizi][rekomendasi]" value="{{ @$assesment['gizi']['rekomendasi'] }}">
                </td>
              </tr>

              <tr>
                <td  style="font-weight: bold; width: 50%;">
                  5.Riwayat Psikososial
                </td>
              </tr>

              <tr>
                <td  style="width: 50%;">
                  Adakah keyakinan / tradisi / budaya yang berkaitan dengan pelayanan kesehatan yang diberikan
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][keyakinan_tradisi][pilihan]"
                          {{ @$assesment['riwayat_psikososial']['keyakinan_tradisi']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                          type="radio" value="Tidak">
                      <label class="form-check-label">Tidak</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][keyakinan_tradisi][pilihan]"
                          {{ @$assesment['riwayat_psikososial']['keyakinan_tradisi']['pilihan'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label">Ya</label>
                      <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[riwayat_psikososial][keyakinan_tradisi][pilihan_ya]" value="{{ @$assesment['riwayat_psikososial']['keyakinan_tradisi']['pilihan_ya'] }}">
                  </div>
                </td>
              </tr>

              <tr>
                <td  style="width: 50%;">
                  Kendala komunikasi
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][kendala_komunikasi][pilihan]"
                          {{ @$assesment['riwayat_psikososial']['kendala_komunikasi']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                          type="radio" value="Tidak">
                      <label class="form-check-label">Tidak ada</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][kendala_komunikasi][pilihan]"
                          {{ @$assesment['riwayat_psikososial']['kendala_komunikasi']['pilihan'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label">Ya</label>
                      <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[riwayat_psikososial][kendala_komunikasi][pilihan_ya]" value="{{ @$assesment['riwayat_psikososial']['keyakinan_tradisi']['pilihan_ya'] }}">
                  </div>
                </td>
              </tr>

              <tr>
                <td  style="width: 50%;">
                  Yang merawat di rumah
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][perawat_dirumah][pilihan]"
                          {{ @$assesment['riwayat_psikososial']['perawat_dirumah']['pilihan'] == 'Tidak ada' ? 'checked' : '' }}
                          type="radio" value="Tidak ada">
                      <label class="form-check-label">Tidak ada</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][perawat_dirumah][pilihan]"
                          {{ @$assesment['riwayat_psikososial']['perawat_dirumah']['pilihan'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label">Ya</label>
                      <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[riwayat_psikososial][perawat_dirumah][pilihan_ya]" value="{{ @$assesment['riwayat_psikososial']['perawat_dirumah']['pilihan_ya'] }}">
                  </div>
                </td>
              </tr>

              <tr>
                <td  style="width: 50%;">
                  Kondisi saat ini
                </td>
                <td style="padding: 5px;">
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][kondisi_saat_ini][pilihan][tenang]"
                          {{ @$assesment['riwayat_psikososial']['kondisi_saat_ini']['pilihan']['tenang'] == 'Tenang' ? 'checked' : '' }}
                          type="checkbox" value="Tenang">
                      <label class="form-check-label">Tenang</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][kondisi_saat_ini][pilihan][gelisah]"
                          {{ @$assesment['riwayat_psikososial']['kondisi_saat_ini']['pilihan']['gelisah'] == 'Gelisah' ? 'checked' : '' }}
                          type="checkbox" value="Gelisah">
                      <label class="form-check-label">Gelisah</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][kondisi_saat_ini][pilihan][takut]"
                          {{ @$assesment['riwayat_psikososial']['kondisi_saat_ini']['pilihan']['takut'] == 'Takut terhadap tindakan' ? 'checked' : '' }}
                          type="checkbox" value="Takut terhadap tindakan">
                      <label class="form-check-label">Takut terhadap tindakan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][kondisi_saat_ini][pilihan][marah]"
                          {{ @$assesment['riwayat_psikososial']['kondisi_saat_ini']['pilihan']['marah'] == 'Marah' ? 'checked' : '' }}
                          type="checkbox" value="Marah">
                      <label class="form-check-label">Marah</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_psikososial][kondisi_saat_ini][pilihan][mudah_tersinggung]"
                          {{ @$assesment['riwayat_psikososial']['kondisi_saat_ini']['pilihan']['mudah_tersinggung'] == 'Mudah Tersinggung' ? 'checked' : '' }}
                          type="checkbox" value="Mudah Tersinggung">
                      <label class="form-check-label">Mudah Tersinggung</label>
                  </div>
                </td>
              </tr>
            </table>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5 class="text-center"><b>Diagnosa Keperawatan (Dx.....)</b></h5>
              <tr>
                <td>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan1]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan1'] == '1. Kelebihan volume cairan' ? 'checked' : '' }}
                          type="checkbox" value="1. Kelebihan volume cairan">
                      <label class="form-check-label" style="font-weight: 400;">1. Kelebihan volume cairan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan2]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan2'] == '2. Gangguan perfusi jaringan' ? 'checked' : '' }}
                          type="checkbox" value="2. Gangguan perfusi jaringan">
                      <label class="form-check-label" style="font-weight: 400;">2. Gangguan perfusi jaringan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan3]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan3'] == '3. Gangguan keseimbangan cairan' ? 'checked' : '' }}
                          type="checkbox" value="3. Gangguan keseimbangan cairan">
                      <label class="form-check-label" style="font-weight: 400;">3. Gangguan keseimbangan cairan</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan4]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan4'] == '4. Penurunan curah jantung' ? 'checked' : '' }}
                          type="checkbox" value="4. Penurunan curah jantung">
                      <label class="form-check-label" style="font-weight: 400;">4. Penurunan curah jantung</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan5]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan5'] == '5. Nutrisi kurang dari kebutuhan tubuh' ? 'checked' : '' }}
                          type="checkbox" value="5. Nutrisi kurang dari kebutuhan tubuh">
                      <label class="form-check-label" style="font-weight: 400;">5. Nutrisi kurang dari kebutuhan tubuh</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan6]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan6'] == '6. Ketidakpatuhan terhadap diit' ? 'checked' : '' }}
                          type="checkbox" value="6. Ketidakpatuhan terhadap diit">
                      <label class="form-check-label" style="font-weight: 400;">6. Ketidakpatuhan terhadap diit</label>
                  </div>
                </td>
                <td>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan7]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan7'] == '7. Gangguan rasa nyaman' ? 'checked' : '' }}
                          type="checkbox" value="7. Gangguan rasa nyaman">
                      <label class="form-check-label" style="font-weight: 400;">7. Gangguan rasa nyaman</label>
                      <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[diagnosa_keperawatan_dx][pilihan7_detail]" value="{{ @$assesment['diagnosa_keperawatan_dx']['pilihan7_detail'] }}">
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan8]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan8'] == 'Lain-lain' ? 'checked' : '' }}
                          type="checkbox" value="Lain-lain">
                      <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                      <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[diagnosa_keperawatan_dx][pilihan8_detail]" value="{{ @$assesment['diagnosa_keperawatan_dx']['pilihan8_detail'] }}">
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[diagnosa_keperawatan_dx][pilihan9]"
                          {{ @$assesment['diagnosa_keperawatan_dx']['pilihan9'] == 'Lain-lain' ? 'checked' : '' }}
                          type="checkbox" value="Lain-lain">
                      <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                      <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[diagnosa_keperawatan_dx][pilihan9_detail]" value="{{ @$assesment['diagnosa_keperawatan_dx']['pilihan9_detail'] }}">
                  </div>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5 class="text-center"><b>Intervensi Keperawatan (Rekapitulasi pre-intra dan post HD)</b></h5>
              <tr>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan1]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan1'] == 'Monitor berat badan, inatake out put, Atur posisi pasien agar ventilasi adekuat' ? 'checked' : '' }}
                        type="checkbox" value="Monitor berat badan, inatake out put, Atur posisi pasien agar ventilasi adekuat">
                    <label class="form-check-label" style="font-weight: 400;">Monitor berat badan, inatake out put, Atur posisi pasien agar ventilasi adekuat</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan2]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan2'] == 'Observasi pasien (Monitor vital sign) dan mesin' ? 'checked' : '' }}
                        type="checkbox" value="Observasi pasien (Monitor vital sign) dan mesin">
                    <label class="form-check-label" style="font-weight: 400;">Observasi pasien (Monitor vital sign) dan mesin</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan3]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan3'] == 'Kaji kemampuan pasien mendapatkan nutrisi yang dibutuhkan' ? 'checked' : '' }}
                        type="checkbox" value="Kaji kemampuan pasien mendapatkan nutrisi yang dibutuhkan">
                    <label class="form-check-label" style="font-weight: 400;">Kaji kemampuan pasien mendapatkan nutrisi yang dibutuhkan</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan4]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan4'] == 'PENKES, diet, AV-Shunt' ? 'checked' : '' }}
                        type="checkbox" value="PENKES, diet, AV-Shunt">
                    <label class="form-check-label" style="font-weight: 400;">PENKES, diet, AV-Shunt</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan5]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan5'] == 'Ganti balutan luka sesuai dengan prosedur' ? 'checked' : '' }}
                        type="checkbox" value="Ganti balutan luka sesuai dengan prosedur">
                    <label class="form-check-label" style="font-weight: 400;">Ganti balutan luka sesuai dengan prosedur</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan6]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan6'] == 'Bila pasien mulai hipotensi (mual, muntah, keringat dingin, pusing kram, hipoglikemi berikan cairan sesuai SPO)' ? 'checked' : '' }}
                        type="checkbox" value="Bila pasien mulai hipotensi (mual, muntah, keringat dingin, pusing kram, hipoglikemi berikan cairan sesuai SPO)">
                    <label class="form-check-label" style="font-weight: 400;">Bila pasien mulai hipotensi (mual, muntah, keringat dingin, pusing kram, hipoglikemi berikan cairan sesuai SPO)</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan7]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan7'] == 'Berikan terapi oksigen sesuai kebutuhan' ? 'checked' : '' }}
                        type="checkbox" value="Berikan terapi oksigen sesuai kebutuhan">
                    <label class="form-check-label" style="font-weight: 400;">Berikan terapi oksigen sesuai kebutuhan</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan8]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan8'] == 'Hentikan HD sesuai indikasi' ? 'checked' : '' }}
                        type="checkbox" value="Hentikan HD sesuai indikasi">
                    <label class="form-check-label" style="font-weight: 400;">Hentikan HD sesuai indikasi</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan9]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan9'] == 'Posisikan supinasi dengan elevasi kepala 30° dan elevasi kaki' ? 'checked' : '' }}
                        type="checkbox" value="Posisikan supinasi dengan elevasi kepala 30° dan elevasi kaki">
                    <label class="form-check-label" style="font-weight: 400;">Posisikan supinasi dengan elevasi kepala 30° dan elevasi kaki</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan10]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan10'] == 'Monitor tanda dan gejala infeksi (lokal dan sistemik)' ? 'checked' : '' }}
                        type="checkbox" value="Monitor tanda dan gejala infeksi (lokal dan sistemik)">
                    <label class="form-check-label" style="font-weight: 400;">Monitor tanda dan gejala infeksi (lokal dan sistemik)</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan11]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan11'] == 'Monitor tanda dan gejala hipoglikemi' ? 'checked' : '' }}
                        type="checkbox" value="Monitor tanda dan gejala hipoglikemi">
                    <label class="form-check-label" style="font-weight: 400;">Monitor tanda dan gejala hipoglikemi</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_keperawatan][pilihan12]"
                        {{ @$assesment['intervensi_keperawatan']['pilihan12'] == 'Lakukan teknik, distraksi, relaksasi' ? 'checked' : '' }}
                        type="checkbox" value="Lakukan teknik, distraksi, relaksasi">
                    <label class="form-check-label" style="font-weight: 400;">Lakukan teknik, distraksi, relaksasi</label>
                  </div>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5 class="text-center"><b>Intervensi Kolaborasi</b></h5>
              <tr>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan1]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan1'] == 'Program HD' ? 'checked' : '' }}
                        type="checkbox" value="Program HD">
                    <label class="form-check-label" style="font-weight: 400;">Program HD</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan2]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan2'] == 'Pemberian Erytropetin' ? 'checked' : '' }}
                        type="checkbox" value="Pemberian Erytropetin">
                    <label class="form-check-label" style="font-weight: 400;">Pemberian Erytropetin</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan3]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan3'] == 'Pemberian Analgetik' ? 'checked' : '' }}
                        type="checkbox" value="Pemberian Analgetik">
                    <label class="form-check-label" style="font-weight: 400;">Pemberian Analgetik</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan4]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan4'] == 'Transfusi darah' ? 'checked' : '' }}
                        type="checkbox" value="Transfusi darah">
                    <label class="form-check-label" style="font-weight: 400;">Transfusi darah</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan5]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan5'] == 'Pemberian preparat besi' ? 'checked' : '' }}
                        type="checkbox" value="Pemberian preparat besi">
                    <label class="form-check-label" style="font-weight: 400;">Pemberian preparat besi</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan6]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan6'] == 'Pemberian Ca Gluconas' ? 'checked' : '' }}
                        type="checkbox" value="Pemberian Ca Gluconas">
                    <label class="form-check-label" style="font-weight: 400;">Pemberian Ca Gluconas</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan7]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan7'] == 'Obat obat emergensi' ? 'checked' : '' }}
                        type="checkbox" value="Obat obat emergensi">
                    <label class="form-check-label" style="font-weight: 400;">Obat obat emergensi</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan8]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan8'] == 'Pemberian Antipiretik' ? 'checked' : '' }}
                        type="checkbox" value="Pemberian Antipiretik">
                    <label class="form-check-label" style="font-weight: 400;">Pemberian Antipiretik</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan9]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan9'] == 'Pemberian Antibiotik' ? 'checked' : '' }}
                        type="checkbox" value="Pemberian Antibiotik">
                    <label class="form-check-label" style="font-weight: 400;">Pemberian Antibiotik</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[intervensi_kolaborasi][pilihan10]"
                        {{ @$assesment['intervensi_kolaborasi']['pilihan10'] == 'Lain-lain' ? 'checked' : '' }}
                        type="checkbox" value="Lain-lain">
                    <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                    <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[intervensi_kolaborasi][pilihan10_detail]" value="{{ @$assesment['intervensi_kolaborasi']['pilihan10_detail'] }}">
                  </div>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5 class="text-center"><b>Instruksi Medik</b></h5>
              <tr>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan1]"
                        {{ @$assesment['instruksi_medik']['pilihan1'] == 'Inisiasi' ? 'checked' : '' }}
                        type="checkbox" value="Inisiasi">
                    <label class="form-check-label" style="font-weight: 400;">Inisiasi</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan2]"
                        {{ @$assesment['instruksi_medik']['pilihan2'] == 'Akut' ? 'checked' : '' }}
                        type="checkbox" value="Akut">
                    <label class="form-check-label" style="font-weight: 400;">Akut</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan3]"
                        {{ @$assesment['instruksi_medik']['pilihan3'] == 'Rutin' ? 'checked' : '' }}
                        type="checkbox" value="Rutin">
                    <label class="form-check-label" style="font-weight: 400;">Rutin</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan4]"
                        {{ @$assesment['instruksi_medik']['pilihan4'] == 'SLED' ? 'checked' : '' }}
                        type="checkbox" value="SLED">
                    <label class="form-check-label" style="font-weight: 400;">SLED</label>
                    <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[instruksi_medik][pilihan4_detail]" value="{{ @$assesment['instruksi_medik']['pilihan4_detail'] }}">
                  </div>
                </td>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan5]"
                        {{ @$assesment['instruksi_medik']['pilihan5'] == 'TD' ? 'checked' : '' }}
                        type="checkbox" value="TD">
                    <label class="form-check-label" style="font-weight: 400;">TD (Jam)</label>
                    <input type="text" class="form-control" placeholder="Jam" name="fisik[instruksi_medik][pilihan5_detail]" value="{{ @$assesment['instruksi_medik']['pilihan5_detail'] }}">
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan6]"
                        {{ @$assesment['instruksi_medik']['pilihan6'] == 'QB' ? 'checked' : '' }}
                        type="checkbox" value="QB">
                    <label class="form-check-label" style="font-weight: 400;">QB (ml/mnt)</label>
                    <input type="text" class="form-control" placeholder="ml/mnt" name="fisik[instruksi_medik][pilihan6_detail]" value="{{ @$assesment['instruksi_medik']['pilihan6_detail'] }}">
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan7]"
                        {{ @$assesment['instruksi_medik']['pilihan7'] == 'QD' ? 'checked' : '' }}
                        type="checkbox" value="QD">
                    <label class="form-check-label" style="font-weight: 400;">QD (ml/mnt)</label>
                    <input type="text" class="form-control" placeholder="ml/mnt" name="fisik[instruksi_medik][pilihan7_detail]" value="{{ @$assesment['instruksi_medik']['pilihan7_detail'] }}">
                  </div>
                </td>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan8]"
                        {{ @$assesment['instruksi_medik']['pilihan8'] == 'UF Goal' ? 'checked' : '' }}
                        type="checkbox" value="UF Goal">
                    <label class="form-check-label" style="font-weight: 400;">UF Goal (ml)</label>
                    <input type="text" class="form-control" placeholder="ml" name="fisik[instruksi_medik][pilihan8_detail]" value="{{ @$assesment['instruksi_medik']['pilihan8_detail'] }}">
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan9]"
                        {{ @$assesment['instruksi_medik']['pilihan9'] == 'Prog. Prolling: Na' ? 'checked' : '' }}
                        type="checkbox" value="Prog. Prolling: Na">
                    <label class="form-check-label" style="font-weight: 400;">Prog. Prolling: Na (Na)</label>
                    <input type="text" class="form-control" placeholder="Na" name="fisik[instruksi_medik][pilihan9_detail]" value="{{ @$assesment['instruksi_medik']['pilihan9_detail'] }}">
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan10]"
                        {{ @$assesment['instruksi_medik']['pilihan10'] == 'UF' ? 'checked' : '' }}
                        type="checkbox" value="UF">
                    <label class="form-check-label" style="font-weight: 400;">UF</label>
                    <input type="text" class="form-control" placeholder="UF" name="fisik[instruksi_medik][pilihan10_detail]" value="{{ @$assesment['instruksi_medik']['pilihan10_detail'] }}">
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[instruksi_medik][pilihan11]"
                        {{ @$assesment['instruksi_medik']['pilihan11'] == 'Bicarbonat' ? 'checked' : '' }}
                        type="checkbox" value="Bicarbonat">
                    <label class="form-check-label" style="font-weight: 400;">Bicarbonat</label>
                    <input type="text" class="form-control" placeholder="Bicarbonat" name="fisik[instruksi_medik][pilihan11_detail]" value="{{ @$assesment['instruksi_medik']['pilihan11_detail'] }}">
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%; font-weight: bold;">
                  Diallsat
                </td>
                <td style="padding: 5px;" colspan="2">
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][diallsat][pilihan1]"
                            {{ @$assesment['instruksi_medik']['diallsat']['pilihan1'] == 'Bicarbonat' ? 'checked' : '' }}
                            type="checkbox" value="Bicarbonat">
                        <label class="form-check-label">Bicarbonat</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][diallsat][pilihan2]"
                            {{ @$assesment['instruksi_medik']['diallsat']['pilihan2'] == 'Condactivity' ? 'checked' : '' }}
                            type="checkbox" value="Condactivity">
                        <label class="form-check-label" aria-placeholder="">Condactivity</label>
                        <input type="text" class="form-control" placeholder="Jelaskan...." name="fisik[instruksi_medik][diallsat][pilihan2_detail]" value="{{ @$assesment['instruksi_medik']['diallsat']['pilihan2_detail'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][diallsat][pilihan3]"
                            {{ @$assesment['instruksi_medik']['diallsat']['pilihan3'] == 'Temperatur' ? 'checked' : '' }}
                            type="checkbox" value="Temperatur">
                        <label class="form-check-label" aria-placeholder="">Temperatur</label>
                        <input type="text" class="form-control" placeholder="Jelaskan...." name="fisik[instruksi_medik][diallsat][pilihan3_detail]" value="{{ @$assesment['instruksi_medik']['diallsat']['pilihan3_detail'] }}">
                    </div>
                </td>
              </tr>
              <tr>
                <td  style="width: 50%; font-weight: bold;">
                  Heparinisasi
                </td>
                <td style="padding: 5px;" colspan="2">
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][heparinisasi][pilihan1]"
                            {{ @$assesment['instruksi_medik']['heparinisasi']['pilihan1'] == 'Dosis sirkulasi' ? 'checked' : '' }}
                            type="checkbox" value="Dosis sirkulasi">
                        <label class="form-check-label">Dosis sirkulasi (lu)</label>
                        <input type="text" class="form-control" placeholder="lu" name="fisik[instruksi_medik][heparinisasi][pilihan1_detail]" value="{{ @$assesment['instruksi_medik']['heparinisasi']['pilihan1_detail'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][heparinisasi][pilihan2]"
                            {{ @$assesment['instruksi_medik']['heparinisasi']['pilihan2'] == 'Dosis Maintenance' ? 'checked' : '' }}
                            type="checkbox" value="Dosis Maintenance">
                        <label class="form-check-label" aria-placeholder="">Dosis Maintenance (Continues lu/jam)</label>
                        <input type="text" class="form-control" placeholder="lu/jam" name="fisik[instruksi_medik][heparinisasi][pilihan2_detail]" value="{{ @$assesment['instruksi_medik']['heparinisasi']['pilihan2_detail'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][heparinisasi][pilihan3]"
                            {{ @$assesment['instruksi_medik']['heparinisasi']['pilihan3'] == 'Intermitten' ? 'checked' : '' }}
                            type="checkbox" value="Intermitten">
                        <label class="form-check-label" aria-placeholder="">Intermitten (lu/jam)</label>
                        <input type="text" class="form-control" placeholder="lu/jam" name="fisik[instruksi_medik][heparinisasi][pilihan3_detail]" value="{{ @$assesment['instruksi_medik']['heparinisasi']['pilihan3_detail'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][heparinisasi][pilihan4]"
                            {{ @$assesment['instruksi_medik']['heparinisasi']['pilihan4'] == 'LMWH' ? 'checked' : '' }}
                            type="checkbox" value="LMWH">
                        <label class="form-check-label" aria-placeholder="">LMWH</label>
                        <input type="text" class="form-control" placeholder="LMWH" name="fisik[instruksi_medik][heparinisasi][pilihan4_detail]" value="{{ @$assesment['instruksi_medik']['heparinisasi']['pilihan4_detail'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][heparinisasi][pilihan5]"
                            {{ @$assesment['instruksi_medik']['heparinisasi']['pilihan5'] == 'Tanpa Heparin' ? 'checked' : '' }}
                            type="checkbox" value="Tanpa Heparin">
                        <label class="form-check-label" aria-placeholder="">Tanpa Heparin, Penyebab :</label>
                        <input type="text" class="form-control" placeholder="Penyebab" name="fisik[instruksi_medik][heparinisasi][pilihan5_detail]" value="{{ @$assesment['instruksi_medik']['heparinisasi']['pilihan5_detail'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[instruksi_medik][heparinisasi][pilihan6]"
                            {{ @$assesment['instruksi_medik']['heparinisasi']['pilihan6'] == 'Program bilas NaCI 0.9 % 100 cc / jam / setengah jam' ? 'checked' : '' }}
                            type="checkbox" value="Program bilas NaCI 0.9 % 100 cc / jam / setengah jam">
                        <label class="form-check-label" aria-placeholder="">Program bilas NaCI 0.9 % 100 cc / jam / setengah jam</label>
                    </div>
                </td>
              </tr>
            </table>
          </div>
          
          <div class="col-md-12">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"> 
            <h5 class="text-center"><b>Tindakan Keperawatan</b></h5>
              <thead style="border: 1px solid black;">
                <tr style="border: 1px solid black;">
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Observasi</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Jam</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Qb</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Uf Rate</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Tek Drh</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Nadi</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Suhu</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Resp</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">
                    Intake <br>
                      1. NaCI 0.9 % <br>
                      2. Dextrose 40% <br>
                      3. Makan / minum <br>
                      4. Lain-lain <br>
                      <b>(Ditulis no)</b>
                  </th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Out-put</th>
                  <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Keterangan Lain</th>
                </tr>
              </thead>
              <tbody>
                @for ($i = 1; $i<=5; $i++)  
                <tr>
                  <td style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Intra HD</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][jam]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['jam'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][qb]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['qb'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][uf_rate]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['uf_rate'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][tek_drh]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['tek_drh'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][nadi]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['nadi'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][suhu]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['suhu'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][resp]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['resp'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][intake]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['intake'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][output]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['output'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][intra_hd][{{ $i }}][keterangan_lain]" value="{{ @$assesment['tindakan_keperawatan']['intra_hd'][$i]['keterangan_lain'] }}">
                  </td>
                </tr>
                @endfor
                <tr>
                  <td style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Post HD</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][jam]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['jam'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][qb]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['qb'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][uf_rate]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['uf_rate'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][tek_drh]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['tek_drh'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][nadi]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['nadi'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][suhu]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['suhu'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][resp]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['resp'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][intake]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['intake'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][output]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['output'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][post_hd][keterangan_lain]" value="{{ @$assesment['tindakan_keperawatan']['post_hd']['keterangan_lain'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">Jml : 
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][jumlah]" value="{{ @$assesment['tindakan_keperawatan']['jumlah'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">Balance : 
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][balance]" value="{{ @$assesment['tindakan_keperawatan']['balance'] }}">
                  </td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                </tr>
                <tr>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;" colspan="3">Total UF (ml):
                    <input type="text" class="form-control" name="fisik[tindakan_keperawatan][total_uf]" value="{{ @$assesment['tindakan_keperawatan']['total_uf'] }}">
                  <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"> 
              <h5 class="text-center"><b>Penyulit Selama HD</b></h5>
              <tr>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[penyulit_selama_hd][pilihan1]"
                        {{ @$assesment['penyulit_selama_hd']['pilihan1'] == 'Masalah Akses' ? 'checked' : '' }}
                        type="checkbox" value="Masalah Akses">
                    <label class="form-check-label" style="font-weight: 400;">Masalah Akses</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan2]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan2'] == 'Nyeri dada' ? 'checked' : '' }}
                          type="checkbox" value="Nyeri dada">
                      <label class="form-check-label" style="font-weight: 400;">Nyeri dada</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan3]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan3'] == 'Perdarahan' ? 'checked' : '' }}
                          type="checkbox" value="Perdarahan">
                      <label class="form-check-label" style="font-weight: 400;">Perdarahan</label>
                  </div>
                </td>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[penyulit_selama_hd][pilihan4]"
                        {{ @$assesment['penyulit_selama_hd']['pilihan4'] == 'Aritmia' ? 'checked' : '' }}
                        type="checkbox" value="Aritmia">
                    <label class="form-check-label" style="font-weight: 400;">Aritmia</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan5]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan5'] == 'First Use Syndrome' ? 'checked' : '' }}
                          type="checkbox" value="First Use Syndrome">
                      <label class="form-check-label" style="font-weight: 400;">First Use Syndrome</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan6]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan6'] == 'Gatal-gatal' ? 'checked' : '' }}
                          type="checkbox" value="Gatal-gatal">
                      <label class="form-check-label" style="font-weight: 400;">Gatal-gatal</label>
                  </div>
                </td>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[penyulit_selama_hd][pilihan7]"
                        {{ @$assesment['penyulit_selama_hd']['pilihan7'] == 'Sakit Kepala' ? 'checked' : '' }}
                        type="checkbox" value="Sakit Kepala">
                    <label class="form-check-label" style="font-weight: 400;">Sakit Kepala</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan8]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan8'] == 'Demam' ? 'checked' : '' }}
                          type="checkbox" value="Demam">
                      <label class="form-check-label" style="font-weight: 400;">Demam</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan9]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan9'] == 'Mual dan Muntah' ? 'checked' : '' }}
                          type="checkbox" value="Mual dan Muntah">
                      <label class="form-check-label" style="font-weight: 400;">Mual dan Muntah</label>
                  </div>
                </td>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[penyulit_selama_hd][pilihan10]"
                        {{ @$assesment['penyulit_selama_hd']['pilihan10'] == 'Menggigil / dingin' ? 'checked' : '' }}
                        type="checkbox" value="Menggigil / dingin">
                    <label class="form-check-label" style="font-weight: 400;">Menggigil / dingin</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan11]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan11'] == 'Kram Otot' ? 'checked' : '' }}
                          type="checkbox" value="Kram Otot">
                      <label class="form-check-label" style="font-weight: 400;">Kram Otot</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan12]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan12'] == 'Hiperkalemia' ? 'checked' : '' }}
                          type="checkbox" value="Hiperkalemia">
                      <label class="form-check-label" style="font-weight: 400;">Hiperkalemia</label>
                  </div>
                </td>
                <td>
                  <div>
                    <input class="form-check-input"
                        name="fisik[penyulit_selama_hd][pilihan13]"
                        {{ @$assesment['penyulit_selama_hd']['pilihan13'] == 'Hipotensi' ? 'checked' : '' }}
                        type="checkbox" value="Hipotensi">
                    <label class="form-check-label" style="font-weight: 400;">Hipotensi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan14]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan14'] == 'Hipertensi' ? 'checked' : '' }}
                          type="checkbox" value="Hipertensi">
                      <label class="form-check-label" style="font-weight: 400;">Hipertensi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[penyulit_selama_hd][pilihan15]"
                          {{ @$assesment['penyulit_selama_hd']['pilihan15'] == 'Lain-lain' ? 'checked' : '' }}
                          type="checkbox" value="Lain-lain">
                          <input type="text" class="form-control" name="fisik[penyulit_selama_hd][pilihan15_detail]" placeholder="Lainnya" value="{{ @$assesment['penyulit_selama_hd']['pilihan15_detail'] }}">
                  </div>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"> 
              <h5 class="text-center"><b>Evaluasi Perawatan</b></h5>
              <tr>
                <td style="padding: 5px;" colspan="3">
                  <textarea rows="5" name="fisik[evaluasi_perawatan][detail]" style="display:inline-block; resize: vertical;" placeholder="[masukkan evaluasi perawatan]" class="form-control" >{{ @$assesment['evaluasi_perawatan']['detail'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px" colspan="3">
                  @if (@$assesment['selesai_evaluasi_perawatan'])
                    <b>Selesai pada : </b> {{date('d-m-Y H:i:s', strtotime(@$assesment['selesai_evaluasi_perawatan']))}}
                  @else
                    <input type="submit" name="selesai_evaluasi_perawatan" class="btn btn-success btn-flat" value="SELESAI">
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
                  <input type="text" id="waktuKontrol" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="button" id="listKontrol" data-dokterID="{{ $reg->dokter_id }}"
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
          </div>

          <div class="col-md-12 text-right">
            <input class="btn btn-warning" type="reset" value="Reset">&nbsp;&nbsp;
            <button class="btn btn-success">Simpan</button>
          </div>

        </form>

        

          <div class="col-md-6">
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
              
              @if (count($riwayats_perawat) == 0)
                  <tr>
                      <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                  </tr>
              @else
                @foreach ($riwayats_perawat as $riwayat)
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ baca_poli($riwayat->registrasi->poli_id) }}
                        </td>
                      
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
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
              @endif
            </tbody>
          </table>
          </div>

          <div class="col-md-12">
            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4>
                    <a href="#askepCollapse" data-toggle="collapse">Asuhan Keperawatan</a>
                  </h4>
                </div>
                <div id="askepCollapse" class="panel-collapse collapse">
                  <div class="panel-body">
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
                </div>
              </div>
            </div>
          </div>
      @endif
          
          <br /><br />
        </div>
      </div>
      

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
        // $("#date_tanpa_tanggal").datepicker( {
        //     format: "mm-yyyy",
        //     viewMode: "months", 
        //     minViewMode: "months"
        // });
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd-mm-yyyy",
            autoclose: true
        });
        $("#date_dengan_tanggal").attr('', true);  
         
  </script>
   <script>
    $(document).on('click', '#listKontrol', function(e) {
      var id = $(this).attr('data-dokterID');
      var tgl = $('#waktuKontrol').val();
      
      if(tgl == null || tgl == ''){
        alert('Harap Isi Tanggal Kontrol');
      }else{
        $('#showListKontrol').modal('show');
        $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
      }
    });
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
    <script>
      // Get the modal
      var modal = document.getElementById("myModal");
      
      // Get the image and insert it inside the modal - use its "alt" text as a caption
      var img = document.getElementById("myImg");
      var modalImg = document.getElementById("img01");
      var dataImage = document.getElementById("dataImage");
      var captionText = document.getElementById("caption");
      img.onclick = function(){
          modal.style.display = "block";
          modalImg.src = dataImage.src;
          captionText.innerHTML = this.alt;
      }
      
      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];
      
      // When the user clicks on <span> (x), close the modal
      span.onclick = function() { 
          modal.style.display = "none";
      }
  </script>
  <script type="text/javascript">
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
</script>
  @endsection