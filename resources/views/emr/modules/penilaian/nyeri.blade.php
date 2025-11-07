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
<h1>Penilaian - Nyeri</h1>
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
    <form method="POST" action="{{ url('emr-soap/penilaian/nyeri/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Nyeri</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:40%;">
                  Nyeri: &nbsp;&nbsp;&nbsp; <input type="radio" value="Ya" name="nyeri[nyeri]" required> Ya&nbsp;&nbsp;&nbsp;
                        <input type="radio" value="Tidak" name="nyeri[nyeri]" checked> Tidak
                </td>
                <td style="padding: 5px;">
                  Onset: &nbsp;&nbsp;&nbsp;
                  <input type="radio" value="Akut" name="nyeri[onset]"> Akut&nbsp;&nbsp;&nbsp;
                  <input type="radio" value="Kronis" name="nyeri[onset]"> Kronis
                </td>
              </tr>
              <tr> 
                <td>Skala Nyeri: &nbsp;&nbsp;&nbsp;
                    <input type="number" value="0" name="nyeri[skala]" style="display:inline-block;width:100px;"
                      class="form-control" id="" required/>
                  </td>
                  <td>
                    Metode: &nbsp;&nbsp;&nbsp;
                  <input type="radio" value="NRS" name="nyeri[metode]"> NRS&nbsp;&nbsp;&nbsp;
                  <input type="radio" value="BPS" name="nyeri[metode]"> BPS
                  <input type="radio" value="NIPS" name="nyeri[metode]"> NIPS
                  <input type="radio" value="FLACC" name="nyeri[metode]"> FLACC
                  <input type="radio" value="VAS" name="nyeri[metode]"> VAS
                  </td>
                </tr>  
              <tr> 
                <td style="width:20%;">Pencetus :</td>
                  <td style="padding: 5px;">
                    <input type="text" name="nyeri[pencetus]" style="display:inline-block"
                      class="form-control" placeholder="[Pencetus]" required/>
                  </td>
              </tr>  
              <tr> 
                <td style="width:20%;">Gambaran :</td>
                  <td style="padding: 5px;">
                    <input type="text" name="nyeri[gambaran]" style="display:inline-block"
                      class="form-control" placeholder="[Gambaran]" required/>
                  </td>
              </tr>  
              <tr> 
                <td style="width:20%;">Durasi :</td>
                  <td style="padding: 5px;">
                    <input type="text" name="nyeri[durasi]" style="display:inline-block"
                      class="form-control" placeholder="[Durasi]" required/>
                  </td>
              </tr>  
              <tr> 
                <td style="width:20%;">Lokasi :</td>
                  <td style="padding: 5px;">
                    <input type="text" name="nyeri[lokasi]" style="display:inline-block"
                      class="form-control" placeholder="[Lokasi]" required/>
                  </td>
              </tr>  
              <tr>
                <td style="width:20%;">Quality :</td>
                  <td style="padding: 5px;">
                    <input type="text" name="nyeri[quality]" style="display:inline-block"
                      class="form-control" placeholder="[quality]" required/>
                  </td>
              </tr>
              <tr>
                <td style="width:20%;">Provokatif :</td>
                  <td style="padding: 5px;">
                    <input type="text" name="nyeri[provokatif]" style="display:inline-block"
                      class="form-control" placeholder="[Provokatif]" required/>
                  </td>
              </tr>
            </table>
        
            <h5><b>Tabel Skala Nyeri</b></h5>
            <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 580px; height: 150px; padding-bottom: 10px;">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                {{-- <td rowspan="2">TGL</td>
                <td rowspan="2">GIGI</td> --}}
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
                  <input class="form-check-input"  name="nyeri[skala_nyeri][0]" type="hidden" value="-" id="flexCheckDefault">
                  
                  <input class="form-check-input"  name="nyeri[skala_nyeri][0]" type="checkbox" value="0" id="flexCheckDefault" >
               
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][1]" type="hidden" value="-" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="nyeri[skala_nyeri][1]" type="checkbox" value="1" id="flexCheckDefault" >
                
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][2]" type="hidden" value="-" id="flexCheckDefault">
                
                  <input class="form-check-input"  name="nyeri[skala_nyeri][2]" type="checkbox" value="2" id="flexCheckDefault" >
                
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][3]" type="hidden" value="-" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="nyeri[skala_nyeri][3]" type="checkbox" value="3" id="flexCheckDefault" >
                 
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][4]" type="hidden" value="-" id="flexCheckDefault">
                  
                  <input class="form-check-input"  name="nyeri[skala_nyeri][4]" type="checkbox" value="4" id="flexCheckDefault" >
                
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][5]" type="hidden" value="-" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="nyeri[skala_nyeri][5]" type="checkbox" value="5" id="flexCheckDefault" >
               
                </td>
                <td>
                  
                  <input class="form-check-input"  name="nyeri[skala_nyeri][6]" type="hidden" value="-" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="nyeri[skala_nyeri][6]" type="checkbox" value="6" id="flexCheckDefault" >
               
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][7]" type="hidden" value="-" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="nyeri[skala_nyeri][7]" type="checkbox" value="7" id="flexCheckDefault" >
               
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][8]" type="hidden" value="-" id="flexCheckDefault">
                
                  <input class="form-check-input"  name="nyeri[skala_nyeri][8]" type="checkbox" value="8" id="flexCheckDefault" >
                 
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][9]" type="hidden" value="-" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="nyeri[skala_nyeri][9]" type="checkbox" value="9" id="flexCheckDefault" >
                 
                </td>
                <td>
                  <input class="form-check-input"  name="nyeri[skala_nyeri][10]" type="hidden" value="-" id="flexCheckDefault">
                 
                  <input class="form-check-input"  name="nyeri[skala_nyeri][10]" type="checkbox" value="10" id="flexCheckDefault" >
                 
                </td>
               
              </tr>
            </table>
            
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
                @else 
                @foreach ($riwayat as $item)
                  <tr>
                    <td rowspan="2"> <b> Nyeri</b>
                      <tr>
                        <td>
                          <b>Nyeri</b> : {{@json_decode($item->nyeri,true)['nyeri']}} |  <b>Onset	</b> : {{@json_decode($item->nyeri,true)['onset']}}<br/>
                          <b>Skala Nyeri:</b> : {{@json_decode($item->nyeri,true)['skala']}} | <b>Metode	</b> : {{@json_decode($item->nyeri,true)['metode']}}<br/>
                          <b>Pencetus	</b> : {{@json_decode($item->nyeri,true)['pencetus']}}<br/>
                          <b>Gambaran	</b> : {{@json_decode($item->nyeri,true)['gambaran']}}<br/>
                          <b>Durasi	</b> : {{@json_decode($item->nyeri,true)['durasi']}}<br/>
                          <b>Lokasi	</b> : {{@json_decode($item->nyeri,true)['lokasi']}}<br/>
                          <b>Provokatif	</b> : {{@json_decode($item->nyeri,true)['provokatif']}}<br/>
                          <b>quality	</b> : {{@json_decode($item->nyeri,true)['quality']}}<br/>
                          {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                      </tr>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="14" style="width: 100px"><b>Tabel Skala Nyeri :</b><br/>
                    
                       <tr>
                         <td>
                           <b>Skala nyeri 0 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['0']}}
                         </td>
                       </tr>
                       <tr>
                        <td>
                          <b>Skala nyeri 1 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['1']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 2 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['2']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 3 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['3']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 4 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['4']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 5 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['5']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 6 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['5']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 7 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['7']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 8 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['8']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 9 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['9']}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Skala nyeri 10 :</b>{{json_decode(@$item->nyeri,true)['skala_nyeri']['10']}}
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