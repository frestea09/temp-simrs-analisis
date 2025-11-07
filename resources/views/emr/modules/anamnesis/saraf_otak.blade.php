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
            <h5><b>Saraf Otak</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td rowspan="1">N.I</td>
                <td>Penciuman</td>
                <td>
                    <input type="text" required name="generalis[penciuman]" class="form-control">
                </td>
              </tr>
        
              


              <tr>
                <td rowspan="3">N.II</td>
                <td>Ketajaman Penglihatan</td>
                <td>
                    <input type="text" required name="generalis[ketajaman_penglihatan]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Campus</td>
                <td>
                    <input type="text" required name="generalis[campus]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Fondus Oculi</td>
                <td>
                    <input type="text" required name="generalis[fondus_oculi]" class="form-control">
                </td>
              </tr>



              <tr>
                <td rowspan="7">N.III/IV/VI</td>
                <td>Ptosis</td>
                <td>
                    <input type="text" required name="generalis[ptosis]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Pupil</td>
                <td>
                    <input type="text" required name="generalis[pupil]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Refleks Cahaya (D/I)</td>
                <td>
                    <input type="text" required name="generalis[reflek_cahaya]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Refleks Konvergensi</td>
                <td>
                    <input type="text" required name="generalis[reflek_konvergensi]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Posisi Mata</td>
                <td>
                    <input type="text" required name="generalis[posisi_mata]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Gerakan Bola Mata</td>
                <td>
                    <input type="text" required name="generalis[gerakan_bola_mata]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Nystagmus</td>
                <td>
                    <input type="text" required name="generalis[nystagmus]" class="form-control">
                </td>
              </tr>




              <tr>
                <td rowspan="5">N.V</td>
                <td>Sensorik</td>
                <td>
                    <input type="text" required name="generalis[sensorik]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Oftalmikus</td>
                <td>
                    <input type="text" required name="generalis[oftalmikus]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Maksilaris</td>
                <td>
                    <input type="text" required name="generalis[maksilaris]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Mandibularis</td>
                <td>
                    <input type="text" required name="generalis[mandibularis]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Motorik</td>
                <td>
                    <input type="text" required name="generalis[motorik]" class="form-control">
                </td>
              </tr>

              
              <tr>
                <td rowspan="4">N.VII</td>
                <td>Gerakan Wajah</td>
                <td>
                    <input type="text" required name="generalis[gerakan_wajah]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Plicanasolabialis</td>
                <td>
                    <input type="text" required name="generalis[plicanasolabialis]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Angkat Alis Mata</td>
                <td>
                    <input type="text" required name="generalis[angkat_alis_mata]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Memejamkan Mata</td>
                <td>
                    <input type="text" required name="generalis[memejamkan_mata]" class="form-control">
                </td>
              </tr>




              <tr>
                <td rowspan="3">N.VIII</td>
                <td>Rasa Kecap 2/3 Bagian Muka Lidah</td>
                <td>
                    <input type="text" required name="generalis[rasa_kecap]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Pendengaran</td>
                <td>
                    <input type="text" required name="generalis[pendengaran]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Keseimbangan</td>
                <td>
                    <input type="text" required name="generalis[keseimbangan]" class="form-control">
                </td>
              </tr>




              <tr>
                <td rowspan="3">N.IX/X</td>
                <td>Suara</td>
                <td>
                    <input type="text" required name="generalis[suara]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Menelan</td>
                <td>
                    <input type="text" required name="generalis[menelan]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Gerakan Palatum Dan Uvula</td>
                <td>
                    <input type="text" required name="generalis[gerakan_palatum_uvula]" class="form-control">
                </td>
              </tr>




              <tr>
                <td rowspan="2">N.XI</td>
                <td>Angkat Bahu</td>
                <td>
                    <input type="text" required name="generalis[angkat_bahu]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Menengok Kanan Dan Kiri</td>
                <td>
                    <input type="text" required name="generalis[menengok]" class="form-control">
                </td>
              </tr>
            

              <tr>
                <td rowspan="3">N.XII</td>
                <td>Gerakan Lidah</td>
                <td>
                    <input type="text" required name="generalis[gerakan_lidah]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Atrofi</td>
                <td>
                    <input type="text" required name="generalis[atrofi]" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Tremor / Fasikulasi</td>
                <td>
                    <input type="text" required name="generalis[tremor]" class="form-control">
                </td>
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
                    <td rowspan="1" style="width: 100px"><b>N.I :</b><br/>
                      <tr>
                        <td>
                           <b>Penciuman : </b>{{json_decode(@$item->riwayat,true)['penciuman']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                 <tr>
                    <td rowspan="3" style="width: 100px"><b>N.II :</b><br/>
                      <tr>
                        <td>
                           <b>Ketajaman Penglihatan : </b>{{json_decode(@$item->riwayat,true)['ketajaman_penglihatan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Campus : </b>{{json_decode(@$item->riwayat,true)['campus']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Fondus Oculi : </b>{{json_decode(@$item->riwayat,true)['fondus_oculi']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>

                
                 <tr>
                    <td rowspan="7" style="width: 100px"><b>N.III/IV/VI :</b><br/>
                      <tr>
                        <td>
                           <b>Ptotis : </b>{{json_decode(@$item->riwayat,true)['ptosis']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Pupil : </b>{{json_decode(@$item->riwayat,true)['pupil']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Refleks Cahaya (D/I) : </b>{{json_decode(@$item->riwayat,true)['reflek_cahaya']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                          <b>Refleks Konvergensi : </b>{{json_decode(@$item->riwayat,true)['reflek_konvergensi']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Posisi Mata : </b>{{json_decode(@$item->riwayat,true)['posisi_mata']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Gerakan Bola Mata : </b>{{json_decode(@$item->riwayat,true)['gerakan_bola_mata']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Nytagmus : </b>{{json_decode(@$item->riwayat,true)['nystagmus']}}
                        </td>
                      </tr>
                    </td>   
                 </tr>
                


                 
                 <tr>
                    <td rowspan="5" style="width: 100px"><b>N.V :</b><br/>
                      <tr>
                        <td>
                           <b>Sensorik : </b>{{json_decode(@$item->riwayat,true)['sensorik']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>oftalmikus : </b>{{json_decode(@$item->riwayat,true)['oftalmikus']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Maksilaris : </b>{{json_decode(@$item->riwayat,true)['maksilaris']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                          <b>Mandibularis : </b>{{json_decode(@$item->riwayat,true)['mandibularis']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Motorik : </b>{{json_decode(@$item->riwayat,true)['motorik']}}
                        </td>
                      </tr>
                    </td>   
                 </tr>
                

                 <tr>
                    <td rowspan="4" style="width: 100px"><b>N.VII :</b><br/>
                      <tr>
                        <td>
                           <b>Gerakan Wajah : </b>{{json_decode(@$item->riwayat,true)['gerakan_wajah']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Plicanasolabialis : </b>{{json_decode(@$item->riwayat,true)['plicanasolabialis']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Angkat Alis Mata : </b>{{json_decode(@$item->riwayat,true)['angkat_alis_mata']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                          <b>Memejamkan Mata : </b>{{json_decode(@$item->riwayat,true)['memejamkan_mata']}}
                        </td>
                      </tr>
                    </td>   
                 </tr>



                 <tr>
                    <td rowspan="3" style="width: 100px"><b>N.VIII :</b><br/>
                      <tr>
                        <td>
                           <b>Rasa Kecap 2/3 Bagian Muka Lidah : </b>{{json_decode(@$item->riwayat,true)['rasa_kecap']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Pendengaran : </b>{{json_decode(@$item->riwayat,true)['pendengaran']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Keseimbangan : </b>{{json_decode(@$item->riwayat,true)['keseimbangan']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>




                 <tr>
                    <td rowspan="3" style="width: 100px"><b>N.IX/X :</b><br/>
                      <tr>
                        <td>
                           <b>Suara : </b>{{json_decode(@$item->riwayat,true)['suara']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Menelan : </b>{{json_decode(@$item->riwayat,true)['menelan']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Gerakan Palatum & Uvula : </b>{{json_decode(@$item->riwayat,true)['gerakan_palatum_uvula']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>




                 <tr>
                    <td rowspan="2" style="width: 100px"><b>N.XI :</b><br/>
                      <tr>
                        <td>
                           <b>Angkat Bahu : </b>{{json_decode(@$item->riwayat,true)['angkat_bahu']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Menengok Kanan Dan Kiri : </b>{{json_decode(@$item->riwayat,true)['menengok']}}
                         </td>
                       </tr>
                    </td>   
                 </tr>


                 <tr>
                    <td rowspan="3" style="width: 100px"><b>N.XI :</b><br/>
                      <tr>
                        <td>
                           <b>Gerakan Lidah : </b>{{json_decode(@$item->riwayat,true)['gerakan_lidah']}}
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <b>Atrofi : </b>{{json_decode(@$item->riwayat,true)['atrofi']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                          <b>Tremor / Fasikulasi : </b>{{json_decode(@$item->riwayat,true)['tremor']}}
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