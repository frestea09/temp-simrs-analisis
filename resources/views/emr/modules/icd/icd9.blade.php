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
<h1>ICD 9</h1>
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
    <form method="POST" action="{{ url('emr-soap-icd/icd9/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
          <div class="col-md-12">
            <h5><b>ICD 9</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              
              <tr>
                <td style="width:20%;">Kode</td>
                <td style="padding: 5px;">
                  <select name="diagnosa_awal[]" id="select2Multiple" class="form-control" multiple="multiple">
                    
                      
                </td>
              </tr>
              <tr>
                  <td style="padding: 5px;" colspan="2">
                    <textarea rows="15" name="diagnosis" style="display:inline-block" placeholder="[Masukkan Diagnosa Dokter]" class="form-control" required></textarea></td>
                  </td>
              </tr>
               
            </table>
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
                @endif
                @foreach ($riwayat as $item)
                  <tr>
                    <td> 
                      <b>Kode ICD (10)	:</b> {{$item->icd10}}<br/>
                      <b>Deskripsi	:</b> {{baca_icd10($item->icd10)}}<br/>
                      <b>Diagnosa	:</b> {{$item->diagnosis}}<br/>
                      <b>Kategori	:</b> {{$item->kategori}}<br/>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
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
    <br/>
    <br/>
    <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;" id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            {{-- <th>Kategori</th> --}}
            <th>Tanggal</th>
            <th>Hapus</th>
           
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                {{-- <td>{{$item->kategori}}</td> --}}
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                <td>
                  <form method="POST" action="{{ url('emr-soap-icd/icd9/'.$item->id) }}" class="form-horizontal">
                    {{ csrf_field() }}
                  <button type="submit" onclick="return confirm('Yakin akan Menghapus Data?')" class="btn btn-danger btn-xs">Hapus</button>
                </form>
                </td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div>

    <div class="modal fade" id="ICD10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Add</th>
                  </tr>
                </thead>
  
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
 //ICD 10
 $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama kode",
      width: '100%',
      ajax: {
          url: '/penjualan/kode/icd-9',
          dataType: 'json',
          data: function (params) {
              return {
                  j: 1,
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })
         
  </script>
  @endsection