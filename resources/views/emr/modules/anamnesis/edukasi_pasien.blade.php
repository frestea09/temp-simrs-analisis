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
<h1>Anamnesis - Edukasi Pasien & Keluarga</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/edukasipasienkeluarga/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Edukasi Pasien & Keluarga</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:50%;">Kesediaan pasien/keluarga menerima informasi</td>
                <td style="padding: 5px;">
                  <input type="radio" value="Ya" name="edukasipasien[menerima]"> Ya&nbsp;&nbsp;&nbsp;
                  <input type="radio" value="Tidak" name="edukasipasien[menerima]" checked> Tidak
                </td>
              </tr>
              <tr>
                <td style="width:50%;">Terdapat hambatan dalam edukasi</td>
                <td style="padding: 5px;">
                  <input type="radio" value="Ya" name="edukasipasien[hambatan]"> Ya&nbsp;&nbsp;&nbsp;
                  <input type="radio" value="Tidak" name="edukasipasien[hambatan]" checked> Tidak
                </td>
              </tr>
              <tr> 
                <td style="width:20%;">Dibutuhkan penerjemah :</td>
                  <td style="padding: 5px;">
                    <input type="radio" value="Ya" name="edukasipasien[penerjemah]"> Ya&nbsp;&nbsp;&nbsp;
                    <input type="radio" value="Tidak" name="edukasipasien[penerjemah]" checked> Tidak
                  </td>
                </tr> 
              <tr> 
                <td colspan="2" style="width:20%;">Kebutuhan Edukasi :<br/>
                {{-- <td style="padding: 5px;">? --}}
                  <input type="checkbox" value="Diagnosa Penyakit" name="edukasipasien[edukasi][]"> Diagnosa Penyakit&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" value="Obat-obatan" name="edukasipasien[edukasi][]"> Obat-obatan&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" value="Diet & Nutrisi" name="edukasipasien[edukasi][]"> Diet & Nutrisi&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" value="Rehabilitasi Medik" name="edukasipasien[edukasi][]"> Rehabilitasi Medik&nbsp;&nbsp;&nbsp;
                  <br/>
                  <input type="checkbox" value="Manajemen Nyeri" name="edukasipasien[edukasi][]"> Manajemen Nyeri&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" value="Penggunaan alat medis" name="edukasipasien[edukasi][]"> Penggunaan alat medis&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" value="Hak dan kewajiban pasien" name="edukasipasien[edukasi][]"> Hak dan kewajiban pasien&nbsp;&nbsp;&nbsp;
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
                    <b>Kesediaan pasien/keluarga menerima informasi	</b> : {{json_decode($item->edukasi_pasien,true)['menerima']}}<br/>
                    <b>Terdapat hambatan dalam edukasi		</b> : {{json_decode($item->edukasi_pasien,true)['hambatan']}}<br/>
                    <b>Dibutuhkan penerjemah	</b> : {{json_decode($item->edukasi_pasien,true)['penerjemah']}}<br/>
                    <b>Kondisi Sosial</b> :
                      @if (isset(json_decode($item->edukasi_pasien,true)['edukasi']))    
                        @foreach (json_decode($item->edukasi_pasien,true)['edukasi'] as $key=>$b)
                            {{$b}},
                        @endforeach<br/>
                      @endif
                    {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                    <span class="pull-right">
                      <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/anamnesis/edukasipasienkeluarga/'.$unit.'/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
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