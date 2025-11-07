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
  .scroll-umum{
   width: 100%;
   overflow-y:scroll;
   height:40%;
   display:block;
  }
</style>
@section('header')
<h1>Asesmen - Riwayat</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/riwayat_umum/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          

          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Riwayat</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:20%;">Keluhan Utama</td>
                <td style="padding: 5px;">
                  <textarea rows="15" name="keterangan" style="display:inline-block" placeholder="[Masukkan Keluhan Utama]" class="form-control" required></textarea></td>
              
             </tr>
             <tr>
                <td style="width:20%;">Riwayat Penyakit Sekaranag</td>
                <td style="padding: 5px;">
                  <textarea rows="15" name="riwayat[riwayat_penyakit_sekarang]" style="display:inline-block" placeholder="[Masukkan Riwayat Penyakit Sekarang]" class="form-control" required></textarea></td>
              
             </tr>
            </table>
            <h5><b>Riwayat Kesehatan</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
                <tr>
                    <td  rowspan="3">Riwayat Alergi</td>
                    <td>
                      <input class="form-check-input" class="riwayat"  name="riwayat[obat]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="riwayat[obat]" type="checkbox" value="Obat" id="flexCheckDefault">
                      A. Obat
                    </td>
                </tr>
                <tr>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="riwayat[makanan]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="riwayat[makanan]" type="checkbox" value="Makanan" id="flexCheckDefault">
                      B. Makanan
                      </td>
                </tr>
                <tr>
                    <td style="padding: 5px;">
                      <input name="riwayat[lainnya1]" type="text" class="form-control" id="lainnya" placeholder="Lain-lain">
                    </td>
                <tr>
                  <td style="width:20%;" rowspan="7">Riwayat Penyakit Dahulu :</td>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="riwayat[hipertensi1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="riwayat[hipertensi1]" type="checkbox" value="Hipertensi" id="flexCheckDefault">
                    Hipertensi
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="riwayat[diabetes1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="riwayat[diabetes1]" type="checkbox" value="Diabetes" id="flexCheckDefault">
                    Diabetes
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="riwayat[asma1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="riwayat[asma1]" type="checkbox" value="Asma" id="flexCheckDefault">
                    Asma
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="riwayat[maag1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="riwayat[maag1]" type="checkbox" value="Maag" id="flexCheckDefault">
                    Maag
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="riwayat[hepatitis1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="riwayat[hepatitis1]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                    Hepatitis
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatdahulu"  name="riwayat[jantung1]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatdahulu"  name="riwayat[jantung1]" type="checkbox" value="Jatung" id="flexCheckDefault">
                    Jantung
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <input name="riwayat[lainnya2]" type="text" class="form-control" id="lainnya" placeholder="Lain-lain">
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;" rowspan="7">Riwayat Penyakit Keluarga :</td>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[hipertensi2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[hipertensi2]" type="checkbox" value="Hipertensi" id="flexCheckDefault">
                    Hipertensi
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[diabetes2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[diabetes2]" type="checkbox" value="Diabetes" id="flexCheckDefault">
                    Diabetes
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[asma2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[asma2]" type="checkbox" value="Asma" id="flexCheckDefault">
                    Asma
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[maag2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[maag2]" type="checkbox" value="Maag" id="flexCheckDefault">
                    Maag
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[hepatitis2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[hepatitis2]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                    Hepatitis
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[jantung2]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input" class="riwayatkeluarga"  name="riwayat[jantung2]" type="checkbox" value="Jatung" id="flexCheckDefault">
                    Jantung
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <input name="riwayat[lainnya3]" type="text" class="form-control" id="lainnya" placeholder="Lain-lain">
                  </td>
                </tr>
            </table>
            <h5><b>Riwayat Perkawinan</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;"> 
                <tr>
                    <td  rowspan="3">Status</td>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="riwayat[bkawin]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="riwayat[bkawin]" type="checkbox" value="BKawin" id="flexCheckDefault">
                      A. Belum Kawin
                    </td>
                </tr>
                <tr>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="riwayat[kawin]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="riwayat[kawin]" type="checkbox" value="Kawin" id="flexCheckDefault">
                      B. Kawin
                      </td>
                </tr>
                <tr>
                    <td>
                    <input class="form-check-input" class="riwayat"  name="riwayat[cerai]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input" class="riwayat"  name="riwayat[cerai]" type="checkbox" value="Cerai" id="flexCheckDefault">
                      C. Cerai
                      </td>
                </tr>
                <tr>
                  <td style="width:20%;">Menikah (x)</td>
                  <td style="padding: 5px;"><input type="number" value="0" name="riwayat[menikah]" style="display:inline-block" class="form-control" id=""></td>
                </tr>
                <tr>
                  <td style="width:20%;">Lama Menikah </td>
                  <td>
                    <input name="riwayat[lama]" type="text" class="form-control" id="lama" placeholder="Lama Menikah">
                  </td>
                </tr>
            </table>



            <h5><b>Riwayat Penyakit Dahulu</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td rowspan="9" style="padding: 5px;">Riwayat Penyakit Dahulu :</td>
                <td>
                <input class="form-check-input" name="riwayat[pil_dhl]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="riwayat[pil_dhl]" type="checkbox" value="Pil" id="flexCheckDefault">
                   Pil
                </td>
               <tr>
                <td>
                  <input class="form-check-input" name="riwayat[jantung_dhl]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="riwayat[jantung_dhl]" type="checkbox" value="jantung" id="flexCheckDefault">
                      jantung
                  </td>
               </tr>
                <tr>
                  <td>
                    <input class="form-check-input" name="riwayat[asma_dhl]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"   name="riwayat[asma_dhl]" type="checkbox" value="asma" id="flexCheckDefault">
                        asma
                    </td>
                </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[hipertensi_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[hipertensi_dhl]" type="checkbox" value="hipertensi" id="flexCheckDefault">
                          hipertensi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[DM_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[DM_dhl]" type="checkbox" value="DM" id="flexCheckDefault">
                          DM
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[hepatitis_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[hepatitis_dhl]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                          Hepatitis
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[alergi_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[alergi_dhl]" type="checkbox" value="Alergi" id="flexCheckDefault">
                          Alergi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[ginjal_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[ginjal_dhl]" type="checkbox" value="Ginjal" id="flexCheckDefault">
                          Ginjal
                      </td>
                  </tr>
                   <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[tidak_ada_dhl]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[tidak_ada_dhl]" type="checkbox" value="Tidak Ada" id="flexCheckDefault">
                          Tidak Ada
                      </td>
                  </tr>
              </tr>
            </table>














            
            <h5><b>Riwayat Penyakit Keluarga</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box table-center"
              style="font-size:12px;">
              <tr>
                <td rowspan="9" style="padding: 5px;">Riwayat Penyakit Keluarga :</td>
                <td>
                <input class="form-check-input" name="riwayat[pil_klg]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="riwayat[pil_klg]" type="checkbox" value="Pil" id="flexCheckDefault">
                   Pil
                </td>
               <tr>
                <td>
                  <input class="form-check-input" name="riwayat[jantung_klg]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"   name="riwayat[jantung_klg]" type="checkbox" value="jantung" id="flexCheckDefault">
                      jantung
                  </td>
               </tr>
                <tr>
                  <td>
                    <input class="form-check-input" name="riwayat[asma_klg]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"   name="riwayat[asma_klg]" type="checkbox" value="asma" id="flexCheckDefault">
                        asma
                    </td>
                </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[hipertensi_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[hipertensi_klg]" type="checkbox" value="hipertensi" id="flexCheckDefault">
                          hipertensi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[DM_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[DM_klg]" type="checkbox" value="DM" id="flexCheckDefault">
                          DM
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[hepatitis_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[hepatitis_klg]" type="checkbox" value="Hepatitis" id="flexCheckDefault">
                          Hepatitis
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[alergi_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[alergi_klg]" type="checkbox" value="Alergi" id="flexCheckDefault">
                          Alergi
                      </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[ginjal_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[ginjal_klg]" type="checkbox" value="Ginjal" id="flexCheckDefault">
                          Ginjal
                      </td>
                  </tr>
                   <tr>
                    <td>
                      <input class="form-check-input" name="riwayat[tidak_ada_klg]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"   name="riwayat[tidak_ada_klg]" type="checkbox" value="Tidak Ada" id="flexCheckDefault">
                          Tidak Ada
                      </td>
                  </tr>
              </tr>
            </table>



            <div class="col-md-12 text-right">
              <button class="btn btn-success">Simpan Data</button>
            </div>
          </div>
          {{-- Alergi --}}

          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Catatan Medis</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i>Belum ada catatan</i></td>
                </tr>  
                @endif

                @php
                    $angka = 1;
                @endphp

                @foreach ($riwayat as $item)
                <tr style="background-color:#9ad0ef">
                  {{-- <th>{{$val_a->registrasi->reg_id}}</th> --}}
                  <th colspan="2">Catatan {{ $angka++ }} 
                    {{-- {{@strtoupper($val_a->registrasi->poli->nama)}} --}}
                  </th>
                </tr>
                <tr> 
                    <td colspan="2"><b>Keluhan Utama</b> : {{$item->keterangan}} <br/></td>
                </tr> 
                <tr> 
                    <td colspan="2"><b>Riwayat Penyakit Sekarang</b> : {{$item->keterangan}} <br/></td>
                </tr> 
                 <tr>
                    <td rowspan="4" style="width: 100px"><b>Alergi :</b><br/>
                      <tr>
                        <td>
                           <b>Obat : </b>{{json_decode(@$item->riwayat,true)['obat']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Makanan : </b>{{json_decode(@$item->riwayat,true)['makanan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->riwayat,true)['lainnya1']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="8" style="width: 100px"><b>Riwayat Penyakit Dahulu :</b><br/>
                      <tr>
                        <td>
                           <b>Hipertensi : </b>{{json_decode(@$item->riwayat,true)['hipertensi1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Diabetes : </b>{{json_decode(@$item->riwayat,true)['diabetes1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Asma : </b>{{json_decode(@$item->riwayat,true)['asma1']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Maag : </b>{{json_decode(@$item->riwayat,true)['maag1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Hepatitis : </b>{{json_decode(@$item->riwayat,true)['hepatitis1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Jantung : </b>{{json_decode(@$item->riwayat,true)['jantung1']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->riwayat,true)['lainnya2']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="8" style="width: 100px"><b>Riwayat Penyakit Keluarga :</b><br/>
                      <tr>
                        <td>
                           <b>Hipertensi : </b>{{json_decode(@$item->riwayat,true)['hipertensi2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Diabetes : </b>{{json_decode(@$item->riwayat,true)['diabetes2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Asma : </b>{{json_decode(@$item->riwayat,true)['asma2']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Maag : </b>{{json_decode(@$item->riwayat,true)['maag2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Hepatitis : </b>{{json_decode(@$item->riwayat,true)['hepatitis2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Jantung : </b>{{json_decode(@$item->riwayat,true)['jantung2']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Lainnya : </b>{{json_decode($item->riwayat,true)['lainnya3']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="6" style="width: 100px"><b>Riwayat Perkawinan :</b><br/>
                      <tr>
                        <td>
                           <b>Belum Kawin : </b>{{json_decode($item->riwayat,true)['bkawin']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Kawin : </b>{{json_decode($item->riwayat,true)['kawin']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Cerai : </b>{{json_decode($item->riwayat,true)['cerai']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                           <b>Menikah : </b>{{json_decode($item->riwayat,true)['menikah']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Hepatitis : </b>{{json_decode($item->riwayat,true)['hepatitis2']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>




                  
                     
                  <tr>
                      <td colspan="2"><b>Penginput</b> : {{baca_user($item->user_id)}}<br/></td>
                  </tr>
                  <tr>
                    <td colspan="2">{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>    
                  <tr>
                    <td colspan="2"><span class="pull-right">
                      <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-hapus-riwayat/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Hapus Data" style="color:red"><i class="fa fa-trash"></i></a>
                      {{-- <a href="{{url('emr-soap-rawatinap/anamnesis/riwayat/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp; --}}
                    </span>
                    </td>
                  </tr> 
                     
                
                @endforeach
              </table>
              </div>
              </div> 
          </div>
          
          <br /><br />
        </div>
      </div>
      
      {{-- <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div> --}}
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
         
  </script>
  @endsection