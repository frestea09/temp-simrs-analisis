@extends('master')

<style>
  .form-box td, select,input,textarea{
    font-size: 12px !important;
  }
  .history-family input[type=text]{
    height:20px !important;
    padding:0px !important;
  }
  .history-family-2 td{
    padding:1px !important;
  }
</style>
@section('header')
  <h1>Medical History - {{baca_unit($unit)}}</h1>
@endsection

@section('content')
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
        <form method="POST" action="{{ url('/emr/save-riwayat') }}" class="form-horizontal">

          <div class="row">
            <div class="col-md-12">
              {{ csrf_field() }}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
              {!! Form::hidden('cara_bayar', $reg->bayar) !!}
              {!! Form::hidden('unit', $unit) !!} 
              <br> 
              @include('emr.modules.addons.tabs')
              
              <div class="col-md-12">  
                <h5><b></b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr class="history-family">
                    <td style="width:20%;"><b>Cara Masuk</b></td>
                    <td style="padding: 5px;">
                      <table style="width:100%;" class="history-family-2">
                        @foreach ($CM as $rowcm)
                        <tr>
                          <td style="width:50%;">
                            {{-- <input type="checkbox" id="{{$rowcm['nama']}}" name="caramasuk[{{$rowcm['id']}}][cara]" value="{{$rowcm['id']}}" {{isset($rowcm['checked'])?'checked':''}}>
                             --}}
                             <input type="hidden" name="caramasuk[{{@$rowcm['id']}}][id]" value="{{@$rowcm['id']}}">
                            <input type="checkbox" id="{{$rowcm['nama']}}" name="caramasuk[{{@$rowcm['id']}}][cek]"
                            value="{{@$rowcm['id']}}" {{@$rowcm['checked']=='1' ?'checked':''}}>
                          {{@$rowcm['nama']}} &nbsp;</td>
                            <td><input type="hidden"class="form-control" value="{{@$rowcm['keterangan']}}" name="caramasuk[{{@$rowcm['id']}}][keterangan]" id=""></td>
                        </tr>
                        @endforeach  
                      </table>
                    </td>
                    <td style="width:20%;"><b>Asal Masuk</b></td>
                    <td style="padding: 5px;">
                      <table style="width:100%;" class="history-family-2">
                        @foreach ($AM as $rowam)
                        <tr>
                          <td style="width:50%;">
                          {{-- <input type="checkbox" id="{{$rowam['nama']}}" name="asalmasuk[{{$rowam['id']}}][asal]" value="{{$rowam['id']}}" {{isset($rowam['checked'])?'checked':''}}>
                          {{$rowam['nama']}} &nbsp;</td> --}}
                          <input type="hidden" name="asalmasuk[{{@$rowam['id']}}][id]" value="{{@$rowam['id']}}">
                          <input type="checkbox" id="{{@$rowam['nama']}}" name="asalmasuk[{{@$rowam['id']}}][cek]"
                            value="{{@$rowam['id']}}" {{@$rowam['checked']=='1' ?'checked':''}}>
                          {{@$rowam['nama']}} &nbsp;
                          <td><input type="hidden"class="form-control" value="{{@$rowam['keterangan']}}" name="asalmasuk[{{@$rowam['id']}}][keterangan]" id=""></td>
                        </tr>
                        @endforeach  
                      </table>
                    </td>
                  </tr>
                </table>
              </div> 
            </div>

            <div class="col-md-12">  
              <h5><b></b></h5>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                
                <tr class="history-family">
                  <td style="width:20%;"><b>Informasi dari</b></td>
                   <td style="padding: 5px;">
                    <table style="width:100%;" class="history-family-2">
                      @foreach ($riwayat_info as $rows)
                      <tr>
                        <td style="width:30%;">
                          {{-- <input type="checkbox" id="{{$rows['nama']}}" name="informasi[{{$rows['id']}}][info]" value="{{$rows['id']}}" {{isset($rows['checked'])?'checked':''}}> --}}
                          <input type="hidden" name="informasi[{{@$rows['id']}}][id]" value="{{@$rows['id']}}">
                          <input type="checkbox" id="{{@$rows['nama']}}" name="informasi[{{@$rows['id']}}][cek]"
                            value="{{@$rows['id']}}" {{@$rows['checked']=='1' ?'checked':''}}>
                          {{@$rows['nama']}} &nbsp;</td>
                        @if($infopasien == @$rows['nama'])
                        <td><input type="text" class="form-control" value="{{@$rows['keterangan']}}" name="informasi[{{@$rows['id']}}][keterangan]" id=""></td>
                        @endif
                        {{-- <td><input type="text"class="form-control" value="{{@$rows['keterangan']}}" name="informasi[{{$item['id']}}][keterangan]" id=""></td> --}}
                      </tr>
                      @endforeach 
                    </table>
                  </td>
                </tr> 
              </table>
            </div> 
            {{-- <div class="col-md-12"> 
            <h5><b>Asal Masuk</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr class="history-family">
                    <td style="width:20%;"></td>
                    <td style="padding: 5px;">
                      <table style="width:100%;" class="history-family-2">
                        @foreach ($AM as $rowam)
                        <tr>
                          <td style="width:30%;">
                          <input type="checkbox" id="{{$rowam['nama']}}" name="asalmasuk[{{$rowam['id']}}][cek]" value="{{$rowam['id']}}" {{isset($rowam['checked'])?'checked':''}}>
                          {{$rowam['nama']}} &nbsp;</td>
                          
                        </tr>
                        @endforeach  
                      </table>
                    </td>
                  </tr>
                </table>
              </div> --}}
          <div class="row">
              <div class="col-md-12">
                
                    <div class="col-md-6">  
                      <h5><b>Anamnesis</b></h5>
                      <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                        <tr>
                            <td style="width:20%;">Tipe Anamnesis</td>
                            <td style="padding: 5px;">
                              <select name="tipe_anamnesis" style="width: 40%;display:inline-block" class="form-control" id="">
                                <option value="autoanamnesis">Autoanamnesis</option>
                              </select>
                              <input type="text" value="{{$riwayat?$riwayat['tipe_anamnesis_keterangan']:''}}" name="tipe_anamnesis_keterangan" style="width: 40%;display:inline-block" class="form-control" id="">
                            </td> 
                        </tr>
                        <tr>
                            <td style="width:20%;">Keluhan Utama</td>
                            <td style="padding: 5px;"><textarea  name="keluhan_utama" style="display:inline-block" class="form-control" id="">{{$riwayat?$riwayat['keluhan_utama']:''}}</textarea></td> 
                        </tr>
                        <tr>
                          <td style="width:20%;">Riwayat Penyakit Sekarang</td>
                          <td style="padding: 5px;"><textarea name="riwayat_penyakit_sekarang" style="display:inline-block" class="form-control" id="">{{$riwayat?$riwayat['riwayat_penyakit_sekarang']:''}}</textarea></td>
                        </tr>
                        <tr>
                          <td style="width:20%;">Riwayat pengobatan</td>
                          <td style="padding: 5px;"><textarea name="riwayat_pengobatan" style="display:inline-block" class="form-control" id="">{{$riwayat?$riwayat['riwayat_pengobatan']:''}}</textarea></td>
                        </tr> 
                      </table>
                    </div>  



                    <div class="col-md-6">  
                  <h5><b>Alergi</b></h5>
                  <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                    <tr class="history-family">
                      <td style="width:20%;">Grup</td>
                      <td style="padding: 5px;">
                        <table style="width:100%;" class="history-family-2">
                          @foreach ($riwayat_alergi as $item)
                          <tr>
                            <td style="width:30%;">{{@$item['nama']}}</td>
                            <td><input type="text"class="form-control" value="{{@$item['keterangan']}}"  name="alergi[{{$item['id']}}][keterangan]" id=""></td>
                          </tr>
                          @endforeach  
                        </table>
                      </td>
                    </tr>
                  </table>
                </div> 


                <div class="col-md-6">  
                  <h5><b>Riwayat kesehatan</b></h5>
                  <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                    <tr>
                        <td style="width:20%;">Riwayat Medis Sebelumnya</td>
                        <td style="padding: 5px;">
                          <input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1" {{ @$riwayat['riwayat_medis_sebelumnya'] == 1 ? 'checked' :''}}>
                          Lain - lain &nbsp; 
                           <input type="text" name="riwayat_medis_sebelumnya_keterangan" value="{{$riwayat?$riwayat['riwayat_medis_sebelumnya_keterangan']:''}}" style="width: 40%;display:inline-block" class="form-control" id="">
                        </td> 
                    </tr>
                    <tr>
                        <td style="width:20%;">Sejarah Bedah</td>
                        <td style="padding: 5px;"><textarea name="sejarah_bedah" style="display:inline-block" class="form-control" id="">{{$riwayat?$riwayat['sejarah_bedah']:''}}</textarea></td> 
                    </tr>
                  </table>
              </div>


                    <div class="col-md-12">
            <h5><b>Tanda Vital</b></h5>
            <div class="col-md-6">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                style="font-size:12px;">
                <tr>
                  <td style="width:20%;">Keadaan Umum</td>
                  <td style="padding: 5px;">
                    <input type="text" name="pemeriksaan[keadaan_umum]" class="form-control" id="">
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">Kesadaran</td>
                  <td style="padding: 5px;"><input type="text" name="pemeriksaan[kesadaran]" style="display:inline-block"
                      class="form-control" id=""/></td>
                </tr>
                <tr>
                  <td style="width:20%;">Tekanan Darah (Sistolik/Distolik) mmHg :</td>
                  <td style="padding: 5px;"><input style="width:30%;display:inline-block" type="number" value="0" name="pemeriksaan[tekanan_darah][]" class="form-control"/> / <input style="width:30%;display:inline-block" type="number" value="0" name="pemeriksaan[tekanan_darah][]" class="form-control"/></td>
                </tr>
                <tr>
                  <td style="width:20%;">Suhu(OC)</td>
                  <td style="padding: 5px;"><input type="text" name="pemeriksaan[suhu]" style="display:inline-block"
                      class="form-control" value="0"></td>
                </tr>
              </table>
            </div>
            
            <div class="col-md-6"> 
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                style="font-size:12px;">
                <tr>
                  <td style="width:20%;">Saturasi O2</td>
                  <td style="padding: 5px;">
                    <input type="number" value="0" name="pemeriksaan[saturasi]" style="display:inline-block" class="form-control" id="">
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">Frekuensi Nadi (X/Menit)</td>
                  <td style="padding: 5px;"><input type="number" value="0" name="pemeriksaan[nadi]" style="display:inline-block" class="form-control" id=""></td>
                </tr>
                <tr>
                  <td style="width:20%;">Frekuensi Nafas (X/Menit)</td>
                  <td style="padding: 5px;"><input type="number" value="0" name="pemeriksaan[nafas]" style="display:inline-block" class="form-control" id=""></td>
                </tr>
                <tr>
                  <td style="width:20%;">Waktu Pemeriksaan</td>
                  <td style="padding: 5px;"><input type="date" value="{{date('Y-m-d')}}" name="pemeriksaan[waktu]" class="form-control"/></td>
                </tr>
              </table>
            </div>
          </div>
          
              <br/><br/> 
            <div class="row">
              <div class="col-md-12">
                {{--<div class="col-md-6">  
                  <h5><b>Riwayat kesehatan</b></h5>
                  <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                    <tr>
                        <td style="width:20%;">Riwayat Medis Sebelumnya</td>
                        <td style="padding: 5px;">
                          <input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1" {{ @$riwayat['riwayat_medis_sebelumnya'] == 1 ? 'checked' :''}}>
                          Lain - lain &nbsp; 
                           <input type="text" name="riwayat_medis_sebelumnya_keterangan" value="{{$riwayat?$riwayat['riwayat_medis_sebelumnya_keterangan']:''}}" style="width: 40%;display:inline-block" class="form-control" id="">
                        </td> 
                    </tr>
                    <tr>
                        <td style="width:20%;">Sejarah Bedah</td>
                        <td style="padding: 5px;"><textarea name="sejarah_bedah" style="display:inline-block" class="form-control" id="">{{$riwayat?$riwayat['sejarah_bedah']:''}}</textarea></td> 
                    </tr>
                  </table>
                    <tr class="history-family">
                   
                        <table style="width:100%;" class="history-family-2">
                          @foreach ($riwayat_kesehatan as $item)
                          <tr>
                            <td style="width:%;">
                              <input type="hidden" name="kesehatan[{{$item['id']}}][id]" value="{{$item['id']}}">
                              <input type="checkbox" id="{{$item['nama']}}" name="kesehatan[{{$item['id']}}][cek]"
                                value="{{$item['id']}}" {{@$item['checked']=='1' ?'checked':''}}>
                              {{$item['nama']}} &nbsp;
                            </td>
                            <td><input type="text" class="form-control" value="{{@$item['keterangan']}}"
                                name="kesehatan[{{$item['id']}}][keterangan]" id=""></td>
                          </tr>
                          @endforeach 
                        </table> --}}



                       
                        
            <!-- <td rowspan="100" style="width:20%;">Pemeriksaan Fisik</td>
                <td rowspan="5"  style="width:20%;">Persarafan</td>
                <td  style="padding: 5px;" class="pemeriksaan">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input" class="pemeriksaan1"  name="pemeriksaan[persarafan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input" class="pemeriksaan1"  name="pemeriksaan[persarafan][tremor]" type="checkbox" value="Tremor" id="flexCheckDefault">
                        Tremor
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input" class="pemeriksaan1"  name="pemeriksaan[persarafan][kejang]" type="checkbox" value="Kejang" id="flexCheckDefault">
                        Kejang
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input" class="pemeriksaan1"  name="pemeriksaan[persarafan][paralise]" type="checkbox" value="Paralise" id="flexCheckDefault">
                        Paralise
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input" class="pemeriksaan1"  name="pemeriksaan[persarafan][hemiparese]" type="checkbox" value="Hemiparese/Hemiplegia" id="flexCheckDefault">
                        Hemiparese/Hemiplegia
                      </label>
                    </td>
                  </tr>
                </td> -->
              


                {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script>
                  
  function bindRadios(selector){
  $(selector).click(function() {
    $(selector).not(this).prop('checked', false);
  });
};

bindRadios("#radio1, #radio2, #radio3, #radio4, #radio5");
// bindRadios("#radio4, #radio5, #radio6");
                  
                </script> --}}








                {{-- <td rowspan="3"  style="width:20%;">Pernapasan</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[pernapasan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[pernapasan][sekret]" type="checkbox" value="Sekret" id="flexCheckDefault">
                        Sekret
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[pernapasan][sesak_napas]" type="checkbox" value="Sesak Napas" id="flexCheckDefault">
                        Sesak Napas
                      </label>
                    </td>
                  </tr>
                </td>






                <td rowspan="4"  style="width:20%;">Pencernaan</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[pencernaan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[pencernaan][konstipasi]" type="checkbox" value="Konstipasi" id="flexCheckDefault">
                        Konstipasi
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[pencernaan][mual]" type="checkbox" value="Mual/Muntah" id="flexCheckDefault">
                        Mual/Muntah
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[pencernaan][diare]" type="checkbox" value="Diare" id="flexCheckDefault">
                        Diare
                      </label>
                    </td>
                  </tr>
                  
                </td>



                <td rowspan="5"  style="width:20%;">Endokrin</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[endokrin][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[endokrin][keringat_banyak]" type="checkbox" value="Keringat Banyak" id="flexCheckDefault">
                        Keringat Banyak
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[endokrin][pembesaran_kelenjar_tiroid]" type="checkbox" value="Pembesaran Kelenjar Tiroid" id="flexCheckDefault">
                        Pembesaran Kelenjar Tiroid
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[endokrin][diare]" type="checkbox" value="Diare" id="flexCheckDefault">
                        Diare
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[endokrin][napas_baus]" type="checkbox" value="Napas Bau" id="flexCheckDefault">
                        Napas Bau
                      </label>
                    </td>
                  </tr>
                  
                </td>





                <td rowspan="3"  style="width:20%;">Kardiovaskuler</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][oedema]" type="checkbox" value="Oedema" id="flexCheckDefault">
                        Oedema
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][chest_pain]" type="checkbox" value="Chest Pain" id="flexCheckDefault">
                        Chest Pain
                      </label>
                    </td>
                  </tr>
                  
                </td>
                <td rowspan="9"  style="width:20%;">Abdomen</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[abdomen][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][membeasar]" type="checkbox" value="Membesar" id="flexCheckDefault">
                        Membesar
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][nyeri_tekan]" type="checkbox" value="Nyeri Tekan" id="flexCheckDefault">
                        Nyeri Tekan
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][luka]" type="checkbox" value="Luka" id="flexCheckDefault">
                        Luka
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][distensi]" type="checkbox" value="Distensi" id="flexCheckDefault">
                        Distensi
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][L_I]" type="checkbox" value="L I" id="flexCheckDefault">
                        L I
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][L_II]" type="checkbox" value="L II" id="flexCheckDefault">
                        L II
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][L_III]" type="checkbox" value="L III" id="flexCheckDefault">
                        L III
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[abdomen][L_IV]" type="checkbox" value="L IV" id="flexCheckDefault">
                        L IV
                      </label>
                    </td>
                  </tr>
                  
                </td>



                <td rowspan="8"  style="width:20%;">Reproduksi</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[reproduksi][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[reproduksi][keputihan]" type="checkbox" value="Keputihan" id="flexCheckDefault">
                        Keputihan
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[reproduksi][haid_teratur]" type="checkbox" value="Haid Teratur" id="flexCheckDefault">
                        Haid Teratur
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[reproduksi][kb]" type="checkbox" value="KB" id="flexCheckDefault">
                        KB
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[reproduksi][hpht]" type="checkbox" value="HPHT" id="flexCheckDefault">
                          HPHT
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[reproduksi][tp]" type="checkbox" value="TP" id="flexCheckDefault">
                        TP
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[reproduksi][uk]" type="checkbox" value="UK" id="flexCheckDefault">
                        UK
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[reproduksi][DPD]" type="checkbox" value="DPD" id="flexCheckDefault">
                       DPD
                      </label>
                    </td>
                  </tr>
                  
                </td>




                <td rowspan="5"  style="width:20%;">Kulit</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[kulit][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[kulit][luka]" type="checkbox" value="Luka" id="flexCheckDefault">
                       Luka
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[kulit][warna]" type="checkbox" value="Warna" id="flexCheckDefault">
                        Warna
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[kulit][lecet]" type="checkbox" value="Lecet" id="flexCheckDefault">
                       Lecet
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[kulit][turgor]" type="checkbox" value="Turgor" id="flexCheckDefault">
                        Turgor
                      </label>
                    </td>
                  </tr>
                  
                </td>






                <td rowspan="3"  style="width:20%;">Urinaria</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[urinaria][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[urinaria][warna]" type="checkbox" value="Warna" id="flexCheckDefault">
                       Warna
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[urinaria][produksi]" type="checkbox" value="Produksi" id="flexCheckDefault">
                        Produksi
                      </label>
                    </td>
                  </tr>
                </td>


                
                <td rowspan="4"  style="width:20%;">Mata</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[mata][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[mata][normal]" type="checkbox" value="Normal" id="flexCheckDefault">
                       Normal
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[mata][kuning]" type="checkbox" value="Kuning" id="flexCheckDefault">
                       Kuning
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[mata][pucat]" type="checkbox" value="Pucat" id="flexCheckDefault">
                       Pucat
                      </label>
                    </td>
                  </tr>
                </td>


                <td rowspan="3"  style="width:20%;">Otot,Sendi, dan Tulang</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[ost][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[ost][gerakan_terbatas]" type="checkbox" value="Gerakan Terbatas" id="flexCheckDefault">
                       Gerakan Terbatas
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[ost][nyeri]" type="checkbox" value="Nyeri" id="flexCheckDefault">
                       Nyeri
                      </label>
                    </td>
                  </tr>
                </td>


               
                <td rowspan="5"  style="width:20%;">Keadaan Emosional</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                    Tidak ada keluhan
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][kooperatif]" type="checkbox" value="Kooperatif" id="flexCheckDefault">
                       Koperatif
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][butuh_pertolongan]" type="checkbox" value="Butuh Pertolongan" id="flexCheckDefault">
                      Butuh Pertolongan
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][ingin_tahu]" type="checkbox" value="Ingin Tahu" id="flexCheckDefault">
                       Ingin Tahu
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][bingung]" type="checkbox" value="Bingung" id="flexCheckDefault">
                       Bingung
                      </label>
                    </td>
                  </tr>
                </td> 




                
              <tr>
                    <td  style="width:20%;">Gigi</td>
                    <td  style="padding: 5px;">
                      <input name="pemeriksaan[gigi]" type="text" class="form-control" id="">
                    </td>
              </tr> 
                
                
              <tr>
                    <td  style="width:20%;">Telinga</td>
                    <td  style="padding: 5px;">
                        <input  name="pemeriksaan[telinga]" type="text" class="form-control">
                    </td>
               </tr>


               <tr>
                    <td  style="width:20%;">Tenggorokan</td>
                    <td  style="padding: 5px;">
                        <input  name="pemeriksaan[tenggorokan]" type="text" class="form-control">
                    </td>
               </tr>  

               <tr>
                    <td  style="width:20%;">Hidung / Muka</td>
                    <td  style="padding: 5px;">
                        <input  name="pemeriksaan[hidung_muka]" type="text" class="form-control">
                    </td>
               </tr>   --}}









                    </tr> 
                  </table>
                </div> 
                
                
                @if (satusehat())
                  <div class="col-md-6">  
                    <h5><b>Satu Sehat</b></h5>
                    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                      <tr class="history-family">
                        <td style="padding: 5px;">
                          <table style="width:100%;" class="history-family-2">
                              <td style="width:30%;">ID Observation Satu Sehat</td>
                              <td><b>{{@$riwayat->id_observation_ss}}</b></td>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </div>
                @endif
              </div>
              
            </div>
            <div class="col-md-12 text-right">
              <button class="btn btn-success">Simpan</button>
            </div>
        <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
          <thead>
            <tr>
              <th>Keadaan Umum</th>
              <th>Kesadaran</th>
              <th>Sistolik</th>
              <th>Frekuensi Nadi</th>
              <th>Frekuensi Nafas</th>
              <th>Suhu</th>
              <th>Saturasi O2</th>
              <th>Waktu Pemeriksaan</th>
            </tr>
          </thead>
        </table>
        </div>
        </form> 
  </div>

@endsection

@section('script')

    <script type="text/javascript">
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
         // ADD RESEP
         
        // HISTORY RESEP 
        // BTN SAVE RESEP
         
        // BTN FINAL RESEP 

        // DELETE DETAIL RESEP 

        // MASTER OBAT  
    </script>
@endsection
