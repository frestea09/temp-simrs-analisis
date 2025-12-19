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
<h1>Anamnesis - Permasalahan Gizi</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/permasalahangizi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Permasalahan Gizi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:50%;">Adakah Perubahan berat badan signifikan dalam 3 bulan terakhir</td>
                <td style="padding: 5px;">
                  <input type="radio" value="Ya" name="permasalahan_gizi[perubahan_berat]"> Ya(1)&nbsp;&nbsp;&nbsp;
                  <input type="radio" value="Tidak" name="permasalahan_gizi[perubahan_berat]" checked> Tidak(0)
                </td>
              </tr>
              <tr>
                <td style="width:50%;">Intake makanan kurang karena tidak ada nafsu makan</td>
                <td style="padding: 5px;">
                  <input type="radio" value="Ya" name="permasalahan_gizi[nafsu_makan]"> Ya(1)&nbsp;&nbsp;&nbsp;
                  <input type="radio" value="Tidak" name="permasalahan_gizi[nafsu_makan]" checked> Tidak(0)
                </td>
              </tr>
              <tr> 
                <td style="width:20%;">Kondisi Khusus :</td>
                  <td style="padding: 5px;">
                    <input type="text" name="permasalahan_gizi[kondisi_khusus]" style="display:inline-block"
                      class="form-control" id=""/>
                  </td>
                </tr> 
              <tr> 
                <td style="width:20%;">Skor :</td>
                  <td style="padding: 5px;">
                    <input type="number" value="0" name="permasalahan_gizi[skor]" style="display:inline-block"
                      class="form-control" id=""/>
                  </td>
                </tr> 
                <tr>
                  <td style="width:50%;">Jika Skor diatas 2</td>
                  <td style="padding: 5px;">
                    <input type="radio" value="Ya" name="permasalahan_gizi[status_skor]"> Ya(1)&nbsp;&nbsp;&nbsp;
                    <input type="radio" value="Tidak" name="permasalahan_gizi[status_skor]" checked> Tidak(0)
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
                @endif
                @foreach ($riwayat as $item)
                  <tr>
                    <td>
                      <b>Adakah Perubahan berat badan signifikan dalam 3 bulan terakhir</b> : {{json_decode($item->permasalahan_gizi,true)['perubahan_berat']}}<br/>
                      <b>Intake makanan kurang karena tidak ada nafsu makan	</b> : {{json_decode($item->permasalahan_gizi,true)['nafsu_makan']}}<br/>
                      <b>Kondisi Khusus	</b> : {{json_decode($item->permasalahan_gizi,true)['kondisi_khusus']}}<br/>
                      <b>Skor	</b> : {{json_decode($item->permasalahan_gizi,true)['skor']}}<br/>
                      <b>Jika Skor diatas 2	</b> : {{json_decode($item->permasalahan_gizi,true)['status_skor']}}<br/>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                      <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/anamnesis/permasalahangizi/'.$unit.'/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                        {{-- <a href="{{url('emr-soap-rawatinap/anamnesis/statusfungsional/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp; --}}
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