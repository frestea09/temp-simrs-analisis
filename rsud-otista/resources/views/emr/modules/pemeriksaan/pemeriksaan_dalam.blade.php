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
<h1>Pemeriksaan Fsik Dalam</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/fisikdalam/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Pemeriksaan Dalam</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
                <tr>
                    <td rowspan="6">Pemeriksaan Dalam</td>
                    <td>Vulva Vagina</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[vulva]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Por o</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[poro]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Ketuban</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[ketuban]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Pembukaan</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[pembukaan]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Persentase Fetus</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[fetus]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Hodge/Sta on</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[hodge]" class="form-control">
                    </td>
                </tr>
            </table>


            <h5><b>Pemeriksaan Penunjang</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
                <tr>
                    <td rowspan="6">Pemeriksaan Penunjang</td>
                    <td>Darah Hb</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[hb]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Protein Urine</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[protein]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>USG</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[usg]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Ht</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[ht]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Glukosa</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[glukosa]" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>CTG</td>
                    <td>
                        <input type="text" name="pemeriksaandalam[ctg]" class="form-control">
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
                    <td>Pemeriksaan Dalam</td>
                    <td> 
                      <b>Vulva Vagina :</b> {{json_decode(@$item->pemeriksaandalam,true)['vulva']}}<br/>
                      <b>Por o :</b> {{json_decode(@$item->pemeriksaandalam,true)['poro']}}<br/>
                      <b>Ketuban :</b> {{json_decode(@$item->pemeriksaandalam,true)['ketuban']}}<br/>
                      <b>Pembukaan :</b> {{json_decode(@$item->pemeriksaandalam,true)['pembukaan']}}
                      <b>Persentase Fetus :</b> {{json_decode(@$item->pemeriksaandalam,true)['fetus']}}<br/>
                      <b>Hodge / Sta on :</b> {{json_decode(@$item->pemeriksaandalam,true)['hodge']}}
                    </td>
                 </tr>
                 <tr>
                    <td>Pemeriksaan Penunjang</td>
                    <td> 
                      <b>Darah Hb :</b> {{json_decode(@$item->pemeriksaandalam,true)['hb']}}<br/>
                      <b>Protein Urine :</b> {{json_decode(@$item->pemeriksaandalam,true)['protein']}}<br/>
                      <b>USG :</b> {{json_decode(@$item->pemeriksaandalam,true)['usg']}}<br/>
                      <b>Ht :</b> {{json_decode(@$item->pemeriksaandalam,true)['ht']}}
                      <b>Glukosa :</b> {{json_decode(@$item->pemeriksaandalam,true)['glukosa']}}<br/>
                      <b>CTG :</b> {{json_decode(@$item->pemeriksaandalam,true)['ctg']}}  
                    <br/> 
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
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