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
<h1>Anamnesis - Status Fungsional</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/statusfungsional/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Status Fungsional</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:20%;" rowspan="7">Fungsional</td>
                <tr>
                <td style="padding: 5px;">
                  <input type="checkbox" value="Alat Bantu" name="alatbantu[data][]">Alat Bantu
                </td>
                </tr>
                <tr>
                <td>
                  <input type="checkbox" value="Prothesis" name="alatbantu[data][]">Prothesis
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" value="Cacat Tubuh" name="alatbantu[data][]">Cacat Tubuhs
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" value="ADL Mandiri" name="alatbantu[data][]">ADL Mandiri
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" value="ADL Di Bantu" name="alatbantu[data][]">ADL Di Bantu
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" value="Riwayat Jatuh 3 bulan terakhir" name="alatbantu[data][]">Riwayat Jatuh 3 bulan terakhir
                </td>
                <td>
                </tr>

                </td>
              <td style="width:20%;">Risiko Cidera / Jatuh :</td>
                <td style="padding: 5px;">
              
                  <input type="checkbox" value="Tidak" name="cidera[data][]"> Tidak
                  <input type="checkbox" value="Ya" name="cidera[data][]"> Ya
                  <textarea name="cidera[lainnya]" style="display:inline-block"
                    class="form-control" id="" required></textarea>
                </td>
              </tr> 
            </table>
          </div>
{{-- 
          @php
              dd($riwayat)
          @endphp --}}


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
                @foreach (@$riwayat as $item)
                  <tr>
                    <td> <b>Fungsional</b> :
                      @if (isset(json_decode(@$item->penggunaan_alat_bantu,true)['data']))    
                        @foreach (json_decode(@$item->penggunaan_alat_bantu,true)['data'] as $key=>$alat)
                            {{@$alat}},
                        @endforeach
                      @endif
                    
                  </tr>
                  <tr>
                    <td> <b>cidera</b> :
                      @if (isset(json_decode($item->cacat_tubuh,true)['data']))
                      @foreach (json_decode($item->cacat_tubuh,true)['data'] as $key=>$alat)
                          {{$alat}},
                      @endforeach
                      @endif
                   
                      {{-- @foreach (json_decode($item->penggunaan_alat_bantu as $p))
                      @endforeach
                    <br/> 
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                      <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/anamnesis/statusfungsional/'.$unit.'/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                        {{-- <a href="{{url('emr-soap-rawatinap/anamnesis/statusfungsional/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp; --}}
                      </span>
                    </td>
                    <tr>
                    <td>
                      <b>Lainnya:</b> {{json_decode($item->cacat_tubuh,true)['lainnya']}}
                    </td>
                  </tr>
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