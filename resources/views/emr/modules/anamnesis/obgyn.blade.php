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
<h1>Anamnesis - Obgyn</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/obgyn/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
           $pengeluaran_pervaginam = json_decode(@$item->obgyn,true)['pengeluaran_pervaginam'];
           $kelenjar_bartholini = json_decode(@$item->obgyn,true)['kelenjar_bartholini'];
           $inspekulo = json_decode(@$item->obgyn,true)['inspekulo'];
           $tfu = json_decode(@$item->obgyn,true)['tfu'];
           $kontraksi_uterus = json_decode(@$item->obgyn,true)['kontraksi_uterus'];
           $lochea = json_decode(@$item->obgyn,true)['lochea'];
           $luka_perenium = json_decode(@$item->obgyn,true)['luka_perenium'];
           $riwayat_id = @$item->id;
          @endphp

     

           @endforeach
          {{-- @php
               ($riwayat as $item) {
                $bau_nafas = json_decode(@$item->kondisi_mukosa_oral,true)['bau_nafas'];
              }
          @endphp --}}


    


          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Gyncologi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>


                <input type="hidden" name="id" value="{{ @$riwayat_id }}">


                <td rowspan="20"  style="width:20%;">Gyncologi</td>
                <td  style="padding: 5px;">
                   
                    Pengeluaran Pervaginam
                   
                    <td>
                       
                        <input type="text" class="form-control" name="obgyn[pengeluaran_pervaginam]">
                       
                    </td>
                 
                  <tr>
                    <td style="padding: 5px;">
                   
                        Kelenjar Bartholini
                        
                      <td>
                        {{-- <input type="text" class="form-control" name="obgyn[kelenjar_bartholini]"> --}}
                     
                        <input type="text" class="form-control" name="obgyn[kelenjar_bartholini]">
                       
                      </td>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                   
                        Inspekulo
                        
                      <td>
                        {{-- <input type="text" class="form-control" name="obgyn[inspekulo]"> --}}
                        
                        <input type="text" class="form-control" name="obgyn[inspekulo]">
                     
                      </td>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                   
                        Lainnya
                        
                      <td>
                        {{-- <input type="text" class="form-control" name="obgyn[inspekulo]"> --}}
                        
                        <input type="text" class="form-control" name="obgyn[lainya]">
                     
                      </td>
                    </td>
                  </tr>
                  
                </td>
              </tr>
            </table>

            <h5><b>Nifas</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>

                <td rowspan="20"  style="width:20%;">Nifas</td>
                <td  style="padding: 5px;">
                   
                    TFU
                   
                    <td>
                        {{-- <input type="text" class="form-control" name="obgyn[tfu]"> --}}
                      
                        <input type="text" class="form-control" name="obgyn[tfu]">
                       
                    </td>
                 
                  <tr>
                    <td style="padding: 5px;">
                   
                        Kontraksi Uterus
                        
                      <td>
                        {{-- <input type="text" class="form-control" name="obgyn[kontraksi_terus]"> --}}
                        
                        <input type="text" class="form-control" name="obgyn[kontraksi_uterus]">
                       
                      </td>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                   
                        Lochea
                        
                      <td>
                        {{-- <input type="text" class="form-control" name="obgyn[lochea]"> --}}
                       
                        <input type="text" class="form-control" name="obgyn[lochea]">
                     
                      </td>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                   
                        Luka Perenium
                        
                      <td>
                        {{-- <input type="text" class="form-control" name="obgyn[luka_perenium]"> --}}
                     
                        <input type="text" class="form-control" name="obgyn[luka_perenium]">
                       
                      </td>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                   
                        Lainya
                        
                      <td>
                        {{-- <input type="text" class="form-control" name="obgyn[luka_perenium]"> --}}
                     
                        <input type="text" class="form-control" name="obgyn[lainya_2]">
                       
                      </td>
                    </td>
                  </tr>
                  
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
                @else

                @php
                    $i = 1;
                @endphp


                @foreach (@$riwayat as $item)
                  <th>Catatan {{ $i++ }}</th>
                  <tr>
                    <td rowspan="5"> <b>Gyncologi</b> :
                      {{-- @if (isset(json_decode(@$item->obgyn,true)['data']))    
                        @foreach (json_decode(@$item->obgyn,true)['data'] as $key=>$alat)
                            {{@$alat}},
                        @endforeach
                      @endif --}}

                      <tr>
                        <td>
                            pengeluaran pervaginam : {{ json_decode(@$item->obgyn,true)['pengeluaran_pervaginam'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                            Kelenjar Bartholini : {{ json_decode(@$item->obgyn,true)['kelenjar_bartholini'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                            Inspekulo : {{ json_decode(@$item->obgyn,true)['inspekulo'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                            Lainya : {{ json_decode(@$item->obgyn,true)['lainya'] }}
                        </td>
                      </tr>

                      </td>
                  </tr>
                  <tr>
                    <td rowspan="6"> <b>Nifas</b> :
                      {{-- @if (isset(json_decode(@$item->obgyn,true)['data']))    
                        @foreach (json_decode(@$item->obgyn,true)['data'] as $key=>$alat)
                            {{@$alat}},
                        @endforeach
                      @endif --}}

                      <tr>
                        <td>
                            TFU : {{ json_decode(@$item->obgyn,true)['tfu'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                            Kontraksi Uterus : {{ json_decode(@$item->obgyn,true)['kontraksi_uterus'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                            Lochea : {{ json_decode(@$item->obgyn,true)['lochea'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                            Luka Perenium : {{ json_decode(@$item->obgyn,true)['luka_perenium'] }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                            Lainya : {{ json_decode(@$item->obgyn,true)['lainya_2'] }}
                        </td>
                      </tr>

                      </td>
                  </tr>
                  
                @endforeach
                @endif
                
              </table>
              </div>
              </div> 
          </div>

          {{-- Alergi --}}
          {{-- <div class="col-md-6">
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
                @else
                @foreach ($riwayat as $item)
                  <tr>
                    <td> <b>Cacat Tubuh</b> :
                      @if (isset(json_decode($item->cacat_tubuh,true)['data']))
                      @foreach (json_decode($item->cacat_tubuh,true)['data'] as $key=>$alat)
                          {{$alat}},
                      @endforeach
                      @endif
                      &nbsp;|&nbsp;<b>Lainnya:</b> {{json_decode($item->cacat_tubuh,true)['lainnya']}}
                      @foreach (json_decode($item->penggunaan_alat_bantu as $p))
                      @endforeach
                    <br/> 
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                      <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/anamnesis/statusfungsional/'.$unit.'/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
            
                      </span>
                      <tr>
                        <td rowspan="5" style="width: 150px"><b>Keadaan Mukosa Oral</b><br/>
                         
                           <tr>
                             <td>
                               @php
                                     json_decode(@$item->kondisi_mukosa_oral,true)['bau_nafas']
                               @endphp
                                @if ($bau_nafas == null)
                                   {{ @$bau_nafas }}
                                @else    
                                    {{  json_decode(@$item->kondisi_mukosa_oral,true)['bau_nafas'] }}
                                @endif
                               </b>
                             </td>
                           </tr>
                    </td>
                  </tr>
                @endforeach
                @endif
                
              </table>
              </div>
              </div> 
          </div> --}}
          
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