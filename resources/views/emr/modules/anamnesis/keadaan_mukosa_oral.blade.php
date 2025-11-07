`@extends('master')

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
<h1>Anamnesis - Keadaan Mukosa Oral</h1>
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
    {{-- {{url('emr-soap/anamnesis/keadaanmukosaoral/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}} --}}
    <form method="POST" action="{{ url('emr-soap/anamnesis/keadaanmukosaoral/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          

          @foreach ($riwayat as $item)
          @php
           $bau_nafas = json_decode(@$item->kondisi_mukosa_oral,true)['bau_nafas'];
           $pendarahan = json_decode(@$item->kondisi_mukosa_oral,true)['pendarahan'];
           $nyeri = json_decode(@$item->kondisi_mukosa_oral,true)['nyeri'];
           $kondisi_dehidrasi = json_decode(@$item->kondisi_mukosa_oral,true)['kondisi_dehidrasi'];
           $peradangan = json_decode(@$item->kondisi_mukosa_oral,true)['peradangan'];
           $kondisi_fisik = json_decode(@$item->kondisi_mukosa_oral,true)['kondisi_fisik'];
           $dapat_perawatan = json_decode(@$item->kondisi_mukosa_oral,true)['dapat_perawatan'];
           $berapa_kali_menyikat_gigi = json_decode(@$item->kondisi_mukosa_oral,true)['berapa_kali_menyikat_gigi'];
           $cara_menyikat_gigi = json_decode(@$item->kondisi_mukosa_oral,true)['cara_menyikat_gigi'];
           $diagnosis = json_decode(@$item->kondisi_mukosa_oral,true)['diagnosis'];
           $kapan_waktu_menyikat_gigi = json_decode(@$item->kondisi_mukosa_oral,true)['kapan_waktu_menyikat_gigi'];
           $pasien_punya_kebiasaan = json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan'];
           $skala_nyeri = json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri'];
           $riwayat_id = @$item->id;
          @endphp

     

           @endforeach
          {{-- @php
               ($riwayat as $item) {
                $bau_nafas = json_decode(@$item->kondisi_mukosa_oral,true)['bau_nafas'];
              }
          @endphp --}}


    


          {{-- Anamnesis --}}


          <div class="col-md-7">
            <h5><b>Diagnosis</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>


                <td rowspan="20"  style="width:20%;">Diagnosis</td>
                <td  style="padding: 5px;">
                   
                    
                   
                   
                       
                        <input type="text" class="form-control" required name="keadaan_mukosa_oral[diagnosis]">
                      
                  
                </td>
              </tr>
            </table>
          </div>


          









     



       
          <br><br>
          {{-- Alergi --}}
          <div class="col-md-5">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Catatan Medis</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">

                {{-- @php
                    dd($riwayat);
                @endphp --}}

                @if (@$riwayat == null)
                <tr>
                  <td><i>Belum ada catatan</i></td>
                </tr> 
                @else
                @foreach ($riwayat as $item)
                  <tr>
                      {{-- <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/anamnesis/statusfungsional/'.$unit.'/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
            
                      </span> --}}
                      <tr>
                        <td rowspan="7" style="width: 100px"><b>Keadaan Mukosa Oral :</b><br/>
                         
                           <tr>
                             <td>
                               <b>Bau Nafas :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['bau_nafas']}}
                             </td>
                           </tr>
                           <tr>
                             <td>
                               <b>Pendarahan :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pendarahan']}}
                             </td>
                           </tr>
                           <tr>
                             <td>
                               <b>Nyeri :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['nyeri']}}
                             </td>
                           </tr>
                           <tr>
                             <td>
                               <b>Peradangan :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['peradangan']}}
                             </td>
                           </tr>
                           <tr>
                             <td>
                               <b>Kondisi Dehidrasi :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['kondisi_dehidrasi']}}
                             </td>
                           </tr>
                           <tr>
                             <td>
                               <b>Kondisi Fisik :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['kondisi_fisik']}}
                             </td>
                           </tr>
                         
                       </td> 
                        
                     </tr>
                     <tr>
                      <td rowspan="1" style="width: 100px"><b>Diagnosis :</b><br/>
                       
                         <tr>
                           <td>
                             <b></b>{{json_decode(@$item->kondisi_mukosa_oral,true)['diagnosis']}}
                           </td>
                         </tr>
                       
                     </td> 
                      
                   </tr>
                   <tr>
                    <td rowspan="14" style="width: 100px"><b>Riwayat Kesehatan Saat Ini :</b><br/>
                     
                       <tr>
                         <td>
                           <b>TGL :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['tgl']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>GIGI :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['gigi']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Skala nyeri 0 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['0']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                          <b>Skala nyeri 1 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['1']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 2 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['2']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 3 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['3']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 4 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['4']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 5 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['5']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 6 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['5']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 7 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['7']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 8 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['8']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 9 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['9']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 10 :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['skala_nyeri']['10']}}
                        </td>
                      </tr>

                       
                       
                     
                   </td> 
                    
                 </tr>


                 <tr>
                  <td rowspan="6" style="width: 100px"><b>Riwayat Kesehatan:</b><br/>
                   
                     <tr>
                       <td>
                         <b>Penyakit Sistemik :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['sistemik']}}
                       </td>
                     </tr>
                     <tr>
                       <td>
                         <b>Kebutuhan Khusu :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['khusus']}}
                       </td>
                     </tr>
                     <tr>
                       <td>
                         <b>Penggunaan Obat :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['obat']}}
                       </td>
                     </tr>
                     <tr>
                       <td>
                         <b>Konsumsi Miras :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['konsumsi']}}
                       </td>
                     </tr>
                     <tr>
                       <td>
                         <b>Riwayat Alergi :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['alergi']}}
                       </td>
                     </tr>
                   
                 </td> 
                  
               </tr>


               <tr>
                <td rowspan="4" style="width: 100px"><b>Kesehatan Gigi Dan Mulut:</b><br/>
                 
                   <tr>
                     <td>
                       <b>Konsumsi Minuman Manis :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['minum']}}
                     </td>
                   </tr>
                   <tr>
                     <td>
                       <b>Remineralisasi Gigi :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['Remineralisasi']}}
                     </td>
                   </tr>
                   <tr>
                     <td>
                       <b>Riwayat Pemeriksaan Gigi:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['pemeriksaan']}}
                     </td>
                   </tr>
                 
               </td> 
                
             </tr>


             <tr>
              <td rowspan="7" style="width: 100px"><b>Kliis Kesehatan Gigi Dan Mulut:</b><br/>
               
                 <tr>
                   <td>
                     <b>Lesi karies/kavita/restorasi :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['lesi']}}
                   </td>
                 </tr>
                 <tr>
                   <td>
                     <b>Gigi hilang karena karies :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['hilang']}}
                   </td>
                 </tr>
                 <tr>
                   <td>
                     <b>Terlihat Plak:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['plak']}}
                   </td>
                 </tr>
                 <tr>
                  <td>
                    <b>Faktor Retensi Makanan:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['faktor']}}
                  </td>
                </tr>
                  <tr>
                   <td>
                     <b>Perawatan Ortodontik:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['ortodontik']}}
                   </td>
                 </tr>
                 <tr>
                  <td>
                    <b>Mulut kering (Xerostomia):</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['asuhan']['xerostomia']}}
                  </td>
                </tr>
               
               
             </td> 
              
           </tr>
               

           <tr>
            <td rowspan="6" style="width: 100px"><b>Hasil Asesmen Resiko Terhadap Karies:</b><br/>
             
               <tr>
                 <td>
                   <b>Ya :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['karies']['iya']}}
                 </td>
               </tr>
               <tr>
                 <td>
                   <b>Tidak :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['karies']['Tidak']}}
                 </td>
               </tr>
               <tr>
                 <td>
                   <b>Beresiko Rendah:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['karies']['beresiko_rendah']}}
                 </td>
               </tr>
               <tr>
                <td>
                  <b>Kecenderungan:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['karies']['kecenderungan']}}
                </td>
              </tr>
               
               <tr>
                <td>
                  <b>Beresiko Tinggi:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['karies']['beresiko_tinggi']}}
                </td>
              </tr>
             
             
           </td> 
            
         </tr>
         <tr>
          <td rowspan="3" style="width: 100px"><b>Riwayat Kesehatan Gigi Sebelumnya:</b><br/>
           
             <tr>
               <td>
                 <b>Dapat Perawatan Sebelumnya :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['dapat_perawatan']['ya']}}
               </td>
             </tr>
             <tr>
               <td>
                 <b>Tidak Mendapat Perawatan Sebelumnya :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['dapat_perawatan']['tidak']}}
               </td>
             </tr>
           
           
         </td> 
          
       </tr>
       <tr>
        <td rowspan="4" style="width: 100px"><b>Berapa Kali menyikat Gigi:</b><br/>
         
           <tr>
             <td>
               <b>1x :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['berapa_kali_menyikat_gigi']['1x']}}
             </td>
           </tr>
           <tr>
             <td>
               <b>2x :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['berapa_kali_menyikat_gigi']['2x']}}
             </td>
           </tr>
           <tr>
            <td>
              <b>Text :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['berapa_kali_menyikat_gigi']['text']}}
            </td>
          </tr>
         
         
       </td> 
        
     </tr>
     <tr>
      <td rowspan="5" style="width: 100px"><b>Kapan Waktu Menyikat Gigi:</b><br/>
       
         <tr>
           <td>
             <b>Saat mandi :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['kapan_waktu_menyikat_gigi']['saat_mandi']}}
           </td>
         </tr>
         <tr>
           <td>
             <b>Setelah Makan :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['kapan_waktu_menyikat_gigi']['setelah_makan']}}
           </td>
         </tr>
         <tr>
          <td>
            <b>Sebelum Tidur :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['kapan_waktu_menyikat_gigi']['sebelum_tidur']}}
          </td>
        </tr>
        <tr>
          <td>
            <b>Text:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['kapan_waktu_menyikat_gigi']['text']}}
          </td>
        </tr>
       
       
     </td> 
      
   </tr>


   <tr>
    <td rowspan="5" style="width: 100px"><b>Bagaimana Cara Menyikat Gigi:</b><br/>
     
       <tr>
         <td>
           <b>Gerakan Memutar :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['cara_menyikat_gigi']['gerakan_memutar']}}
         </td>
       </tr>
       <tr>
         <td>
           <b>Gerakan Maju Mundur :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['cara_menyikat_gigi']['maju_mundur']}}
         </td>
       </tr>
       <tr>
        <td>
          <b>Gerakan Searah Tumbhnya Gigi :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['cara_menyikat_gigi']['gerakan_searah_tumbuhnya_gigi']}}
        </td>
      </tr>
      <tr>
        <td>
          <b>Text:</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['cara_menyikat_gigi']['text']}}
        </td>
      </tr>
     
     
   </td> 
    
 </tr>
 <tr>
  <td rowspan="9" style="width: 100px"><b>Pasien Punya Kebiasaan:</b><br/>
   
     <tr>
       <td>
         <b>Minum Teh :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan']['minum_teh']}}
       </td>
     </tr>
     <tr>
       <td>
         <b>Minum Minuman Beralkohol :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan']['minum_minuman_beralkohol']}}
       </td>
     </tr>
     <tr>
      <td>
        <b>Merokok :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan']['merokok']}}
      </td>
    </tr>
    <tr>
      <td>
        <b>Mengunyah Satu Rahang :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan']['mengunyah_satu_rahang']}}
      </td>
    </tr>
    <tr>
      <td>
        <b>Mengigit Pensil :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan']['mengigit_pensil']}}
      </td>
    </tr>
    <tr>
      <td>
        <b>Bruixsm :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan']['bruixsm']}}
      </td>
    </tr>
    <tr>
      <td>
        <b>Text :</b>{{json_decode(@$item->kondisi_mukosa_oral,true)['pasien_punya_kebiasaan']['text']}}
      </td>
    </tr>
    
   
 </td> 

 <td>
  <span class="pull-right">
    <a  onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/anamnesis/keadaanmukosaoral/'.$unit.'/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus Data" style="color:red"><i class="fa fa-trash"></i></a>
    {{-- <a href="{{url('emr-soap-rawatinap/anamnesis/umum/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp; --}}
  </span> 
 </td>
  
</tr>




                @endforeach
                @endif
                
              </table>
              </div>
              </div> 
          </div>

          {{-- <div class="col-md-6">
            <h5><b>Anamnesa</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>


                <td rowspan="20"  style="width:20%;">Anamnesa</td>
                <td  style="padding: 5px;">
                   
                    Keluhan Utama
                   
                    <td>
                        @if (@$pengeluaran_pervaginam == null)
                        <input type="text" class="form-control" required name="obgyn[pengeluaran_pervaginam]">
                        @else
                        <input type="text" class="form-control" required name="obgyn[pengeluaran_pervaginam]" value="{{ @$pengeluaran_pervaginam }}">
                        @endif
                    </td>
                  
                </td>
                <tr>
                    <td>Riwayat Penyakit Sekarang</td>
                        <td>
                            @if (@$pengeluaran_pervaginam == null)
                            <input type="text" class="form-control" required name="obgyn[pengeluaran_pervaginam]">
                            @else
                            <input type="text" class="form-control" required name="obgyn[pengeluaran_pervaginam]" value="{{ @$pengeluaran_pervaginam }}">
                            @endif
                        </td>
                </tr>
              </tr>
            </table>
          </div>
          <div class="col-md-7">
            <h5><b>Pemeriksaan Fisik</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>


                <td rowspan="20"  style="width:20%;">Pemeriksaan fisik</td>
                <td  style="padding: 5px;">
                   
                    
                   
                   
                        @if (@$pengeluaran_pervaginam == null)
                        <input type="text" class="form-control" required name="obgyn[pengeluaran_pervaginam]">
                        @else
                        <input type="text" class="form-control" required name="obgyn[pengeluaran_pervaginam]" value="{{ @$pengeluaran_pervaginam }}">
                        @endif
                  
                </td>
              </tr>
            </table>
          </div> --}}
    

          
          <div class="col-md-7">
            <h5><b>Hasil Asesmen Risiko Terhadap Karies</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td rowspan="4" style="width: 50%;">Hasil Asesmen :</td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[karies][iya]" value="-" type="hidden" id="flexCheckDefault">
                  <input class="form-check-input"  name="keadaan_mukosa_oral[karies][iya]" value="Iya" type="checkbox" id="flexCheckDefault">
                  Ya
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[karies][Tidak]" value="-" type="hidden" id="flexCheckDefault">
                  <input class="form-check-input"  name="keadaan_mukosa_oral[karies][Tidak]" value="tidak" type="checkbox" id="flexCheckDefault">
                  Tidak
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Beresiko Rendah</td>
                <td>
                  <input name="keadaan_mukosa_oral[karies][beresiko_rendah]" type="text" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Kecenderungan</td>
                <td>
                  <input name="keadaan_mukosa_oral[karies][kecenderungan]" type="text" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Beresiko Tinggi</td>
                <td style="padding: 5px;">
                  <input name="keadaan_mukosa_oral[karies][beresiko_tinggi]" type="text" name="" class="form-control" required>
                </td>
              </tr>
            </table>
          </div>



          <div class="col-md-7">
            <h5><b>Riwayat Kesehatan Gigi Saat Ini</b></h5>
            <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 645px; height: 150px; padding-bottom: 10px;">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td rowspan="2">TGL</td>
                <td rowspan="2">GIGI</td>
                <td class="text-center" colspan="11">Skala Nyeri</td>
              </tr>
              <tr>
                <td>0</td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
              </tr>
              <tr>  
                <td>




                 
                  <input class="form-control" required  name="keadaan_mukosa_oral[skala_nyeri][tgl]" type="text">
                
                </td>
                <td>
                 
                  <input class="form-control" required  name="keadaan_mukosa_oral[skala_nyeri][gigi]" type="text">
                
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][0]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                  
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][0]" type="checkbox" value="0" id="flexCheckDefault" >
               
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][1]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][1]" type="checkbox" value="1" id="flexCheckDefault" >
                
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][2]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][2]" type="checkbox" value="2" id="flexCheckDefault" >
                
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][3]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][3]" type="checkbox" value="3" id="flexCheckDefault" >
                 
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][4]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                  
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][4]" type="checkbox" value="4" id="flexCheckDefault" >
                
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][5]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][5]" type="checkbox" value="5" id="flexCheckDefault" >
               
                </td>
                <td>
                  
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][6]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][6]" type="checkbox" value="6" id="flexCheckDefault" >
               
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][7]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][7]" type="checkbox" value="7" id="flexCheckDefault" >
               
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][8]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][8]" type="checkbox" value="8" id="flexCheckDefault" >
                 
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][9]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][9]" type="checkbox" value="9" id="flexCheckDefault" >
                 
                </td>
                <td>
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][10]" type="hidden" value="tidak_ada" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[skala_nyeri][10]" type="checkbox" value="10" id="flexCheckDefault" >
                 
                </td>
               
              </tr>
            </table>
            
          </div>







          <div class="col-md-7">
            <h5><b>Riwayat Kesehatan Gigi Sebelumnya</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>


                <td rowspan="2"  style="width:50%;">Apakah Sebelumnya Pasien Pernah Mendapatkan Perawatan Gigi?</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[dapat_perawatan][ya]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[dapat_perawatan][ya]" type="checkbox" value="ya" id="flexCheckDefault" >
                   
                   Ya
                  </label>
                </td>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[dapat_perawatan][tidak]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[dapat_perawatan][tidak]" type="checkbox" value="tidak" id="flexCheckDefault" >
                  
                   Tidak
                  </label>
                </td>
               </tr>
              </tr>




              <tr>
                <td rowspan="3"  style="width:50%;">Berapa Kali Menyikat Gigi?</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[berapa_kali_menyikat_gigi][1x]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[berapa_kali_menyikat_gigi][1x]" type="checkbox" value="1x" id="flexCheckDefault" >
                    
                   1x
                  </label>
                </td>
                <tr>
                  <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[berapa_kali_menyikat_gigi][2x]" type="hidden" value="-" id="flexCheckDefault">
                    
                    <input class="form-check-input"  name="keadaan_mukosa_oral[berapa_kali_menyikat_gigi][2x]" type="checkbox" value="2x" id="flexCheckDefault" >
                   
                   2x
                  </label>
                  </td>
               </tr>
               <tr>
                <td  style="padding: 5px;">
                  
                  <input class="form-control" required  name="keadaan_mukosa_oral[berapa_kali_menyikat_gigi][text]" type="text">
                 
                </td>
               </tr>
              </tr>


              <tr>
                <td rowspan="4"  style="width:50%;">Kapan Waktu Menyikat Gigi ?</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[kapan_waktu_menyikat_gigi][saat_mandi]" type="hidden" value="0" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[kapan_waktu_menyikat_gigi][saat_mandi]" type="checkbox" value="1" id="flexCheckDefault" >
                    
                   Saat Mandi
                  </label>
                </td>
                <tr>
                  <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[kapan_waktu_menyikat_gigi][setelah_makan]" type="hidden" value="0" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[kapan_waktu_menyikat_gigi][setelah_makan]" type="checkbox" value="1" id="flexCheckDefault" >
                
                   Setelah Makan
                  </label>
                  </td>
               </tr>
               <tr>
                <td  style="padding: 5px;">
                <label class="form-check-label" for="flexCheckDefault">
                  <input class="form-check-input"  name="keadaan_mukosa_oral[kapan_waktu_menyikat_gigi][sebelum_tidur]" type="hidden" value="0" id="flexCheckDefault">
                
                  <input class="form-check-input"  name="keadaan_mukosa_oral[kapan_waktu_menyikat_gigi][sebelum_tidur]" type="checkbox" value="1" id="flexCheckDefault" >
               
                 Sebelum Tidur
                </label>
                </td>
             </tr>
               <tr>
                <td  style="padding: 5px;">
                 
                  <input class="form-control" required  name="keadaan_mukosa_oral[kapan_waktu_menyikat_gigi][text]" type="text">
                 
                </td>
                </tr>
              </tr>
              <tr>
                <td rowspan="4"  style="width:50%;">Bagaimana Gerakan Cara Menyikat Gigi Yang Di Lakukan</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[cara_menyikat_gigi][gerakan_searah_tumbuhnya_gigi]" type="hidden" value="0" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[cara_menyikat_gigi][gerakan_searah_tumbuhnya_gigi]" type="checkbox" value="1" id="flexCheckDefault" >
                   
                   Gerakan searah tumbuhnya gigi
                  </label>
                </td>
                <tr>
                  <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[cara_menyikat_gigi][maju_mundur]" type="hidden" value="0" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[cara_menyikat_gigi][maju_mundur]" type="checkbox" value="1" id="flexCheckDefault" >
                 
                    Gerakan maju mundur
                  </label>
                  </td>
               </tr>
               <tr>
                <td  style="padding: 5px;">
                <label class="form-check-label" for="flexCheckDefault">
                  <input class="form-check-input"  name="keadaan_mukosa_oral[cara_menyikat_gigi][gerakan_memutar]" type="hidden" value="0" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[cara_menyikat_gigi][gerakan_memutar]" type="checkbox" value="1" id="flexCheckDefault">
                
                  Gerakan Memutar
                </label>
                </td>
             </tr>
               <tr>
                <td  style="padding: 5px;">
                 
                  <input class="form-control" required  name="keadaan_mukosa_oral[cara_menyikat_gigi][text]" type="text">
                 
                </td>
                </tr>
              </tr>



              <tr>
                <td rowspan="7"  style="width:50%;">Pasien Mempunyai Kebiasaan?</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][minum_teh]" type="hidden" value="0" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][minum_teh]" type="checkbox" value="1" id="flexCheckDefault">
                   
                   Minum Teh
                  </label>
                </td>
                <tr>
                  <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][minum_minuman_beralkohol]" type="hidden" value="0" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][minum_minuman_beralkohol]" type="checkbox" value="1" id="flexCheckDefault">

                    Minum minuman Beralkohol
                  </label>
                  </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                <label class="form-check-label" for="flexCheckDefault">
                  <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][merokok]" type="hidden" value="0" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][merokok]" type="checkbox" value="1" id="flexCheckDefault">
                
                Merokok
                </label>
                </td>
                </tr>

                <tr>
                  <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][mengunyah_satu_rahang]" type="hidden" value="0" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][mengunyah_satu_rahang]" type="checkbox" value="1" id="flexCheckDefault">
                 
                  Mengunyah 1 sisi rahang
                  </label>
                  </td>
               </tr>
               <tr>
                <td  style="padding: 5px;">
                <label class="form-check-label" for="flexCheckDefault">
                  <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][mengigit_pensil]" type="hidden" value="0" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][mengigit_pensil]" type="checkbox" value="1" id="flexCheckDefault">
                
                Mengigit Pensil
                </label>
                </td>
             </tr>
             <tr>
              <td  style="padding: 5px;">
              <label class="form-check-label" for="flexCheckDefault">
                <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][bruixsm]" type="hidden" value="0" id="flexCheckDefault">
              
                <input class="form-check-input"  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][bruixsm]" type="checkbox" value="1" id="flexCheckDefault">
              
              Bruxism
              </label>
              </td>
           </tr>
                
               <tr>
                <td  style="padding: 5px;">
                  
                  <input class="form-control" required  name="keadaan_mukosa_oral[pasien_punya_kebiasaan][text]" type="text">
                
                </td>
                </tr>
              </tr>






            </table>
          </div>

          <div class="col-md-7">
            <h5><b>Keadaan Mukosa Oral</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>


                <input type="hidden" name="id" value="{{ @$riwayat_id }}">


                <td rowspan="6"  style="width:20%;">Keadaan Mukosa Oral</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[bau_nafas]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[bau_nafas]" type="checkbox" value="Bau Nafas" id="flexCheckDefault">
                    
                   
                    Bau Nafas / Gangguan Pencernaasn / RR normal
                  </label>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[pendarahan]" type="hidden" value="-" id="flexCheckDefault">
                      
                        <input class="form-check-input"  name="keadaan_mukosa_oral[pendarahan]" type="checkbox" value="Pendarahan" id="flexCheckDefault">
                       
                        Pendarahan Akibat Kerusakan Membran Mukosa Oral / Risiko Kekurangan Volume Darah
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[nyeri]" type="hidden" value="-" id="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[nyeri]" type="checkbox" value="Nyeri" id="flexCheckDefault">
                        
                        Nyeri
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[kondisi_dehidrasi]" type="hidden" value="-" id="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[kondisi_dehidrasi]" type="checkbox" value="Kondisi Dehidrasi Akibat Intake Cairan Yang Kurang" id="flexCheckDefault">
                       
                        Kondisi Dehidrasi Akibat Intake Cairan Yang Kurang
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[peradangan]" type="hidden" value="-" id="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[peradangan]" type="checkbox" value=" Peradangan Mukosa Oral / Bibir Pecah-pecah / Rasa Kering / Sensasi Rasa Luka / Hipersalivasi / Perubahan Kulit Mukosa Oral / Tampak Bengkak / Hiperemi (Kemerahan)" id="flexCheckDefault">
                       
                        Peradangan Mukosa Oral / Bibir Pecah-pecah / Rasa Kering / Sensasi Rasa Luka / Hipersalivasi / Perubahan Kulit Mukosa Oral / Tampak Bengkak / Hiperemi (Kemerahan)
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[kondisi_fisik]" type="hidden" value="-" id="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[kondisi_fisik]" type="checkbox" value=" Kondisi Fisik Yang Lemah Sebagai Akibat Intake Nutrisi Yang Kurang" id="flexCheckDefault">
                       
                        Kondisi Fisik Yang Lemah Sebagai Akibat Intake Nutrisi Yang Kurang
                      </label>
                    </td>
                  </tr>
                  
                </td>
              </tr>
            </table>
          </div>



          <div class="col-md-7">
            <h5><b>Diagnosa Keperawatan Gigi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][KME]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][KME]" type="checkbox" value="KME/KMD/KMP" id="flexCheckDefault" >
                   
                   KME/KMD/KMP
                  </label>
                </td>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][nyeri]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][nyeri]" type="checkbox" value="Nyeri" id="flexCheckDefault" >
                  
                    Nyeri
                  </label>
                </td>
                </tr>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi]kurang_pengetahuan]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi]kurang_pengetahuan]" type="checkbox" value="Kurang Pengetahuan Tentang Kesehatan Gigi Dan Mulut " id="flexCheckDefault" >
                  
                    Kurang Pengetahuan Tentang GIGI dan MULUT 
                  </label>
                </td>
                </tr>
                <tr>
                  <td  style="padding: 5px;">
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][gangguan_pengunyahan]" type="hidden" value="-" id="flexCheckDefault">
                     
                      <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][gangguan_pengunyahan]" type="checkbox" value="Gangguan Pengunyahan & Menelan" id="flexCheckDefault" >
                    
                      Gangguan Pengunyahan & Menelan
                    </label>
                  </td>
                  </tr>
                  <tr>
                    <td  style="padding: 5px;">
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][risiko_terjadi_pendarahan]" type="hidden" value="-" id="flexCheckDefault">
                       
                        <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][risiko_terjadi_pendarahan]" type="checkbox" value="Risiko Terjadi Pendarahan" id="flexCheckDefault" >
                      
                        Risiko Terjadi Pendarahan
                      </label>
                    </td>
                    </tr>
                    <tr>
                      <td  style="padding: 5px;">
                        <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][gangguan_psikologis]" type="hidden" value="-" id="flexCheckDefault">
                         
                          <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][gangguan_psikologis]" type="checkbox" value="Gangguan Psikologis" id="flexCheckDefault" >
                        
                          Gangguan Psikologis
                        </label>
                      </td>
                      </tr>
                      <tr>
                        <td  style="padding: 5px;">
                          <label class="form-check-label" for="flexCheckDefault">
                            <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][infeksi]" type="hidden" value="-" id="flexCheckDefault">
                           
                            <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][infeksi]" type="checkbox" value="Infeksi" id="flexCheckDefault" >
                          
                            Infeksi
                          </label>
                        </td>
                        </tr>
                        <tr>
                          <td  style="padding: 5px;">
                            <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][Risiko Injury]" type="hidden" value="-" id="flexCheckDefault">
                             
                              <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][Risiko Injury]" type="checkbox" value="Risiko Injury" id="flexCheckDefault" >
                            
                              Risiko Injury
                            </label>
                          </td>
                          </tr>
              </tr>






            </table>
          </div>


          <div class="col-md-7">
            <h5><b>Kemungkinan Penyebab</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][perilaku]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][perilaku]" type="checkbox" value="Perilaku Kesehatan Gigi Dan Mulut" id="flexCheckDefault" >
                   
                   Perilaku Kesehatan Gigi Dan Mulut
                  </label>
                </td>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][trauma]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][trauma]" type="checkbox" value="Trauma" id="flexCheckDefault" >
                  
                    Trauma
                  </label>
                </td>
                </tr>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][gangguan_sistematik]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][gangguan_sistematik]" type="checkbox" value="Gangguan Sistematik" id="flexCheckDefault" >
                  
                   Gangguan Sistematik
                  </label>
                </td>
                </tr>
                <tr>
                  <td  style="padding: 5px;">
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][genetika]" type="hidden" value="-" id="flexCheckDefault">
                     
                      <input class="form-check-input"  name="keadaan_mukosa_oral[diagnosa_keperawatan_gigi][genetika]" type="checkbox" value="Genetika" id="flexCheckDefault" >
                    
                      Genetika
                    </label>
                  </td>
                  </tr>
              </tr>






            </table>
          </div>



          <div class="col-md-7">
            <h5><b>Implementasi & Evaluasi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>


                <td rowspan="4"  style="width:50%;">Kolaborasi</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][KGA]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][KGA]" type="checkbox" value="KGA" id="flexCheckDefault" >
                   
                   KGA
                  </label>
                </td>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][KG]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][KG]" type="checkbox" value="KG" id="flexCheckDefault" >
                  
                   KG
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][ortho]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][ortho]" type="checkbox" value="Ortho" id="flexCheckDefault" >
                  
                   Ortho
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][BM]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][BM]" type="checkbox" value="BM" id="flexCheckDefault" >
                  
                   BM
                  </label>
                </td>
               </tr>
              </tr>



              <tr>


                <td rowspan="5"  style="width:50%;">Intervensi</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][preventif]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][preventif]" type="checkbox" value="Preventif Perawatan Gigi" id="flexCheckDefault" >
                   
                   Preventif Perawatan Gigi
                  </label>
                </td>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][debridement]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][debridement]" type="checkbox" value="Debridement" id="flexCheckDefault" >
                  
                   Debridement
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][irigasi]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][irigasi]" type="checkbox" value="Irigasi" id="flexCheckDefault" >
                  
                   Irigasi
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][perawatan_luka]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][perawatan_luka]" type="checkbox" value="perawatan_luka" id="flexCheckDefault" >
                  
                   perawatan_luka
                  </label>
                </td>
               </tr>


               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][buka_jahitan]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][buka_jahitan]" type="checkbox" value="Buka Jahitan" id="flexCheckDefault" >
                  
                   Buka Jahitan
                  </label>
                </td>
               </tr>





              </tr>




              <tr>


                <td rowspan="5"  style="width:50%;">Konseling Perawatan Gigi</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_higiene]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_higiene]" type="checkbox" value="Penkes Higiene Rongga Mulut" id="flexCheckDefault" >
                   
                   Penkes Higiene Rongga Mulut
                  </label>
                </td>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkses_selama_perawatan]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkses_selama_perawatan]" type="checkbox" value="Penkes Perawatan Gigi di rumah" id="flexCheckDefault" >
                  
                   Penkes Perawatan Gigi di rumah
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_diet]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_diet]" type="checkbox" value="Penkes Diet dan Nutrisi" id="flexCheckDefault" >
                  
                   Penkes Diet dan Nutrisi
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_pra_operasi]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_pra_operasi]" type="checkbox" value="Penkes Pra Operasi" id="flexCheckDefault" >
                  
                   Penkes Pra Operasi
                  </label>
                </td>
               </tr>


               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_pasca_operasi]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_pasca_operasi]" type="checkbox" value="Penkes Pasca Operasi" id="flexCheckDefault" >
                  
                   Penkes Pasca Operasi
                  </label>
                </td>
               </tr>





              </tr>






              <tr>


                <td rowspan="6"  style="width:50%;">Evaluasi</td>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][ohis]" type="hidden" value="-" id="flexCheckDefault">
                  
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][ohis]" type="checkbox" value="OHIS" id="flexCheckDefault" >
                   
                   OHIS
                  </label>
                </td>
                <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_gigi_dan_mulut]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_gigi_dan_mulut]" type="checkbox" value="Penkes Gigi dan Mulut" id="flexCheckDefault" >
                  
                   Penkes Gigi dan Mulut
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][perawatan_klinis]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][perawatan_klinis]" type="checkbox" value="Perawatan Klinis" id="flexCheckDefault" >
                  
                   Perawatan Klinis
                  </label>
                </td>
               </tr>

               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][nyeri]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][nyeri]" type="checkbox" value="Nyeri" id="flexCheckDefault" >
                  
                   Nyeri
                  </label>
                </td>
               </tr>


               <tr>
                <td  style="padding: 5px;">
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_pasca_operasi]" type="hidden" value="-" id="flexCheckDefault">
                   
                    <input class="form-check-input"  name="keadaan_mukosa_oral[implementasi_evaluasi][penkes_pasca_operasi]" type="checkbox" value="Penkes Pasca Operasi" id="flexCheckDefault" >
                  
                   Penkes Pasca Operasi
                  </label>
                </td>
               </tr>





              </tr>





















              </tr>
            </table>
          </div>



          



          

          <div class="col-md-7">
            <h5><b>Asuhan Keperawatan</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td rowspan="5">Riwayat Kesehatan</td>
                <td style="padding: 5px;">Penyakit Sistemik</td>
                <td>
                  <input type="text" name="keadaan_mukosa_oral[asuhan][sistemik]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Kebutuhan Khusus</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][khusus]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Penggunaan Obat</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][obat]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Konsumsi Miras/Narkoba</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][konsumsi]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Riwayat Alergi</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][alergi]" class="form-control" required>
                </td>
              </tr>

              <tr>
                <td rowspan="3">Kesehatan Gigi Dan Mulut</td>
                <td style="padding: 5px;">Konsumsi Minuman Manis</td>
                <td>
                  <input type="text" name="keadaan_mukosa_oral[asuhan][minum]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Remineralisasi Gigi</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][Remineralisasi]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Riwayat Pemeriksaan Gigi</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][pemeriksaan]" class="form-control" required>
                </td>
              </tr>
              

              <tr>
                <td rowspan="6">Klinis Kesehatan Gigi Dan Mulut</td>
                <td style="padding: 5px;">Lesi karies/kavita/restorasi</td>
                <td>
                  <input type="text" name="keadaan_mukosa_oral[asuhan][lesi]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Gigi hilang karena karies</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][hilang]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Terlihat Plak</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][plak]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Faktor retensi makanan</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][faktor]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Perawatan ortodontik</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][ortodontik]" class="form-control" required>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Mulut kering (Xerostomia)</td>
                <td>
                    <input type="text" name="keadaan_mukosa_oral[asuhan][xerostomia]" class="form-control" required>
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