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

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
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
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
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
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

    .select2-selection__rendered {
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
    <h1>Hand Over Pasien</h1>
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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/hand-over-pasien/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12">
                            @include('emr.modules.addons.tabs')
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                              <h4 style="text-align: center; padding: 10px"><b>Hand Over Pasien</b></h4>
                            <br>
                        </div>
                    </div>

                    <div class="row">
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
                                          {{@Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          {{ @$riwayat->user->name }}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                          
                                          {{-- <a href="{{ url("cetak-formulir-surveilans-infeksi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i>
                                          </a> --}}

                                          {{-- <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                            <i class="fa fa-trash"></i>
                                          </a> --}}
                                      </td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                      <i>Dibuat : {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }}</i>
                                    </td>
                                  </tr>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                          <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                              <tr style="text-align: center;">
                                  <td style="width: 20%"></td>
                                  <td><b>Pagi</b></td>
                                  <td><b>Siang</b></td>
                                  <td><b>Malam</b></td>
                              </tr>
                              <tr>
                                <td colspan="4" style="width: 20%; text-align: center;"><b>Assesment(A)</b></td>
                              </tr>
                              <tr>
                                  <td style="width: 20%">Diagnosa Medis</td>
                                  <td><input type="text" name="fisik[assesment][diagnosa_medis1]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['diagnosa_medis1'] }}"></td>
                                  <td><input type="text" name="fisik[assesment][diagnosa_medis2]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['diagnosa_medis2'] }}"></td>
                                  <td><input type="text" name="fisik[assesment][diagnosa_medis3]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['diagnosa_medis3'] }}"></td>                      
                              </tr>
                              <tr>
                                  <td style="width: 20%">Diagnosa Keperawatan</td>
                                  <td><input type="text" name="fisik[assesment][diagnosa_keperawatan1]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['diagnosa_keperawatan1'] }}"></td>
                                  <td><input type="text" name="fisik[assesment][diagnosa_keperawatan2]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['diagnosa_keperawatan2'] }}"></td>
                                  <td><input type="text" name="fisik[assesment][diagnosa_keperawatan3]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['diagnosa_keperawatan3'] }}"></td>                      
                              </tr>
                              <tr>
                                  <td style="width: 20%">Hari Rawat Ke</td>
                                  <td><input type="text" name="fisik[assesment][hari1]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['hari1'] }}"></td>
                                  <td><input type="text" name="fisik[assesment][hari2]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['hari2'] }}"></td>
                                  <td><input type="text" name="fisik[assesment][hari3]" style="display:inline-block;" class="form-control" id="" value="{{ @$assesment['assesment']['hari3'] }}"></td>                      
                              </tr>
                              <tr>
                                  <td style="width: 20%">Klasifikasi Pasien</td>
                                  <td>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi1]" {{ @$assesment['assesment']['klasifikasi1'] == 'Total Care' ? 'checked' : '' }} value="Total Care">
                                      <label style="font-weight: normal;">Total Care</label>
                                    </div>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi1]" {{ @$assesment['assesment']['klasifikasi1'] == 'Partial Care' ? 'checked' : '' }} value="Partial Care">
                                      <label style="font-weight: normal;">Partial Care</label>
                                    </div>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi1]" {{ @$assesment['assesment']['klasifikasi1'] == 'Minimal Care' ? 'checked' : '' }} value="Minimal Care">
                                      <label style="font-weight: normal;">Minimal Care</label>
                                    </div>               
                                  </td>
                                  <td>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi2]" {{ @$assesment['assesment']['klasifikasi2'] == 'Total Care' ? 'checked' : '' }} value="Total Care">
                                      <label style="font-weight: normal;">Total Care</label>
                                    </div>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi2]" {{ @$assesment['assesment']['klasifikasi2'] == 'Partial Care' ? 'checked' : '' }} value="Partial Care">
                                      <label style="font-weight: normal;">Partial Care</label>
                                    </div>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi2]" {{ @$assesment['assesment']['klasifikasi2'] == 'Minimal Care' ? 'checked' : '' }} value="Minimal Care">
                                      <label style="font-weight: normal;">Minimal Care</label>
                                    </div>               
                                  </td>
                                  <td>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi3]" {{ @$assesment['assesment']['klasifikasi3'] == 'Total Care' ? 'checked' : '' }} value="Total Care">
                                      <label style="font-weight: normal;">Total Care</label>
                                    </div>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi3]" {{ @$assesment['assesment']['klasifikasi3'] == 'Partial Care' ? 'checked' : '' }} value="Partial Care">
                                      <label style="font-weight: normal;">Partial Care</label>
                                    </div>
                                    <div>
                                      <input type="radio" name="fisik[assesment][klasifikasi3]" {{ @$assesment['assesment']['klasifikasi3'] == 'Minimal Care' ? 'checked' : '' }} value="Minimal Care">
                                      <label style="font-weight: normal;">Minimal Care</label>
                                    </div>               
                                  </td>
                              </tr>
                              <tr>
                                <td style="width: 20%;">Keluhan Saat ini</td>
                                <td><input type="text" class="form-control" name="fisik[assesment][keluhan1]" value="{{ @$assesment['assesment']['keluhan1'] }}" placeholder=""></td>
                                <td><input type="text" class="form-control" name="fisik[assesment][keluhan2]" value="{{ @$assesment['assesment']['keluhan2'] }}" placeholder=""></td>
                                <td><input type="text" class="form-control" name="fisik[assesment][keluhan3]" value="{{ @$assesment['assesment']['keluhan3'] }}" placeholder=""></td>
                              </tr>
                              <tr>
                                <td colspan="4" style="width: 20%; text-align: center;"><b>Background(B)</b></td>
                              </tr>
                              <tr>
                                <td style="width: 20%;">Riwayat Kesehatan Sekarang</td>
                                <td><input type="text" class="form-control" name="fisik[background][riwayat_kesehatan1]" value="{{ @$assesment['background']['riwayat_kesehatan1'] }}" placeholder=""></td>
                                <td><input type="text" class="form-control" name="fisik[background][riwayat_kesehatan2]" value="{{ @$assesment['background']['riwayat_kesehatan2'] }}" placeholder=""></td>
                                <td><input type="text" class="form-control" name="fisik[background][riwayat_kesehatan3]" value="{{ @$assesment['background']['riwayat_kesehatan3'] }}" placeholder=""></td>
                              </tr>
                              <tr>
                                <td>Riwayat Alergi</td>
                                <td>
                                    <input type="radio" name="fisik[background][riwayat_alergi1]" {{ @$assesment['background']['riwayat_alergi1'] == 'Tidak' ? 'checked' : '' }}  value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][riwayat_alergi1]" {{ @$assesment['background']['riwayat_alergi1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[background][riwayat_alergi_detail1][obat]" value="{{ @$assesment['background']['riwayat_alergi_detail1']['obat'] }}" placeholder="obat">
                                    <input type="text" class="form-control" name="fisik[background][riwayat_alergi_detail1][makanan]" value="{{ @$assesment['background']['riwayat_alergi_detail1']['makanan'] }}" placeholder="makanan">
                                    </div>                                 
                                </td>
                                <td>
                                    <input type="radio" name="fisik[background][riwayat_alergi2]" {{ @$assesment['background']['riwayat_alergi2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][riwayat_alergi2]" {{ @$assesment['background']['riwayat_alergi2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[background][riwayat_alergi_detail2][obat]" value="{{ @$assesment['background']['riwayat_alergi_detail2']['obat'] }}" placeholder="obat">
                                    <input type="text" class="form-control" name="fisik[background][riwayat_alergi_detail2][makanan]" value="{{ @$assesment['background']['riwayat_alergi_detail2']['makanan'] }}" placeholder="makanan">
                                    </div>                                 
                                </td>
                                <td>
                                    <input type="radio" name="fisik[background][riwayat_alergi3]" {{ @$assesment['background']['riwayat_alergi3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][riwayat_alergi3]" {{ @$assesment['background']['riwayat_alergi3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[background][riwayat_alergi_detail3][obat]" value="{{ @$assesment['background']['riwayat_alergi_detail3']['obat'] }}" placeholder="obat">
                                    <input type="text" class="form-control" name="fisik[background][riwayat_alergi_detail3][makanan]" value="{{ @$assesment['background']['riwayat_alergi_detail3']['makanan'] }}" placeholder="makanan">
                                    </div>                                 
                                </td>
                              </tr>                   
                              <tr>
                                <td style="width: 20%; vertical-align: top;">Info penting yang berhubungan dengan kondisi pasien terkini</td>
                                <td>
                                  <textarea style="resize: vertical;" class="form-control" rows="7" placeholder="[Masukkan info penting]" name="fisik[background][info_penting1]">{{ @$assesment['background']['info_penting1'] }}</textarea>
                                </td>
                                <td>
                                  <textarea style="resize: vertical;" class="form-control" rows="7" placeholder="[Masukkan info penting]" name="fisik[background][info_penting2]">{{ @$assesment['background']['info_penting2'] }}</textarea>
                                </td>
                                <td>
                                  <textarea style="resize: vertical;" class="form-control" rows="7" placeholder="[Masukkan info penting]" name="fisik[background][info_penting3]">{{ @$assesment['background']['info_penting3'] }}</textarea>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 20%; vertical-align: top;">Tanda Tanda Vital</td>
                                <td>
                                  TD :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][td1]" value="{{ @$assesment['background']['tanda_vital']['td1'] }}">
                                  Nadi :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][nadi1]" value="{{ @$assesment['background']['tanda_vital']['nadi1'] }}">
                                  Suhu :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][suhu1]" value="{{ @$assesment['background']['tanda_vital']['suhu1'] }}">
                                  Resp :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][resp1]" value="{{ @$assesment['background']['tanda_vital']['resp1'] }}">
                                  Skala Nyeri :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][skala1]" value="{{ @$assesment['background']['tanda_vital']['skala1'] }}">
                                </td>
                                <td>
                                  TD :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][td2]" value="{{ @$assesment['background']['tanda_vital']['td2'] }}">
                                  Nadi :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][nadi2]" value="{{ @$assesment['background']['tanda_vital']['nadi2'] }}">
                                  Suhu :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][suhu2]" value="{{ @$assesment['background']['tanda_vital']['suhu2'] }}">
                                  Resp :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][resp2]" value="{{ @$assesment['background']['tanda_vital']['resp2'] }}">
                                  Skala Nyeri :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][skala2]" value="{{ @$assesment['background']['tanda_vital']['skala2'] }}">
                                </td>
                                <td>
                                  TD :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][td3]" value="{{ @$assesment['background']['tanda_vital']['td3'] }}">
                                  Nadi :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][nadi3]" value="{{ @$assesment['background']['tanda_vital']['nadi3'] }}">
                                  Suhu :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][suhu3]" value="{{ @$assesment['background']['tanda_vital']['suhu3'] }}">
                                  Resp :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][resp3]" value="{{ @$assesment['background']['tanda_vital']['resp3'] }}">
                                  Skala Nyeri :
                                  <input type="text" class="form-control" name="fisik[background][tanda_vital][skala3]" value="{{ @$assesment['background']['tanda_vital']['skala3'] }}">
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 20%; vertical-align: top;">Kesadaran</td>
                                <td>
                                  <div>
                                    <input type="checkbox" name="fisik[background][kesadaran][compos_mentis1]" {{ @$assesment['background']['kesadaran']['compos_mentis1'] == 'Compos Mentis' ? 'checked' : '' }} value="Compos Mentis">
                                    <label style="font-weight: normal;">Compos Mentis</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][somnolen1]" {{ @$assesment['background']['kesadaran']['somnolen1'] == 'Somnolen' ? 'checked' : '' }} value="Somnolen">
                                    <label style="font-weight: normal;">Somnolen</label>
                                  </div>
                                  <div>
                                    <input type="checkbox" name="fisik[background][kesadaran][apatis1]" {{ @$assesment['background']['kesadaran']['apatis1'] == 'Apatis' ? 'checked' : '' }} value="Apatis">
                                    <label style="font-weight: normal;">Apatis</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][koma1]" {{ @$assesment['background']['kesadaran']['koma1'] == 'Koma' ? 'checked' : '' }} value="Koma">
                                    <label style="font-weight: normal;">Koma</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][sopor1]" {{ @$assesment['background']['kesadaran']['sopor1'] == 'Sopor' ? 'checked' : '' }} value="Sopor">
                                    <label style="font-weight: normal;">Sopor</label>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <input type="checkbox" name="fisik[background][kesadaran][compos_mentis2]" {{ @$assesment['background']['kesadaran']['compos_mentis2'] == 'Compos Mentis' ? 'checked' : '' }} value="Compos Mentis">
                                    <label style="font-weight: normal;">Compos Mentis</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][somnolen2]" {{ @$assesment['background']['kesadaran']['somnolen2'] == 'Somnolen' ? 'checked' : '' }} value="Somnolen">
                                    <label style="font-weight: normal;">Somnolen</label>
                                  </div>
                                  <div>
                                    <input type="checkbox" name="fisik[background][kesadaran][apatis2]" {{ @$assesment['background']['kesadaran']['apatis2'] == 'Apatis' ? 'checked' : '' }} value="Apatis">
                                    <label style="font-weight: normal;">Apatis</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][koma2]" {{ @$assesment['background']['kesadaran']['koma2'] == 'Koma' ? 'checked' : '' }} value="Koma">
                                    <label style="font-weight: normal;">Koma</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][sopor2]" {{ @$assesment['background']['kesadaran']['sopor2'] == 'Sopor' ? 'checked' : '' }} value="Sopor">
                                    <label style="font-weight: normal;">Sopor</label>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <input type="checkbox" name="fisik[background][kesadaran][compos_mentis3]" {{ @$assesment['background']['kesadaran']['compos_mentis3'] == 'Compos Mentis' ? 'checked' : '' }} value="Compos Mentis">
                                    <label style="font-weight: normal;">Compos Mentis</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][somnolen3]" {{ @$assesment['background']['kesadaran']['somnolen3'] == 'Somnolen' ? 'checked' : '' }} value="Somnolen">
                                    <label style="font-weight: normal;">Somnolen</label>
                                  </div>
                                  <div>
                                    <input type="checkbox" name="fisik[background][kesadaran][apatis3]" {{ @$assesment['background']['kesadaran']['apatis3'] == 'Apatis' ? 'checked' : '' }} value="Apatis">
                                    <label style="font-weight: normal;">Apatis</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][koma3]" {{ @$assesment['background']['kesadaran']['koma3'] == 'Koma' ? 'checked' : '' }} value="Koma">
                                    <label style="font-weight: normal;">Koma</label>
                                    <input type="checkbox" name="fisik[background][kesadaran][sopor3]" {{ @$assesment['background']['kesadaran']['sopor3'] == 'Sopor' ? 'checked' : '' }} value="Sopor">
                                    <label style="font-weight: normal;">Sopor</label>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 20%; vertical-align: top;">GCS</td>
                                <td>
                                  E =
                                  <input type="text" class="form-control" name="fisik[background][gcs][e1]" value="{{ @$assesment['background']['gcs']['e1'] }}">
                                  V =
                                  <input type="text" class="form-control" name="fisik[background][gcs][v1]" value="{{ @$assesment['background']['gcs']['v1'] }}">
                                  M = 
                                  <input type="text" class="form-control" name="fisik[background][gcs][m1]" value="{{ @$assesment['background']['gcs']['m1'] }}">
                                </td>
                                <td>
                                  E =
                                  <input type="text" class="form-control" name="fisik[background][gcs][e2]" value="{{ @$assesment['background']['gcs']['e2'] }}">
                                  V =
                                  <input type="text" class="form-control" name="fisik[background][gcs][v2]" value="{{ @$assesment['background']['gcs']['v2'] }}">
                                  M = 
                                  <input type="text" class="form-control" name="fisik[background][gcs][m2]" value="{{ @$assesment['background']['gcs']['m2'] }}">
                                </td>
                                <td>
                                  E =
                                  <input type="text" class="form-control" name="fisik[background][gcs][e3]" value="{{ @$assesment['background']['gcs']['e3'] }}">
                                  V =
                                  <input type="text" class="form-control" name="fisik[background][gcs][v3]" value="{{ @$assesment['background']['gcs']['v3'] }}">
                                  M = 
                                  <input type="text" class="form-control" name="fisik[background][gcs][m3]" value="{{ @$assesment['background']['gcs']['m3'] }}">
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 20%;">Diet / Frekuensi</td>
                                <td>
                                  <input type="text" class="form-control" name="fisik[background][diet1]" value="{{ @$assesment['background']['diet1'] }}" placeholder="">
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="fisik[background][diet2]" value="{{ @$assesment['background']['diet2'] }}" placeholder="">
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="fisik[background][diet3]" value="{{ @$assesment['background']['diet3'] }}" placeholder="">
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 20%; vertical-align: top;">Intake Cairan</td>
                                <td>
                                  <div>
                                    <input type="checkbox" name="fisik[background][intake_cairan1][oral]" {{ @$assesment['background']['intake_cairan1']['oral'] == 'Oral' ? 'checked' : '' }} value="Oral">
                                    <label style="font-weight: normal;">Oral/NGT</label>
                                  </div>
                                  <div>
                                    <input type="checkbox" name="fisik[background][intake_cairan1][parental]" {{ @$assesment['background']['intake_cairan1']['parental'] == 'Parental' ? 'checked' : '' }} value="Parental">
                                    <label style="font-weight: normal;">Parenteral</label>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <input type="checkbox" name="fisik[background][intake_cairan2][oral]" {{ @$assesment['background']['intake_cairan2']['oral'] == 'Oral/NGT' ? 'checked' : '' }} value="Oral/NGT">
                                    <label style="font-weight: normal;">Oral/NGT</label>
                                  </div>
                                  <div>
                                    <input type="checkbox" name="fisik[background][intake_cairan2][parental]" {{ @$assesment['background']['intake_cairan2']['parental'] == 'Parenteral' ? 'checked' : '' }} value="Parenteral">
                                    <label style="font-weight: normal;">Parenteral</label>
                                  </div>
                                </td>
                                <td>
                                  <div>
                                    <input type="checkbox" name="fisik[background][intake_cairan3][oral]" {{ @$assesment['background']['intake_cairan3']['oral'] == 'Oral/NGT' ? 'checked' : '' }} value="Oral/NGT">
                                    <label style="font-weight: normal;">Oral/NGT</label>
                                  </div>
                                  <div>
                                    <input type="checkbox" name="fisik[background][intake_cairan3][parental]" {{ @$assesment['background']['intake_cairan3']['parental'] == 'Parenteral' ? 'checked' : '' }} value="Parenteral">
                                    <label style="font-weight: normal;">Parenteral</label>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="vertical-align: top;">Massa</td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][massa1]" {{ @$assesment['background']['massa1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][massa1]" {{ @$assesment['background']['massa1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][massa][lokasi1]" value="{{ @$assesment['background']['massa']['lokasi1'] }}" placeholder="lokasi">
                                    <input type="text" class="form-control" name="fisik[background][massa][ukuran1]" value="{{ @$assesment['background']['massa']['ukuran1'] }}" placeholder="ukuran">
                                  </div>
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][massa2]" {{ @$assesment['background']['massa2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][massa2]" {{ @$assesment['background']['massa2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][massa][lokasi2]" value="{{ @$assesment['background']['massa']['lokasi2'] }}" placeholder="lokasi">
                                    <input type="text" class="form-control" name="fisik[background][massa][ukuran2]" value="{{ @$assesment['background']['massa']['ukuran2'] }}" placeholder="ukuran">
                                  </div>
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][massa3]" {{ @$assesment['background']['massa3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][massa3]" {{ @$assesment['background']['massa3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][massa][lokasi3]" value="{{ @$assesment['background']['massa']['lokasi3'] }}" placeholder="lokasi">
                                    <input type="text" class="form-control" name="fisik[background][massa][ukuran3]" value="{{ @$assesment['background']['massa']['ukuran3'] }}" placeholder="ukuran">
                                  </div>
                                </td>
                              </tr>   
                              <tr>
                                <td style="vertical-align: top;">Luka Operasi</td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][luka_operasi1]" {{ @$assesment['background']['luka_operasi1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][luka_operasi1]" {{ @$assesment['background']['luka_operasi1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][luka_operasi][lokasi1]" value="{{ @$assesment['background']['luka_operasi']['lokasi1'] }}" placeholder="lokasi">
                                    <input type="text" class="form-control" name="fisik[background][luka_operasi][hari1]" value="{{ @$assesment['background']['luka_operasi']['hari1'] }}" placeholder="hari ke">
                                  </div>
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][luka_operasi2]" {{ @$assesment['background']['luka_operasi2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][luka_operasi2]" {{ @$assesment['background']['luka_operasi2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][luka_operasi][lokasi2]" value="{{ @$assesment['background']['luka_operasi']['lokasi2'] }}" placeholder="lokasi">
                                    <input type="text" class="form-control" name="fisik[background][luka_operasi][hari2]" value="{{ @$assesment['background']['luka_operasi']['hari2'] }}" placeholder="hari ke">
                                  </div>
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][luka_operasi3]" {{ @$assesment['background']['luka_operasi3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][luka_operasi3]" {{ @$assesment['background']['luka_operasi3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][luka_operasi][lokasi3]" value="{{ @$assesment['background']['luka_operasi']['lokasi3'] }}" placeholder="lokasi">
                                    <input type="text" class="form-control" name="fisik[background][luka_operasi][hari3]" value="{{ @$assesment['background']['luka_operasi']['hari3'] }}" placeholder="hari ke">
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 20%; vertical-align: top;">Terapi Parenteral</td>
                                <td>
                                  <div>
                                    <input type="text" class="form-control" name="fisik[background][terapi_parental][ml/hr1]" value="{{ @$assesment['background']['terapi_parental']['ml/hr1'] }}" placeholder="ml/hr">
                                  </div>
                                  <div>
                                    <input type="text" class="form-control" name="fisik[background][terapi_parental][lokasi1]" value="{{ @$assesment['background']['terapi_parental']['lokasi1'] }}" placeholder="lokasi">
                                  </div>                         
                                </td>
                                <td>
                                  <div>
                                    <input type="text" class="form-control" name="fisik[background][terapi_parental][ml/hr2]" value="{{ @$assesment['background']['terapi_parental']['ml/hr2'] }}" placeholder="ml/hr">
                                  </div>
                                  <div>
                                    <input type="text" class="form-control" name="fisik[background][terapi_parental][lokasi2]" value="{{ @$assesment['background']['terapi_parental']['lokasi2'] }}" placeholder="lokasi">
                                  </div>                         
                                </td>
                                <td>
                                  <div>
                                    <input type="text" class="form-control" name="fisik[background][terapi_parental][ml/hr3]" value="{{ @$assesment['background']['terapi_parental']['ml/hr3'] }}" placeholder="ml/hr">
                                  </div>
                                  <div>
                                    <input type="text" class="form-control" name="fisik[background][terapi_parental][lokasi3]" value="{{ @$assesment['background']['terapi_parental']['lokasi3'] }}" placeholder="lokasi">
                                  </div>                         
                                </td>
                              </tr>
                              <tr>
                                <td style="vertical-align: top;">Kemoterapi</td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][kemoterapi1]" {{ @$assesment['background']['kemoterapi1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][kemoterapi1]" {{ @$assesment['background']['kemoterapi1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][kemoterapi][siklus1]" value="{{ @$assesment['background']['kemoterapi']['siklus1'] }}" placeholder="siklus ke">
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][kemoterapi2]" {{ @$assesment['background']['kemoterapi2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][kemoterapi2]" {{ @$assesment['background']['kemoterapi2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][kemoterapi][siklus2]" value="{{ @$assesment['background']['kemoterapi']['siklus2'] }}" placeholder="siklus ke">
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][kemoterapi3]" {{ @$assesment['background']['kemoterapi3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][kemoterapi3]" {{ @$assesment['background']['kemoterapi3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <input type="text" class="form-control" name="fisik[background][kemoterapi][siklus3]" value="{{ @$assesment['background']['kemoterapi']['siklus3'] }}" placeholder="siklus ke">
                                </td>
                              </tr>
                              <tr>
                                <td style="vertical-align: top;">Radiasi</td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][radiasi1]" {{ @$assesment['background']['radiasi1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][radiasi1]" {{ @$assesment['background']['radiasi1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <select name="fisik[background][radiasi][pilihan1]" class="form-control" style="width: 50%">
                                      <option value="1" {{ @$assesment['background']['radiasi']['pilihan1'] == '1' ? 'selected' : '' }}>Internal</option>
                                      <option value="2" {{ @$assesment['background']['radiasi']['pilihan1'] == '2' ? 'selected' : '' }}>Eksternal</option>
                                    </select>
                                    <input type="text" class="form-control" name="fisik[background][radiasi_siklus1]" value="{{ @$assesment['background']['radiasi_siklus1'] }}" placeholder="siklus ke">
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][radiasi2]" {{ @$assesment['background']['radiasi2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][radiasi2]" {{ @$assesment['background']['radiasi2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <select name="fisik[background][radiasi][pilihan2]" class="form-control" style="width: 50%">
                                      <option value="1" {{ @$assesment['background']['radiasi']['pilihan2'] == '1' ? 'selected' : '' }}>Internal</option>
                                      <option value="2" {{ @$assesment['background']['radiasi']['pilihan2'] == '2' ? 'selected' : '' }}>Eksternal</option>
                                    </select>
                                    <input type="text" class="form-control" name="fisik[background][radiasi_siklus2]" value="{{ @$assesment['background']['radiasi_siklus2'] }}" placeholder="siklus ke">
                                </td>
                                <td style="padding: 5px;">
                                    <input type="radio" name="fisik[background][radiasi3]" {{ @$assesment['background']['radiasi3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak</label>
                                    <input type="radio" name="fisik[background][radiasi3]" {{ @$assesment['background']['radiasi3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ya</label>
                                    <select name="fisik[background][radiasi][pilihan3]" class="form-control" style="width: 50%">
                                      <option value="1" {{ @$assesment['background']['radiasi']['pilihan3'] == '1' ? 'selected' : '' }}>Internal</option>
                                      <option value="2" {{ @$assesment['background']['radiasi']['pilihan3'] == '2' ? 'selected' : '' }}>Eksternal</option>
                                    </select>
                                    <input type="text" class="form-control" name="fisik[background][radiasi_siklus1]" value="{{ @$assesment['background']['radiasi_siklus1'] }}" placeholder="siklus ke">
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 20%;">Test Diagnostik</td>
                                <td>
                                  <input type="text" class="form-control" name="fisik[background][test_diagnostik1]" value="{{ @$assesment['background']['test_diagnostik1'] }}" placeholder="">
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="fisik[background][test_diagnostik2]" value="{{ @$assesment['background']['test_diagnostik2'] }}" placeholder="">
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="fisik[background][test_diagnostik3]" value="{{ @$assesment['background']['test_diagnostik3'] }}" placeholder="">
                                </td>
                              </tr>
                              <tr>
                                <td colspan="4" style="vertical-align: top; padding-top: 5px; text-align: center;"><b>Assesment(A)</b></td>                        
                              </tr>
                              <tr>
                                <td style="vertical-align: top; padding-top: 5px;">Kepala & Leher</td>
                                <td>
                                  Mata :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mata1]" {{ @$assesment['assesment']['kepala&leher']['mata1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mata1]" {{ @$assesment['assesment']['kepala&leher']['mata1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][mata][jelaskan1]" value="{{ @$assesment['assesment']['kepala&leher']['mata']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Hidung :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][hidung1]" {{ @$assesment['assesment']['kepala&leher']['hidung1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][hidung1]" {{ @$assesment['assesment']['kepala&leher']['hidung1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][hidung][jelaskan1]" value="{{ @$assesment['assesment']['kepala&leher']['hidung']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Mulut :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mulut1]" {{ @$assesment['assesment']['kepala&leher']['mulut1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mulut1]" {{ @$assesment['assesment']['kepala&leher']['mulut1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][mulut][jelaskan1]" value="{{ @$assesment['assesment']['kepala&leher']['mulut']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Telinga :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][telinga1]" {{ @$assesment['assesment']['kepala&leher']['telinga1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][telinga1]" {{ @$assesment['assesment']['kepala&leher']['telinga1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][telinga][jelaskan1]" value="{{ @$assesment['assesment']['kepala&leher']['telinga']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Leher :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][leher1]" {{ @$assesment['assesment']['kepala&leher']['leher1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][leher1]" {{ @$assesment['assesment']['kepala&leher']['leher1'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][leher][jelaskan1]" value="{{ @$assesment['assesment']['kepala&leher']['leher']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                </td>                    
                                <td>
                                  Mata :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mata2]" {{ @$assesment['assesment']['kepala&leher']['mata2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mata2]" {{ @$assesment['assesment']['kepala&leher']['mata2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][mata][jelaskan2]" value="{{ @$assesment['assesment']['kepala&leher']['mata']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Hidung :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][hidung2]" {{ @$assesment['assesment']['kepala&leher']['hidung2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][hidung2]" {{ @$assesment['assesment']['kepala&leher']['hidung2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][hidung][jelaskan2]" value="{{ @$assesment['assesment']['kepala&leher']['hidung']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Mulut :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mulut2]" {{ @$assesment['assesment']['kepala&leher']['mulut2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mulut2]" {{ @$assesment['assesment']['kepala&leher']['mulut2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][mulut][jelaskan2]" value="{{ @$assesment['assesment']['kepala&leher']['mulut']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Telinga :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][telinga2]" {{ @$assesment['assesment']['kepala&leher']['telinga2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][telinga2]" {{ @$assesment['assesment']['kepala&leher']['telinga2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][telinga][jelaskan2]" value="{{ @$assesment['assesment']['kepala&leher']['telinga']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Leher :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][leher2]" {{ @$assesment['assesment']['kepala&leher']['leher2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][leher2]" {{ @$assesment['assesment']['kepala&leher']['leher2'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][leher][jelaskan2]" value="{{ @$assesment['assesment']['kepala&leher']['leher']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                </td>                    
                                <td>
                                  Mata :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mata3]" {{ @$assesment['assesment']['kepala&leher']['mata3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mata3]" {{ @$assesment['assesment']['kepala&leher']['mata3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][mata][jelaskan3]" value="{{ @$assesment['assesment']['kepala&leher']['mata']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Hidung :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][hidung3]" {{ @$assesment['assesment']['kepala&leher']['hidung3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][hidung3]" {{ @$assesment['assesment']['kepala&leher']['hidung3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][hidung][jelaskan3]" value="{{ @$assesment['assesment']['kepala&leher']['hidung']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Mulut :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mulut3]" {{ @$assesment['assesment']['kepala&leher']['mulut3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][mulut3]" {{ @$assesment['assesment']['kepala&leher']['mulut3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][mulut][jelaskan3]" value="{{ @$assesment['assesment']['kepala&leher']['mulut']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Telinga :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][telinga3]" {{ @$assesment['assesment']['kepala&leher']['telinga3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][telinga3]" {{ @$assesment['assesment']['kepala&leher']['telinga3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][telinga][jelaskan3]" value="{{ @$assesment['assesment']['kepala&leher']['telinga']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Leher :
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][leher3]" {{ @$assesment['assesment']['kepala&leher']['leher3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][kepala&leher][leher3]" {{ @$assesment['assesment']['kepala&leher']['leher3'] == 'Ya' ? 'checked' : '' }} value="Ya">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][kepala&leher][leher][jelaskan3]" value="{{ @$assesment['assesment']['kepala&leher']['leher']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                </td>                    
                              </tr>
                              <tr>
                                <td style="width: 50px; vertical-align: top; padding-top: 5px;">Dada</td>
                                <td>
                                  Payudara :
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][payudara1]" {{ @$assesment['assesment']['dada']['payudara1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][payudara1]" {{ @$assesment['assesment']['dada']['payudara1'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][payudara][jelaskan1]" value="{{ @$assesment['assesment']['dada']['payudara']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Pergerakan Dada :
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][pergerakan_dada1]" {{ @$assesment['assesment']['dada']['pergerakan_dada1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][pergerakan_dada1]" {{ @$assesment['assesment']['dada']['pergerakan_dada1'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][pergerakan_dada][jelaskan1]" value="{{ @$assesment['assesment']['dada']['pergerakan_dada']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                           
                                </td>  
                                <td>
                                  Payudara :
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][payudara2]" {{ @$assesment['assesment']['dada']['payudara2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][payudara2]" {{ @$assesment['assesment']['dada']['payudara2'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][dada][payudara][jelaskan2]" value="{{ @$assesment['assesment']['dada']['payudara']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Pergerakan Dada :
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][pergerakan_dada2]" {{ @$assesment['assesment']['dada']['pergerakan_dada2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][pergerakan_dada2]" {{ @$assesment['assesment']['dada']['pergerakan_dada2'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][dada][pergerakan_dada][jelaskan2]" value="{{ @$assesment['assesment']['dada']['pergerakan_dada']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                           
                                </td>                                
                                <td>
                                  Payudara :
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][payudara3]" {{ @$assesment['assesment']['dada']['payudara3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][payudara3]" {{ @$assesment['assesment']['dada']['payudara3'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][dada][payudara][jelaskan3]" value="{{ @$assesment['assesment']['dada']['payudara']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                  Pergerakan Dada :
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][pergerakan_dada3]" {{ @$assesment['assesment']['dada']['pergerakan_dada3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][dada][pergerakan_dada3]" {{ @$assesment['assesment']['dada']['pergerakan_dada3'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][dada][pergerakan_dada][jelaskan3]" value="{{ @$assesment['assesment']['dada']['pergerakan_dada']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                           
                                </td>      
                              </tr>
                              <tr>
                                <td style="width: 50px; vertical-align: top; padding-top: 5px;">Abdomen</td>
                                <td>
                                  Perut :
                                  <div>
                                    <input type="radio" name="fisik[assesment][abdomen][perut1]" {{ @$assesment['assesment']['abdomen']['perut1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][abdomen][perut1]" {{ @$assesment['assesment']['abdomen']['perut1'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][abdomen][perut][jelaskan1]" value="{{ @$assesment['assesment']['abdomen']['perut']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                     
                                </td>
                                <td>
                                  Perut :
                                  <div>
                                    <input type="radio" name="fisik[assesment][abdomen][perut2]" {{ @$assesment['assesment']['abdomen']['perut2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][abdomen][perut2]" {{ @$assesment['assesment']['abdomen']['perut2'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][abdomen][perut][jelaskan2]" value="{{ @$assesment['assesment']['abdomen']['perut']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                     
                                </td>
                                <td>
                                  Perut :
                                  <div>
                                    <input type="radio" name="fisik[assesment][abdomen][perut3]" {{ @$assesment['assesment']['abdomen']['perut3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][abdomen][perut3]" {{ @$assesment['assesment']['abdomen']['perut3'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][abdomen][perut][jelaskan3]" value="{{ @$assesment['assesment']['abdomen']['perut']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                     
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 50px; vertical-align: top; padding-top: 5px;">Muskuloskeletal & Kulit</td>
                                <td>
                                  Tulang & Sendi :
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][tulang1]" {{ @$assesment['assesment']['muskuloskeletal']['tulang1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][tulang1]" {{ @$assesment['assesment']['muskuloskeletal']['tulang1'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][muskuloskeletal][tulang][jelaskan1]" value="{{ @$assesment['assesment']['muskuloskeletal']['tulang']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                    
                                  Kulit :
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][kulit1]" {{ @$assesment['assesment']['muskuloskeletal']['kulit1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][kulit1]" {{ @$assesment['assesment']['muskuloskeletal']['kulit1'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][muskuloskeletal][kulit][jelaskan1]" value="{{ @$assesment['assesment']['muskuloskeletal']['kulit']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                    
                                </td>
                                <td>
                                  Tulang & Sendi :
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][tulang2]" {{ @$assesment['assesment']['muskuloskeletal']['tulang2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][tulang2]" {{ @$assesment['assesment']['muskuloskeletal']['tulang2'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][muskuloskeletal][tulang][jelaskan2]" value="{{ @$assesment['assesment']['muskuloskeletal']['tulang']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                    
                                  Kulit :
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][kulit2]" {{ @$assesment['assesment']['muskuloskeletal']['kulit2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][kulit2]" {{ @$assesment['assesment']['muskuloskeletal']['kulit2'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][muskuloskeletal][kulit][jelaskan2]" value="{{ @$assesment['assesment']['muskuloskeletal']['kulit']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                    
                                </td>
                                <td>
                                  Tulang & Sendi :
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][tulang3]" {{ @$assesment['assesment']['muskuloskeletal']['tulang3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][tulang3]" {{ @$assesment['assesment']['muskuloskeletal']['tulang3'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][muskuloskeletal][tulang][jelaskan3]" value="{{ @$assesment['assesment']['muskuloskeletal']['tulang']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                    
                                  Kulit :
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][kulit3]" {{ @$assesment['assesment']['muskuloskeletal']['kulit3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][muskuloskeletal][kulit3]" {{ @$assesment['assesment']['muskuloskeletal']['kulit3'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][muskuloskeletal][kulit][jelaskan3]" value="{{ @$assesment['assesment']['muskuloskeletal']['kulit']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>                                                    
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 50px; vertical-align: top; padding-top: 5px;">Genital</td>
                                <td>
                                  Vagina/Penis :
                                  <div>
                                    <input type="radio" name="fisik[assesment][genital][vagina1]" {{ @$assesment['assesment']['genital']['vagina1'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][genital][vagina1]" {{ @$assesment['assesment']['genital']['vagina1'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][genital][vagina][jelaskan1]" value="{{ @$assesment['assesment']['genital']['vagina']['jelaskan1'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                </td>
                                <td>
                                  Vagina/Penis :
                                  <div>
                                    <input type="radio" name="fisik[assesment][genital][vagina2]" {{ @$assesment['assesment']['genital']['vagina2'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][genital][vagina2]" {{ @$assesment['assesment']['genital']['vagina2'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][genital][vagina][jelaskan2]" value="{{ @$assesment['assesment']['genital']['vagina']['jelaskan2'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                </td>
                                <td>
                                  Vagina/Penis :
                                  <div>
                                    <input type="radio" name="fisik[assesment][genital][vagina3]" {{ @$assesment['assesment']['genital']['vagina3'] == 'Tidak' ? 'checked' : '' }} value="Tidak">
                                    <label style="font-weight: normal;">Tidak ada kelainan/keluhan</label>
                                  </div>
                                  <div>
                                    <input type="radio" name="fisik[assesment][genital][vagina3]" {{ @$assesment['assesment']['genital']['vagina3'] == 'Ada' ? 'checked' : '' }} value="Ada">
                                    <label style="font-weight: normal;">Ada kelainan/keluhan</label>
                                    <div>
                                    <input type="text" class="form-control" name="fisik[assesment][genital][vagina][jelaskan3]" value="{{ @$assesment['assesment']['genital']['vagina']['jelaskan3'] }}" placeholder="Jelaskan">
                                    </div>
                                  </div><br>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 50px; vertical-align: top; padding-top: 5px;"><b>Recomendation(R)</b></td>
                                <td>
                                  <textarea style="resize: vertical;" class="form-control" rows="7" placeholder="[rekomendasi]" name="fisik[recomendation][rekomendasi1]">{{ @$assesment['recomendation']['rekomendasi1'] }}</textarea>
                                </td>
                                <td>
                                  <textarea style="resize: vertical;" class="form-control" rows="7" placeholder="[rekomendasi]" name="fisik[recomendation][rekomendasi2]">{{ @$assesment['recomendation']['rekomendasi2'] }}</textarea>
                                </td>
                                <td>
                                  <textarea style="resize: vertical;" class="form-control" rows="7" placeholder="[rekomendasi]" name="fisik[recomendation][rekomendasi3]">{{ @$assesment['recomendation']['rekomendasi3'] }}</textarea>
                                </td>
                              </tr>
                          </table>
                      </div>
                  </div>

                  @if (empty(@$assesment))
                    <button class="btn btn-success pull-right">Simpan</button>
                  @else
                    <button class="btn btn-danger pull-right">Perbarui</button>
                    {{-- <a href="{{url('emr-soap/pemeriksaan/cetak_hand_over_pasien' . '/' . $reg->id)}}" class="btn btn-warning pull-right" style="margin-right: 1rem;">Cetak</a> --}}
                  @endif
                </form>
        </div>
    </div>
  </div>  

  {{-- Modal TTE Sbar--}}
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-tte-sbar" action="" method="POST">
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE Transfer Internal</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Nama:</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
          </div>
          </div>
          <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">NIK:</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
          </div>
          </div>
          <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
          <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
          </div>
          </div>
      </div>

      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="button-proses-tte-triage" onclick="prosesTTE()">Proses TTE</button>
      </div>
      </div>
      </form>
  
  </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        let html = `Pemakaian ke :
                        <input required type="text" class="form-control" name="background[penggunaan_kateter][pemakaian_ke]" value="{{@$dataBackground['penggunaan_kateter']['pemakaian_ke']}}">
                        Tanggal :
                        <input required type="date" class="form-control" name="background[penggunaan_kateter][tanggal]" value="{{@$dataBackground['penggunaan_kateter']['tanggal']}}">
                        Jam :
                        <input required type="time" class="form-control" name="background[penggunaan_kateter][jam]" value="{{@$dataBackground['penggunaan_kateter']['jam']}}">`;
                    
            function editDokter(id) {
            var dok = $('#dokter_id').val();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/emr/editDokter/' + dok + '/' + id,
                    type: 'POST',
                    dataType: 'json',
                })
                .done(function(data) {
                    alert('Berhasil Ubah DPJP');
                })
                .fail(function() {
                    alert('Gagal Ubah DPJP');
                });
            }
        
          function penggunaan_kateter(status) {
          if (status == "Ada") {
            $('#penggunaan_kateter').html(html);
          } else {
            $('#penggunaan_kateter').html('');
          }
        }

        $(".skin-blue").addClass( "sidebar-collapse" );
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

    <script>
        function showTTEModal(sbar_id) {
            $('#form-tte-sbar').attr('action', '/tte-transfer-internal/'+sbar_id)
            $('#myModal').modal('show');
        }

        function prosesTTE() {
            $('input').prop('disabled', false)
            $('#form-tte-sbar').submit();
        }
    </script>

@endsection
