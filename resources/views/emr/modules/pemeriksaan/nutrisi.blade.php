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
<h1>Pemeriksaan Umum - Nutrisi</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/nutrisi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Nutrisi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:20%;">Berat Badan(Kg)</td>
                  <td style="padding: 5px;"><input type="number" name="pemeriksaan[bb]" style="display:inline-block"
                      class="form-control" value="0"></td>
              </tr>
              <tr>
                <td style="width:20%;">Tinggi Badan(Cm)</td>
                <td style="padding: 5px;"><input type="number" name="pemeriksaan[tb]" style="display:inline-block" class="form-control" value="0"></td>
              </tr> 
               
              <tr>
                <td style="width:20%;">Index Massa Tubuh</td>
                <td style="padding: 5px;"><input type="number" name="pemeriksaan[index]" style="display:inline-block" class="form-control" value="0"></td>
              </tr> 
              <tr>
                <td style="width:20%;">Lingkar Kepala</td>
                <td style="padding: 5px;"><input type="number" name="pemeriksaan[lingkar]" style="display:inline-block" class="form-control" value="0"></td>
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
                      <b>Berat Badan (Kg):</b> {{json_decode($item->nutrisi,true)['bb']}}<br/>
                      <b>Tinggi Badan(Cm) :</b> {{json_decode($item->nutrisi,true)['tb']}}<br/>
                      <b>Index Massa Tubuh :</b> {{json_decode($item->nutrisi,true)['index']}}<br/>
                      <b>Lingkar Kepala :</b> {{json_decode($item->nutrisi,true)['lingkar']}}
                      
                    <br/> 
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
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