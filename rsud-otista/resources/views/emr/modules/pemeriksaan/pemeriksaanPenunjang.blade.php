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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/penunjangInap/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Pemeriksaan Penunjang</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
                <tr>
                    <td rowspan="5">Hematologi Rutin</td>
                    <td>Leukosit</td>
                    <td>
                        <input type="text" name="pemeriksaanpenunjang[leukosit]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Hemogoblin</td>
                    <td>
                        <input type="text" name="pemeriksaanpenunjang[hemogoblin]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Hematokrit</td>
                    <td>
                        <input type="text" name="pemeriksaanpenunjang[hematokrit]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Trombosit</td>
                    <td>
                        <input type="text" name="pemeriksaanpenunjang[trombosit]" class="form-control">
                    </td>
                </tr>
                <tr>
                  <td>Lainnya</td>
                  <td>
                      <input type="text" name="pemeriksaanpenunjang[lainnya_HR]" class="form-control">
                  </td>
              </tr>
          



              <tr>
                <td rowspan="2">Glukosa Strip</td>
                <td>Glukosa Sewaktu</td>
                <td>
                    <input type="text" name="pemeriksaanpenunjang[glukosa_sewaktu]" class="form-control">
                </td>
                <tr>
                  <td>Lainnya</td>
                  <td>
                    <input type="text" name="pemeriksaanpenunjang[lainnya_GS]" class="form-control">
                </td>
                </tr>
              </tr>

               <tr>
                  <td rowspan="2">Golongan Darah</td>
                  <td>GOL DARAH</td>
                  <td>
                      <input type="text" name="pemeriksaanpenunjang[golongan_darah]" class="form-control">
                  </td>
                  <tr>
                    <td>Lainnya</td>
                    <td>
                      <input type="text" name="pemeriksaanpenunjang[lainnya_GD]" class="form-control">
                  </td>
                  </tr>
               </tr>

               <tr>
                  <td rowspan="2">Rhesus</td>
                  <td>GOL RHESUS</td>
                  <td>
                      <input type="text" name="pemeriksaanpenunjang[golongan_rhesus]" class="form-control">
                  </td>
                  <tr>
                    <td>Lainnya</td>
                    <td>
                      <input type="text" name="pemeriksaanpenunjang[lainnya_GR]" class="form-control">
                  </td>
                  </tr>
              </tr>


              <tr>
                <td rowspan="2">Bilirubin Direct</td>
                <td>Bilirubin Direct</td>
                <td>
                    <input type="text" name="pemeriksaanpenunjang[bilirubin_direct]" class="form-control">
                </td>
                <tr>
                  <td>Lainnya</td>
                  <td>
                    <input type="text" name="pemeriksaanpenunjang[lainnya_BD]" class="form-control">
                </td>
                </tr>
              </tr>

              <tr>
                <td rowspan="2">Bilirubin Total</td>
                <td>Bilirubin Total</td>
                <td>
                    <input type="text" name="pemeriksaanpenunjang[bilirubin_total]" class="form-control">
                </td>
                <tr>
                  <td>Lainnya</td>
                  <td>
                    <input type="text" name="pemeriksaanpenunjang[lainnya_BT]" class="form-control">
                </td>
                </tr>
              </tr>


              <tr>
                <td rowspan="4">Natrium Kalium</td>
                <td>Natrium</td>
                <td>
                    <input type="text" name="pemeriksaanpenunjang[natrium]" class="form-control">
                </td>
                <tr>
                  <td>Kalium</td>
                  <td>
                    <input type="text" name="pemeriksaanpenunjang[kalium]" class="form-control">
                </td>
                </tr>
                <tr>
                  <td>Klorida</td>
                  <td>
                    <input type="text" name="pemeriksaanpenunjang[klorida]" class="form-control">
                </td>
                </tr>
                <tr>
                  <td>Lainnya</td>
                  <td>
                    <input type="text" name="pemeriksaanpenunjang[lainya_NK]" class="form-control">
                </td>
                </tr>
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
                    <td>Hematologi Rutin</td>
                    <td> 
                      <b>Leukosit :</b> {{json_decode(@$item->pemeriksaandalam,true)['leukosit']}}<br/>
                      <b>Hemogoblin :</b> {{json_decode(@$item->pemeriksaandalam,true)['hemogoblin']}}<br/>
                      <b>Hematokrit :</b> {{json_decode(@$item->pemeriksaandalam,true)['hematokrit']}}<br/>
                      <b>Trombosit :</b> {{json_decode(@$item->pemeriksaandalam,true)['trombosit']}}
                      <b>Lainya :</b> {{json_decode(@$item->pemeriksaandalam,true)['lainnya_HR']}}<br/>
                     
                    </td>
                </tr>
                <tr>
                  <td>Glukosa Strip</td>
                  <td> 
                    <b>Glukosa Sewaktu :</b> {{json_decode(@$item->pemeriksaandalam,true)['glukosa_sewaktu']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->pemeriksaandalam,true)['lainnya_GS']}}<br/>
                  </td>
                </tr>
                <tr>
                  <td>Golongan Darah</td>
                  <td> 
                    <b>Golongan Darah :</b> {{json_decode(@$item->pemeriksaandalam,true)['golongan_darah']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->pemeriksaandalam,true)['lainnya_GD']}}<br/>
                  </td>
                </tr>
                <tr>
                  <td>Rhesus</td>
                  <td> 
                    <b>Golongan Rhesus :</b> {{json_decode(@$item->pemeriksaandalam,true)['golongan_rhesus']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->pemeriksaandalam,true)['lainnya_GR']}}<br/>
                  </td>
                </tr>
                <tr>
                  <td>Billirubin Direct</td>
                  <td> 
                    <b>Billirubin Direct :</b> {{json_decode(@$item->pemeriksaandalam,true)['bilirubin_direct']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->pemeriksaandalam,true)['lainnya_BD']}}<br/>
                  </td>
                </tr>
                <tr>
                  <td>Billirubin Total</td>
                  <td> 
                    <b>Billirubin Total :</b> {{json_decode(@$item->pemeriksaandalam,true)['bilirubin_total']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->pemeriksaandalam,true)['lainnya_BT']}}<br/>
                  </td>
                </tr>
                <tr>
                  <td>Natrium Kalium</td>
                  <td> 
                    <b>Natrium :</b> {{json_decode(@$item->pemeriksaandalam,true)['natrium']}}<br/>
                    <b>Kalium :</b> {{json_decode(@$item->pemeriksaandalam,true)['kalium']}}<br/>
                    <b>Klorida :</b> {{json_decode(@$item->pemeriksaandalam,true)['klorida']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->pemeriksaandalam,true)['lainya_NK']}}<br/>
                  </td>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
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