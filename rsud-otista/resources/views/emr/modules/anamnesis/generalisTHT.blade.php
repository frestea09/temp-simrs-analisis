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
<h1>Pemeriksaan Penunjang</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/generalisTHT/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Status Generalis</b></h5>
             <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
                <tr>
                    <td rowspan="2">Auricula Dextra - Sinistra</td>
                    <td>Cae Tenang</td>
                    <td>
                        <input type="text" required name="generalis[cae_tenang]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Sekret</td>
                    <td>
                        <input type="text" required name="generalis[sekret]" class="form-control">
                    </td>
                </tr>
          


                <tr>
                      <td rowspan="2">Membran Timpani</td>
                      <td>Intak</td>
                      <td>
                          <input type="text" required name="generalis[intak]" class="form-control">
                      </td>
                  </tr>
                  <tr>
                      <td>Reflek Cahaya</td>
                      <td>
                          <input type="text" required name="generalis[reflek_cahaya]" class="form-control">
                      </td>
                  </tr>
            
                  
                  
                

                <tr>
                    <td rowspan="4">Cavum Nasi ( CN )</td>
                    <td>Secret</td>
                    <td>
                        <input type="text" required name="generalis[secret]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Concha Inferior</td>
                    <td>
                        <input type="text" required name="generalis[concha_inferior]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Eutrofil</td>
                    <td>
                        <input type="text" required name="generalis[eutrofil]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Passase Udara</td>
                    <td>
                        <input type="text" required name="generalis[passase_udara]" class="form-control">
                    </td>
                </tr>






                
                <tr>
                    <td rowspan="3">Nasofaring / Orofaring</td>
                    <td>Tonsil</td>
                    <td>
                        <input type="text" required name="generalis[tonsil]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Detritus</td>
                    <td>
                        <input type="text" required name="generalis[detritus]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Faring</td>
                    <td>
                        <input type="text" required name="generalis[faring]" class="form-control">
                    </td>
                </tr>




                <tr>
                    <td rowspan="2">Maksilofasial</td>
                    <td>Simetris / Tidak Simetris</td>
                    <td>
                        <input type="hidden" name="generalis[simetris]" value="Tidak">
                        <input type="checkbox" name="generalis[simetris]" value="Ya">
                    </td>
                </tr>
                <tr>
                    <td>Parese Nervus Cranialis</td>
                    <td>
                        <input type="hidden" name="generalis[parese_nervus_cranialis]" value="Tidak">
                        <input type="checkbox" name="generalis[parese_nervus_cranialis]" value="Ya">
                    </td>
                </tr>


                <tr>
                    <td rowspan="2">Leher</td>
                    <td>KGB Teraba / Tidak Teraba</td>
                    <td>
                        <input type="hidden" name="generalis[kgb_teraba]" value="Tidak">
                        <input type="checkbox" name="generalis[kgb_teraba]" value="Ya">
                    </td>
                </tr>
                <tr>
                    <td>KGB Membesar / Tidak Membesar</td>
                    <td>
                        <input type="hidden" name="generalis[kgb_membesar]" value="Tidak">
                        <input type="checkbox" name="generalis[kgb_membesar]" value="Ya">
                    </td>
                </tr>


                <tr>
                    <td rowspan="1">Genitalia</td>
                    <td>
                        <input type="text" required name="generalis[genitalia]" class="form-control">
                    </td>
                </tr>

                <tr>
                    <td rowspan="1">Ektremitas</td>
                    <td>
                        <input type="text" required name="generalis[ektremitas]" class="form-control">
                    </td>
                </tr>

                <tr>
                    <td rowspan="1">Kulit</td>
                    <td>
                        <input type="text" required name="generalis[kulit]" class="form-control">
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
                @if (isset($riwayat))
                @foreach (@$riwayat as $item)

                  <tr>
                    <td>Auricula Dextra - Sinistra</td>
                    <td> 
                      <b>Cae Tenang </b>: {{json_decode(@$item->generalis,true)['cae_tenang']}}<br/>
                      <b>Sekret </b>: {{json_decode(@$item->generalis,true)['sekret']}}<br/>
                     
                    </td>
                </tr>
                <tr>
                  <td>Membran Timpani</td>
                  <td> 
                    <b>Intak </b>: {{json_decode(@$item->generalis,true)['intak']}}<br/>
                    <b>Reflek Cahaya </b>: {{json_decode(@$item->generalis,true)['reflek_cahaya']}}<br/>
                  </td>
                </tr>
                <tr>
                  <td>Cavum Nasi (CN)</td>
                  <td> 
                    <b>Secret </b>: {{json_decode(@$item->generalis,true)['secret']}}<br/>
                    <b>Concha Inferior </b>: {{json_decode(@$item->generalis,true)['concha_inferior']}}<br/>
                    <b>Eutrofil </b>: {{json_decode(@$item->generalis,true)['eutrofil']}}<br/>
                    <b>Passase Udara </b>: {{json_decode(@$item->generalis,true)['passase_udara']}}<br/>
                </td>
                </tr>
                <tr>
                  <td>Nasofaring / Orofaring</td>
                  <td> 
                    <b>Tonsil </b>: {{json_decode(@$item->generalis,true)['tonsil']}}<br/>
                    <b>Detritus </b>: {{json_decode(@$item->generalis,true)['detritus']}}<br/>
                    <b>Faring </b>: {{json_decode(@$item->generalis,true)['faring']}}<br/>
                </td>
                </tr>
                <tr>
                  <td>Maksilofasial</td>
                  <td> 
                    <b>Simetris </b>: {{json_decode(@$item->generalis,true)['simetris']}}<br/>
                    <b>Parese Nervus Cranialis </b>: {{json_decode(@$item->generalis,true)['parese_nervus_cranialis']}}<br/>
                  </td>
                </tr>
                <tr>
                  <td>Leher</td>
                  <td> 
                    <b>KGB Teraba </b>: {{json_decode(@$item->generalis,true)['kgb_teraba']}}<br/>
                    <b>KGB Membesar </b>: {{json_decode(@$item->generalis,true)['kgb_membesar']}}<br/>
                  </td>
                  </tr>
                  <tr>
                    <td>Genitalia</td>
                    <td> 
                      <b>Genitalia </b>: {{json_decode(@$item->generalis,true)['genitalia']}}<br/>
                    </td>
                  </tr>
                  <tr>
                    <td>Ektremitas</td>
                    <td> 
                      <b>Ektremitas </b>: {{json_decode(@$item->generalis,true)['ektremitas']}}<br/>
                    </td>
                  </tr>
                  <tr>
                    <td>Kulit</td>
                    <td> 
                      <b>Kulit </b>: {{json_decode(@$item->generalis,true)['kulit']}}<br/>
                    </td>
                    <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
                @endif
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