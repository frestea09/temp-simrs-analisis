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
<h1>Asesmen Anatomi THT</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/asesmenAnatomiAnak/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Asesmen Anatomi THT</b></h5>
             <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
                <tr>
                    <td style="width:20%;">Kepala Dan Leher</td>
                    <td style="padding: 5px;">
                    <textarea rows="15" name="asesmen[kepala_dan_leher]" style="display:inline-block" placeholder="[Masukkan Asesmen Kepala Dan Leher]" class="form-control" required></textarea></td>
                
                </tr>
                <tr>
                    <td rowspan="2">Dada Dan Punggung</td>
                    <td>Paru</td>
                    <td>
                        <input type="text" required name="asesmen[paru]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Jantung</td>
                    <td>
                        <input type="text" required name="asesmen[jantung]" class="form-control">
                    </td>
                </tr>

                <tr>
                    <td style="width:20%;">Perut Dan Pinggang</td>
                    <td style="padding: 5px;">
                    <textarea rows="15" name="asesmen[perut_dan_pinggang]" style="display:inline-block" placeholder="[Masukkan Asesmen Perut Dan Pinggang]" class="form-control" required></textarea></td>
                
                </tr>
                <tr>
                    <td style="width:20%;">Anggota Gerak</td>
                    <td style="padding: 5px;">
                    <textarea rows="15" name="asesmen[anggota_gerak]" style="display:inline-block" placeholder="[Masukkan Asesmen Anggota Gerak]" class="form-control" required></textarea></td>
                
                </tr>
                <tr>
                    <td style="width:20%;">Genitalia Dan Anus</td>
                    <td style="padding: 5px;">
                    <textarea rows="15" name="asesmen[genitalia_dan_anus]" style="display:inline-block" placeholder="[Masukkan Asesmen Genitalia Dan Anus]" class="form-control" required></textarea></td>
                
                </tr>
                <tr>
                    <td style="width:20%;">Pemeriksaan Neurologis</td>
                    <td style="padding: 5px;">
                    <textarea rows="15" name="asesmen[pemeriksaan_neurologis]" style="display:inline-block" placeholder="[Masukkan Asesmen Pemeriksaan Neurologis]" class="form-control" required></textarea></td>
                
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
                    <td colspan="2"><b>Kepala Dan Leher</b> : {{json_decode(@$item->asesmen,true)['kepala_dan_leher']}} <br/></td>
                </tr> 
                
                  <tr>
                    <td>Dada Dan Punggung</td>
                    <td> 
                      <b>Paru </b>: {{json_decode(@$item->asesmen,true)['paru']}}<br/>
                      <b>Jantung </b>: {{json_decode(@$item->asesmen,true)['jantung']}}<br/>
                     
                    </td>
                </tr>

                <tr> 
                    <td colspan="2"><b>Perut Dan Pinggang</b> : {{json_decode(@$item->asesmen,true)['perut_dan_pinggang']}} <br/></td>
                </tr>
                <tr> 
                    <td colspan="2"><b>Anggota Gerak</b> : {{json_decode(@$item->asesmen,true)['anggota_gerak']}} <br/></td>
                </tr>
                <tr> 
                    <td colspan="2"><b>Genitalia Dan Anus</b> : {{json_decode(@$item->asesmen,true)['genitalia_dan_anus']}} <br/></td>
                </tr>  
                <tr> 
                    <td colspan="2"><b>Pemeriksaan Neurologis</b> : {{json_decode(@$item->asesmen,true)['pemeriksaan_neurologis']}} <br/></td>
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