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
<h1>Pemeriksaan Obgyn</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/fisikobgyn/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Pemeriksaan obgyn</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
                <tr>
                    <td rowspan="2">Muka</td>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaanobgyn[cloasma_gravidarum]" type="hidden" value="Tidak" id="flexCheckDefault">
                        <input class="form-check-input"  name="pemeriksaanobgyn[cloasma_gravidarum]" type="checkbox" value="Ada" id="flexCheckDefault">
                        Cloasma Gravidarum
                      </label>
                    </td>
                   <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                       
                        <input class="form-control"  name="pemeriksaanobgyn[lainnya_muka]" type="text" placeholder="Lainnya"  id="flexCheckDefault">
                      </label>
                    </td>
                   </tr>
                </tr>
                <tr>
                  <td rowspan="2">Mata</td>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="pemeriksaanobgyn[konjung_va]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="pemeriksaanobgyn[konjung_va]" type="checkbox" value="Anemis" id="flexCheckDefault">
                      Konjung Va
                    </label>
                  </td>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                     
                      <input class="form-control"  name="pemeriksaanobgyn[lainnya_mata]" type="text" placeholder="Lainnya"  id="flexCheckDefault">
                    </label>
                  </td>
                 </tr>
              </tr>
              <tr>
                <td rowspan="4">Leher</td>
                <td>
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[kelenjar_roid]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[kelenjar_roid]" type="checkbox" value="Ada" id="flexCheckDefault">
                    Kelenjar roid Pembesaran
                  </label>
                </td>
                <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="pemeriksaanobgyn[vena_jugularis]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="pemeriksaanobgyn[vena_jugularis]" type="checkbox" value="Ada" id="flexCheckDefault">
                      Vena Jugularis Peningkatan
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="pemeriksaanobgyn[kgb_pembesaran]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="pemeriksaanobgyn[kgb_pembesaran]" type="checkbox" value="Ada" id="flexCheckDefault">
                     KGB Pembesaran
                    </label>
                  </td>
                 </tr>
               <tr>
                <td>
                  <label class="form-check-label" for="flexCheckDefault">
                   
                    <input class="form-control"  name="pemeriksaanobgyn[lainnya_leher]" type="text" placeholder="Lainnya"  id="flexCheckDefault">
                  </label>
                </td>
               </tr>
            </tr>




            <tr>
              <td rowspan="6">Dada</td>
              <td>
                <label class="form-check-label" for="flexCheckDefault">
                  <input class="form-check-input"  name="pemeriksaanobgyn[payudara]" type="hidden" value="asimetris" id="flexCheckDefault">
                  <input class="form-check-input"  name="pemeriksaanobgyn[payudara]" type="checkbox" value="simetris" id="flexCheckDefault">
                  Payudara (simetris/asimetris)
                </label>
              </td>
              <tr>
                <td>
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[puting_susu]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[puting_susu]" type="checkbox" value="Ada" id="flexCheckDefault">
                    Puting Susu Menonjol
                  </label>
                </td>
               </tr>
               <tr>
                <td>
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[kolostrum]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[kolostrum]" type="checkbox" value="Ada" id="flexCheckDefault">
                   Kolostrum
                  </label>
                </td>
               </tr>
               <tr>
                <td>
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[masa]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[masa]" type="checkbox" value="Ada" id="flexCheckDefault">
                   Masa / Benjolan
                  </label>
                </td>
               </tr>
               <tr>
                <td>
                  <label class="form-check-label" for="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[retraksi]" type="hidden" value="Tidak" id="flexCheckDefault">
                    <input class="form-check-input"  name="pemeriksaanobgyn[retraksi]" type="checkbox" value="Ada" id="flexCheckDefault">
                   Retraksi
                  </label>
                </td>
               </tr>
             <tr>
              <td>
                <label class="form-check-label" for="flexCheckDefault">
                 
                  <input class="form-control"  name="pemeriksaanobgyn[lainnya_dada]" type="text" placeholder="Lainnya"  id="flexCheckDefault">
                </label>
              </td>
             </tr>
          </tr>





          <tr>
            <td rowspan="6">Ekstremitas atas dan bawah</td>
            <td>
              <label class="form-check-label" for="flexCheckDefault">
                <input class="form-check-input"  name="pemeriksaanobgyn[oedem]" type="hidden" value="Tidak" id="flexCheckDefault">
                <input class="form-check-input"  name="pemeriksaanobgyn[oedem]" type="checkbox" value="Anemis" id="flexCheckDefault">
               Oedem
              </label>
            </td>

            <tr>
              <td>
                <label class="form-check-label" for="flexCheckDefault">
                  <input class="form-check-input"  name="pemeriksaanobgyn[kekuatan_otot]" type="hidden" value="Tidak" id="flexCheckDefault">
                  <input class="form-check-input"  name="pemeriksaanobgyn[kekuatan_otot]" type="checkbox" value="Normal" id="flexCheckDefault">
                 Kekuatan Otot dan Sendi
                </label>
              </td>
             </tr>
             <tr>
              <td>
                <label class="form-check-label" for="flexCheckDefault">
                  <input class="form-check-input"  name="pemeriksaanobgyn[varices]" type="hidden" value="Tidak" id="flexCheckDefault">
                  <input class="form-check-input"  name="pemeriksaanobgyn[varices]" type="checkbox" value="Ada" id="flexCheckDefault">
                 varices
                </label>
              </td>
             </tr>
             <tr>
              <td>
                Reflek
              </td>
             <tr>
               <td>
               
                  <input class="form-check-input"  name="pemeriksaanobgyn[reflek]" type="hidden" value="Tidak" id="flexCheckDefault">
                  <input class="form-check-input"  name="pemeriksaanobgyn[reflek]" type="checkbox" value="Normal" id="flexCheckDefault"><b> Normal,</b>
                  <input class="form-check-input"  name="pemeriksaanobgyn[reflek]" type="checkbox" value="Hyper" id="flexCheckDefault"> <b>Hyper,</b>
                  <input class="form-check-input"  name="pemeriksaanobgyn[reflek]" type="checkbox" value="Hipo" id="flexCheckDefault"> <b>Hipo.</b>

             
              </td>
             </tr>
             </tr>


           <tr>
            <td>
              <label class="form-check-label" for="flexCheckDefault">
              
                <input class="form-control"  name="pemeriksaanobgyn[lainnya_ekstremitas]" type="text" placeholder="Lainnya"  id="flexCheckDefault">
              </label>
            </td>
           </tr>
        </tr>



        <tr>
          <td rowspan="3">Abdomen</td>
          <td>
            <label class="form-check-label" for="flexCheckDefault">
              <input class="form-check-input"  name="pemeriksaanobgyn[striae_gravidarum]" type="hidden" value="Tidak" id="flexCheckDefault">
              <input class="form-check-input"  name="pemeriksaanobgyn[striae_gravidarum]" type="checkbox" value="Ya" id="flexCheckDefault">
             Striae Gravidarum
            </label>
          </td>

          <tr>
            <td>
              <label class="form-check-label" for="flexCheckDefault">
                <input class="form-check-input"  name="pemeriksaanobgyn[bekas_luka]" type="hidden" value="Tidak" id="flexCheckDefault">
                <input class="form-check-input"  name="pemeriksaanobgyn[bekas_luka]" type="checkbox" value="Ya" id="flexCheckDefault">
               Bekas Luka Operasi
              </label>
            </td>
           </tr>
           <tr>
            <td>
                <input type="text" name="pemeriksaanobgyn[TFU]" id="" placeholder="TFU" class="form-control">
            </td>
           </tr>
      </tr>



      <tr>
        <td rowspan="7">Palpasi</td>
        <td>
          <input type="text" class="form-control" placeholder="Leopold I" name="pemeriksaanobgyn[leopold_1]">
        </td>
        <tr>
          <td>
            <input type="text" class="form-control" placeholder="Leopold II" name="pemeriksaanobgyn[leopold_2]">
          </td>
        </tr>
        <tr>
          <td>
            <input type="text" class="form-control" placeholder="Leopold III" name="pemeriksaanobgyn[leopold_3]">
          </td>
        </tr>
        <tr>
          <td>
            <input type="text" class="form-control" placeholder="Leopold IV" name="pemeriksaanobgyn[leopold_4]">
          </td>
        </tr>
        <tr>
          <td>
            <input type="text" class="form-control" placeholder="HIS" name="pemeriksaanobgyn[his]">
          </td>
        </tr>
        <tr>
          
          <td>
            <input class="form-check-input"  name="pemeriksaanobgyn[intensitas]" type="hidden" value="Tidak" id="flexCheckDefault">
            <input class="form-check-input"  name="pemeriksaanobgyn[intensitas]" type="checkbox" value="Ya" id="flexCheckDefault">
            Intensitas (Kuat)
          </td>
        </tr>
        <tr>
          <td>
            <input type="text" class="form-control" placeholder="Durasi" name="pemeriksaanobgyn[durasi_palpasi]">
          </td>
        </tr>
      </tr>

      <tr>
        <td rowspan="2">Auskultasi</td>
        <td>
          <input type="text" class="form-control" placeholder="DJJ    (regullar / iregullar)" name="pemeriksaanobgyn[djj]">
        </td>
        <tr>
          <td>
            <input type="text" class="form-control" placeholder="TBJA  (gr)" name="pemeriksaanobgyn[tbja]">
          </td>
        </tr>










            </table>
          </div>
          




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
                @foreach (@$riwayat as $item)
                  <tr>
                    <td>Muka</td>
                    <td> 
                      <b>Cloasma Gravidarum :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['cloasma_gravidarum']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['lainnya_muka']}}<br/>
                    </td>
                   </tr>
                   <tr>
                    <td>Mata</td>
                    <td> 
                      <b>Konjung Va :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['konjung_va']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['lainnya_mata']}}<br/>
                    </td>
                   </tr>
                   <tr>
                    <td>Leher</td>
                    <td> 
                      <b>Kelenjar Roid :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['kelenjar_roid']}}<br/>
                      <b>Vena Jugularis Peningkatan :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['vena_jugularis']}}<br/>
                      <b>KGB Pembesaran :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['kgb_pembesaran']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['lainnya_leher']}}<br/>
                    </td>
                   </tr>
                   <tr>
                    <td>Dada</td>
                    <td> 
                      <b>Payudara (simetris/asimetris) :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['payudara']}}<br/>
                      <b>Puting Susu Menonjol :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['puting_susu']}}<br/>
                      <b>Kolostrum :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['kolostrum']}}<br/>
                      <b>Masa / Benjolan :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['masa']}}<br/>
                      <b>Retraksi :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['retraksi']}}<br/>
                      <b>lainnya_dada :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['lainnya_dada']}}<br/>
                    </td> 
                   </tr>
                   <tr>
                    <td>Ekstremitas atas dan bawah</td>
                    <td> 
                      <b>oedem :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['oedem']}}<br/>
                      <b>Kekuatan Otot dan Sendi :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['kekuatan_otot']}}<br/>
                      <b>Varices :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['varices']}}<br/>
                      <b>Reflek :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['reflek']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['lainnya_ekstremitas']}}<br/>
                    </td> 
                   </tr>
                   <tr>
                    <td>Abdomen</td>
                    <td> 
                      <b>Striae Gravidarum :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['striae_gravidarum']}}<br/>
                      <b>Bekas Luka Operasi :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['bekas_luka']}}<br/>
                      <b>TFU :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['TFU']}}<br/>
                    </td> 
                   </tr>
                   <tr>
                    <td>Palpasi</td>
                    <td> 
                      <b>Leopold I :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['leopold_1']}}<br/>
                      <b>Leopold II :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['leopold_2']}}<br/>
                      <b>Leopold III :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['leopold_3']}}<br/>
                      <b>Leopold IV :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['leopold_4']}}<br/>
                      <b>HIS :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['his']}}<br/>
                    </td> 
                   </tr>
                   <tr>
                    <td>Auskultasi</td>
                    <td> 
                      <b>DJJ :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['djj']}}<br/>
                      <b>TBJA :</b> {{json_decode(@$item->pemeriksaanobgyn,true)['tbja']}}<br/>
                    </td> 
                   </tr>
                   
                @endforeach
              </table>
              </div>
              </div> 
          </div>

          <br/><br/>
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